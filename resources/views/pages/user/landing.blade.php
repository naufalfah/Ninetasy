@extends('layouts.master')
@section('content')
    <h1>Landing</h1>
    <ul>
        <li><a href="{{ route('user.transaksi.index') }}">Transaksi</a></li>
    </ul>

    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit">Logout</button>
    </form>
@endsection