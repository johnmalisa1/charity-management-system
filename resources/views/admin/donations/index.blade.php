@extends('layouts.app')

@section('title', 'Donations Management')

@section('content')
<div class="card bg-dark text-light shadow rounded-lg p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>💰 Donations Management</h2>
        <a href="{{ route('admin.donations.create') }}" class="btn btn-success">➕ Add Donation</a>
    </div>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-dark table-striped table-hover">
        <thead>
            <tr>
                <th>#</th>
                <th>Donor</th>
                <th>Campaign</th>
                <th>Amount</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($donations ?? [] as $donation)
                <tr>
                    <td>{{ $donation->id ?? 'N/A' }}</td>
                    <td>{{ optional($donation->user)->name ?? 'N/A' }}</td>
                    <td>{{ optional($donation->campaign)->title ?? 'N/A' }}</td>
                    <td>${{ number_format($donation->amount, 2) }}</td>
                    <td>{{ optional($donation->created_at)->format('M d, Y') ?? 'N/A' }}</td>
                    <td>
                        <a href="{{ route('admin.donations.edit', $donation->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('admin.donations.destroy', $donation->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"
                                    onclick="return confirm('Are you sure you want to delete this donation?')">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center text-muted">No donations found</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Pagination --}}
    @if(isset($donations))
        <div class="mt-3">
            {{ $donations->links() }}
        </div>
    @endif
</div>
@endsection
