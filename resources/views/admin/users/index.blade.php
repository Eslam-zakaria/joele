@extends('admin.layout.base')

@section('title', 'Users')

@section('content')
    <div class="container-fluid">
        @include('admin.layout.alerts')
        <users-list></users-list>
    </div>
@stop
