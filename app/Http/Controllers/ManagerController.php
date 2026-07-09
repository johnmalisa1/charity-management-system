<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Campaign;
use App\Models\Donation;
use App\Models\Event;
use App\Models\VolunteerActivity;
use App\Models\Notification;
use App\Models\User;
use App\Models\EventParticipant;
use App\Models\Gallery;
use App\models\Feedback;
use Illuminate\Pagination\LengthAwarePaginator;

class ManagerController extends Controller
{
    public function index()
    {
        // Dashboard statistics
        $totalDonations = Donation::sum('amount');
        $activeCampaigns = Campaign::where('status', 'active')->count();
        $upcomingEvents = Event::where('start_time', '>=', now())->count();
        $registeredVolunteers = VolunteerActivity::count();

        // Previews
        $recentDonations = Donation::latest()->take(5)->get();
        $campaigns = Campaign::latest()->take(3)->get();
        $events = Event::where('start_time', '>=', now())->orderBy('start_time')->take(3)->get();
        $volunteers = VolunteerActivity::latest()->take(5)->get();

        // Notifications preview
        $latestNotifications = Notification::where('user_id', auth()->id())
            ->latest()
            ->take(5)
            ->get();

        // Chart data
        $donationMonths = Donation::selectRaw('MONTH(created_at) as month')
            ->groupBy('month')
            ->pluck('month');
        $donationValues = Donation::selectRaw('MONTH(created_at) as month, SUM(amount) as total')
            ->groupBy('month')
            ->pluck('total');

        $campaignTitles = Campaign::pluck('title');
        $campaignValues = Campaign::pluck('raised_amount');

        $volunteerStatuses = ['Active', 'Inactive', 'Pending'];
        $volunteerCounts = [
            VolunteerActivity::where('status', 'Active')->count(),
            VolunteerActivity::where('status', 'Inactive')->count(),
            VolunteerActivity::where('status', 'Pending')->count(),
        ];

        return view('dashboards.manager', compact(
            'totalDonations',
            'activeCampaigns',
            'upcomingEvents',
            'registeredVolunteers',
            'recentDonations',
            'campaigns',
            'events',
            'volunteers',
            'latestNotifications',
            'donationMonths',
            'donationValues',
            'campaignTitles',
            'campaignValues',
            'volunteerStatuses',
            'volunteerCounts'
        ));
    }

    // ✅ Campaigns list
public function campaigns()
{
    $campaigns = Campaign::latest()->paginate(10);
    return view('manager.campaigns.index', compact('campaigns'));
}

public function createCampaign()
{
    return view('manager.campaigns.create');
}

public function storeCampaign(Request $request)
{
    $validated = $request->validate([
        'title'       => 'required|string|max:255',
        'description' => 'nullable|string',
        'goal_amount' => 'required|numeric',
        'start_date'  => 'required|date',
        'end_date'    => 'required|date|after_or_equal:start_date',
        'images.*'    => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048', // ✅ multiple images
    ]);

    $campaign = Campaign::create($validated + [
        'raised_amount' => 0,
        'status'        => 'active', // ✅ changed from 'pending' to 'active'
    ]);

    // ✅ Save multiple images into galleries
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $image) {
            $path = $image->store('campaigns', 'public');
            Gallery::create([
                'title'       => $campaign->title,
                'image_path'  => $path,
                'campaign_id' => $campaign->id,
            ]);
        }
    }

    return redirect()->route('manager.campaigns')->with('success', 'Campaign created successfully.');
}



public function editCampaign(Campaign $campaign)
{
    return view('manager.campaigns.edit', compact('campaign'));
}

public function updateCampaign(Request $request, Campaign $campaign)
{
    $validated = $request->validate([
        'title'       => 'required|string|max:255',
        'description' => 'nullable|string',
        'goal_amount' => 'required|numeric',
        'start_date'  => 'required|date',
        'end_date'    => 'required|date|after_or_equal:start_date',
        'images.*'    => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048', // ✅ multiple images
    ]);

    $campaign->update($validated);

    // ✅ Add new images if uploaded
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $image) {
            $path = $image->store('campaigns', 'public');
            Gallery::create([
                'title'       => $campaign->title,
                'image_path'  => $path,
                'campaign_id' => $campaign->id,
            ]);
        }
    }

    return redirect()->route('manager.campaigns')->with('success', 'Campaign updated successfully.');
}


public function destroyCampaign(Campaign $campaign)
{
    $campaign->delete();
    return redirect()->route('manager.campaigns')->with('success', 'Campaign deleted successfully.');
}


    // ✅ Donations page
    public function donations()
    {
        $donations = Donation::with(['donor', 'campaign'])->latest()->paginate(10);
        return view('manager.donations.index', compact('donations'));
    }

