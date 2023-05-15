@extends('admin.layout.base')

@section('title', 'Cases')

@section('content')
    <div class="container-fluid">
        @include('admin.layout.alerts')
        <Cases-list></Cases-list>
    </div>
@endsection
