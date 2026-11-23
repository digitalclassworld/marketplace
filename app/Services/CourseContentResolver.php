<?php

namespace App\Services;

use Illuminate\Support\Str;

class CourseContentResolver
{
    /**
     * Resolve dynamic, subject-specific course details: Overview, Topics (What Will You Learn),
     * Curriculum (Modules & Lectures), FAQs, Audience and Requirements.
     */
    public static function resolve(object $course): array
    {
        $title      = trim($course->title ?? $course->course_name ?? 'Online Course');
        $desc       = trim(strip_tags($course->description ?? $course->course_desc ?? ''));
        $category   = trim($course->category ?? 'General Education');
        $duration   = $course->duration ?? 'Self Paced';
        $chapters   = (int)($course->course_chapter ?? 0);
        $videos     = (int)($course->course_video ?? 0);
        $instructor = $course->instructor_name ?? 'Digital Class Instructor';

        $subLow = strtolower($title . ' ' . $category . ' ' . $desc);

        // ---------------------------------------------------------------------
        // 1. TOPICS ("WHAT WILL YOU LEARN?")
        // ---------------------------------------------------------------------
        $learningPoints = [];

        // Check for bullet points or numbered lists in course description
        $rawDesc = $course->description ?? $course->course_desc ?? '';
        $lines = preg_split('/[\r\n]+/', $rawDesc);
        foreach ($lines as $line) {
            $line = trim(strip_tags($line));
            if (empty($line)) continue;

            // Skip technical metadata lines
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

        // If not enough bullet points in description, extract sentences or generate domain-specific topics
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
                    "AI tools integration (ChatGPT, Canva, Midjourney) to accelerate content creation",
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
        $learningPoints = array_slice(array_unique($learningPoints), 0, 8);

        // ---------------------------------------------------------------------
        // 2. CURRICULUM (MODULES & LECTURES)
        // ---------------------------------------------------------------------
        $curriculum = [];

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
            } elseif (str_contains($subLow, 'java')) {
                $curriculum = [
                    ['section' => '1. Java Architecture & Object-Oriented Principles', 'lectures' => '5 Lectures', 'duration' => '46m', 'items' => [
                        ['title' => 'Java Platform Overview: JVM, JRE, JDK & Development Setup', 'duration' => '08:30', 'preview' => true],
                        ['title' => 'Classes, Objects, Methods, Encapsulation & Access Modifiers', 'duration' => '11:20', 'preview' => true],
                        ['title' => 'Inheritance, Method Overriding, Polymorphism & Abstraction', 'duration' => '12:45', 'preview' => false],
                        ['title' => 'Constructors, static, final & super Keywords Explained', 'duration' => '07:40', 'preview' => false],
                        ['title' => 'Packages, Interfaces and Java Naming Conventions', 'duration' => '06:10', 'preview' => false],
                    ]],
                    ['section' => '2. Exception Handling, Collections & Modern Java APIs', 'lectures' => '5 Lectures', 'duration' => '52m', 'items' => [
                        ['title' => 'Exception Handling: try-catch-finally, throw, throws & Custom Exceptions', 'duration' => '11:10', 'preview' => false],
                        ['title' => 'Collections Framework: ArrayList, LinkedList, HashSet and HashMap', 'duration' => '13:40', 'preview' => false],
                        ['title' => 'Iterating Collections: Iterators, For-Each & Lambda Expressions', 'duration' => '09:20', 'preview' => false],
                        ['title' => 'Multithreading Basics, Thread Lifecycle and Synchronization', 'duration' => '10:50', 'preview' => false],
                        ['title' => 'Java Stream API: Filter, Map, Reduce and Collectors', 'duration' => '07:30', 'preview' => false],
                    ]],
                    ['section' => '3. Web Applications with Servlets, JSP & Database (JDBC)', 'lectures' => '5 Lectures', 'duration' => '58m', 'items' => [
                        ['title' => 'Web Architecture, HTTP Protocol and Servlet Lifecycle', 'duration' => '12:15', 'preview' => true],
                        ['title' => 'Session Management: Cookies, HttpSession and URL Rewriting', 'duration' => '11:30', 'preview' => false],
                        ['title' => 'JSP Directives, Scriptlets, Actions and JSTL Standard Tags', 'duration' => '10:45', 'preview' => false],
                        ['title' => 'JDBC: Connecting Java Applications to MySQL Databases', 'duration' => '14:20', 'preview' => false],
                        ['title' => 'CRUD Operations Project using MVC Architecture', 'duration' => '09:40', 'preview' => false],
                    ]],
                    ['section' => '4. Enterprise Java: Spring Framework & Hibernate ORM', 'lectures' => '5 Lectures', 'duration' => '1h 05m', 'items' => [
                        ['title' => 'Introduction to Spring Framework & Inversion of Control (IoC)', 'duration' => '13:45', 'preview' => false],
                        ['title' => 'Spring MVC Architecture and Building RESTful Web APIs', 'duration' => '14:20', 'preview' => false],
                        ['title' => 'Hibernate ORM: Entity Mapping and Database Operations', 'duration' => '15:10', 'preview' => false],
                        ['title' => 'Full-Stack Enterprise Java Project Deployment Walkthrough', 'duration' => '22:15', 'preview' => false],
                    ]],
                ];
            } elseif (str_contains($subLow, 'account') || str_contains($subLow, 'ca foundation') || str_contains($subLow, 'tally') || str_contains($subLow, 'finance')) {
                $curriculum = [
                    ['section' => '1. Theoretical Framework & Accounting Fundamentals', 'lectures' => '5 Lectures', 'duration' => '45m', 'items' => [
                        ['title' => 'Meaning and Scope of Accounting: Principles, Concepts & Conventions', 'duration' => '09:15', 'preview' => true],
                        ['title' => 'Accounting Standards and Framework for Preparation of Financial Statements', 'duration' => '10:30', 'preview' => true],
                        ['title' => 'Capital and Revenue Expenditures and Receipts', 'duration' => '08:45', 'preview' => false],
                        ['title' => 'Double Entry System and Recording of Business Transactions', 'duration' => '09:20', 'preview' => false],
                        ['title' => 'Rules of Debit and Credit: Golden Rules Explained with Examples', 'duration' => '07:30', 'preview' => false],
                    ]],
                    ['section' => '2. Accounting Process: Journals, Ledgers & Trial Balance', 'lectures' => '5 Lectures', 'duration' => '52m', 'items' => [
                        ['title' => 'Journal Entries for Complex Business Transactions', 'duration' => '11:40', 'preview' => false],
                        ['title' => 'Ledger Posting, Balancing Accounts and Subsidiary Books', 'duration' => '10:15', 'preview' => false],
                        ['title' => 'Cash Book Preparation: Single, Double & Triple Column Formats', 'duration' => '11:20', 'preview' => false],
                        ['title' => 'Trial Balance Preparation and Methods of Locating Errors', 'duration' => '09:45', 'preview' => false],
                        ['title' => 'Rectification of Accounting Errors Before and After Trial Balance', 'duration' => '09:30', 'preview' => false],
                    ]],
                    ['section' => '3. Bank Reconciliation (BRS), Depreciation & Inventories', 'lectures' => '5 Lectures', 'duration' => '56m', 'items' => [
                        ['title' => 'Bank Reconciliation Statement (BRS): Causes of Differences & Formats', 'duration' => '12:30', 'preview' => false],
                        ['title' => 'Comprehensive Practice Problems on BRS with Overdraft Balances', 'duration' => '13:10', 'preview' => false],
                        ['title' => 'Depreciation Accounting: Straight Line vs Written Down Value (WDV)', 'duration' => '11:45', 'preview' => false],
                        ['title' => 'Inventory Valuation: FIFO, LIFO, Weighted Average and Cost Methods', 'duration' => '10:20', 'preview' => false],
                        ['title' => 'Provisions, Reserves and Contingent Liabilities', 'duration' => '08:45', 'preview' => false],
                    ]],
                    ['section' => '4. Final Accounts & Specialized Transactions', 'lectures' => '5 Lectures', 'duration' => '1h 04m', 'items' => [
                        ['title' => 'Bills of Exchange: Promissory Notes, Discounting and Dishonor Entries', 'duration' => '12:15', 'preview' => false],
                        ['title' => 'Consignment Accounts: Invoicing at Cost vs Selling Price', 'duration' => '13:40', 'preview' => false],
                        ['title' => 'Preparation of Trading Account and Profit & Loss Account', 'duration' => '12:20', 'preview' => false],
                        ['title' => 'Balance Sheet Preparation with Year-End Adjustments', 'duration' => '14:15', 'preview' => false],
                        ['title' => 'Exam Review: Master Question Solving and Answering Strategies', 'duration' => '11:50', 'preview' => false],
                    ]],
                ];
            } elseif (str_contains($subLow, 'hack') || str_contains($subLow, 'cyber') || str_contains($subLow, 'security') || str_contains($subLow, 'comptia')) {
                $curriculum = [
                    ['section' => '1. Cybersecurity Fundamentals & Lab Setup', 'lectures' => '4 Lectures', 'duration' => '38m', 'items' => [
                        ['title' => 'Introduction to Ethical Hacking, Laws & Penetration Testing Methodologies', 'duration' => '08:45', 'preview' => true],
                        ['title' => 'Setting Up Your Virtual Attack Lab with Kali Linux & Metasploitable', 'duration' => '12:30', 'preview' => true],
                        ['title' => 'Linux Command Line Mastery for Security Professionals', 'duration' => '09:15', 'preview' => false],
                        ['title' => 'TCP/IP, OSI Model, Subnetting and Networking Fundamentals', 'duration' => '08:00', 'preview' => false],
                    ]],
                    ['section' => '2. Information Gathering & Vulnerability Scanning', 'lectures' => '5 Lectures', 'duration' => '50m', 'items' => [
                        ['title' => 'Passive Reconnaissance: OSINT, Google Dorking & Domain Footprinting', 'duration' => '10:15', 'preview' => false],
                        ['title' => 'Active Reconnaissance: Nmap Port Scanning, Timing & Service Detection', 'duration' => '12:40', 'preview' => false],
                        ['title' => 'Banner Grabbing, Vulnerability Enumeration and Searchsploit', 'duration' => '09:20', 'preview' => false],
                        ['title' => 'Automated Vulnerability Scanning with Nessus and OpenVAS', 'duration' => '10:15', 'preview' => false],
                        ['title' => 'Network Sniffing and Packet Analysis using Wireshark', 'duration' => '08:10', 'preview' => false],
                    ]],
                    ['section' => '3. Web Application Penetration Testing (OWASP Top 10)', 'lectures' => '5 Lectures', 'duration' => '58m', 'items' => [
                        ['title' => 'Burp Suite Setup: Intercepting Proxies, Spidering & Repeater Workflows', 'duration' => '12:10', 'preview' => false],
                        ['title' => 'SQL Injection (SQLi): Authentication Bypass and Database Extraction', 'duration' => '14:20', 'preview' => false],
                        ['title' => 'Cross-Site Scripting (XSS): Reflected, Stored and DOM XSS Attacks', 'duration' => '11:45', 'preview' => false],
                        ['title' => 'Broken Authentication, CSRF and Insecure Direct Object References (IDOR)', 'duration' => '11:15', 'preview' => false],
                        ['title' => 'File Upload Vulnerabilities and Remote Code Execution (RCE)', 'duration' => '09:10', 'preview' => false],
                    ]],
                    ['section' => '4. System Exploitation & Defensive Hardening', 'lectures' => '4 Lectures', 'duration' => '45m', 'items' => [
                        ['title' => 'Metasploit Framework: Exploits, Payloads and Meterpreter Sessions', 'duration' => '13:20', 'preview' => false],
                        ['title' => 'Password Cracking Methodologies using John the Ripper and Hashcat', 'duration' => '11:10', 'preview' => false],
                        ['title' => 'Post-Exploitation, Privilege Escalation and Maintaining Access', 'duration' => '11:45', 'preview' => false],
                        ['title' => 'Remediation Reporting, Defensive Best Practices & Certification Path', 'duration' => '09:15', 'preview' => false],
                    ]],
                ];
            } elseif (str_contains($subLow, 'biology') || str_contains($subLow, 'science') || str_contains($subLow, 'ncert') || str_contains($subLow, 'cbse')) {
                $curriculum = [
                    ['section' => '1. Core Concepts & Curriculum Foundation', 'lectures' => '4 Lectures', 'duration' => '35m', 'items' => [
                        ['title' => "Curriculum Blueprint: Syllabus Overview & High-Yield Marks Weightage", 'duration' => '07:15', 'preview' => true],
                        ['title' => 'Fundamental Principles and Foundational Terminology', 'duration' => '09:40', 'preview' => true],
                        ['title' => 'Visualizing Key Biological Processes with Labeled Diagram Walkthroughs', 'duration' => '10:20', 'preview' => false],
                        ['title' => 'Key Scientific Definitions and Formula Flashcards', 'duration' => '08:15', 'preview' => false],
                    ]],
                    ['section' => '2. Detailed Concept Exploration & Mechanism Analysis', 'lectures' => '5 Lectures', 'duration' => '52m', 'items' => [
                        ['title' => 'In-Depth Breakdown of Primary Biological Mechanisms', 'duration' => '12:10', 'preview' => false],
                        ['title' => 'Step-by-Step Flowcharts and Reaction Pathways Explained', 'duration' => '11:30', 'preview' => false],
                        ['title' => 'Comparative Studies: Tabular Differences Frequently Asked in Exams', 'duration' => '09:40', 'preview' => false],
                        ['title' => 'Important Diagram Drawing Practice and Marking Scheme Guidelines', 'duration' => '10:50', 'preview' => false],
                        ['title' => 'Conceptual Questions and NCERT Textbook In-Text Solutions', 'duration' => '08:30', 'preview' => false],
                    ]],
                    ['section' => '3. High-Yield Topic Modules & Exemplar Solutions', 'lectures' => '5 Lectures', 'duration' => '55m', 'items' => [
                        ['title' => 'Detailed Analysis of Complex Chapter Sections', 'duration' => '12:45', 'preview' => false],
                        ['title' => 'Solving NCERT Exemplar and Previous Years Board Exam Questions', 'duration' => '13:20', 'preview' => false],
                        ['title' => 'Case-Based and Assertion-Reasoning Question Solving Strategies', 'duration' => '11:10', 'preview' => false],
                        ['title' => 'Common Conceptual Traps and Mistakes Students Make', 'duration' => '09:15', 'preview' => false],
                        ['title' => 'Quick Revision Notes and Mind Maps for Rapid Retention', 'duration' => '09:10', 'preview' => false],
                    ]],
                    ['section' => '4. Exam Preparation, Model Papers & Final Review', 'lectures' => '4 Lectures', 'duration' => '44m', 'items' => [
                        ['title' => 'Full-Length Model Question Paper Discussion and Model Answers', 'duration' => '14:20', 'preview' => false],
                        ['title' => 'Time Management Strategies for 3-Hour Board Examinations', 'duration' => '09:40', 'preview' => false],
                        ['title' => 'Last-Minute Revision Checklist and Essential Diagram Review', 'duration' => '11:15', 'preview' => false],
                        ['title' => 'Course Wrap-Up and Verified Completion Certificate', 'duration' => '09:15', 'preview' => false],
                    ]],
                ];
            } else {
                // Adaptive Fallback for any other title
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