public function createDonation()
{
    $campaigns = Campaign::all();
    $donors = User::all(); // or filter only donors if you have a role system
    return view('manager.donations.create', compact('campaigns', 'donors'));
}

public function storeDonation(Request $request)
{
    $validated = $request->validate([
        'donor_id' => 'required|exists:users,id',
        'campaign_id' => 'required|exists:campaigns,id',
        'amount' => 'required|numeric|min:1',
    ]);

    Donation::create($validated);

    return redirect()->route('manager.donations')->with('success', 'Donation added successfully.');
}

public function editDonation(Donation $donation)
{
    $campaigns = Campaign::all();
    $donors = User::all();
    return view('manager.donations.edit', compact('donation', 'campaigns', 'donors'));
}

public function updateDonation(Request $request, Donation $donation)
{
    $validated = $request->validate([
        'donor_id' => 'required|exists:users,id',
        'campaign_id' => 'required|exists:campaigns,id',
        'amount' => 'required|numeric|min:1',
    ]);

    $donation->update($validated);

    return redirect()->route('manager.donations')->with('success', 'Donation updated successfully.');
}

public function destroyDonation(Donation $donation)
{
    $donation->delete();
    return redirect()->route('manager.donations')->with('success', 'Donation deleted successfully.');
}


  public function events()
{
    $events = Event::orderBy('start_time', 'desc')->paginate(10);
    return view('manager.events.index', compact('events'));
}

public function createEvent()
{
    // ✅ Pass charities to the view so the dropdown can be populated
    $charities = \App\Models\Charity::all();
    return view('manager.events.create', compact('charities'));
}

public function storeEvent(Request $request)
{
    $validated = $request->validate([
        'title'       => 'required|string|max:255',
        'description' => 'nullable|string',
        'location'    => 'required|string|max:255',
        'start_time'  => 'required|date',
        'end_time'    => 'required|date|after_or_equal:start_time',
        'charity_id'  => 'required|exists:charities,id',
        'images.*'    => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048', // ✅ multiple images
    ]);

    $event = Event::create($validated);

    // ✅ Save multiple images into galleries
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $image) {
            $path = $image->store('events', 'public');
            Gallery::create([
                'title'     => $event->title,
                'image_path'=> $path,
                'event_id'  => $event->id,
            ]);
        }
    }

    return redirect()->route('manager.events')->with('success', 'Event created successfully.');
}


public function editEvent(Event $event)
{
    // ✅ Also pass charities to the edit view so manager can change charity
    $charities = \App\Models\Charity::all();
    return view('manager.events.edit', compact('event', 'charities'));
}

public function updateEvent(Request $request, Event $event)
{
    $validated = $request->validate([
        'title'       => 'required|string|max:255',
        'description' => 'nullable|string',
        'location'    => 'required|string|max:255',
        'start_time'  => 'required|date',
        'end_time'    => 'required|date|after_or_equal:start_time',
        'charity_id'  => 'required|exists:charities,id',
        'images.*'    => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048', // ✅ multiple images
    ]);

    $event->update($validated);

    // ✅ Add new images if uploaded
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $image) {
            $path = $image->store('events', 'public');
            Gallery::create([
                'title'     => $event->title,
                'image_path'=> $path,
                'event_id'  => $event->id,
            ]);
        }
    }

    return redirect()->route('manager.events')->with('success', 'Event updated successfully.');
}


public function destroyEvent(Event $event)
{
    $event->delete();
    return redirect()->route('manager.events')->with('success', 'Event deleted successfully.');
}



public function showEvent(Event $event)
{
    // Load donors, volunteers, and campaign with donations
    $event->load(['donors', 'volunteers', 'campaign.donations.donor']);

    // Merge donors and volunteers into unified participants
    $participants = $event->donors->merge($event->volunteers);

    // Donations via campaign (if campaign exists)
    if ($event->campaign) {
        $donations = $event->campaign->donations()->with('donor')->paginate(10);
    } else {
        // Return an empty paginator instead of a plain collection
        $donations = new LengthAwarePaginator([], 0, 10, 1, [
            'path' => request()->url(),
            'query' => request()->query(),
        ]);
    }

    return view('manager.events.show', compact('event', 'participants', 'donations'));
}










    // ✅ Volunteers page
    // List volunteers
public function volunteers()
{
    $volunteers = VolunteerActivity::with('user')->latest()->paginate(10);
    return view('manager.volunteers.index', compact('volunteers'));
}

