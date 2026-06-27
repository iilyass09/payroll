<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('position_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->cascadeOnDelete();
            $table->string('jabatan');
            $table->string('divisi');
            $table->string('atasan')->nullable();
            $table->date('mulai');
            $table->date('selesai')->nullable();
            $table->enum('status', ['Aktif', 'Selesai'])->default('Aktif');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('position_histories');
    }
};
