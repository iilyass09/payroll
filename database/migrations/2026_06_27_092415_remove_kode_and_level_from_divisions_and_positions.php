<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('divisions', function (Blueprint $table) {
            $table->dropUnique(['kode']);
            $table->dropColumn('kode');
        });

        Schema::table('positions', function (Blueprint $table) {
            $table->dropUnique(['kode']);
            $table->dropColumn('kode');
            $table->dropColumn('level');
        });
    }

    public function down(): void
    {
        Schema::table('divisions', function (Blueprint $table) {
            $table->string('kode', 20)->unique()->after('id');
        });

        Schema::table('positions', function (Blueprint $table) {
            $table->string('kode', 20)->unique()->after('id');
            $table->integer('level')->default(0)->after('parent_id');
        });
    }
};
