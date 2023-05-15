@extends('frontend.layouts.master')

@section('title', __('system.latest_offers'))

@section('meta')
    {!! $settings['offers_page_seo'][app()->getLocale() == 'en'  ?  'en' : 'ar'] ?? '' !!}
@stop

@push('styles')
    <link rel="stylesheet preload" href="{{ asset('frontend/css/' . ( app()->getLocale() == 'en' ? 'offers.min.css' : 'offers-rtl.min.css' ) ) }}" as="style" crossorigin>
@endpush

@push('lang')
    @include('frontend.components.lang_url.lang', ['path' => '/latest-offers'])
@endpush

@section('schema_code')
{!! $settings['offer_page_schema'] ?? '' !!}
@stop

@section('content')
   <!-- page header -->
   <div class="page-header">
        <!-- image -->
        <div class="page-header__image" data-aos="zoom-out">
            <picture>
                <source srcset="{{ asset('frontend/images/page-header.webp') }}" type="image/webp"><img src="{{ asset('frontend/images/page-header.jpg') }}" draggable="false" alt="page header">
            </picture>
        </div>
        <!-- // image -->
        <div class="page-header__text">
            <div class="container">
                <h2 data-aos="fade-up">@lang('system.offers')</h2>
                <!-- breadcrumb -->
                <nav aria-label="breadcrumb" data-aos="fade-up" data-aos-delay="50">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('web.home.index') }}">@lang('system.home')</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('system.offers')</li>
                    </ol>
                </nav>
                <!-- // breadcrumb -->
            </div>
        </div>
    </div>
    <!-- // page header -->

    <!-- wrapper -->
    <div class="wrapper">

        <!-- offers -->
        <section class="offers d-pad">
            <div class="container">
                <!-- title -->
                <div class="section-title text-center" data-aos="fade-up">
                    <h2>@lang('system.latest_offers')</h2>
                    <p>{{ $settings['page_offer_content'][app()->getLocale() == 'en'  ?  'en' : 'ar'] ?? '' }}</p>
                </div>
                <!-- // title -->
                <!-- offers -->
                <div class="row">
                    <!-- offer -->
                    @foreach($branches as $branche)
                    <div class="col-lg-4">
                        <a class="card offer__card" href="{{ route('web.offers.lists', ['slug' => $branche->slug ]) }}" data-aos="fade-up">
                            <div class="offer__card-image">
                                <picture>
                                    <source srcset="{{ $branche->offer_image }}" type="image/webp"><img loading="lazy" src="{{ $branche->offer_image }}" alt="offer name">
                                </picture>
                            </div>
                            <h3 class="offer__card-title h5">
                            @lang('system.offer') {{ $branche->name ?? '' }}
                            </h3>
                        </a>
                    </div>
                    @endforeach
                    <!-- // offer -->
                </div>
                <!-- // offers -->
            </div>
        </section>
        <!-- // offers -->
    </div>
@stop
