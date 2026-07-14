<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Donation;

class StakabaWebhookController extends Controller
{
    public function handle(Request $request)
    {
        // Log the raw payload for debugging
        Log::info('Stakaba Webhook Received:', $request->all());

        // Extract nested fields from the payload
        $payload = $request->input('payload', []);
        $orderId = $payload['orderId'] ?? null;
        $status  = $payload['status'] ?? null; // will appear in real payment events

        // Update the donations table if we have a matching record
        if ($orderId) {
            Donation::where('transaction_id', $orderId)->update([
                'status' => $status ?? 'PENDING', // fallback if status missing
            ]);
        }

        // Always return a quick JSON response so Stakaba sees 200 OK
        return response()->json(['status' => 'ok'], 200);
    }
}





