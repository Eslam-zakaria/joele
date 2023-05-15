@extends('admin.layout.base')

@section('title', 'Branches')

@section('content')
    <div class="container-fluid">
        @include('admin.layout.alerts')
        <branches-list></branches-list>
    </div>
@endsection
