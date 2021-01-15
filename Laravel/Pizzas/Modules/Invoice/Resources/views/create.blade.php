@extends('invoice::layouts.master')

@section('content')
@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
    <div class="row">
        <div class="col-md-12">
            <form action="{{ route('store_invoice', ['order_id' => $order->id]) }}" method="POST">
                @csrf
                <label>CUSTOMER NAME</label>
                <input type="text" name="customer_name" placeholder="Customer Name">
                <label>CUSTOMER NUMBER</label>
                <input type="text" name="customer_number" placeholder="Customer Number">
                <label>ORDER TYPE</label>
                <input type="radio" name="order_type">
                <label>Having</label>
                <input type="radio" name="order_type">
                <label>Take Away</label>
                <input type="radio" name="order_type">
                <label>Delivery</label>
                <label>PAYMENT METHOD</label>
                <input type="radio" class="payment_method" name="payment_method" value="card">
                <label>Card</label>
                <input type="radio" class="payment_method" name="payment_method" value="wallet">
                <label>Wallet</label>
                <input type="radio" class="payment_method" name="payment_method" value="upi">
                <label>UPI</label>
                <input type="radio" class="payment_method" name="payment_method" value="others">
                <label>Others</label>
                <select id="mode_of_payment" name="mode_of_payment">
                    <option>Select Payment Method</option>
                </select>
                <button type="submit" class="btn btn-success">Create</button>
            </form>
        </div>
    </div>
@endsection
