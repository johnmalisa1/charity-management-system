<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Donation;
use App\Models\Campaign;
use App\Models\Charity;
use App\Models\Event;
use App\Models\Volunteer;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Notification;
use App\Models\Setting;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{




    public function index()
    {
        // Donations grouped by month
        $donationsByMonth = Donation::selectRaw('MONTH(created_at) as month, SUM(amount) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month');

        // Users grouped by month
        $usersByMonth = User::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month');

        // Convert numeric months to names
        $monthNames = [
            1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr',
            5 => 'May', 6 => 'Jun', 7 => 'Jul', 8 => 'Aug',
            9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dec'
        ];

        $donationsByMonthNamed = [];
        foreach ($donationsByMonth as $month => $total) {
            $donationsByMonthNamed[$monthNames[$month]] = $total;
        }

        $usersByMonthNamed = [];
        foreach ($usersByMonth as $month => $total) {
            $usersByMonthNamed[$monthNames[$month]] = $total;
        }

        // User role counts
        $userRoles = [
            'Admins'     => User::whereHas('roles', fn($q) => $q->where('name','Admin'))->count(),
            'Managers'   => User::whereHas('roles', fn($q) => $q->where('name','Manager'))->count(),
            'Donors'     => User::whereHas('roles', fn($q) => $q->where('name','Donor'))->count(),
            'Volunteers' => User::whereHas('roles', fn($q) => $q->where('name','Volunteer'))->count(),
        ];

        // KPI counts
        $totalDonations = Donation::sum('amount');
        $totalUsers     = User::count();
        $campaignsCount = Campaign::count();
        $charitiesCount = Charity::count();

        // Recent activity
        $recentDonations = Donation::latest()->take(5)->get();
        $recentCampaigns = Campaign::latest()->take(5)->get();
        $recentUsers     = User::latest()->take(5)->get();
        $recentEvents    = Event::with('charity')->latest()->take(5)->get();

        // Campaigns for progress bars
        $campaigns = Campaign::all();

        return view('dashboards.admin', compact(
            'donationsByMonthNamed',
            'usersByMonthNamed',
            'userRoles',
            'totalDonations',
            'totalUsers',
            'campaignsCount',
            'charitiesCount',
            'recentDonations',
            'recentCampaigns',
            'recentUsers',
            'recentEvents',
            'campaigns'
        ));
    }

    // --- Sidebar Pages ---
    public function users()
    {
        $users = User::with('roles')->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function donations()
    {
        $donations = Donation::with(['donor', 'campaign'])->paginate(10);
        return view('admin.donations.index', compact('donations'));
    }

    public function campaigns()
    {
        $campaigns = Campaign::with('charity')->paginate(10);
        return view('admin.campaigns.index', compact('campaigns'));
    }

    public function events()
    {
        $events = Event::with('charity')->paginate(10);
        return view('admin.events.index', compact('events'));
    }

   public function volunteers()
{
    // Fetch volunteers from the volunteers table and eager-load the linked user
    $volunteers = Volunteer::with('user')->paginate(10);

    return view('admin.volunteers.index', compact('volunteers'));
}


  public function reports(Request $request)
{
    // Filters: admin can choose which sections to include
    $includeDonations = $request->has('donations');
    $includeCampaigns = $request->has('campaigns');
    $includeUsers     = $request->has('users');

    // KPI counts
    $totalDonations = Donation::sum('amount');
    $totalUsers     = User::count();
    $campaignsCount = Campaign::count();
    $charitiesCount = Charity::count();

    // Donations grouped by month
    $donationsByMonth = Donation::selectRaw('MONTH(created_at) as month, SUM(amount) as total')
        ->groupBy('month')
        ->orderBy('month')
        ->pluck('total', 'month');

    $monthNames = [
        1=>'Jan',2=>'Feb',3=>'Mar',4=>'Apr',5=>'May',6=>'Jun',
        7=>'Jul',8=>'Aug',9=>'Sep',10=>'Oct',11=>'Nov',12=>'Dec'
    ];

    $donationsByMonthNamed = [];
    foreach ($donationsByMonth as $month => $total) {
        $donationsByMonthNamed[$monthNames[$month]] = $total;
    }

    // Campaign status counts
    $activeCampaigns    = Campaign::where('status','active')->count();
    $completedCampaigns = Campaign::where('status','completed')->count();
    $pendingCampaigns   = Campaign::where('status','pending')->count();

    // Reports sections
    $reports = [];
    if ($includeDonations) {
        // FIXED: use donor instead of user
        $reports['donations'] = Donation::with(['donor','campaign'])->latest()->take(20)->get();
    }
    if ($includeCampaigns) {
        $reports['campaigns'] = Campaign::with('charity')->latest()->take(20)->get();
    }
    if ($includeUsers) {
        $reports['users'] = User::latest()->take(20)->get();
    }

    return view('admin.reports.index', compact(
        'totalDonations',
        'totalUsers',
        'campaignsCount',
        'charitiesCount',
        'donationsByMonthNamed',
        'activeCampaigns',
        'completedCampaigns',
        'pendingCampaigns',
        'reports'
    ));
}


public function reportsPdf(Request $request)
{
    // Filters: same as reports()
    $includeDonations = $request->has('donations');
    $includeCampaigns = $request->has('campaigns');
    $includeUsers     = $request->has('users');

    // Collect data
    $reports = [];
    if ($includeDonations) {
        // FIXED: use donor instead of user
        $reports['donations'] = Donation::with(['donor','campaign'])->latest()->take(20)->get();
    }
    if ($includeCampaigns) {
        $reports['campaigns'] = Campaign::with('charity')->latest()->take(20)->get();
    }
    if ($includeUsers) {
        $reports['users'] = User::latest()->take(20)->get();
    }

    // Generate PDF with text/tables only
    $pdf = Pdf::loadView('admin.reports.pdf', compact('reports'));
    return $pdf->download('reports.pdf');
}

public function settings()
{
    // Fetch settings from DB as key => value array
    $settings = Setting::pluck('value', 'key')->toArray();

    return view('admin.settings.index', compact('settings'));
}

public function updateSettings(Request $request)
{
    $request->validate([
        'site_name' => 'required|string|max:255',
        'timezone'  => 'required|string',
        'currency'  => 'required|string|max:10',
    ]);

    // Save each setting into DB
    foreach ($request->only(['site_name', 'timezone', 'currency']) as $key => $value) {
        Setting::updateOrCreate(['key' => $key], ['value' => $value]);
    }

    return redirect()->route('admin.settings')->with('success', 'Settings updated successfully.');
}






    // --- User CRUD ---
public function createUser()
{
    $roles = Role::all();
    return view('admin.users.create', compact('roles'));
}

public function storeUser(Request $request)
{
    $validated = $request->validate([
        'name'     => 'required|string|max:255',
        'email'    => 'required|email|unique:users',
        'password' => 'required|min:6',
        'roles'    => 'array'
    ]);

    $user = User::create([
        'name'     => $validated['name'],
        'email'    => $validated['email'],
        'password' => bcrypt($validated['password']),
    ]);

    if (!empty($validated['roles'])) {
        $user->syncRoles($validated['roles']);
    }

    return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
}

public function editUser(User $user)
{
    $roles = Role::all();
    return view('admin.users.edit', compact('user', 'roles'));
}

public function updateUser(Request $request, User $user)
{
    $validated = $request->validate([
        'name'     => 'required|string|max:255',
        'email'    => 'required|email|unique:users,email,' . $user->id,
        'password' => 'nullable|min:6',
        'roles'    => 'array'
    ]);

    $user->name  = $validated['name'];
    $user->email = $validated['email'];

    if (!empty($validated['password'])) {
        $user->password = bcrypt($validated['password']);
    }

    $user->save();

    if (!empty($validated['roles'])) {
        $user->syncRoles($validated['roles']);
    }

    return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
}

public function destroyUser(User $user)
{
    $user->delete();
    return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
}


    // --- Donation CRUD ---
public function createDonation()
{
    // Fetch all users so admin can assign a donor
    $users = User::all();
    $campaigns = Campaign::all();
    return view('admin.donations.create', compact('users', 'campaigns'));
}

public function storeDonation(Request $request)
{
    $validated = $request->validate([
        'donor_id'    => 'required|exists:users,id',
        'campaign_id' => 'required|exists:campaigns,id',
        'amount'      => 'required|numeric|min:1',
    ]);

    Donation::create([
        'donor_id'    => $validated['donor_id'],
        'campaign_id' => $validated['campaign_id'],
        'amount'      => $validated['amount'],
    ]);

    return redirect()->route('admin.donations.index')->with('success', 'Donation recorded successfully.');
}

public function editDonation(Donation $donation)
{
    $users = User::all();
    $campaigns = Campaign::all();
    return view('admin.donations.edit', compact('donation', 'users', 'campaigns'));
}

public function updateDonation(Request $request, Donation $donation)
{
    $validated = $request->validate([
        'donor_id'    => 'required|exists:users,id',
        'campaign_id' => 'required|exists:campaigns,id',
        'amount'      => 'required|numeric|min:1',
    ]);

    $donation->update([
        'donor_id'    => $validated['donor_id'],
        'campaign_id' => $validated['campaign_id'],
        'amount'      => $validated['amount'],
    ]);

    return redirect()->route('admin.donations.index')->with('success', 'Donation updated successfully.');
}

public function destroyDonation(Donation $donation)
{
    $donation->delete();
    return redirect()->route('admin.donations.index')->with('success', 'Donation deleted successfully.');
}



   // --- Campaign CRUD ---
public function createCampaign()
{
    $charities = Charity::all();
    return view('admin.campaigns.create', compact('charities'));
}

public function storeCampaign(Request $request)
{
    $validated = $request->validate([
        'title'       => 'required|string|max:255',
        'description' => 'required|string',
        'goal_amount' => 'required|numeric|min:1',
        'charity_id'  => 'required|exists:charities,id',
        'start_date'  => 'required|date',
        'end_date'    => 'required|date|after_or_equal:start_date',
    ]);

    Campaign::create([
        'title'       => $validated['title'],
        'description' => $validated['description'],
        'goal_amount' => $validated['goal_amount'],
        'charity_id'  => $validated['charity_id'],
        'start_date'  => $validated['start_date'],
        'end_date'    => $validated['end_date'],
    ]);

    return redirect()->route('admin.campaigns.index')->with('success', 'Campaign created successfully.');
}

public function editCampaign(Campaign $campaign)
{
    $charities = Charity::all();
    return view('admin.campaigns.edit', compact('campaign', 'charities'));
}

public function updateCampaign(Request $request, Campaign $campaign)
{
    $validated = $request->validate([
        'title'       => 'required|string|max:255',
        'description' => 'required|string',
        'goal_amount' => 'required|numeric|min:1',
        'charity_id'  => 'required|exists:charities,id',
        'start_date'  => 'required|date',
        'end_date'    => 'required|date|after_or_equal:start_date',
    ]);

    $campaign->update([
        'title'       => $validated['title'],
        'description' => $validated['description'],
        'goal_amount' => $validated['goal_amount'],
        'charity_id'  => $validated['charity_id'],
        'start_date'  => $validated['start_date'],
        'end_date'    => $validated['end_date'],
    ]);

    return redirect()->route('admin.campaigns.index')->with('success', 'Campaign updated successfully.');
}

public function destroyCampaign(Campaign $campaign)
{
    $campaign->delete();
    return redirect()->route('admin.campaigns.index')->with('success', 'Campaign deleted successfully.');
}


        // --- Event CRUD ---
    public function createEvent()
    {
        $charities = Charity::all();
        return view('admin.events.create', compact('charities'));
    }

    public function storeEvent(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'start_time'  => 'required|date',
            'end_time'    => 'required|date|after_or_equal:start_time',
            'location'    => 'required|string|max:255',
            'charity_id'  => 'required|exists:charities,id',
        ]);

        Event::create($validated);

        return redirect()->route('admin.events.index')->with('success', 'Event created successfully.');
    }

    public function editEvent(Event $event)
    {
        $charities = Charity::all();
        return view('admin.events.edit', compact('event', 'charities'));
    }

    public function updateEvent(Request $request, Event $event)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'start_time'  => 'required|date',
            'end_time'    => 'required|date|after_or_equal:start_time',
            'location'    => 'required|string|max:255',
            'charity_id'  => 'required|exists:charities,id',
        ]);

        $event->update($validated);

        return redirect()->route('admin.events.index')->with('success', 'Event updated successfully.');
    }

    public function destroyEvent(Event $event)
    {
        $event->delete();
        return redirect()->route('admin.events.index')->with('success', 'Event deleted successfully.');
    }

       // --- Volunteer CRUD ---
