<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->role === 'admin') {

            $events = Event::with(['category', 'organization'])
                ->latest()
                ->paginate(10);

        } else {

            $events = Event::with(['category', 'organization'])
                ->where('organization_id', Auth::user()->organization_id)
                ->latest()
                ->paginate(10);

        }

        return view('admin.events.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();

        return view('admin.events.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date' => 'required|date',
            'location' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:1',
            'poster' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Organizer otomatis menjadi pemilik event
        $validated['organization_id'] = Auth::user()->organization_id;

        if ($request->hasFile('poster')) {
            $validated['poster_path'] = $request
                ->file('poster')
                ->store('posters', 'public');
        }

        Event::create($validated);

        return redirect()
            ->route('admin.events.index')
            ->with('success', 'Event berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        if (
            Auth::user()->role !== 'admin' &&
            $event->organization_id != Auth::user()->organization_id
        ) {
            abort(403);
        }

        return redirect()->route('admin.events.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        if (
            Auth::user()->role !== 'admin' &&
            $event->organization_id != Auth::user()->organization_id
        ) {
            abort(403);
        }

        $categories = Category::all();

        return view('admin.events.edit', compact('event', 'categories'));
    }

    /**
     * Update the specified resource.
     */
    public function update(Request $request, Event $event)
    {
        if (
            Auth::user()->role !== 'admin' &&
            $event->organization_id != Auth::user()->organization_id
        ) {
            abort(403);
        }

        $data = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date' => 'required|date',
            'location' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:1',
            'poster' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('poster')) {

            if (
                $event->poster_path &&
                Storage::disk('public')->exists($event->poster_path)
            ) {
                Storage::disk('public')->delete($event->poster_path);
            }

            $data['poster_path'] = $request
                ->file('poster')
                ->store('posters', 'public');
        }

        $event->update($data);

        return redirect()
            ->route('admin.events.index')
            ->with('success', 'Event berhasil diperbarui.');
    }

    /**
     * Remove the specified resource.
     */
    public function destroy(Event $event)
    {
        if (
            Auth::user()->role !== 'admin' &&
            $event->organization_id != Auth::user()->organization_id
        ) {
            abort(403);
        }

        if (
            $event->poster_path &&
            Storage::disk('public')->exists($event->poster_path)
        ) {
            Storage::disk('public')->delete($event->poster_path);
        }

        $event->delete();

        return redirect()
            ->route('admin.events.index')
            ->with('success', 'Event berhasil dihapus.');
    }
}