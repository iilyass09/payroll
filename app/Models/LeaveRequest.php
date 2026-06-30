<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LeaveRequest extends Model
{
    protected $fillable = [
        'employee_id',
        'atasan_id',
        'jenis',
        'tanggal_mulai',
        'tanggal_selesai',
        'durasi',
        'keterangan',
        'catatan_persetujuan',
        'persetujuan_koor',
        'persetujuan_hr',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_mulai' => 'date',
            'tanggal_selesai' => 'date',
        ];
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function atasan(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'atasan_id');
    }
}
