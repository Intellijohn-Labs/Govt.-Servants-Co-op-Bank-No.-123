<?php
declare(strict_types=1);

namespace App\Controllers;

use Core\Request;
use Core\Response;
use Core\Database;

class PageController
{
    public function about(Request $request): Response
    {
        $response = new Response();
        return $response->view('pages/about', [
            'meta_title' => __('nav_who_we_are'),
            'meta_desc' => setting('tagline', 'History and mission of the institution'),
        ]);
    }

    public function board(Request $request): Response
    {
        $members = Database::fetchAll(
            "SELECT * FROM board_members WHERE client_slug = ? AND status = 'active' ORDER BY sort_order ASC",
            [client_slug()]
        );

        $response = new Response();
        return $response->view('pages/board', [
            'meta_title' => __('nav_board'),
            'members' => $members,
        ]);
    }

    public function chairpersonMessage(Request $request): Response
    {
        $chairperson = Database::fetchOne(
            "SELECT * FROM board_members WHERE client_slug = ? AND role_type = 'chairperson' AND status = 'active' LIMIT 1",
            [client_slug()]
        );

        $response = new Response();
        return $response->view('pages/chairperson_message', [
            'meta_title' => __('nav_chairperson_msg'),
            'chairperson' => $chairperson,
        ]);
    }

    public function legal(Request $request): Response
    {
        $response = new Response();
        return $response->view('pages/legal', [
            'meta_title' => __('nav_legal_framework'),
        ]);
    }

    public function privacy(Request $request): Response
    {
        $response = new Response();
        return $response->view('pages/privacy', [
            'meta_title' => __('Privacy Policy', 'സ്വകാര്യതാ നയം'),
        ]);
    }

    public function terms(Request $request): Response
    {
        $response = new Response();
        return $response->view('pages/terms', [
            'meta_title' => __('Terms & Conditions', 'ഉപയോഗ നിബന്ധനകൾ'),
        ]);
    }

    public function sitemap(Request $request): Response
    {
        $response = new Response();
        return $response->view('pages/sitemap', [
            'meta_title' => __('Sitemap', 'സൈറ്റ്മാപ്പ്'),
        ]);
    }

    public function achievements(Request $request): Response
    {
        $clientSlug = client_slug();

        $achievements = Database::fetchAll(
            "SELECT * FROM achievements WHERE client_slug = ? ORDER BY sort_order ASC",
            [$clientSlug]
        );

        $response = new Response();
        return $response->view('pages/achievements', [
            'meta_title' => __('nav_achievements'),
            'achievements' => $achievements,
        ]);
    }

    public function welfare(Request $request): Response
    {
        $response = new Response();
        return $response->view('pages/welfare', [
            'meta_title' => __('nav_welfare'),
        ]);
    }

    public function downloads(Request $request): Response
    {
        $clientSlug = client_slug();

        $downloads = Database::fetchAll(
            "SELECT * FROM downloads WHERE client_slug = ? AND status = 'active' ORDER BY category ASC, title_en ASC",
            [$clientSlug]
        );

        $grouped = [];
        foreach ($downloads as $item) {
            $cat = $item['category'];
            $grouped[$cat][] = $item;
        }

        $response = new Response();
        return $response->view('pages/downloads', [
            'meta_title' => __('nav_downloads'),
            'grouped_downloads' => $grouped,
        ]);
    }

    public function tenders(Request $request): Response
    {
        $clientSlug = client_slug();

        $tenders = Database::fetchAll(
            "SELECT * FROM tenders WHERE client_slug = ? ORDER BY closing_date DESC",
            [$clientSlug]
        );

        $response = new Response();
        return $response->view('pages/tenders', [
            'meta_title' => __('nav_tenders'),
            'tenders' => $tenders,
        ]);
    }

    public function careers(Request $request): Response
    {
        $clientSlug = client_slug();

        $careers = Database::fetchAll(
            "SELECT * FROM careers WHERE client_slug = ? ORDER BY last_date_to_apply DESC",
            [$clientSlug]
        );

        $response = new Response();
        return $response->view('pages/careers', [
            'meta_title' => __('nav_careers'),
            'careers' => $careers,
        ]);
    }

