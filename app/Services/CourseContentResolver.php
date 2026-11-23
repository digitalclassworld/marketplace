<?php

namespace App\Services;

use Illuminate\Support\Str;

class CourseContentResolver
{
    /**
     * Parse structured sections and bulleted lecture items from a course description.
     */
    public static function parseSectionsFromDesc(string $desc): array
    {
        $lines = explode("\n", str_replace("\r", "", $desc));
        $sections = [];
        $currentSection = null;
        $currentItems = [];

        foreach ($lines as $line) {
            $trimmed = trim($line);
            if (empty($trimmed)) continue;

            // Bullet items (- item, * item, • item, > item)
            if (preg_match('/^[\-\*\•\·\>]\s*(.+)/u', $trimmed, $m)) {
                $itemTitle = trim($m[1]);
                if ($currentSection === null) {
                    $currentSection = 'Course Overview';
                }
                $currentItems[] = $itemTitle;
            } elseif (preg_match('/^\d+[\.\)]\s*(.+)/', $trimmed, $m)) {
                $itemTitle = trim($m[1]);
                // If the numbered line is short and looks like a header, start a new section
                if (strlen($itemTitle) < 40 && !str_contains($itemTitle, ':') && !str_contains($itemTitle, ' - ')) {
                    if ($currentSection !== null && !empty($currentItems)) {
                        $sections[] = ['title' => $currentSection, 'items' => $currentItems];
                        $currentItems = [];
                    }
                    $currentSection = $itemTitle;
                } else {
                    if ($currentSection === null) {
                        $currentSection = 'Course Curriculum';
                    }
                    $currentItems[] = $itemTitle;
                }
            } else {
                // Non-bullet line: check if it's a section header followed by bullet items
                $isIntro = preg_match('/^(dear|welcome|this is|if you|we will|hello|hi|please|note|program\s|device\s|no\.?\s*of|lecture duration)/i', $trimmed);
                $hasColon = str_ends_with($trimmed, ':');
                $cleanHeader = rtrim($trimmed, ':');

                if (!$isIntro && strlen($cleanHeader) <= 65 && (!str_ends_with($trimmed, '.') || $hasColon)) {
                    if ($currentSection !== null && !empty($currentItems)) {
                        $sections[] = ['title' => $currentSection, 'items' => $currentItems];
                        $currentItems = [];
                    }
                    $currentSection = $cleanHeader;
                }
            }
        }

        if ($currentSection !== null && !empty($currentItems)) {
            $sections[] = ['title' => $currentSection, 'items' => $currentItems];
        }

        return $sections;
    }

