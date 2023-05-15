@extends('admin.layout.base')

@section('title', 'Subscription form')

@section('content')
    <div class="container-fluid">
        @include('admin.layout.alerts')
        <subscription-form></subscription-form>
    </div>
@endsection
