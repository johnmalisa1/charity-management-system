@extends('layouts.app')

@section('title', 'Volunteer Profile')

@section('content')
<div class="max-w-4xl mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6 text-center text-yellow-600">Volunteer Profile</h1>

    <h3 class="mt-4 font-semibold">Campaigns Joined</h3>
    <ul class="list-disc pl-5">
        @forelse($campaigns as $campaign)
            <li>{{ $campaign->title }} ({{ $campaign->status }})</li>
        @empty
            <li>No campaigns joined yet.</li>
        @endforelse
    </ul>
</div>
@endsection