public function createVolunteer()
{
    // Pass all users so you can link a volunteer to an existing user
    $users = User::all();
    return view('admin.volunteers.create', compact('users'));
}

public function storeVolunteer(Request $request)
{
    $validated = $request->validate([
        'user_id'      => 'required|exists:users,id',
        'skills'       => 'nullable|string|max:255',
        'availability' => 'nullable|string',
        'status'       => 'required|string|in:active,inactive,pending',
    ]);

    Volunteer::create($validated);

    return redirect()->route('admin.volunteers.index')->with('success', 'Volunteer created successfully.');
}

public function editVolunteer(Volunteer $volunteer)
{
    $users = User::all();
    return view('admin.volunteers.edit', compact('volunteer', 'users'));
}

public function updateVolunteer(Request $request, Volunteer $volunteer)
{
    $validated = $request->validate([
        'user_id'      => 'required|exists:users,id',
        'skills'       => 'nullable|string|max:255',
        'availability' => 'nullable|string',
        'status'       => 'required|string|in:active,inactive,pending',
    ]);

    $volunteer->update($validated);

    return redirect()->route('admin.volunteers.index')->with('success', 'Volunteer updated successfully.');
}

public function destroyVolunteer(Volunteer $volunteer)
{
    $volunteer->delete();
    return redirect()->route('admin.volunteers.index')->with('success', 'Volunteer deleted successfully.');
}

