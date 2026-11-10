<?php
declare(strict_types=1);

namespace App\Controllers;

use Core\Request;
use Core\Response;
use Core\Database;

class HomeController
{
    public function index(Request $request): Response
    {
        $clientSlug = client_slug();

        // 1. Fetch Banner
        $banner = Database::fetchOne(
            "SELECT * FROM banners WHERE client_slug = ? AND status = 'active' ORDER BY sort_order ASC LIMIT 1",
            [$clientSlug]
        );

        // 2. Fetch Achievements
        $achievements = Database::fetchAll(
            "SELECT * FROM achievements WHERE client_slug = ? ORDER BY sort_order ASC",
            [$clientSlug]
        );

        // 3. Fetch Rates for Deposit & Loan Panels
        $depositRates = Database::fetchAll(
            "SELECT * FROM product_rates 
             WHERE client_slug = ? AND category_type = 'deposit' AND is_active = 1 
             ORDER BY sort_order ASC, general_rate ASC",
            [$clientSlug]
        );

        $loanRates = Database::fetchAll(
            "SELECT * FROM product_rates 
             WHERE client_slug = ? AND category_type = 'loan' AND is_active = 1 
             ORDER BY sort_order ASC, general_rate ASC",
            [$clientSlug]
        );

        // 4. Fetch Chairperson
        $chairperson = Database::fetchOne(
            "SELECT * FROM board_members WHERE client_slug = ? AND role_type = 'chairperson' AND status = 'active' LIMIT 1",
            [$clientSlug]
        );

        // 5. Fetch Branches preview
        $branches = Database::fetchAll(
            "SELECT * FROM branches WHERE client_slug = ? AND status = 'active' ORDER BY is_head_office DESC, sort_order ASC LIMIT 4",
            [$clientSlug]
        );

        $response = new Response();
        return $response->view('pages/home', [
            'meta_title' => __('nav_home'),
            'banner' => $banner,
            'achievements' => $achievements,
            'deposit_rates' => $depositRates,
            'loan_rates' => $loanRates,
            'chairperson' => $chairperson,
            'branches' => $branches,
        ]);
    }
}
