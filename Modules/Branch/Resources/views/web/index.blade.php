@extends('frontend.layouts.master')

@section('meta')
    {!! $settings['branches_page_seo'][app()->getLocale() == 'en'  ?  'en' : 'ar'] ?? '' !!}
@stop

@push('styles')
    <link rel="stylesheet" href="{{ asset('frontend/css/contact' . ( app()->getLocale() == 'en' ? '.min.css' : '-rtl.min.css' ) ) }}" crossorigin="anonymous">
@endpush

@push('lang')
    @include('frontend.components.lang_url.lang', ['path' => '/branches'])
@endpush

@section('schema_code')
{!! $settings['branches_page_schema'] ?? '' !!}
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
                <h2 data-aos="fade-up">@lang('system.branches')</h2>
                <!-- breadcrumb -->
                <nav aria-label="breadcrumb" data-aos="fade-up" data-aos-delay="50">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('web.home.index') }}">@lang('system.home')</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('system.branches')</li>
                    </ol>
                </nav>
                <!-- // breadcrumb -->
            </div>
        </div>
    </div>
    <!-- END :: page header -->

    <!-- BEGIN :: page content -->
    <div class="wrapper">
        <section class="branches d-pad">
            <div class="container">
                <!-- section title -->
                <div class="section-title" data-aos="fade-up">
                    <h2>@lang('system.branches')</h2>
                </div>
                <!-- // section title -->
                @foreach($branches as $branch)
                    <div class="branch" data-aos="fade-up">
                        <div class="branch__info">
                            <h3 class="h4">{{ $branch->translate(app()->getLocale())->name }}</h3>
                            <p>{{ $branch->translate(app()->getLocale())->address }}</p>

                            <a href="tel:{{ $branch->phone }}" class="btn btn-border">
                                <picture>
                                    <source srcset="{{ asset('frontend/images/icons/icons.svg#phone') }}" type="image/webp">
                                    <img src="{{ asset('frontend/images/icons/icons.svg#phone') }}" alt="phone" class="icon">
                                </picture>
                                {{ $branch->phone }}
                            </a>

                            @if( $branch->another_phone )
                                <a href="tel:{{ $branch->another_phone }}" class="btn btn-border">
                                    <picture>
                                        <source srcset="{{ asset('frontend/images/icons/icons.svg#phone') }}" type="image/webp">
                                        <img src="{{ asset('frontend/images/icons/icons.svg#phone') }}" alt="phone" class="icon">
                                    </picture>
                                    {{ $branch->another_phone }}
                                </a>
                            @endif
                        </div>

                        <iframe src="{{ $branch->map_link }}"
                                width="600"
                                height="450"
                                style="border:0;"
                                allowfullscreen=""
                                loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                @endforeach
            </div>
        </section>
    </div>
    <!-- END :: page content -->
@stop