// --- Notifications ---
public function notifications()
{
    // Fetch latest notifications, newest first
    $notifications = \App\Models\Notification::latest()->paginate(10);

    // Count unread notifications for badge display
    $unreadCount = \App\Models\Notification::where('is_read', false)->count();

    return view('admin.notifications.index', compact('notifications', 'unreadCount'));
}

public function markAsRead(int $id)
{
    $notification = \App\Models\Notification::findOrFail($id);
    $notification->update(['is_read' => true]);

    return redirect()->route('admin.notifications')
                     ->with('success', 'Notification marked as read.');
}

public function markAllAsRead()
{
    \App\Models\Notification::where('is_read', false)->update(['is_read' => true]);

    return redirect()->route('admin.notifications')
                     ->with('success', 'All notifications marked as read.');
}

// --- Charities CRUD ---
public function charities()
{
    $charities = \App\Models\Charity::with('manager')->latest()->paginate(10);
    return view('admin.charities.index', compact('charities'));
}

public function createCharity()
{
    // Fetch all users with Manager role
    $managers = \App\Models\User::role('Manager')->get();

    return view('admin.charities.create', compact('managers'));
}

public function storeCharity(Request $request)
{
    $validated = $request->validate([
        'name'               => 'required|string|max:255',
        'description'        => 'required|string',
        'registration_number'=> 'required|string|max:50|unique:charities,registration_number',
        'manager_id'         => 'required|exists:users,id',
    ]);

    \App\Models\Charity::create($validated);

    return redirect()->route('admin.charities.index')
                     ->with('success', 'Charity created successfully.');
}

public function editCharity(\App\Models\Charity $charity)
{
    $managers = \App\Models\User::role('Manager')->get();

    return view('admin.charities.edit', compact('charity', 'managers'));
}

public function updateCharity(Request $request, \App\Models\Charity $charity)
{
    $validated = $request->validate([
        'name'               => 'required|string|max:255',
        'description'        => 'required|string',
        'registration_number'=> 'required|string|max:50|unique:charities,registration_number,' . $charity->id,
        'manager_id'         => 'required|exists:users,id',
    ]);

    $charity->update($validated);

    return redirect()->route('admin.charities.index')
                     ->with('success', 'Charity updated successfully.');
}

public function destroyCharity(\App\Models\Charity $charity)
{
    $charity->delete();

    return redirect()->route('admin.charities.index')
                     ->with('success', 'Charity deleted successfully.');
}


}















