@extends('frontend.layouts.master')

@section('title', __('system.services'))

@section('meta')
    {!! $settings['services_page_seo'][app()->getLocale() == 'en'  ?  'en' : 'ar'] ?? '' !!}
@stop

@push('styles')
    <link rel="stylesheet preload" href="{{ asset('frontend/css/' . ( app()->getLocale() == 'en' ? 'services.min.css' : 'services-rtl.min.css' ) ) }}" as="style" crossorigin>
@endpush

@push('lang')
    @include('frontend.components.lang_url.lang', ['path' => '/services'])
@endpush

@section('schema_code')
{!! $settings['services_page_schema'] ?? '' !!}
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
                <h2 data-aos="fade-up">@lang('system.services')</h2>
                <!-- breadcrumb -->
                <nav aria-label="breadcrumb" data-aos="fade-up" data-aos-delay="50">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('web.home.index') }}">@lang('system.home')</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('system.services')</li>
                    </ol>
                </nav>
                <!-- // breadcrumb -->
            </div>
        </div>
    </div>
    <!-- // page header -->
    <div class="wrapper">
        <!-- services -->
        <section class="services d-pad">
            <div class="container">
                <!-- title -->
                <div class="section-title text-center" data-aos="fade-up">
                    <h2>{{ $settings['services_page_title'][app()->getLocale() == 'en'  ?  'en' : 'ar'] ?? '' }}</h2>
                    <p>{{ $settings['services_page_content'][app()->getLocale() == 'en'  ?  'en' : 'ar'] ?? '' }}</p>
                </div>
                <!-- // title -->
                <!-- services -->
                <div class="row">
                    <!-- service -->
                    @if(count($categories) > 0)
                        @foreach($categories as $cat)
                        <div class="col-lg-4">
                            <a class="card service__card" href="{{ route('web.services.list', ['slug' => $cat->slug ]) }}" data-aos="fade-up">
                                <div class="service__card-image">
                                    <picture>
                                        <source srcset="{{ $cat->category_image ?? '' }}" type="image/webp" />
                                        <img loading="lazy" src="{{ $cat->category_image ?? '' }}" alt="{{ $cat->alt_image ?? $cat->name }}" />
                                    </picture>
                                </div>
                                <h3 class="service__card-title h5">@lang('system.service') {{ $cat->name ?? ''}}</h3>
                            </a>
                        </div>
                        @endforeach
                    @endif
                    <!-- // service -->
                </div>
                <!-- // services -->
            </div>
        </section>
        <!-- // services -->
    </div>
@endsection


