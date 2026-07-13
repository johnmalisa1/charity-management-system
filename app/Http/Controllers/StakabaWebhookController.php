<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class StakabaWebhookController extends Controller
{
    public function handle(Request $request)
    {
        // Log the raw payload for debugging
        Log::info('Stakaba Webhook Received:', $request->all());

        // Example: extract orderId and status
        $orderId = $request->input('orderId');
        $status  = $request->input('status'); // e.g. "SUCCESS", "FAILED"

        // TODO: Update your database record for this order/payment
        // For example:
        // Payment::where('order_id', $orderId)->update(['status' => $status]);

        return response()->json(['message' => 'Webhook processed'], 200);
    }
}
