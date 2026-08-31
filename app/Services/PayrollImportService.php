<?php

namespace App\Services;

use App\Models\PayrollDetail;
use App\Models\PayrollImport;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;

class PayrollImportService
{
    public function import(string $filePath, string $periode, int $uploadedBy): PayrollImport
    {
        $spreadsheet = IOFactory::load($filePath);
        $worksheet = $spreadsheet->getActiveSheet();
        $rows = $worksheet->toArray();

        $header = array_shift($rows);
        $data = collect($rows)->filter(fn($row) => !empty(array_filter($row)));

        $errors = [];
        $validData = [];

        foreach ($data as $index => $row) {
            $rowNumber = $index + 2;

            $bonusAbsensiFull = (float) ($row[8] ?? 0);
            $pengembalian = (float) ($row[9] ?? 0);
            $tipsPelanggan = (float) ($row[10] ?? 0);
            $insentifCreative = (float) ($row[11] ?? 0);
            $tambahanUpah = $bonusAbsensiFull + $pengembalian + $tipsPelanggan + $insentifCreative;

            $rowData = [
                'nik' => trim($row[0] ?? ''),
                'nama' => trim($row[1] ?? ''),
                'email' => trim($row[2] ?? ''),
                'divisi' => trim($row[3] ?? ''),
                'jabatan' => trim($row[4] ?? ''),
                'gaji_pokok' => (float) ($row[5] ?? 0),
                'tunjangan_jabatan' => (float) ($row[6] ?? 0),
                'tambahan_upah' => $tambahanUpah,
                'bonus_absensi_full' => $bonusAbsensiFull,
                'pengembalian' => $pengembalian,
                'tips_pelanggan' => $tipsPelanggan,
                'insentif_creative' => $insentifCreative,
                'premi_bpjs_kesehatan_4' => (float) ($row[12] ?? 0),
                'tambahan_upah_bonus' => (float) ($row[13] ?? 0),
                'thr' => (float) ($row[14] ?? 0),
                'thr_dibayarkan' => (float) ($row[15] ?? 0),
                'potongan_pinjaman' => (float) ($row[16] ?? 0),
                'potongan_absensi' => (float) ($row[17] ?? 0),
                'potongan_keterlambatan' => (float) ($row[18] ?? 0),
                'potongan_bpjs_kesehatan_4' => (float) ($row[19] ?? 0),
                'potongan_bpjs_kesehatan_1' => (float) ($row[20] ?? 0),
                'pdf_password' => trim($row[21] ?? ''),
            ];

            $validator = Validator::make($rowData, [
                'nik' => 'required|string',
                'nama' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'divisi' => 'nullable|string|max:255',
                'jabatan' => 'required|string|max:255',
                'gaji_pokok' => 'required|numeric|min:0',
                'tunjangan_jabatan' => 'numeric|min:0',
                'tambahan_upah' => 'numeric|min:0',
                'bonus_absensi_full' => 'numeric|min:0',
                'pengembalian' => 'numeric|min:0',
                'tips_pelanggan' => 'numeric|min:0',
                'insentif_creative' => 'numeric|min:0',
                'premi_bpjs_kesehatan_4' => 'numeric|min:0',
                'tambahan_upah_bonus' => 'numeric|min:0',
                'thr' => 'numeric|min:0',
                'thr_dibayarkan' => 'numeric|min:0',
                'potongan_pinjaman' => 'numeric|min:0',
                'potongan_absensi' => 'numeric|min:0',
                'potongan_keterlambatan' => 'numeric|min:0',
                'potongan_bpjs_kesehatan_4' => 'numeric|min:0',
                'potongan_bpjs_kesehatan_1' => 'numeric|min:0',
                'pdf_password' => 'required|string|min:1|max:50',
            ]);

            if ($validator->fails()) {
                $errors[] = [
                    'row' => $rowNumber,
                    'data' => $rowData,
                    'errors' => $validator->errors()->toArray(),
                ];
            } else {
                $rowData['take_home_pay'] = $rowData['gaji_pokok']
                    + $rowData['tunjangan_jabatan']
                    + $rowData['tambahan_upah']
                    + $rowData['premi_bpjs_kesehatan_4']
                    + $rowData['tambahan_upah_bonus']
                    + $rowData['thr']
                    - $rowData['thr_dibayarkan']
                    - $rowData['potongan_pinjaman']
                    - $rowData['potongan_absensi']
                    - $rowData['potongan_keterlambatan']
                    - $rowData['potongan_bpjs_kesehatan_4']
                    - $rowData['potongan_bpjs_kesehatan_1'];
                $validData[] = $rowData;
            }
        }

        $payrollImport = DB::transaction(function () use ($validData, $periode, $filePath, $uploadedBy, $errors) {
            $import = PayrollImport::create([
                'periode' => $periode,
                'file_name' => 'Payroll ' . $periode,
                'total_employee' => count($validData),
                'total_payroll' => collect($validData)->sum('take_home_pay'),
                'uploaded_by' => $uploadedBy,
            ]);

            foreach ($validData as $data) {
                PayrollDetail::create([
                    'payroll_import_id' => $import->id,
                    'nik' => $data['nik'],
                    'nama' => $data['nama'],
                    'email' => $data['email'],
                    'divisi' => $data['divisi'],
                    'jabatan' => $data['jabatan'],
                    'gaji_pokok' => $data['gaji_pokok'],
                    'tunjangan_jabatan' => $data['tunjangan_jabatan'],
                    'tambahan_upah' => $data['tambahan_upah'],
                    'bonus_absensi_full' => $data['bonus_absensi_full'],
                    'pengembalian' => $data['pengembalian'],
                    'tips_pelanggan' => $data['tips_pelanggan'],
                    'insentif_creative' => $data['insentif_creative'],
                    'premi_bpjs_kesehatan_4' => $data['premi_bpjs_kesehatan_4'],
                    'tambahan_upah_bonus' => $data['tambahan_upah_bonus'],
                    'thr' => $data['thr'],
                    'thr_dibayarkan' => $data['thr_dibayarkan'],
                    'potongan_pinjaman' => $data['potongan_pinjaman'],
                    'potongan_absensi' => $data['potongan_absensi'],
                    'potongan_keterlambatan' => $data['potongan_keterlambatan'],
                    'potongan_bpjs_kesehatan_4' => $data['potongan_bpjs_kesehatan_4'],
                    'potongan_bpjs_kesehatan_1' => $data['potongan_bpjs_kesehatan_1'],
                    'take_home_pay' => $data['take_home_pay'],
                    'pdf_password' => $data['pdf_password'],
                ]);
            }

            return $import;
        });

        $payrollImport->setAttribute('errors', $errors);
        $payrollImport->setAttribute('invalid_rows', count($errors));

        return $payrollImport;
    }

