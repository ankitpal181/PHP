@extends('menu::layouts.master')

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
    <form id="order-form" action="{{ route('store_order') }}" method="POST">
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
            @php
                $count = 0;
            @endphp
            @foreach($menu as $category => $items)
                @php
                    $count += 1;
                @endphp
                <div class="col-md-3">
                    <div class="card category">
                        <p class="category-heading">{{ $category }}</p>

                        <input type="text" class="filter-menu-field" id="filter-menu-{{ $category }}" placeholder="Search..." onkeyup="filterItems('{{ $category }}')">
                        <ul class="item-list" id="item-list-{{ $category }}">
                            @foreach($items as $item)
                                <li class="item-details">
                                    @if($item->available)
                                        <div id="delete-fields-{{ $item->id }}">
                                    @else
                                        <div>
                                    @endif
                                        <input type="checkbox" id="delete-checkbox" class="hidden-checkbox" name="ids[]" value="{{ $item->id }}">
                                        @if($item->available)
                                            <p class="item-name">{{ $item->item }}<span class="item-price" id="item-price">{{ $item->price }}</span></p>
                                        @else
                                            <p class="item-name item-not-available">{{ $item->item }}<span class="item-price item-not-available" id="item-price">{{ $item->price }}</span></p>
                                        @endif
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                @if($count == 4)
                    </div>
                    <div class="row">
                    @php
                        $count = 0;
                    @endphp
                @endif
            @endforeach
        </div>
    </form>
    <div class="temp-cart-details">
        <div class="row">
            <div class="col-md-12">
                <ul id="item-quantity-list" class="item-list item-quantity-list">
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <p class="total-amount-container">Total Amount: <span id="total-amount" class="total-amount">0</span></p>
            </div>
        </div>
    </div>
@endsection
