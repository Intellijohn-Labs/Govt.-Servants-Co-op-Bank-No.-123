<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use Core\Request;
use Core\Response;
use Core\Database;
use Core\Settings;

class DashboardController
{
    public function index(Request $request): Response
    {
        $clientSlug = Settings::clientSlug();

        // Count metrics
        $branchCount = Database::fetchOne("SELECT COUNT(*) as count FROM branches WHERE client_slug = ?", [$clientSlug])['count'] ?? 0;
        $productCount = Database::fetchOne("SELECT COUNT(*) as count FROM products WHERE client_slug = ?", [$clientSlug])['count'] ?? 0;
        $enquiryCount = Database::fetchOne("SELECT COUNT(*) as count FROM enquiries WHERE client_slug = ?", [$clientSlug])['count'] ?? 0;
        $newEnquiries = Database::fetchOne("SELECT COUNT(*) as count FROM enquiries WHERE client_slug = ? AND status = 'new'", [$clientSlug])['count'] ?? 0;

        // Recent enquiries
        $recentEnquiries = Database::fetchAll(
            "SELECT e.*, b.name_en as branch_name 
             FROM enquiries e 
             LEFT JOIN branches b ON e.branch_id = b.id 
             WHERE e.client_slug = ? 
             ORDER BY e.id DESC LIMIT 5",
            [$clientSlug]
        );

        $response = new Response();
        return $response->view('admin/dashboard', [
            'title' => 'Administrative Dashboard',
            'activeNav' => 'dashboard',
            'branchCount' => $branchCount,
            'productCount' => $productCount,
            'enquiryCount' => $enquiryCount,
            'newEnquiries' => $newEnquiries,
            'recentEnquiries' => $recentEnquiries,
        ], 'admin');
    }
}
