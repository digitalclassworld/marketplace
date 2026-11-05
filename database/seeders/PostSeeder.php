<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\PostComment;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Technology', 'slug' => 'technology', 'count' => 42],
            ['name' => 'Business',   'slug' => 'business',   'count' => 38],
            ['name' => 'Marketing',  'slug' => 'marketing',  'count' => 36],
            ['name' => 'Education',  'slug' => 'education',  'count' => 32],
            ['name' => 'Career',     'slug' => 'career',     'count' => 28],
            ['name' => 'Software',   'slug' => 'software',   'count' => 22],
            ['name' => 'Teaching',   'slug' => 'teaching',   'count' => 18],
            ['name' => 'Offers',     'slug' => 'offers',     'count' => 16],
            ['name' => 'Trends',     'slug' => 'trends',     'count' => 14],
            ['name' => 'Others',     'slug' => 'others',     'count' => 10],
        ];

        foreach ($categories as $cat) {
            Category::updateOrCreate(['slug' => $cat['slug']], $cat);
        }

        $posts = [
            [
                'title'            => 'Top 10 AI Tools for Students in 2026',
                'slug'             => 'top-10-ai-tools-for-students-2026',
                'excerpt'          => 'Discover the best AI tools that can help students learn faster, create better content and improve productivity in 2026.',
                'content'          => "<p>Artificial Intelligence is changing the way students learn, research and create. In 2026, there are many powerful AI tools that can save time, improve productivity and help you achieve better results.</p>
<p>In this blog, we will explore the Top 10 AI tools for students that are easy to use and can make your study journey smarter.</p>
<h2>1. ChatGPT & Claude 3.5 for Smart Research</h2>
<p>Modern AI chatbots allow students to understand complex academic topics, summarize research papers, and brainstorm project outlines in seconds.</p>
<h2>2. Notion AI for Smart Note-Taking</h2>
<p>Keep your entire syllabus, lecture notes, and assignments organized with automated summaries and action items.</p>
<h2>3. Canva Magic Studio for Presentations</h2>
<p>Create visual slides and academic infographics without needing advanced graphic design skills.</p>
<h2>4. Grammarly & QuillBot for Academic Writing</h2>
<p>Refine your essays, eliminate grammatical errors, and ensure clarity in your written assignments.</p>
<h2>5. Perplexity AI for Accurate Sourced Citations</h2>
<p>Unlike standard search engines, Perplexity provides concise summaries with direct academic references and citations.</p>",
                'featured_image'   => 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=1200&auto=format&fit=crop&q=80',
                'type'             => 'Blog',
                'category'         => 'Technology',
                'author_name'      => 'Hitesh Mohkar',
                'author_avatar'    => 'https://ui-avatars.com/api/?name=Hitesh+Mohkar&background=0066ff&color=fff',
                'author_role'      => 'Super Admin',
                'views'            => 12450,
                'status'           => 'Published',
                'published_at'     => '2026-10-28 10:30:00',
                'allow_comments'   => true,
                'is_featured'      => true,
                'tags'             => ['AI', 'Students', 'Education', 'Productivity', 'Tools'],
                'meta_title'       => 'Top 10 AI Tools for Students in 2026 | Digital Class',
                'meta_description' => 'Explore the best AI tools for students in 2026. Learn how these tools can help you study better, create content, and improve productivity.',
                'focus_keyword'    => 'AI tools for students',
                'comments'         => [
                    [
                        'name'    => 'Priya Patel',
                        'email'   => 'priya.patel@gmail.com',
                        'comment' => 'Incredible article! Perplexity and Notion AI have completely transformed my semester exam preparation.',
                    ],
                    [
                        'name'    => 'Rahul Sharma',
                        'email'   => 'rahul.sharma@gmail.com',
                        'comment' => 'Very practical breakdown. Could you also do a post on AI coding tools for computer science students?',
                    ],
                ],
            ],
            [
                'title'            => 'How to Start a Computer Institute in 2026',
                'slug'             => 'start-computer-institute-2026',
                'excerpt'          => 'Step by step roadmap to set up a profitable computer training institute with modern lab infrastructure and accredited certifications.',
                'content'          => "<p>Starting a computer education center requires strategic planning, proper software affiliations, and hands-on laboratory infrastructure.</p><p>Explore licensing, course curriculum design, and digital marketing strategies to attract your first 100 students.</p>",
                'featured_image'   => 'https://images.unsplash.com/photo-1531482615713-2afd69097998?w=800&auto=format&fit=crop&q=80',
                'type'             => 'Blog',
                'category'         => 'Business',
                'author_name'      => 'Manish Patel',
                'author_avatar'    => 'https://ui-avatars.com/api/?name=Manish+Patel&background=ea580c&color=fff',
                'author_role'      => 'Content Editor',
                'views'            => 9820,
                'status'           => 'Published',
                'published_at'     => '2026-10-26 16:15:00',
                'allow_comments'   => true,
                'is_featured'      => false,
                'tags'             => ['Institute', 'Business', 'Startup', 'Education'],
                'meta_title'       => 'How to Start a Computer Institute in 2026 | Digital Class',
                'meta_description' => 'Complete guide on opening a successful computer training center.',
                'focus_keyword'    => 'Start computer institute',
            ],
            [
                'title'            => 'Digital Marketing Career Guide for Beginners',
                'slug'             => 'digital-marketing-career-guide',
                'excerpt'          => 'Everything you need to know to launch a high-paying career in SEO, social media marketing, and paid performance advertising.',
                'content'          => "<p>Digital marketing continues to be one of the highest growth industries. Discover the core skills required: Google Ads, Meta Ads, SEO copywriting, and performance data analytics.</p>",
                'featured_image'   => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=800&auto=format&fit=crop&q=80',
                'type'             => 'Blog',
                'category'         => 'Marketing',
                'author_name'      => 'Prakash Shah',
                'author_avatar'    => 'https://ui-avatars.com/api/?name=Prakash+Shah&background=10b981&color=fff',
                'author_role'      => 'Marketing Lead',
                'views'            => 8540,
                'status'           => 'Published',
                'published_at'     => '2026-10-24 11:20:00',
                'allow_comments'   => true,
                'is_featured'      => false,
                'tags'             => ['Marketing', 'Career', 'SEO', 'Ads'],
                'meta_title'       => 'Digital Marketing Career Guide for Beginners | Digital Class',
                'meta_description' => 'Learn how to become a certified digital marketer in 2026.',
                'focus_keyword'    => 'Digital marketing career',
            ],
            [
                'title'            => 'Online vs Offline Classes - Which is Better?',
                'slug'             => 'online-vs-offline-classes',
                'excerpt'          => 'Comparing flexibility, retention rates, practical lab access, and mentorship between online learning and offline classrooms.',
                'content'          => "<p>The debate between classroom learning and remote courses continues. In this analysis, we evaluate cost, hands-on faculty interaction, and scheduling flexibility.</p>",
                'featured_image'   => 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=800&auto=format&fit=crop&q=80',
                'type'             => 'Blog',
                'category'         => 'Education',
                'author_name'      => 'Tushar Mehta',
                'author_avatar'    => 'https://ui-avatars.com/api/?name=Tushar+Mehta&background=8b5cf6&color=fff',
                'author_role'      => 'Academic Consultant',
                'views'            => 6920,
                'status'           => 'Draft',
                'published_at'     => null,
                'allow_comments'   => true,
                'is_featured'      => false,
                'tags'             => ['Education', 'Online Classes', 'Learning'],
                'meta_title'       => 'Online vs Offline Classes Comparison',
                'meta_description' => 'Detailed study on student outcomes in online vs offline courses.',
                'focus_keyword'    => 'Online vs offline classes',
            ],
            [
                'title'            => 'Top 5 Skills to Get a Job in 2026',
                'slug'             => 'top-5-skills-job-2026',
                'excerpt'          => 'The top 5 in-demand technical and soft skills tech recruiters and multinational enterprises are looking for this year.',
                'content'          => "<p>Employers are placing a premium on candidates who can combine AI literacy with full-stack development, cloud computing, cyber hygiene, and critical problem solving.</p>",
                'featured_image'   => 'https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?w=800&auto=format&fit=crop&q=80',
                'type'             => 'Blog',
                'category'         => 'Career',
                'author_name'      => 'Hitesh Mohkar',
                'author_avatar'    => 'https://ui-avatars.com/api/?name=Hitesh+Mohkar&background=0066ff&color=fff',
                'author_role'      => 'Super Admin',
                'views'            => 5430,
                'status'           => 'Published',
                'published_at'     => '2026-10-20 09:45:00',
                'allow_comments'   => true,
                'is_featured'      => false,
                'tags'             => ['Career', 'Jobs', 'Skills', 'Tech'],
                'meta_title'       => 'Top 5 Skills to Get a Job in 2026',
                'meta_description' => 'Discover the top technical skills to guarantee placements.',
                'focus_keyword'    => 'Top skills for jobs 2026',
            ],
            [
                'title'            => 'How Institute Management Software Helps Grow Your Institute',
                'slug'             => 'institute-erp-benefits',
                'excerpt'          => 'Automating fee receipts, batch schedules, student attendance, and parent communication with unified Institute ERP.',
                'content'          => "<p>Coaching centers and schools lose dozens of administrative hours weekly to manual spreadsheets. Learn how automated ERP platforms scale institute capacity effortlessly.</p>",
                'featured_image'   => 'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?w=800&auto=format&fit=crop&q=80',
                'type'             => 'Blog',
                'category'         => 'Software',
                'author_name'      => 'Manish Patel',
                'author_avatar'    => 'https://ui-avatars.com/api/?name=Manish+Patel&background=ea580c&color=fff',
                'author_role'      => 'Content Editor',
                'views'            => 4980,
                'status'           => 'Scheduled',
                'published_at'     => '2026-11-02 10:00:00',
                'allow_comments'   => true,
                'is_featured'      => false,
                'tags'             => ['ERP', 'Software', 'Automation'],
                'meta_title'       => 'Benefits of Institute Management Software',
                'meta_description' => 'Why every modern coaching center needs unified ERP management.',
                'focus_keyword'    => 'Institute management software',
            ],
            [
                'title'            => 'Free AI Tools for Teachers',
                'slug'             => 'free-ai-tools-teachers',
                'excerpt'          => 'Streamline lesson planning, generate custom student quizzes, and automate grading with these 5 free AI platforms.',
                'content'          => "<p>Teachers can now reclaim their evenings by utilizing automated question generator tools, rubric checkers, and smart presentation builders designed specifically for educators.</p>",
                'featured_image'   => 'https://images.unsplash.com/photo-1580582932707-520aed937b7b?w=800&auto=format&fit=crop&q=80',
                'type'             => 'Blog',
                'category'         => 'Teaching',
                'author_name'      => 'Neha Shah',
                'author_avatar'    => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=100&auto=format&fit=crop&q=80',
                'author_role'      => 'Educator Partner',
                'views'            => 4210,
                'status'           => 'Published',
                'published_at'     => '2026-10-18 15:10:00',
                'allow_comments'   => true,
                'is_featured'      => false,
                'tags'             => ['Teaching', 'AI', 'Classroom'],
                'meta_title'       => 'Free AI Tools for Teachers | Digital Class',
                'meta_description' => 'Empower your teaching with automated lesson planning tools.',
                'focus_keyword'    => 'AI tools for teachers',
            ],
            [
                'title'            => 'Diwali Special: Best Online Courses with Discount',
                'slug'             => 'diwali-special-online-courses',
                'excerpt'          => 'Grab up to 50% flat discount across full-stack coding, data analytics, graphic design, and spoken English courses.',
                'content'          => "<p>Celebrate this festival of lights by investing in career growth. Use code DIWALI50 during checkout to unlock special holiday bundle discounts on all top-rated programs.</p>",
                'featured_image'   => 'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=800&auto=format&fit=crop&q=80',
                'type'             => 'Blog',
                'category'         => 'Offers',
                'author_name'      => 'Prakash Shah',
                'author_avatar'    => 'https://ui-avatars.com/api/?name=Prakash+Shah&background=10b981&color=fff',
                'author_role'      => 'Marketing Lead',
                'views'            => 3980,
                'status'           => 'Published',
                'published_at'     => '2026-10-16 12:25:00',
                'allow_comments'   => true,
                'is_featured'      => false,
                'tags'             => ['Offers', 'Diwali', 'Discount', 'Courses'],
                'meta_title'       => 'Diwali Special Online Course Discounts',
                'meta_description' => 'Save up to 50% on top accredited online courses.',
                'focus_keyword'    => 'Online course discounts',
            ],
            [
                'title'            => 'How to Choose the Right Course After 10th and 12th',
                'slug'             => 'choose-right-course-10th-12th',
                'excerpt'          => 'A practical career counseling roadmap for students deciding between polytechnic, coding diplomas, medical, and commerce streams.',
                'content'          => "<p>Choosing your academic path after school sets the trajectory of your professional career. Here is our expert guide on matching student aptitudes with market demand.</p>",
                'featured_image'   => 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=800&auto=format&fit=crop&q=80',
                'type'             => 'Blog',
                'category'         => 'Career',
                'author_name'      => 'Tushar Mehta',
                'author_avatar'    => 'https://ui-avatars.com/api/?name=Tushar+Mehta&background=8b5cf6&color=fff',
                'author_role'      => 'Academic Consultant',
                'views'            => 3450,
                'status'           => 'Published',
                'published_at'     => '2026-10-14 17:20:00',
                'allow_comments'   => true,
                'is_featured'      => false,
                'tags'             => ['Career', 'Students', 'Counseling'],
                'meta_title'       => 'How to Choose Course After 10th and 12th',
                'meta_description' => 'Comprehensive career counseling guide for school graduates.',
                'focus_keyword'    => 'Courses after 10th and 12th',
            ],
            [
                'title'            => 'Future of AI in Education',
                'slug'             => 'future-of-ai-in-education',
                'excerpt'          => 'From hyper-personalized tutor bots to automated grading: how artificial intelligence will shape classroom learning by 2030.',
                'content'          => "<p>Adaptive learning technologies are evolving rapidly. Discover how neural learning models will personalize learning speeds for every child globally.</p>",
                'featured_image'   => 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=800&auto=format&fit=crop&q=80',
                'type'             => 'Blog',
                'category'         => 'Trends',
                'author_name'      => 'Hitesh Mohkar',
                'author_avatar'    => 'https://ui-avatars.com/api/?name=Hitesh+Mohkar&background=0066ff&color=fff',
                'author_role'      => 'Super Admin',
                'views'            => 2980,
                'status'           => 'Published',
                'published_at'     => '2026-10-12 11:40:00',
                'allow_comments'   => true,
                'is_featured'      => false,
                'tags'             => ['AI', 'EdTech', 'Trends', 'Future'],
                'meta_title'       => 'Future of AI in Education | Digital Class',
                'meta_description' => 'Trends and predictions for AI in education by 2030.',
                'focus_keyword'    => 'Future of AI in education',
            ],
        ];

        foreach ($posts as $p) {
            $comments = $p['comments'] ?? [];
            unset($p['comments']);

            $post = Post::updateOrCreate(['slug' => $p['slug']], $p);

            if ($post->comments()->count() === 0 && count($comments) > 0) {
                foreach ($comments as $c) {
                    $post->comments()->create($c);
                }
            }
        }
    }
}

