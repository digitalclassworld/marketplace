<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseEnrollment;
use App\Models\ElearnCourse;
use App\Models\Order;
use App\Models\StudentCourseProgress;
use App\Models\StudentLectureNote;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CustomerCourseController extends Controller
{
    /**
     * Display the Student Learning Dashboard ("My Courses").
     */
    public function myCourses(Request $request): View|RedirectResponse
    {
        $user = Auth::guard('web')->user();
        if (!$user) {
            return redirect()->route('customer.login')->with('warning', 'Please login to access your enrolled courses.');
        }

        // 1. Auto-sync any purchases from the Orders table into CourseEnrollment
        $this->syncPurchasedOrders($user);

        // 2. Fetch all enrollments for this user
        $enrollments = CourseEnrollment::where('user_id', $user->id)
            ->latest('updated_at')
            ->get();

        // Attach course details & lesson counts
        $enrolledItems = collect();
        $totalLecturesFinishedAll = 0;
        $totalLecturesCountAll = 0;

        foreach ($enrollments as $enrollment) {
            $course = null;
            $allLessons = collect();
            $chapters = collect();

            if ($enrollment->course_type === 'catalog') {
                $course = Course::find($enrollment->course_id);
                if ($course) {
                    $allLessons = $course->contents;
                    $chapters = $course->contents->groupBy('section_title');
                }
            } else {
                $course = ElearnCourse::find($enrollment->course_id);
                if ($course) {
                    $allLessons = $course->getAllLessons();
                    $chapters = $course->getVideoChapters();
                }
            }

            if (!$course) {
                continue;
            }

            $totalLessons = $allLessons->count();
            $totalLecturesCountAll += $totalLessons;

            // Completed lessons count
            $completedLessonIds = StudentCourseProgress::where('user_id', $user->id)
                ->where('course_id', $enrollment->course_id)
                ->where('completed', true)
                ->pluck('lesson_id')
                ->toArray();

            $completedLessonsCount = count($completedLessonIds);
            $totalLecturesFinishedAll += $completedLessonsCount;

            // Progress percentage
            $progressPercent = $totalLessons > 0 ? (int) round(($completedLessonsCount / $totalLessons) * 100) : $enrollment->progress_percent;
            if ($progressPercent > 100) $progressPercent = 100;

            // Resolve last watched or next up lesson
            $nextUpLesson = null;
            if ($enrollment->last_watched_lesson_id) {
                $nextUpLesson = $allLessons->firstWhere('id', (int)$enrollment->last_watched_lesson_id);
            }
            if (!$nextUpLesson && $allLessons->isNotEmpty()) {
                // Find first uncompleted lesson
                $nextUpLesson = $allLessons->first(function($l) use ($completedLessonIds) {
                    return !in_array($l->id, $completedLessonIds);
                }) ?: $allLessons->first();
            }

            $enrolledItems->push((object)[
                'enrollment'             => $enrollment,
                'course'                 => $course,
                'course_id'              => $enrollment->course_id,
                'course_type'            => $enrollment->course_type,
                'title'                  => $course->title ?? $course->course_name,
                'instructor'             => $course->instructor_name ?? 'Digital Class Instructor',
                'thumbnail'              => $course->thumbnail ?? $course->thumbnail_url,
                'category'               => $course->category ?? 'E-Learning',
                'total_lessons'          => $totalLessons,
                'completed_lessons'      => $completedLessonsCount,
                'progress_percent'       => $progressPercent,
                'is_completed'           => $progressPercent >= 100,
                'last_watched_lesson_id' => $enrollment->last_watched_lesson_id,
                'next_up_lesson'         => $nextUpLesson,
                'chapters'               => $chapters,
                'all_lessons'            => $allLessons,
                'updated_at'             => $enrollment->updated_at ?? $enrollment->created_at,
            ]);
        }

        // Hero Course (most recently active course to quick-resume)
        $heroCourse = $enrolledItems->first(fn($i) => $i->progress_percent < 100) ?: $enrolledItems->first();

        // Search filtering
        $search = trim((string)$request->get('search', ''));
        if ($search !== '') {
            $enrolledItems = $enrolledItems->filter(function($item) use ($search) {
                return str_contains(strtolower($item->title), strtolower($search)) ||
                       str_contains(strtolower($item->instructor), strtolower($search)) ||
                       str_contains(strtolower($item->category), strtolower($search));
            });
        }

        // Filter tab
        $tab = $request->get('tab', 'all');
        if ($tab === 'in_progress') {
            $filteredItems = $enrolledItems->filter(fn($item) => $item->progress_percent < 100);
        } elseif ($tab === 'completed') {
            $filteredItems = $enrolledItems->filter(fn($item) => $item->progress_percent >= 100);
        } else {
            $filteredItems = $enrolledItems;
        }

        // Sorting
        $sort = $request->get('sort', 'recent');
        if ($sort === 'progress_high') {
            $filteredItems = $filteredItems->sortByDesc('progress_percent')->values();
        } elseif ($sort === 'progress_low') {
            $filteredItems = $filteredItems->sortBy('progress_percent')->values();
        } elseif ($sort === 'title') {
            $filteredItems = $filteredItems->sortBy('title', SORT_NATURAL|SORT_FLAG_CASE)->values();
        } else {
            $filteredItems = $filteredItems->sortByDesc('updated_at')->values();
        }

        // Student Overview Statistics
        $stats = [
            'total_enrolled'           => $enrollments->count(),
            'in_progress'              => $enrolledItems->where('progress_percent', '<', 100)->count(),
            'completed'                => $enrolledItems->where('progress_percent', '>=', 100)->count(),
            'total_lectures_finished'  => $totalLecturesFinishedAll,
            'total_lectures_count'     => $totalLecturesCountAll,
            'certificates_count'       => $enrolledItems->where('progress_percent', '>=', 100)->count(),
            'average_progress'         => $enrolledItems->isNotEmpty() ? (int)round($enrolledItems->avg('progress_percent')) : 0,
        ];

        // Featured/recommended courses if the student wants to explore more
        $recommendedCourses = collect();
        if (\Illuminate\Support\Facades\Schema::hasTable('dc_elearn_course')) {
            $recommendedCourses = ElearnCourse::where('is_featured', 1)
                ->orWhere('is_trending', 1)
                ->latest('id')
                ->take(4)
                ->get();
        } elseif (\Illuminate\Support\Facades\Schema::hasTable('courses')) {
            $recommendedCourses = Course::latest('id')->take(4)->get();
        }

        return view('customer.my-courses', [
            'user'               => $user,
            'enrolledItems'      => $filteredItems,
            'heroCourse'         => $heroCourse,
            'stats'              => $stats,
            'allCount'           => $enrolledItems->count(),
            'inProgressCount'    => $enrolledItems->where('progress_percent', '<', 100)->count(),
            'completedCount'     => $enrolledItems->where('progress_percent', '>=', 100)->count(),
            'currentTab'         => $tab,
            'currentSort'        => $sort,
            'search'             => $search,
            'recommendedCourses' => $recommendedCourses,
        ]);
    }

    /**
     * Interactive Video Classroom & Course Player.
     */
    public function player(Request $request, $courseId, $lessonId = null): View|RedirectResponse
    {
        $user = Auth::guard('web')->user();
        if (!$user) {
            return redirect()->route('customer.login')->with('warning', 'Please login to view course lectures.');
        }

        // 1. Resolve Course
        $course = null;
        $courseType = 'catalog';

        if (\Illuminate\Support\Facades\Schema::hasTable('dc_elearn_course')) {
            $course = ElearnCourse::find($courseId);
            if ($course) $courseType = 'elearn';
        }

        if (!$course && \Illuminate\Support\Facades\Schema::hasTable('courses')) {
            $course = Course::find($courseId);
            $courseType = 'catalog';
        }

        if (!$course) {
            return redirect()->route('customer.my-courses')->with('error', 'Course not found.');
        }

        // 2. Ensure User is Enrolled (auto-enroll if bought, demo, or free)
        $enrollment = CourseEnrollment::firstOrCreate(
            [
                'user_id'     => $user->id,
                'course_id'   => $course->id,
                'course_type' => $courseType,
            ],
            [
                'enrolled_at'      => now(),
                'status'           => 'active',
                'progress_percent' => 0,
            ]
        );

        // 3. Retrieve Chapters and Video Lessons
        $chapters = collect();
        $allLessons = collect();

        if ($courseType === 'elearn') {
            $chapters = $course->getVideoChapters();
            $allLessons = $course->getAllLessons();
        } else {
            // Modern catalog course
            $contents = $course->contents;
            $grouped = $contents->groupBy('section_title');
            $chNo = 1;
            foreach ($grouped as $secTitle => $lectures) {
                $ch = (object)[
                    'id'           => $chNo,
                    'chapter_no'   => sprintf('%02d', $chNo),
                    'chapter_name' => $secTitle ?: "Module {$chNo}",
                    'lessons'      => $lectures->map(function($lec) use ($chNo) {
                        return (object)[
                            'id'                 => $lec->id,
                            'lesson_no'          => $lec->sort_order ?: $lec->id,
                            'lesson_name'        => $lec->lecture_title,
                            'duration'           => $lec->duration ?: '15:00',
                            'video_link'         => $lec->video_url,
                            'course_description' => '',
                            'chapter_name'       => $lec->section_title ?: "Module {$chNo}",
                        ];
                    }),
                ];
                $chapters->push($ch);
                foreach ($ch->lessons as $l) {
                    $allLessons->push($l);
                }
                $chNo++;
            }
        }

        // If course has no chapters or lessons in DB, create an introductory syllabus
        if ($allLessons->isEmpty()) {
            $fallbackLesson = (object)[
                'id'                 => 999990,
                'lesson_no'          => 1,
                'lesson_name'        => 'Introduction to ' . ($course->title ?? $course->course_name),
                'duration'           => '15:00',
                'video_link'         => $course->course_demo_video_url ?? 'https://www.youtube.com/watch?v=eIrMbAQSU34',
                'course_description' => 'Welcome to the course! Get an overview of all modules, course syllabus, and required learning tools.',
                'chapter_name'       => 'Module 1: Orientation & Fundamentals',
            ];
            $fallbackChapter = (object)[
                'id'           => 1,
                'chapter_no'   => '01',
                'chapter_name' => 'Module 1: Orientation & Fundamentals',
                'lessons'      => collect([$fallbackLesson]),
            ];
            $chapters = collect([$fallbackChapter]);
            $allLessons = collect([$fallbackLesson]);
        }

        // 4. Resolve Active Lesson
        $currentLesson = null;
        if ($lessonId) {
            $currentLesson = $allLessons->firstWhere('id', (int)$lessonId);
        }

        if (!$currentLesson && $enrollment->last_watched_lesson_id) {
            $currentLesson = $allLessons->firstWhere('id', (int)$enrollment->last_watched_lesson_id);
        }

        if (!$currentLesson) {
            $currentLesson = $allLessons->first();
        }

        // Update last watched lesson on enrollment
        if ($currentLesson) {
            $enrollment->update(['last_watched_lesson_id' => $currentLesson->id]);
        }

        // 5. Find Next and Previous Lessons for seamless navigation
        $currentIdx = $allLessons->search(fn($l) => $l->id == $currentLesson->id);
        $prevLesson = ($currentIdx !== false && $currentIdx > 0) ? $allLessons->get($currentIdx - 1) : null;
        $nextLesson = ($currentIdx !== false && $currentIdx < $allLessons->count() - 1) ? $allLessons->get($currentIdx + 1) : null;

        // 6. User Progress Details
        $completedLessonIds = StudentCourseProgress::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->where('completed', true)
            ->pluck('lesson_id')
            ->toArray();

        $completedCount = count($completedLessonIds);
        $totalLessons = $allLessons->count();
        $progressPercent = $totalLessons > 0 ? (int) round(($completedCount / $totalLessons) * 100) : 0;
        if ($progressPercent > 100) $progressPercent = 100;

        // 7. Student Notes for this lesson and all saved course notes
        $currentNote = StudentLectureNote::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->where('lesson_id', $currentLesson ? $currentLesson->id : 0)
            ->first();

        $allCourseNotes = StudentLectureNote::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->latest('updated_at')
            ->get();

        // 8. Format Embed Video Stream URL
        $embedVideoUrl = $this->formatEmbedUrl($currentLesson ? $currentLesson->video_link : null);

        return view('customer.learning-player', [
            'user'               => $user,
            'course'             => $course,
            'courseType'         => $courseType,
            'chapters'           => $chapters,
            'allLessons'         => $allLessons,
            'currentLesson'      => $currentLesson,
            'prevLesson'         => $prevLesson,
            'nextLesson'         => $nextLesson,
            'completedLessonIds' => $completedLessonIds,
            'isCurrentCompleted' => $currentLesson && in_array($currentLesson->id, $completedLessonIds),
            'completedCount'     => $completedCount,
            'totalLessons'       => $totalLessons,
            'progressPercent'    => $progressPercent,
            'currentNote'        => $currentNote,
            'allCourseNotes'     => $allCourseNotes,
            'embedVideoUrl'      => $embedVideoUrl,
        ]);
    }

    /**
     * AJAX action to toggle lesson completion status.
     */
    public function toggleLesson(Request $request, $courseId, $lessonId): JsonResponse
    {
        $user = Auth::guard('web')->user();
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }

        $course = null;
        $courseType = 'catalog';
        if (\Illuminate\Support\Facades\Schema::hasTable('dc_elearn_course')) {
            $course = ElearnCourse::find($courseId);
            if ($course) $courseType = 'elearn';
        }
        if (!$course && \Illuminate\Support\Facades\Schema::hasTable('courses')) {
            $course = Course::find($courseId);
            $courseType = 'catalog';
        }

        if (!$course) {
            return response()->json(['success' => false, 'message' => 'Course not found'], 404);
        }

        $progressRecord = StudentCourseProgress::where('user_id', $user->id)
            ->where('course_id', $courseId)
            ->where('lesson_id', $lessonId)
            ->first();

        if ($progressRecord) {
            $newState = !$progressRecord->completed;
            $progressRecord->completed = $newState;
            $progressRecord->completed_at = $newState ? now() : null;
            $progressRecord->save();
        } else {
            $newState = true;
            StudentCourseProgress::create([
                'user_id'      => $user->id,
                'course_id'    => $courseId,
                'lesson_id'    => $lessonId,
                'completed'    => true,
                'completed_at' => now(),
            ]);
        }

        // Calculate total lessons
        $allLessons = ($courseType === 'elearn') ? $course->getAllLessons() : $course->contents;
        $totalCount = $allLessons->count() ?: 1;

        $completedCount = StudentCourseProgress::where('user_id', $user->id)
            ->where('course_id', $courseId)
            ->where('completed', true)
            ->count();

        $progressPercent = min(100, (int) round(($completedCount / $totalCount) * 100));

        // Update enrollment
        $enrollment = CourseEnrollment::where('user_id', $user->id)
            ->where('course_id', $courseId)
            ->first();

        if ($enrollment) {
            $enrollment->progress_percent = $progressPercent;
            $enrollment->last_watched_lesson_id = $lessonId;
            if ($progressPercent >= 100 && !$enrollment->completed_at) {
                $enrollment->completed_at = now();
                $enrollment->status = 'completed';
            }
            $enrollment->save();
        }

        // Find next lesson id
        $currentIdx = $allLessons->search(fn($l) => $l->id == $lessonId);
        $nextLesson = ($currentIdx !== false && $currentIdx < $allLessons->count() - 1) ? $allLessons->get($currentIdx + 1) : null;

        return response()->json([
            'success'          => true,
            'completed'        => $newState,
            'progress_percent' => $progressPercent,
            'completed_count'  => $completedCount,
            'total_count'      => $totalCount,
            'next_lesson_id'   => $nextLesson ? $nextLesson->id : null,
            'is_finished'      => $progressPercent >= 100,
        ]);
    }

    /**
     * Save student personal study notes for the active lecture.
     */
    public function saveNote(Request $request, $courseId, $lessonId): JsonResponse
    {
        $user = Auth::guard('web')->user();
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }

        $noteText = trim((string)$request->input('note'));

        $note = StudentLectureNote::updateOrCreate(
            [
                'user_id'   => $user->id,
                'course_id' => $courseId,
                'lesson_id' => $lessonId,
            ],
            [
                'note'              => $noteText,
                'timestamp_seconds' => (int) $request->input('timestamp', 0),
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Note saved successfully!',
            'note'    => $note->note,
        ]);
    }

    /**
     * One-click enroll in free course.
     */
    public function enrollFree(Request $request, $courseId): RedirectResponse
    {
        $user = Auth::guard('web')->user();
        if (!$user) {
            return redirect()->route('customer.login')->with('warning', 'Please login to enroll in this course.');
        }

        $course = null;
        $courseType = 'catalog';
        if (\Illuminate\Support\Facades\Schema::hasTable('dc_elearn_course')) {
            $course = ElearnCourse::find($courseId);
            if ($course) $courseType = 'elearn';
        }
        if (!$course && \Illuminate\Support\Facades\Schema::hasTable('courses')) {
            $course = Course::find($courseId);
            $courseType = 'catalog';
        }

        if (!$course) {
            return redirect()->back()->with('error', 'Course not found.');
        }

        CourseEnrollment::firstOrCreate(
            [
                'user_id'     => $user->id,
                'course_id'   => $course->id,
                'course_type' => $courseType,
            ],
            [
                'enrolled_at'      => now(),
                'status'           => 'active',
                'progress_percent' => 0,
            ]
        );

        return redirect()->route('customer.course.learn', ['courseId' => $course->id])
            ->with('success', 'Enrolled successfully! Enjoy your learning journey.');
    }

    /**
     * View & Download Certificate of Course Completion.
     */
    public function certificate(Request $request, $courseId): View|RedirectResponse
    {
        $user = Auth::guard('web')->user();
        if (!$user) {
            return redirect()->route('customer.login')->with('warning', 'Please login to view your certificate.');
        }

        $course = null;
        if (\Illuminate\Support\Facades\Schema::hasTable('dc_elearn_course')) {
            $course = ElearnCourse::find($courseId);
        }
        if (!$course && \Illuminate\Support\Facades\Schema::hasTable('courses')) {
            $course = Course::find($courseId);
        }

        if (!$course) {
            return redirect()->route('customer.my-courses')->with('error', 'Course not found.');
        }

        $enrollment = CourseEnrollment::where('user_id', $user->id)
            ->where('course_id', $courseId)
            ->first();

        // Calculate progress
        $totalLessons = ($course instanceof ElearnCourse) ? $course->getAllLessons()->count() : $course->contents()->count();
        $completedLessons = StudentCourseProgress::where('user_id', $user->id)
            ->where('course_id', $courseId)
            ->where('completed', true)
            ->count();

        $percent = $totalLessons > 0 ? (int)round(($completedLessons / $totalLessons) * 100) : ($enrollment ? $enrollment->progress_percent : 0);

        $completionDate = ($enrollment && $enrollment->completed_at) ? $enrollment->completed_at : now();
        $certificateId = 'DCW-' . strtoupper(substr(md5("{$user->id}-{$courseId}-DCW_CERT"), 0, 10));

        return view('customer.certificate', [
            'user'            => $user,
            'course'          => $course,
            'enrollment'      => $enrollment,
            'percent'         => $percent,
            'completionDate'  => $completionDate,
            'certificateId'   => $certificateId,
            'instructorName'  => $course->instructor_name ?? 'Digital Class Certified Master Instructor',
        ]);
    }

    /**
     * Auto-sync any purchases from the Orders table into CourseEnrollment records.
     */
    protected function syncPurchasedOrders(User $user): void
    {
        $orders = Order::where(function ($q) use ($user) {
            if ($user->email) $q->where('customer_email', $user->email);
            if ($user->phone) $q->orWhere('customer_phone', $user->phone);
        })
        ->where('order_type', 'Course')
        ->whereIn('status', ['confirmed', 'completed', 'processing', 'in_progress'])
        ->get();

        foreach ($orders as $order) {
            // Find course by title or id
            $course = null;
            $courseType = 'catalog';

            if (\Illuminate\Support\Facades\Schema::hasTable('dc_elearn_course')) {
                $course = ElearnCourse::where('course_name', $order->item_title)->first();
                if (!$course && preg_match('/\[ID:\s*(\d+)\]/', $order->item_subtext, $matches)) {
                    $course = ElearnCourse::find((int)$matches[1]);
                }
                if ($course) $courseType = 'elearn';
            }

            if (!$course && \Illuminate\Support\Facades\Schema::hasTable('courses')) {
                $course = Course::where('title', $order->item_title)->first();
                $courseType = 'catalog';
            }

            if ($course) {
                CourseEnrollment::firstOrCreate(
                    [
                        'user_id'     => $user->id,
                        'course_id'   => $course->id,
                        'course_type' => $courseType,
                    ],
                    [
                        'order_id'         => $order->id,
                        'enrolled_at'      => $order->placed_at ?? $order->created_at,
                        'status'           => 'active',
                        'progress_percent' => 0,
                    ]
                );
            }
        }
    }

    /**
     * Transform arbitrary video links into safe, responsive iframe embed URLs.
     */
    protected function formatEmbedUrl(?string $url): ?string
    {
        if (empty($url)) {
            return null;
        }

        $url = trim($url);

        // 1. YouTube
        if (preg_match('/(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))([\w-]{11})/', $url, $matches)) {
            return 'https://www.youtube-nocookie.com/embed/' . $matches[1] . '?autoplay=1&rel=0&modestbranding=1&enablejsapi=1';
        }

        // 2. Vimeo
        if (preg_match('/vimeo\.com\/(?:channels\/(?:\w+\/)?|groups\/(?:[^\/]*)\/videos\/|album\/(?:\d+)\/video\/|video\/|)(\d+)/', $url, $matches)) {
            return 'https://player.vimeo.com/video/' . $matches[1] . '?autoplay=1&title=0&byline=0';
        }

        // Direct video or generic URL
        return $url;
    }
}
