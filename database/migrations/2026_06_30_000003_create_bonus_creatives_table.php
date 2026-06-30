<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bonus_creatives', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->string('nik');
            $table->string('nama');
            $table->text('keterangan')->nullable();
            $table->string('dokumentasi')->nullable();
            $table->decimal('insentif', 15, 2)->default(0);
            $table->decimal('pencapaian', 15, 2)->default(0);
            $table->decimal('total', 15, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bonus_creatives');
    }
};
