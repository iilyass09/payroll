<?php

namespace App\Services;

use App\Models\PayrollDetail;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\Storage;

class PdfGenerationService
{
    public function generate(PayrollDetail $detail, string $periode, string $password = ''): string
    {
        $filename = sprintf('Slip_%s_%s.pdf', $detail->nama, $periode);
        $path = "slip-gaji/{$detail->payroll_import_id}/{$filename}";

        $logoPath = public_path('logo.png');
        $logoBase64 = base64_encode(file_get_contents($logoPath));
        $logoSrc = 'data:image/png;base64,' . $logoBase64;

        $html = view('pdf.slip-gaji', [
            'detail' => $detail,
            'periode' => $periode,
            'logoSrc' => $logoSrc,
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
