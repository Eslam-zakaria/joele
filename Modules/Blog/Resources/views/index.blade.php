@extends('admin.layout.base')

@section('title', 'Blogs')

@section('content')
    <div class="container-fluid">
        @include('admin.layout.alerts')
        <blogs-list></blogs-list>
    </div>
@endsection
