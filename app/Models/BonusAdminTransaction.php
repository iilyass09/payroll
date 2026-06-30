<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BonusAdminTransaction extends Model
{
    protected $fillable = [
        'tanggal',
        'nik',
        'nama',
        'jabatan',
        'divisi',
        'sesi',
        'ach_sold',
    ];

    protected function casts(): array
    {
        return [
            'tanggal' => 'date',
            'ach_sold' => 'decimal:2',
        ];
    }
}
