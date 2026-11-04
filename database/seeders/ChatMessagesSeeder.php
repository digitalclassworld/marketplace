<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Seller;
use App\Models\Conversation;
use App\Models\Message;
use Carbon\Carbon;

class ChatMessagesSeeder extends Seeder
{
    public function run(): void
    {
        $sellers = Seller::all();
        if ($sellers->isEmpty()) {
            return;
        }

        foreach ($sellers as $seller) {
            // Delete existing conversations for this seller to avoid duplicates
            Conversation::where('seller_id', $seller->id)->delete();

            $baseDate = Carbon::parse('2026-10-31 10:24:00');

            // 1. Rimsha Khan (Primary Active Chat)
            $c1 = Conversation::create([
                'seller_id' => $seller->id,
                'customer_name' => 'Rimsha Khan',
                'customer_email' => 'rimsha.khan@gmail.com',
                'customer_phone' => '+91 98765 43210',
                'customer_avatar' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=200&q=80',
                'customer_city' => 'Ahmedabad, Gujarat',
                'customer_online_status' => 'Online',
                'subject_title' => 'Digital Marketing Mastery',
                'subject_type' => 'Course Enquiry',
                'subject_thumbnail' => 'https://images.unsplash.com/photo-1432888622747-4eb9a8efeb07?auto=format&fit=crop&w=120&q=80',
                'category' => 'inquiries',
                'status' => 'In Progress',
                'total_messages' => 12,
                'unread_count' => 2,
                'last_message' => 'Please share it here. Also can I get a 10% discount if I enroll now?',
                'last_message_at' => $baseDate->copy(),
                'active_since' => Carbon::parse('2026-10-31'),
            ]);

            // Messages for Rimsha Khan matching screenshot exactly
            Message::create([
                'conversation_id' => $c1->id,
                'sender_type' => 'seller',
                'sender_id' => $seller->id,
                'sender_name' => $seller->store_name,
                'message' => 'Hello Rimsha! Thank you for your interest in our Digital Marketing course. How can I help you today?',
                'is_read' => true,
                'created_at' => Carbon::parse('2026-10-31 10:08:00'),
            ]);

            Message::create([
                'conversation_id' => $c1->id,
                'sender_type' => 'customer',
                'sender_name' => 'Rimsha Khan',
                'message' => 'Hi Rahul, I am interested in your Digital Marketing course. Can you please share more details about the course, fees, and duration?',
                'is_read' => true,
                'created_at' => Carbon::parse('2026-10-31 10:12:00'),
            ]);

            Message::create([
                'conversation_id' => $c1->id,
                'sender_type' => 'seller',
                'sender_id' => $seller->id,
                'sender_name' => $seller->store_name,
                'message' => "Sure! 😊 This course covers SEO, Social Media, Google Ads, Content Marketing and more. The duration is 3 months with live sessions + lifetime access to recorded videos.\n\nThe current fee is ₹2,999. Would you like me to share the complete brochure and syllabus?",
                'is_read' => true,
                'created_at' => Carbon::parse('2026-10-31 10:16:00'),
            ]);

            Message::create([
                'conversation_id' => $c1->id,
                'sender_type' => 'customer',
                'sender_name' => 'Rimsha Khan',
                'message' => 'Yes please. Also, do you have any batch schedule for weekend classes?',
                'is_read' => true,
                'created_at' => Carbon::parse('2026-10-31 10:18:00'),
            ]);

            Message::create([
                'conversation_id' => $c1->id,
                'sender_type' => 'seller',
                'sender_id' => $seller->id,
                'sender_name' => $seller->store_name,
                'message' => "Yes, we have a dedicated weekend batch starting from 15th Nov. I'll share the complete details, brochure and available slots in a PDF. Would you like me to share it here or on WhatsApp?",
                'is_read' => true,
                'created_at' => Carbon::parse('2026-10-31 10:22:00'),
            ]);

            Message::create([
                'conversation_id' => $c1->id,
                'sender_type' => 'customer',
                'sender_name' => 'Rimsha Khan',
                'message' => 'Please share it here. Also can I get a 10% discount if I enroll now?',
                'is_read' => false,
                'created_at' => Carbon::parse('2026-10-31 10:24:00'),
            ]);

            // 2. Amit Patel
            $c2 = Conversation::create([
                'seller_id' => $seller->id,
                'customer_name' => 'Amit Patel',
                'customer_email' => 'amit.patel@gmail.com',
                'customer_phone' => '+91 98250 11223',
                'customer_avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=200&q=80',
                'customer_city' => 'Surat, Gujarat',
                'customer_online_status' => 'Away',
                'subject_title' => 'Digital Marketing Mastery (Order #DC12567)',
                'subject_type' => 'Order Support',
                'subject_thumbnail' => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&w=120&q=80',
                'category' => 'orders',
                'status' => 'In Progress',
                'total_messages' => 4,
                'unread_count' => 1,
                'last_message' => 'I have purchased the course but I am not able to access the live...',
                'last_message_at' => $baseDate->copy()->subDay(),
                'active_since' => Carbon::parse('2026-10-30'),
            ]);
            Message::create([
                'conversation_id' => $c2->id,
                'sender_type' => 'customer',
                'sender_name' => 'Amit Patel',
                'message' => 'I have purchased the course but I am not able to access the live classes dashboard. Could you please check?',
                'is_read' => false,
                'created_at' => $baseDate->copy()->subDay(),
            ]);

            // 3. Neha Desai
            $c3 = Conversation::create([
                'seller_id' => $seller->id,
                'customer_name' => 'Neha Desai',
                'customer_email' => 'neha.desai@gmail.com',
                'customer_phone' => '+91 97230 44556',
                'customer_avatar' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=200&q=80',
                'customer_city' => 'Vadodara, Gujarat',
                'customer_online_status' => 'Offline',
                'subject_title' => 'Full Stack Web Development',
                'subject_type' => 'Course Enquiry',
                'subject_thumbnail' => 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?auto=format&fit=crop&w=120&q=80',
                'category' => 'inquiries',
                'status' => 'Active',
                'total_messages' => 6,
                'unread_count' => 0,
                'last_message' => 'Can you please share the syllabus of the web development course?',
                'last_message_at' => $baseDate->copy()->subDay()->subHours(2),
                'active_since' => Carbon::parse('2026-10-29'),
            ]);
            Message::create([
                'conversation_id' => $c3->id,
                'sender_type' => 'customer',
                'sender_name' => 'Neha Desai',
                'message' => 'Can you please share the syllabus of the web development course?',
                'is_read' => true,
                'created_at' => $baseDate->copy()->subDay()->subHours(2),
            ]);

            // 4. Pooja Patel
            $c4 = Conversation::create([
                'seller_id' => $seller->id,
                'customer_name' => 'Pooja Patel',
                'customer_email' => 'pooja.patel@gmail.com',
                'customer_phone' => '+91 98980 99887',
                'customer_avatar' => 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?auto=format&fit=crop&w=200&q=80',
                'customer_city' => 'Ahmedabad, Gujarat',
                'customer_online_status' => 'Offline',
                'subject_title' => 'Python for Beginners & Data Science',
                'subject_type' => 'Course Enquiry',
                'subject_thumbnail' => 'https://images.unsplash.com/photo-1526374965328-7f61d4dc18c5?auto=format&fit=crop&w=120&q=80',
                'category' => 'inquiries',
                'status' => 'In Progress',
                'total_messages' => 8,
                'unread_count' => 0,
                'last_message' => 'Do you offer any discount for multiple courses?',
                'last_message_at' => $baseDate->copy()->subDays(2),
                'active_since' => Carbon::parse('2026-10-28'),
            ]);
            Message::create([
                'conversation_id' => $c4->id,
                'sender_type' => 'customer',
                'sender_name' => 'Pooja Patel',
                'message' => 'Do you offer any discount for multiple courses?',
                'is_read' => true,
                'created_at' => $baseDate->copy()->subDays(2),
            ]);

            // 5. Vikas Mehta
            $c5 = Conversation::create([
                'seller_id' => $seller->id,
                'customer_name' => 'Vikas Mehta',
                'customer_email' => 'vikas.mehta@eduhub.in',
                'customer_phone' => '+91 94280 66778',
                'customer_avatar' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=200&q=80',
                'customer_city' => 'Rajkot, Gujarat',
                'customer_online_status' => 'Offline',
                'subject_title' => 'Institute Partnership & Business Listing',
                'subject_type' => 'Business Listing Enquiry',
                'subject_thumbnail' => 'https://images.unsplash.com/photo-1497366216548-37526070297c?auto=format&fit=crop&w=120&q=80',
                'category' => 'inquiries',
                'status' => 'In Progress',
                'total_messages' => 5,
                'unread_count' => 0,
                'last_message' => 'I want to list my institute on your platform. Please share the process.',
                'last_message_at' => $baseDate->copy()->subDays(3),
                'active_since' => Carbon::parse('2026-10-27'),
            ]);
            Message::create([
                'conversation_id' => $c5->id,
                'sender_type' => 'customer',
                'sender_name' => 'Vikas Mehta',
                'message' => 'I want to list my institute on your platform. Please share the process.',
                'is_read' => true,
                'created_at' => $baseDate->copy()->subDays(3),
            ]);

            // 6. Sneha Shah
            $c6 = Conversation::create([
                'seller_id' => $seller->id,
                'customer_name' => 'Sneha Shah',
                'customer_email' => 'sneha.shah@gmail.com',
                'customer_phone' => '+91 99090 33445',
                'customer_avatar' => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&w=200&q=80',
                'customer_city' => 'Gandhinagar, Gujarat',
                'customer_online_status' => 'Offline',
                'subject_title' => 'Graphic Design Masterclass',
                'subject_type' => 'Course Feedback',
                'subject_thumbnail' => 'https://images.unsplash.com/photo-1626785774573-4b799315345d?auto=format&fit=crop&w=120&q=80',
                'category' => 'support',
                'status' => 'Resolved',
                'total_messages' => 4,
                'unread_count' => 0,
                'last_message' => 'Thank you for the quick response. The course is really helpful!',
                'last_message_at' => $baseDate->copy()->subDays(3)->subHours(3),
                'active_since' => Carbon::parse('2026-10-26'),
            ]);
            Message::create([
                'conversation_id' => $c6->id,
                'sender_type' => 'customer',
                'sender_name' => 'Sneha Shah',
                'message' => 'Thank you for the quick response. The course is really helpful!',
                'is_read' => true,
                'created_at' => $baseDate->copy()->subDays(3)->subHours(3),
            ]);

            // 7. Rahul Joshi
            $c7 = Conversation::create([
                'seller_id' => $seller->id,
                'customer_name' => 'Rahul Joshi',
                'customer_email' => 'rahul.joshi@gmail.com',
                'customer_phone' => '+91 98795 77889',
                'customer_avatar' => 'https://images.unsplash.com/photo-1522075469751-3a6694fb2f61?auto=format&fit=crop&w=200&q=80',
                'customer_city' => 'Bhavnagar, Gujarat',
                'customer_online_status' => 'Away',
                'subject_title' => 'Wireless Mouse Logitech M330 (Order #DC12566)',
                'subject_type' => 'Product Order Status',
                'subject_thumbnail' => 'https://images.unsplash.com/photo-1527864550417-7fd91fc51a46?auto=format&fit=crop&w=120&q=80',
                'category' => 'orders',
                'status' => 'In Progress',
                'total_messages' => 7,
                'unread_count' => 0,
                'last_message' => 'Please check the order status of my product. It is still showing...',
                'last_message_at' => $baseDate->copy()->subDays(3)->subHours(5),
                'active_since' => Carbon::parse('2026-10-26'),
            ]);
            Message::create([
                'conversation_id' => $c7->id,
                'sender_type' => 'customer',
                'sender_name' => 'Rahul Joshi',
                'message' => 'Please check the order status of my product. It is still showing processing.',
                'is_read' => true,
                'created_at' => $baseDate->copy()->subDays(3)->subHours(5),
            ]);

            // 8. Priya Singh
            $c8 = Conversation::create([
                'seller_id' => $seller->id,
                'customer_name' => 'Priya Singh',
                'customer_email' => 'priya.singh@gmail.com',
                'customer_phone' => '+91 97123 45678',
                'customer_avatar' => 'https://images.unsplash.com/photo-1517841905240-472988babdf9?auto=format&fit=crop&w=200&q=80',
                'customer_city' => 'Ahmedabad, Gujarat',
                'customer_online_status' => 'Offline',
                'subject_title' => 'Video Player Technical Support',
                'subject_type' => 'Technical Support',
                'subject_thumbnail' => 'https://images.unsplash.com/photo-1498050108023-c5249f4df085?auto=format&fit=crop&w=120&q=80',
                'category' => 'support',
                'status' => 'In Progress',
                'total_messages' => 9,
                'unread_count' => 0,
                'last_message' => "I'm facing an issue with the video playback. Can you help?",
                'last_message_at' => $baseDate->copy()->subDays(4),
                'active_since' => Carbon::parse('2026-10-25'),
            ]);
            Message::create([
                'conversation_id' => $c8->id,
                'sender_type' => 'customer',
                'sender_name' => 'Priya Singh',
                'message' => "I'm facing an issue with the video playback on lesson 4. Can you help?",
                'is_read' => true,
                'created_at' => $baseDate->copy()->subDays(4),
            ]);

            // 9. Karan Mehta (Orders)
            $c9 = Conversation::create([
                'seller_id' => $seller->id,
                'customer_name' => 'Karan Mehta',
                'customer_email' => 'karan.mehta@studio.com',
                'customer_phone' => '+91 98244 55667',
                'customer_avatar' => 'https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?auto=format&fit=crop&w=200&q=80',
                'customer_city' => 'Delhi',
                'customer_online_status' => 'Offline',
                'subject_title' => 'Logo Design Standard Package (Order #DC12563)',
                'subject_type' => 'Service Order',
                'subject_thumbnail' => 'https://images.unsplash.com/photo-1626785774573-4b799315345d?auto=format&fit=crop&w=120&q=80',
                'category' => 'orders',
                'status' => 'In Progress',
                'total_messages' => 11,
                'unread_count' => 0,
                'last_message' => 'Uploaded the brand style guide and reference colors.',
                'last_message_at' => $baseDate->copy()->subDays(5),
                'active_since' => Carbon::parse('2026-10-24'),
            ]);
            Message::create([
                'conversation_id' => $c9->id,
                'sender_type' => 'customer',
                'sender_name' => 'Karan Mehta',
                'message' => 'Uploaded the brand style guide and reference colors for our company logo.',
                'is_read' => true,
                'created_at' => $baseDate->copy()->subDays(5),
            ]);

            // 10. Sunita Sharma (Orders)
            $c10 = Conversation::create([
                'seller_id' => $seller->id,
                'customer_name' => 'Sunita Sharma',
                'customer_email' => 'sunita.sharma@gmail.com',
                'customer_phone' => '+91 99130 11224',
                'customer_avatar' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=200&q=80',
                'customer_city' => 'Mumbai, MH',
                'customer_online_status' => 'Offline',
                'subject_title' => 'Python for Beginners (Order #DC12564)',
                'subject_type' => 'Course Order',
                'subject_thumbnail' => 'https://images.unsplash.com/photo-1526374965328-7f61d4dc18c5?auto=format&fit=crop&w=120&q=80',
                'category' => 'orders',
                'status' => 'Resolved',
                'total_messages' => 5,
                'unread_count' => 0,
                'last_message' => 'Payment completed successfully. Thank you!',
                'last_message_at' => $baseDate->copy()->subDays(6),
                'active_since' => Carbon::parse('2026-10-23'),
            ]);
            Message::create([
                'conversation_id' => $c10->id,
                'sender_type' => 'customer',
                'sender_name' => 'Sunita Sharma',
                'message' => 'Payment completed successfully for Python Course. Thank you!',
                'is_read' => true,
                'created_at' => $baseDate->copy()->subDays(6),
            ]);

            // 11. Rohit Verma (Inquiries)
            $c11 = Conversation::create([
                'seller_id' => $seller->id,
                'customer_name' => 'Rohit Verma',
                'customer_email' => 'rohit.verma@techsolutions.in',
                'customer_phone' => '+91 98255 33441',
                'customer_avatar' => 'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?auto=format&fit=crop&w=200&q=80',
                'customer_city' => 'Rajkot, GJ',
                'customer_online_status' => 'Offline',
                'subject_title' => 'Business Listing Premium Plan (Order #DC12565)',
                'subject_type' => 'Business Profile Verification',
                'subject_thumbnail' => 'https://images.unsplash.com/photo-1497366216548-37526070297c?auto=format&fit=crop&w=120&q=80',
                'category' => 'inquiries',
                'status' => 'Resolved',
                'total_messages' => 6,
                'unread_count' => 0,
                'last_message' => 'Sent business registration documents for verification.',
                'last_message_at' => $baseDate->copy()->subDays(7),
                'active_since' => Carbon::parse('2026-10-22'),
            ]);
            Message::create([
                'conversation_id' => $c11->id,
                'sender_type' => 'customer',
                'sender_name' => 'Rohit Verma',
                'message' => 'Sent business registration documents for verification of our IT center listing.',
                'is_read' => true,
                'created_at' => $baseDate->copy()->subDays(7),
            ]);

            // 12. Raj Malhotra (Support)
            $c12 = Conversation::create([
                'seller_id' => $seller->id,
                'customer_name' => 'Raj Malhotra',
                'customer_email' => 'raj.malhotra@gmail.com',
                'customer_phone' => '+91 98240 88990',
                'customer_avatar' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?auto=format&fit=crop&w=200&q=80',
                'customer_city' => 'Pune, MH',
                'customer_online_status' => 'Offline',
                'subject_title' => 'Laptop Stand Adjustable (Order #DC12559)',
                'subject_type' => 'Delivery Support',
                'subject_thumbnail' => 'https://images.unsplash.com/photo-1527864550417-7fd91fc51a46?auto=format&fit=crop&w=120&q=80',
                'category' => 'support',
                'status' => 'Resolved',
                'total_messages' => 4,
                'unread_count' => 0,
                'last_message' => 'Product received in great condition, thank you!',
                'last_message_at' => $baseDate->copy()->subDays(8),
                'active_since' => Carbon::parse('2026-10-20'),
            ]);
            Message::create([
                'conversation_id' => $c12->id,
                'sender_type' => 'customer',
                'sender_name' => 'Raj Malhotra',
                'message' => 'Product received in great condition, thank you for fast dispatch!',
                'is_read' => true,
                'created_at' => $baseDate->copy()->subDays(8),
            ]);
        }
    }
}

