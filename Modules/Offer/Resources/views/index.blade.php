@extends('admin.layout.base')

@section('title', 'Offers')

@section('content')
    <div class="container-fluid">
        @include('admin.layout.alerts')
        <offers-list></offers-list>
    </div>
@endsection
