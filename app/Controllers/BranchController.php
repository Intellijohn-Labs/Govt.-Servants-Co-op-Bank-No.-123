<?php
declare(strict_types=1);

namespace App\Controllers;

use Core\Request;
use Core\Response;
use Core\Database;

class BranchController
{
    public function index(Request $request): Response
    {
        $clientSlug = client_slug();
        $query = trim((string)$request->input('q', ''));
        $filterLocker = $request->input('locker') === '1';
        $filter365 = $request->input('365') === '1';

        $sql = "SELECT * FROM branches WHERE client_slug = ? AND status = 'active'";
        $params = [$clientSlug];

        if ($query !== '') {
            $sql .= " AND (name_en LIKE ? OR name_ml LIKE ? OR address_en LIKE ? OR district LIKE ?)";
            $searchTerm = "%{$query}%";
            $params = array_merge($params, [$searchTerm, $searchTerm, $searchTerm, $searchTerm]);
        }

        if ($filterLocker) {
            $sql .= " AND has_locker = 1";
        }

        if ($filter365) {
            $sql .= " AND has_365_days = 1";
        }

        $sql .= " ORDER BY is_head_office DESC, sort_order ASC, name_en ASC";

        $branches = Database::fetchAll($sql, $params);

        $response = new Response();
        return $response->view('pages/branches', [
            'meta_title' => __('nav_branches'),
            'branches' => $branches,
            'search_query' => $query,
            'filter_locker' => $filterLocker,
            'filter_365' => $filter365,
        ]);
    }
}
