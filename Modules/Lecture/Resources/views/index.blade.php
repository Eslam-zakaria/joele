@extends('admin.layout.base')

@section('title', 'Lectures')

@section('content')
    <div class="container-fluid">
        @include('admin.layout.alerts')
        <lectures-list></lectures-list>
    </div>
@endsection
