<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $quotes = Quote::all();
        $dbStatus = $this->checkDatabaseConnection();
        
        return view('home', [
            'quotes' => $quotes,
            'dbStatus' => $dbStatus,
        ]);
    }

    private function checkDatabaseConnection(): array
    {
        try {
            $pdo = \DB::connection()->getPdo();
            return [
                'connected' => true,
                'driver' => \DB::connection()->getDriverName(),
                'database' => \DB::connection()->getDatabaseName(),
            ];
        } catch (\Exception $e) {
            return [
                'connected' => false,
                'error' => $e->getMessage(),
            ];
        }
    }
}

