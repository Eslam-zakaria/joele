@extends('frontend.layouts.master')

@section('title')
    @lang('system.service') {{ $category->name ?? ''}}
@stop

@section('meta')
    <meta property="og:title" content="{{ $category->name ?? '' }}"/>
    <meta property="og:description" content="{{ $category->meta_description ?? '' }}" />
    <meta property="og:image" content="{{ $category->category_image ?? '/frontend/images/logo.svg' }}"/>
    <meta property="og:url" content="{{ url()->current() ?? '' }}"/>

    <!-- Meta description for twitter. -->
    <meta name="twitter:card" content="{{ $category->category_image ?? '/frontend/images/logo.svg' }}">
    <meta name="twitter:site" content="{{ url('/') }}">
    <meta name="twitter:title" content="{{ $category->name ?? '' }}"/>
    <meta name="twitter:description" content="{{ $category->meta_description ?? '' }}" />
    <meta name="twitter:image" content="{{ $category->category_image ?? '/frontend/images/logo.svg' }}" />

    <link rel="canonical" href="{{ $category->canonical_url ?? '' }}" />
    <meta name="title" content="{{ $category->meta_title ?? '' }}"/>
    <meta name="keywords" content="{{ $category->meta_keywords ?? '' }}"/>
    <meta name="description" content="{{ $category->meta_description ?? '' }}"/>
@stop

@push('styles')
    <link rel="stylesheet preload" href="{{ asset('frontend/css/' . ( app()->getLocale() == 'en' ? 'services.min.css' : 'services-rtl.min.css' ) ) }}" as="style" crossorigin>
@endpush

@push('lang')
    @include('frontend.components.lang_url.lang', ['path' => (app()->getLocale() == 'en' ? '/services/'.$category->translate('ar')->slug : '/services/'.$category->translate('en')->slug)])
@endpush

@section('schema_code')

<script type="application/ld+json">
{
    "@context": "http://schema.org",
    "@type": "WebPage",
    "name": "{{ $category->translate('en')->name ?? ''}}",
    "description": "{{ $category->translate('en')->meta_description ?? '' }}"
}
</script>

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
                <h2 data-aos="fade-up">@lang('system.service') {{ $category->name ?? ''}}</h2>
                <!-- breadcrumb -->
                <nav aria-label="breadcrumb" data-aos="fade-up" data-aos-delay="50">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('web.home.index') }}">@lang('system.home')</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('web.services.index') }}">@lang('system.services')</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('system.service') {{ $category->name ?? ''}}</li>
                    </ol>
                </nav>
                <!-- // breadcrumb -->
            </div>
        </div>
    </div>
    <!-- // page header -->

    <div class="wrapper">

<!-- services -->
<section class="service-category d-pad">
    <div class="container">
        <!-- title -->
        <div class="section-title" data-aos="fade-up">
            <h2>@lang('system.service') {{ $category->name ?? ''}}</h2>
        </div>
        <!-- // title -->
        <div class="row">
            <div class="col-lg-6">
                <p>
                   {{ $category->description ?? ''}}
                </p>
            </div>
            <!-- filters -->
            <div class="col-lg-6">
                <form>
                    <div class="filters">
                        <!-- filter -->
                        @if(count($categories) > 0)
                            @foreach($categories as $cat)
                                <a @if($cat->id == $category->category_id) class="btn btn-brand-gradient" @else class="btn btn-white" @endif href="{{ route('web.services.list', ['slug' => $cat->slug ]) }}">{{ $cat->name ?? ''}}</a>
                            @endforeach
                        @endif
                        <!-- // filter -->
                    </div>
                </form>
            </div>
            <!-- // filters -->
            <!-- service category -->
            <div class="col-lg-12">
                <div class="service-category">
                    <div class="row">
                        <!-- service -->
                        @if(count($services) > 0)
                            @foreach($services as $service)
                            <div class="{{ $category->serviceItemsPerRowClass }}">
                                <a class="card service__card" href="{{ route('web.services.details', ['slug' => $service->slug ]) }}">
                                    <div class="service__card-image">
                                        <picture>
                                            <source srcset="{{ $service->service_image ?? ''}}" type="image/webp"><img loading="lazy" src="{{ $service->service_image ?? ''}}" alt="{{ $service->alt_image ?? $service->name }}">
                                        </picture>
                                    </div>
                                    <h3 class="service__card-title h5">
                                      {{ $service->name ?? ''}}
                                    </h3>
                                </a>
                            </div>
                            @endforeach
                        @endif
                        <!-- // service -->

                        <!-- pagination -->
{{--                        <div class="col-lg-12">--}}
{{--                            <div class="pagination__container" data-aos="fade-up">--}}
{{--                                <nav aria-label="Page navigation example">--}}
{{--                                    <ul class="pagination">--}}
{{--                                     {{ $services->links('frontend.home.pagination') }}--}}
{{--                                    </ul>--}}
{{--                                </nav>--}}
{{--                            </div>--}}
{{--                        </div>--}}
                        <!-- // pagination -->
                    </div>
                </div>
            </div>
            <!-- // service category -->
        </div>
    </div>
</section>
<!-- // services -->
    </div>
@stop
