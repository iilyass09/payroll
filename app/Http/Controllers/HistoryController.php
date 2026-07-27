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

        $yearImportIds = PayrollImport::where('periode', 'LIKE', "%{$selectedYear}")->pluck('id');

        $imports = PayrollImport::with('uploadedBy')
            ->withCount('payrollDetails')
            ->whereIn('id', $yearImportIds)
            ->latest()
            ->paginate(12);

        $stats = [
            'total_payroll' => PayrollImport::whereIn('id', $yearImportIds)->sum('total_payroll'),
            'total_employee' => PayrollDetail::whereIn('payroll_import_id', $yearImportIds)
                ->distinct()->count('nik'),
            'email_sent' => PayrollDetail::whereIn('payroll_import_id', $yearImportIds)
                ->where('status', 'sent')->count(),
            'email_failed' => PayrollDetail::whereIn('payroll_import_id', $yearImportIds)
                ->where('status', 'failed')->count(),
        ];

        return view('history.index', compact('imports', 'availableYears', 'selectedYear', 'stats'));
    }

    public function show(PayrollImport $import)
    {
        $import->load(['payrollDetails.emailLog', 'uploadedBy']);

        return view('history.show', compact('import'));
    }
}
