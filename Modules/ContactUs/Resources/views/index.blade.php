@extends('admin.layout.base')

@section('title', 'Contact Us')

@section('content')
    <div class="container-fluid">
        @include('admin.layout.alerts')
        <contact-us></contact-us>
    </div>
@endsection
