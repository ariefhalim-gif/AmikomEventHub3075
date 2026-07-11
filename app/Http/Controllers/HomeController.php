<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Event;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // Ambil semua kategori
        $categories = Category::all();

        // Query event
        $query = Event::with('category')
            ->where('date', '>=', now())
            ->orderBy('date', 'asc');

        // Filter kategori
        if ($request->filled('category')) {

            $query->whereHas('category', function ($q) use ($request) {

                $q->where('slug', $request->category);

            });

        }

        $events = $query->get();

        return view('welcome', compact(
            'events',
            'categories'
        ));
    }
}