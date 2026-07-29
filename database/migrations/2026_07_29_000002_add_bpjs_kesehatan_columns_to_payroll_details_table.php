<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payroll_details', function (Blueprint $table) {
            $table->decimal('premi_bpjs_kesehatan_4', 15, 2)->default(0)->after('tunjangan_jabatan');
            $table->decimal('potongan_bpjs_kesehatan_4', 15, 2)->default(0)->after('potongan_absensi');
            $table->decimal('potongan_bpjs_kesehatan_1', 15, 2)->default(0)->after('potongan_bpjs_kesehatan_4');
            $table->dropColumn('potongan_bpjs');
        });
    }

    public function down(): void
    {
        Schema::table('payroll_details', function (Blueprint $table) {
            $table->decimal('potongan_bpjs', 15, 2)->default(0)->after('potongan_absensi');
            $table->dropColumn(['premi_bpjs_kesehatan_4', 'potongan_bpjs_kesehatan_4', 'potongan_bpjs_kesehatan_1']);
        });
    }
};
