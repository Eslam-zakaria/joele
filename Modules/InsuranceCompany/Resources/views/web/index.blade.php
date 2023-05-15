@extends('frontend.layouts.master')

@section('meta')
    {!! $settings['insurance_companies_page_seo'][app()->getLocale() == 'en'  ?  'en' : 'ar'] ?? '' !!}
@stop

@section('title', __('system.insurance_companies') . ' | ' . ( $settings['website_name'][app()->getLocale() == 'en'  ?  'en' : 'ar'] ?? '' ))

@push('styles')
    <link rel="stylesheet" href="{{ asset('frontend/css/insurance' . ( app()->getLocale() == 'en' ? '.min.css' : '-rtl.min.css') ) }}" as="style" crossorigin>
@endpush

@push('lang')
@include('frontend.components.lang_url.lang', ['path' => '/insurance-companies'])
@endpush

@section('content')
    <!-- BEGIN ::page header -->
    <div class="page-header">
        <!-- image -->
        <div class="page-header__image" data-aos="zoom-out">
            <picture>
                <source srcset="{{ asset('frontend/images/page-header.webp') }}" type="image/webp" />
                <img src="{{ asset('frontend/images/page-header.png') }}" draggable="false" alt="page header" />
            </picture>
        </div>
        <!-- // image -->
        <div class="page-header__text">
            <div class="container">
                <h2 data-aos="fade-up">@lang('system.insurance_companies')</h2>
                <nav aria-label="breadcrumb" data-aos="fade-up" data-aos-delay="50">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">@lang('system.home')</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('system.insurance_companies')</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- END ::page header -->

    <!-- BEGIN :: page content -->
    <div class="wrapper">
        <section class="insurance d-pad">
            <div class="container">
                <!-- title -->
                <div class="section-title" data-aos="fade-up">
                    <h2>@lang('system.insurance_companies')</h2>
                </div>
                <!-- // title -->
                <div class="row">
                    @foreach($insuranceCompanies as $insuranceCompany)
                        <!-- card -->
                        <div class="col-lg-6">
                            <div class="company card" data-aos="fade-up">
                                <div class="company__header d-flex align-items-center">
                                    <div class="company__image" data-aos="zoom-out">
                                        <picture>
                                            <source srcset="{{ $insuranceCompany->insurance_company_image }}" type="image/webp">
                                            <img src="{{ $insuranceCompany->insurance_company_image }}"
                                                 draggable="false"
                                                 alt="{{ $insuranceCompany->translate(app()->getLocale())->title ?? '' }}">
                                        </picture>
                                    </div>
                                    <h3 class="h4">{{ $insuranceCompany->translate(app()->getLocale())->title ?? '' }}</h3>
                                </div>
                                <div class="company__body">
                                    <p>{{ $insuranceCompany->translate(app()->getLocale())->content ?? '' }}</p>
                                </div>
                            </div>
                        </div>
                        <!-- // card -->
                    @endforeach

                    <!-- pagination -->
                    <div class="col-lg-12">
                        <div class="pagination__container" data-aos="fade-up">
                            <nav aria-label="Page navigation example">
                                <ul class="pagination">
                                    {{ $insuranceCompanies->links('frontend.home.pagination') }}
                                </ul>
                            </nav>
                        </div>
                    </div>
                    <!-- // pagination -->
                </div>
            </div>
        </section>
    </div>
    <!-- END :: page content -->
@endsection
