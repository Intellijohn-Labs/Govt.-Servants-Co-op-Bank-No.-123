<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use Core\Request;
use Core\Response;
use Core\Database;
use Core\Settings;
use Core\Session;

class BranchAdminController
{
    public function index(Request $request): Response
    {
        $clientSlug = Settings::clientSlug();

        $branches = Database::fetchAll(
            "SELECT * FROM branches WHERE client_slug = ? ORDER BY is_head_office DESC, sort_order ASC, name_en ASC",
            [$clientSlug]
        );

        $response = new Response();
        return $response->view('admin/branches', [
            'title' => 'Branches & Office Network',
            'activeNav' => 'branches',
            'branches' => $branches,
        ], 'admin');
    }

    public function save(Request $request): Response
    {
        $clientSlug = Settings::clientSlug();
        $id = (int)$request->input('id', 0);
        $code = trim((string)$request->input('code', ''));
        $nameEn = trim((string)$request->input('name_en', ''));
        $nameMl = trim((string)$request->input('name_ml', ''));
        $addressEn = trim((string)$request->input('address_en', ''));
        $addressMl = trim((string)$request->input('address_ml', ''));
        $phone = trim((string)$request->input('phone', ''));
        $email = trim((string)$request->input('email', ''));
        $managerName = trim((string)$request->input('manager_name', ''));
        $managerPhone = trim((string)$request->input('manager_phone', ''));
        $workingHoursEn = trim((string)$request->input('working_hours_en', 'Mon - Sat: 9:30 AM - 4:30 PM'));
        $workingHoursMl = trim((string)$request->input('working_hours_ml', 'തിങ്കൾ - ശനി: 9:30 AM - 4:30 PM'));
        $hasLocker = $request->input('has_locker') ? 1 : 0;
        $has365 = $request->input('has_365_days') ? 1 : 0;
        $hasGoldLoan = $request->input('has_gold_loan') ? 1 : 0;
        $hasAtm = $request->input('has_atm') ? 1 : 0;
        $status = trim((string)$request->input('status', 'active'));

        if ($id > 0) {
            Database::execute(
                "UPDATE branches SET 
                 code = ?, name_en = ?, name_ml = ?, address_en = ?, address_ml = ?, 
                 phone = ?, email = ?, manager_name = ?, manager_phone = ?,
                 working_hours_en = ?, working_hours_ml = ?, has_locker = ?, has_365_days = ?,
                 has_gold_loan = ?, has_atm = ?, status = ?
                 WHERE id = ? AND client_slug = ?",
                [
                    $code, $nameEn, $nameMl, $addressEn, $addressMl,
                    $phone, $email, $managerName, $managerPhone,
                    $workingHoursEn, $workingHoursMl, $hasLocker, $has365,
                    $hasGoldLoan, $hasAtm, $status, $id, $clientSlug
                ]
            );
            Session::flash('success', 'Branch updated successfully.');
        } else {
            $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $nameEn), '-'));
            Database::execute(
                "INSERT INTO branches (client_slug, code, name_en, name_ml, slug, address_en, address_ml, phone, email, manager_name, manager_phone, working_hours_en, working_hours_ml, has_locker, has_365_days, has_gold_loan, has_atm, status)
                 VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",
                [
                    $clientSlug, $code, $nameEn, $nameMl, $slug, $addressEn, $addressMl,
                    $phone, $email, $managerName, $managerPhone,
                    $workingHoursEn, $workingHoursMl, $hasLocker, $has365,
                    $hasGoldLoan, $hasAtm, $status
                ]
            );
            Session::flash('success', 'Branch created successfully.');
        }

        $response = new Response();
        return $response->redirect('/admin/branches');
    }
}
