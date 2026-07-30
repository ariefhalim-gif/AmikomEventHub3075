<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Query Dasar
        |--------------------------------------------------------------------------
        */

        $query = Transaction::with(['event', 'event.organization']);

        /*
        |--------------------------------------------------------------------------
        | Multi Tenant
        |--------------------------------------------------------------------------
        */

        if (auth()->user()->role === 'organizer') {

            $query->whereHas('event', function ($q) {
                $q->where(
                    'organization_id',
                    auth()->user()->organization_id
                );
            });

        }

        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->where('order_id', 'like', "%{$search}%")
                    ->orWhere('customer_name', 'like', "%{$search}%")
                    ->orWhere('customer_email', 'like', "%{$search}%");

            });

        }

        /*
        |--------------------------------------------------------------------------
        | Filter Status
        |--------------------------------------------------------------------------
        */

        if ($request->filled('status')) {

            if ($request->status == 'success') {

                $query->whereIn('status', [
                    'success',
                    'settlement'
                ]);

            } elseif ($request->status == 'failed') {

                $query->whereIn('status', [
                    'failed',
                    'expire',
                    'cancel',
                    'deny'
                ]);

            } else {

                $query->where('status', $request->status);

            }

        }

        /*
        |--------------------------------------------------------------------------
        | Summary Cards
        |--------------------------------------------------------------------------
        */

        $summary = Transaction::query();

        if (auth()->user()->role === 'organizer') {

            $summary->whereHas('event', function ($q) {
                $q->where(
                    'organization_id',
                    auth()->user()->organization_id
                );
            });

        }

        $totalRevenue = (clone $summary)
            ->whereIn('status', ['success', 'settlement'])
            ->sum('total_price');

        $successCount = (clone $summary)
            ->whereIn('status', ['success', 'settlement'])
            ->count();

        $pendingCount = (clone $summary)
            ->where('status', 'pending')
            ->count();

        /*
        |--------------------------------------------------------------------------
        | Data
        |--------------------------------------------------------------------------
        */

        $transactions = $query
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.transactions.index', compact(
            'transactions',
            'totalRevenue',
            'successCount',
            'pendingCount'
        ));
    }

    /**
     * Export
     */
    public function export(Request $request)
    {
        return back()->with(
            'success',
            'Fitur export laporan sedang diproses.'
        );
    }
}