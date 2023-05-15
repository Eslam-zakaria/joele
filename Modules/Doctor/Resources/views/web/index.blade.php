@extends('frontend.layouts.master')

@section('title', __('system.our_doctors'))

@section('meta')
    {!! $settings['doctors_page_seo'][app()->getLocale() == 'en'  ?  'en' : 'ar'] ?? '' !!}
@stop

@push('styles')
    <link rel="stylesheet preload" href="{{ asset('frontend/css/' . ( app()->getLocale() == 'en' ? 'doctors.min.css' : 'doctors-rtl.min.css' ) ) }}" as="style" crossorigin>
@endpush

@push('lang')
    @include('frontend.components.lang_url.lang', $request->get('category') != null ? ['path' => '/doctors'.'?category='.$request->get('category')] : ['path' => '/doctors'])
@endpush

@section('schema_code')
    {!! $settings['doctors_page_schema'] ?? '' !!}
@stop

@section('content')
    <!-- page header -->
    <div class="page-header">
        <!-- image -->
        <div class="page-header__image" data-aos="zoom-out">
            <picture>
                <source srcset="{{ asset('frontend/images/page-header.webp') }}" type="image/webp" />
                <img src="{{ asset('frontend/images/page-header.jpg') }}" draggable="false" alt="page header" />
            </picture>
        </div>
        <!-- // image -->

        <div class="page-header__text">
            <div class="container">
                <h2 data-aos="fade-up">@lang('system.our_doctors')</h2>
                <!-- breadcrumb -->
                <nav aria-label="breadcrumb" data-aos="fade-up" data-aos-delay="50">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('web.home.index') }}">@lang('system.home')</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('system.our_doctors')</li>
                    </ol>
                </nav>
                <!-- // breadcrumb -->
            </div>
        </div>
    </div>
    <!-- // page header -->

    <!-- wrapper -->
    <div class="wrapper">
        <!-- doctors -->
        <section class="doctors-page d-pad">
            <div class="container">
                <!-- title -->
                <div class="section-title" data-aos="fade-up">
                    <h2>@lang('system.our_doctors')</h2>
                </div>
                <!-- // title -->
                <form action="" id="filter_form">
                    <div class="row">
                        <div class="col-lg-3">
                            <select class="form-select" aria-label="التصفية بالفرع" data-aos="fade-up" name="branch" onchange="document.getElementById('filter_form').submit();">
                                <option value="">-- @lang('system.filter_by_branch') --</option>
                                @foreach($branches as $branch)
                                    <option value="{{ $branch->id }}" {{ $branch->id == request()->branch ? 'selected' : '' }}>
                                        {{ $branch->translate(app()->getLocale())->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-lg-3">
                            <select class="form-select" aria-label="التصفية بالتخصص" data-aos="fade-up" name="specialization" onchange="document.getElementById('filter_form').submit();">
                                <option value="">-- @lang('system.filter_by_specialization') --</option>
                                @foreach($specializations as $specialization)
                                    <option value="{{ $specialization->id }}" {{ $specialization->id == request()->specialization ? 'selected' : '' }}>
                                        {{ $specialization->translate(app()->getLocale())->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <!-- filters -->
                        <div class="col-lg-6">
                            <div class="filters" data-aos="fade-up">
                                <!-- filter -->
                                <a @if(empty($request->get('category'))) class="btn btn-brand-gradient" @else  class="btn btn-white" @endif href="{{ route('web.doctors.index') }}">@lang('system.all_doctors')</a>
                                <!-- // filter -->
                                <!-- filter -->
                                @foreach($categories as $key => $category)
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input"
                                               type="radio"
                                               name="category"
                                               id="category_{{ $key }}"
                                               value="{{ $category->id }}"
                                               onclick="document.getElementById('filter_form').submit();" {{ $category->id == request()->category ? 'checked' : '' }} />

                                        <label class="form-check-label {{ $category->id == request()->category ? 'checked' : '' }}" for="category_{{ $key }}">
                                            {{ $category->translate(app()->getLocale())->name }}
                                        </label>
                                    </div>
                                @endforeach
                                <!-- // filter -->
                            </div>
                        </div>
                    </div>
                </form>

                <div class="row">
                    <!-- // filters -->
                    <!-- doctors -->
                    <div class="col-lg-12">
                        <div class="doctors-container">
                            <div class="row">
                                <!-- doctor card -->
                                @if(!empty($doctors))
                                @foreach($doctors as $doctor)
                                <div class="col-lg-3">
                                    <div class="doctor__card" data-aos="fade-up">
                                        <!-- social -->
                                        @if($doctor->socialMediaData)
                                            <div class="doctor__card-social d-flex flex-column gap-2">
                                                @foreach($doctor->socialMediaData as $key => $doctorLinks)
                                                    @if($doctorLinks)
                                                        @include("frontend.components.social_media.$key", ['link' => $doctorLinks])
                                                    @endif
                                                @endforeach
                                            </div>
                                        @endif
                                        <!-- // social -->
                                        <a href="{{ route('web.doctors.details', ['slug' => $doctor->slug ]) }}">
                                            <div class="doctor__card-image">
                                                <picture>
                                                    <source srcset="{{ $doctor->doctor_image }}" type="image/webp">
                                                    <img src="{{ $doctor->doctor_image }}" alt="{{ $doctor->alt_image ?? $doctor->name }}">
                                                </picture>
                                            </div>
                                            <h3 class="doctor__card-title h5 text-center">{{ $doctor->name ?? '' }}</h3>
                                            <span class="doctor__card-info d-flex align-items-center justify-content-between gap-4">
                                                <span class="d-block color">{{ $doctor->category->name ?? '' }}</span>
                                                <span class="d-block">{{ optional($doctor->specializations->first())->name }}</span>
                                            </span>
                                        </a>
                                        <a href="{{ route('web.booking.index') }}" class="btn btn-brand-gradient w-100">@lang('system.book_now')</a>
                                    </div>
                                </div>
                                @endforeach
                                @endif
                                <!-- // doctor card -->
                                <!-- pagination -->
                                <div class="col-lg-12">
                                    <div class="pagination__container" data-aos="fade-up">
                                        <nav aria-label="Page navigation example">
                                            <ul class="pagination">
                                                {{ $doctors->withQueryString()->links('frontend.home.pagination') }}
                                            </ul>
                                        </nav>
                                    </div>
                                </div>
                                <!-- // pagination -->
                            </div>
                        </div>
                    </div>
                    <!-- // doctors -->
                </div>
            </div>
        </section>
        <!-- // doctors -->
    </div>
@stop
