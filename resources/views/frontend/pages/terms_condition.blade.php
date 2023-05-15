@extends('frontend.layouts.master')

@section('meta')
    {!! $settings['terms_conditions_seo'][app()->getLocale() == 'en'  ?  'en' : 'ar'] ?? '' !!}
@stop

@push('styles')
    <link rel="stylesheet" href="{{ asset('frontend/css/terms' . ( app()->getLocale() == 'en' ? '.min.css' : '-rtl.min.css' ) ) }}" crossorigin="anonymous">
@endpush

@section('title', __('system.terms_conditions'))

@push('lang')
    @include('frontend.components.lang_url.lang', ['path' => '/terms-condition'])
@endpush

@section('schema_code')
{!! $settings['terms_page_schema'] ?? '' !!}
@stop

@section('content')
    <div class="page-header">
        <!-- image -->
        <div class="page-header__image" data-aos="zoom-out">
            <picture>
                <source srcset="{{ asset('frontend/images/page-header.webp') }}" type="image/webp">
                <img src="{{ asset('frontend/images/page-header.jpg') }}" draggable="false" alt="page header">
            </picture>
        </div>
        <!-- // image -->
        <div class="page-header__text">
            <div class="container">
                <h2 data-aos="fade-up">@lang('system.terms_conditions')</h2>
                <!-- breadcrumb -->
                <nav aria-label="breadcrumb" data-aos="fade-up" data-aos-delay="50">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">@lang('system.home')</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('system.terms_conditions')</li>
                    </ol>
                </nav>
                <!-- // breadcrumb -->
            </div>
        </div>
    </div>

    <div class="wrapper">
        <section class="terms d-pad">
            <div class="container">
                <!-- title -->
                <div class="section-title" data-aos="fade-up">
                    <h2>@lang('system.terms_conditions')</h2>
                </div>
                <!-- // title -->
                <div class="terms__container">{!! $settings['terms_conditions_page_content'][app()->getLocale() == 'en'  ?  'en' : 'ar'] ?? '' !!}</div>
            </div>
        </section>
    </div>
@endsection
