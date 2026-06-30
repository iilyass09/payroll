<?php

namespace App\Http\Controllers;

use App\Services\DashboardService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct(
        private DashboardService $dashboardService,
    ) {}

    public function index(Request $request)
    {
        $user = auth()->user();

        if ($user->isKaryawan()) {
            $employee = $user->employee;

            if (!$employee) {
                return view('dashboard.index', [
                    'karyawanView' => true,
                    'employee' => null,
                    'karyawanData' => null,
                ]);
            }

            $karyawanData = $this->dashboardService->getKaryawanDashboard($employee->id);

            return view('dashboard.index', [
                'karyawanView' => true,
                'employee' => $employee,
                'karyawanData' => $karyawanData,
            ]);
        }

        $stats = $this->dashboardService->getStats();
        $availableYears = $this->dashboardService->getAvailableYears();
        $selectedYear = $request->integer('year', $availableYears[0] ?? now()->year);
        $payrolls = $this->dashboardService->getPayrollsByYear($selectedYear);
        $divisionStats = $this->dashboardService->getDivisionStats();
        $latestPayroll = $this->dashboardService->getLatestPayroll();
        $pendingLeaveRequests = $this->dashboardService->getPendingLeaveRequests(user: $user);
        $pendingLeaveCount = $this->dashboardService->getPendingLeaveCount(user: $user);
        $expiringContracts = $this->dashboardService->getExpiringContracts();
        $expiringContractCount = count($expiringContracts);
        $meetingStats = $this->dashboardService->getMonthlyMeetingStats();

        return view('dashboard.index', compact(
            'stats', 'availableYears', 'selectedYear', 'payrolls', 'divisionStats',
            'latestPayroll', 'pendingLeaveRequests', 'pendingLeaveCount',
            'expiringContracts', 'expiringContractCount', 'meetingStats',
        ));
    }
}
