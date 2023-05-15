@extends('admin.layout.base')

@section('title', 'Frequently Asked Questions')

@section('content')
    <div class="container-fluid">
        @include('admin.layout.alerts')
        <frequently-questions-list></frequently-questions-list>
    </div>
@endsection
