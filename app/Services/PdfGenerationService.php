<?php

namespace App\Services;

use App\Models\PayrollDetail;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\Storage;

class PdfGenerationService
{
    public function generate(PayrollDetail $detail, string $periode, string $password = ''): string
    {
        $filename = sprintf('%s_%s_%s.pdf', $detail->nik, str_replace(' ', '', $periode), $detail->nama);
        $path = "payroll/{$detail->payroll_import_id}/{$filename}";

        $html = view('pdf.slip-gaji', [
            'detail' => $detail,
            'periode' => $periode,
        ])->render();

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        if ($password) {
            $canvas = $dompdf->getCanvas();
            $canvas->get_cpdf()->setEncryption($password, $password, []);
        }

        $fullPath = Storage::disk('public')->path($path);
        $dir = dirname($fullPath);

        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        file_put_contents($fullPath, $dompdf->output());

        return $path;
    }
}
