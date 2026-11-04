<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class CertificateController extends Controller
{
    /**
     * Display the Certificate view with PDF download & print functionality.
     */
    public function show(Request $request, ?string $code = null): View
    {
        $certificate = null;

        try {
            if (Schema::hasTable('certificates')) {
                if ($code) {
                    $certificate = Certificate::with(['course', 'seller.businessDetail'])
                        ->where('certificate_no', $code)
                        ->orWhere('student_id', $code)
                        ->first();
                }

                if (!$certificate) {
                    $certificate = Certificate::with(['course', 'seller.businessDetail'])
                        ->where('certificate_no', 'DC2026-00128')
                        ->first()
                        ?? Certificate::with(['course', 'seller.businessDetail'])->first();
                }
            }
        } catch (\Throwable $e) {
            $certificate = null;
        }

        // If customized via query parameter, override for preview
        if ($certificate && $request->filled('name')) {
            $certificate->student_name = $request->query('name');
        }

        // Fallback default certificate if database is empty
        if (!$certificate) {
            $certificate = new Certificate([
                'certificate_no'       => 'DC2026-00128',
                'student_id'           => 'STU20260045',
                'student_name'         => $request->query('name', 'Meshwa Patel'),
                'course_title'         => 'Full Stack Web Development',
                'duration'             => '6 Months',
                'start_date'           => '15 Apr 2026',
                'completion_date'      => '15 Oct 2026',
                'instructor_name'      => 'Rajesh Sharma',
                'instructor_title'     => 'Course Instructor',
                'instructor_signature' => 'Rajesh',
                'signatory_name'       => 'Dr. Neha Mehta',
                'signatory_title'      => 'Authorized Signatory',
                'institute_name'       => 'BrightLearn Institute',
                'signatory_signature'  => 'Joshi',
                'is_verified'          => true,
            ]);
        }

        return view('certificate.show', compact('certificate'));
    }

    /**
     * Generate or display the certificate for a specific course by slug.
     */
    public function forCourse(Request $request, string $slug): View
    {
        $course = Course::with(['seller.businessDetail', 'seller.user'])
            ->where('slug', $slug)
            ->first();

        $studentName = $request->query('name')
            ?: (Auth::check() ? Auth::user()->name : 'Meshwa Patel');

        $certificate = null;
        try {
            if (Schema::hasTable('certificates') && $course) {
                $certificate = Certificate::where('course_id', $course->id)
                    ->where('student_name', $studentName)
                    ->first();

                if (!$certificate) {
                    // Find existing certificate for this course or create a new unique one
                    $certificate = Certificate::where('course_id', $course->id)->first();
                }
            }
        } catch (\Throwable $e) {
            $certificate = null;
        }

        if (!$certificate) {
            $instName = $course?->seller?->businessDetail?->business_name
                ?: ($course?->seller?->institute_name ?: 'BrightLearn Institute');

            $instructorName = $course?->instructor_name
                ?: ($course?->seller?->user?->name ?: 'Rajesh Sharma');

            $certificate = new Certificate([
                'certificate_no'       => Certificate::generateCertificateNo(),
                'student_id'           => 'STU' . date('Y') . sprintf('%04d', rand(100, 9999)),
                'student_name'         => $studentName,
                'course_title'         => $course ? $course->title : 'Full Stack Web Development',
                'course_id'            => $course?->id,
                'seller_id'            => $course?->seller_id,
                'duration'             => $course?->duration ?: '6 Months',
                'start_date'           => '15 Apr 2026',
                'completion_date'      => '15 Oct 2026',
                'instructor_name'      => $instructorName,
                'instructor_title'     => 'Course Instructor',
                'instructor_signature' => explode(' ', $instructorName)[0],
                'signatory_name'       => 'Dr. Neha Mehta',
                'signatory_title'      => 'Authorized Signatory',
                'institute_name'       => $instName,
                'signatory_signature'  => 'Joshi',
                'is_verified'          => true,
            ]);
        }

        return view('certificate.show', compact('certificate', 'course'));
    }
}

