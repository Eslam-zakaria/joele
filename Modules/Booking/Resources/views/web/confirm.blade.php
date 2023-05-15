@extends('frontend.layouts.master')

@section('meta')
    <!-- Meta description for facebook. -->
    <meta property="og:title" content="{{ __('system.Thank you') . ' | ' . $settings['website_name'][app()->getLocale()] ?? '' }}"/>
    <meta property="og:description" content="{{ $settings['meta_description'][app()->getLocale()] ?? '' }}" />
    <meta property="og:image" content="{{ $settings['website_logo'] ?? '' }}"/>
    <meta property="og:url" content="{{ url()->full() }}"/>

    <!-- Meta description for twitter. -->
    <meta name="twitter:title" content="{{ __('messages.Thank you') . ' | ' . $settings['website_name'][app()->getLocale()] ?? '' }}"/>
    <meta name="twitter:description" content="{{ $settings['meta_description'][app()->getLocale()] ?? '' }}" />
    <meta name="twitter:image" content="{{ $settings['website_logo'] ?? '' }}" />

    <link rel="canonical" href="{{ url()->full() }}" />
    <meta name="keywords" content="{{ $settings['meta_tags'][app()->getLocale()] ?? '' }}"/>
    <meta name="description" content="{{ $settings['meta_description'][app()->getLocale()] ?? '' }}"/>
@stop

@section('title', __('messages.Thank you') . ' | ' . ( $settings['website_name'][app()->getLocale()] ?? '' ))

@push('styles')
    <link rel="stylesheet" href="{{ asset('frontend/css/thanks' . ( app()->getLocale() == 'ar' ? '-rtl.min.css' : '.min.css') ) }}" crossorigin="anonymous">
@endpush

@section('content')
    <!-- page header -->
    <div class="page-header">
        <div class="container">
            <!-- image -->
            <div class="page-header__image">
                <picture>
                    <source srcset="{{ asset('frontend/images/page-header.webp') }}" type="image/webp"><img src="{{ asset('frontend/images/page-header.png') }}" draggable="false"
                        alt="image" data-aos="zoom-out">
                </picture>
            </div>
            <!-- // image -->
            <!-- title -->
            <h2 class="h3" data-aos="fade-up" data-aos-delay="100">
            @lang('messages.Thank you')
            </h2>
            <!-- // title -->
        </div>
    </div>
    <!-- // page header -->


    <!-- page content -->
    <div class="page-content thanks brd-top-rad">
        <div class="container">
            <!-- title -->
            <div class="section-title">
                <h2 class="title" data-aos="fade-up">
                @lang('messages.Thank you')
                </h2>
                <p class="lead" data-aos="fade-up" data-aos-delay="100">
                @lang('messages.thank_you_message')
                </p>
            </div>
            <!-- // title -->
        </div>
    </div>
    <!-- // page content -->


    <!-- book now -->
    <section class="book-now d-pad brd-top-rad" style="background-image: url('{{ asset('frontend/images/book-now.jpg') }}')">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 d-flex align-items-center">
                    <h2 class="h3" data-aos="fade-up">
                        @lang('messages.book_your_appointment_now') <br>
                        @lang('messages.enjoy_unique_treatment_experience')
                    </h2>
                </div>
                <div class="col-lg-6 d-flex align-items-center justify-content-lg-end">
                    <a href="{{ route('web.booking.index', (app()->getLocale() == 'en' ? ['lang' => app()->getLocale()] : '')) }}" class="btn btn-white" data-aos="fade-up">
                        @lang('messages.book_your_appointment_now')
                    </a>
                </div>
            </div>
        </div>
    </section>
    <!-- // book now -->
@stop
