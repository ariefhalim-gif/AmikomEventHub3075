<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;

class CheckinController extends Controller
{
    public function index()
    {
        return view('admin.checkin.index');
    }

    public function verify($orderId)
    {
        $transaction = Transaction::where('order_id', $orderId)->first();

        if (!$transaction) {
            return response()->json([
                'status' => false,
                'message' => 'Tiket tidak ditemukan.',
            ]);
        }

        if (!in_array($transaction->status, ['success', 'settlement'])) {
            return response()->json([
                'status' => false,
                'message' => 'Pembayaran belum berhasil.',
            ]);
        }

        if ($transaction->is_used) {
            return response()->json([
                'status' => false,
                'message' => 'Tiket sudah digunakan.',
            ]);
        }

        // Update status check-in
        $transaction->is_used = true;
        $transaction->used_at = now();
        $transaction->save();

        $transaction->refresh();

        return response()->json([
            'status' => true,
            'message' => 'Check-in berhasil.',
            'transaction' => [
                'order_id' => $transaction->order_id,
                'customer_name' => $transaction->customer_name,
                'used_at' => $transaction->used_at->format('d M Y H:i'),
            ],
        ]);
    }
}