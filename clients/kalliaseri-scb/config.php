<?php
declare(strict_types=1);

/**
 * Client Configuration: Govt. Servants' Co-operative Bank Ltd. No. 123, N. Paravur
 * Legal Profile: Co-operative society registered under the Kerala Co-operative Societies Act (Class 1)
 */
return [
    'client_slug' => 'kalliaseri-scb',
    
    // Legal Profile & Regulatory Compliance (verified from the bank's official letters)
    'legal' => [
        'verified_legal_name' => "Govt. Servants' Co-operative Bank Ltd. No. 123, N. Paravur",
        'approved_public_name' => "Govt. Servants' Co-operative Bank Ltd. No. 123, N. Paravur",
        'approved_public_name_ml' => 'സർക്കാർ ജീവനക്കാരുടെ സഹകരണ ബാങ്ക് ക്ലിപ്തം നമ്പർ 123, എൻ. പറവൂർ',
        'short_name' => 'GSCB Paravur',
        'entity_type' => 'employee_society', // 'licensed_bank' | 'credit_society' | 'agri_society' | 'employee_society'
        'registration_number' => 'Reg. No. 123 (Est. 1920)',
        'rbi_license_number' => '', // not supplied
        'pan' => '', // not supplied
        'gst' => '', // not supplied
        'dicgc_enabled' => false, // deposit-insurance status not confirmed
        'dicgc_statement_en' => '',
        'dicgc_statement_ml' => '',
        'ombudsman_name' => '', // not supplied
        'ombudsman_url' => '',
        'domain_obligation_note' => '',
        // Membership eligibility (verified wording: residence and/or property)
        'membership_eligibility_en' => 'Persons employed in government / semi-government institutions in Paravur Taluk who have permanent residence and/or immovable property in the taluk.',
        'membership_eligibility_ml' => 'പറവൂർ താലൂക്കിലെ സർക്കാർ / അർദ്ധ സർക്കാർ സ്ഥാപനങ്ങളിൽ ജോലിയുള്ളവരും, പറവൂർ താലൂക്കിൽ സ്ഥിരതാമസക്കാരോ അല്ലെങ്കിൽ സ്ഥാവര സ്വത്തുക്കളോ ഉള്ളതുമായ വ്യക്തികൾക്ക്.',
    ],

    // Branding assets (paths relative to /public)
    'branding' => [
        'logo' => 'assets/img/logo.png',
        'favicon' => 'assets/img/favicon.png',
        'apple_touch_icon' => 'assets/img/apple-touch-icon.png',
    ],

    // Contact & Physical Head Office
    'contact' => [
        'head_office_address_en' => 'Court Complex West, N. Paravur, Ernakulam, Kerala - 683513',
        'head_office_address_ml' => 'കോടതി സമുച്ചയത്തിന് പടിഞ്ഞാറുവശം, എൻ. പറവൂർ, എറണാകുളം, കേരളം - 683513',
        'primary_phone' => '0484-2442693',
        'secondary_phone' => '',
        'toll_free' => '',
        'whatsapp_number' => '',
        'email' => 'gscb123paravur@gmail.com',
        'support_email' => 'gscb123paravur@gmail.com',
        'grievance_email' => 'gscb123paravur@gmail.com',
        'working_hours_en' => 'Monday – Saturday: 9:30 AM – 4:30 PM (Sunday Closed)',
        'working_hours_ml' => 'തിങ്കൾ – ശനി: 9:30 AM – 4:30 PM (ഞായർ അവധി)',
    ],

    // Digital Channels & Social Links (none supplied)
    'social' => [],

    // Key Highlights & Stats for Homepage Counters
    'stats' => [
        'audit_classification' => 'Class 1',
        // Figures in ₹ Lakhs
        'working_capital' => '7010.23',
        'total_deposits' => '6923.74',
        'total_loans' => '5093.62',
        'share_capital' => '110.70',
    ],

    // Enabled Feature Modules
    'enabled_modules' => [
        'product_catalogue',
        'rate_engine',
        'calculators',
        'branch_directory',
        'enquiry_workflow',
        'news_events',
        'special_offers',
        'welfare_projects',
        'trust_centre',
        'announcements',
        'downloads',
    ],

    'default_language' => 'en',
    'timezone' => 'Asia/Kolkata',
];
