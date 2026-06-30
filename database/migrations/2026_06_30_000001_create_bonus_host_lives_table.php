<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bonus_host_lives', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->time('jam_mulai')->nullable();
            $table->time('jam_selesai')->nullable();
            $table->string('nik');
            $table->string('nama');
            $table->string('jabatan');
            $table->string('divisi');
            $table->string('sesi');
            $table->decimal('ach_sold', 15, 2)->default(0);
            $table->decimal('ach_view', 15, 2)->default(0);
            $table->decimal('peak_view', 15, 2)->default(0);
            $table->text('catatan')->nullable();
            $table->string('foto_statistik')->nullable();
            $table->string('foto_bukti_live')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bonus_host_lives');
    }
};
