<?php

namespace App\Http\Controllers;

use App\Models\Volunteer;
use App\Models\KegiatanVolunteer;
use App\Models\Lembaga;

class DashboardController extends Controller
{
    public function index()
    {
        $counts = [
            'volunteers' => Volunteer::where('status', 'approved')->count(),
            'campaigns' => KegiatanVolunteer::count(),
            'organizations' => Lembaga::count(),
        ];

        return view('layouts.user_app', compact('counts'));
    }
}