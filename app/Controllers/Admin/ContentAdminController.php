<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use Core\Request;
use Core\Response;
use Core\Database;
use Core\Settings;
use Core\Session;

class ContentAdminController
{
    public function news(Request $request): Response
    {
        $clientSlug = Settings::clientSlug();

        $news = Database::fetchAll(
            "SELECT * FROM news WHERE client_slug = ? ORDER BY publish_date DESC",
            [$clientSlug]
        );

        $response = new Response();
        return $response->view('admin/news', [
            'title' => 'News & Events Management',
            'activeNav' => 'news',
            'news' => $news,
        ], 'admin');
    }

    public function saveNews(Request $request): Response
    {
        $clientSlug = Settings::clientSlug();
        $id = (int)$request->input('id', 0);
        $titleEn = trim((string)$request->input('title_en', ''));
        $titleMl = trim((string)$request->input('title_ml', ''));
        $excerptEn = trim((string)$request->input('excerpt_en', ''));
        $excerptMl = trim((string)$request->input('excerpt_ml', ''));
        $bodyEn = trim((string)$request->input('body_en', ''));
        $bodyMl = trim((string)$request->input('body_ml', ''));
        $publishDate = trim((string)$request->input('publish_date', date('Y-m-d')));
        $status = trim((string)$request->input('status', 'published'));

        if ($id > 0) {
            Database::execute(
                "UPDATE news SET title_en = ?, title_ml = ?, excerpt_en = ?, excerpt_ml = ?, body_en = ?, body_ml = ?, publish_date = ?, status = ?
                 WHERE id = ? AND client_slug = ?",
                [$titleEn, $titleMl, $excerptEn, $excerptMl, $bodyEn, $bodyMl, $publishDate, $status, $id, $clientSlug]
            );
            Session::flash('success', 'News article updated successfully.');
        } else {
            $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $titleEn), '-')) . '-' . date('Y');
            Database::execute(
                "INSERT INTO news (client_slug, slug, title_en, title_ml, excerpt_en, excerpt_ml, body_en, body_ml, publish_date, status)
                 VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",
                [$clientSlug, $slug, $titleEn, $titleMl, $excerptEn, $excerptMl, $bodyEn, $bodyMl, $publishDate, $status]
            );
            Session::flash('success', 'News article published successfully.');
        }

        $response = new Response();
        return $response->redirect('/admin/news');
    }

    public function downloads(Request $request): Response
    {
        $clientSlug = Settings::clientSlug();

        $downloads = Database::fetchAll(
            "SELECT * FROM downloads WHERE client_slug = ? ORDER BY category ASC, id DESC",
            [$clientSlug]
        );

        $response = new Response();
        return $response->view('admin/downloads', [
            'title' => 'Downloads & Forms',
            'activeNav' => 'downloads',
            'downloads' => $downloads,
        ], 'admin');
    }

    public function saveDownload(Request $request): Response
    {
        $clientSlug = Settings::clientSlug();
        $id = (int)$request->input('id', 0);
        $titleEn = trim((string)$request->input('title_en', ''));
        $titleMl = trim((string)$request->input('title_ml', ''));
        $category = trim((string)$request->input('category', 'General'));
        $filePath = trim((string)$request->input('file_path', '/downloads/sample_form.pdf'));
        $fileSizeKb = (int)$request->input('file_size_kb', 250);

        if ($id > 0) {
            Database::execute(
                "UPDATE downloads SET title_en = ?, title_ml = ?, category = ?, file_path = ?, file_size_kb = ?
                 WHERE id = ? AND client_slug = ?",
                [$titleEn, $titleMl, $category, $filePath, $fileSizeKb, $id, $clientSlug]
            );
            Session::flash('success', 'Download item updated.');
        } else {
            Database::execute(
                "INSERT INTO downloads (client_slug, title_en, title_ml, category, file_path, file_size_kb, status)
                 VALUES (?, ?, ?, ?, ?, ?, 'active')",
                [$clientSlug, $titleEn, $titleMl, $category, $filePath, $fileSizeKb]
            );
            Session::flash('success', 'Download item added.');
        }

        $response = new Response();
        return $response->redirect('/admin/downloads');
    }

    public function announcements(Request $request): Response
    {
        $clientSlug = Settings::clientSlug();

        $announcements = Database::fetchAll(
            "SELECT * FROM announcements WHERE client_slug = ? ORDER BY id DESC",
            [$clientSlug]
        );

        $response = new Response();
        return $response->view('admin/announcements', [
            'title' => 'Announcements & Alerts',
            'activeNav' => 'announcements',
            'announcements' => $announcements,
        ], 'admin');
    }

    public function board(Request $request): Response
    {
        $clientSlug = Settings::clientSlug();

        $members = Database::fetchAll(
            "SELECT * FROM board_members WHERE client_slug = ? ORDER BY sort_order ASC",
            [$clientSlug]
        );

        $response = new Response();
        return $response->view('admin/board', [
            'title' => 'Board of Directors & Executives',
            'activeNav' => 'board',
            'members' => $members,
        ], 'admin');
    }

    public function pages(Request $request): Response
    {
        $pages = [
            ['title' => 'Who We Are (About Us)', 'url' => '/about', 'desc' => 'Historical overview, core co-operative values, mission and vision.'],
            ['title' => 'Board of Directors', 'url' => '/board', 'desc' => 'Elected board members, designations, and contact profiles.'],
            ['title' => 'President’s Desk', 'url' => '/chairperson-message', 'desc' => 'President / Chairperson official address to members and depositors.'],
            ['title' => 'Achievements & Milestones', 'url' => '/achievements', 'desc' => 'Statutory Class A audit ratings, growth history, and community trust metrics.'],
            ['title' => 'Welfare Projects', 'url' => '/welfare', 'desc' => 'Healthcare, dialysis relief, scholarship endowments, and farmer clinics.'],
            ['title' => 'Legal & Governance Framework', 'url' => '/legal-framework', 'desc' => 'Kerala Co-operative Societies Act 1969 & statutory compliance disclosures.'],
            ['title' => 'Privacy Policy (DPDP Compliance)', 'url' => '/privacy-policy', 'desc' => 'Digital Personal Data Protection Act compliance statement and data handling.'],
            ['title' => 'Terms & Conditions', 'url' => '/terms', 'desc' => 'Banking terms, disclaimers, and service conditions.'],
        ];

        $response = new Response();
        return $response->view('admin/pages', [
            'title' => 'Static & Legal Content Pages',
            'activeNav' => 'pages',
            'pages' => $pages,
        ], 'admin');
    }

    public function banners(Request $request): Response
    {
        $clientSlug = Settings::clientSlug();

        $banners = Database::fetchAll(
            "SELECT * FROM banners WHERE client_slug = ? ORDER BY sort_order ASC",
            [$clientSlug]
        );

        $response = new Response();
        return $response->view('admin/banners', [
            'title' => 'Banners & Hero Sliders',
            'activeNav' => 'banners',
            'banners' => $banners,
        ], 'admin');
    }

    public function settings(Request $request): Response
    {
        $clientSlug = Settings::clientSlug();

        $settings = Database::fetchAll(
            "SELECT * FROM settings WHERE client_slug = ? OR client_slug IS NULL",
            [$clientSlug]
        );

        $response = new Response();
        return $response->view('admin/settings', [
            'title' => 'Settings & Regulatory Profile',
            'activeNav' => 'settings',
            'settings' => $settings,
        ], 'admin');
    }

    public function audit(Request $request): Response
    {
        $clientSlug = Settings::clientSlug();

        $users = Database::fetchAll(
            "SELECT u.name, u.username, u.email, u.last_login_at, u.last_login_ip, r.name as role_name 
             FROM users u 
             JOIN roles r ON u.role_id = r.id 
             WHERE u.client_slug = ?",
            [$clientSlug]
        );

        $response = new Response();
        return $response->view('admin/audit', [
            'title' => 'System & Security Audit Log',
            'activeNav' => 'audit',
            'users' => $users,
        ], 'admin');
    }
}
