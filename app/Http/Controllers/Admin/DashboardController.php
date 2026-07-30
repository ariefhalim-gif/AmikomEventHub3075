<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        /*
        |--------------------------------------------------------------------------
        | SUPERADMIN
        |--------------------------------------------------------------------------
        */
        if ($user->role === 'superadmin' || $user->role === 'admin') {

            $totalRevenue = Transaction::whereIn('status', [
                'success',
                'settlement',
            ])->sum('total_price');

            $ticketsSold = Transaction::whereIn('status', [
                'success',
                'settlement',
            ])->sum('quantity');

            $activeEvents = Event::count();

            $pendingOrders = Transaction::where('status', 'pending')->count();

            $totalUsers = User::count();

            $recentTransactions = Transaction::with(['event', 'user'])
                ->latest()
                ->limit(10)
                ->get();

            $eventChart = Event::selectRaw('MONTH(date) as month, COUNT(*) as total')
                ->groupBy('month')
                ->orderBy('month')
                ->get();

            $userChart = User::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
                ->groupBy('month')
                ->orderBy('month')
                ->get();

        }

        /*
        |--------------------------------------------------------------------------
        | ORGANIZER
        |--------------------------------------------------------------------------
        */
        else {

            $eventIds = Event::query()
                ->where('organization_id', $user->organization_id)
                ->pluck('id');

            $totalRevenue = Transaction::whereIn('event_id', $eventIds)
                ->whereIn('status', [
                    'success',
                    'settlement',
                ])
                ->whereNotNull('event_id')
                ->sum('total_price');

            $ticketsSold = Transaction::whereIn('event_id', $eventIds)
                ->whereIn('status', [
                    'success',
                    'settlement',
                ])
                ->sum('quantity');

            $activeEvents = Event::where(
                'organization_id',
                $user->organization_id
            )->count();

            $pendingOrders = Transaction::whereIn('event_id', $eventIds)
                ->where('status', 'pending')
                ->count();

            // Organizer tidak melihat statistik user seluruh aplikasi
            $totalUsers = 0;

            $recentTransactions = Transaction::with(['event', 'user'])
                ->whereHas('event', function ($query) use ($user) {
                    $query->where(
                        'organization_id',
                        $user->organization_id
                    );
                })
                ->latest()
                ->limit(10)
                ->get();

            $eventChart = Event::where(
                    'organization_id',
                    $user->organization_id
                )
                ->selectRaw('MONTH(date) as month, COUNT(*) as total')
                ->groupBy('month')
                ->orderBy('month')
                ->get();

            // Organizer tidak melihat grafik user
            $userChart = collect();

        }

        return view('admin.dashboard', compact(
            'totalRevenue',
            'ticketsSold',
            'activeEvents',
            'pendingOrders',
            'totalUsers',
            'recentTransactions',
            'eventChart',
            'userChart'
        ));
    }
}