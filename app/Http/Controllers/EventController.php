<?php

namespace App\Http\Controllers;

use App\Models\Event;

class EventController extends Controller
{
    /**
     * Menampilkan detail event beserta review dan kategori.
     */
    public function show(Event $event)
    {
        $event->load([
    'category',
    'reviews' => function ($query) {
        $query->latest();
    },
    'reviews.user',
]);

        return view('event-detail', compact('event'));
    }
}