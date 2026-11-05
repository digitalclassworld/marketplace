<?php

namespace Database\Seeders;

use App\Models\PlatformNotification;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class NotificationSeeder extends Seeder
{
    public function run(): void
    {
        PlatformNotification::truncate();

        // 10 Curated Notifications matching screenshot exactly
        $curated = [
            [
                'title'            => 'Diwali Offer is Live!',
                'message'          => 'Get 50% OFF on all Online Courses. Use Code DIWALI50 now!',
                'channel'          => 'Push Notification',
                'type'             => 'Promotion',
                'audience'         => 'All Users',
                'audience_count'   => 8620,
                'platforms'        => ['Website', 'Android App', 'iOS App'],
                'status'           => 'Sent',
                'sent_at'          => Carbon::parse('2026-10-28 10:30:00'),
                'recipients_count' => 8620,
                'opened_count'     => 6280,
                'clicked_count'    => 1420,
                'image_url'        => 'https://images.unsplash.com/photo-1607082348824-0a96f2a4b9da?auto=format&fit=crop&w=400&q=80',
                'target_link'      => 'https://digitalclass.in/coupon/DIWALI50',
            ],
            [
                'title'            => 'New Course Launch',
                'message'          => 'Learn AI for Business - Live Classes starting this Sunday.',
                'channel'          => 'Push Notification',
                'type'             => 'Course',
                'audience'         => 'Students',
                'audience_count'   => 3120,
                'platforms'        => ['Website', 'Android App', 'iOS App'],
                'status'           => 'Sent',
                'sent_at'          => Carbon::parse('2026-10-26 16:15:00'),
                'recipients_count' => 3120,
                'opened_count'     => 2240,
                'clicked_count'    => 610,
                'image_url'        => 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=400&q=80',
                'target_link'      => 'https://digitalclass.in/courses',
            ],
            [
                'title'            => 'Website Maintenance',
                'message'          => 'Our website will be under maintenance tomorrow from 1 AM to 5 AM.',
                'channel'          => 'In-App',
                'type'             => 'System',
                'audience'         => 'All Users',
                'audience_count'   => 8620,
                'platforms'        => ['Website', 'Android App', 'WhatsApp'],
                'status'           => 'Sent',
                'sent_at'          => Carbon::parse('2026-10-25 21:20:00'),
                'recipients_count' => 8620,
                'opened_count'     => 7100,
                'clicked_count'    => 450,
                'image_url'        => 'https://images.unsplash.com/photo-1581291518655-9523c932deb3?auto=format&fit=crop&w=400&q=80',
                'target_link'      => 'https://digitalclass.in',
            ],
            [
                'title'            => 'Monthly Newsletter',
                'message'          => 'Check out the latest blogs, courses and updates from Digital Class.',
                'channel'          => 'Email',
                'type'             => 'Update',
                'audience'         => 'All Users',
                'audience_count'   => 8620,
                'platforms'        => ['Website', 'Email'],
                'status'           => 'Sent',
                'sent_at'          => Carbon::parse('2026-10-22 11:00:00'),
                'recipients_count' => 8620,
                'opened_count'     => 5900,
                'clicked_count'    => 1280,
                'image_url'        => 'https://images.unsplash.com/photo-1557804506-669a67965ba0?auto=format&fit=crop&w=400&q=80',
                'target_link'      => 'https://digitalclass.in/blog',
            ],
            [
                'title'            => 'Pending Fee Reminder',
                'message'          => 'Your course fee is pending. Please complete the payment.',
                'channel'          => 'SMS',
                'type'             => 'Reminder',
                'audience'         => 'Students',
                'audience_count'   => 820,
                'platforms'        => ['Android App', 'iOS App'],
                'status'           => 'Sent',
                'sent_at'          => Carbon::parse('2026-10-20 15:45:00'),
                'recipients_count' => 820,
                'opened_count'     => 760,
                'clicked_count'    => 310,
                'image_url'        => 'https://images.unsplash.com/photo-1434030216411-0b793f4b4173?auto=format&fit=crop&w=400&q=80',
                'target_link'      => 'https://digitalclass.in/user/payments',
            ],
            [
                'title'            => 'New Seller Registration',
                'message'          => 'Welcome to Digital Class! Start listing your courses today.',
                'channel'          => 'Email',
                'type'             => 'Welcome',
                'audience'         => 'Sellers',
                'audience_count'   => 142,
                'platforms'        => ['Website', 'Email'],
                'status'           => 'Sent',
                'sent_at'          => Carbon::parse('2026-10-18 13:10:00'),
                'recipients_count' => 142,
                'opened_count'     => 138,
                'clicked_count'    => 92,
                'image_url'        => 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&w=400&q=80',
                'target_link'      => 'https://digitalclass.in/seller/dashboard',
            ],
            [
                'title'            => 'Review Request',
                'message'          => 'How was your learning experience? Please share your review.',
                'channel'          => 'In-App',
                'type'             => 'Engagement',
                'audience'         => 'Students',
                'audience_count'   => 1250,
                'platforms'        => ['Android App', 'iOS App'],
                'status'           => 'Scheduled',
                'scheduled_at'     => Carbon::parse('2026-10-31 10:00:00'),
                'recipients_count' => 1250,
                'opened_count'     => 0,
                'clicked_count'    => 0,
                'image_url'        => 'https://images.unsplash.com/photo-1531403009284-440f080d1e12?auto=format&fit=crop&w=400&q=80',
                'target_link'      => 'https://digitalclass.in/reviews',
            ],
            [
                'title'            => 'Limited Time Offer',
                'message'          => 'Get 30% OFF on Institute Management Software. Valid till 5 Nov.',
                'channel'          => 'Push Notification',
                'type'             => 'Promotion',
                'audience'         => 'Institutes',
                'audience_count'   => 650,
                'platforms'        => ['Website', 'Email'],
                'status'           => 'Scheduled',
                'scheduled_at'     => Carbon::parse('2026-11-01 09:00:00'),
                'recipients_count' => 650,
                'opened_count'     => 0,
                'clicked_count'    => 0,
                'image_url'        => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&w=400&q=80',
                'target_link'      => 'https://digitalclass.in/services',
            ],
            [
                'title'            => 'New Feature Update',
                'message'          => 'We have added new certificate builder templates. Check now!',
                'channel'          => 'Push Notification',
                'type'             => 'Product',
                'audience'         => 'All Users',
                'audience_count'   => 8620,
                'platforms'        => ['Website', 'Android App', 'iOS App'],
                'status'           => 'Draft',
                'recipients_count' => 0,
                'opened_count'     => 0,
                'clicked_count'    => 0,
                'image_url'        => 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?auto=format&fit=crop&w=400&q=80',
                'target_link'      => 'https://digitalclass.in/certificate',
            ],
            [
                'title'            => 'Event Reminder',
                'message'          => "Don't forget! Live webinar on Digital Marketing today at 7 PM.",
                'channel'          => 'Push Notification',
                'type'             => 'Event',
                'audience'         => 'Registered Users',
                'audience_count'   => 320,
                'platforms'        => ['Android App', 'Email'],
                'status'           => 'Draft',
                'recipients_count' => 0,
                'opened_count'     => 0,
                'clicked_count'    => 0,
                'image_url'        => 'https://images.unsplash.com/photo-1511578314322-379afb476865?auto=format&fit=crop&w=400&q=80',
                'target_link'      => 'https://digitalclass.in/events',
            ],
        ];

        foreach ($curated as $item) {
            PlatformNotification::create($item);
        }

        // Additional Sent items (to reach 98 Sent total)
        $audiences = [
            ['All Users', 8620, ['Website', 'Android App', 'iOS App']],
            ['Students', 3120, ['Android App', 'iOS App']],
            ['Sellers', 142, ['Website', 'Email']],
            ['Institutes', 650, ['Website', 'Email']],
            ['Registered Users', 320, ['Android App', 'Email']],
        ];
        $types = ['Promotion', 'Course', 'System', 'Update', 'Reminder', 'Welcome', 'Engagement', 'Product', 'Event'];
        $channels = ['Push Notification', 'In-App', 'Email', 'SMS'];

        for ($i = 7; $i <= 98; $i++) {
            $aud = $audiences[array_rand($audiences)];
            $type = $types[array_rand($types)];
            $chan = $channels[array_rand($channels)];
            PlatformNotification::create([
                'title'            => "Platform Announcement #{$i}",
                'message'          => "Exciting updates and seasonal offers available for our community members.",
                'channel'          => $chan,
                'type'             => $type,
                'audience'         => $aud[0],
                'audience_count'   => $aud[1],
                'platforms'        => $aud[2],
                'status'           => 'Sent',
                'sent_at'          => Carbon::parse('2026-10-01')->addDays($i % 25)->addHours($i % 12),
                'recipients_count' => rand(150, $aud[1]),
                'opened_count'     => rand(50, 120),
                'clicked_count'    => rand(10, 40),
                'image_url'        => null,
                'target_link'      => 'https://digitalclass.in',
            ]);
        }

        // Additional Scheduled items (to reach 18 Scheduled total)
        for ($i = 3; $i <= 18; $i++) {
            $aud = $audiences[array_rand($audiences)];
            $type = $types[array_rand($types)];
            PlatformNotification::create([
                'title'            => "Scheduled Campaign #{$i}",
                'message'          => "Upcoming discount and engagement push scheduled for execution.",
                'channel'          => 'Push Notification',
                'type'             => $type,
                'audience'         => $aud[0],
                'audience_count'   => $aud[1],
                'platforms'        => $aud[2],
                'status'           => 'Scheduled',
                'scheduled_at'     => Carbon::parse('2026-11-01')->addDays($i % 10)->addHours($i % 8),
                'recipients_count' => $aud[1],
                'opened_count'     => 0,
                'clicked_count'    => 0,
                'image_url'        => null,
                'target_link'      => 'https://digitalclass.in',
            ]);
        }

        // Additional Draft items (to reach 8 Drafts total)
        for ($i = 3; $i <= 8; $i++) {
            $aud = $audiences[array_rand($audiences)];
            $type = $types[array_rand($types)];
            PlatformNotification::create([
                'title'            => "Draft Campaign Concept #{$i}",
                'message'          => "Draft copy for testing notification subject lines and open rates.",
                'channel'          => 'In-App',
                'type'             => $type,
                'audience'         => $aud[0],
                'audience_count'   => $aud[1],
                'platforms'        => $aud[2],
                'status'           => 'Draft',
                'recipients_count' => 0,
                'opened_count'     => 0,
                'clicked_count'    => 0,
                'image_url'        => null,
                'target_link'      => 'https://digitalclass.in',
            ]);
        }

        // 2 Failed items (to reach 2 Failed total)
        for ($i = 1; $i <= 2; $i++) {
            $aud = $audiences[array_rand($audiences)];
            PlatformNotification::create([
                'title'            => "Failed Delivery Test #{$i}",
                'message'          => "Gateway connection timed out during broadcast attempt.",
                'channel'          => 'SMS',
                'type'             => 'System',
                'audience'         => $aud[0],
                'audience_count'   => $aud[1],
                'platforms'        => ['Website'],
                'status'           => 'Failed',
                'sent_at'          => Carbon::parse('2026-10-15 08:00:00'),
                'recipients_count' => 0,
                'opened_count'     => 0,
                'clicked_count'    => 0,
                'image_url'        => null,
                'target_link'      => 'https://digitalclass.in',
            ]);
        }
    }
}
