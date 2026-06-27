<?php

namespace App\Http\Controllers;

use App\Models\PayrollImport;
use App\Services\DashboardService;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function index(Request $request, DashboardService $dashboardService)
    {
        $availableYears = $dashboardService->getAvailableYears();
        $selectedYear = $request->integer('year', $availableYears[0] ?? now()->year);
        $imports = PayrollImport::with('uploadedBy')
            ->withCount('payrollDetails')
            ->where('periode', 'LIKE', "%{$selectedYear}")
            ->latest()
            ->paginate(12);

        $stats = $dashboardService->getStats();

        return view('history.index', compact('imports', 'availableYears', 'selectedYear', 'stats'));
    }

    public function show(PayrollImport $import)
    {
        $import->load(['payrollDetails.emailLog', 'uploadedBy']);

        return view('history.show', compact('import'));
    }
}
