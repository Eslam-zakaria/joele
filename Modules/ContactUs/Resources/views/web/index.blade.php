@extends('frontend.layouts.master')

@push('styles')
    <link rel="stylesheet" href="{{ asset('frontend/css/contact' . ( app()->getLocale() == 'ar' ? '-rtl.min.css' : '.min.css') ) }}" crossorigin="anonymous">
@endpush

@push('lang')
    @include('frontend.components.lang_url.lang', ['path' => '/contact-us'])
@endpush

@section('title', __('system.contact_us'))

@section('schema_code')
    {!! $settings['contact_page_schema'] ?? '' !!}
@stop

@section('meta')
    {!! $settings['contact_us_page_seo'][app()->getLocale() == 'en'  ?  'en' : 'ar'] ?? '' !!}
@stop

@section('content')
    <!-- BEGIN :: page header section -->
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
                <h2 data-aos="fade-up">@lang('system.contact_us')</h2>
                <!-- breadcrumb -->
                <nav aria-label="breadcrumb" data-aos="fade-up" data-aos-delay="50">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('web.home.index') }}">@lang('system.home')</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('system.contact_us')</li>
                    </ol>
                </nav>
                <!-- // breadcrumb -->
            </div>
        </div>
    </div>
    <!-- END :: page header section -->

    <!-- BEGIN :: page content -->
    <div class="wrapper">
        <section class="contact d-pad">
            <div class="container">
                <!-- section title -->
                <div class="section-title" data-aos="fade-up">
                    <h2>@lang('system.contact_us')</h2>
                </div>
                <!-- // section title -->

                <form action="{{ route('contact-us.store') }}" method="post">
                    @csrf
                    <!-- block -->
                    <div class="contact__block" data-aos="fade-up">
                        <h3 class="h4">@lang('system.purpose_of_communication')</h3>
                        <div class="contact__block-data">
                            <div class="row">
                                <!-- contact -->
                                <div class="col-lg-7">
                                    <div>
                                        <div class="filters">
                                            @foreach($contact_us_topic as $key => $data)
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input"
                                                           type="radio"
                                                           name="subject"
                                                           id="topic_{{ $key }}"
                                                           value="{{ $key }}" {{ old('subject') == $key ? 'checked' : '' }} />

                                                    <label class="form-check-label {{ old('subject') == $key ? 'checked' : '' }}" for="topic_{{ $key }}">
                                                        {{ $data[app()->getLocale() == 'en'  ?  'en' : 'ar'] }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    @error('subject')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-lg-5 d-flex align-items-center justify-content-end">
                                    <div class="top-bar__block contact d-flex gap-5">
                                        <!-- form -->
                                        <a class="top-bar__link" href="tel:{{ $settings['phone'] ?? '' }}">
                                            <span class="top-bar__link-icon">
                                                <picture>
                                                    <source srcset="{{ asset('frontend/images/icons/icons.svg#phone') }}" type="image/webp">
                                                    <img class="icon" src="{{ asset('frontend/images/icons/icons.svg#phone') }}" alt="Phone Icon">
                                                </picture>
                                            </span>
                                            <span class="top-bar__link-text">{{ $settings['phone'] ?? '' }}</span>
                                        </a>
                                        <!-- // form -->
                                        <!-- mail -->
                                        <a class="top-bar__link" href="mailto:{{ $settings['email'] ?? '' }}">
                                            <span class="top-bar__link-icon">
                                                <picture>
                                                    <source srcset="{{ asset('frontend/images/icons/icons.svg#mail') }}" type="image/webp">
                                                    <img class="icon" src="{{ asset('frontend/images/icons/icons.svg#mail') }}" alt="Email Icon">
                                                </picture>
                                            </span>
                                            <span class="top-bar__link-text">{{ $settings['email'] ?? '' }}</span>
                                        </a>
                                        <!-- // mail -->
                                    </div>
                                </div>
                                <!-- // contact -->
                            </div>
                        </div>
                    </div>
                    <!-- // block -->
                    <!-- block -->
                    <div class="contact__block" data-aos="fade-up">
                        <h3 class="h4">@lang('system.contact_informations')</h3>
                        <div class="contact__block-data">
                            <div class="row">
                                <div class="col-lg-6">
                                    <!-- form -->
                                    <div class="mb-3" data-aos="fade-up">
                                        <label for="fullName" class="visually-hidden">@lang('system.full_name')</label>

                                        <input type="text"
                                               class="form-control"
                                               name="name"
                                               value="{{ old('name') }}"
                                               id="fullName"
                                               placeholder="@lang('system.full_name')" />

                                        @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <!-- // form -->
                                    <!-- form -->
                                    <div class="mb-3" data-aos="fade-up">
                                        <label for="phoneNumber" class="visually-hidden">@lang('system.phone')</label>

                                        <input type="tel"
                                               class="form-control"
                                               name="phone"
                                               value="{{ old('phone') }}"
                                               id="phoneNumber"
                                               placeholder="@lang('system.phone')" />

                                        @error('phone')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <!-- // form -->
                                </div>
                                <div class="col-lg-6">
                                    <!-- message -->
                                    <div class="mb-3" data-aos="fade-up">
                                        <label for="message" class="visually-hidden">@lang('system.message')</label>

                                        <textarea class="form-control"
                                                  name="message"
                                                  id="message"
                                                  placeholder="@lang('system.message')">{{ old('message') }}</textarea>

                                        @error('message')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <!-- // message -->
                                    <button class="btn btn-brand-gradient" data-aos="fade-up">@lang('system.send_your_message')</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- // block -->
                </form>
            </div>
        </section>
    </div>
    <!-- END :: page content -->
@stop

@push('js')
    <script>
        $(document).on('click', '.form-check-label', function() {
            $('.form-check-label').removeClass("checked");

            $(this).addClass('checked');
        });
    </script>
@endpush
