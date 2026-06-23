@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <h1 class="text-2xl font-bold mb-4">Notifications</h1>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto bg-white dark:bg-gray-800 shadow rounded-lg">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Message</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Action</th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                @forelse($notifications as $notification)
                    <tr>
                        <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">
                            {{ $notification->message }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            {{ $notification->created_at->format('d M Y H:i') }}
                        </td>
                        <td class="px-6 py-4 text-sm">
                            @if($notification->is_read)
                                <span class="text-green-600">Read</span>
                            @else
                                <span class="text-red-600">Unread</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm">
                            @if(!$notification->is_read)
                                <form method="POST" action="{{ route('admin.notifications.markAsRead', $notification->id) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded">
                                        Mark as Read
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                            No notifications found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $notifications->links() }}
    </div>

    <div class="mt-6">
        <form method="POST" action="{{ route('admin.notifications.markAllAsRead') }}">
            @csrf
            @method('PATCH')
            <button class="bg-gray-700 hover:bg-gray-900 text-white px-4 py-2 rounded">
                Mark All as Read
            </button>
        </form>
    </div>
</div>
@endsection

