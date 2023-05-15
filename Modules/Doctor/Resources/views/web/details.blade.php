@extends('frontend.layouts.master')

@section('title', $doctor->name ?? '')

@section('meta')
    <meta property="og:title" content="{{ $doctor->name ?? '' }}"/>
    <meta property="og:description" content='{!! $doctor->meta_description ?? '' !!}' />
    <meta property="og:image" content="{{ $doctor->doctor_image ?? '/frontend/images/logo.svg' }}"/>
    <meta property="og:url" content="{{ url()->current() ?? '' }}"/>

    <!-- Meta description for twitter. -->
    <meta name="twitter:card" content="{{ $doctor->doctor_image ?? '/frontend/images/logo.svg' }}">
    <meta name="twitter:site" content="{{ url('/') }}">
    <meta name="twitter:title" content="{{ $doctor->name ?? '' }}"/>
    <meta name="twitter:description" content='{!! $doctor->meta_description ?? '' !!}' />
    <meta name="twitter:image" content="{{ $doctor->doctor_image ?? '/frontend/images/logo.svg' }}" />

    <link rel="canonical" href="{{ $doctor->canonical_url ?? '' }}" />
    <meta name="title" content="{{ $doctor->meta_title ?? '' }}"/>
    <meta name="keywords" content="{{ $doctor->meta_keywords ?? '' }}"/>
    <meta name="description" content='{!! $doctor->meta_description ?? '' !!}'/>
@stop

@push('styles')
    <link rel="stylesheet preload" href="{{ asset('frontend/css/' . ( app()->getLocale() == 'en' ? 'doctors.min.css' : 'doctors-rtl.min.css' ) ) }}" as="style" crossorigin>
@endpush

@push('lang')
    @if($doctor->translate('ar'))
        @include('frontend.components.lang_url.lang', ['path' => (app()->getLocale() == 'en' ? '/doctor/' . $doctor->translate('ar')->slug : '/doctor/'.$doctor->translate('en')->slug)])
    @endif
@endpush

@section('schema_code')

<script type="application/ld+json">
{
    "@context": "http://schema.org",
    "@type": "WebPage",
    "name": "{{ $doctor->translate('en')->name ?? ''}}",
    "description": "{{ $doctor->translate('en')->description ?? '' }}"
}
</script>

@stop

