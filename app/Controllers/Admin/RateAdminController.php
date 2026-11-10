<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use Core\Request;
use Core\Response;
use Core\Database;
use Core\Settings;
use Core\Session;

class RateAdminController
{
    public function index(Request $request): Response
    {
        $clientSlug = Settings::clientSlug();

        $depositRates = Database::fetchAll(
            "SELECT * FROM product_rates WHERE client_slug = ? AND category_type = 'deposit' ORDER BY sort_order ASC, general_rate ASC",
            [$clientSlug]
        );

        $loanRates = Database::fetchAll(
            "SELECT * FROM product_rates WHERE client_slug = ? AND category_type = 'loan' ORDER BY sort_order ASC, general_rate ASC",
            [$clientSlug]
        );

        $response = new Response();
        return $response->view('admin/rates', [
            'title' => 'Unified Rate Engine',
            'activeNav' => 'rates',
            'depositRates' => $depositRates,
            'loanRates' => $loanRates,
        ], 'admin');
    }

    public function save(Request $request): Response
    {
        $clientSlug = Settings::clientSlug();
        $id = (int)$request->input('id', 0);
        $categoryType = $request->input('category_type', 'deposit');
        $tenureEn = trim((string)$request->input('tenure_label_en', ''));
        $tenureMl = trim((string)$request->input('tenure_label_ml', ''));
        $generalRate = (float)$request->input('general_rate', 0.0);
        $seniorRate = $request->input('senior_rate') !== '' ? (float)$request->input('senior_rate') : null;
        $effectiveFrom = trim((string)$request->input('effective_from', date('Y-m-d')));

        if ($id > 0) {
            Database::execute(
                "UPDATE product_rates SET 
                 tenure_label_en = ?, tenure_label_ml = ?, general_rate = ?, senior_rate = ?, effective_from = ?
                 WHERE id = ? AND client_slug = ?",
                [$tenureEn, $tenureMl, $generalRate, $seniorRate, $effectiveFrom, $id, $clientSlug]
            );
            Session::flash('success', 'Rate slab updated successfully.');
        } else {
            Database::execute(
                "INSERT INTO product_rates (client_slug, category_type, tenure_label_en, tenure_label_ml, general_rate, senior_rate, effective_from, is_active)
                 VALUES (?, ?, ?, ?, ?, ?, ?, 1)",
                [$clientSlug, $categoryType, $tenureEn, $tenureMl, $generalRate, $seniorRate, $effectiveFrom]
            );
            Session::flash('success', 'New rate slab added successfully.');
        }

        $response = new Response();
        return $response->redirect('/admin/rates');
    }

    public function delete(Request $request): Response
    {
        $clientSlug = Settings::clientSlug();
        $id = (int)$request->input('id', 0);

        Database::execute(
            "DELETE FROM product_rates WHERE id = ? AND client_slug = ?",
            [$id, $clientSlug]
        );

        Session::flash('success', 'Rate slab removed.');
        $response = new Response();
        return $response->redirect('/admin/rates');
    }
}
