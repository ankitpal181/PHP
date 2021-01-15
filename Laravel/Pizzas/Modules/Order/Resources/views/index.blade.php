@extends('order::layouts.master')

@section('content')
    @foreach($orders as $order)
        <div class="row">
            <div class="col-md-12">
                <div class="card order-wrapper">
                    <div class="order-details-wrapper">
                        <p class="float-left order-details">Order No: <span>{{ $order->id }}</span></p>
                        <p class="float-right order-details">Total Amount: <span>{{ "$order->amount" }}</span></p>
                    </div>
                    <ul id="item-list" class="item-list">
                        @foreach(json_decode($order->item_details) as $item)
                            <li class="item-details">
                                <p class="item-name">{{ $item->name }}<span class="item-count">x{{ $item->quantity }}</span></p>
                            </li>
                        @endforeach
                    </ul>
                    <div id="drop-menu-icon">
                        <p class="fas fa-angle-down drop-menu-icon"></p>
                    </div>
                    <div class="order-details-wrapper">
                        <small class="float-left order-details">Customer Name: <span>{{ $order->customer_name }}</span></small>
                        <small class="float-right order-details">Customer Number: <span>{{ $order->customer_number }}</span></small>
                    </div>
                    <div class="order-button-wrapper">
                        <a class="order-button" href="{{ route('complete_order', ['id' => $order->id]) }}"><button class="btn btn-basic" type="button">Complete</button></a>
                        <a class="order-button" href="{{ route('edit_order', ['id' => $order->id]) }}"><button class="btn btn-basic" type="button">Edit</button></a>
                        <a class="order-button" href="{{ route('destroy_order', ['id' => $order->id]) }}"><button class="btn btn-basic" type="button">Cancel</button></a>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    <div class="row">
        <div class="col-md-12">
            <a class="card order-wrapper place-order-wrapper" href="{{ route('create_order') }}">
                <button class="btn btn-light place-order-button" type="submit">
                    <p class="place-order-para">Place Order</p>
                    <i class="fas fa-plus"></i>
                </button>
            </a>
        </div>
    </div>
@endsection
