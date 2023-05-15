@extends('admin.layout.base')

@section('title')
    Insurance Companies
@endsection

@section('content')
    <div class="container-fluid">
        @include('admin.layout.alerts')
        <insurances-list></insurances-list>
    </div>
@endsection
