<?php

namespace App\Http\Controllers;

use App\Models\PayrollDetail;
use App\Models\PayrollImport;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function index(Request $request)
    {
        $availableYears = PayrollImport::selectRaw('DISTINCT SUBSTR(periode, -4) as year')
            ->pluck('year')
            ->sort()
            ->values()
            ->toArray();

        $selectedYear = $request->integer('year', $availableYears[0] ?? now()->year);

        $imports = PayrollImport::with('uploadedBy')
            ->withCount('payrollDetails')
            ->where('periode', 'LIKE', "%{$selectedYear}")
            ->latest()
            ->paginate(12);

        $stats = [
            'total_payroll' => PayrollImport::sum('total_payroll'),
            'total_employee' => PayrollImport::sum('total_employee'),
            'email_sent' => PayrollDetail::where('status', 'sent')->count(),
            'email_failed' => PayrollDetail::where('status', 'failed')->count(),
        ];

        return view('history.index', compact('imports', 'availableYears', 'selectedYear', 'stats'));
    }

    public function show(PayrollImport $import)
    {
        $import->load(['payrollDetails.emailLog', 'uploadedBy']);

        return view('history.show', compact('import'));
    }
}
