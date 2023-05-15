@extends('frontend.layouts.master')

@section('meta')
    {!! $settings['about_us_page_seo'][app()->getLocale() == 'en'  ?  'en' : 'ar'] ?? '' !!}
@stop

@push('styles')
    <link rel="stylesheet" href="{{ asset('frontend/css/about' . ( app()->getLocale() == 'en' ? '.min.css' : '-rtl.min.css' ) ) }}" crossorigin="anonymous">
@endpush

@section('title', __('system.our_story'))

@push('lang')
    @include('frontend.components.lang_url.lang', ['path' => '/about-us'])
@endpush

@section('schema_code')
{!! $settings['about_us_page_schema'] ?? '' !!}
@stop

@section('content')
    <!-- BEGIN :: page header -->
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
                <h2 data-aos="fade-up">@lang('system.our_story')</h2>
                <!-- breadcrumb -->
                <nav aria-label="breadcrumb" data-aos="fade-up" data-aos-delay="50">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('web.home.index') }}">@lang('system.home')</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('system.our_story')</li>
                    </ol>
                </nav>
                <!-- // breadcrumb -->
            </div>
        </div>
    </div>
    <!-- END :: page header -->

    <!-- BEGIN :: page content -->
    <div class="wrapper">
        <section class="about d-pad">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 d-flex align-items-center">
                        <div class="about__text">
                            <!-- title -->
                            <div class="section-title" data-aos="fade-up">
                                <h2>{{ $settings['about_us_page_title'][app()->getLocale() == 'en'  ?  'en' : 'ar'] ?? '' }}</h2>
                            </div>
                            <!-- // title -->
                            <p data-aos="fade-up">{!! $settings['about_us_page_content'][app()->getLocale() == 'en'  ?  'en' : 'ar'] ?? '' !!}</p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="about__image" data-aos="zoom-out">
                            <picture>
                                <source srcset="{{ $settings['home_about_image'] ?? asset('frontend/images/about.webp') }}" type="image/webp">
                                <img loading="lazy" src="{{ $settings['home_about_image'] ?? asset('frontend/images/about.jpg') }}" alt="@lang('system.our_story')">
                            </picture>
                        </div>
                    </div>
                    <!-- vision -->
                    <div class="col-lg-6">
                        <div class="about__block" data-aos="fade-up">
                            <div class="about__block-image" data-aos="zoom-out">
                                <picture>
                                    <source srcset="{{ asset('frontend/images/vision_brand.png') }}" type="image/webp">
                                    <img src="{{ asset('frontend/images/vision_brand.png') }}" draggable="false" alt="@lang('our_vision')">
                                </picture>
                            </div>
                            <div class="about__block-text">
                                <h3 class="h4">@lang('system.our_vision')</h3>
                                <p>{{ $settings['vision'][app()->getLocale() == 'en'  ?  'en' : 'ar'] ?? '' }}</p>
                            </div>
                        </div>
                    </div>
                    <!-- // vision -->
                    <!-- message -->
                    <div class="col-lg-6">
                        <div class="about__block" data-aos="fade-up">
                            <div class="about__block-image" data-aos="zoom-out">
                                <picture>
                                    <source srcset="{{ asset('frontend/images/mission_brand.png') }}" type="image/webp">
                                    <img src="{{ asset('frontend/images/mission_brand.png') }}" draggable="false" alt="message">
                                </picture>
                            </div>
                            <div class="about__block-text">
                                <h3 class="h4">@lang('system.our_message')</h3>
                                <p>{{ $settings['message'][app()->getLocale() == 'en'  ?  'en' : 'ar'] ?? '' }}</p>
                            </div>
                        </div>
                    </div>
                    <!-- // message -->
                </div>
            </div>
        </section>
        <!-- cards hero -->
        <section class="hero">
            <div class="container">
                <div class="row">
                    <!-- cards -->
                    <div class="about__cards about__cards_brand m-0">
                        <div class="d-flex justify-content-center flex-wrap gap-4">
                            <!-- card -->
                            <div class="card d-flex flex-row align-items-center justify-content-between gap-4" data-aos="fade-up">
                                <div class="about__card-text d-flex flex-column">
                                    <span class="h1 d-flex">{{ number_format(\DB::table('services')->count()) }}</span>
                                    <span class="about__card-title d-flex">@lang('system.services')</span>
                                </div>
                                <div class="about__card-icon">
                                    <picture>
                                        <source srcset="{{ asset('frontend/images/icons/icons.svg#services') }}" type="image/webp">
                                        <img class="icon" src="{{ asset('frontend/images/icons/icons.svg#services') }}" alt="services">
                                    </picture>
                                </div>
                            </div>
                            <!-- // card -->
                            <!-- card -->
                            <div class="card d-flex flex-row align-items-center justify-content-between gap-4" data-aos="fade-up">
                                <div class="about__card-text d-flex flex-column">
                                    <span class="h1 d-flex">{{ number_format(\DB::table('doctors')->count()) }}</span>
                                    <span class="about__card-title d-flex">@lang('system.doctors')</span>
                                </div>
                                <div class="about__card-icon">
                                    <picture>
                                        <source srcset="{{ asset('frontend/images/icons/icons.svg#doctors') }}" type="image/webp">
                                        <img class="icon" src="{{ asset('frontend/images/icons/icons.svg#doctors') }}" alt="services">
                                    </picture>
                                </div>
                            </div>
                            <!-- // card -->
                            <!-- card -->
                            <div class="card d-flex flex-row align-items-center justify-content-between gap-4" data-aos="fade-up">
                                <div class="about__card-text d-flex flex-column">
                                    <span class="h1 d-flex">{{--{{ number_format(\DB::table('branches')->count()) }}--}} {{ number_format(400000) }}</span>
                                    <span class="about__card-title d-flex">@lang('system.clients')</span>
                                </div>
                                <div class="about__card-icon">
                                    <picture>
                                        <source srcset="{{ asset('frontend/images/icons/icons.svg#clients') }}" type="image/webp">
                                        <img class="icon" src="{{ asset('frontend/images/icons/icons.svg#clients') }}" alt="services">
                                    </picture>
                                </div>
                            </div>
                            <!-- // card -->
                        </div>
                    </div>
                    <!-- // cards -->
                </div>
            </div>
        </section>
        <!-- // cards hero -->
        <section class="services d-pad">
            <div class="container">
                <div class="row">
                    <!-- text -->
                    <div class="col-lg-4">
                        <!-- title -->
                        <div class="section-title" data-aos="fade-up">
                            <h2>{{ $settings['services_page_title'][app()->getLocale() == 'en'  ?  'en' : 'ar'] ?? '' }}</h2>
                        </div>
                        <!-- // title -->
                        <p data-aos="zoom-up" data-aos-delay="50">{{ $settings['services_page_content'][app()->getLocale() == 'en'  ?  'en' : 'ar'] ?? '' }}</p>
                        <div data-aos="fade-up" data-aos-delay="150">
                            <a href="{{ route('web.services.index') }}" class="btn btn-link">
                                @lang('system.services')
                            </a>
                        </div>
                    </div>
                    <!-- // text -->
                    <!-- services slider -->
                    <div class="col-lg-8">
                        <!-- slider -->
                        <div class="services-slider" data-aos="fade-up">
                            <div class="swiper servicesSlider">
                                <div class="swiper-wrapper">
                                    @foreach($services as $service)
                                        <div class="swiper-slide">
                                            <a class="card service__card" href="{{ route('web.services.details', $service->slug) }}">
                                                <div class="service__card-image">
                                                    <picture>
                                                        <source srcset="{{ $service->service_image }}" type="image/webp">
                                                        <img loading="lazy" src="{{ $service->service_image }}" alt="{{ $service->translate(app()->getLocale())->name }}">
                                                    </picture>
                                                </div>
                                                <h3 class="service__card-title h5">{{ $service->translate(app()->getLocale())->name }}</h3>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="swiper-pagination"></div>
                                <div class="slider-controls">
                                    <div class="swiper-button-next services-next"></div>
                                    <div class="swiper-button-prev services-prev"></div>
                                </div>
                            </div>
                        </div>
                        <!-- // slider -->
                    </div>
                    <!-- // services slider -->
                </div>
            </div>
        </section>
    </div>
    <!-- END :: page content -->
@stop
