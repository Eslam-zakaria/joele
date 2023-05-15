@extends('admin.layout.base')

@section('title', 'Review questions')

@section('content')
    <div class="container-fluid">
        @include('admin.layout.alerts')
        <question-list></question-list>
    </div>
@endsection
