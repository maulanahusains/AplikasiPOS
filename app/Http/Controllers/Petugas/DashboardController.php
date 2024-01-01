<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    //
    public function dashboard_admin() {
        return Inertia::render('Petugas/Dashboards/Admin');
    }

    public function dashboard_petugas() {
        return Inertia::render('Petugas/Dashboards/Kasir');
    }
}
