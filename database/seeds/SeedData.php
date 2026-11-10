<?php
declare(strict_types=1);

namespace Database\Seeds;

use Core\Database;

/**
 * High-quality comprehensive database seeder for Kerala Co-operative Banks & Societies.
 */
class SeedData
{
    public static function run(string $clientSlug): void
    {
        echo "Seeding data for client: {$clientSlug}...\n";

        self::purgeClientData($clientSlug);
        self::seedRolesAndPermissions();
        self::seedAdminUsers($clientSlug);
        self::seedBranches($clientSlug);
        self::seedProductCategories($clientSlug);
        self::seedProductsAndRates($clientSlug);
        self::seedBoardMembers($clientSlug);
        self::seedAchievements($clientSlug);
        self::seedBannersAndAnnouncements($clientSlug);
        self::seedNewsAndDownloads($clientSlug);
        self::seedTendersAndCareers($clientSlug);
        self::seedCalculatorsConfig($clientSlug);
        self::hideTemplateFiller($clientSlug);

        echo "Seeding completed successfully for {$clientSlug}!\n";
    }

    private static function purgeClientData(string $clientSlug): void
    {
        try {
            Database::execute("DELETE FROM product_variants WHERE product_id IN (SELECT id FROM products WHERE client_slug = ?)", [$clientSlug]);
            Database::execute("DELETE FROM product_documents WHERE product_id IN (SELECT id FROM products WHERE client_slug = ?)", [$clientSlug]);
            Database::execute("DELETE FROM product_faqs WHERE product_id IN (SELECT id FROM products WHERE client_slug = ?)", [$clientSlug]);
            Database::execute("DELETE FROM product_rates WHERE client_slug = ?", [$clientSlug]);
            Database::execute("DELETE FROM products WHERE client_slug = ?", [$clientSlug]);
            Database::execute("DELETE FROM branches WHERE client_slug = ?", [$clientSlug]);
            Database::execute("DELETE FROM board_members WHERE client_slug = ?", [$clientSlug]);
            Database::execute("DELETE FROM achievements WHERE client_slug = ?", [$clientSlug]);
            Database::execute("DELETE FROM banners WHERE client_slug = ?", [$clientSlug]);
            Database::execute("DELETE FROM announcements WHERE client_slug = ?", [$clientSlug]);
            Database::execute("DELETE FROM news WHERE client_slug = ?", [$clientSlug]);
            Database::execute("DELETE FROM downloads WHERE client_slug = ?", [$clientSlug]);
            Database::execute("DELETE FROM tenders WHERE client_slug = ?", [$clientSlug]);
            Database::execute("DELETE FROM careers WHERE client_slug = ?", [$clientSlug]);
            Database::execute("DELETE FROM calculators_config WHERE client_slug = ?", [$clientSlug]);
        } catch (\Throwable $e) {
            // Ignore if tables are not yet created or clean
        }
    }

    private static function seedRolesAndPermissions(): void
    {
        $roles = [
            ['super_admin', 'Super Administrator', 'Full platform access across all modules and settings'],
            ['admin', 'Administrator', 'Administrative access to content, rates, branches, and enquiries'],
            ['editor', 'Content Editor', 'Can manage news, announcements, downloads, and pages'],
            ['branch_manager', 'Branch Manager', 'Restricted to branch-specific enquiries and service requests'],
        ];

        foreach ($roles as [$slug, $name, $desc]) {
            Database::execute(
                "INSERT IGNORE INTO roles (slug, name, description) VALUES (?, ?, ?)",
                [$slug, $name, $desc]
            );
        }
    }

    private static function seedAdminUsers(string $clientSlug): void
    {
        $superAdminRoleId = Database::fetchOne("SELECT id FROM roles WHERE slug = 'super_admin'")['id'] ?? 1;
        $branchManagerRoleId = Database::fetchOne("SELECT id FROM roles WHERE slug = 'branch_manager'")['id'] ?? 4;

        $passwordHash = password_hash('Admin@12345', PASSWORD_DEFAULT);

        Database::execute(
            "INSERT INTO users (client_slug, role_id, name, username, email, password_hash, status)
             VALUES (?, ?, ?, ?, ?, ?, 'active')
             ON DUPLICATE KEY UPDATE name=VALUES(name), password_hash=VALUES(password_hash)",
            [$clientSlug, $superAdminRoleId, 'System Administrator', 'admin', "admin@{$clientSlug}.local", $passwordHash]
        );

        Database::execute(
            "INSERT INTO users (client_slug, role_id, name, username, email, password_hash, status)
             VALUES (?, ?, ?, ?, ?, ?, 'active')
             ON DUPLICATE KEY UPDATE name=VALUES(name), password_hash=VALUES(password_hash)",
            [$clientSlug, $branchManagerRoleId, 'Branch Manager', 'manager', "manager@{$clientSlug}.local", $passwordHash]
        );
    }

