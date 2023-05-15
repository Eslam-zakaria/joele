@extends('admin.layout.base')

@section('title', 'Specialization')

@section('content')
    <div class="container-fluid">
        @include('admin.layout.alerts')
        <specializations-list></specializations-list>
    </div>
@endsection
