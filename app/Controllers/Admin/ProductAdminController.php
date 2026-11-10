<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use Core\Request;
use Core\Response;
use Core\Database;
use Core\Settings;
use Core\Session;

class ProductAdminController
{
    public function index(Request $request): Response
    {
        $clientSlug = Settings::clientSlug();

        $products = Database::fetchAll(
            "SELECT p.*, c.name_en as cat_name, c.type as cat_type
             FROM products p
             JOIN product_categories c ON p.category_id = c.id
             WHERE p.client_slug = ?
             ORDER BY c.sort_order ASC, p.sort_order ASC",
            [$clientSlug]
        );

        $response = new Response();
        return $response->view('admin/products', [
            'title' => 'Products & Schemes Catalogue',
            'activeNav' => 'products',
            'products' => $products,
        ], 'admin');
    }

    public function toggle(Request $request): Response
    {
        $clientSlug = Settings::clientSlug();
        $id = (int)$request->input('id', 0);
        $status = $request->input('status') === 'published' ? 'draft' : 'published';

        Database::execute(
            "UPDATE products SET status = ? WHERE id = ? AND client_slug = ?",
            [$status, $id, $clientSlug]
        );

        Session::flash('success', "Product status changed to {$status}.");
        $response = new Response();
        return $response->redirect('/admin/products');
    }
}
