<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Charity;

class CharityController extends Controller
{
    // Show the Add Charity form
    public function create()
    {
        return view('charities.create');
    }

    // Handle form submission
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'registration_number' => 'required|string|max:100|unique:charities',
        ]);

        Charity::create($validated);

        return redirect()->route('admin.dashboard')
                         ->with('success', 'Charity added successfully!');
    }
}

