<?php

namespace Database\Seeders;

use App\Models\Certificate;
use App\Models\Course;
use App\Models\Seller;
use App\Models\User;
use Illuminate\Database\Seeder;

class CertificateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $seller = Seller::first();
        $user = User::first();
        $course = Course::where('title', 'like', '%Full Stack%')->first()
            ?? Course::first();

        // 1. Exact Certificate matching the uploaded screenshot
        Certificate::firstOrCreate(
            ['certificate_no' => 'DC2026-00128'],
            [
                'student_id'           => 'STU20260045',
                'student_name'         => 'Meshwa Patel',
                'course_title'         => 'Full Stack Web Development',
                'course_id'            => $course?->id,
                'seller_id'            => $seller?->id,
                'user_id'              => $user?->id,
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
            ]
        );

        // 2. Certificate for Digital Marketing Complete Course 2026
        $dmCourse = Course::where('slug', 'digital-marketing-complete-course-2026')->first();
        if ($dmCourse) {
            Certificate::firstOrCreate(
                ['certificate_no' => 'DC2026-00129'],
                [
                    'student_id'           => 'STU20260046',
                    'student_name'         => 'Meshwa Patel',
                    'course_title'         => $dmCourse->title,
                    'course_id'            => $dmCourse->id,
                    'seller_id'            => $dmCourse->seller_id ?? $seller?->id,
                    'user_id'              => $user?->id,
                    'duration'             => '3 Months',
                    'start_date'           => '01 Jan 2026',
                    'completion_date'      => '31 Mar 2026',
                    'instructor_name'      => 'Hitesh Mohkar',
                    'instructor_title'     => 'Founder & CEO, Digital Class',
                    'instructor_signature' => 'Hitesh',
                    'signatory_name'       => 'Dr. Neha Mehta',
                    'signatory_title'      => 'Authorized Signatory',
                    'institute_name'       => 'VCEC - Vinayak Computer Education Center',
                    'signatory_signature'  => 'Joshi',
                    'is_verified'          => true,
                ]
            );
        }
    }
}

