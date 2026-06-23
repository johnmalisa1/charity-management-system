<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\Campaign;
use App\Models\Event;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf; // ✅ Import DomPDF

class DonorController extends Controller
{
    // Dashboard
    public function index()
    {
        $user = Auth::user();

        // Statistics
        $totalDonations = Donation::where('donor_id', $user->id)->sum('amount');
        $campaignsSupported = Donation::where('donor_id', $user->id)
            ->distinct('campaign_id')->count('campaign_id');
        $eventsJoined = Event::whereHas('participants', fn($q) => $q->where('user_id', $user->id))->count();
        $volunteerActivities = $user->volunteerActivities()->count() ?? 0;

        // Previews
        $recentDonations = Donation::where('donor_id', $user->id)->latest()->take(5)->get();
        $featuredCampaigns = Campaign::where('is_featured', true)->take(2)->get();
        $upcomingEvents = Event::where('start_time', '>=', now())->orderBy('start_time')->take(3)->get();
        $latestNotifications = Notification::where('user_id', $user->id)->latest()->take(3)->get();

        return view('dashboards.donor', compact(
            'user',
            'totalDonations',
            'campaignsSupported',
            'eventsJoined',
            'volunteerActivities',
            'recentDonations',
            'featuredCampaigns',
            'upcomingEvents',
            'latestNotifications'
        ));
    }

    // My Donations page
    public function donations()
    {
        $user = Auth::user();
        $donations = $user->donations()->latest()->paginate(10);
        return view('donor.donations', compact('donations'));
    }

    // Download all donations as CSV
    public function downloadDonations()
    {
        $user = Auth::user();
        $donations = $user->donations()->latest()->get();

        $csv = "Campaign,Amount,Date\n";
        foreach ($donations as $donation) {
            $csv .= "{$donation->campaign->title},{$donation->amount},{$donation->created_at->format('Y-m-d')}\n";
        }

        return response($csv)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename=donations.csv');
    }

    // Campaigns list page
    public function campaigns()
    {
        $campaigns = Campaign::latest()->paginate(10);
        return view('donor.campaigns', compact('campaigns'));
    }

    // ✅ Campaign detail page
    public function showCampaign(Campaign $campaign)
    {
        $campaign->load('galleries');
        return view('donor.campaigns.show', compact('campaign'));
    }

    // Donate to a campaign (POST)
    public function donate(Request $request, Campaign $campaign)
{
    $validated = $request->validate([
        'amount' => 'required|numeric|min:1',
    ]);

    Donation::create([
        'donor_id'    => Auth::id(),
        'campaign_id' => $campaign->id,
        'amount'      => $validated['amount'],
    ]);

    // ✅ Update campaign raised_amount
    $campaign->increment('raised_amount', $validated['amount']);

    return redirect()->route('donor.campaigns')
                     ->with('success', 'Donation successful!');
}



    // Events list page
    public function events()
    {
        $events = Event::latest()->paginate(10);
        return view('donor.events', compact('events'));
    }

    // ✅ Event detail page
    public function showEvent(Event $event)
    {
        $event->load('galleries', 'participants');
        return view('donor.events.show', compact('event'));
    }

    // Join an event
public function joinEvent(Event $event)
{
    $user = Auth::user();

    // Check if donor already joined
    if (!$event->donors()->where('user_id', $user->id)->exists()) {
        $event->donors()->attach($user->id);
    }

    return redirect()->back()->with('success', 'You have joined the event!');
}

// Cancel participation in an event
public function cancelEvent(Event $event)
{
    $user = Auth::user();

    // Detach donor from event
    $event->donors()->detach($user->id);

    return redirect()->back()->with('success', 'You have cancelled your participation.');
}


    // Donation Receipts page
    public function receipts()
    {
        $user = Auth::user();
        $receipts = $user->donations()->latest()->paginate(10);
        return view('donor.receipts', compact('receipts'));
    }

    // ✅ Download a single receipt as PDF
    public function downloadReceipt(Donation $donation)
    {
        $pdf = Pdf::loadView('donor.receipt_pdf', compact('donation'));
        return $pdf->download('receipt.pdf');
    }

    // Notifications page
    public function notifications()
    {
        $user = Auth::user();
        $notifications = Notification::where('user_id', $user->id)->latest()->paginate(10);
        return view('donor.notifications', compact('notifications'));
    }

    // Profile page
    public function profile()
    {
        $user = Auth::user();
        return view('donor.profile', compact('user'));
    }

    // Volunteer Activities page
    public function volunteer()
    {
        $user = Auth::user();
        $query = $user->volunteerActivities()->latest();

        if (request('activity_name')) {
            $query->where('activity_name', 'like', '%' . request('activity_name') . '%');
        }
        if (request('from_date')) {
            $query->whereDate('date', '>=', request('from_date'));
        }
        if (request('to_date')) {
            $query->whereDate('date', '<=', request('to_date'));
        }

        $activities = $query->paginate(10)->withQueryString();
        return view('donor.volunteer', compact('user', 'activities'));
    }
}











