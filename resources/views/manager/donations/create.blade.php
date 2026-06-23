@extends('layouts.app')

@section('header')
    <h1 class="text-2xl font-bold text-indigo-400">Add Donation</h1>
@endsection

@section('content')
<div class="container-fluid">
    <div class="card bg-dark text-light">
        <div class="card-body">
            <form action="{{ route('manager.donations.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Donor</label>
                    <select name="donor_id" class="form-control" required>
                        <option value="">-- Select Donor --</option>
                        @foreach($donors as $donor)
                            <option value="{{ $donor->id }}">{{ $donor->name }} ({{ $donor->email }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Campaign</label>
                    <select name="campaign_id" class="form-control" required>
                        <option value="">-- Select Campaign --</option>
                        @foreach($campaigns as $campaign)
                            <option value="{{ $campaign->id }}">{{ $campaign->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Amount</label>
                    <input type="number" name="amount" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-success">Save Donation</button>
            </form>
        </div>
    </div>
</div>
@endsection