    public function validate(array $data): array
    {
        $errors = [];
        $validData = [];

        foreach ($data as $index => $row) {
            $rowNumber = $index + 2;
            $validator = Validator::make($row, [
                'nik' => 'required|string',
                'nama' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'divisi' => 'nullable|string|max:255',
                'jabatan' => 'required|string|max:255',
                'gaji_pokok' => 'required|numeric|min:0',
                'tunjangan_jabatan' => 'numeric|min:0',
                'tambahan_upah' => 'numeric|min:0',
                'bonus_absensi_full' => 'numeric|min:0',
                'pengembalian' => 'numeric|min:0',
                'tips_pelanggan' => 'numeric|min:0',
                'insentif_creative' => 'numeric|min:0',
                'premi_bpjs_kesehatan_4' => 'numeric|min:0',
                'tambahan_upah_bonus' => 'numeric|min:0',
                'thr' => 'numeric|min:0',
                'thr_dibayarkan' => 'numeric|min:0',
                'potongan_pinjaman' => 'numeric|min:0',
                'potongan_absensi' => 'numeric|min:0',
                'potongan_keterlambatan' => 'numeric|min:0',
                'potongan_bpjs_kesehatan_4' => 'numeric|min:0',
                'potongan_bpjs_kesehatan_1' => 'numeric|min:0',
                'pdf_password' => 'required|string|min:1|max:50',
            ]);

            if ($validator->fails()) {
                $errors[] = [
                    'row' => $rowNumber,
                    'data' => $row,
                    'errors' => $validator->errors()->toArray(),
                ];
            } else {
                $validData[] = $row;
            }
        }

        return compact('validData', 'errors');
    }
}
