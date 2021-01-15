@extends('menu::layouts.master')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="action-button-container">
                <a href="{{ route('edit_menu') }}"><button class="btn btn-primary" type="button">Edit</button></a>
                <a href="{{ route('create_menu') }}"><button class="btn btn-primary" type="button">Add/Delete</button></a>
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
                                    <p class="item-name">{{ $item->item }}<span class="item-price">{{ $item->price }}</span></p>
                                @else
                                    <p class="item-name item-not-available">{{ $item->item }}<span class="item-price item-not-available">{{ $item->price }}</span></p>
                                @endif
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
@endsection
