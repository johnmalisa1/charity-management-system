<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Donation Receipt</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        .receipt { border: 1px solid #333; padding: 20px; }
        h2 { color: #4f46e5; }
    </style>
</head>
<body>
    <div class="receipt">
        <h2>Receipt for Donation</h2>
        <p><strong>Campaign:</strong> {{ $donation->campaign->title }}</p>
        <p><strong>Amount:</strong> {{ number_format($donation->amount, 2) }} TZS</p>
        <p><strong>Date:</strong> {{ $donation->created_at->format('Y-m-d') }}</p>
    </div>
</body>
</html>
