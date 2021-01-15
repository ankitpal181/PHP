@extends('dashboard::layouts.master')

@section('sidetab')
    <nav class="links">
        <a href="/menu"><p>Menu</p></a>
        <a href="/order"><p>Orders</p></a>
        <a href="/invoice"><p>Invoice</p></a>
    </nav>
@endsection

@section('content')
    <p>Welcome User</p>
@endsection
