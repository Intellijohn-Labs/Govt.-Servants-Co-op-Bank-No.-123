<?php
declare(strict_types=1);

/**
 * Client Configuration: Kalliaseri Co-operative Urban Bank
 * Legal Profile: Licensed Co-operative Bank under Banking Regulation Act
 */
return [
    'client_slug' => 'kalliaseri-scb',
    
    // Legal Profile & Regulatory Compliance
    'legal' => [
        'verified_legal_name' => 'The Kalliaseri Co-operative Urban Bank Ltd. No. C.124',
        'approved_public_name' => 'Kalliaseri Co-operative Urban Bank',
        'entity_type' => 'licensed_bank', // 'licensed_bank' | 'credit_society' | 'agri_society' | 'employee_society'
        'registration_number' => 'C.124 (Regd. 1968)',
        'rbi_license_number' => '', // TODO: client to supply
        'pan' => '', // TODO: client to supply
        'gst' => '', // TODO: client to supply
        'dicgc_enabled' => false, // TODO: confirm deposit-insurance status with client
        'dicgc_statement_en' => '',
        'dicgc_statement_ml' => '',
        'ombudsman_name' => 'Banking Ombudsman (RBI, Thiruvananthapuram)',
        'ombudsman_url' => 'https://cms.rbi.org.in',
        'domain_obligation_note' => 'Licensed co-operative bank complying with RBI circular RBI/2025-26/28 regarding .bank.in domain adoption.',
    ],

    // Contact & Physical Head Office
    'contact' => [
        'head_office_address_en' => 'Head Office, Central Junction, Kalliaseri, Kannur District, Kerala - 670562',
        'head_office_address_ml' => 'ഹെഡ് ഓഫീസ്, സെൻട്രൽ ജംഗ്ഷൻ, കല്ല്യാശ്ശേരി, കണ്ണൂർ ജില്ല, കേരളം - 670562',
        'primary_phone' => '+91 497 278 1200',
        'secondary_phone' => '+91 497 278 1201',
        'toll_free' => '1800 425 1968',
        'whatsapp_number' => '919447123456',
        'email' => 'info@kalliaseribank.bank.in',
        'support_email' => 'support@kalliaseribank.bank.in',
        'grievance_email' => 'grievance@kalliaseribank.bank.in',
        'working_hours_en' => 'Monday - Saturday: 9:30 AM to 4:30 PM (2nd & 4th Saturday Holiday)',
        'working_hours_ml' => 'തിങ്കൾ മുതൽ ശനി വരെ: 9:30 AM മുതൽ 4:30 PM വരെ (2-ാം, 4-ാം ശനി അവധി)',
    ],

    // Digital Channels & Social Links
    'social' => [
        'facebook' => 'https://facebook.com/kalliaseribank',
        'twitter' => 'https://twitter.com/kalliaseribank',
        'instagram' => 'https://instagram.com/kalliaseribank',
        'youtube' => 'https://youtube.com/@kalliaseribank',
    ],

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