// Show create form
public function createVolunteer()
{
    $users = \App\Models\User::all();
    return view('manager.volunteers.create', compact('users'));
}

// Store new volunteer
public function storeVolunteer(Request $request)
{
    $validated = $request->validate([
        'user_id'      => 'required|exists:users,id',
        'activity_name'=> 'required|string|max:255',
        'description'  => 'nullable|string',
        'date'         => 'required|date',
        'skills'       => 'nullable|string|max:255',
        'availability' => 'nullable|string|max:255',
        'status'       => 'required|string|in:Active,Inactive,Pending',
    ]);

    VolunteerActivity::create($validated);

    return redirect()->route('manager.volunteers')
                     ->with('success', 'Volunteer created successfully.');
}


// Show edit form
public function editVolunteer(VolunteerActivity $volunteer)
{
    $users = \App\Models\User::all();
    return view('manager.volunteers.edit', compact('volunteer', 'users'));
}

// Update volunteer
public function updateVolunteer(Request $request, VolunteerActivity $volunteer)
{
    $validated = $request->validate([
        'user_id'      => 'required|exists:users,id',
        'skills'       => 'nullable|string|max:255',
        'availability' => 'nullable|string|max:255',
        'status'       => 'required|string|in:active,inactive,pending',
    ]);

    $volunteer->update($validated);

    return redirect()->route('manager.volunteers')->with('success', 'Volunteer updated successfully.');
}

// Delete volunteer
public function destroyVolunteer(VolunteerActivity $volunteer)
{
    $volunteer->delete();
    return redirect()->route('manager.volunteers')->with('success', 'Volunteer deleted successfully.');
}


  // List notifications
public function notifications()
{
    $notifications = Notification::where('user_id', auth()->id())
        ->latest()
        ->paginate(10);

    return view('manager.notifications.index', compact('notifications'));
}

// Mark single notification as read
public function markAsRead(Notification $notification)
{
    $notification->update(['is_read' => true]);
    return redirect()->route('manager.notifications')->with('success', 'Notification marked as read.');
}

// Mark all notifications as read
public function markAllAsRead()
{
    Notification::where('user_id', auth()->id())
        ->update(['is_read' => true]);

    return redirect()->route('manager.notifications')->with('success', 'All notifications marked as read.');
}

// Delete notification
public function destroyNotification(Notification $notification)
{
    $notification->delete();
    return redirect()->route('manager.notifications')->with('success', 'Notification deleted successfully.');
}


    // List participants (unified: donors + volunteers + manual participants)
public function participants()
{
    // Load events with donors, volunteers, and manual participants
    $events = Event::with(['donors', 'volunteers', 'participants.user'])->get();

    $participants = collect();

    foreach ($events as $event) {
        // Donors
        foreach ($event->donors as $donor) {
            $participants->push([
                'event' => $event->title,
                'name'  => $donor->name,
                'email' => $donor->email,
                'role'  => 'Donor',
            ]);
        }

        // Volunteers
        foreach ($event->volunteers as $volunteer) {
            $participants->push([
                'event' => $event->title,
                'name'  => $volunteer->name,
                'email' => $volunteer->email,
                'role'  => 'Volunteer',
            ]);
        }

        // Manually added participants (EventParticipant model)
        foreach ($event->participants as $participant) {
            $participants->push([
                'event' => $event->title,
                'name'  => $participant->user->name,
                'email' => $participant->user->email,
                'role'  => $participant->role ?? 'Participant',
            ]);
        }
    }

    // Paginate manually
    $page = request()->get('page', 1);
    $perPage = 10;
    $paginated = new \Illuminate\Pagination\LengthAwarePaginator(
        $participants->forPage($page, $perPage),
        $participants->count(),
        $perPage,
        $page,
        ['path' => request()->url(), 'query' => request()->query()]
    );

    return view('manager.participants.index', compact('paginated'));
}

// Show create form
public function createParticipant()
{
    $events = Event::all();
    $users = \App\Models\User::all();
    return view('manager.participants.create', compact('events', 'users'));
}

// Store new participant (manual entry)
public function storeParticipant(Request $request)
{
    $validated = $request->validate([
        'event_id' => 'required|exists:events,id',
        'user_id'  => 'required|exists:users,id',
        'role'     => 'nullable|string|max:255',
    ]);

    EventParticipant::create($validated);

    return redirect()->route('manager.participants')->with('success', 'Participant added successfully.');
}

// Show edit form
public function editParticipant(EventParticipant $participant)
{
    $events = Event::all();
    $users = \App\Models\User::all();
    return view('manager.participants.edit', compact('participant', 'events', 'users'));
}

