<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->string('atasan')->nullable()->after('position_id');
            $table->string('jenis_karyawan', 30)->nullable()->after('tanggal_masuk');
            $table->string('lokasi_kerja')->nullable()->after('jenis_karyawan');
            $table->string('no_kontak_darurat1', 30)->nullable()->after('no_hp');
            $table->string('hubungan_darurat1', 50)->nullable()->after('no_kontak_darurat1');
            $table->string('no_kontak_darurat2', 30)->nullable()->after('hubungan_darurat1');
            $table->string('hubungan_darurat2', 50)->nullable()->after('no_kontak_darurat2');
            $table->string('no_bpjs', 30)->nullable()->after('hubungan_darurat2');
        });
    }

    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn([
                'atasan',
                'jenis_karyawan',
                'lokasi_kerja',
                'no_kontak_darurat1',
                'hubungan_darurat1',
                'no_kontak_darurat2',
                'hubungan_darurat2',
                'no_bpjs',
            ]);
        });
    }
};
