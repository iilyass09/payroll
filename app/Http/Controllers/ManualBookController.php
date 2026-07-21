<?php

namespace App\Http\Controllers;

class ManualBookController extends Controller
{
    public function index()
    {
        $books = [
            [
                'file' => 'book-host.pdf',
                'title' => 'Book Host',
                'description' => 'Panduan untuk Host',
                'icon_color' => 'red',
            ],
            [
                'file' => 'book-admin.pdf',
                'title' => 'Admin Jual',
                'description' => 'Panduan transaksi penjualan',
                'icon_color' => 'blue',
            ],
            [
                'file' => 'book-admin.pdf',
                'title' => 'Admin Beli',
                'description' => 'Panduan transaksi pembelian',
                'icon_color' => 'emerald',
            ],
        ];

        return view('hris.manual-book', compact('books'));
    }
}
