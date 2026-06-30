<?php

namespace App\Http\Controllers;

use App\Models\BonusCreative;
use App\Models\BonusHostLive;
use App\Models\BonusAdminTransaction;

class BonusController extends Controller
{
    public function index()
    {
        $stats = [
            'host_live' => BonusHostLive::count(),
            'admin_transaksi' => BonusAdminTransaction::count(),
            'creative' => BonusCreative::count(),
        ];

        return view('bonus.index', compact('stats'));
    }
}
