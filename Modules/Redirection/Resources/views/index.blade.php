@extends('admin.layout.base')

@section('title', 'Redirections')

@section('content')
    <div class="container-fluid">
        @include('admin.layout.alerts')
        <redirection-list></redirection-list>
    </div>
@endsection
