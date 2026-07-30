<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Event;
use App\Models\Transaction;
use Midtrans\Config;
use Midtrans\Snap;

class TicketController extends Controller
{
    /**
     * Halaman Checkout
     */
    public function checkout(Event $event)
    {
        return view('checkout', compact('event'));
    }

    /**
     * Simpan Checkout
     */
    public function store(Request $request, Event $event)
    {
        $data = $request->validate([
            'customer_name'  => 'required|string|max:255',
            'customer_email' => 'required|email',
            'customer_phone' => 'required',
            'quantity'       => 'required|integer|min:1',
        ]);

        if ($data['quantity'] > $event->stock) {
            return back()
                ->withErrors([
                    'quantity' => 'Stok tiket tidak mencukupi.'
                ])
                ->withInput();
        }

        $ticketPrice = $event->price;
        $adminFee = 5000;
        $totalPrice = ($ticketPrice * $data['quantity']) + $adminFee;

        $transaction = Transaction::create([
            'event_id'        => $event->id,
            'user_id'         => Auth::id(),
            'order_id'        => 'ORD-' . strtoupper(Str::random(10)),
            'customer_name'   => $data['customer_name'],
            'customer_email'  => $data['customer_email'],
            'customer_phone'  => $data['customer_phone'],
            'quantity'        => $data['quantity'],
            'ticket_price'    => $ticketPrice,
            'admin_fee'       => $adminFee,
            'total_price'     => $totalPrice,
            'status'          => 'pending',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Midtrans Configuration
        |--------------------------------------------------------------------------
        */

        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $params = [

            'transaction_details' => [
                'order_id'     => $transaction->order_id,
                'gross_amount' => (int) $transaction->total_price,
            ],

            'customer_details' => [
                'first_name' => $transaction->customer_name,
                'email'      => $transaction->customer_email,
                'phone'      => $transaction->customer_phone,
            ],

        ];

        try {

            $snapToken = Snap::getSnapToken($params);

            $transaction->update([
                'snap_token' => $snapToken
            ]);

        } catch (\Exception $e) {

            return back()->withErrors([
                'payment' => $e->getMessage()
            ]);

        }

        /*
        |--------------------------------------------------------------------------
        | Kurangi stok setelah checkout
        |--------------------------------------------------------------------------
        */

        $event->decrement('stock', $data['quantity']);

        return redirect()->route(
            'checkout.payment',
            $transaction->order_id
        );
    }

    /**
     * Halaman Payment
     */
    public function payment($order_id)
    {
        $transaction = Transaction::where('order_id', $order_id)
            ->with('event')
            ->firstOrFail();

        return view('checkout.payment', compact('transaction'));
    }

    /**
     * Halaman Success
     * Status transaksi diperbarui oleh Webhook Midtrans
     */
    public function success($order_id)
{
    $transaction = Transaction::where('order_id', $order_id)
        ->with('event')
        ->firstOrFail();

    // Untuk praktikum lokal (tanpa webhook)
    if ($transaction->status === 'pending') {
        $transaction->update([
            'status' => 'success'
        ]);

        // Refresh object agar status terbaru ikut terbaca
        $transaction->refresh();
    }

    return view('checkout.success', compact('transaction'));
}

    /**
     * Halaman Ticket Lama
     */
    public function ticket(Transaction $transaction)
    {
        $transaction->load('event');

        return view('ticket', compact('transaction'));
    }

    /**
     * Daftar Tiket Milik User
     */
    public function myTickets()
{
    $tickets = Transaction::with('event')
        ->where('user_id', Auth::id())
        ->where('status', 'success')
        ->latest()
        ->paginate(10);

    return view('ticket.index', compact('tickets'));
}

    /**
     * Detail Tiket
     */
    public function show(Transaction $transaction)
    {
        if ($transaction->user_id != Auth::id()) {
            abort(403);
        }

        if ($transaction->status !== 'success') {
    abort(403, 'Tiket belum dapat diakses karena pembayaran belum selesai.');
}

        $transaction->load('event');

        return view('ticket.show', compact('transaction'));
    }
}