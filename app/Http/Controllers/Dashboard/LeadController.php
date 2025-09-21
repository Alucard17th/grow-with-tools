<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    // Display the list of leads
    public function index()
    {
        $leads = Lead::all(); // Fetch all leads
        return view('dashboard.leads.index', compact('leads'));
    }

    // Show form to create a new lead
    public function create()
    {
        return view('dashboard.leads.create');
    }

    // Store a new lead in the database
    public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|unique:leads,email',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
        ]);

        Lead::create($validated);

        return redirect()->route('leads.index')->with('success', 'Lead created successfully!');
    }

    public function jsStore(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|unique:leads,email',
            'full_name' => 'nullable|string|max:255',
        ]);

        $validated['first_name'] = explode(' ', $validated['full_name'])[0];
        $validated['last_name'] = explode(' ', $validated['full_name'])[1];

        Lead::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Thanks for subscribing!',
        ]);
    }

    // Show the details of a specific lead
    public function show(Lead $lead)
    {
        return view('dashboard.leads.show', compact('lead'));
    }

    // Show form to edit an existing lead
    public function edit(Lead $lead)
    {
        return view('dashboard.leads.edit', compact('lead'));
    }

    // Update an existing lead in the database
    public function update(Request $request, Lead $lead)
    {
        $validated = $request->validate([
            'email' => 'required|email|unique:leads,email,' . $lead->id,
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
        ]);

        $lead->update($validated);

        return redirect()->route('leads.index')->with('success', 'Lead updated successfully!');
    }

    // Delete a specific lead
    public function destroy(Lead $lead)
    {
        $lead->delete();
        return redirect()->route('leads.index')->with('success', 'Lead deleted successfully!');
    }
}
