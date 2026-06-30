<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== EMAIL LOG ===\n";
$log = DB::table('email_logs')->latest()->first();
if ($log) {
    echo json_encode($log, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) . "\n";
} else {
    echo "No email logs found\n";
}

echo "\n=== LATEST PAYROLL DETAIL ===\n";
$detail = App\Models\PayrollDetail::latest()->first();
if ($detail) {
    $data = [
        'id' => $detail->id,
        'email' => $detail->email,
        'status' => $detail->status,
        'pdf_path' => $detail->pdf_path,
        'pdf_password' => $detail->pdf_password,
        'nama' => $detail->nama,
    ];
    echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) . "\n";

    echo "\n=== PDF EXISTS? ===\n";
    $fullPath = storage_path('app/public/' . $detail->pdf_path);
    echo "Expected path: $fullPath\n";
    echo "Exists: " . (file_exists($fullPath) ? 'YES' : 'NO') . "\n";
} else {
    echo "No payroll details found\n";
}

echo "\n=== ALL PAYROLL EMAILS ===\n";
$all = App\Models\PayrollDetail::whereNotNull('email')->get(['id', 'email', 'status', 'nama']);
foreach ($all as $d) {
    echo "  #{$d->id} {$d->nama} -> {$d->email} [{$d->status}]\n";
}

echo "\n=== CONFIG CHECK ===\n";
echo "MAIL_MAILER: " . config('mail.default') . "\n";
echo "MAIL_HOST: " . config('mail.mailers.smtp.host') . "\n";
echo "MAIL_PORT: " . config('mail.mailers.smtp.port') . "\n";
echo "MAIL_ENCRYPTION: " . (config('mail.mailers.smtp.encryption') ?? 'NOT SET') . "\n";

echo "\n=== RECENT LOG ===\n";
$logContent = `tail -50 storage/logs/laravel.log 2>&1`;  // Use backticks for shell
echo $logContent;
