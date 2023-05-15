@extends('admin.layout.base')

@section('title', 'Review')

@section('content')
    <div class="container-fluid">
        @include('admin.layout.alerts')
        <review-list></review-list>
    </div>
@endsection
