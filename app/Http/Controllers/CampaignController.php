<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Campaign;

class CampaignController extends Controller
{
    // Show the Add Campaign form
    public function create()
    {
        // ✅ Point directly to resources/views/campaigns/create.blade.php
        return view('campaigns.create');
    }

    // Handle form submission
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'goal_amount' => 'required|numeric|min:1',
            'start_date'  => 'required|date',
            'end_date'    => 'required|date|after_or_equal:start_date',
        ]);

        Campaign::create($validated);

        // ✅ Redirect back to admin dashboard with success message
        return redirect()->route('admin.dashboard')
                         ->with('success', 'Campaign created successfully!');
    }
}


