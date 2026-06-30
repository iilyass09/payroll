<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BonusHostLive extends Model
{
    protected $fillable = [
        'tanggal',
        'jam_mulai',
        'jam_selesai',
        'nik',
        'nama',
        'jabatan',
        'divisi',
        'sesi',
        'ach_sold',
        'ach_view',
        'peak_view',
        'catatan',
        'foto_statistik',
        'foto_bukti_live',
    ];

    protected function casts(): array
    {
        return [
            'tanggal' => 'date',
            'jam_mulai' => 'string',
            'jam_selesai' => 'string',
            'ach_sold' => 'decimal:2',
            'ach_view' => 'decimal:2',
            'peak_view' => 'decimal:2',
        ];
    }
}
