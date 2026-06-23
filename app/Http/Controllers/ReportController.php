<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Donation;
use App\Models\Campaign;
use App\Models\Charity;

class ReportController extends Controller
{
    // Show the Reports dashboard
    public function index()
    {
        // Collect some basic stats
        $totalUsers     = User::count();
        $totalDonations = Donation::sum('amount');   // raw sum in DB
        $campaignsCount = Campaign::count();
        $charitiesCount = Charity::count();

        return view('reports.index', [
            'totalUsers'     => $totalUsers,
            'totalDonations' => $totalDonations,
            'campaignsCount' => $campaignsCount,
            'charitiesCount' => $charitiesCount,
        ]);
    }
}

