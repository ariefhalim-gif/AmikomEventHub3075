<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;

class MidtransCallbackController extends Controller
{
    public function handle(Request $request)
    {
        $notification = $request->all();

        $transaction = Transaction::where(
            'order_id',
            $notification['order_id']
        )->first();

        if (!$transaction) {
            return response()->json([
                'message' => 'Transaction not found'
            ], 404);
        }

        $transaction->update([

            'status' => $notification['transaction_status']

        ]);

        return response()->json([

            'message' => 'Callback Success'

        ]);
    }
}