    /**
     * Resolve dynamic, subject-specific course details: Overview, Topics (What Will You Learn),
     * Curriculum (Modules & Lectures), FAQs, Audience and Requirements.
     */
    public static function resolve(object $course): array
    {
        $title      = trim($course->title ?? $course->course_name ?? 'Online Course');
        $rawDesc    = $course->description ?? $course->course_desc ?? '';
        $desc       = trim(strip_tags($rawDesc));
        $category   = trim($course->category ?? 'General Education');
        $duration   = $course->duration ?? 'Self Paced';
        $chapters   = (int)($course->course_chapter ?? 0);
        $videos     = (int)($course->course_video ?? 0);
        $instructor = $course->instructor_name ?? 'Digital Class Instructor';

        $subLow = strtolower($title . ' ' . $category . ' ' . $desc);

        // First: attempt to parse real structured sections from the course description
        $parsedSections = self::parseSectionsFromDesc($rawDesc);

        $learningPoints = [];
        $curriculum = [];

        // ---------------------------------------------------------------------
        // CASE A: Description has 2 or more real structured sections (like course 1324)
        // In the original system, section headers become "What you'll learn" items!
        // ---------------------------------------------------------------------
        if (count($parsedSections) >= 2) {
            foreach ($parsedSections as $secIdx => $sec) {
                $cleanTitle = preg_replace('/^\d+[\.\)]\s*/', '', $sec['title']);
                $cleanTitle = trim($cleanTitle, " \t\n\r\0\x0B:-");
                if (!empty($cleanTitle)) {
                    $learningPoints[] = $cleanTitle;
                }

                $items = [];
                foreach ($sec['items'] as $itIdx => $it) {
                    $items[] = [
                        'title' => $it,
                        'duration' => sprintf('%02d:%02d', 8 + (($itIdx * 3) % 15), 15 + (($itIdx * 7) % 40)),
                        'preview' => ($secIdx === 0 && $itIdx === 0),
                    ];
                }

                $curriculum[] = [
                    'section' => ($secIdx + 1) . '. ' . $cleanTitle,
                    'lectures' => count($items) . ' Lectures',
                    'duration' => (count($items) * 11) . 'm',
                    'items' => $items,
                ];
            }
        } elseif (count($parsedSections) === 1 && count($parsedSections[0]['items']) >= 4) {
            // Case B: One section with multiple items (e.g. course 858: 13 bundled courses/modules)
            $learningPoints = array_slice($parsedSections[0]['items'], 0, 10);

            $chunked = array_chunk($parsedSections[0]['items'], 4);
            foreach ($chunked as $idx => $chunk) {
                $items = [];
                foreach ($chunk as $itIdx => $it) {
                    $items[] = [
                        'title' => $it,
                        'duration' => '12:00',
                        'preview' => ($idx === 0 && $itIdx === 0),
                    ];
                }
                $curriculum[] = [
                    'section' => ($idx + 1) . '. ' . ($chunk[0] ?? 'Module ' . ($idx + 1)),
                    'lectures' => count($items) . ' Lectures',
                    'duration' => (count($items) * 12) . 'm',
                    'items' => $items,
                ];
            }
        }

        // ---------------------------------------------------------------------
        // CASE C: Fallback to bullet point extraction or domain-specific generation
        // ---------------------------------------------------------------------
        if (empty($learningPoints)) {
            $lines = preg_split('/[\r\n]+/', $rawDesc);
            foreach ($lines as $line) {
                $line = trim(strip_tags($line));
                if (empty($line)) continue;

                if (preg_match('/^(program|device|language|contains|usage|validity|no\.?\s*of\s*lecture|lecture duration|encrypted)/i', $line)) {
                    continue;
                }

                if (preg_match('/^[\x{2022}\x{2023}\x{25E6}\x{2043}\x{2219}\*\-\•\·\>]\s*(.+)/u', $line, $m)) {
                    $pt = trim($m[1]);
                    if (strlen($pt) >= 10 && strlen($pt) <= 120 && !str_contains(strtolower($pt), 'http')) {
                        $learningPoints[] = $pt;
                    }
                } elseif (preg_match('/^\d+[\.\)]\s*(.+)/', $line, $m)) {
                    $pt = trim($m[1]);
                    if (strlen($pt) >= 10 && strlen($pt) <= 120 && !str_contains(strtolower($pt), 'http')) {
                        $learningPoints[] = $pt;
                    }
                }
            }
        }

        if (count($learningPoints) < 6) {
            $cleanTitle = preg_replace('/^(the|learn|master|complete|ultimate|guide to|training course for)\s+/i', '', $title);
            $cleanTitle = preg_replace('/[:\-\|].*$/', '', $cleanTitle);
            $subject = trim($cleanTitle);

            // Extract genuine sentences from description if available
            $sentences = preg_split('/[\.\!\?]+/', $desc);
            foreach ($sentences as $s) {
                $s = trim($s);
                if (strlen($s) >= 25 && strlen($s) <= 95 && !preg_match('/welcome|enroll|click|price|discount|guarantee|copyright|device|windows|encrypted/i', $s)) {
                    $learningPoints[] = ucfirst($s);
                    if (count($learningPoints) >= 4) break;
                }
            }

            // Subject-Specific Curated Learning Points
            if (str_contains($subLow, 'python')) {
                $learningPoints = array_merge($learningPoints, [
                    "Master core Python syntax, variables, data types and operator logic",
                    "Learn visual and animated problem-solving for difficult coding concepts",
                    "Control flow mastery: conditionals, nested loops, break and continue",
                    "Data structures: deep dive into lists, tuples, sets and dictionaries",
                    "Functions, modular code architecture and working with Python libraries",
                    "File handling, debugging techniques, error handling and clean code habits",
                    "Build functional real-world projects and automation scripts from scratch",
                    "Official verified course certificate to boost your developer portfolio"
                ]);
            } elseif (str_contains($subLow, 'shopify') || str_contains($subLow, 'ecommerce') || str_contains($subLow, 'dropshipping')) {
                $learningPoints = array_merge($learningPoints, [
                    "Setup and optimize a high-converting Shopify store from the ground up",
                    "Organic audience acquisition and building a loyal customer tribe",
                    "Winning product curation, high-margin pricing and branding strategy",
                    "Free traffic channels to scale your store without expensive paid ads",
                    "Customer retention, automated email winback sequences and referrals",
                    "Conversion rate optimization (CRO) and checkout friction removal",
                    "Order fulfillment, international shipping setup and scaling operations",
                    "Comprehensive step-by-step guidance from beginner to profitable brand"
                ]);
            } elseif (str_contains($subLow, 'java') || str_contains($subLow, 'spring') || str_contains($subLow, 'hibernate')) {
                $learningPoints = array_merge($learningPoints, [
                    "Core Java fundamentals, Object-Oriented Programming (OOP) and design patterns",
                    "Advanced OOP: inheritance, polymorphism, abstract classes and interfaces",
                    "Java Collections Framework: Lists, Sets, Maps, Iterators and Streams API",
                    "Web application development using Servlets, JSP and session management",
                    "Database connectivity with JDBC and MySQL relational integration",
                    "Spring Framework & Hibernate ORM enterprise architecture",
                    "Hands-on project development and enterprise coding best practices",
                    "Industry recognized Java developer certificate upon completion"
                ]);
            } elseif (str_contains($subLow, 'account') || str_contains($subLow, 'ca foundation') || str_contains($subLow, 'tally') || str_contains($subLow, 'gst') || str_contains($subLow, 'finance')) {
                $learningPoints = array_merge($learningPoints, [
                    "Core theoretical framework and fundamental principles of financial accounting",
                    "Step-by-step journal entries, ledger posting, trial balance and subsidiary books",
                    "Bank Reconciliation Statements (BRS) and cash book synchronization",
                    "Depreciation methods, inventory valuation and provisions accounting",
                    "Bills of exchange, consignment transactions and joint venture accounts",
                    "Preparation of final accounts for sole proprietors, firms and companies",
                    "Practical problem-solving aligned with standard examination patterns",
                    "Comprehensive exam revision notes and concept clarity modules"
                ]);
            } elseif (str_contains($subLow, 'hack') || str_contains($subLow, 'cyber') || str_contains($subLow, 'security') || str_contains($subLow, 'comptia') || str_contains($subLow, 'penetration')) {
                $learningPoints = array_merge($learningPoints, [
                    "Foundational concepts of network security, protocols and threat modeling",
                    "Hands-on penetration testing methodologies using Kali Linux tools",
                    "Web application vulnerability assessment and OWASP Top 10 mitigation",
                    "System reconnaissance, network scanning, port enumeration and exploitation",
                    "Cryptography, digital certificates, firewall rules and defensive hardening",
                    "Burp Suite, Wireshark, Metasploit and vulnerability scanner workflows",
                    "Bug bounty hunting techniques and responsible disclosure practices",
                    "Preparation pathway for industry-standard cybersecurity certifications"
                ]);
            } elseif (str_contains($subLow, 'wordpress') || str_contains($subLow, 'web develop') || str_contains($subLow, 'html') || str_contains($subLow, 'css') || str_contains($subLow, 'javascript')) {
                $learningPoints = array_merge($learningPoints, [
                    "Design, build and launch beautiful, modern responsive websites",
                    "Theme installation, customization and visual page builder mastery",
                    "Essential plugins for SEO, security, speed optimization and backups",
                    "E-commerce store creation with WooCommerce and payment gateways",
                    "Responsive web layout techniques for mobile, tablet and desktop displays",
                    "Client project workflow: domain setup, hosting, staging and launch",
                    "Website maintenance, troubleshooting common errors and speed tuning",
                    "Building a web design portfolio to land freelance clients and jobs"
                ]);
            } elseif (str_contains($subLow, 'biology') || str_contains($subLow, 'science') || str_contains($subLow, 'physics') || str_contains($subLow, 'chemistry') || str_contains($subLow, 'ncert') || str_contains($subLow, 'cbse')) {
                $learningPoints = array_merge($learningPoints, [
                    "Comprehensive chapter-by-chapter concept clarity based on NCERT / CBSE curriculum",
                    "Detailed anatomical diagrams, labeled process flows and scientific mechanisms",
                    "High-yield exam questions, conceptual derivations and chapter revision summaries",
                    "Life processes, control & coordination, reproduction, genetics and environment",
                    "Self-assessment checkpoints, objective quizzes and board-exam pattern questions",
                    "Structured downloadable study modules and quick-revision flashcards",
                    "Effective time-management and answering techniques for top exam marks",
                    "Complete syllabus coverage designed by experienced subject educators"
                ]);
            } elseif (str_contains($subLow, 'marketing') || str_contains($subLow, 'seo') || str_contains($subLow, 'social media')) {
                $learningPoints = array_merge($learningPoints, [
                    "Complete digital marketing strategy from foundational concepts to execution",
                    "Search Engine Optimization (SEO): keyword research, on-page, off-page and technical",
                    "Paid advertising campaigns across Google Ads, Meta Ads and YouTube",
                    "Social media growth strategies, content scheduling and community engagement",
                    "High-converting email marketing automation and customer lead funnels",
                    "AI tools integration to accelerate content creation and campaign analysis",
                    "Analytics, conversion tracking, ROI measurement and reporting dashboards",
                    "Verified Digital Class certification to showcase your digital marketing expertise"
                ]);
            } elseif (str_contains($subLow, 'english') || str_contains($subLow, 'spoken') || str_contains($subLow, 'communication')) {
                $learningPoints = array_merge($learningPoints, [
                    "Fluency building techniques for confident everyday and professional speaking",
                    "Grammar essentials: sentence construction, correct tenses and common error fixes",
                    "Vocabulary expansion: 500+ idioms, phrases and professional conversation starters",
                    "Pronunciation training, accent neutralization and active listening skills",
                    "Overcoming hesitation, public speaking anxiety and presentation confidence",
                    "Email etiquette, formal letter writing and workplace communication mastery",
                    "Interactive real-life dialogue practice and conversation simulations",
                    "Official speaking certification to validate your communication skills"
                ]);
            } else {
                $learningPoints = array_merge($learningPoints, [
                    "Comprehensive foundation and core principles of {$subject}",
                    "Practical application and real-world techniques used by experienced practitioners",
                    "Step-by-step guidance from introductory concepts to advanced execution",
                    "Hands-on exercises, downloadable resources and guided practice sessions",
                    "Time-tested frameworks and best practices to accelerate your learning curve",
                    "Problem-solving methodologies to tackle real challenges independently",
                    "Lifetime access to study material, updates and community learning support",
                    "Official digital completion certificate from Digital Class - Educational World"
                ]);
            }
        }
        $learningPoints = array_values(array_unique($learningPoints));

        // ---------------------------------------------------------------------
        // CURRICULUM FALLBACK (IF NOT ALREADY POPULATED VIA PARSED SECTIONS)
        // ---------------------------------------------------------------------
        if (empty($curriculum)) {
            // Check if database course has custom contents
            if (isset($course->contents) && $course->contents->isNotEmpty()) {
                foreach ($course->contents->groupBy('section_title') as $secTitle => $lectures) {
                    $curriculum[] = [
                        'section' => $secTitle,
                        'lectures' => $lectures->count() . ' Lectures',
                        'duration' => ($lectures->count() * 12) . 'm',
                        'items' => $lectures->map(fn($l) => [
                            'title' => $l->lecture_title,
                            'duration' => $l->duration ?: '10:00',
                            'preview' => (bool)$l->video_url,
                        ])->toArray(),
                    ];
                }
            }
        }

        if (empty($curriculum)) {
            if (str_contains($subLow, 'python')) {
                $curriculum = [
                    ['section' => '1. Course Orientation & Animated Coding Paradigm', 'lectures' => '4 Lectures', 'duration' => '32m', 'items' => [
                        ['title' => 'Welcome to Python with Animation: The 3-Layer Learning Model', 'duration' => '07:45', 'preview' => true],
                        ['title' => 'Installing Python & Configuring Your Development Environment', 'duration' => '10:20', 'preview' => true],
                        ['title' => 'Writing & Running Your First Python Script', 'duration' => '06:50', 'preview' => false],
                        ['title' => 'How Python Interprets Code Behind the Scenes', 'duration' => '07:15', 'preview' => false],
                    ]],
                    ['section' => '2. Core Syntax: Variables, Data Types & Operators', 'lectures' => '5 Lectures', 'duration' => '48m', 'items' => [
                        ['title' => 'Visualizing Strings, Integers, Floats & Booleans with Animation', 'duration' => '11:10', 'preview' => true],
                        ['title' => 'Arithmetic, Comparison and Logical Operators Explained', 'duration' => '08:40', 'preview' => false],
                        ['title' => 'User Input Handling and Type Casting', 'duration' => '09:20', 'preview' => false],
                        ['title' => 'String Formatting (f-strings) and Built-In Methods', 'duration' => '09:50', 'preview' => false],
                        ['title' => 'Hands-on Practice: Building an Interactive Calculator', 'duration' => '09:10', 'preview' => false],
                    ]],
                    ['section' => '3. Control Flow: Logic Building with Conditions & Loops', 'lectures' => '6 Lectures', 'duration' => '54m', 'items' => [
                        ['title' => 'If-Else Conditionals: Making Decisions in Python', 'duration' => '10:15', 'preview' => false],
                        ['title' => 'Nested Conditionals and Elif Statements with Visual Decision Trees', 'duration' => '08:45', 'preview' => false],
                        ['title' => 'For Loops: Iterating Over Sequences and Ranges', 'duration' => '09:30', 'preview' => false],
                        ['title' => 'While Loops: Loop Control, Break and Continue Keywords', 'duration' => '11:20', 'preview' => false],
                        ['title' => 'Coding Exercise: Automated Number Guessing Game', 'duration' => '14:10', 'preview' => false],
                    ]],
                    ['section' => '4. Data Structures: Lists, Tuples, Dictionaries & Sets', 'lectures' => '6 Lectures', 'duration' => '1h 02m', 'items' => [
                        ['title' => 'Python Lists: Indexing, Slicing, Appending and Sorting', 'duration' => '12:45', 'preview' => false],
                        ['title' => 'Tuples vs Lists: Immutability and Memory Optimization', 'duration' => '08:15', 'preview' => false],
                        ['title' => 'Dictionaries: Key-Value Mapping and Data Lookup', 'duration' => '13:20', 'preview' => false],
                        ['title' => 'Sets: Mathematical Set Operations and Deduplication', 'duration' => '09:10', 'preview' => false],
                        ['title' => 'List Comprehensions for Clean, Idiomatic Python Code', 'duration' => '08:40', 'preview' => false],
                        ['title' => 'Project: Student Database & Grade Calculator', 'duration' => '10:10', 'preview' => false],
                    ]],
                    ['section' => '5. Functions, Modules & Real-World Capstone Project', 'lectures' => '5 Lectures', 'duration' => '50m', 'items' => [
                        ['title' => 'Defining Functions with Parameters, Return Values and Variable Scope', 'duration' => '11:30', 'preview' => false],
                        ['title' => 'Standard Library Modules: math, random, datetime and os', 'duration' => '09:45', 'preview' => false],
                        ['title' => 'File Handling: Reading and Writing Text and CSV Files', 'duration' => '11:15', 'preview' => false],
                        ['title' => 'Final Capstone Project: End-to-End Program Walkthrough', 'duration' => '17:30', 'preview' => false],
                    ]],
                ];
            } elseif (str_contains($subLow, 'shopify') || str_contains($subLow, 'ecommerce')) {
                $curriculum = [
                    ['section' => '1. The Shopify Sales Machine Framework', 'lectures' => '4 Lectures', 'duration' => '36m', 'items' => [
                        ['title' => 'Overview: The 3 Pillars of a Predictable Shopify Machine', 'duration' => '08:10', 'preview' => true],
                        ['title' => 'Store Architecture: Selecting & Configuring High-Converting Themes', 'duration' => '11:30', 'preview' => true],
                        ['title' => 'Designing Frictionless Product Pages That Drive Add-to-Cart', 'duration' => '09:40', 'preview' => false],
                        ['title' => 'Payment Gateways, Tax Rules and Currency Setup', 'duration' => '07:15', 'preview' => false],
                    ]],
                    ['section' => '2. Building Your Tribe & Organic Customer Loyalty', 'lectures' => '5 Lectures', 'duration' => '48m', 'items' => [
                        ['title' => 'What is Brand Tribe Building and Why Paid Ads Alone Fail', 'duration' => '09:30', 'preview' => true],
                        ['title' => 'Developing Your Irresistible Brand Story & Value Proposition', 'duration' => '10:15', 'preview' => false],
                        ['title' => 'Building Engaged Social Media Communities around Your Niche', 'duration' => '11:45', 'preview' => false],
                        ['title' => 'Creating VIP Customer Clubs & Automated Referral Reward Loops', 'duration' => '10:10', 'preview' => false],
                        ['title' => 'Case Study: How Organic Tribe Building Generated 6-Figure Sales', 'duration' => '07:10', 'preview' => false],
                    ]],
                    ['section' => '3. Zero-Cost Free Traffic Engine', 'lectures' => '5 Lectures', 'duration' => '45m', 'items' => [
                        ['title' => 'Content Marketing Blueprint for E-Commerce Products', 'duration' => '08:45', 'preview' => false],
                        ['title' => 'Short-Form Video Strategy (Reels & TikTok) for Viral Product Reach', 'duration' => '11:20', 'preview' => false],
                        ['title' => 'Micro-Influencer Gifting Partnerships Without Upfront Cash', 'duration' => '10:50', 'preview' => false],
                        ['title' => 'Shopify SEO Fundamentals to Rank Organically on Google', 'duration' => '14:10', 'preview' => false],
                    ]],
                    ['section' => '4. Retention, Upsells & Scaling Lifetime Value', 'lectures' => '4 Lectures', 'duration' => '42m', 'items' => [
                        ['title' => 'Automated Abandoned Cart Sequences That Recover 15%+ Lost Sales', 'duration' => '11:15', 'preview' => false],
                        ['title' => 'Post-Purchase 1-Click Upsells and Average Order Value (AOV) Boosters', 'duration' => '10:40', 'preview' => false],
                        ['title' => 'Customer Lifecycle Email Flows: Welcome, Post-Purchase & Re-engagement', 'duration' => '12:30', 'preview' => false],
                        ['title' => 'Scaling Roadmap: Automating Operations and Next Steps', 'duration' => '08:00', 'preview' => false],
                    ]],
                ];
            } else {
                $cleanSub = preg_replace('/^(the|learn|master|complete|ultimate|guide to)\s+/i', '', $title);
                $cleanSub = preg_replace('/[:\-\|].*$/', '', $cleanSub);
                $sub = trim($cleanSub);

                $curriculum = [
                    ['section' => "1. Foundations & Overview of {$sub}", 'lectures' => '4 Lectures', 'duration' => '35m', 'items' => [
                        ['title' => "Welcome to {$title}: Learning Roadmap & Outcomes", 'duration' => '07:15', 'preview' => true],
                        ['title' => "Core Principles, Terminology and Essential Tools", 'duration' => '10:30', 'preview' => true],
                        ['title' => "Setting Up Your Workspace and Study Resources", 'duration' => '08:45', 'preview' => false],
                        ['title' => "Foundational Concepts Every Practitioner Must Know", 'duration' => '09:10', 'preview' => false],
                    ]],
                    ['section' => "2. Core Frameworks & Practical Implementation", 'lectures' => '5 Lectures', 'duration' => '50m', 'items' => [
                        ['title' => "Step-by-Step Breakdown of Key Methodologies", 'duration' => '11:20', 'preview' => false],
                        ['title' => "Detailed Guided Examples and Practical Demonstrations", 'duration' => '12:15', 'preview' => false],
                        ['title' => "Deep Dive into Fundamental Components and Operations", 'duration' => '10:40', 'preview' => false],
                        ['title' => "Common Pitfalls to Avoid and Industry Best Practices", 'duration' => '08:50', 'preview' => false],
                        ['title' => "Hands-on Exercise with Instructor Guidance", 'duration' => '07:35', 'preview' => false],
                    ]],
                    ['section' => "3. Intermediate Techniques & Case Studies", 'lectures' => '4 Lectures', 'duration' => '46m', 'items' => [
                        ['title' => "Real-World Case Study Analysis and Problem Solving", 'duration' => '12:40', 'preview' => false],
                        ['title' => "Efficiency Shortcuts and Pro Techniques for Best Results", 'duration' => '11:15', 'preview' => false],
                        ['title' => "Troubleshooting, Optimization and Refinement Workflows", 'duration' => '12:30', 'preview' => false],
                        ['title' => "Interactive Review of Practical Project Deliverables", 'duration' => '09:55', 'preview' => false],
                    ]],
                    ['section' => "4. Advanced Strategies & Final Capstone Project", 'lectures' => '4 Lectures', 'duration' => '45m', 'items' => [
                        ['title' => "Advanced Frameworks and Future Trends in {$category}", 'duration' => '12:10', 'preview' => false],
                        ['title' => "Full Project Execution from Strategy to Completion", 'duration' => '15:30', 'preview' => false],
                        ['title' => "Comprehensive Knowledge Check and Summary Points", 'duration' => '09:40', 'preview' => false],
                        ['title' => "Next Steps, Career Pathways and Verified Certificate", 'duration' => '08:00', 'preview' => false],
                    ]],
                ];
            }
        }

        // ---------------------------------------------------------------------
        // 3. FAQS (FREQUENTLY ASKED QUESTIONS)
        // ---------------------------------------------------------------------
        $cleanSub = preg_replace('/^(the|learn|master|complete|ultimate|guide to)\s+/i', '', $title);
        $cleanSub = preg_replace('/[:\-\|].*$/', '', $cleanSub);
        $sub = trim($cleanSub);

        $faqs = [
            [
                'q' => "How do I access \"{$title}\" after enrollment?",
                'a' => "You will receive instant lifetime access immediately after checkout. You can log in anytime to your Digital Class student account and access all video lessons, project files, and study resources on your computer, laptop, tablet, or smartphone."
            ],
            [
                'q' => "Are there any prerequisites or prior experience required?",
                'a' => "No prior advanced experience is necessary unless specifically noted. The course is structured progressively from fundamentals to advanced concepts, making it accessible to beginners while providing valuable insights for experienced learners."
            ],
            [
                'q' => "Will I receive an official certificate upon course completion?",
                'a' => "Yes! Once you complete all the lessons and course modules, you will be issued an official verified Digital Class Certificate of Completion. You can download the PDF, share it on LinkedIn, or attach it to your resume."
            ],
            [
                'q' => "Is this course self-paced or does it follow a fixed schedule?",
                'a' => "This is a 100% self-paced online course. You can study whenever it fits your schedule, pause and replay complex sections as many times as you want, with no deadlines or expiry dates."
            ],
            [
                'q' => "How can I ask questions if I get stuck while learning?",
                'a' => "You can post your queries directly in the course Q&A discussion tab. The course educator and academic support team actively review and respond to student inquiries to ensure you never get stuck."
            ],
            [
                'q' => "What is the refund policy for this course?",
                'a' => "Digital Class offers a 30-day satisfaction guarantee. If the course does not meet your expectations, simply reach out to our customer support within 30 days of purchase for a prompt refund."
            ],
        ];

        // ---------------------------------------------------------------------
        // 4. TARGET AUDIENCE & REQUIREMENTS
        // ---------------------------------------------------------------------
        $targetAudience = [
            "Students and beginners eager to build practical expertise in {$sub}",
            "Working professionals aiming to upgrade their skills in {$category}",
            "Freelancers, entrepreneurs and creators wanting actionable knowledge",
            "Anyone seeking an industry-recognized certification to boost their career",
        ];

        $requirements = [
            "A desktop computer, laptop, tablet or smartphone with internet connection",
            "Basic computer familiarity and a desire to learn new practical skills",
            "No prior advanced experience required; all core principles are taught step-by-step",
        ];

        return [
            'learningPoints' => $learningPoints,
            'curriculum'     => $curriculum,
            'faqs'           => $faqs,
            'targetAudience' => $targetAudience,
            'requirements'   => $requirements,
        ];
    }
}
