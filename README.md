# Payroll

Aplikasi web untuk mengimpor data payroll, membuat slip gaji PDF berpassword, dan mengirimkannya kepada karyawan melalui email.

## Fitur

- Login pengguna dan riwayat impor payroll per periode.
- Impor file `.xlsx`, `.xls`, atau `.csv` hingga 10 MB.
- Validasi data payroll serta perhitungan *take-home pay* otomatis.
- Pembuatan slip gaji PDF per karyawan dengan password dari file impor.
- Pengiriman email melalui queue terpisah, pemantauan progres, log status, dan kirim ulang email gagal.
- Unduh slip gaji dan ringkasan payroll per periode.

## Teknologi

- PHP 8.3 dan Laravel 13
- Blade, Tailwind CSS, Alpine.js, Vite, dan Livewire
- PhpSpreadsheet untuk membaca file payroll
- Dompdf untuk menghasilkan PDF
- Laravel database queue untuk proses PDF dan email

## Prasyarat

- PHP 8.3 atau lebih baru
- Composer 2
- Node.js 20 atau lebih baru dan npm
- Database yang didukung Laravel (MySQL/MariaDB atau SQLite untuk pengembangan)
- SMTP yang aktif untuk pengiriman email produksi

## Instalasi

```bash
git clone https://github.com/iilyass09/payroll.git
cd payroll
composer install
npm install
copy .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
npm run build
```

Sesuaikan `.env` untuk koneksi database, aplikasi, dan email. Contoh pengaturan penting:

```env
APP_URL=http://localhost:8000
QUEUE_CONNECTION=database

MAIL_MAILER=smtp
MAIL_HOST=smtp.example.com
MAIL_PORT=587
MAIL_USERNAME=your-username
MAIL_PASSWORD=your-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=no-reply@example.com
MAIL_FROM_NAME="Payroll"
```

Jangan menyimpan kredensial SMTP atau file `.env` di Git.

## Menjalankan aplikasi

Untuk pengembangan, jalankan server, Vite, dan dua worker queue pada terminal terpisah:

```bash
php artisan serve
npm run dev
php artisan queue:listen --tries=1 --timeout=0
php artisan queue:listen --queue=email --tries=3 --timeout=300
```

Pada Windows, `composer dev` juga tersedia untuk menjalankan layanan tersebut secara bersamaan. Untuk server Linux, contoh konfigurasi Supervisor tersedia di [`supervisor/payroll-queue.conf`](supervisor/payroll-queue.conf).

## Format file impor

Baris pertama diperlakukan sebagai header. Data dibaca berdasarkan urutan kolom berikut:

| No. | Kolom | Wajib |
| --- | --- | --- |
| 1 | NIK | Ya |
| 2 | Nama | Ya |
| 3 | Email | Ya |
| 4 | Divisi | Tidak |
| 5 | Jabatan | Ya |
| 6 | Gaji pokok | Ya |
| 7 | Tambahan upah | Tidak |
| 8 | Bonus | Tidak |
| 9 | THR | Tidak |
| 10 | Apresiasi | Tidak |
| 11 | Tunjangan jabatan | Tidak |
| 12 | Premi BPJS Kesehatan 4% | Tidak |
| 13 | THR dibayarkan | Tidak |
| 14 | Potongan pinjaman | Tidak |
| 15 | Potongan absensi | Tidak |
| 16 | Potongan BPJS Kesehatan 4% | Tidak |
| 17 | Potongan BPJS Kesehatan 1% | Tidak |
| 18 | Password PDF | Ya |

Semua komponen nominal harus berupa angka nol atau positif. *Take-home pay* dihitung dengan rumus:

```text
(gaji pokok + tambahan upah + bonus + THR + apresiasi + tunjangan jabatan + premi BPJS 4%)
- (THR dibayarkan + potongan pinjaman + potongan absensi + potongan BPJS 4% + potongan BPJS 1%)
```

## Alur operasional

1. Login lalu buka menu Payroll dan unggah file payroll beserta periode.
2. Periksa data pada halaman pratinjau.
3. Pilih generate untuk membuat seluruh slip PDF dan menjadwalkan pengiriman email.
4. Pantau progres pengiriman pada halaman detail payroll.
5. Gunakan log email untuk meninjau atau mengirim ulang email yang gagal.

## Pengujian

```bash
composer test
```

## Catatan keamanan

- Ganti atau hapus akun seed sebelum deployment produksi.
- Lindungi akses aplikasi dengan HTTPS dan kredensial unik.
- Pastikan folder `storage` dapat ditulis oleh proses aplikasi, tetapi tidak dapat diakses langsung selain melalui mekanisme aplikasi.
