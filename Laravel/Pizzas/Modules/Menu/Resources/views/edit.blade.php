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
    <form action="{{ route('update_menu') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-md-12">
                <div class="action-button-container">
                    <button class="btn btn-success" type="submit">Save</button>
                    <a href="{{ route('index_menu') }}"><button class="btn btn-danger" type="button">Cancel</button></a>
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
                                    <div class="edit-field-container" id="edit-fields-{{ $item->id }}">
                                        <input type="checkbox" id="edit-checkbox" class="hidden-checkbox" name="ids[]" value="{{ $item->id }}">
                                        <input type="text" class="edit-field item-name" name="names[{{ $item->id }}]" value="{{ $item->item }}">
                                        <input class="edit-field item-price" type="text" name="prices[{{ $item->id }}]" value="{{ $item->price }}">
                                        <input id="item-available" class="edit-field item-available" type="text" name="availables[{{ $item->id }}]" value="{{ $item->available }}">
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
@endsection
