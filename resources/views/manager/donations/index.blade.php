@extends('layouts.app')

@section('header')
    <h1 class="text-2xl font-bold text-indigo-400">All Donations</h1>
@endsection

@section('content')
<div class="container-fluid">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="mb-3">
        <a href="{{ route('manager.donations.create') }}" class="btn btn-primary">+ Add Donation</a>
    </div>

    <div class="card bg-dark text-light mb-4">
        <div class="card-body">
            <table class="table table-dark table-striped">
                <thead>
                    <tr>
                        <th>Donor</th>
                        <th>Campaign</th>
                        <th>Amount</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($donations as $donation)
                        <tr>
                            <td>{{ $donation->donor->name ?? 'N/A' }}</td>
                            <td>{{ $donation->campaign->title ?? 'N/A' }}</td>
                            <td>{{ $donation->amount }}</td>
                            <td>{{ $donation->created_at->format('Y-m-d') }}</td>
                            <td>
                                <a href="{{ route('manager.donations.edit', $donation->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('manager.donations.destroy', $donation->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Delete this donation?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $donations->links() }}
        </div>
    </div>
</div>
@endsection

