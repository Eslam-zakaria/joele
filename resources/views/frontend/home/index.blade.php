@extends('frontend.layouts.master')

@section('meta')
    {!! $settings['home_page_seo'][app()->getLocale() == 'en'  ?  'en' : 'ar'] ?? '' !!}
@stop

@push('styles')
    <link rel="stylesheet" href="{{ asset('frontend/css/' . ( app()->getLocale() == 'en' ? 'home.min.css' : 'home-rtl.min.css' ) ) }}" crossorigin="anonymous">
@endpush

@section('title', $settings['website_name'][app()->getLocale() == 'en'  ?  'en' : 'ar'] ?? '')

@push('lang')
    @include('frontend.components.lang_url.lang', ['path' => ''])
@endpush

@section('schema_code')
    {!! $settings['home_page_schema'] ?? '' !!}
@stop

@section('content')
    <!-- BEGIN :: slider section -->
    <div class="slider">
        <!-- slider -->
        <div class="swiper joeleSlider">
            <div class="swiper-wrapper">
                @foreach($sliders as $slider)
                    <!-- slide -->
                        <div class="swiper-slide">
                            <div class="slider__slide">
                                <!-- image -->
                                <div class="slider__slide-image" data-aos="zoom-out">
                                    @if($slider->media->first()->mime_type == 'video')
                                        <video class="swiper-lazy lazyload" loop="true" autoplay="autoplay" controls muted>
                                            <source src="{{ $slider->slider_image }}" type="video/mp4" />
                                        </video>
                                     @else
                                        <picture>
                                            <source class="swiper-lazy lazyload" srcset="{{ $slider->slider_image }}" type="image/webp">
                                            <img class="swiper-lazy lazyload" src="{{ asset('frontend/images/placeholder.svg') }}" data-src="{{ $slider->slider_image }}" alt="alt">
                                        </picture>
                                    @endif
                                    <div class="swiper-lazy-preloader"></div>
                                </div>
                                <!-- // image -->
                                <!-- text -->
                                <div class="slider__slide-text">
                                    <div class="container">
                                        <div class="slider__slide-content">
                                            <span class="overline" data-aos="fade-up">{{ $slider->first_title }}</span>
                                            <h1 data-aos="fade-up" data-aos-delay="50">{{ $slider->second_title }}</h1>
                                            <p class="lead" data-aos="fade-up" data-aos-delay="100">{{ $slider->description }}</p>
                                            <div class="slider__actions" data-aos="fade-up" data-aos-delay="150">
                                                <a href="{{ route('web.about-us') }}" class="btn btn-white">@lang('system.know_more')</a>
                                                <a href="{{ route('web.booking.index') }}" class="btn btn-brand-gradient">@lang('system.book_now')</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- // text -->
                            </div>
                        </div>
                        <!-- // slide -->
                @endforeach
            </div>
            <div class="swiper-pagination"></div>
            <div class="slider-controls">
                <div class="swiper-button-next hero-slider-next"></div>
                <div class="swiper-button-prev hero-slider-prev"></div>
            </div>
        </div>
        <!-- // slider -->

        <!-- overlay -->
        <div class="slider__overlay" data-aos="fade-up" data-aos-delay="200">
            <div class="container d-flex align-items-center">
                <!-- rate -->
                <a href="{{ route('web.reviews.create') }}" class="slider__rate card d-flex align-items-center flex-row gap-4">
                    <div class="slider__rate-image">
                        <picture>
                            <source class="lazyload" srcset="{{ asset('frontend/images/placeholder.svg') }}" data-srcset="{{ asset('frontend/images/rate.webp') }}" type="image/webp">
                            <img class="lazyload sdddsd" src="{{ asset('frontend/images/placeholder.svg') }}" data-src="{{ asset('frontend/images/rate.jpg') }}" alt="alt">
                        </picture>
                    </div>
                    <div class="slider__rate-text">
                        <span class="overline">@lang('system.did_you_visit_us_recently')</span>
                        <span class="h6 d-block">@lang('system.you_can_rate_your_visit_here')</span>
                    </div>
                </a>
                <!-- // rate -->
                <!-- rate -->
                <div class="slider__time card d-flex align-items-center">
                    <div class="slider__time-icon">
                        <picture>
                            <source srcset="{{ asset('frontend/images/icons/icons.svg#time') }}" type="image/webp">
                            <img class="icon" src="{{ asset('frontend/images/icons/icons.svg#time') }}" alt="opening time">
                        </picture>
                    </div>
                    <!-- time block -->
                    <div class="slider__time-text">
                        <span class="slider__time-head d-block">@lang('system.working_days')</span>
                        <span class="slider__time-info d-block">{{ $settings['working_days'][app()->getLocale() == 'en'  ?  'en' : 'ar'] ?? '' }}</span>
                    </div>
                    <!-- // time block -->
                    <!-- time block -->
                    <div class="slider__time-text">
                        <span class="slider__time-head d-block">@lang('system.working_time')</span>
                        <span class="slider__time-info d-block">{{ $settings['working_time'][app()->getLocale() == 'en'  ?  'en' : 'ar'] ?? '' }}</span>
                    </div>
                    <!-- // time block -->
                    <!-- time block -->
                    <div class="slider__time-text">
                        <span class="slider__time-head d-block">@lang('system.day_off')</span>
                        <span class="slider__time-info d-block">{{ $settings['day_off'][app()->getLocale() == 'en'  ?  'en' : 'ar'] ?? '' }}</span>
                    </div>
                    <!-- // time block -->
                </div>
                <!-- // rate -->
            </div>
        </div>
        <!-- // overlay -->
    </div>
    <!-- END :: slider section -->

    <!-- wrapper -->
    <div class="wrapper">

        <!-- about -->
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
                            <p data-aos="fade-up" data-aos-delay="50">{!! $settings['about_us_page_content'][app()->getLocale() == 'en'  ?  'en' : 'ar'] ?? '' !!}</p>
                            <div data-aos="fade-up" data-aos-delay="100">
                                <a href="{{ route('web.about-us') }}" class="btn btn-link">
                                    @lang('system.more_about_joele')
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="about__image" data-aos="zoom-out">
                            <picture>
                                <source class="lazyload" srcset="{{ asset('frontend/images/placeholder.svg') }}" data-srcset="{{ asset('frontend/images/about.webp') }}" type="image/webp">
                                <img loading="lazy" class="lazyload" src="{{ asset('frontend/images/placeholder.svg') }}" data-src="{{ asset('frontend/images/about.jpg') }}" alt="@lang('system.about')">
                            </picture>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- // about -->

        <!-- hero -->
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
                                    <span class="h1 d-flex">{{--{{ number_format\DB::table('branches')->count()) }}--}} {{ number_format(400000) }}</span>
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
        <!-- // hero -->

        <!-- BEGIN :: categories -->
        <div class="services d-pad">
            <div class="container">
                <div class="row">
                    <!-- text -->
                    <div class="col-lg-4">
                        <!-- title -->
                        <div class="section-title" data-aos="fade-up">
                            <h2>{{ $settings['services_page_title'][app()->getLocale() == 'en'  ?  'en' : 'ar'] ?? '' }}</h2>
                        </div>
                        <!-- // title -->
                        <p data-aos="fade-up" data-aos-delay="50">{{ $settings['services_page_content'][app()->getLocale() == 'en'  ?  'en' : 'ar'] ?? '' }}</p>
                        <div data-aos="fade-up" data-aos-delay="100">
                            <a href="{{ route('web.services.index') }}" class="btn btn-link">
                                @lang('system.about_our_services')
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
                                    @foreach($categories as $category)
                                        <!-- service card -->
                                        <div class="swiper-slide">
                                            <a class="card service__card" href="{{ route('web.services.list', ['slug' => $category->slug ]) }}">
                                                <div class="service__card-image">
                                                    <picture>
                                                        <source class="lazyload" srcset="{{ asset('frontend/images/placeholder.svg') }}" data-srcset="{{ $category->category_image }}" type="image/webp">
                                                        <img loading="lazy" class="lazyload" src="{{ asset('frontend/images/placeholder.svg') }}" data-src="{{ $category->category_image }}" alt="service name">
                                                    </picture>
                                                </div>
                                                <h3 class="service__card-title h5">{{ $category->name }}</h3>
                                            </a>
                                        </div>
                                        <!-- service card -->
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
        </div>
        <!-- END :: categories -->

        <!-- BEGIN :: doctors -->
        <section class="doctors">
            <div class="container">
                <!-- title -->
                <div class="section-title" data-aos="fade-up">
                    <h2>@lang('system.our_doctors')</h2>
                </div>
                <!-- // title -->
                <div class="row">
                    <div class="col-lg-6">
                        <p data-aos="fade-up" data-aos-delay="50">{{ $settings['doctor_content'][app()->getLocale() == 'en'  ?  'en' : 'ar'] ?? '' }}</p>
                    </div>
                    <!-- filters -->
                    <div class="col-lg-6">
                        <div class="filters" data-aos="fade-up">
                            <a href="{{ route('web.doctors.index') }}">
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label checked" for="allDoctors">
                                        @lang('system.our_doctors')
                                    </label>
                                </div>
                            </a>
                        </div>
                    </div>
                    <!-- // filters -->
                </div>
                <!-- slider -->
                <div class="doctors-slider" data-aos="fade-up">
                    <div class="swiper doctorsSlider">
                        <div class="swiper-wrapper">
                            @foreach($doctors as $doctor)
                                <!-- doctor card -->
                                <div class="swiper-slide">
                                    <div class="doctor__card">
                                        <!-- social -->
                                        <div class="doctor__card-social d-flex flex-column gap-2">
                                            @foreach($doctor->socialMediaData as $key => $doctorLinks)
                                                @if($doctorLinks)
                                                    @include("frontend.components.social_media.$key", ['link' => $doctorLinks])
                                                @endif
                                            @endforeach
                                        </div>
                                        <!-- // social -->

                                        <a href="{{ route('web.doctors.details', ['slug' => $doctor->slug ]) }}">
                                            <div class="doctor__card-image">
                                                <picture>
                                                    <source class="lazyload" srcset="{{ asset('frontend/images/placeholder.svg') }}" data-srcset="{{ $doctor->doctor_image }}" type="image/webp" />
                                                    <img loading="lazy" class="lazyload" src="{{ asset('frontend/images/placeholder.svg') }}" data-src="{{ $doctor->doctor_image }}" alt="doctor name" />
                                                </picture>
                                            </div>
                                            <h3 class="doctor__card-title h5 text-center">{{ $doctor->name }}</h3>
                                            <span class="doctor__card-info d-flex align-items-center justify-content-between gap-4">
                                                <span class="d-block color">{{ $doctor->category->name }}</span>
                                                <span class="d-block">{{ optional($doctor->specializations->first())->name }}</span>
                                            </span>
                                        </a>
                                        <a href="{{ route('web.booking.index') }}" class="btn btn-brand-gradient w-100">@lang('system.book_now')</a>
                                    </div>
                                </div>
                                <!-- // doctor card -->
                            @endforeach
                        </div>
                        <div class="swiper-pagination"></div>
                        <div class="slider-controls">
                            <div class="swiper-button-next doctors-next"></div>
                            <div class="swiper-button-prev doctors-prev"></div>
                        </div>
                    </div>
                </div>
                <!-- // slider -->
            </div>
        </section>
        <!-- END :: doctors -->

        <!-- before and after -->
        <section class="before-and-after d-pad">
            <div class="container">
                <!-- title -->
                <div class="section-title" data-aos="fade-up">
                    <h2>@lang('system.before_and_after')</h2>
                </div>
                <!-- // title -->
                <div class="row">
                    <div class="col-lg-6">
                        <p data-aos="fade-up" data-aos-delay="50">{{ $settings['cases_content_home'][app()->getLocale() == 'en'  ?  'en' : 'ar'] ?? '' }}</p>
                    </div>
                    <!-- filters -->
                    <div class="col-lg-6">
                        <div class="filters" data-aos="fade-up">
                            <a href="{{ route('web.cases.index') }}">
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label checked" for="allDoctors">
                                        @lang('system.all_cases')
                                    </label>
                                </div>
                            </a>
                        </div>
                    </div>
                    <!-- // filters -->
                </div>
                <!-- slider -->
                <div class="cases-slider" data-aos="fade-up">
                    <div class="swiper casesSlider">
                        <div class="swiper-wrapper">

                           @foreach($cases as $case)
                                <!-- cases card -->
                                <div class="swiper-slide">
                                    <div class="case__card card">
                                        <div class="case twentytwenty-container">
                                            <picture>
                                                <source class="lazyload" srcset="{{ asset('frontend/images/placeholder.svg') }}" data-srcset="{{ $case->imageBefore }}" type="image/webp" />
                                                <img loading="lazy" class="lazyload" src="{{ asset('frontend/images/placeholder.svg') }}" data-src="{{ $case->imageBefore }}" alt="before" />
                                            </picture>
                                            <picture>
                                                <source class="lazyload" srcset="{{ asset('frontend/images/placeholder.svg') }}" data-srcset="{{ $case->imageAfter }}" type="image/webp" />
                                                <img loading="lazy" class="lazyload" src="{{ asset('frontend/images/placeholder.svg') }}" data-src="{{ $case->imageAfter }}" alt="after" />
                                            </picture>
                                        </div>

                                        <div class="d-flex gap-2">
                                            <div class="case__card-image">
                                                <picture>
                                                    <source srcset="{{ $case->doctor->doctor_image }}" type="image/webp" />
                                                    <img loading="lazy" class="lazyload" src="{{ asset('frontend/images/placeholder.svg') }}" data-src="{{ $case->doctor->doctor_image }}" alt="dr name" />
                                                </picture>
                                            </div>
                                            <div class="case__card-info d-flex align-items-center flex-wrap gap-2 justify-content-between w-100">
                                                <h3 class="h6">
                                                    <a href="{{ route('web.doctors.details', $case->doctor->slug) }}">
                                                        {{ $case->doctor->name }}
                                                    </a>
                                                </h3>
                                                <span class="color">{{ $case->category->name }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- // cases card -->
                            @endforeach
                        </div>
                        <div class="swiper-pagination"></div>
                        <div class="slider-controls">
                            <div class="swiper-button-next case-next"></div>
                            <div class="swiper-button-prev case-prev"></div>
                        </div>
                    </div>
                </div>
                <!-- // slider -->
            </div>
        </section>
        <!-- // before and after -->

        <!-- testimonials -->
        <section class="testimonials d-pad">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4">
                        <!-- title -->
                        <div class="section-title" data-aos="fade-up">
                            <!-- <h2>@lang('system.customer_reviews')</h2> -->
                            <h2>@lang('system.what_about_us')</h2>
                        </div>
                        <!-- // title -->
                        <p data-aos="fade-up" data-aos-delay="50">{{ $settings['review_content'][app()->getLocale() == 'en'  ?  'en' : 'ar'] ?? '' }}</p>
                        <a href="{{ route('web.reviews.create') }}" class="btn btn-link">
                            @lang('system.send_us_your_review')
                        </a>
                    </div>
                    <!-- slider -->
                    <div class="col-lg-8">
                        <div class="testimonials-slider" data-aos="fade-up">
                            <div class="swiper testimonialsSlider card">
                                <div class="swiper-wrapper">
                                    @foreach($reviews as $review)
                                        <!-- testimonial card -->
                                        <div class="swiper-slide">
                                            <div class="testimonial d-flex flex-column align-items-center text-center">
                                                <p class="lead">{{ $review->message }}</p>
                                                <div class="testimonial__sayer">
                                                    {{--<picture>
                                                        <source srcset="{{ $testimonial->testimonialImage }}" type="image/webp">
                                                        <img loading="lazy" class="lazyload" src="{{ asset('frontend/images/placeholder.svg') }}" data-src="{{ $testimonial->testimonialImage }}" alt="alt">
                                                    </picture>--}}
                                                    <h6>{{ $review->name }}</h6>
                                                        <span>
                                                            <picture>
                                                            <source srcset="{{ $review->doctor->doctorImage }}" type="image/webp">
                                                            <img loading="lazy" class="lazyload" src="{{ asset('frontend/images/placeholder.svg') }}" data-src="{{ $review->doctor->doctorImage }}" alt="alt">
                                                        </picture>
                                                        <h6>{{ $review->doctor->name }}</h6>
                                                    </span>

                                                    {{--<div class="testimonial__stars d-flex justify-content-center">
                                                        @for($i = 1 ; $i <= $testimonial->rating ; $i++)
                                                            <picture>
                                                                <source srcset="{{ asset('frontend/images/icons/star.svg') }}" type="image/webp">
                                                                <img loading="lazy" class="lazyload icon" src="{{ asset('frontend/images/placeholder.svg') }}" data-src="{{ asset('frontend/images/icons/star.svg') }}" draggable="false" alt="star">
                                                            </picture>
                                                        @endfor
                                                    </div>--}}
                                                </div>
                                            </div>
                                        </div>
                                        <!-- // testimonial card -->
                                    @endforeach
                                </div>
                                <div class="swiper-pagination"></div>
                                <div class="slider-controls">
                                    <div class="swiper-button-next testimonials-next"></div>
                                    <div class="swiper-button-prev testimonials-prev"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- // slider -->
                </div>
            </div>
        </section>
        <!-- // testimonials -->

        <!-- latest articles -->
        @if(count($blogs) > 0)
        <section class="articles d-pad">
            <div class="container">
                <!-- title -->
                <div class="section-title" data-aos="fade-up">
                    <h2>@lang('system.medical_blog')</h2>
                </div>
                <!-- // title -->
                <div class="row">
                    <div class="col-lg-6">
                        <p data-aos="fade-up" data-aos-delay="50">{{ $settings['articles_content'][app()->getLocale() == 'en'  ?  'en' : 'ar'] ?? '' }}</p>
                    </div>
                    <!-- filters -->

                    <div class="col-lg-6">
                        <div class="filters" data-aos="fade-up">
                            <a href="{{ route('web.blogs.index') }}">
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label checked" for="allDoctors">
                                        @lang('system.all_blogs')
                                    </label>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <!-- slider -->
                <div class="articles-slider" data-aos="fade-up">
                    <div class="swiper articlesSlider">
                        <div class="swiper-wrapper">
                            @foreach($blogs as $blog)
                                <!-- slide -->
                                <div class="swiper-slide">
                                    <a class="article__card card" href="{{ route('web.blog.show', $blog->slug) }}">
                                        <div class="article__card-image">
                                            <picture>
                                                <source srcset="{{ $blog->blog_image }}" type="image/webp">
                                                <img loading="lazy" class="lazyload" src="{{ asset('frontend/images/placeholder.svg') }}" data-src="{{ $blog->blog_image }}" alt="article">
                                            </picture>
                                        </div>
                                        <div class="article__card-text">
                                            <span class="color">{{ $blog->category->name }}</span>
                                            <h3 class="h5">{{ $blog->title }}</h3>
                                            <small>{{ $blog->created_at->diffForHumans() }}</small>
                                        </div>
                                    </a>
                                </div>
                                <!-- // slide -->
                            @endforeach
                        </div>
                        <div class="swiper-pagination"></div>
                        <div class="slider-controls">
                            <div class="swiper-button-next articles-next"></div>
                            <div class="swiper-button-prev articles-prev"></div>
                        </div>
                    </div>
                </div>
                <!-- // slider -->
            </div>
        </section>
        @endif
        <!-- // latest articles -->

        <!-- latest lectures -->
        <section class="lectures d-pad">
            <div class="container">
                <!-- title -->
                <div class="section-title" data-aos="fade-up">
                    <h2>@lang('system.joele_studio')</h2>
                </div>
                <!-- // title -->
                <div class="row">
                    <div class="col-lg-6">
                        <p data-aos="fade-up" data-aos-delay="50">{{ $settings['lectures_content'][app()->getLocale() == 'en'  ?  'en' : 'ar'] ?? '' }}</p>
                    </div>
                    <!-- filters -->
                    <div class="col-lg-6">
                        <div class="filters" data-aos="fade-up">
                            <a href="{{ route('web.lectures.index') }}">
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label checked" for="allDoctors">
                                        @lang('system.joele_studio')
                                    </label>
                                </div>
                            </a>
                        </div>
                    </div>
                    <!-- // filters -->
                </div>
                <!-- slider -->
                <div class="lectures-slider" data-aos="fade-up">
                    <div class="swiper lecturesSlider">
                        <div class="swiper-wrapper">
                            @foreach($lectures as $lecture)
                                <!-- slide -->
                                <div class="swiper-slide">
                                    <a class="lecture__card card" href="#" data-bs-toggle="modal" data-bs-target="#lectureModal" data-link="{{ $lecture->link }}">
                                        <div class="lecture__card-image">
                                            <picture>
                                                <source srcset="{{ $lecture->lecture_image }}" type="image/webp">
                                                <img loading="lazy" class="lazyload" src="{{ asset('frontend/images/placeholder.svg') }}" data-src="{{ $lecture->lecture_image }}" alt="alt">
                                            </picture>
                                        </div>
                                        <div class="lecture__card-info">
                                            <h3 class="h5">{{ $lecture->title }}</h3>
                                            <small class="color">{{ $lecture->category->name }}</small>
                                        </div>
                                    </a>
                                </div>
                                <!-- // slide -->
                            @endforeach
                        </div>
                        <div class="swiper-pagination"></div>
                        <div class="slider-controls">
                            <div class="swiper-button-next lectures-next"></div>
                            <div class="swiper-button-prev lectures-prev"></div>
                        </div>
                    </div>
                </div>
                <!-- // slider -->
            </div>
        </section>
        <!-- // latest lectures -->

        <!-- before and after -->
        <section class="insurance-container d-pad">
            <div class="container">
                <!-- title -->
                <div class="section-title" data-aos="fade-up">
                    <h2>@lang('system.insurance_companies')</h2>
                </div>
                <!-- // title -->
                <!-- slider -->
                <div class="insurance-slider" data-aos="fade-up">
                    <div class="swiper insuranceSlider">
                        <div class="swiper-wrapper">
                           @foreach($insuranceCompanies as $insuranceCompany)
                                <div class="swiper-slide">
                                    <div class="company">
                                        <img src="{{ $insuranceCompany->insurance_company_image }}"
                                        draggable="false" alt="{{ $insuranceCompany->title }}">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="swiper-pagination insurance-pagination"></div>
                        <div class="slider-controls">
                            <div class="swiper-button-next insurance-next"></div>
                            <div class="swiper-button-prev insurance-prev"></div>
                        </div>
                    </div>
                </div>
                <!-- // slider -->
            </div>
        </section>
        <!-- // before and after -->
    </div>
    <!-- // wrapper -->

    <!-- BEGIN :: lecture modal -->
    <div class="lecture-overlay" id="lectureOverlay">
        <div class="modal fade" id="lectureModal" tabindex="-1" aria-labelledby="lectureModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content card p-0" id="lectureModalLabel">
                    <!-- close btn -->
                    <button type="button" class="btn btn-transparent" data-bs-dismiss="modal">
                        <picture>
                            <source srcset="{{ asset('frontend/images/icons/icons.svg#close') }}" type="image/webp" />
                            <img loading="lazy" class="lazyload icon" src="{{ asset('frontend/images/placeholder.svg') }}" data-src="{{ asset('frontend/images/icons/icons.svg#close') }}" draggable="false" alt="close" />
                        </picture>
                    </button>
                    <!-- // close btn -->
                    <!-- video -->
{{--                    <video controls>--}}
{{--                        <source src="http://127.0.0.1:8000/frontend/videos/video.mp4" id="video_source_element" type="video/mp4">--}}
{{--                        Your browser does not support the video tag.--}}
{{--                    </video>--}}
                    <!-- // video -->
                    <!-- youtube -->
                    <iframe src=""
                            title="YouTube video player"
                            frameborder="0"
                            id="video_source_element"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    <!-- // youtube -->
                </div>
            </div>
        </div>
    </div>
    <!-- END :: lecture modal -->
@endsection

@push('js')
    <script>
        var videoElement = $('#video_source_element');

        $(document).on('click', '.lecture__card', function() {
            videoElement.attr('src', $(this).data('link'));
        });
        $('#lectureModal').on('hidden.bs.modal', function () {
            var tempSrc = videoElement.attr("src");
            videoElement.attr("src", tempSrc);
        });
    </script>
@endpush
