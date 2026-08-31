<?php

namespace App\Livewire;

use App\Models\PayrollImport;
use Livewire\Component;

class PayrollProgress extends Component
{
    public PayrollImport $import;
    public bool $doneDismissed = false;
    public string $lastPoll = '';

    public function poll(): void
    {
        $this->lastPoll = now()->format('H:i:s');
    }

    public function render()
    {
        $total = $this->import->payrollDetails()->count();
        $sent = $this->import->payrollDetails()->where('status', 'sent')->count();
        $failed = $this->import->payrollDetails()->where('status', 'failed')->count();
        $pending = max(0, $total - $sent - $failed);
        $percent = $total > 0 ? (int) round(($sent + $failed) / $total * 100) : 0;
        $allDone = $total > 0 && ($sent + $failed) >= $total;

        $showProgress = false;

        if (!$this->doneDismissed) {
            $showProgress = true;
        }

        return view('livewire.payroll-progress', compact(
            'total', 'sent', 'failed', 'pending', 'percent', 'allDone', 'showProgress'
        ) + ['lastPoll' => $this->lastPoll]);
    }

    public function close(): void
    {
        $this->doneDismissed = true;
    }
}