// Update participant
public function updateParticipant(Request $request, EventParticipant $participant)
{
    $validated = $request->validate([
        'event_id' => 'required|exists:events,id',
        'user_id'  => 'required|exists:users,id',
        'role'     => 'nullable|string|max:255',
    ]);

    $participant->update($validated);

    return redirect()->route('manager.participants')->with('success', 'Participant updated successfully.');
}

// Delete participant
public function destroyParticipant(EventParticipant $participant)
{
    $participant->delete();
    return redirect()->route('manager.participants')->with('success', 'Participant deleted successfully.');
}


  // Reports dashboard
public function reports(Request $request)
{
    // Filters (optional: by month, campaign, etc.)
    $month = $request->input('month');
    $campaignId = $request->input('campaign_id');

    // Donations summary
    $donationsQuery = Donation::query();
    if ($month) {
        $donationsQuery->whereMonth('created_at', $month);
    }
    if ($campaignId) {
        $donationsQuery->where('campaign_id', $campaignId);
    }
    $donations = $donationsQuery->latest()->paginate(20);

    // KPIs
    $totalDonations = $donationsQuery->sum('amount');
    $campaignsCount = Campaign::count();
    $volunteersCount = VolunteerActivity::count();
    $eventsCount = Event::count();

    // Chart data
    $monthlyDonations = Donation::selectRaw('MONTH(created_at) as month, SUM(amount) as total')
        ->groupBy('month')
        ->pluck('total', 'month');

    return view('manager.reports.index', compact(
        'donations',
        'totalDonations',
        'campaignsCount',
        'volunteersCount',
        'eventsCount',
        'monthlyDonations'
    ));
}

// Export PDF
public function reportsPdf(Request $request)
{
    $donations = Donation::latest()->take(50)->get();
    $campaigns = Campaign::latest()->take(20)->get();
    $volunteers = VolunteerActivity::latest()->take(20)->get();

    $pdf = \PDF::loadView('manager.reports.pdf', compact('donations', 'campaigns', 'volunteers'));
    return $pdf->download('reports.pdf');
}

// List gallery items
public function gallery()
{
    // Only show gallery items with their event relationship
    $galleryItems = Gallery::with('event')->latest()->paginate(12);
    return view('manager.gallery.index', compact('galleryItems'));
}

// Show upload form
public function createGallery()
{
    // Pass all events so manager can choose which event the image belongs to
    $events = Event::all();
    return view('manager.gallery.create', compact('events'));
}

// Store new gallery item
public function storeGallery(Request $request)
{
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'image' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
        'event_id' => 'required|exists:events,id', // ensure valid event
    ]);

    $path = $request->file('image')->store('gallery', 'public');

    Gallery::create([
        'title' => $validated['title'],
        'image_path' => $path,
        'event_id' => $validated['event_id'], // link to event
    ]);

    return redirect()->route('manager.gallery')->with('success', 'Image uploaded successfully.');
}

// Delete gallery item
public function destroyGallery(Gallery $gallery)
{
    \Storage::disk('public')->delete($gallery->image_path);
    $gallery->delete();

    return redirect()->route('manager.gallery')->with('success', 'Image deleted successfully.');
}

// Replace gallery item (update image)
public function updateGallery(Request $request, Gallery $gallery)
{
    $validated = $request->validate([
        'image' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
    ]);

    // Delete old file
    \Storage::disk('public')->delete($gallery->image_path);

    // Store new file
    $path = $request->file('image')->store('gallery', 'public');

    // Update gallery record
    $gallery->update([
        'image_path' => $path,
    ]);

    return redirect()->back()->with('success', 'Image replaced successfully.');
}


public function feedbackIndex()
{
    $feedbackItems = \App\Models\Feedback::with(['user','charity'])
        ->latest()
        ->paginate(10);

    return view('manager.feedback.index', compact('feedbackItems'));
}

public function profile()
{
    $manager = auth()->user();
    return view('manager.profile.index', compact('manager'));
}

public function updateProfile(Request $request)
{
    $manager = auth()->user();

    $data = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email',
        'password' => 'nullable|confirmed|min:8',
        'photo' => 'nullable|image|max:2048',
    ]);

    if ($request->hasFile('photo')) {
        $path = $request->file('photo')->store('profiles', 'public');
        $data['photo_url'] = '/storage/' . $path;
    }

    if (!empty($data['password'])) {
        $data['password'] = bcrypt($data['password']);
    } else {
        unset($data['password']);
    }

    $manager->update($data);

    return redirect()->route('manager.profile')->with('success', 'Profile updated successfully.');
}


}






