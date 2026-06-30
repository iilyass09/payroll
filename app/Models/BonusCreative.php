<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BonusCreative extends Model
{
    protected $fillable = [
        'tanggal',
        'nik',
        'nama',
        'keterangan',
        'dokumentasi',
        'insentif',
        'pencapaian',
        'total',
    ];

    protected function casts(): array
    {
        return [
            'tanggal' => 'date',
            'insentif' => 'decimal:2',
            'pencapaian' => 'decimal:2',
            'total' => 'decimal:2',
        ];
    }
}
