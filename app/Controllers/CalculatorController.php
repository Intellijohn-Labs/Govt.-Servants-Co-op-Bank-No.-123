<?php
declare(strict_types=1);

namespace App\Controllers;

use Core\Request;
use Core\Response;
use Core\Database;

class CalculatorController
{
    public function index(Request $request): Response
    {
        $clientSlug = client_slug();

        $configs = Database::fetchAll(
            "SELECT * FROM calculators_config WHERE client_slug = ?",
            [$clientSlug]
        );

        $parsedConfigs = [];
        foreach ($configs as $cfg) {
            $parsedConfigs[$cfg['calculator_type']] = json_decode($cfg['config_json'], true) ?: [];
        }

        $response = new Response();
        return $response->view('pages/calculators', [
            'meta_title' => __('nav_calculators'),
            'configs' => $parsedConfigs,
        ]);
    }
}
