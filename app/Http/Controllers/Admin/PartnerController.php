<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use Illuminate\Http\Request;

class PartnerController extends Controller
{
    public function index()
    {
        if (auth()->user()->role === 'admin') {

            $partners = Partner::latest()->get();

        } else {

            $partners = Partner::where(
                'organization_id',
                auth()->user()->organization_id
            )->latest()->get();

        }

        return view('admin.partners.index', compact('partners'));
    }

    public function create()
    {
        return view('admin.partners.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'logo_url' => 'required',
        ]);

        $validated['organization_id'] = auth()->user()->organization_id;

        Partner::create($validated);

        return redirect()
            ->route('admin.partners.index')
            ->with('success', 'Partner berhasil ditambahkan.');
    }
}