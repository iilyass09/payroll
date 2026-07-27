<?php

namespace App\Jobs;

use App\Models\PayrollImport;
use App\Services\PdfGenerationService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessPayrollJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public PayrollImport $payrollImport,
    ) {}

    public function handle(PdfGenerationService $pdfService): void
    {
        $details = $this->payrollImport->payrollDetails;

        foreach ($details as $detail) {
            $path = $pdfService->generate($detail, $this->payrollImport->periode, $detail->pdf_password);
            $detail->update(['pdf_path' => $path]);
        }

        foreach ($details as $i => $detail) {
            SendEmailJob::dispatch($detail, $this->payrollImport->periode)
                ->onQueue('email')
                ->delay(now()->addSeconds($i * 3));
        }
    }
}
