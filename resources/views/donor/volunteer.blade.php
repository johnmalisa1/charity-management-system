@extends('layouts.app')

@section('header')
    <h1 class="text-2xl font-bold text-indigo-400">Volunteer Activities</h1>
@endsection

@section('content')
<div class="container py-8">
    <h5 class="mb-4">Your Volunteer Activities</h5>

    <!-- Filters -->
    <form method="GET" action="{{ route('donor.volunteer') }}" class="mb-4 row g-3">
        <div class="col-md-4">
            <input type="text" name="activity_name" value="{{ request('activity_name') }}"
                   class="form-control" placeholder="Search by activity name">
        </div>
        <div class="col-md-3">
            <input type="date" name="from_date" value="{{ request('from_date') }}"
                   class="form-control">
        </div>
        <div class="col-md-3">
            <input type="date" name="to_date" value="{{ request('to_date') }}"
                   class="form-control">
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-outline-light w-100">Filter</button>
        </div>
    </form>

    <!-- Activities Table -->
    @if($activities->isEmpty())
        <p>No volunteer activities found.</p>
    @else
        <table class="table table-dark table-striped">
            <thead>
                <tr>
                    <th>Activity</th>
                    <th>Date</th>
                    <th>Description</th>
                </tr>
            </thead>
            <tbody>
                @foreach($activities as $activity)
                    <tr>
                        <td>{{ $activity->activity_name }}</td>
                        <td>{{ $activity->date?->format('Y-m-d') }}</td>
                        <td>{{ $activity->description }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="mt-3">
            {{ $activities->links() }}
        </div>
    @endif
</div>
@endsection

