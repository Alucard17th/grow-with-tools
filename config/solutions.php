<?php
return [
    'products' => [
        [
            'slug'     => 'doctor-finder',
            'title'    => 'Doctor Finder',
            'subtitle' => 'A comprehensive app to manage appointments, connect with doctors, and securely share information.',
            'desc'     => 'The ultimate solution for doctors to manage their schedules, patient data, and facilitate secure communication.',
            'platform' => 'iOS • Android',
            'img' => 'img/products/doctor-finder.png',
            'video' => [
                'src' => '',
                'poster' => 'img/products/doctor-finder.png'
            ],
            'color' => '#20a651',
            'bg' => '#20a6511c',
            'benefits' => [
                ['title' => 'Appointment Management', 'desc' => 'Streamlined calendar and automatic reminders for better time management.'],
                ['title' => 'Secure Data Sharing', 'desc' => 'Confidential patient data storage with end-to-end encryption for sharing.'],
                ['title' => 'Efficient Communication', 'desc' => 'Instant messaging and video calls to communicate with patients and other doctors.'],
            ],
            'features' => [
                ['icon' => 'calendar', 'title' => 'Appointment Scheduler', 'desc' => 'Set appointments easily, with reminders to reduce no-shows.'],
                ['icon' => 'lock', 'title' => 'Data Security', 'desc' => 'Store patient data securely with top-notch encryption.'],
                ['icon' => 'search', 'title' => 'Doctor Finder', 'desc' => 'Find and connect with other specialists easily within the app.'],
            ],
            'stats' => [
                ['kpi' => '95%', 'label' => 'User Satisfaction'],
                ['kpi' => '1–2 weeks', 'label' => 'Setup Time'],
            ],
            'gallery' => [
                'img/products/doctor-finder-1.png',
                'img/products/doctor-finder-2.png',
                'img/products/doctor-finder-3.png',
                'img/products/doctor-finder-4.png',
                'img/products/doctor-finder-5.png',
            ],
            'testimonials' => [
                ['author' => 'Dr. Emma Brown', 'role' => 'Pediatrician', 'text' => 'Doctor Finder has greatly simplified appointment management and data sharing for me.'],
                ['author' => 'Dr. Alex White', 'role' => 'Cardiologist', 'text' => 'The app is intuitive, making communication and scheduling a breeze.'],
            ],
            'faqs' => [
                ['q' => 'Can I share patient data securely?', 'a' => 'Yes, all patient data is encrypted for secure sharing with other healthcare providers.'],
                ['q' => 'Is the app easy to integrate with my practice?', 'a' => 'Yes, the app is designed for seamless integration with your current workflow and patient management system.'],
                ['q' => 'How do I schedule appointments?', 'a' => 'You can easily schedule appointments through the app by selecting available time slots.'],
            ],
            'price_cards' => [
                [
                    'title' => 'Basic Plan', 
                    'price' => '$9', 
                    'desc' => 'Access to appointment scheduling, patient data storage, and all features.',
                ],
                // ['title' => 'Premium Plan', 'price' => '$2,500+', 'desc' => 'Includes secure messaging, video calls, and advanced analytics.'],
            ],
            'cta' => [
                'primary_text' => 'Try Doctor Finder Now', 'primary_href' => '#contact',
                'secondary_text' => 'See a demo', 'secondary_href' => '#contact',
            ],
            'outcomes' => [
                ['key_outcome' => 'Improved Patient Engagement', 'description' => 'Increase in the frequency of patient interactions, with seamless scheduling and communication.'],
                ['key_outcome' => 'Higher Appointment Attendance', 'description' => 'Reduction in no-show rates through automatic reminders and easy rescheduling.'],
                ['key_outcome' => 'Data Security and Compliance', 'description' => 'Improved data security with encrypted patient information and compliance with healthcare standards.'],
                ['key_outcome' => 'Operational Efficiency', 'description' => 'Time-saving for medical professionals through automated scheduling and secure data management.'],
                ['key_outcome' => 'Enhanced Doctor-Patient Relationship', 'description' => 'Strengthened relationships through direct messaging and personalized care options.'],
            ],
            'problem' => 'Managing appointments and patient data in a secure, efficient, and user-friendly manner is challenging for clinics. Without centralized systems, doctors and patients face difficulties with scheduling, secure communication, and data sharing.',
            'approach' => 'We prioritize seamless integration, patient data security, and real-time scheduling to enhance the efficiency of clinics. Our approach focuses on delivering a scalable solution that is easy for both doctors and patients to use, with a strong emphasis on user experience and privacy.',
        ],
        [
            'slug'     => 'habit-tracker',
            'title'    => 'Habit Tracker',
            'subtitle' => 'The simplest way to track your habits and get instant clarity on your progress.',
            'desc'     => 'A minimalist app designed to help you track habits, stay motivated, and improve consistency with personalized AI-driven insights.',
            'platform' => 'iOS • Android • Web (PWA)',
            'img' => 'img/products/habit-tracker.png',
            'video' => [
                'src' => '',
                'poster' => 'img/products/habit-tracker.png'
            ],
            'color' => '#2563eb',
            'bg' => '#2563eb1c',
            'benefits' => [
                ['title' => 'Effortless Habit Tracking', 'desc' => 'Track habits in seconds with a simple, no-fuss interface.'],
                ['title' => 'AI-Powered Insights', 'desc' => 'Get personalized suggestions on how to improve your habits and stay on track.'],
                ['title' => 'Daily Summaries', 'desc' => 'Receive daily summaries with wins, stumbles, and next steps to keep you motivated.'],
            ],
            'features' => [
                ['icon' => 'calendar', 'title' => 'Habit Logging', 'desc' => 'Easily log habits every day with one click or swipe.'],
                ['icon' => 'robot', 'title' => 'AI Coach', 'desc' => 'Get actionable insights and tips from our AI to optimize your habits.'],
                ['icon' => 'chart-line', 'title' => 'Analytics', 'desc' => 'See your progress with charts and insights that show trends over time.'],
            ],
            'stats' => [
                ['kpi' => '90%', 'label' => 'User Retention'],
                ['kpi' => '1–2 minutes', 'label' => 'Daily Tracking Time'],
            ],
            'gallery' => [
                'img/products/habit-tracker-1.png',
                'img/products/habit-tracker-2.png',
                'img/products/habit-tracker-3.png',
                'img/products/habit-tracker-4.png',
                'img/products/habit-tracker-5.png',
            ],
            'testimonials' => [
                ['author' => 'Sarah L.', 'role' => 'Fitness Enthusiast', 'text' => 'DailyClarity helped me stay on top of my hydration and workout habits every day!'],
                ['author' => 'John D.', 'role' => 'Software Engineer', 'text' => 'The AI-powered insights really helped me understand my productivity habits better.'],
            ],
            'faqs' => [
                ['q' => 'Can I track multiple habits?', 'a' => 'Yes, you can track as many habits as you want and get personalized suggestions for each.'],
                ['q' => 'Is my data secure?', 'a' => 'Absolutely! We use top-notch encryption to keep your habit data private and secure.'],
                ['q' => 'Does it work offline?', 'a' => 'Yes, DailyClarity works as a PWA, so you can track habits offline and sync when you’re back online.'],
            ],
            'price_cards' => [
                ['title' => 'Free Plan', 'price' => '$0', 'desc' => 'Access habit tracking, basic analytics, and daily summaries.', 'url' => 'https://habit-tracker-a.netlify.app/'],
                ['title' => 'Premium Plan', 'price' => '$9/month', 'desc' => 'Unlock AI coaching, advanced analytics, and goal-setting features.', 'url' => 'https://habit-tracker-a.netlify.app/'],
            ],
            'cta' => [
                'primary_text' => 'Try DailyClarity Now', 'primary_href' => 'https://eddallalnoureddine.gumroad.com/l/vmywj',
                'secondary_text' => 'See a Demo', 'secondary_href' => '#contact',
            ],
            'outcomes' => [
                ['key_outcome' => 'Improved Consistency', 'description' => 'Stay on track with your daily habits and improve consistency over time.'],
                ['key_outcome' => 'Smarter Goal Achievement', 'description' => 'Achieve your goals faster with personalized AI-powered habit insights.'],
                ['key_outcome' => 'Clarity on Progress', 'description' => 'Understand your habits and make adjustments to improve productivity and health.'],
                ['key_outcome' => 'Time-saving', 'description' => 'Save time with quick habit logging and instant daily summaries.'],
                ['key_outcome' => 'Better Routine Building', 'description' => 'Build effective routines with actionable insights and gentle accountability.'],
            ],
            'problem' => 'Staying consistent with habits can be hard, especially with cluttered apps that overwhelm you with unnecessary features. Without simple tracking, AI-driven insights, and clear progress, it’s easy to lose focus or get discouraged. We solve that with DailyClarity—a minimalist, actionable tool that keeps you on track. ',
            'approach' => 'DailyClarity focuses on simplicity, clarity, and intelligent tracking to help users maintain consistency. By providing AI-powered insights, quick habit logging, and daily summaries, we guide users to achieve their goals in a non-overwhelming, easy-to-use way. Our approach is built on user feedback, privacy, and seamless experience across all devices.',
        ],
        [
            'slug'     => 'wp-nrd-form-builder',
            'title'    => 'WP Nrd Form Builder',
            'subtitle' => 'A powerful and easy-to-use form builder plugin for WordPress that enables seamless creation and management of forms.',
            'desc'     => 'A flexible and intuitive plugin that allows users to easily build custom forms on WordPress, with options to integrate with external services like Google Sheets, Stripe, and more.',
            'platform' => 'Web',
            'img' => 'img/products/wp-nrd-form-builder.png',
            'video' => [
                'src' => '',
                'poster' => 'img/products/wp-nrd-form-builder.png'
            ],
            'color' => '#5e2fca',
            'bg' => '#5e2fca1c',
            'benefits' => [
                ['title' => 'Drag-and-Drop Interface', 'desc' => 'Easily create custom forms with a simple drag-and-drop builder that requires no coding knowledge.'],
                ['title' => 'Google Sheets Integration', 'desc' => 'Automatically sync form submissions with your Google Sheets for easy data management.'],
                ['title' => 'Customizable Fields', 'desc' => 'Add various types of fields like text, checkboxes, file uploads, and more to meet your form requirements.'],
            ],
            'features' => [
                ['icon' => 'calendar', 'title' => 'Form Scheduling', 'desc' => 'Set specific dates and times for form availability to ensure timely data collection.'],
                ['icon' => 'plug', 'title' => 'Integrations', 'desc' => 'Connect with popular third-party services like Stripe, Mailchimp, and Google Sheets for seamless workflow.'],
                ['icon' => 'gear', 'title' => 'Customization Options', 'desc' => 'Fully customize the form design and field behaviors using advanced settings and CSS options.'],
            ],
            'stats' => [
                ['kpi' => '98%', 'label' => 'User Satisfaction'],
                ['kpi' => '1–5 minutes', 'label' => 'Average Form Setup Time'],
            ],
            'gallery' => [
                'img/products/wp-nrd-form-builder-1.png',
                'img/products/wp-nrd-form-builder-2.png',
                'img/products/wp-nrd-form-builder-3.png',
            ],
            'testimonials' => [
                ['author' => 'Linda K.', 'role' => 'Marketing Manager', 'text' => 'This form builder plugin made collecting leads and data much easier on our WordPress site!'],
                ['author' => 'Tom M.', 'role' => 'Web Developer', 'text' => 'The drag-and-drop interface is super intuitive. This plugin saved us a ton of development time.'],
            ],
            'faqs' => [
                ['q' => 'Can I integrate this plugin with third-party services?', 'a' => 'Yes, it supports integration with services like Google Sheets, Stripe, and Mailchimp for enhanced functionality.'],
                ['q' => 'Is it compatible with all themes?', 'a' => 'Yes, the plugin is fully compatible with most WordPress themes, and it can be customized to match your design.'],
                ['q' => 'Can I create multiple forms?', 'a' => 'Absolutely! You can create as many forms as you need and manage them all from a centralized dashboard.'],
            ],
            'price_cards' => [
                [
                    'title' => 'Free Plan',
                    'price' => '$0',
                    'desc' => 'Create basic forms with standard field types and limited integrations.',
                    'url' => env('APP_URL') . ('/downloads/wp-nrd-form-builder.zip') 
                ],
                [   
                    'title' => 'Premium Plan',
                    'price' => '$39 (lifetime)',
                    'desc' => 'Unlock advanced features like third-party integrations, advanced field types, and unlimited form submissions.',
                    'url' => 'https://eddallalnoureddine.gumroad.com/l/vpxgrz'
                ],
            ],
            'cta' => [
                'primary_text' => 'Get the Form Builder Plugin Now', 'primary_href' => '#contact',
                'secondary_text' => 'See a Demo', 'secondary_href' => '#contact',
            ],
            'outcomes' => [
                ['key_outcome' => 'Streamlined Data Collection', 'description' => 'Easily collect and manage data from your users with automated integrations and real-time syncing.'],
                ['key_outcome' => 'Enhanced User Experience', 'description' => 'Provide users with a smooth, intuitive experience by simplifying the form submission process on your website.'],
                ['key_outcome' => 'Faster Setup and Deployment', 'description' => 'Reduce form setup time with the drag-and-drop interface, ensuring faster deployment of forms.'],
                ['key_outcome' => 'Simplified Workflow', 'description' => 'Automate your data collection process by integrating directly with tools like Google Sheets and Stripe.'],
                ['key_outcome' => 'Improved Conversion Rates', 'description' => 'Design visually appealing and easy-to-use forms that help increase user engagement and conversion rates.'],
            ],
            'problem' => 'Creating and managing forms on WordPress can be time-consuming and frustrating, especially when you need complex features and third-party integrations. Without an easy-to-use form builder, managing form submissions and data can be overwhelming. Our plugin solves this by offering an intuitive drag-and-drop interface, powerful customization options, and seamless integrations with external services like Google Sheets and Stripe.',
            'approach' => 'Our WordPress form builder plugin is designed to make form creation and data management effortless. We focus on simplicity, flexibility, and user-friendly features to ensure anyone can build, manage, and automate forms with ease. The plugin integrates with popular third-party services, offers powerful customization options, and supports advanced features without any coding knowledge required.',
        ],
    ],

    'projects' => [
        [
            'title' => 'Clinic PWA',
            'tag' => 'Healthcare',
            'img' => 'img/portfolio/doctor-finder.png',
            'link' => '#contact',  // Link to a contact or project page
        ],
        [
            'title' => 'Habit Tracker',
            'tag' => 'Wellness',
            'img' => 'img/portfolio/habit-tracker.png',
            'link' => '#contact',
        ],
        [
            'title' => 'Wave to Soul',
            'tag' => 'Surf & Travel',
            'img' => 'img/portfolio/wave-to-soul.png',
            'link' => '#contact',
        ],
        [
            'title' => 'Zicheck',
            'tag' => 'Cars Diagnostic',
            'img' => 'img/portfolio/zi-check.png',
            'link' => '#contact',
        ],
    ],
];