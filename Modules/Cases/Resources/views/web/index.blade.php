@extends('frontend.layouts.master')

@section('meta')
    {!! $settings['cases_page_seo'][app()->getLocale() == 'en'  ?  'en' : 'ar'] ?? '' !!}
@stop

@section('title', __('system.before_and_after') . ' | ' . ( $settings['website_name'][app()->getLocale() == 'en'  ?  'en' : 'ar'] ?? '' ))

@push('styles')
    <link rel="stylesheet" href="{{ asset('frontend/css/before-and-after' . ( app()->getLocale() == 'ar' ? '-rtl.min.css' : '.min.css') ) }}" as="style" crossorigin>
@endpush

@push('lang')

@include('frontend.components.lang_url.lang', request()->get('category') != null ? ['path' => '/cases'.'?category='.request()->get('category')] : ['path' => '/cases'])

@endpush

@section('schema_code')
{!! $settings['cases_page_schema'] ?? '' !!}
@stop

@section('content')
    <div class="page-header">
        <!-- image -->
        <div class="page-header__image" data-aos="zoom-out">
            <picture>
                <source srcset="{{ asset('frontend/images/page-header.webp') }}" type="image/webp">
                <img src="{{ asset('frontend/images/page-header.jpg') }}" draggable="false" alt="@lang('system.before_and_after')">
            </picture>
        </div>
        <!-- // image -->
        <div class="page-header__text">
            <div class="container">
                <h2 data-aos="fade-up">@lang('system.before_and_after')</h2>
                <!-- breadcrumb -->
                <nav aria-label="breadcrumb" data-aos="fade-up" data-aos-delay="50">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('web.home.index') }}">@lang('system.home')</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('system.before_and_after')</li>
                    </ol>
                </nav>
                <!-- // breadcrumb -->
            </div>
        </div>
    </div>

    <div class="wrapper">
        <section class="cases-page d-pad">
            <div class="container">
                <!-- title -->
                <div class="section-title" data-aos="fade-up">
                    <h2>@lang('system.before_and_after')</h2>
                </div>
                <!-- // title -->

                <form action="" id="filter_form">
                    <div class="row">
                        <div class="col-lg-6">
                            <select class="form-select" aria-label="Sort by Branch" name="branch" data-aos="fade-up" onchange="document.getElementById('filter_form').submit();">
                                <option value="">-- @lang('system.choose') --</option>
                                @foreach($branches as $key => $branch)
                                    <option value="{{ $branch->id }}" {{ request()->branch == $branch->id ? 'selected' : '' }}>
                                        {{ $branch->translate(app()->getLocale())->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-lg-6">
                            <div class="filters" data-aos="fade-up">
                                <a class="btn {{ !request()->category ? 'btn-brand-gradient' : 'btn-white' }}" href="{{ route('web.cases.index') }}">@lang('system.before_and_after')</a>

                                @foreach($categories as $key => $category)
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input"
                                               type="radio"
                                               name="category"
                                               id="category_{{ $key }}"
                                               value="{{ $category->id }}"
                                               onclick="document.getElementById('filter_form').submit();" />

                                        <label class="form-check-label {{ $category->id == request()->category ? 'checked' : '' }}" for="category_{{ $key }}">
                                            {{ $category->translate(app()->getLocale())->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </form>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="cases-container">
                            <div class="row">
                                @foreach($cases as $case)
                                    <div class="col-lg-4 col-xl-3">
                                        <div class="case__card card" data-aos="fade-up">
                                            <div class="case twentytwenty-container">
                                                <picture>
                                                    <source srcset="{{ $case->image_before }}" type="image/webp">
                                                    <img loading="lazy" src="{{ $case->image_before }}" alt="before">
                                                </picture>
                                                <picture>
                                                    <source srcset="{{ $case->image_after }}" type="image/webp">
                                                    <img loading="lazy" src="{{ $case->image_after }}" alt="after">
                                                </picture>
                                            </div>
                                            <div class="d-flex gap-2">
                                                <div class="case__card-image">
                                                    <picture>
                                                        <source srcset="{{ $case->doctor->doctor_image }}" type="image/webp">
                                                        <img src="{{ $case->doctor->doctor_image }}" alt="dr name">
                                                    </picture>
                                                </div>
                                                <div class="case__card-info d-flex align-items-center flex-wrap gap-2 justify-content-between w-100">
                                                    <h3 class="h6"><a href="{{ route('web.doctors.details', ['slug' => $case->doctor->slug ]) }}">{{ $case->doctor->translate(app()->getLocale())->name }}</a></h3>
                                                    <span class="color">{{ $case->category->translate(app()->getLocale())->name }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                                <!-- pagination -->
                                <div class="col-lg-12">
                                    <div class="pagination__container" data-aos="fade-up">
                                        <ul class="pagination">
                                            {{ $cases->appends(['category' => request()->get('category'), 'branch' => request()->get('branch')])->links('frontend.home.pagination') }}
                                        </ul>
                                    </div>
                                </div>
                                <!-- // pagination -->
                            </div>
                        </div>
                    </div>
                    <!-- // cases -->
                </div>
            </div>
        </section>
    </div>
@stop
