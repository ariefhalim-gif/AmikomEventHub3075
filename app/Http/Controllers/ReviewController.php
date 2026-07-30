<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ReviewController extends Controller
{
    public function store(Request $request, Event $event)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'required|string|max:1000',
        ]);

        
        $transaction = Auth::user()
    ->transactions()
    ->where('event_id', $event->id)
    ->whereIn('status', [
        'success',
        'settlement',
    ])
    ->exists();

if (!$transaction) {
    return back()->with(
        'error',
        'Anda harus membeli tiket terlebih dahulu.'
    );
}

        // User harus pernah membeli tiket
        $transaction = Auth::user()
    ->transactions()
    ->where('event_id', $event->id)
    ->whereIn('status', [
        'success',
        'settlement',
    ])
    ->exists();

        if (!$transaction) {
            return back()->with(
                'error',
                'Anda harus membeli tiket terlebih dahulu.'
            );
        }

        // Cegah review ganda
        $exists = Review::where('user_id', Auth::id())
            ->where('event_id', $event->id)
            ->exists();

        if ($exists) {
            return back()->with(
                'error',
                'Anda sudah memberikan review.'
            );
        }

        Review::create([
            'user_id' => Auth::id(),
            'event_id' => $event->id,
            'rating' => $request->rating,
            'review' => $request->review,
        ]);

        return back()->with(
            'success',
            'Terima kasih atas review Anda.'
        );
    }
}