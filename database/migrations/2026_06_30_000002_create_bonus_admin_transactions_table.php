<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bonus_admin_transactions', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->string('nik');
            $table->string('nama');
            $table->string('jabatan');
            $table->string('divisi');
            $table->string('sesi');
            $table->decimal('ach_sold', 15, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bonus_admin_transactions');
    }
};
