<?php

namespace App\Services;

use App\Models\Division;
use App\Models\EmailLog;
use App\Models\Employee;
use App\Models\PayrollDetail;
use App\Models\PayrollImport;
use Illuminate\Support\Facades\DB;

class DashboardService
{
    public function getStats(): array
    {
        return [
            'total_payroll' => PayrollImport::sum('total_payroll'),
            'total_employee' => PayrollImport::sum('total_employee'),
            'total_employees' => Employee::count(),
            'total_divisions' => Division::count(),
            'email_sent' => EmailLog::where('status', 'sent')->count(),
            'email_failed' => EmailLog::where('status', 'failed')->count(),
        ];
    }

    public function getAvailableYears(): array
    {
        return PayrollImport::select(DB::raw('CAST(SUBSTR(periode, -4) AS INTEGER) as year'))
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year')
            ->toArray();
    }

    public function getPayrollsByYear(int $year): mixed
    {
        return PayrollImport::with('uploadedBy')
            ->where('periode', 'LIKE', "%{$year}")
            ->latest()
            ->get();
    }

    public function getTimeline(int $limit = 10): array
    {
        $imports = PayrollImport::withCount('payrollDetails')
            ->latest()
            ->take($limit)
            ->get();

        $timeline = [];

        foreach ($imports as $import) {
            $sentCount = $import->payrollDetails()->where('status', 'sent')->count();
            $failedCount = $import->payrollDetails()->where('status', 'failed')->count();

            $timeline[] = [
                'time' => $import->created_at,
                'icon' => 'upload',
                'title' => "Payroll {$import->periode} diupload",
                'description' => "File: {$import->file_name}",
            ];

            $timeline[] = [
                'time' => $import->created_at->addMinutes(1),
                'icon' => 'check',
                'title' => "Data berhasil divalidasi",
                'description' => "{$import->total_employee} karyawan",
            ];

            if ($sentCount > 0) {
                $timeline[] = [
                    'time' => $import->created_at->addMinutes(2),
                    'icon' => 'mail',
                    'title' => "{$sentCount} email terkirim",
                    'description' => "Periode {$import->periode}",
                ];
            }

            if ($failedCount > 0) {
                $timeline[] = [
                    'time' => $import->created_at->addMinutes(3),
                    'icon' => 'alert',
                    'title' => "{$failedCount} email gagal",
                    'description' => "Perlu retry",
                ];
            }
        }

        return $timeline;
    }
}
