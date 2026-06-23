<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reports PDF</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        h2, h3 { margin-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
    </style>
</head>
<body>
    <h2>System Reports Export</h2>

    @if(!empty($reports['donations']))
        <h3>Recent Donations</h3>
        <table>
            <thead><tr><th>User</th><th>Campaign</th><th>Amount</th><th>Date</th></tr></thead>
            <tbody>
                @foreach($reports['donations'] as $donation)
                    <tr>
                        <td>{{ $donation->user->name ?? 'N/A' }}</td>
                        <td>{{ $donation->campaign->title ?? 'N/A' }}</td>
                        <td>{{ number_format($donation->amount,2) }}</td>
                        <td>{{ $donation->created_at->format('M d, Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    @if(!empty($reports['campaigns']))
        <h3>Recent Campaigns</h3>
        <table>
            <thead><tr><th>Title</th><th>Goal</th><th>Charity</th></tr></thead>
            <tbody>
                @foreach($reports['campaigns'] as $campaign)
                    <tr>
                        <td>{{ $campaign->title }}</td>
                        <td>{{ $campaign->goal }}</td>
                        <td>{{ $campaign->charity->name ?? 'N/A' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    @if(!empty($reports['users']))
        <h3>Recent Users</h3>
        <table>
            <thead><tr><th>Name</th><th>Email</th><th>Joined</th></tr></thead>
            <tbody>
                @foreach($reports['users'] as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->created_at->format('M d, Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</body>
</html>
