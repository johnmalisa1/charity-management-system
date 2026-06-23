@extends('layouts.app')

@section('header')
    <h1 class="text-2xl font-bold text-indigo-400">Notifications</h1>
@endsection

@section('content')
<div class="container py-8">
    <div class="alert alert-success">✅ Donation confirmed for Education Fund.</div>
    <div class="alert alert-info">📢 New campaign launched: School Supplies.</div>
    <div class="alert alert-warning">⏰ Reminder: Charity Marathon on June 1.</div>
</div>
@endsection
