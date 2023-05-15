@extends('admin.layout.base')

@section('title', 'Frequently Asked Question category')

@section('content')
    <div class="container-fluid">
        @include('admin.layout.alerts')
        <frequently-asked-question-category-list></frequently-asked-question-category-list>
    </div>
@endsection
