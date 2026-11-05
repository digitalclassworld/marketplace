<?php

namespace Database\Seeders;

use App\Models\WebsitePage;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class WebsiteManagementSeeder extends Seeder
{
    public function run(): void
    {
        WebsitePage::truncate();

        $pages = [
            [
                'title'            => 'Home',
                'slug'             => '/',
                'type'             => 'System',
                'status'           => 'Published',
                'thumbnail'        => 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&w=150&q=80',
                'show_in_menu'     => true,
                'is_homepage'      => true,
                'meta_title'       => 'Digital Class - Online Educational Marketplace',
                'meta_description' => 'Learn, Hire, Buy, Discover on Digital Class Marketplace.',
                'focus_keyword'    => 'educational marketplace',
                'last_updated_at'  => Carbon::parse('2026-10-28 10:20:00'),
            ],
            [
                'title'            => 'Courses',
                'slug'             => '/courses',
                'type'             => 'Custom',
                'status'           => 'Published',
                'thumbnail'        => 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=150&q=80',
                'show_in_menu'     => true,
                'is_homepage'      => false,
                'meta_title'       => 'Online Courses & Training Programs - Digital Class',
                'meta_description' => 'Explore 500+ top-rated courses across business, software, marketing and technology.',
                'focus_keyword'    => 'online courses',
                'last_updated_at'  => Carbon::parse('2026-10-26 16:15:00'),
            ],
            [
                'title'            => 'Services',
                'slug'             => '/services',
                'type'             => 'Custom',
                'status'           => 'Published',
                'thumbnail'        => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&w=150&q=80',
                'show_in_menu'     => true,
                'is_homepage'      => false,
                'meta_title'       => 'Professional Services & Freelancers - Digital Class',
                'meta_description' => 'Hire top educational consultants, designers, developers and marketers.',
                'focus_keyword'    => 'freelance services',
                'last_updated_at'  => Carbon::parse('2026-10-25 11:30:00'),
            ],
            [
                'title'            => 'Products',
                'slug'             => '/products',
                'type'             => 'Custom',
                'status'           => 'Published',
                'thumbnail'        => 'https://images.unsplash.com/photo-1550745165-9bc0b252726f?auto=format&fit=crop&w=150&q=80',
                'show_in_menu'     => true,
                'is_homepage'      => false,
                'meta_title'       => 'Educational Products & Hardware - Digital Class',
                'meta_description' => 'Buy laptops, cameras, software, smart screens and educational kits.',
                'focus_keyword'    => 'educational hardware',
                'last_updated_at'  => Carbon::parse('2026-10-22 13:45:00'),
            ],
            [
                'title'            => 'Institutes',
                'slug'             => '/institutes',
                'type'             => 'Custom',
                'status'           => 'Published',
                'thumbnail'        => 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?auto=format&fit=crop&w=150&q=80',
                'show_in_menu'     => true,
                'is_homepage'      => false,
                'meta_title'       => 'Verified Colleges & Training Institutes - Digital Class',
                'meta_description' => 'Discover certified institutes, tuition academies and schools near you.',
                'focus_keyword'    => 'institutes',
                'last_updated_at'  => Carbon::parse('2026-10-20 09:10:00'),
            ],
            [
                'title'            => 'About Us',
                'slug'             => '/about-us',
                'type'             => 'Custom',
                'status'           => 'Published',
                'thumbnail'        => 'https://images.unsplash.com/photo-1531403009284-440f080d1e12?auto=format&fit=crop&w=150&q=80',
                'show_in_menu'     => false,
                'is_homepage'      => false,
                'meta_title'       => 'About Digital Class Educational World',
                'meta_description' => 'Our vision to empower learners, instructors and educational institutes across India.',
                'focus_keyword'    => 'about digital class',
                'last_updated_at'  => Carbon::parse('2026-10-18 14:25:00'),
            ],
            [
                'title'            => 'Contact Us',
                'slug'             => '/contact-us',
                'type'             => 'Custom',
                'status'           => 'Published',
                'thumbnail'        => 'https://images.unsplash.com/photo-1557804506-669a67965ba0?auto=format&fit=crop&w=150&q=80',
                'show_in_menu'     => false,
                'is_homepage'      => false,
                'meta_title'       => 'Contact Digital Class Support',
                'meta_description' => 'Get in touch with our admissions and technical support team.',
                'focus_keyword'    => 'contact us',
                'last_updated_at'  => Carbon::parse('2026-10-15 12:00:00'),
            ],
            [
                'title'            => 'Blog',
                'slug'             => '/blog',
                'type'             => 'Blog',
                'status'           => 'Published',
                'thumbnail'        => 'https://images.unsplash.com/photo-1499750310107-5fef28a66643?auto=format&fit=crop&w=150&q=80',
                'show_in_menu'     => true,
                'is_homepage'      => false,
                'meta_title'       => 'Knowledge Hub & Student Articles - Digital Class',
                'meta_description' => 'Read our latest blogs on AI, education, digital marketing and careers.',
                'focus_keyword'    => 'education blog',
                'last_updated_at'  => Carbon::parse('2026-10-12 15:40:00'),
            ],
            [
                'title'            => 'Terms & Conditions',
                'slug'             => '/terms-conditions',
                'type'             => 'Legal',
                'status'           => 'Published',
                'thumbnail'        => 'https://images.unsplash.com/photo-1450133064473-71024230f91b?auto=format&fit=crop&w=150&q=80',
                'show_in_menu'     => false,
                'is_homepage'      => false,
                'meta_title'       => 'Terms & Conditions - Digital Class',
                'meta_description' => 'Terms of service for buyers, sellers and institutional partners.',
                'focus_keyword'    => 'terms of service',
                'last_updated_at'  => Carbon::parse('2026-10-10 11:50:00'),
            ],
            [
                'title'            => 'Privacy Policy',
                'slug'             => '/privacy-policy',
                'type'             => 'Legal',
                'status'           => 'Published',
                'thumbnail'        => 'https://images.unsplash.com/photo-1555421689-491a97ff2040?auto=format&fit=crop&w=150&q=80',
                'show_in_menu'     => false,
                'is_homepage'      => false,
                'meta_title'       => 'Privacy Policy - Digital Class',
                'meta_description' => 'How Digital Class collects, protects and uses user data.',
                'focus_keyword'    => 'privacy policy',
                'last_updated_at'  => Carbon::parse('2026-10-09 13:15:00'),
            ],
        ];

        foreach ($pages as $p) {
            WebsitePage::create($p);
        }

        // Additional pages to reach 28 total
        $extraTitles = [
            'Refund & Cancellation Policy' => ['/refund-policy', 'Legal'],
            'Become a Seller'              => ['/seller/register', 'Custom'],
            'Institute Partnership'        => ['/institutes/partner', 'Custom'],
            'Student Scholarship 2026'     => ['/scholarships', 'Custom'],
            'Careers at Digital Class'     => ['/careers', 'Custom'],
            'Help & FAQ Center'            => ['/help', 'Custom'],
            'Pricing Plans'                => ['/pricing', 'Custom'],
            'Affiliate Program'            => ['/affiliate', 'Custom'],
            'Community Guidelines'         => ['/guidelines', 'Legal'],
            'Certificate Verification'     => ['/verify-certificate', 'System'],
            'Press & Media Kit'            => ['/press', 'Custom'],
            'Security & Compliance'        => ['/security', 'Legal'],
            'Sitemap'                      => ['/sitemap', 'System'],
            'Developer API Documentation'  => ['/developers', 'Custom'],
            'Diwali Special 2026 Landing'  => ['/campaign/diwali', 'Custom'],
            'Mobile App Download'          => ['/apps', 'Custom'],
            'Cookie Policy'                => ['/cookies', 'Legal'],
            'Accessibility Statement'      => ['/accessibility', 'Legal'],
        ];

        $i = 11;
        foreach ($extraTitles as $title => $meta) {
            WebsitePage::create([
                'title'            => $title,
                'slug'             => $meta[0],
                'type'             => $meta[1],
                'status'           => 'Published',
                'thumbnail'        => 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=150&q=80',
                'show_in_menu'     => false,
                'is_homepage'      => false,
                'meta_title'       => "{$title} - Digital Class",
                'meta_description' => "Information regarding {$title} on Digital Class Marketplace.",
                'focus_keyword'    => strtolower($title),
                'last_updated_at'  => Carbon::parse('2026-10-01')->addDays($i % 25),
            ]);
            $i++;
        }
    }
}
