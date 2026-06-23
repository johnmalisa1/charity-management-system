<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Participation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class VolunteerController extends Controller
{
    // Dashboard
    public function index()
    {
        $user = Auth::user();

        // Statistics
        $eventsJoined        = $user->joinedEvents()->count();
        $upcomingEvents      = $user->joinedEvents()->where('start_time', '>=', now())->count();
        $volunteerHours      = $user->participations()->sum('hours');
        $completedActivities = $user->activities()->where('status', 'completed')->count();

        // Previews
        $availableEvents     = Event::where('start_time', '>=', now())->orderBy('start_time')->take(3)->get();
        $joinedEvents        = $user->joinedEvents()->where('start_time', '>=', now())->take(3)->get();
        $assignedActivities  = $user->activities()->latest()->take(5)->get();
        $history             = $user->participations()->latest()->take(5)->get();
        $notifications       = $user->notifications()->latest()->take(5)->get();

        // Chart data: group participations by month
        $participationsByMonth = $user->participations()
            ->selectRaw('MONTH(date) as month, COUNT(*) as count')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month');

        $months = [];
        $eventsData = [];
        foreach (range(1, 12) as $m) {
            $months[] = date('M', mktime(0, 0, 0, $m, 1));
            $eventsData[] = $participationsByMonth[$m] ?? 0;
        }

        return view('dashboards.volunteer', compact(
            'user',
            'eventsJoined',
            'upcomingEvents',
            'volunteerHours',
            'completedActivities',
            'availableEvents',
            'joinedEvents',
            'assignedActivities',
            'history',
            'notifications',
            'months',
            'eventsData'
        ));
    }

    // Show all events
    public function events()
    {
        $events = Event::with('galleries', 'volunteers') // ✅ eager-load galleries & volunteers
                       ->where('start_time', '>=', now())
                       ->orderBy('start_time')
                       ->paginate(10);

        return view('volunteer.events.index', compact('events'));
    }

    // ✅ Show single event detail
    public function showEvent(Event $event)
    {
        $event->load('galleries', 'volunteers');
        return view('volunteer.events.show', compact('event'));
    }

    // Show participation history
    public function history()
    {
        $user = Auth::user();
        $history = $user->participations()->latest()->paginate(10);

        return view('volunteer.history.index', compact('history'));
    }

    // Show notifications
    public function notifications()
    {
        $user = Auth::user();
        $notifications = $user->notifications()->latest()->paginate(10);

        return view('volunteer.notifications.index', compact('notifications'));
    }

    // Show profile
    public function profile()
    {
        $user = Auth::user();
        return view('volunteer.profile.index', compact('user'));
    }

    // Update profile
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'photo' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('photos', 'public');
        }

        $user->update($data);

        return redirect()->route('volunteer.profile')->with('success', 'Profile updated successfully.');
    }

    // ✅ Join an event via pivot table
    public function joinEvent(Event $event)
    {
        $user = Auth::user();

        if (!$event->volunteers()->where('user_id', $user->id)->exists()) {
            $event->volunteers()->attach($user->id);
        }

        Participation::updateOrCreate(
            ['user_id' => $user->id, 'event_id' => $event->id],
            [
                'status' => 'joined',
                'date'   => now(),
                'hours'  => 0,
            ]
        );

        return redirect()->route('volunteer.events.index')->with('success', 'You have joined the event successfully.');
    }

    // ✅ Cancel participation via pivot table
    public function cancelEvent(Event $event)
    {
        $user = Auth::user();

        $event->volunteers()->detach($user->id);

        Participation::where('user_id', $user->id)
            ->where('event_id', $event->id)
            ->update(['status' => 'cancelled']);

        return redirect()->route('volunteer.events.index')->with('success', 'You have cancelled your participation.');
    }
}






