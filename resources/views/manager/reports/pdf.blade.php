<!DOCTYPE html>
<html>
<head>
    <title>Reports PDF</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #333; padding: 6px; text-align: left; }
    </style>
</head>
<body>
    <h2>Reports Summary</h2>

    <h3>Donations</h3>
    <table>
        <thead>
            <tr><th>Donor</th><th>Campaign</th><th>Amount</th><th>Date</th></tr>
        </thead>
        <tbody>
            @foreach($donations as $donation)
                <tr>
                    <td>{{ $donation->donor->name ?? 'N/A' }}</td>
                    <td>{{ $donation->campaign->title ?? 'N/A' }}</td>
                    <td>{{ $donation->amount }}</td>
                    <td>{{ $donation->created_at->format('Y-m-d') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h3>Campaigns</h3>
    <table>
        <thead>
            <tr><th>Title</th><th>Goal</th><th>Raised</th></tr>
        </thead>
        <tbody>
            @foreach($campaigns as $campaign)
                <tr>
                    <td>{{ $campaign->title }}</td>
                    <td>{{ $campaign->goal_amount }}</td>
                    <td>{{ $campaign->raised_amount }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h3>Volunteers</h3>
    <table>
        <thead>
            <tr><th>Name</th><th>Status</th></tr>
        </thead>
        <tbody>
            @foreach($volunteers as $volunteer)
                <tr>
                    <td>{{ $volunteer->user->name }}</td>
                    <td>{{ ucfirst($volunteer->status) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