@section('content')

    <!-- page header -->
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
                <{{ $doctor->title_header_option ?? 'h2' }}> {{ $doctor->name ?? ''}} </{{ $doctor->title_header_option ?? 'h2' }}>
                <!-- breadcrumb -->
                <nav aria-label="breadcrumb" data-aos="fade-up" data-aos-delay="50">
                    <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('web.home.index') }}">@lang('system.home')</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('web.doctors.index') }}">@lang('system.doctors')</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $doctor->name ?? ''}}</li>
                    </ol>
                </nav>
                <!-- // breadcrumb -->
            </div>
        </div>
    </div>
    <!-- // page header -->

    <!-- wrapper -->
    <div class="wrapper">
        <!-- doctor profile -->
        <section class="doctor-profile d-pad">
            <div class="container">
                <div class="row">
                    <div class="col-xl-2 order-xl-3">
                        <div class="doctor-profile__nav d-flex gap-2 flex-column" data-aos="fade-up">
                            <a href="#about" class="btn btn-white w-100 active">@lang('system.about_doctor')</a>
                            <a href="#journey" class="btn btn-white w-100">@lang('system.career_journey')</a>
                            <a href="#services" class="btn btn-white w-100 d-none">@lang('system.services')</a>
                            <a href="#cases" class="btn btn-white w-100">@lang('system.before_and_after')</a>
                            @if(count($doctor->reviews) > 0)
                                <a href="#reviews" class="btn btn-white w-100">@lang('system.customer_reviews')</a>
                            @endif
                        </div>
                    </div>
                    <!-- // dr nav -->
                    <!-- dr card -->
                    <div class="col-md-4 col-xl-3">
                        <div class="doctor__card" data-aos="fade-up">
                            <div class="doctor__card-social d-flex flex-column gap-2">
                                @foreach($doctor->socialMediaData as $key => $doctorLinks)
                                    @if($doctorLinks)
                                        @include("frontend.components.social_media.$key", ['link' => $doctorLinks])
                                    @endif
                                @endforeach
                            </div>

                            <div class="doctor__card-image">
                                <picture>
                                    <source srcset="{{ $doctor->doctor_image ?? '' }}" type="image/webp">
                                    <img src="{{ $doctor->doctor_image ?? '' }}" alt="{{ $doctor->alt_image ?? $doctor->name }}">
                                </picture>
                            </div>

                            <h3 class="doctor__card-title h5 text-center">{{ $doctor->name ?? ''}}</h3>
                            <span class="doctor__card-info d-flex align-items-center justify-content-between gap-4">
                                <span class="d-block color">{{ $doctor->category->name ?? ''}}</span>
                                <span class="d-block">{{ optional($doctor->specializations->first())->name }}</span>
                                <!-- <span class="d-block">الحمراء</span> -->
                            </span>
                            <a href="{{ route('web.booking.index') }}" class="btn btn-brand-gradient w-100">@lang('system.book_now')</a>
                        </div>
                    </div>
                    <!-- // dr card -->
                    <!-- dr profile -->
                    <div class="col-md-8 col-xl-7">
                        <div class="content">
                            <!-- about -->
                            <div class="about" id="about">
                                <{{ $doctor->title_header_option ?? 'h2' }} data-aos="fade-up">{{ $doctor->name ?? ''}}</{{ $doctor->title_header_option ?? 'h2' }}>
                                <div class="about__info d-flex flex-wrap gap-5" data-aos="fade-up" data-aos-delay="50">
                                    @if(count($doctor->specializations) > 0)
                                        <{{ $doctor->specialization_title_header_option ?? 'h2' }} class="color h6 font-weight-normal">
                                            @foreach($doctor->specializations as $specialization) {{ $specialization->name }} <span class="text-black">{{ $loop->last ? '' : ',' }}</span> @endforeach
                                        </{{ $doctor->specialization_title_header_option ?? 'h2' }}>
                                    @endif
                                    <span>{{ $doctor->experience_years ?? ''}}</span>
                                    <!-- <span>الحمراء</span> -->
                                </div>
                                <div class="about__text">
                                    <h3 class="h5" data-aos="fade-up">@lang('system.about_doctor')</h3>
                                    <p data-aos="fade-up" data-aos-delay="50">{!! $doctor->description ?? '' !!}</p>
                                </div>
                            </div>
                            <!-- // about -->

                            @if(count($doctor->branches) > 0)
                                <div class="journey sm-pad" id="journey">
                                    <h3 class="h5" data-aos="fade-up">@lang('system.branches')</h3>
                                    <!-- block -->
                                    @foreach($doctor->branches as $branch)
                                        <div class="journey__block card d-flex align-items-center gap-3" data-aos="fade-up">
                                            <div class="d-flex align-items-center gap-3">
                                                <span class="journey-icon">
                                                    <picture>
                                                        <source srcset="{{ asset('frontend/images/icons/icons.svg#branches') }}" type="image/webp">
                                                        <img src="{{ asset('frontend/images/icons/icons.svg#branches') }}" alt="icon">
                                                    </picture>
                                                </span>
                                                <span class="h6 color">{{ $branch->name ?? ''}}</span>
                                            </div>
                                        </div>
                                    @endforeach
                                    <!-- // block -->
                                </div>
                            @endif

                            <!-- journey -->
                            @if(count($doctor->experience) > 0)
                            <div class="journey sm-pad" id="journey">
                                <h3 class="h5" data-aos="fade-up">@lang('system.career_journey')</h3>
                                <!-- block -->
                                @foreach($doctor->experience as $experience)
                                <div class="journey__block card d-flex align-items-center gap-3" data-aos="fade-up">
                                    <div class="d-flex align-items-center gap-3">
                                        <span class="journey-icon">
                                            <picture>
                                                <source srcset="{{ asset('frontend/images/icons/icons.svg#doctors') }}" type="image/webp">
                                                <img src="{{ asset('frontend/images/icons/icons.svg#doctors') }}" alt="icon">
                                            </picture>
                                        </span>
                                        <span class="h6 color">{{ $experience->specialization ?? ''}}</span>
                                    </div>
                                    <span>{{ $experience->company_name ?? ''}}</span>
                                </div>
                                @endforeach
                                <!-- // block -->
                            </div>
                            @endif
                            <!-- // journey -->
                            <!-- services -->
                            @if(count($doctor->services) > 0)
                            <div class="services sm-pad d-none" id="services">
                                <h3 class="h5" data-aos="fade-up">@lang('system.services')</h3>
                                <div class="row">
                                    <!-- service -->
                                    @foreach($doctor->services as $service)
                                    <div class="col-lg-6">
                                        <div data-aos="fade-up">
                                            <a class="card service__card" href="{{ route('web.services.details', ['slug' => $service->slug ]) }}" data-aos="fade-up">
                                                <div class="service__card-image">
                                                    <picture>
                                                        <source srcset="{{ $service->service_image ?? '' }}" type="image/webp">
                                                        <img loading="lazy" src="{{ $service->service_image ?? '' }}" alt="{{ $service->alt_image ?? $service->name }}">
                                                    </picture>
                                                </div>
                                                <h3 class="service__card-title h5">
                                                  {{ $service->name ?? ''}}
                                                </h3>
                                            </a>
                                        </div>
                                    </div>
                                    @endforeach
                                    <!-- // service -->
                                </div>
                            </div>
                            @endif
                            <!-- // services -->
                            <!-- cases -->
                            @if(count($doctor->medicalCase) > 0)
                            <div class="cases sm-pad" id="cases">
                                <h3 class="h5" data-aos="fade-up">@lang('system.before_and_after')</h3>
                                <div class="row">
                                    <!-- cases card -->
                                    @foreach($doctor->medicalCase as $case)
                                    <div class="col-lg-6">
                                        <div class="case__card card" data-aos="fade-up">
                                            <div class="case twentytwenty-container">
                                                <picture>
                                                    <source srcset="{{ $case->image_before ?? '' }}" type="image/webp"><img loading="lazy" src="{{ $case->image_before ?? '' }}" alt="before">
                                                </picture>
                                                <picture>
                                                    <source srcset="{{ $case->image_after ?? '' }}" type="image/webp"><img loading="lazy" src="{{ $case->image_after ?? '' }}" alt="after">
                                                </picture>
                                            </div>
                                            <div class="d-flex gap-2">
                                                <div class="case__card-image">
                                                    <picture>
                                                        <source srcset="{{ $case->doctor->doctor_image ?? '' }}" type="image/webp">
                                                        <img src="{{ $case->doctor->doctor_image ?? '' }}" alt="dr name">
                                                    </picture>
                                                </div>
                                                <div class="case__card-info d-flex align-items-center flex-wrap gap-2 justify-content-between w-100">
                                                    <h3 class="h6"><a href="#!">{{ $case->doctor->name ?? ''}}</a></h3>
                                                    <span class="color">{{ $doctor->category->name ?? ''}}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                    <!-- // cases card -->
                                </div>
                            </div>
                            @endif
                            <!-- // cases -->

                            @if(count($doctor->reviews) > 0)
                                <div class="reviews sm-pad" id="reviews">
                                    <h3 class="h5" data-aos="fade-up">@lang('system.customer_reviews')</h3>
                                    <div class="testimonials-slider" data-aos="fade-up">
                                        <div class="swiper testimonialsSlider card">
                                            <div class="swiper-wrapper">
                                                @foreach($doctor->reviews as $review)
                                                    <!-- testimonial card -->
                                                    <div class="swiper-slide">
                                                        <div class="testimonial d-flex flex-column align-items-center text-center">
                                                            <p class="lead">{{ $review->message }}</p>
                                                            <div class="testimonial__sayer">
                                                                <h6>{{ $review->name }}</h6>
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
                            @endif
                        </div>
                    </div>
                    <!-- // dr profile -->
                    <!-- dr nav -->
                </div>
            </div>
        </section>
        <!-- // doctor profile -->
    </div>
@stop
