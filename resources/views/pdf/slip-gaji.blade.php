<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Slip Gaji - {{ $detail->nama }}</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 10px;
            line-height: 1.4;
            margin: 0;
            padding: 20px 25px;
            color: #333;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
            margin-bottom: 14px;
        }
        .header .company-name {
            font-size: 12px;
            font-weight: bold;
            color: #1a56db;
            letter-spacing: 1px;
        }
        .header h1 {
            font-size: 13px;
            margin: 4px 0 0 0;
            color: #1a1a1a;
        }
        .header-logo-row img {
            height: 28px;
            display: block;
            margin: 0 auto 4px auto;
        }
        .identity-section {
            margin-bottom: 14px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .identity-table {
            width: 100%;
            border-collapse: collapse;
        }
        .identity-table td {
            vertical-align: top;
            padding: 1px 5px;
            font-size: 10px;
        }
        .left-col {
            width: 50%;
            line-height: 1.5;
            color: #333;
            font-style: italic;
        }
        .right-col {
            width: 50%;
            text-align: right;
        }
        .employee-info {
            margin-left: auto;
        }
        .employee-info td {
            padding: 0px 4px;
            line-height: 1.4;
        }
        .employee-info td:last-child {
            word-break: break-word;
            max-width: 200px;
        }
        .identity-table .label {
            font-weight: bold;
            width: 80px;
            color: #555;
        }
        .section-title {
            font-weight: bold;
            font-size: 11px;
            padding: 5px 8px;
            margin-top: 16px;
            margin-bottom: 3px;
        }
        .section-title.penerimaan {
            background: #e8f5e9;
            color: #2e7d32;
        }
        .section-title.pengurangan {
            background: #ffebee;
            color: #c62828;
        }
        .detail-table {
            width: 100%;
            border-collapse: collapse;
        }
        .detail-table th {
            background: #f5f5f5;
            padding: 4px 8px;
            text-align: left;
            font-size: 9px;
            text-transform: uppercase;
            border-bottom: 1px solid #ddd;
        }
        .detail-table td {
            padding: 5px 8px;
            border-bottom: 1px solid #f0f0f0;
            font-size: 10px;
        }
        .detail-table .text-right {
            text-align: right;
        }
        .sub-item td:first-child {
            padding-left: 18px;
            font-size: 9px;
            color: #555;
        }
        .sub-item td:last-child {
            font-size: 9px;
            color: #555;
        }
        .total-row td {
            font-weight: bold;
            font-size: 10px;
            border-top: 2px solid #333;
            padding-top: 8px;
        }
        .grand-total td {
            font-weight: bold;
            font-size: 12px;
            border-top: 3px double #1a56db;
            padding-top: 8px;
            color: #1a56db;
        }
        .terbilang {
            text-align: center;
            font-size: 9px;
            font-style: italic;
            padding: 6px;
            margin-top: 12px;
            border: 1px solid #ccc;
            background: #fafafa;
        }
        .footer-line {
            border: none;
            border-top: 1px solid #ccc;
            margin: 14px 0 10px 0;
        }
        .signature-section {
            text-align: center;
            margin-top: 8px;
        }
        .signature-section .city-date {
            font-size: 10px;
            margin-bottom: 20px;
        }
        .signature-section .company-sign {
            font-weight: bold;
            font-size: 10px;
            margin-top: 4px;
        }
        .watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            font-size: 32px;
            font-weight: bold;
            color: #cccccc;
            opacity: 0.2;
            text-transform: uppercase;
            letter-spacing: 8px;
            z-index: 9999;
            pointer-events: none;
            transform: translate(-50%, -50%) rotate(-35deg);
            white-space: nowrap;
        }
    </style>
