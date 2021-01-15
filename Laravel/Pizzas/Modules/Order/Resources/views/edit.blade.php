@extends('order::layouts.master')

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
    <form action="{{ route('update_order', ['id' => $order->id]) }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-md-12">
                <div class="action-button-container">
                    <button class="btn btn-success" type="submit">Save</button>
                    <a href="{{ route('index_order') }}"><button class="btn btn-danger" type="button">Cancel</button></a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="order-wrapper order-details-wrapper">
                    <p class="order-details">Customer Name: <span>{{ $order->customer_name }}</span></p>
                    <p class="order-details">Customer Number: <span>{{ $order->customer_number }}</span></p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-striped table-sm table-responsive order-wrapper">
                    <thead>
                        <tr>
                            <th>NAME</th>
                            <th>PRICE</th>
                            <th>QUANTITY</th>
                            <th>ORDER AMOUNT</th>
                            <th>DELETE</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(json_decode($order->item_details) as $index => $item)
                            <tr>
                                <td style="text-align: right;">
                                    {{ $item->name }}
                                </td>
                                <td id="edit-item-price" style="text-align: right;">
                                    {{ json_decode($invoice->item_amount)[$index]->price }}
                                </td>
                                <td>
                                    <input style="text-align: right;" type="text" value="{{ $item->quantity }}" name="quantity[{{ str_replace(' ', '', $item->name) }}]" class="edit-item-quantity">
                                </td>
                                <td id="edit-item-order-amount" style="text-align: right;">
                                    {{ json_decode($invoice->item_amount)[$index]->amount }}
                                </td>
                                <td style="text-align: center;">
                                    <input type="checkbox" id="delete-item-checkbox" name="deleted_items[{{ str_replace(' ', '', $item->name) }}]" value="true" style="display: none;">
                                    <span class="far fa-times-circle delete-item-button"></span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td id="edit-order-amount" style="text-align: right;">{{ $invoice->order_amount }}</td>
                        <td></td>
                    </tfoot>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="order-wrapper">
                    <table class="table table-sm float-right">
                        <tr>
                            <th>Discount</th>
                            <td id="edit-discount-rate">(0%)</td>
                            <td id="edit-discount" style="text-align: right;">{{ $invoice->discount }}</td>
                        </tr>
                        <tr>
                            <th>Tax</th>
                            <td id="edit-tax-rate">(18%)</td>
                            <td id="edit-tax" style="text-align: right;">{{ $invoice->tax }}</td>
                        </tr>
                        <tr>
                            <th>Total Amount</th>
                            <td></td>
                            <td id="edit-total-amount" style="text-align: right;">{{ $invoice->total_amount }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12"></div>
        </div>
    </form>
@endsection
