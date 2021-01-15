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
    <form action="/menu/store" method="GET">
        @csrf
        <div class="row">
            <div class="col-md-12">
                <div class="action-button-container">
                    <button class="btn btn-success" type="submit">Save</button>
                    <a href="/menu"><button class="btn btn-danger" type="button">Cancel</button></a>
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
                                    <div id="delete-fields-{{ $item->id }}">
                                        <input type="checkbox" id="delete-checkbox" class="hidden-checkbox" name="ids[]" value="{{ $item->id }}">
                                        @if($item->available)
                                            <p class="item-name">{{ $item->item }}<span class="item-price">{{ $item->price }}</span></p>
                                        @else
                                            <p class="item-name item-not-available">{{ $item->item }}<span class="item-price item-not-available">{{ $item->price }}</span></p>
                                        @endif
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                        <span class="btn btn-primary add-btn" onclick="addItem('{{ $category }}')">+</span>
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
@endsection
