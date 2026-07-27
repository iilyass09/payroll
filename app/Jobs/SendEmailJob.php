<?php

namespace App\Jobs;

use App\Models\PayrollDetail;
use App\Services\EmailService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 5;
    public $maxExceptions = 3;
    public $backoff = [10, 30, 60, 120];

    public function __construct(
        public PayrollDetail $payrollDetail,
        public string $periode,
    ) {}

    public function handle(EmailService $emailService): void
    {
        $emailService->send($this->payrollDetail, $this->periode);
    }
}