    private static function seedBranches(string $clientSlug): void
    {
        if ($clientSlug === 'kalliaseri-scb') {
            $branches = [
                [
                    'HO-01', 'Head Office & Main Branch', 'ഹെഡ് ഓഫീസ് & മെയിൻ ബ്രാഞ്ച്', 'head-office-main-branch',
                    1, 'Central Junction, Kalliaseri, Kannur - 670562', 'സെൻട്രൽ ജംഗ്ഷൻ, കല്ല്യാശ്ശേരി, കണ്ണൂർ - 670562',
                    'Kannur', '670562', '+91 497 278 1200', '+91 497 278 1201', 'headoffice@kalliaseribank.bank.in',
                    'P. K. Suresh Kumar', '+91 94471 23450', 'Mon - Sat: 9:30 AM - 4:30 PM', 'തിങ്കൾ - ശനി: 9:30 AM - 4:30 PM',
                    1, 1, 1, 1, 11.9702, 75.3528
                ],
                [
                    'BR-02', 'Morazha Evening Branch', 'മൊറാഴ സായാഹ്ന ശാഖ', 'morazha-evening-branch',
                    0, 'Near Morazha High School, Morazha P.O., Kannur - 670331', 'മൊറാഴ ഹൈസ്കൂളിന് സമീപം, മൊറാഴ പി.ഒ., കണ്ണൂർ - 670331',
                    'Kannur', '670331', '+91 497 278 2300', null, 'morazha@kalliaseribank.bank.in',
                    'K. V. Rajesh', '+91 94471 23451', 'Mon - Sun: 10:00 AM - 7:00 PM (365 Days)', 'തിങ്കൾ - ഞായർ: 10:00 AM - 7:00 PM (365 ദിവസവും)',
                    1, 1, 1, 0, 11.9845, 75.3610
                ],
                [
                    'BR-03', 'Irinave Coastal Branch', 'ഇരിണാവ് ശാഖ', 'irinave-coastal-branch',
                    0, 'Irinave Ferry Road, Irinave, Kannur - 670301', 'ഇരിണാവ് ഫെറി റോഡ്, ഇരിണാവ്, കണ്ണൂർ - 670301',
                    'Kannur', '670301', '+91 497 278 3400', null, 'irinave@kalliaseribank.bank.in',
                    'M. Shaji', '+91 94471 23452', 'Mon - Sat: 9:30 AM - 4:30 PM', 'തിങ്കൾ - ശനി: 9:30 AM - 4:30 PM',
                    0, 0, 1, 1, 11.9567, 75.3402
                ],
                [
                    'BR-04', 'Pappinisseri Town Branch', 'പാപ്പിനിശ്ശേരി ടൗൺ ശാഖ', 'pappinisseri-town-branch',
                    0, 'National Highway Junction, Pappinisseri, Kannur - 670561', 'നാഷണൽ ഹൈവേ ജംഗ്ഷൻ, പാപ്പിനിശ്ശേരി, കണ്ണൂർ - 670561',
                    'Kannur', '670561', '+91 497 278 4500', null, 'pappinisseri@kalliaseribank.bank.in',
                    'P. Mini', '+91 94471 23453', 'Mon - Sat: 9:30 AM - 4:30 PM', 'തിങ്കൾ - ശനി: 9:30 AM - 4:30 PM',
                    1, 0, 1, 1, 11.9421, 75.3550
                ],
            ];
        } else {
            $branches = [
                [
                    'HO-01', 'Head Office & Main Counter', 'ഹെഡ് ഓഫീസ് & മെയിൻ കൗണ്ടർ', 'periyar-head-office',
                    1, 'Society Road, Aluva, Ernakulam - 683101', 'സൊസൈറ്റി റോഡ്, ആലുവ, എറണാകുളം - 683101',
                    'Ernakulam', '683101', '+91 484 262 1100', null, 'secretary@periyarscs.coop.in',
                    'K. N. Vijayan', '+91 94472 11001', 'Mon - Sat: 9:00 AM - 4:30 PM', 'തിങ്കൾ - ശനി: 9:00 AM - 4:30 PM',
                    1, 0, 1, 0, 10.1076, 76.3516
                ],
                [
                    'BR-02', 'Thottakkattukara Branch', 'തോട്ടക്കാട്ടുകര ശാഖ', 'thottakkattukara-branch',
                    0, 'Market Road, Thottakkattukara, Aluva - 683108', 'മാർക്കറ്റ് റോഡ്, തോട്ടക്കാട്ടുകര, ആലുവ - 683108',
                    'Ernakulam', '683108', '+91 484 262 2200', null, 'thottakkattukara@periyarscs.coop.in',
                    'B. Radhakrishnan', '+91 94472 11002', 'Mon - Sat: 9:00 AM - 4:30 PM', 'തിങ്കൾ - ശനി: 9:00 AM - 4:30 PM',
                    0, 0, 1, 0, 10.1190, 76.3450
                ]
            ];
        }

        foreach ($branches as $b) {
            Database::execute(
                "INSERT INTO branches (client_slug, code, name_en, name_ml, slug, is_head_office, address_en, address_ml, district, pincode, phone, alternate_phone, email, manager_name, manager_phone, working_hours_en, working_hours_ml, has_locker, has_365_days, has_gold_loan, has_atm, latitude, longitude, status)
                 VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'active')",
                array_merge([$clientSlug], $b)
            );
        }
    }

    private static function seedProductCategories(string $clientSlug): void
    {
        $categories = [
            ['loans', 'loan', 'Loans & Credit Advances', 'വായ്പകളും അഡ്വാൻസുകളും', 'fa-hand-holding-dollar', 1],
            ['deposits', 'deposit', 'Deposits & Savings Schemes', 'നിക്ഷേപ പദ്ധതികൾ', 'fa-piggy-bank', 2],
            ['facilities', 'facility', 'Customer Facilities & Digital Banking', 'ബാങ്കിംഗ് സൗകര്യങ്ങൾ', 'fa-shield-halved', 3],
            ['welfare', 'welfare', 'Community & Social Welfare', 'സാമൂഹ്യക്ഷേമം', 'fa-heart-pulse', 4],
        ];

        foreach ($categories as [$slug, $type, $nameEn, $nameMl, $icon, $order]) {
            Database::execute(
                "INSERT INTO product_categories (client_slug, slug, type, name_en, name_ml, icon, sort_order)
                 VALUES (?, ?, ?, ?, ?, ?, ?)
                 ON DUPLICATE KEY UPDATE name_en=VALUES(name_en), name_ml=VALUES(name_ml)",
                [$clientSlug, $slug, $type, $nameEn, $nameMl, $icon, $order]
            );
        }
    }

    private static function seedProductsAndRates(string $clientSlug): void
    {
        $loanCatId = Database::fetchOne("SELECT id FROM product_categories WHERE client_slug = ? AND slug = 'loans'", [$clientSlug])['id'] ?? 1;
        $depCatId = Database::fetchOne("SELECT id FROM product_categories WHERE client_slug = ? AND slug = 'deposits'", [$clientSlug])['id'] ?? 2;
        $facCatId = Database::fetchOne("SELECT id FROM product_categories WHERE client_slug = ? AND slug = 'facilities'", [$clientSlug])['id'] ?? 3;

        $isBank = ($clientSlug === 'kalliaseri-scb');

        // Helper to insert product
        $insertProd = function(array $data) use ($clientSlug) {
            Database::execute(
                "INSERT INTO products (client_slug, category_id, slug, code, name_en, name_ml, tagline_en, tagline_ml, overview_en, overview_ml, target_audience, interest_rate_display, tenure_display_en, tenure_display_ml, max_amount_display_en, max_amount_display_ml, processing_fee_en, processing_fee_ml, is_featured, show_on_rates_panel, sort_order, status)
                 VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'published')",
                array_merge([$clientSlug], $data)
            );
            return (int)Database::lastInsertId();
        };

        // 1. Gold Loan
        $glId = $insertProd([
            $loanCatId, 'gold-loan', 'LN-GL',
            $isBank ? 'Swarna Nidhi Gold Loan' : 'Swarna Padhathi Gold Pledge Loan',
            $isBank ? 'സ്വർണ്ണ നിധി സ്വർണ്ണ പണയ വായ്പ' : 'സ്വർണ്ണ പണയ വായ്പ',
            'Instant financial liquidity against 22K gold ornaments with maximum advance value per gram.',
            'കുറഞ്ഞ പലിശ നിരക്കിലും പരമാവധി ഗ്രാമിന് മൂല്യത്തിലും വേഗത്തിലുള്ള സ്വർണ്ണ പണയ വായ്പ.',
            'Our Gold Loan scheme provides members and customers with instant liquidity against 22K gold ornaments. Processed within 10 minutes with transparent weighment and computerized safe appraisal.',
            '22 കാരറ്റ് സ്വർണ്ണാഭരണങ്ങൾക്ക് ഏറ്റവും വേഗത്തിൽ പണം ലഭ്യമാക്കുന്ന പദ്ധതി. സുതാര്യമായ കമ്പ്യൂട്ടറൈസ്ഡ് ഭാര നിർണ്ണയവും ഉയർന്ന സുരക്ഷയുള്ള ലോക്കർ ഭദ്രതയും.',
            $isBank ? 'open_to_public' : 'members_only',
            '8.50% - 9.75%', 'Up to 12 Months', '12 മാസം വരെ', 'Up to ₹ 25 Lakhs', '₹ 25 ലക്ഷം വരെ',
            'Zero processing fee for loans up to ₹ 1 Lakh', '₹ 1 ലക്ഷം വരെയുള്ള വായ്പകൾക്ക് പ്രോസസ്സിംഗ് ഫീസ് ഇല്ല',
            1, 1, 1
        ]);
        Database::execute("INSERT INTO product_variants (product_id, name_en, name_ml, ceiling_amount, rate_display, tenure) VALUES (?, 'Express Gold Loan (1 Month)', 'എക്സ്പ്രസ്സ് സ്വർണ്ണ വായ്പ (1 മാസം)', 500000, '8.50%', '30 Days')", [$glId]);
        Database::execute("INSERT INTO product_variants (product_id, name_en, name_ml, ceiling_amount, rate_display, tenure) VALUES (?, 'Standard Swarna Nidhi (6 Months)', 'സ്റ്റാൻഡേർഡ് സ്വർണ്ണ വായ്പ (6 മാസം)', 1500000, '9.00%', '180 Days')", [$glId]);
        Database::execute("INSERT INTO product_documents (product_id, title_en, title_ml, is_mandatory, sort_order) VALUES (?, 'Aadhaar Card / Voter ID proof', 'ആധാർ കാർഡ് അല്ലെങ്കിൽ വോട്ടർ ഐഡി', 1, 1)", [$glId]);
        Database::execute("INSERT INTO product_documents (product_id, title_en, title_ml, is_mandatory, sort_order) VALUES (?, 'Passport Size Photographs (2 Nos)', 'പാസ്‌പോർട്ട് സൈസ് ഫോട്ടോ (2 എണ്ണം)', 1, 2)", [$glId]);
        Database::execute("INSERT INTO product_faqs (product_id, question_en, question_ml, answer_en, answer_ml, sort_order) VALUES (?, 'What is the maximum loan per gram?', 'ഒരു ഗ്രാമിന് പരമാവധി എത്ര തുക ലഭിക്കും?', 'The advance rate per gram is updated daily based on prevailing 22-carat gold market rates and RBI/Government directives.', 'വിപണി നിരക്കുകൾക്കും സർക്കാർ നിർദ്ദേശങ്ങൾക്കും അനുസൃതമായി ദിവസേന നിശ്ചയിക്കുന്ന നിരക്കിൽ പരമാവധി തുക അനുവദിക്കുന്നു.', 1)", [$glId]);

        // 2. Housing Loan
        $hlId = $insertProd([
            $loanCatId, 'housing-loan', 'LN-HL',
            'Griha Nirman Housing Loan', 'ഭവന നിർമ്മാണ വായ്പ',
            'Affordable home loans for new construction, purchase, renovation, and plot acquisition.',
            'വീട് നിർമ്മാണം, വാങ്ങൽ, നവീകരണം എന്നിവയ്ക്കായി ലളിതമായ വ്യവസ്ഥകളിൽ ഭവന വായ്പ.',
            'Fulfill your dream home aspiration with our flexible housing loans. Offering transparent terms, low processing fees, and comfortable tenure repayment up to 15 years.',
            'സ്വന്തമായൊരു വീടെന്ന സ്വപ്നം സാക്ഷാത്കരിക്കാൻ ആകർഷകമായ പലിശ നിരക്കിൽ ദീർഘകാല തിരിച്ചടവ് സൗകര്യത്തോടെ ഭവന വായ്പ നൽകുന്നു.',
            $isBank ? 'open_to_public' : 'members_only',
            '9.25% - 10.50%', 'Up to 15 Years', '15 വർഷം വരെ', 'Up to ₹ 50 Lakhs', '₹ 50 ലക്ഷം വരെ',
            '0.50% of loan amount + GST', 'വായ്പാ തുകയുടെ 0.50% + ജി.എസ്.ടി',
            1, 1, 2
        ]);
        Database::execute("INSERT INTO product_variants (product_id, name_en, name_ml, ceiling_amount, rate_display, tenure) VALUES (?, 'New Construction Loan', 'പുതിയ ഭവന നിർമ്മാണം', 5000000, '9.25%', '15 Years')", [$hlId]);
        Database::execute("INSERT INTO product_variants (product_id, name_en, name_ml, ceiling_amount, rate_display, tenure) VALUES (?, 'Home Renovation & Extension', 'ഭവന പുനരുദ്ധാരണ വായ്പ', 1500000, '9.75%', '7 Years')", [$hlId]);
        Database::execute("INSERT INTO product_documents (product_id, title_en, title_ml, is_mandatory, sort_order) VALUES (?, 'Registered Title Deed (Aadheeram) & Prior Deeds', 'ആധാരവും മുന്നാധാരങ്ങളും', 1, 1)", [$hlId]);
        Database::execute("INSERT INTO product_documents (product_id, title_en, title_ml, is_mandatory, sort_order) VALUES (?, 'Approved Building Plan and Permit from Local Body', 'തദ്ദേശ സ്ഥാപനത്തിന്റെ അംഗീകൃത പ്ലാനും പെർമിറ്റും', 1, 2)", [$hlId]);
        Database::execute("INSERT INTO product_documents (product_id, title_en, title_ml, is_mandatory, sort_order) VALUES (?, 'Latest Land Tax Receipt and Possession Certificate', 'കരം ഒടുക്കിയ രസീതും കൈവശാവകാശ സർട്ടിഫിക്കറ്റും', 1, 3)", [$hlId]);

        // 3. Agricultural Loan
        $agId = $insertProd([
            $loanCatId, 'agricultural-loan', 'LN-AG',
            'Kisan Samriddhi Agricultural Credit', 'കിസാൻ സമൃദ്ധി കാർഷിക വായ്പ',
            'Concessional crop loans and agricultural investment advances for farmers and allied agri-ventures.',
            'നെൽകൃഷി, നാണ്യവിളകൾ, ക്ഷീരോൽപ്പാദനം എന്നിവയ്ക്കായി സബ്സിഡിയോടെയുള്ള കാർഷിക വായ്പ.',
            'Designed to support farmers with crop cultivation, seed procurement, tractor and micro-irrigation machinery, dairy cattle farming, and poultry setup.',
            'കർഷകർക്ക് വിത്ത്, വളം, ജലസേചന ഉപകരണങ്ങൾ വാങ്ങുന്നതിനും കന്നുകാലി വളർത്തലിനും മിതമായ പലിശ നിരക്കിൽ നൽകുന്ന കാർഷിക വായ്പ.',
            'members_only',
            '7.00% - 8.50%', 'Seasonal to 5 Years', 'വിളവെടുപ്പ് കാലം മുതൽ 5 വർഷം വരെ', 'Up to ₹ 10 Lakhs', '₹ 10 ലക്ഷം വരെ',
            'Nil for small & marginal farmers', 'ചെറുകിട നാമമാത്ര കർഷകർക്ക് പ്രോസസ്സിംഗ് ഫീസ് ഇല്ല',
            1, 1, 3
        ]);

        // 4. Business Loan
        $blId = $insertProd([
            $loanCatId, 'business-loan', 'LN-BL',
            'Vyapar Sahayi Trader & SME Credit', 'വ്യാപാര സഹായി ബിസിനസ്സ് വായ്പ',
            'Working capital and trade expansion loans for shopkeepers, traders, and small enterprises.',
            'വ്യാപാരികൾക്കും ചെറുകിട സംരംഭകർക്കും സ്റ്റോക്ക് വാങ്ങാനും വിപുലീകരിക്കാനും ബിസിനസ്സ് വായ്പ.',
            'Boost your trade liquidity with easy overdraft and working capital limits. Quick approvals with minimal documentation for merchant community members.',
            'കച്ചവട സ്ഥാപനങ്ങൾ, സ്റ്റോക്കുകൾ, വർക്കിംഗ് ക്യാപിറ്റൽ എന്നിവയ്ക്കായി പ്രതിമാസ പലിശ അടവ് സൗകര്യത്തോടെ നൽകുന്ന വ്യാപാര വായ്പ.',
            'open_to_public',
            '10.00% - 11.25%', '1 to 5 Years', '1 മുതൽ 5 വർഷം വരെ', 'Up to ₹ 25 Lakhs', '₹ 25 ലക്ഷം വരെ',
            '1.0% + GST', '1.0% + ജി.എസ്.ടി',
            0, 1, 4
        ]);

        // 5. Vehicle Loan
        $vlId = $insertProd([
            $loanCatId, 'vehicle-loan', 'LN-VL',
            'Vahana Mithra Vehicle Loan', 'വാഹന മിത്ര വാഹന വായ്പ',
            'Fast approvals for two-wheelers, passenger cars, and commercial transport vehicles.',
            'സ്വന്തമായി ഇരുചക്ര വാഹനം, കാർ, അല്ലെങ്കിൽ ചരക്ക് വാഹനം വാങ്ങാൻ ഏറ്റവും കുറഞ്ഞ പലിശയിൽ വായ്പ.',
            'Drive home your personal or commercial vehicle with competitive interest rates and flexible equated monthly installments.',
            'പുതിയ ഇരുചക്ര വാഹനങ്ങൾ, കാറുകൾ, മറ്റ് വാണിജ്യ വാഹനങ്ങൾ എന്നിവ വാങ്ങാൻ ലളിതമായ തവണ വ്യവസ്ഥയിൽ വായ്പ ലഭിക്കുന്നു.',
            'open_to_public',
            '9.50% - 10.75%', 'Up to 5 Years', '5 വർഷം വരെ', 'Up to ₹ 15 Lakhs', '₹ 15 ലക്ഷം വരെ',
            '0.75% of vehicle cost', 'വാഹന വിലയുടെ 0.75%',
            0, 1, 5
        ]);

        // 6. Fixed Deposit
        $fdId = $insertProd([
            $depCatId, 'fixed-deposit', 'DP-FD',
            $isBank ? 'Suraksha Term Fixed Deposit' : 'Kshema Nidhi Term Deposit',
            $isBank ? 'സുരക്ഷ ഫിക്സഡ് ഡെപ്പോസിറ്റ്' : 'ക്ഷേമ നിധി സ്ഥിര നിക്ഷേപം',
            'Secure long-term wealth growth with monthly, quarterly or cumulative maturity compounding.',
            'നിക്ഷേപങ്ങൾക്ക് ഉയർന്ന സുരക്ഷിതത്വവും ആകർഷകമായ പലിശ വരുമാനവും നൽകുന്ന സ്ഥിര നിക്ഷേപം.',
            'Fixed Deposits offer maximum safety with competitive interest payout options. Senior citizens enjoy an additional 0.50% interest bonus across all tenure slabs.',
            'സ്ഥിര നിക്ഷേപങ്ങൾക്ക് പ്രതിമാസ, ത്രൈമാസ, അല്ലെങ്കിൽ കാലാവധിയിൽ ലഭിക്കുന്ന പലിശ ഓപ്ഷനുകൾ. മുതിർന്ന പൗരന്മാർക്ക് 0.50% അധിക പലിശ ആനുകൂല്യം.',
            $isBank ? 'open_to_public' : 'members_only',
            '7.50% - 9.00%', '46 Days to 5 Years', '46 ദിവസം മുതൽ 5 വർഷം വരെ', 'No upper ceiling', 'പരിധിയില്ല',
            'N/A', 'ബാധകമല്ല',
            1, 1, 6
        ]);
        Database::execute("INSERT INTO product_variants (product_id, name_en, name_ml, ceiling_amount, rate_display, tenure) VALUES (?, 'Cumulative Reinvestment (Kamadhenu)', 'കാമധേനു കൂട്ടുപലിശ നിക്ഷേപം', null, '8.25%', '1 to 5 Years')", [$fdId]);
        Database::execute("INSERT INTO product_variants (product_id, name_en, name_ml, ceiling_amount, rate_display, tenure) VALUES (?, 'Monthly Interest Income Scheme', 'പ്രതിമാസ പലിശ വരുമാന പദ്ധതി', null, '8.00%', '1 to 3 Years')", [$fdId]);

        // 7. Recurring Deposit
        $rdId = $insertProd([
            $depCatId, 'recurring-deposit', 'DP-RD',
            'Sanchaya Recurring Deposit', 'സഞ്ചയ ആവർത്തന നിക്ഷേപം',
            'Disciplined monthly savings yielding compounded maturity returns for goal planning.',
            'ചെറിയ തുകകൾ പ്രതിമാസം മിച്ചം വെച്ച് ഉയർന്ന പലിശയോടെ വലിയൊരു തുക സ്വരുക്കൂട്ടാം.',
            'Ideal for salaried persons and small savers. Deposit a fixed sum every month from ₹ 100 onwards and earn attractive compound interest at maturity.',
            'പ്രതിമാസം ₹ 100 മുതൽ നിശ്ചിത തുക അടച്ച് നിശ്ചിത കാലാവധി പൂർത്തിയാകുമ്പോൾ ഉയർന്ന കൂട്ടുപലിശയോടെ തുക കൈപ്പറ്റാം.',
            'open_to_public',
            '7.25% - 8.50%', '12 to 60 Months', '12 മുതൽ 60 മാസം വരെ', 'Min ₹ 100 / Month', 'കുറഞ്ഞത് ₹ 100 / മാസം',
            'N/A', 'ബാധകമല്ല',
            1, 1, 7
        ]);

        // 8. Pigmy Deposit
        $pgId = $insertProd([
            $depCatId, 'pigmy-deposit', 'DP-PG',
            'Nithya Nidhi Daily Pigmy Deposit', 'നിത്യനിധി ഡെയ്‌ലി പിഗ്മി നിക്ഷേപം',
            'Doorstep daily collection savings designed for merchants, small vendors, and households.',
            'ബാങ്ക് പ്രതിനിധി നിങ്ങളുടെ കടയിലോ വീട്ടിലോ നേരിട്ടെത്തി ദിവസേന തുക സ്വീകരിക്കുന്ന സമ്പാദ്യ പദ്ധതി.',
            'Our authorized collectors visit your doorstep daily to collect and receipt your small savings, making wealth accumulation completely effortless.',
            'ഓതറൈസ്ഡ് കളക്ടർമാർ നിങ്ങളുടെ സ്ഥാപനത്തിലോ വീട്ടിലോ എത്തി കൈപ്പറ്റ് രസീത് നൽകി തുക ശേഖരിക്കുന്നു. കച്ചവടക്കാർക്ക് അനുയോജ്യം.',
            'open_to_public',
            '5.50% - 6.50%', '12 to 24 Months', '12 മുതൽ 24 മാസം വരെ', 'Daily collection', 'ദിവസേനയുള്ള നിക്ഷേപം',
            'N/A', 'ബാധകമല്ല',
            0, 1, 8
        ]);

        // 9. Kids Deposit
        $kdId = $insertProd([
            $depCatId, 'kids-deposit', 'DP-KD',
            'Bala Nidhi Children Savings Deposit', 'ബാലനിധി വിദ്യാർത്ഥി സമ്പാദ്യ പദ്ധതി',
            'Cultivating the habit of thrift and securing educational funds for your children.',
            'കുട്ടികളിൽ സമ്പാദ്യശീലം വളർത്തുന്നതിനും അവരുടെ ഉപരിപഠന ചെലവുകൾ മുൻകൂട്ടി കാണുന്നതിനുമുള്ള പദ്ധതി.',
            'Open an account in the name of your child with guardian operation. Special gift incentives, higher interest bonus, and fee concessions on higher education loan later.',
            'കുട്ടികളുടെ പേരിൽ രക്ഷിതാക്കൾക്ക് അക്കൗണ്ട് ആരംഭിക്കാം. ആകർഷകമായ പലിശയും ഭാവിയിൽ വിദ്യാഭ്യാസ വായ്പകൾക്ക് മുൻഗണനയും.',
            'open_to_public',
            '7.50% - 8.25%', 'Up to age 18', '18 വയസ്സ് പൂർത്തിയാകുന്നത് വരെ', 'Flexible', 'പരിധിയില്ല',
            'Zero account opening charge', 'അക്കൗണ്ട് ഓപ്പണിംഗ് ഫീസ് ഇല്ല',
            0, 1, 9
        ]);

        // 10. Lockers
        $lkId = $insertProd([
            $facCatId, 'lockers', 'FC-LK',
            'Safe Deposit Lockers', 'സേഫ് ഡെപ്പോസിറ്റ് ലോക്കറുകൾ',
            'High-security dual-key vaults with biometric access, fire protection, and CCTV monitoring.',
            'നിങ്ങളുടെ ആഭരണങ്ങളും പ്രമാണങ്ങളും സുരക്ഷിതമായി സൂക്ഷിക്കാൻ അത്യാധുനിക സേഫ് ലോക്കറുകൾ.',
            'Available in Small, Medium, and Large dimensions across all major branches with reasonable annual rentals and strict confidentiality.',
            'സിസിടിവി നിരീക്ഷണവും അതീവ സുരക്ഷാ സംവിധാനങ്ങളുമുള്ള സ്ട്രോംഗ് റൂമുകളിൽ കുറഞ്ഞ വാർഷിക വാടകയിൽ ലോക്കർ സൗകര്യം ലഭ്യമാണ്.',
            'open_to_public',
            'Annual Rent from ₹ 1,000', 'Annual Renewal', 'വാർഷിക വാടക', 'Small, Medium, Large', 'ചെറുത്, ഇടത്തരം, വലുത്',
            'Refundable Security Deposit Applicable', 'റീഫണ്ടബിൾ സെക്യൂരിറ്റി ഡെപ്പോസിറ്റ് ബാധകം',
            1, 0, 10
        ]);

        // 11. NEFT / RTGS
        $trId = $insertProd([
            $facCatId, 'neft-rtgs', 'FC-TR',
            'NEFT / RTGS / IMPS Funds Transfer', 'നെഫ്റ്റ് / ആർ.ടി.ജി.എസ് പണമിടപാടുകൾ',
            'Instant electronic remittances to any bank account in India within seconds.',
            'ഇന്ത്യയിലെ ഏത് ബാങ്ക് അക്കൗണ്ടിലേക്കും നിമിഷങ്ങൾക്കകം പണം കൈമാറാൻ സുരക്ഷിത സംവിധാനം.',
            'Direct electronic clearing and settlement enabling effortless money transfer for business payments, loan installments, and personal family remittances.',
            'ദേശീയതലത്തിൽ ഏത് ബാങ്കിലേക്കും ബിസിനസ്സ് ആവശ്യങ്ങൾക്കും വ്യക്തിഗത ആവശ്യങ്ങൾക്കുമായി വേഗത്തിൽ പണം അയക്കാം.',
            'open_to_public',
            'Nominal RBI rates', 'Instant / Same Day', 'തത്സമയം', 'Up to ₹ 25 Lakhs per day', 'പ്രതിദിനം ₹ 25 ലക്ഷം വരെ',
            'Standard transaction charge', 'സാധാരണ ട്രാൻസാക്ഷൻ നിരക്ക്',
            0, 0, 11
        ]);

        // 12. Mobile Banking
        $mbId = $insertProd([
            $facCatId, 'mobile-banking', 'FC-MB',
            'Mobile Passbook & Digital App', 'മൊബൈൽ പാസ്സ്ബുക്ക് & ഡിജിറ്റൽ ആപ്പ്',
            'Real-time account balance, mini statements, and SMS alerts straight to your smartphone.',
            'നിങ്ങളുടെ ബാങ്ക് ഇടപാടുകൾ മൊബൈൽ ഫോണിൽ തത്സമയം അറിയാൻ സ്മാർട്ട് ഡിജിറ്റൽ പാസ്സ്ബുക്ക്.',
            'Download our secure customer app to view passbook entries, transaction history, interest certificates, and branch locator without visiting a counter.',
            'ശാഖകളിൽ ക്യൂ നിൽക്കാതെ തന്നെ ബാലൻസ് പരിശോധനയും കഴിഞ്ഞ ഇടപാടുകളുടെ വിവരങ്ങളും മൊബൈൽ ആപ്പിൽ ലഭ്യമാണ്.',
            'open_to_public',
            'Free Service', '24x7 Availability', '24 മണിക്കൂറും', 'Android / iOS App', 'ആൻഡ്രോയിഡ് / ഐ.ഒ.എസ്',
            'Zero Service Charge', 'സൗജന്യ സേവനം',
            0, 0, 12
        ]);

        // Seed Rate Engine Rows (Deposit & Loan)
        $rates = [
            ['deposit', '46 Days to 90 Days', '46 ദിവസം മുതൽ 90 ദിവസം വരെ', 6.25, 6.75],
            ['deposit', '91 Days to 180 Days', '91 ദിവസം മുതൽ 180 ദിവസം വരെ', 6.75, 7.25],
            ['deposit', '181 Days to Less than 1 Year', '181 ദിവസം മുതൽ 1 വർഷം താഴെ വരെ', 7.50, 8.00],
            ['deposit', '1 Year to 2 Years', '1 വർഷം മുതൽ 2 വർഷം വരെ', 8.25, 8.75],
            ['deposit', 'Above 2 Years up to 5 Years', '2 വർഷത്തിന് മുകളിൽ 5 വർഷം വരെ', 8.00, 8.50],
        ];

        foreach ($rates as [$catType, $tEn, $tMl, $genRate, $senRate]) {
            Database::execute(
                "INSERT INTO product_rates (client_slug, product_id, category_type, tenure_label_en, tenure_label_ml, general_rate, senior_rate, effective_from, is_active, sort_order)
                 VALUES (?, ?, ?, ?, ?, ?, ?, '2026-04-01', 1, 1)",
                [$clientSlug, $fdId, $catType, $tEn, $tMl, $genRate, $senRate]
            );
        }

        // Loan Rates
        // kalliaseri-scb: approved loan slabs only (no template placeholder rates)
        $loanRates = $isBank ? [
            ['loan', 'Loans up to ₹4 Lakhs', '4 ലക്ഷം വരെ', 9.50, 9.50],
            ['loan', 'Loans above ₹4 Lakhs up to ₹8 Lakhs', '4 ലക്ഷത്തിന് മുകളിൽ 8 ലക്ഷം വരെ', 10.50, 10.50],
            ['loan', 'Loans above ₹8 Lakhs', '8 ലക്ഷത്തിന് മുകളിൽ', 11.50, 11.50], // slab badges are set in hideTemplateFiller()
        ] : [
            ['loan', 'Gold Loan (Swarna Nidhi)', 'സ്വർണ്ണ വായ്പ', 8.50, 8.50],
            ['loan', 'Housing Loan (Home Construction)', 'ഭവന നിർമ്മാണ വായ്പ', 9.25, 9.25],
            ['loan', 'Kisan Agricultural Loan', 'കാർഷിക വായ്പ', 7.00, 7.00],
            ['loan', 'SME Business & Trader Credit', 'ചെറുകിട വ്യാപാരി വായ്പ', 10.00, 10.00],
            ['loan', 'Vehicle & Two Wheeler Loan', 'വാഹന വായ്പ', 9.50, 9.50],
        ];

        foreach ($loanRates as [$catType, $tEn, $tMl, $genRate, $senRate]) {
            Database::execute(
                "INSERT INTO product_rates (client_slug, product_id, category_type, tenure_label_en, tenure_label_ml, general_rate, senior_rate, effective_from, is_active, sort_order)
                 VALUES (?, ?, ?, ?, ?, ?, ?, ?, 1, ?)",
                [$clientSlug, $isBank ? null : $glId, $catType, $tEn, $tMl, $genRate, $senRate, $isBank ? '2026-11-10' : '2026-04-01', $isBank ? 0 : 2]
            );
        }
    }

    private static function seedBoardMembers(string $clientSlug): void
    {
        $isBank = ($clientSlug === 'kalliaseri-scb');

        $members = [
            [
                $isBank ? 'K. Ramanathan' : 'M. V. Balakrishnan',
                $isBank ? 'കെ. രാമനാഥൻ' : 'എം. വി. ബാലകൃഷ്ണൻ',
                'President / Chairperson', 'പ്രസിഡന്റ് / ചെയർപേഴ്സൺ',
                'chairperson', '+91 94471 23456', 'president@bank.local',
                $isBank ? 'Our institution remains firmly committed to empowering ordinary households and small businesses through robust co-operative banking.' : 'Our society exists solely for our member community, uplifting farmers and rural households with mutual trust.',
                $isBank ? 'സാധാരണക്കാരുടെയും ചെറുകിട സംരംഭകരുടെയും ഉന്നമനത്തിനായി സുതാര്യവും ജനകീയവുമായ സഹകരണ ബാങ്കിംഗ് ഉറപ്പാക്കുകയാണ് ഞങ്ങളുടെ ലക്ഷ്യം.' : 'പരസ്പര വിശ്വാസത്തിലൂടെയും കർഷകക്ഷേമത്തിലൂടെയും നാടിന്റെ സമഗ്ര പുരോഗതിക്കായി സൊസൈറ്റി എപ്പോഴും ഒപ്പമുണ്ട്.',
                1
            ],
            [
                $isBank ? 'P. V. Sumathi' : 'P. K. Narayanan',
                $isBank ? 'പി. വി. സുമതി' : 'പി. കെ. നാരായണൻ',
                'Vice President', 'വൈസ് പ്രസിഡന്റ്',
                'vice_chairperson', '+91 94471 23457', 'vp@bank.local',
                null, null, 2
            ],
            [
                $isBank ? 'C. H. Madhavan' : 'E. K. Raghu',
                $isBank ? 'സി. എച്ച്. മാധവൻ' : 'ഇ. കെ. രഘു',
                'Secretary / Chief Executive', 'സെക്രട്ടറി / സി.ഇ.ഒ',
                'secretary', '+91 94471 23458', 'secretary@bank.local',
                null, null, 3
            ],
            [
                $isBank ? 'K. P. Jayarajan' : 'T. V. Chandran',
                $isBank ? 'കെ. പി. ജയരാജൻ' : 'ടി. വി. ചന്ദ്രൻ',
                'Director (Board Member)', 'ഡയറക്ടർ',
                'director', null, null, null, null, 4
            ],
            [
                $isBank ? 'Prof. M. Leela' : 'K. Sarojini',
                $isBank ? 'പ്രൊഫ. എം. ലീല' : 'കെ. സരോജിനി',
                'Director (Board Member)', 'ഡയറക്ടർ',
                'director', null, null, null, null, 5
            ],
        ];

        foreach ($members as [$nEn, $nMl, $dEn, $dMl, $role, $phone, $email, $mEn, $mMl, $order]) {
            Database::execute(
                "INSERT INTO board_members (client_slug, name_en, name_ml, designation_en, designation_ml, role_type, phone, email, message_en, message_ml, sort_order, status)
                 VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'active')",
                [$clientSlug, $nEn, $nMl, $dEn, $dMl, $role, $phone, $email, $mEn, $mMl, $order]
            );
        }
    }

    private static function seedAchievements(string $clientSlug): void
    {
        // Figures in ₹ Lakhs for kalliaseri-scb (client note); other clients keep template values
        $achievements = $clientSlug === 'kalliaseri-scb' ? [
            ['Working Capital (₹ Lakhs)', 'പ്രവർത്തന മൂലധനം (ലക്ഷം രൂപ)', '7010.23', '', 'fa-chart-line', 1],
            ['Total Deposits (₹ Lakhs)', 'നിക്ഷേപ ബാക്കി (ലക്ഷം രൂപ)', '6923.74', '', 'fa-piggy-bank', 2],
            ['Total Loans (₹ Lakhs)', 'വായ്പാ ബാക്കി (ലക്ഷം രൂപ)', '5093.62', '', 'fa-hand-holding-dollar', 3],
            ['Share Capital (₹ Lakhs)', 'ഓഹരി മൂലധനം (ലക്ഷം രൂപ)', '110.70', '', 'fa-coins', 4],
        ] : [
            ['Audit Classification', 'ഓഡിറ്റ് ഗ്രേഡ്', 'Class A', '', 'fa-award', 1],
            ['Active Members', 'സജീവ അംഗങ്ങൾ', '45,000', '+', 'fa-users', 2],
            ['Branch Offices', 'ശാഖകൾ', '14', '+', 'fa-building-columns', 3],
            ['Working Capital', 'പ്രവർത്തന മൂലധനം', '₹ 450', ' Cr+', 'fa-chart-line', 4],
        ];

        foreach ($achievements as [$tEn, $tMl, $val, $suf, $icon, $order]) {
            Database::execute(
                "INSERT INTO achievements (client_slug, title_en, title_ml, count_value, suffix, icon, sort_order)
                 VALUES (?, ?, ?, ?, ?, ?, ?)",
                [$clientSlug, $tEn, $tMl, $val, $suf, $icon, $order]
            );
        }
    }

    private static function seedBannersAndAnnouncements(string $clientSlug): void
    {
        $isBank = ($clientSlug === 'kalliaseri-scb');

        // Main Banners
        Database::execute(
            "INSERT INTO banners (client_slug, title_en, title_ml, subtitle_en, subtitle_ml, image_path, link_url, button_text_en, button_text_ml, sort_order, status)
             VALUES (?, ?, ?, ?, ?, '/assets/img/hero_slide_1.jpg', '/services', ?, ?, 1, 'active')",
            [
                $clientSlug,
                $isBank ? '100 Years of Service Legacy | Class 1 Bank' : 'Empowering Farmers and Rural Households',
                $isBank ? '100 വർഷങ്ങളുടെ സേവനപാരമ്പര്യം | Class 1 ബാങ്ക്' : 'കർഷകർക്കും നാടിനും കരുത്തായി സഹകരണ പ്രസ്ഥാനം',
                $isBank ? 'Attractive deposit schemes' : 'Best-in-class interest rates on deposits and immediate sanctioning for loans.',
                $isBank ? 'ആകർഷകമായ നിക്ഷേപ പദ്ധതികൾ' : 'നിക്ഷേപങ്ങൾക്ക് ഉയർന്ന സുരക്ഷിത പലിശയും എളുപ്പത്തിൽ ലഭ്യമാകുന്ന വായ്പകളും.',
                'Explore Schemes',
                'പദ്ധതികൾ അറിയാം'
            ]
        );

        $now = date('Y-m-d H:i:s');
        $after30Days = date('Y-m-d H:i:s', strtotime('+30 days'));
        $after14Days = date('Y-m-d H:i:s', strtotime('+14 days'));

        // Emergency / Holiday Ticker
        Database::execute(
            "INSERT INTO announcements (client_slug, type, title_en, title_ml, message_en, message_ml, link_url, priority, start_date, end_date, is_active)
             VALUES (?, 'ticker', 'Notice: Rate Revision', 'അറിയിപ്പ്: പലിശ നിരക്കുകൾ പുതുക്കി', ?, ?, '/interest-rates', 'normal', ?, ?, 1)",
            [
                $clientSlug,
                'Special 9.00% p.a. interest rate for Senior Citizen 1-year Fixed Deposits now effective. 365 Days Evening Banking active at Morazha Branch.',
                'മുതിർന്ന പൗരന്മാരുടെ 1 വർഷ സ്ഥിര നിക്ഷേപങ്ങൾക്ക് 9.00% പലിശ നിരക്ക് നിലവിൽ വന്നു. മൊറാഴ ശാഖയിൽ 365 ദിവസവും സായാഹ്ന ബാങ്കിംഗ് സേവനം ലഭ്യമാണ്.',
                $now,
                $after30Days
            ]
        );

        // Popup Notice
        Database::execute(
            "INSERT INTO announcements (client_slug, type, title_en, title_ml, message_en, message_ml, link_url, priority, start_date, end_date, is_active)
             VALUES (?, 'popup_modal', 'Annual General Body Meeting Notice', 'വാർഷിക പൊതുയോഗ അറിയിപ്പ്', ?, ?, '/news/agm-notice-2026', 'urgent', ?, ?, 1)",
            [
                $clientSlug,
                'Notice is hereby given that the 57th Annual General Body Meeting of the institution will be held on Sunday at the Auditorium. All enrolled members are cordially invited.',
                'സ്ഥാപനത്തിന്റെ 57-ാമത് വാർഷിക പൊതുയോഗം ഞായറാഴ്ച രാവിലെ 10:00 മണിക്ക് ബാങ്ക് ഓഡിറ്റോറിയത്തിൽ വെച്ച് നടക്കും. എല്ലാ അംഗങ്ങളും കൃത്യസമയത്ത് എത്തിച്ചേരണമെന്ന് അഭ്യർത്ഥിക്കുന്നു.',
                $now,
                $after14Days
            ]
        );
    }

    private static function seedNewsAndDownloads(string $clientSlug): void
    {
        $today = date('Y-m-d');
        // Sample News
        Database::execute(
            "INSERT INTO news (client_slug, slug, title_en, title_ml, excerpt_en, excerpt_ml, body_en, body_ml, publish_date, status)
             VALUES (?, 'new-branch-inauguration-2026', 'New Fully Air-Conditioned Branch Inaugurated', 'പുതിയ അത്യാധുനിക ശാഖയുടെ ഉദ്ഘാടനം നടന്നു', 'State-of-the-art banking facilities and safe lockers introduced for the community.', 'ആധുനിക സേഫ് ഡെപ്പോസിറ്റ് ലോക്കറുകളോടെ പുതിയ ശാഖ പ്രവർത്തനം ആരംഭിച്ചു.', 'The newly constructed modern branch facility was officially inaugurated yesterday in the presence of distinguished dignitaries and community leaders. Equipped with 24/7 CCTV surveillance, biometric lockers, and an automated passbook printing kiosk.', 'ബാങ്കിന്റെ പുതിയ ശാഖ ജനപ്രതിനിധികളുടെയും പ്രമുഖ വ്യക്തികളുടെയും സാന്നിധ്യത്തിൽ ഉദ്ഘാടനം ചെയ്തു. ആധുനിക ലോക്കർ സൗകര്യങ്ങളും ഓട്ടോമേറ്റഡ് കിയോസ്കും ഇവിടെ ഒരുക്കിയിട്ടുണ്ട്.', ?, 'published')",
            [$clientSlug, $today]
        );

        Database::execute(
            "INSERT INTO news (client_slug, slug, title_en, title_ml, excerpt_en, excerpt_ml, body_en, body_ml, publish_date, status)
             VALUES (?, 'agm-notice-2026', '57th Annual General Body Meeting Convened', '57-ാമത് വാർഷിക പൊതുയോഗം ചേരുന്നു', 'Notice issued for the annual assembly of all A-Class registered members.', 'എല്ലാ എ-ക്ലാസ്സ് അംഗങ്ങൾക്കുമുള്ള വാർഷിക പൊതുയോഗ നോട്ടീസ് പ്രസിദ്ധീകരിച്ചു.', 'All enrolled members are requested to attend the upcoming Annual General Meeting to review the audited balance sheet, distribution of member dividends, and budget approval for the upcoming fiscal year.', 'കഴിഞ്ഞ സാമ്പത്തിക വർഷത്തെ ഓഡിറ്റ് ചെയ്ത കണക്കുകളും ഡിവിഡന്റും അംഗീകരിക്കുന്നതിനായി വാർഷിക പൊതുയോഗം ചേരുന്നു.', ?, 'published')",
            [$clientSlug, $today]
        );

        // Sample Downloads
        $downloads = [
            ['Gold Loan Application Form', 'സ്വർണ്ണ വായ്പ അപേക്ഷാ ഫോം', 'Loan Forms', '/downloads/gold_loan_application.pdf', 340, 'PDF'],
            ['Housing Loan Application & Checklist', 'ഭവന വായ്പ അപേക്ഷാ ഫോം', 'Loan Forms', '/downloads/housing_loan_application.pdf', 520, 'PDF'],
            ['Fixed Deposit Account Opening Form', 'സ്ഥിര നിക്ഷേപ അക്കൗണ്ട് ഓപ്പണിംഗ് ഫോം', 'Deposit Forms', '/downloads/fd_account_form.pdf', 280, 'PDF'],
            ['Recurring Deposit Mandate Form', 'ആവർത്തന നിക്ഷേപ ഫോം', 'Deposit Forms', '/downloads/rd_account_form.pdf', 210, 'PDF'],
            ['New Member Enrollment & KYC Form', 'അംഗത്വ അപേക്ഷ & കെ.വൈ.സി ഫോം', 'Membership & KYC', '/downloads/kyc_member_form.pdf', 310, 'PDF'],
            ['Nomination Form (DA-1)', 'നോമിനേഷൻ ഫോം (DA-1)', 'Membership & KYC', '/downloads/nomination_da1.pdf', 180, 'PDF'],
            ['Annual Audit Report 2024-25', 'വാർഷിക ഓഡിറ്റ് റിപ്പോർട്ട് 2024-25', 'Audit Reports', '/downloads/annual_report_2024_25.pdf', 1250, 'PDF'],
            ['Society Bye-Laws & Service Rules', 'സ്ഥാപന ഉപനിയമാവലി', 'Legal & Governance', '/downloads/bye_laws.pdf', 980, 'PDF'],
        ];

        foreach ($downloads as [$tEn, $tMl, $cat, $path, $size, $type]) {
            Database::execute(
                "INSERT INTO downloads (client_slug, title_en, title_ml, category, file_path, file_size_kb, file_type, status)
                 VALUES (?, ?, ?, ?, ?, ?, ?, 'active')",
                [$clientSlug, $tEn, $tMl, $cat, $path, $size, $type]
            );
        }
    }

    private static function seedTendersAndCareers(string $clientSlug): void
    {
        $after20Days = date('Y-m-d H:i:s', strtotime('+20 days'));
        $after10Days = date('Y-m-d H:i:s', strtotime('+10 days'));

        // Tenders
        Database::execute(
            "INSERT INTO tenders (client_slug, tender_ref_no, title_en, title_ml, description_en, description_ml, closing_date, file_path, status)
             VALUES (?, 'TND/2026/01', 'Installation of 25 kW Rooftop Solar Power Plant', '25 kW റൂഫ്‌ടോപ്പ് സോളാർ പവർ പ്ലാന്റ് സ്ഥാപിക്കൽ', 'Sealed quotations are invited from MNRE/ANERT authorized vendors for rooftop solar setup at Head Office.', 'ഹെഡ് ഓഫീസിൽ സോളാർ പ്ലാന്റ് സ്ഥാപിക്കുന്നതിന് അംഗീകൃത ഏജൻസികളിൽ നിന്നും ടെണ്ടർ ക്ഷണിക്കുന്നു.', ?, '/downloads/solar_tender_doc.pdf', 'active')",
            [$clientSlug, $after20Days]
        );

        Database::execute(
            "INSERT INTO tenders (client_slug, tender_ref_no, title_en, title_ml, description_en, description_ml, closing_date, file_path, status)
             VALUES (?, 'TND/2026/02', 'Comprehensive Annual Maintenance (AMC) for CBS Hardware & CCTV', 'സി.ബി.എസ് ഹാർഡ്‌വെയർ & സിസിടിവി വാർഷിക അറ്റകുറ്റപ്പണി (AMC)', 'Inviting quotations for server hardware maintenance, firewall support, and 24/7 CCTV surveillance across all branches.', 'എല്ലാ ശാഖകളിലെയും കമ്പ്യൂട്ടറുകൾ, നെറ്റ്വർക്ക്, സിസിടിവി എന്നിവയുടെ വാർഷിക അറ്റകുറ്റപ്പണിക്കായി കൊട്ടേഷൻ ക്ഷണിക്കുന്നു.', ?, '/downloads/amc_tender_doc.pdf', 'active')",
            [$clientSlug, $after10Days]
        );

        // Careers
        Database::execute(
            "INSERT INTO careers (client_slug, job_code, title_en, title_ml, department_en, department_ml, location, qualification_en, qualification_ml, experience_en, experience_ml, description_en, description_ml, last_date_to_apply, status)
             VALUES (?, 'CR-2026-01', 'Junior Clerk / Cashier', 'ജൂനിയർ ക്ലർക്ക് / കാഷ്യർ', 'Banking Operations', 'ബാങ്കിംഗ് വിഭാഗം', 'All Branches', 'Recognized University Degree + JDC / HDC / HDCM with basic computer operations knowledge.', 'അംഗീകൃത ബിരുദവും ജെ.ഡി.സി (JDC) അല്ലെങ്കിൽ എച്ച്.ഡി.സി (HDC) വിജയവും, കമ്പ്യൂട്ടർ പരിജ്ഞാനവും.', 'Freshers / Up to 2 years', 'പരിചയം അഭികാമ്യം', 'Handling customer counter operations, deposit receipts, loan documentation, and passbook issuance.', 'കൗണ്ടർ ഇടപാടുകൾ, നിക്ഷേപ രസീതുകൾ, വായ്പാ രേഖകൾ തയ്യാറാക്കൽ എന്നിവ കൈകാര്യം ചെയ്യൽ.', ?, 'open')",
            [$clientSlug, date('Y-m-d', strtotime('+25 days'))]
        );

        Database::execute(
            "INSERT INTO careers (client_slug, job_code, title_en, title_ml, department_en, department_ml, location, qualification_en, qualification_ml, experience_en, experience_ml, description_en, description_ml, last_date_to_apply, status)
             VALUES (?, 'CR-2026-02', 'Gold Loan Appraiser', 'സ്വർണ്ണ വായ്പാ അപ്രൈസർ', 'Credit & Appraisal', 'സ്വർണ്ണ വായ്പാ വിഭാഗം', 'Main Branch', 'SSLC Pass + Recognized Gold Appraisal Certification from approved institute.', 'എസ്.എസ്.എൽ.സി ജയവും അംഗീകൃത സ്വർണ്ണ പരിശോധാ സർട്ടിഫിക്കറ്റും.', 'Minimum 3 years appraisal experience', 'കുറഞ്ഞത് 3 വർഷത്തെ പ്രവൃത്തിപരിചയം', 'Assessing purity, carat grading, and weighing of pledged gold ornaments in compliance with bank standards.', 'പണയം വെക്കുന്ന സ്വർണ്ണാഭരണങ്ങളുടെ പരിശുദ്ധി കൃത്യമായി നിർണ്ണയിക്കലും പരിശോധനയും.', ?, 'open')",
            [$clientSlug, date('Y-m-d', strtotime('+15 days'))]
        );
    }

    private static function seedCalculatorsConfig(string $clientSlug): void
    {
        $configs = [
            [
                'emi',
                json_encode(['default_principal' => 500000, 'default_rate' => 9.25, 'default_tenure_months' => 60]),
                'EMI calculation is indicative only and calculated on reducing balance method.',
                'ഇ.എം.ഐ കണക്കുകൂട്ടൽ സൂചന മാത്രമാണ്; കുറഞ്ഞുവരുന്ന ബാക്കി തുകയെ അടിസ്ഥാനമാക്കിയാണ് കണക്കാക്കുന്നത്.'
            ],
            [
                'gold_loan',
                json_encode(['rate_per_gram_22k' => 5200, 'max_ltv_percentage' => 75]),
                'Gold loan eligibility is based on net weight of 22-carat gold and prevailing market appraisal.',
                'സ്വർണ്ണ വായ്പാ പരിധി 22 കാരറ്റ് ആഭരണങ്ങളുടെ അറ്റ ഭാരത്തെയും അംഗീകൃത മൂല്യത്തെയും അടിസ്ഥാനമാക്കിയുള്ളതാണ്.'
            ],
            [
                'deposit_maturity',
                json_encode(['compounding_frequency' => 'quarterly', 'senior_bonus_rate' => 0.50]),
                'Maturity value calculated on quarterly compounding interest basis.',
                'ത്രൈമാസ കൂട്ടുപലിശ അടിസ്ഥാനത്തിലാണ് മെച്യൂരിറ്റി തുക കണക്കാക്കുന്നത്.'
            ]
        ];

        foreach ($configs as [$type, $json, $discEn, $discMl]) {
            Database::execute(
                "INSERT INTO calculators_config (client_slug, calculator_type, config_json, disclaimer_en, disclaimer_ml)
                 VALUES (?, ?, ?, ?, ?)
                 ON DUPLICATE KEY UPDATE config_json=VALUES(config_json)",
                [$clientSlug, $type, $json, $discEn, $discMl]
            );
        }
    }

    /**
     * kalliaseri-scb only: the template seeds (products, deposit rates, news, branches,
     * board, announcements, downloads, tenders, careers) contain invented placeholder data.
     * Hide it so only client-supplied content is public. Reversible by flipping status flags.
     */
    private static function hideTemplateFiller(string $clientSlug): void
    {
        if ($clientSlug !== 'kalliaseri-scb') {
            return;
        }
        $c = [$clientSlug];
        Database::execute("UPDATE news SET status = 'draft' WHERE client_slug = ?", $c);
        Database::execute("UPDATE board_members SET status = 'inactive' WHERE client_slug = ?", $c);
        Database::execute("UPDATE announcements SET is_active = 0 WHERE client_slug = ?", $c);
        Database::execute("UPDATE downloads SET status = 'inactive' WHERE client_slug = ?", $c);
        Database::execute("UPDATE products SET status = 'draft' WHERE client_slug = ?", $c);
        Database::execute("UPDATE product_rates SET is_active = 0 WHERE client_slug = ? AND category_type = 'deposit'", $c);
        Database::execute("DELETE FROM tenders WHERE client_slug = ?", $c);
        Database::execute("DELETE FROM careers WHERE client_slug = ?", $c);
        // Keep only the head office (the branch selector in forms is mandatory)
        Database::execute("UPDATE branches SET status = 'inactive' WHERE client_slug = ? AND is_head_office = 0", $c);
        Database::execute(
            "UPDATE branches SET manager_name = NULL, manager_phone = NULL, has_365_days = 0, has_locker = 0, has_gold_loan = 0, has_atm = 0
             WHERE client_slug = ? AND is_head_office = 1",
            $c
        );
        $badges = [
            ['Loans up to ₹4 Lakhs', '≤ ₹4L', '4 ലക്ഷം വരെ'],
            ['Loans above ₹4 Lakhs up to ₹8 Lakhs', '₹4L – ₹8L', '4 – 8 ലക്ഷം'],
            ['Loans above ₹8 Lakhs', '> ₹8L', '8 ലക്ഷത്തിന് മുകളിൽ'],
        ];
        foreach ($badges as [$label, $en, $ml]) {
            Database::execute(
                "UPDATE product_rates SET notes_en = ?, notes_ml = ? WHERE client_slug = ? AND tenure_label_en = ?",
                [$en, $ml, $clientSlug, $label]
            );
        }
    }
}
