<?php

namespace App\Http\Controllers;

use App\Models\PayrollImport;

class DashboardController extends Controller
{
    public function index()
    {
        $totalImports = PayrollImport::count();
        $totalPayroll = PayrollImport::sum('total_payroll');
        $totalEmployees = PayrollImport::sum('total_employee');
        $recentImports = PayrollImport::latest()->take(5)->get();

        return view('dashboard.index', compact(
            'totalImports', 'totalPayroll', 'totalEmployees', 'recentImports',
        ));
    }
}
