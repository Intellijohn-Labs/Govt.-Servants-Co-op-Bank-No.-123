<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use Core\Request;
use Core\Response;
use Core\Database;
use Core\Settings;
use Core\Session;

class EnquiryController
{
    public function index(Request $request): Response
    {
        $clientSlug = Settings::clientSlug();
        $tab = $request->input('tab', 'requests'); // 'requests' or 'general'
        $status = trim((string)$request->input('status', ''));

        // Service Requests
        $reqSql = "SELECT sr.*, b.name_en as branch_name 
                   FROM service_requests sr 
                   LEFT JOIN branches b ON sr.branch_id = b.id 
                   WHERE sr.client_slug = ?";
        $reqParams = [$clientSlug];
        if ($status !== '') {
            $reqSql .= " AND sr.status = ?";
            $reqParams[] = $status;
        }
        $reqSql .= " ORDER BY sr.id DESC";
        $serviceRequests = Database::fetchAll($reqSql, $reqParams);

        // General Enquiries
        $enqSql = "SELECT e.*, b.name_en as branch_name 
                   FROM enquiries e 
                   LEFT JOIN branches b ON e.branch_id = b.id 
                   WHERE e.client_slug = ?";
        $enqParams = [$clientSlug];
        if ($status !== '') {
            $enqSql .= " AND e.status = ?";
            $enqParams[] = $status;
        }
        $enqSql .= " ORDER BY e.id DESC";
        $generalEnquiries = Database::fetchAll($enqSql, $enqParams);

        $response = new Response();
        return $response->view('admin/enquiries', [
            'title' => 'Enquiries & Service Requests',
            'activeNav' => 'enquiries',
            'currentTab' => $tab,
            'currentStatus' => $status,
            'serviceRequests' => $serviceRequests,
            'generalEnquiries' => $generalEnquiries,
        ], 'admin');
    }

    public function updateStatus(Request $request): Response
    {
        $clientSlug = Settings::clientSlug();
        $type = $request->input('item_type', 'request'); // 'request' or 'enquiry'
        $id = (int)$request->input('id', 0);
        $newStatus = trim((string)$request->input('status', 'in_progress'));
        $notes = trim((string)$request->input('notes', ''));

        if ($type === 'request') {
            Database::execute(
                "UPDATE service_requests SET status = ?, resolution_notes = ? WHERE id = ? AND client_slug = ?",
                [$newStatus, $notes, $id, $clientSlug]
            );
        } else {
            Database::execute(
                "UPDATE enquiries SET status = ?, internal_notes = ? WHERE id = ? AND client_slug = ?",
                [$newStatus, $notes, $id, $clientSlug]
            );
        }

        Session::flash('success', 'Status updated successfully.');
        $response = new Response();
        return $response->redirect('/admin/enquiries?tab=' . ($type === 'request' ? 'requests' : 'general'));
    }
}
