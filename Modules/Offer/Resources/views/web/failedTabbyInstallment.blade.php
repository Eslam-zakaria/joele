@extends('frontend.layouts.master')

@section('meta')
    <!-- Meta description for facebook. -->
    <meta property="og:title" content="{{ __('system.thank_you') . ' | ' . ( $settings['website_name'][app()->getLocale() == 'en'  ?  'en' : 'ar'] ?? '' ) }}"/>
    <meta property="og:description" content="{{ $settings['meta_description'][app()->getLocale() == 'en'  ?  'en' : 'ar'] ?? '' }}" />
    <meta property="og:image" content="{{ $settings['website_logo'] ?? '' }}"/>
    <meta property="og:url" content="{{ url()->full() }}"/>

    <!-- Meta description for twitter. -->
    <meta name="twitter:title" content="{{ __('system.thank_you') . ' | ' . ( $settings['website_name'][app()->getLocale() == 'en'  ?  'en' : 'ar'] ?? '' ) }}"/>
    <meta name="twitter:description" content="{{ $settings['meta_description'][app()->getLocale() == 'en'  ?  'en' : 'ar'] ?? '' }}" />
    <meta name="twitter:image" content="{{ $settings['website_logo'] ?? '' }}" />

    <link rel="canonical" href="{{ url()->full() }}" />
    <meta name="keywords" content="{{ $settings['meta_tags'][app()->getLocale() == 'en'  ?  'en' : 'ar'] ?? '' }}"/>
    <meta name="description" content="{{ $settings['meta_description'][app()->getLocale() == 'en'  ?  'en' : 'ar'] ?? '' }}"/>
@stop

@section('title', __('system.thank_you') . ' | ' . ( $settings['website_name'][app()->getLocale() == 'en'  ?  'en' : 'ar'] ?? '' ))

@push('styles')
    <link rel="stylesheet preload" href="{{ asset('frontend/css/' . ( app()->getLocale() == 'en' ? 'book.min.css' : 'book-rtl.min.css' ) ) }}" as="style" crossorigin>
@endpush

@push('lang')
    @include('frontend.components.lang_url.lang', ['path' => '/offers/thanks'])
@endpush

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
                <h2 data-aos="fade-up">@lang('system.thank_you')</h2>
                <!-- breadcrumb -->
                <nav aria-label="breadcrumb" data-aos="fade-up" data-aos-delay="50">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('web.home.index') }}">@lang('system.home')</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('system.thank_you')</li>
                    </ol>
                </nav>
                <!-- // breadcrumb -->
            </div>
        </div>
    </div>

    <div class="wrapper">
        <section class="thanks d-pad">
            <div class="container">
                <!-- section title -->
                <div class="section-title text-center" data-aos="fade-up">
                    <h2>@lang('system.thank_you')</h2>
                </div>
                <!-- // section title -->
                <p class="lead" data-aos="fade-up" data-aos-delay="100">
                    <!-- @lang('system.we_have_received_your_order_and_will_get_back_to_you_soon') -->
                    {{ (app()->getLocale() == 'en') ? 'Sorry, Tabby is unable to approve this purchase. Please use an alternative payment method for your order.' : 'نأسف، تابي غير قادرة على الموافقة على هذه العملية. الرجاء استخدام طريقة دفع أخرى'}}
                </p>
                <a href="{{ route('web.home.index') }}" class="btn btn-brand-gradient" data-aos="fade-up" data-aos-delay="100">
                    @lang('system.back_to_home')
                </a>
            </div>
        </section>
    </div>
@stop