</head>
<body>
    <div class="watermark">Private &amp; Confidential</div>
    <div class="header">
        <div class="header-logo-row">
            <img src="{{ $logoSrc }}" alt="PT. Johen Sukses Abadi">
        </div>
        <div class="company-name">PT. JOHEN SUKSES ABADI</div>
        <h1>SLIP GAJI</h1>
        <div style="text-align: right; font-size: 9px; font-style: italic; color: #666; margin-top: -2px;">Slip ini dicetak secara elektronik</div>
    </div>

    <div class="identity-section">
        <table class="identity-table">
            <tr>
                <td class="left-col">
                    <strong>PT. Johen Sukses Abadi</strong><br>
                    Summarecon Gedebage<br>
                    Ruko Plaza Topaz Commercial No.60, Summarecon<br>
                    Gedebage, Kota Bandung, Jawa Barat, 40294
                </td>
                <td class="right-col">
                    <table class="employee-info">
                        <tr><td class="label">Periode</td><td>: {{ $periode }}</td></tr>
                        <tr><td class="label">NIK</td><td>: {{ $detail->nik }}</td></tr>
                        <tr><td class="label">Karyawan</td><td>: {{ $detail->nama }}</td></tr>
                        <tr><td class="label">Jabatan</td><td>: {{ $detail->jabatan }}</td></tr>
                        <tr><td class="label">Divisi</td><td>: {{ $detail->divisi }}</td></tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>

    <div class="section-title penerimaan">PENERIMAAN</div>
    <table class="detail-table">
        <thead>
            <tr>
                <th>Keterangan</th>
                <th class="text-right">Jumlah (Rp)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Gaji Pokok</td>
                <td class="text-right">{{ number_format($detail->gaji_pokok, 0, ',', '.') }}</td>
            </tr>
            @if($detail->tunjangan_jabatan > 0)
            <tr>
                <td>Tunjangan Jabatan</td>
                <td class="text-right">{{ number_format($detail->tunjangan_jabatan, 0, ',', '.') }}</td>
            </tr>
            @endif
            @if($detail->total_tambahan_upah_sub > 0)
            <tr>
                <td><strong>Tambahan Upah</strong></td>
                <td class="text-right"><strong>{{ number_format($detail->total_tambahan_upah_sub, 0, ',', '.') }}</strong></td>
            </tr>
            @if($detail->bonus_absensi_full > 0)
            <tr class="sub-item">
                <td>Bonus Absensi Full 1 Bulan</td>
                <td class="text-right">{{ number_format($detail->bonus_absensi_full, 0, ',', '.') }}</td>
            </tr>
            @endif
            @if($detail->pengembalian > 0)
            <tr class="sub-item">
                <td>Pengembalian</td>
                <td class="text-right">{{ number_format($detail->pengembalian, 0, ',', '.') }}</td>
            </tr>
            @endif
            @if($detail->tips_pelanggan > 0)
            <tr class="sub-item">
                <td>Tips Pelanggan</td>
                <td class="text-right">{{ number_format($detail->tips_pelanggan, 0, ',', '.') }}</td>
            </tr>
            @endif
            @if($detail->insentif_creative > 0)
            <tr class="sub-item">
                <td>Insentif View/Sold Creative; CC, Video Editor & Resepsionist</td>
                <td class="text-right">{{ number_format($detail->insentif_creative, 0, ',', '.') }}</td>
            </tr>
            @endif
            @endif
            @if($detail->premi_bpjs_kesehatan_4 > 0)
            <tr>
                <td>Premi BPJS Kesehatan (4%)</td>
                <td class="text-right">{{ number_format($detail->premi_bpjs_kesehatan_4, 0, ',', '.') }}</td>
            </tr>
            @endif
            @if($detail->tambahan_upah_bonus > 0)
            <tr>
                <td>Tambahan Upah (Bonus Sold, View, dll)</td>
                <td class="text-right">{{ number_format($detail->tambahan_upah_bonus, 0, ',', '.') }}</td>
            </tr>
            @endif
            @if($detail->thr > 0)
            <tr>
                <td>THR</td>
                <td class="text-right">{{ number_format($detail->thr, 0, ',', '.') }}</td>
            </tr>
            @endif
            <tr class="total-row">
                <td>TOTAL PENGHASILAN BRUTO</td>
                <td class="text-right">Rp {{ number_format($detail->total_penghasilan_bruto, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <div class="section-title pengurangan">PENGURANGAN</div>
    <table class="detail-table">
        <thead>
            <tr>
                <th>Keterangan</th>
                <th class="text-right">Jumlah (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @if($detail->thr_dibayarkan > 0)
            <tr>
                <td>THR Dibayarkan</td>
                <td class="text-right">{{ number_format($detail->thr_dibayarkan, 0, ',', '.') }}</td>
            </tr>
            @endif
            @if($detail->potongan_pinjaman > 0)
            <tr>
                <td>Potongan Pinjaman</td>
                <td class="text-right">{{ number_format($detail->potongan_pinjaman, 0, ',', '.') }}</td>
            </tr>
            @endif
            @if($detail->potongan_absensi > 0)
            <tr>
                <td>Potongan Absensi (Ketidakhadiran)</td>
                <td class="text-right">{{ number_format($detail->potongan_absensi, 0, ',', '.') }}</td>
            </tr>
            @endif
            @if($detail->potongan_keterlambatan > 0)
            <tr>
                <td>Potongan Absensi (Keterlambatan)</td>
                <td class="text-right">{{ number_format($detail->potongan_keterlambatan, 0, ',', '.') }}</td>
            </tr>
            @endif
            @if($detail->potongan_bpjs_kesehatan_4 > 0)
            <tr>
                <td>Potongan BPJS Kesehatan (4%) - Tanggungan Perusahaan</td>
                <td class="text-right">{{ number_format($detail->potongan_bpjs_kesehatan_4, 0, ',', '.') }}</td>
            </tr>
            @endif
            @if($detail->potongan_bpjs_kesehatan_1 > 0)
            <tr>
                <td>Potongan BPJS Kesehatan (1%) - Tanggungan Karyawan</td>
                <td class="text-right">{{ number_format($detail->potongan_bpjs_kesehatan_1, 0, ',', '.') }}</td>
            </tr>
            @endif
            <tr class="total-row">
                <td>TOTAL PENGELUARAN</td>
                <td class="text-right">Rp {{ number_format($detail->total_pengeluaran, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <table class="detail-table" style="margin-top: 10px;">
        <tr class="grand-total">
            <td>TOTAL DITERIMA</td>
            <td class="text-right">Rp {{ number_format($detail->take_home_pay, 0, ',', '.') }}</td>
        </tr>
    </table>

    <div class="terbilang">
        # {{ terbilang($detail->take_home_pay) }} Rupiah #
    </div>

    <hr class="footer-line">

    <div class="signature-section">
        <div class="city-date">Bandung, {{ $tanggalCetak }}</div>
        <div style="margin-top: 20px;"></div>
        <div class="company-sign">PT. Johen Sukses Abadi</div>
    </div>
</body>
</html>
