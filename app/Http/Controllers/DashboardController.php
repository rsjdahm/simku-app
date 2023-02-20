<?php

namespace App\Http\Controllers;

use App\Enums\Penatausahaan\StatusPosting;
use App\Models\Anggaran\BelanjaRkaPd;
use App\Models\Penatausahaan\BelanjaLs;
use App\Models\Penatausahaan\BuktiGu;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('layouts.dashboard');
    }

    public function show()
    {
        return view(
            'pages.dashboard',
            [
                'sum_belanja_rka_pd' => BelanjaRkaPd::get()->sum('nilai'),
                'sum_realisasi_belanja_rka_pd' => BuktiGu::where('status', StatusPosting::Posting)->get()->sum('nilai') + BelanjaLs::where('status', StatusPosting::Posting)->get()->sum('nilai'),
            ]
        );
    }
}
