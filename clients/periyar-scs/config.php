<?php
declare(strict_types=1);

/**
 * Client Configuration: Periyar Service Co-operative Society
 * Legal Profile: Service Co-operative Society registered under Kerala Co-operative Societies Act, 1969.
 * Note: Strictly respects statutory prohibition on using the word "Bank" or "Banking".
 */
return [
    'client_slug' => 'periyar-scs',
    
    // Legal Profile & Compliance
    'legal' => [
        'verified_legal_name' => 'Periyar Service Co-operative Society Ltd. No. 4390',
        'approved_public_name' => 'Periyar Service Co-operative Society',
        'entity_type' => 'credit_society', // 'licensed_bank' | 'credit_society' | 'agri_society' | 'employee_society'
        'registration_number' => 'No. 4390 (Regd. 1974)',
        'pan' => 'AAAAP5678B',
        'gst' => '32AAAAP5678B1Z2',
        'dicgc_enabled' => false,
        'dicgc_statement_en' => 'Note: As per statutory norms, deposits with Co-operative Societies are governed under the Kerala Co-operative Societies Act and are not covered by DICGC insurance.',
        'dicgc_statement_ml' => 'ശ്രദ്ധിക്കുക: സഹകരണ നിയമപ്രകാരം സൊസൈറ്റിയിലെ നിക്ഷേപങ്ങൾ കേരള സഹകരണ സംഘം നിയമത്തിന് കീഴിലുള്ളതാണ്; DICGC ഇൻഷുറൻസ് പരിധിയിൽ വരുന്നതല്ല.',
        'membership_eligibility_en' => 'Services and credit facilities are strictly available to enrolled ' . 'A' . ' and ' . 'B' . ' class members residing within our notified operational area.',
        'membership_eligibility_ml' => 'സൊസൈറ്റിയുടെ പ്രവർത്തന പരിധിയിൽ താമസിക്കുന്ന അംഗങ്ങൾക്ക് മാത്രമായി സേവനങ്ങളും വായ്പാ സൗകര്യങ്ങളും നിജപ്പെടുത്തിയിരിക്കുന്നു.',
        'ombudsman_name' => 'Co-operative Ombudsman (Government of Kerala, Thiruvananthapuram)',
        'ombudsman_url' => 'https://cooperation.kerala.gov.in',
    ],

    // Contact & Office
    'contact' => [
        'head_office_address_en' => 'Society Central Complex, Aluva Town Road, Periyar Region, Ernakulam, Kerala - 683101',
        'head_office_address_ml' => 'സൊസൈറ്റി സെൻട്രൽ കോംപ്ലക്സ്, ആലുവ ടൗൺ റോഡ്, പെരിയാർ റീജിയൻ, എറണാകുളം, കേരളം - 683101',
        'primary_phone' => '+91 484 262 5500',
        'secondary_phone' => '+91 484 262 5501',
        'whatsapp_number' => '919846001122',
        'email' => 'contact@periyarscs.org',
        'support_email' => 'help@periyarscs.org',
        'grievance_email' => 'grievance@periyarscs.org',
        'working_hours_en' => 'Monday - Saturday: 9:00 AM to 4:00 PM',
        'working_hours_ml' => 'തിങ്കൾ മുതൽ ശനി വരെ: രാവിലെ 9:00 മുതൽ വൈകുന്നേരം 4:00 വരെ',
    ],

    // Social Links
    'social' => [
        'facebook' => 'https://facebook.com/periyarscs',
        'youtube' => 'https://youtube.com/@periyarscs',
    ],

    // Highlights for Counters
    'stats' => [
        'audit_classification' => 'Audit Class A Society',
        'total_branches' => '6 Branch Offices & Fertilizer Depots',
        'working_capital' => '₹ 180+ Crores',
        'members_count' => '22,000+ Enrolled Members',
        'fertilizer_depots' => '4 Agricultural Supply Depots',
    ],

    // Enabled Modules (notice: no unclaimed deposits or heavy commercial app)
    'enabled_modules' => [
        'product_catalogue',
        'rate_engine',
        'calculators',
        'branch_directory',
        'enquiry_workflow',
        'news_events',
        'welfare_projects',
        'trust_centre',
        'announcements',
        'downloads',
        'tenders',
    ],

    'default_language' => 'en',
    'timezone' => 'Asia/Kolkata',
];
