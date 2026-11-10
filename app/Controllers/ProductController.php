<?php
declare(strict_types=1);

namespace App\Controllers;

use Core\Request;
use Core\Response;
use Core\Database;

class ProductController
{
    public function services(Request $request): Response
    {
        $clientSlug = client_slug();

        $categories = Database::fetchAll(
            "SELECT * FROM product_categories WHERE client_slug = ? AND status = 'active' ORDER BY sort_order ASC",
            [$clientSlug]
        );

        $products = Database::fetchAll(
            "SELECT p.*, c.slug as category_slug, c.name_en as cat_name_en, c.name_ml as cat_name_ml, c.type as cat_type
             FROM products p
             JOIN product_categories c ON p.category_id = c.id
             WHERE p.client_slug = ? AND p.status = 'published'
             ORDER BY p.sort_order ASC",
            [$clientSlug]
        );

        $grouped = [];
        foreach ($products as $prod) {
            $catType = $prod['cat_type'];
            $grouped[$catType][] = $prod;
        }

        $response = new Response();
        return $response->view('pages/services', [
            'meta_title' => __('nav_services'),
            'categories' => $categories,
            'grouped_products' => $grouped,
        ]);
    }

    public function show(Request $request, string $slug): Response
    {
        $clientSlug = client_slug();

        $product = Database::fetchOne(
            "SELECT p.*, c.name_en as cat_name_en, c.name_ml as cat_name_ml, c.type as cat_type
             FROM products p
             JOIN product_categories c ON p.category_id = c.id
             WHERE p.client_slug = ? AND p.slug = ? AND p.status = 'published'
             LIMIT 1",
            [$clientSlug, $slug]
        );

        if (!$product) {
            $response = new Response();
            return $response->status(404)->view('errors/404', [
                'title' => __('Product Not Found', 'പദ്ധതി കണ്ടെത്താനായില്ല')
            ]);
        }

        // Scheme variants (e.g. Express Gold loan, 6-Month, Agri gold loan)
        $variants = Database::fetchAll(
            "SELECT * FROM product_variants WHERE product_id = ? ORDER BY sort_order ASC",
            [$product['id']]
        );

        // Required KYC & security documents
        $documents = Database::fetchAll(
            "SELECT * FROM product_documents WHERE product_id = ? ORDER BY sort_order ASC",
            [$product['id']]
        );

        // FAQs
        $faqs = Database::fetchAll(
            "SELECT * FROM product_faqs WHERE product_id = ? ORDER BY sort_order ASC",
            [$product['id']]
        );

        // Related schemes
        $related = Database::fetchAll(
            "SELECT * FROM products WHERE client_slug = ? AND category_id = ? AND id != ? AND status = 'published' LIMIT 3",
            [$clientSlug, $product['category_id'], $product['id']]
        );

        $response = new Response();
        return $response->view('pages/product_detail', [
            'meta_title' => is_malayalam() ? $product['name_ml'] : $product['name_en'],
            'meta_desc' => is_malayalam() ? ($product['tagline_ml'] ?? '') : ($product['tagline_en'] ?? ''),
            'product' => $product,
            'variants' => $variants,
            'documents' => $documents,
            'faqs' => $faqs,
            'related' => $related,
        ]);
    }
}
