<?php
declare(strict_types=1);

namespace App\Controllers;

use Core\Request;
use Core\Response;
use Core\Database;

class RateController
{
    public function index(Request $request): Response
    {
        $clientSlug = client_slug();

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

        $response = new Response();
        return $response->view('pages/rates', [
            'meta_title' => __('nav_rates'),
            'deposit_rates' => $depositRates,
            'loan_rates' => $loanRates,
        ]);
    }
}
