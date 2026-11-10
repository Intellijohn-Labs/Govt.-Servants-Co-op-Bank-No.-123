<?php
declare(strict_types=1);

namespace App\Controllers;

use Core\Request;
use Core\Response;
use Core\Database;
use Core\Session;

class ServiceRequestController
{
    public function show(Request $request): Response
    {
        $clientSlug = client_slug();

        $branches = Database::fetchAll(
            "SELECT id, name_en, name_ml FROM branches WHERE client_slug = ? AND status = 'active' ORDER BY is_head_office DESC, sort_order ASC, name_en ASC",
            [$clientSlug]
        );

        $products = Database::fetchAll(
            "SELECT p.id, p.slug, p.name_en, p.name_ml, c.type as cat_type
             FROM products p
             JOIN product_categories c ON p.category_id = c.id
             WHERE p.client_slug = ? AND p.status = 'published'
             ORDER BY c.sort_order ASC, p.sort_order ASC",
            [$clientSlug]
        );

        $selectedService = trim((string)$request->input('service', ''));
        $trackingCode = trim((string)$request->input('track', ''));
        $trackedRequest = null;

        if ($trackingCode !== '') {
            $trackedRequest = Database::fetchOne(
                "SELECT sr.*, b.name_en as branch_name_en, b.name_ml as branch_name_ml, b.phone as branch_phone
                 FROM service_requests sr
                 LEFT JOIN branches b ON sr.branch_id = b.id
                 WHERE sr.client_slug = ? AND sr.tracking_code = ? LIMIT 1",
                [$clientSlug, $trackingCode]
            );
        }

        $response = new Response();
        return $response->view('pages/service_request', [
            'meta_title' => __('enquire_now'),
            'branches' => $branches,
            'products' => $products,
            'selected_service' => $selectedService,
            'tracking_code' => $trackingCode,
            'tracked_request' => $trackedRequest,
        ]);
    }

    public function submit(Request $request): Response
    {
        $clientSlug = client_slug();

        $fullName = trim((string)$request->input('full_name', ''));
        $phone = trim((string)$request->input('phone', ''));
        $email = trim((string)$request->input('email', ''));
        $branchId = (int)$request->input('branch_id', 0);
        $requestType = trim((string)$request->input('request_type', 'General'));
        $memberNumber = trim((string)$request->input('member_number', ''));
        $message = trim((string)$request->input('message', ''));

        $errors = [];

        if ($fullName === '' || mb_strlen($fullName) < 2) {
            $errors['full_name'] = __('Name is required and must be valid', 'പേര് രേഖപ്പെടുത്തേണ്ടത് നിർബന്ധമാണ്');
        }

        $cleanPhone = preg_replace('/[^0-9]/', '', $phone);
        if (strlen($cleanPhone) < 10) {
            $errors['phone'] = __('Valid 10-digit mobile number is required', 'സാധുവായ 10 അക്ക മൊബൈൽ നമ്പർ നൽകുക');
        }

        if ($branchId <= 0) {
            $errors['branch_id'] = __('Please select your nearest branch', 'സമീപമുള്ള ശാഖ തിരഞ്ഞെടുക്കുക');
        }

        if (!empty($errors)) {
            Session::flash('errors', $errors);
            Session::flash('old', $request->all());
            $response = new Response();
            return $response->redirect(url('/service-request'));
        }

        // Generate unique tracking code
        $prefix = strtoupper(substr(preg_replace('/[^a-zA-Z]/', '', $clientSlug), 0, 3));
        $trackingCode = sprintf('SR-%s-%s-%04d', $prefix, date('ymd'), mt_rand(1000, 9999));

        $ipAddress = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';

        Database::execute(
            "INSERT INTO service_requests (client_slug, branch_id, tracking_code, request_type, full_name, member_number, email, phone, message, status, ip_address)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'new', ?)",
            [
                $clientSlug,
                $branchId,
                $trackingCode,
                $requestType,
                $fullName,
                $memberNumber ?: null,
                $email ?: 'no-email@customer.local',
                $phone,
                $message,
                $ipAddress
            ]
        );

        Session::flash('success_tracking_code', $trackingCode);
        Session::flash('success_message', __(
            'Your service request has been submitted successfully. Our branch representative will contact you shortly.',
            'നിങ്ങളുടെ അപേക്ഷ വിജയകരമായി സമർപ്പിച്ചു. ഞങ്ങളുടെ ശാഖാ പ്രതിനിധി ഉടൻ നിങ്ങളുമായി ബന്ധപ്പെടുന്നതാണ്.'
        ));

        $response = new Response();
        return $response->redirect(url('/service-request?track=' . urlencode($trackingCode)));
    }
}
