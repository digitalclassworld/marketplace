<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\CourseContent;
use App\Models\CourseEnrollment;
use App\Models\ElearnCourse;
use App\Models\Order;
use App\Models\Seller;
use App\Models\StudentCourseProgress;
use App\Models\StudentLectureNote;
use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class StudentLearningPortalTest extends TestCase
{
    protected $student;
    protected $course;
    protected $isElearn = false;

    protected function setUp(): void
    {
        parent::setUp();

        // 1. Create or retrieve test student customer
        $this->student = User::where('role', 'customer')->first();
        if (!$this->student) {
            $this->student = User::factory()->create([
                'name'       => 'Pooja Sharma',
                'email'      => 'pooja_student_' . uniqid() . '@example.com',
                'role'       => 'customer',
                'profession' => 'Student (College / University)',
            ]);
        }

        // 2. Retrieve Course 2014 or create catalog course with curriculum
        if (Schema::hasTable('dc_elearn_course')) {
            $this->course = ElearnCourse::find(2014) ?: ElearnCourse::first();
            $this->isElearn = true;
        } else {
            $sellerUser = User::factory()->create(['role' => 'seller']);
            $seller = Seller::create([
                'user_id'      => $sellerUser->id,
                'seller_code'  => 'SEL' . rand(1000, 9999),
                'account_type' => 'individual',
                'status'       => 'approved',
            ]);

            $this->course = Course::create([
                'seller_id' => $seller->id,
                'title'     => 'Java Program Training Course',
                'slug'      => 'java-program-training-course-' . uniqid(),
                'category'  => 'Development',
                'price'     => 10000,
                'status'    => 'approved',
            ]);

            CourseContent::create([
                'course_id'     => $this->course->id,
                'section_title' => 'Module 1: Orientation',
                'lecture_title' => 'Java Architecture Overview',
                'duration'      => '18:45',
                'video_url'     => 'https://www.youtube.com/watch?v=eIrMbAQSU34',
                'sort_order'    => 1,
            ]);

            CourseContent::create([
                'course_id'     => $this->course->id,
                'section_title' => 'Module 2: OOP Principles',
                'lecture_title' => 'Inheritance and Polymorphism',
                'duration'      => '24:10',
                'video_url'     => 'https://www.youtube.com/watch?v=RRubcjpTkks',
                'sort_order'    => 2,
            ]);

            $this->isElearn = false;
        }
    }

    public function test_guest_is_redirected_to_login_when_accessing_learning_portal()
    {
        $response = $this->get(route('customer.my-courses'));
        $response->assertRedirect(route('customer.login'));
    }

    public function test_student_can_view_my_courses_page()
    {
        $response = $this->actingAs($this->student, 'web')->get(route('customer.my-courses'));
        $response->assertStatus(200);
        $response->assertSee('Student Learning Portal');
        $response->assertSee('All Enrolled');
    }

    public function test_student_can_access_course_learning_player()
    {
        $response = $this->actingAs($this->student, 'web')->get(route('customer.course.learn', ['courseId' => $this->course->id]));
        $response->assertStatus(200);
        $response->assertSee('Course Content');
        $response->assertSee('Mark as Completed');

        // Verify enrollment record was created
        $this->assertDatabaseHas('course_enrollments', [
            'user_id'   => $this->student->id,
            'course_id' => $this->course->id,
        ]);
    }

    public function test_student_can_toggle_lesson_completion()
    {
        // Get first lesson id
        $firstLessonId = 1;
        if ($this->isElearn) {
            $chapters = $this->course->getVideoChapters();
            $firstLessonId = $chapters->first()->lessons->first()->id;
        } else {
            $firstLessonId = $this->course->contents->first()->id;
        }

        // Toggle complete
        $response = $this->actingAs($this->student, 'web')
            ->postJson(route('customer.course.lesson.toggle', [
                'courseId' => $this->course->id,
                'lessonId' => $firstLessonId,
            ]));

        $response->assertStatus(200);
        $response->assertJson([
            'success'   => true,
            'completed' => true,
        ]);

        $this->assertDatabaseHas('student_course_progress', [
            'user_id'   => $this->student->id,
            'course_id' => $this->course->id,
            'lesson_id' => $firstLessonId,
            'completed' => 1,
        ]);

        // Toggle back to incomplete
        $response2 = $this->actingAs($this->student, 'web')
            ->postJson(route('customer.course.lesson.toggle', [
                'courseId' => $this->course->id,
                'lessonId' => $firstLessonId,
            ]));

        $response2->assertStatus(200);
        $response2->assertJson([
            'success'   => true,
            'completed' => false,
        ]);
    }

    public function test_student_can_save_lecture_notes()
    {
        $firstLessonId = 1;
        if ($this->isElearn) {
            $chapters = $this->course->getVideoChapters();
            $firstLessonId = $chapters->first()->lessons->first()->id;
        } else {
            $firstLessonId = $this->course->contents->first()->id;
        }

        $response = $this->actingAs($this->student, 'web')
            ->postJson(route('customer.course.lesson.note', [
                'courseId' => $this->course->id,
                'lessonId' => $firstLessonId,
            ]), [
                'note' => 'Important: Remember JVM bytecode execution and stack frames.',
            ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'message' => 'Note saved successfully!',
        ]);

        $this->assertDatabaseHas('student_lecture_notes', [
            'user_id'   => $this->student->id,
            'course_id' => $this->course->id,
            'lesson_id' => $firstLessonId,
        ]);
    }

    public function test_student_can_view_certificate()
    {
        $response = $this->actingAs($this->student, 'web')
            ->get(route('customer.course.certificate', ['courseId' => $this->course->id]));

        $response->assertStatus(200);
        $response->assertSee('Certificate of Completion');
        $response->assertSee($this->student->name);
        $response->assertSee('DIGITAL CLASS WORLD');
        $response->assertSee('Download Locked');

        // Explicit download attempt when not completed should be blocked and redirected with error
        $downloadResponse = $this->actingAs($this->student, 'web')
            ->get(route('customer.course.certificate', ['courseId' => $this->course->id, 'download' => 1]));
        $downloadResponse->assertRedirect();
        $downloadResponse->assertSessionHas('error');
    }
}
