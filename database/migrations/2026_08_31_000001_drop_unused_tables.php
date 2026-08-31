<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $tables = [
            'attendances',
            'bonus_admin_transactions',
            'bonus_creatives',
            'bonus_host_lives',
            'divisions',
            'employee_contracts',
            'employee_documents',
            'employees',
            'meeting_requests',
            'meetings',
            'position_histories',
            'positions',
            'promotions',
        ];

        foreach ($tables as $table) {
            Schema::dropIfExists($table);
        }
    }

    public function down(): void
    {
        // Cannot reverse — tables and their data are permanently deleted
    }
};
