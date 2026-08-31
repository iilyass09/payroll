<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessPayrollJob;
use App\Models\PayrollDetail;
use App\Models\PayrollImport;
use Illuminate\Support\Facades\Storage;

class PayrollController extends Controller
{
    public function generate(PayrollImport $import)
    {
        ProcessPayrollJob::dispatch($import);

        return redirect()
            ->route('payroll.show', $import)
            ->with('processing', true)
            ->with('success', 'Proses generate PDF dan pengiriman email telah dimulai.');
    }

    public function show(PayrollImport $import)
    {
        $import->load(['payrollDetails.emailLog', 'uploadedBy']);

        $progress = $this->getProgress($import);

        return view('payroll.show', compact('import', 'progress'));
    }

    public function progressJson(PayrollImport $import)
    {
        return response()->json($this->getProgress($import));
    }

    private function getProgress(PayrollImport $import): array
    {
        $total = $import->payrollDetails()->count();
        $sent = $import->payrollDetails()->where('status', 'sent')->count();
        $failed = $import->payrollDetails()->where('status', 'failed')->count();
        $pending = max(0, $total - $sent - $failed);
        $percent = $total > 0 ? (int) round(($sent + $failed) / $total * 100) : 0;

        return [
            'total' => $total,
            'sent' => $sent,
            'failed' => $failed,
            'pending' => $pending,
            'percent' => $percent,
            'allDone' => $total > 0 && ($sent + $failed) >= $total,
        ];
    }

    public function downloadPdf(PayrollDetail $detail)
    {
        if (!$detail->pdf_path || !Storage::disk('public')->exists($detail->pdf_path)) {
            return redirect()->back()->with('error', 'File PDF tidak ditemukan.');
        }

        return Storage::disk('public')->download(
            $detail->pdf_path,
            sprintf('Slip_%s_%s.pdf', $detail->nik, $detail->payrollImport->periode)
        );
    }
}
