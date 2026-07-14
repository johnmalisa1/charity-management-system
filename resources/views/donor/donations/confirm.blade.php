@extends('layouts.app')

@section('header')
    <h1 class="text-2xl font-bold text-indigo-400">Confirm Donation</h1>
@endsection

@section('content')
<div class="container py-8">
    <p>You are donating <strong>{{ number_format($amount, 0) }} TZS</strong> to <strong>{{ $campaign->title }}</strong>.</p>

    <form action="{{ route('donor.donations.store') }}" method="POST">
        @csrf
        <input type="hidden" name="campaign_id" value="{{ $campaign->id }}">
        <input type="hidden" name="amount" value="{{ $amount }}">

        <!-- Payment Method -->
        <div class="form-group mt-3">
            <label for="payment_method" class="text-gray-300">Payment Method</label>
            <select id="payment_method" name="payment_method" class="form-control" required>
                <option value="">Choose a payment method</option>
                <option value="mpesa">M-PESA</option>
                <option value="mixx_by_yas">MIXX BY YAS</option>
                <option value="halopesa">HaloPesa</option>
                <option value="airtel_money">Airtel Money</option>
                <option value="mastercard">MasterCard</option>
            </select>
        </div>

        <!-- Mobile Number (hidden by default) -->
        <div id="mobile_number_field" class="form-group mt-3" style="display:none;">
            <label for="mobile_number" class="text-gray-300">Mobile Number</label>
            <input type="text" id="mobile_number" name="mobile_number" class="form-control" placeholder="e.g. 255712345678">
        </div>

        <!-- Card Number (hidden by default) -->
        <div id="card_number_field" class="form-group mt-3" style="display:none;">
            <label for="card_number" class="text-gray-300">Card Number</label>
            <input type="text" id="card_number" name="card_number" class="form-control" placeholder="e.g. 4111 1111 1111 1111">
        </div>

        <button type="submit" class="btn btn-success mt-4">Proceed to Payment</button>
    </form>
</div>

<!-- ✅ JavaScript to toggle fields -->
<script>
document.getElementById('payment_method').addEventListener('change', function() {
    let method = this.value;
    let mobileField = document.getElementById('mobile_number_field');
    let cardField = document.getElementById('card_number_field');

    // Hide both initially
    mobileField.style.display = 'none';
    cardField.style.display = 'none';

    if (['mpesa','mixx_by_yas','halopesa','airtel_money'].includes(method)) {
        mobileField.style.display = 'block';
    } else if (method === 'mastercard') {
        cardField.style.display = 'block';
    }
});
</script>
@endsection


