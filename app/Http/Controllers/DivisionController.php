<?php

namespace App\Http\Controllers;

use App\Models\Division;
use App\Models\Employee;
use Illuminate\Http\Request;

class DivisionController extends Controller
{
    public function index()
    {
        $stats = [
            'total' => Division::count(),
            'aktif' => Division::where('is_active', true)->count(),
            'karyawan' => Employee::count(),
        ];

        return view('divisions.index', compact('stats'));
    }
}