    public function search(Request $request): Response
    {
        $clientSlug = client_slug();
        $query = trim((string)$request->input('q', ''));

        $results = [
            'products' => [],
            'branches' => [],
            'downloads' => [],
            'news' => [],
        ];

        if ($query !== '') {
            $wildcard = "%{$query}%";

            $results['products'] = Database::fetchAll(
                "SELECT id, slug, name_en, name_ml, tagline_en, tagline_ml, 'product' as item_type 
                 FROM products 
                 WHERE client_slug = ? AND status = 'published' AND (name_en LIKE ? OR name_ml LIKE ? OR overview_en LIKE ? OR overview_ml LIKE ?)
                 LIMIT 8",
                [$clientSlug, $wildcard, $wildcard, $wildcard, $wildcard]
            );

            $results['branches'] = Database::fetchAll(
                "SELECT id, slug, name_en, name_ml, address_en, address_ml, phone, 'branch' as item_type 
                 FROM branches 
                 WHERE client_slug = ? AND status = 'active' AND (name_en LIKE ? OR name_ml LIKE ? OR address_en LIKE ? OR address_ml LIKE ?)
                 LIMIT 5",
                [$clientSlug, $wildcard, $wildcard, $wildcard, $wildcard]
            );

            $results['downloads'] = Database::fetchAll(
                "SELECT id, title_en, title_ml, category, file_path, file_size_kb, 'download' as item_type 
                 FROM downloads 
                 WHERE client_slug = ? AND status = 'active' AND (title_en LIKE ? OR title_ml LIKE ?)
                 LIMIT 5",
                [$clientSlug, $wildcard, $wildcard]
            );

            $results['news'] = Database::fetchAll(
                "SELECT id, slug, title_en, title_ml, excerpt_en, excerpt_ml, publish_date, 'news' as item_type 
                 FROM news 
                 WHERE client_slug = ? AND status = 'published' AND (title_en LIKE ? OR title_ml LIKE ? OR body_en LIKE ? OR body_ml LIKE ?)
                 LIMIT 5",
                [$clientSlug, $wildcard, $wildcard, $wildcard, $wildcard]
            );
        }

        $response = new Response();
        return $response->view('pages/search', [
            'meta_title' => __('Search Results', 'തിരച്ചിൽ ഫലങ്ങൾ'),
            'query' => $query,
            'results' => $results,
        ]);
    }

    public function newsIndex(Request $request): Response
    {
        $clientSlug = client_slug();

        $news = Database::fetchAll(
            "SELECT * FROM news WHERE client_slug = ? AND status = 'published' ORDER BY publish_date DESC",
            [$clientSlug]
        );

        $response = new Response();
        return $response->view('pages/news', [
            'meta_title' => __('nav_news'),
            'news_list' => $news,
        ]);
    }

    public function newsShow(Request $request, string $slug): Response
    {
        $clientSlug = client_slug();

        $article = Database::fetchOne(
            "SELECT * FROM news WHERE client_slug = ? AND slug = ? AND status = 'published' LIMIT 1",
            [$clientSlug, $slug]
        );

        if (!$article) {
            $response = new Response();
            return $response->status(404)->view('errors/404', [
                'title' => __('Article Not Found', 'വാർത്ത കണ്ടെത്താനായില്ല')
            ]);
        }

        $recent = Database::fetchAll(
            "SELECT * FROM news WHERE client_slug = ? AND id != ? AND status = 'published' ORDER BY publish_date DESC LIMIT 4",
            [$clientSlug, $article['id']]
        );

        $response = new Response();
        return $response->view('pages/news_detail', [
            'meta_title' => is_malayalam() ? $article['title_ml'] : $article['title_en'],
            'meta_desc' => is_malayalam() ? ($article['excerpt_ml'] ?? '') : ($article['excerpt_en'] ?? ''),
            'article' => $article,
            'recent' => $recent,
        ]);
    }
}
