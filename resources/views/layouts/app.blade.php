<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Save for the Kids') }}</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom Dark Theme -->
    <style>
        body { background-color: #121212; color: #e0e0e0; }

        /* Sidebar fixed */
        .sidebar {
            width: 250px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            overflow-y: auto;
            background-color: #1f1f1f;
        }
        .sidebar a, .sidebar button {
            color: #e0e0e0;
            text-decoration: none;
            padding: .5rem 1rem;
            display: block;
            background: none;
            border: none;
            text-align: left;
            width: 100%;
        }
        .sidebar a.active, .sidebar a:hover, .sidebar button:hover {
            background-color: #343a40;
            border-radius: 4px;
            cursor: pointer;
        }

        .navbar-dark { background-color: #1f1f1f; }
        footer { background-color: #1f1f1f; color: #aaa; padding: 1rem; text-align: center; }

        /* Card hover effects */
        .card.bg-dark { transition: all 0.25s ease-in-out; }
        .card.bg-dark:hover {
            background-color: #1c1c1c;
            transform: translateY(-3px);
            cursor: pointer;
        }

        /* KPI-specific glow colors */
        .card-donations:hover { box-shadow: 0 0 15px rgba(79, 70, 229, 0.7); }
        .card-users:hover { box-shadow: 0 0 15px rgba(34, 197, 94, 0.7); }
        .card-campaigns:hover { box-shadow: 0 0 15px rgba(245, 158, 11, 0.7); }
        .card-charities:hover { box-shadow: 0 0 15px rgba(239, 68, 68, 0.7); }
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <!-- Sidebar -->
    <nav class="sidebar p-3">
        <h4 class="text-white mb-4">Save for the Kids</h4>
        <ul class="nav flex-column">
      
            {{-- Admin Sidebar --}}
@role('Admin')
    <li class="nav-item"><a href="{{ route('admin.dashboard') }}" class="nav-link">📊 Dashboard</a></li>
    <li class="nav-item"><a href="{{ route('admin.users.index') }}" class="nav-link">👥 Users</a></li>
    <li class="nav-item"><a href="{{ route('admin.donations.index') }}" class="nav-link">💰 Donations</a></li>
    <li class="nav-item"><a href="{{ route('admin.campaigns.index') }}" class="nav-link">📢 Campaigns</a></li>
    <li class="nav-item"><a href="{{ route('admin.charities.index') }}" class="nav-link">🏥 Charities</a></li>
    <li class="nav-item"><a href="{{ route('admin.events.index') }}" class="nav-link">🎉 Events</a></li>
    <li class="nav-item"><a href="{{ route('admin.volunteers.index') }}" class="nav-link">🤝 Volunteers</a></li>
    <li class="nav-item"><a href="{{ route('admin.reports') }}" class="nav-link">📑 Reports</a></li>
    <li class="nav-item">
    <a href="{{ route('admin.notifications') }}" class="nav-link d-flex align-items-center">
        🔔 Notifications
        @if(isset($unreadCount) && $unreadCount > 0)
            <span class="badge bg-danger ms-2">{{ $unreadCount }}</span>
        @endif
    </a>
</li>

    <li class="nav-item"><a href="{{ route('admin.settings') }}" class="nav-link">⚙️ Settings</a></li>
@endrole


            {{-- Donor Sidebar --}}
            @role('Donor')
                <li class="nav-item"><a href="{{ route('donor.dashboard') }}" class="nav-link">📊 Dashboard</a></li>
                <li class="nav-item"><a href="{{ route('donor.donations') }}" class="nav-link">💰 My Donations</a></li>
                <li class="nav-item"><a href="{{ route('donor.campaigns') }}" class="nav-link">📢 Campaigns</a></li>
                <li class="nav-item"><a href="{{ route('donor.events') }}" class="nav-link">🎉 Events</a></li>
                <li class="nav-item"><a href="{{ route('donor.receipts') }}" class="nav-link">📄 Donation Receipts</a></li>
                <li class="nav-item"><a href="{{ route('donor.notifications') }}" class="nav-link">🔔 Notifications</a></li>
                <li class="nav-item"><a href="{{ route('donor.profile') }}" class="nav-link">👤 Profile Settings</a></li>
            @endrole

           {{-- Manager Sidebar --}}
@role('Manager')
    <li class="nav-item"><a href="{{ route('manager.dashboard') }}" class="nav-link">📊 Dashboard</a></li>
    <li class="nav-item"><a href="{{ route('manager.campaigns') }}" class="nav-link">📢 Campaigns</a></li>
    <li class="nav-item"><a href="{{ route('manager.donations') }}" class="nav-link">💰 Donations</a></li>
    <li class="nav-item"><a href="{{ route('manager.events') }}" class="nav-link">🎉 Events</a></li>
    <li class="nav-item"><a href="{{ route('manager.volunteers') }}" class="nav-link">🤝 Volunteers</a></li>
    <li class="nav-item"><a href="{{ route('manager.participants') }}" class="nav-link">👥 Participants</a></li>
    <li class="nav-item"><a href="{{ route('manager.reports') }}" class="nav-link">📑 Reports</a></li>
    <li class="nav-item"><a href="{{ route('manager.notifications') }}" class="nav-link">🔔 Notifications</a></li>
    <li class="nav-item"><a href="{{ route('manager.gallery') }}" class="nav-link">🖼️ Gallery</a></li>
    <li class="nav-item">
    <a href="{{ route('manager.feedback.index') }}" class="nav-link">💬 Feedback</a></li>
    <li class="nav-item"><a href="{{ route('manager.profile') }}" class="nav-link">👤 Profile Settings</a></li>
@endrole


            {{-- Volunteer Sidebar --}}
@role('Volunteer')
    <li class="nav-item"><a href="{{ route('volunteer.dashboard') }}" class="nav-link">📊 Dashboard</a></li>
    <li class="nav-item"><a href="{{ route('volunteer.events.index') }}" class="nav-link">🎉 Events</a></li> <!-- fixed -->
    <li class="nav-item"><a href="{{ route('volunteer.history') }}" class="nav-link">📄 Participation History</a></li>
    <li class="nav-item"><a href="{{ route('volunteer.notifications') }}" class="nav-link">🔔 Notifications</a></li>
    <li class="nav-item"><a href="{{ route('volunteer.profile') }}" class="nav-link">👤 Profile Settings</a></li>
@endrole




            {{-- Logout (visible to all) --}}
            <li class="nav-item">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="nav-link">🚪 Logout</button>
                </form>
            </li>
        </ul>
    </nav>

    <!-- Main Content -->
    <div class="flex-grow-1 d-flex flex-column" style="margin-left: 250px;">
        <!-- Top Navbar -->
        <nav class="navbar navbar-dark px-3 mb-4 d-flex justify-content-between align-items-center" style="background-color:#1f1f1f;">
            <!-- Left: Search -->
            <form class="d-flex" role="search">
                <input class="form-control me-2 bg-dark text-light border-0" type="search" placeholder="Search..." aria-label="Search">
                <button class="btn btn-outline-light" type="submit">Search</button>
            </form>

            <!-- Right: Notifications + Profile -->
            <div class="d-flex align-items-center">
                <!-- Notification Bell -->
                <a class="nav-link text-light me-3 position-relative" href="{{ route('admin.notifications') }}">
    <i class="bi bi-bell"></i>
    @if(isset($unreadCount) && $unreadCount > 0)
        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
            {{ $unreadCount }}
        </span>
    @endif
</a>


                <!-- Profile Dropdown -->
                <div class="dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center text-light" href="#" 
                       id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="{{ Auth::user()->photo_url }}" class="rounded-circle me-2" width="32" height="32" alt="Profile Photo">
                        {{ Auth::user()->name }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-dark" aria-labelledby="profileDropdown">
                        <li><a class="dropdown-item" href="{{ route('donor.profile') }}">Profile Settings</a></li>
                        <li><a class="dropdown-item" href="#">Settings</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item">Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Page Heading -->
        @yield('header')

        <!-- Page Content -->
        <main class="flex-grow-1 p-4">
            @yield('content')
        </main>

        <!-- Footer -->
        <footer>
            Save for the Kids Charity Management System © {{ date('Y') }}
        </footer>
    </div>

    <!-- Bootstrap JS + Icons -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    @stack('scripts')
</body>
</html>
