<!DOCTYPE html>
<html dir="{{ app()->getLocale() == 'en' ? 'ltr' : 'rtl' }}" lang="{{ app()->getLocale() == 'en' ? 'en' : 'ar' }}">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- preloads -->
    <link rel="preload" href="{{ asset('frontend/fonts/' . ( app()->getLocale() == 'en' ? 'joele-en-regular.woff' : 'joele-ar-regular.woff' ) ) }}" as="font" type="font/woff" crossorigin>
    <link rel="preload" href="{{ asset('frontend/fonts/' . ( app()->getLocale() == 'en' ? 'joele-en-regular.woff2' : 'joele-ar-regular.woff2' ) ) }}" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="{{ asset('frontend/fonts/' . ( app()->getLocale() == 'en' ? 'joele-en-medium.woff' : 'joele-ar-medium.woff' ) ) }}" as="font" type="font/woff" crossorigin>
    <link rel="preload" href="{{ asset('frontend/fonts/' . ( app()->getLocale() == 'en' ? 'joele-en-medium.woff2' : 'joele-ar-medium.woff2' ) ) }}" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="{{ asset('frontend/fonts/' . ( app()->getLocale() == 'en' ? 'joele-en-bold.woff' : 'joele-ar-bold.woff' ) ) }}" as="font" type="font/woff" crossorigin>
    <link rel="preload" href="{{ asset('frontend/fonts/' . ( app()->getLocale() == 'en' ? 'joele-en-bold.woff2' : 'joele-ar-bold.woff2' ) ) }}" as="font" type="font/woff2" crossorigin>

    <!-- favicons -->
    <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('frontend/images/favicons/apple-icon-57x57.png') }}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('frontend/images/favicons/apple-icon-60x60.png') }}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('frontend/images/favicons/apple-icon-72x72.png') }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('frontend/images/favicons/apple-icon-76x76.png') }}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('frontend/images/favicons/apple-icon-114x114.png') }}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('frontend/images/favicons/apple-icon-120x120.png') }}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('frontend/images/favicons/apple-icon-144x144.png') }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('frontend/images/favicons/apple-icon-152x152.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('frontend/images/favicons/apple-icon-180x180.png') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('frontend/images/favicons/android-icon-192x192.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('frontend/images/favicons/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('frontend/images/favicons/favicon-96x96.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('frontend/images/favicons/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('frontend/images/favicons/manifest.json') }}">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="assets/images/favicons/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <!-- css -->
    <link rel="stylesheet" href="{{ asset('frontend/css/' . ( app()->getLocale() == 'en' ? 'main.min.css' : 'main-rtl.min.css' ) ) }}" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lazysizes/5.3.2/lazysizes.min.js" integrity="sha512-q583ppKrCRc7N5O0n2nzUiJ+suUv7Et1JGels4bXOaMFQcamPk9HjdUknZuuFjBNs7tsMuadge5k9RzdmO+1GQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />

    @stack('styles')



    <title>@yield('title')</title>

    @yield('meta')

    @yield('schema_code')

</head>

<body id="top">
<!-- BEGIN :: search modal -->
<div class="search-overlay" id="searchOverlay">
    <div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content card">
                <!-- close btn -->
                <button type="button" class="btn btn-transparent" data-bs-dismiss="modal">
                    <picture>
                        <source srcset="{{ asset('frontend/images/icons/icons.svg#close') }}" type="image/webp">
                        <img class="icon" src="{{ asset('frontend/images/icons/icons.svg#close') }}" draggable="false" alt="close">
                    </picture>
                </button>
                <!-- // close btn -->
                <div class="modal-header justify-content-center">
                    <h2 class="modal-title h3" id="searchModalLabel">@lang('system.search')</h2>
                </div>
                <div class="modal-body">
                    <form method="GET" action="{{ route('web.home.search') }}">
                        <div class="row">
                            <div class="col-lg-8">
                                <label for="searchInput" class="visually-hidden">@lang('system.search')</label>

                                <input type="search"
                                       name="keyword"
                                       class="form-control"
                                       id="searchInput"
                                       placeholder="@lang('system.are_you_looking_for_doctor_service_or_anything')">
                            </div>

                            <div class="col-lg-4">
                                <button class="btn btn-brand-gradient w-100">@lang('system.search')</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END :: search modal -->

<!-- BEGIN :: header section -->
<header class="header">
    <!-- BEGIN :: top bar section -->
    <div class="top-bar" data-aos="fade-down">
        <div class="container d-flex">
            <!-- BEGIN :: control language -->
            @stack('lang')
            <!-- END :: control language -->

            <!-- BEGIN :: header contact -->
            <div class="top-bar__block contact d-flex">
                <!-- phone -->
                <a class="top-bar__link" href="tel:{{ $settings['phone'] ?? '' }}"> <span class="top-bar__link-icon">
                    <picture>
                        <source srcset="{{ asset('frontend/images/icons/icons.svg#phone') }}" type="image/webp" />
                        <img class="icon" src="{{ asset('frontend/images/icons/icons.svg#phone') }}" alt="Phone Icon" />
                    </picture>
                    </span> <span class="top-bar__link-text">{{ $settings['phone'] ?? '' }}</span>
                </a>
                <!-- // phone -->

                <!-- mail -->
                <a class="top-bar__link" href="mailto:{{ $settings['email'] ?? '' }}"> <span class="top-bar__link-icon">
                    <picture>
                        <source srcset="{{ asset('frontend/images/icons/icons.svg#mail') }}" type="image/webp" />
                        <img class="icon" src="{{ asset('frontend/images/icons/icons.svg#mail') }}" alt="Email Icon" />
                    </picture>
                    </span> <span class="top-bar__link-text">{{ $settings['email'] ?? '' }}</span>
                </a>
                <!-- // mail -->
            </div>
            <!-- END :: header contact -->

            <!-- BEGIN :: social contact -->
            <div class="top-bar__block social d-flex">

                @if(isset($settings['facebook']))
                    <!-- social link -->
                    <a class="top-bar__link" href="{{ $settings['facebook'] ?? 'javascript:void(0)' }}" target="_blank">
                        <span class="top-bar__link-icon">
                            <picture>
                                <source srcset="{{ asset('frontend/images/icons/icons.svg#facebook') }}" type="image/webp">
                                <img class="icon" src="{{ asset('frontend/images/icons/icons.svg#facebook') }}" alt="Facebook Icon">
                            </picture>
                        </span>
                    </a> <!-- // social link -->
                @endif

                @if(isset($settings['twitter']))
                    <!-- social link -->
                    <a class="top-bar__link" href="{{ $settings['twitter'] ?? 'javascript:void(0)' }}" target="_blank">
                        <span class="top-bar__link-icon">
                            <picture>
                                <source srcset="{{ asset('frontend/images/icons/icons.svg#twitter') }}" type="image/webp">
                                <img class="icon" src="{{ asset('frontend/images/icons/icons.svg#twitter') }}" alt="Twitter Icon">
                            </picture>
                        </span>
                    </a>
                    <!-- // social link -->
                @endif

                @if(isset($settings['instagram']))
                    <!-- social link -->
                    <a class="top-bar__link" href="{{ $settings['instagram'] ?? 'javascript:void(0)' }}" target="_blank">
                        <span class="top-bar__link-icon">
                            <picture>
                                <source srcset="{{ asset('frontend/images/icons/icons.svg#instagram') }}" type="image/webp">
                                <img class="icon" src="{{ asset('frontend/images/icons/icons.svg#instagram') }}" alt="Instagram Icon">
                            </picture>
                        </span>
                    </a>
                    <!-- // social link -->
                @endif

                @if(isset($settings['youtube']))
                    <!-- social link -->
                    <a class="top-bar__link" href="{{ $settings['youtube'] ?? 'javascript:void(0)' }}" target="_blank">
                        <span class="top-bar__link-icon">
                            <picture>
                                <source srcset="{{ asset('frontend/images/icons/icons.svg#youtube') }}" type="image/webp">
                                <img class="icon" src="{{ asset('frontend/images/icons/icons.svg#youtube') }}" alt="YouTube Icon">
                            </picture>
                        </span>
                    </a>
                    <!-- // social link -->
                @endif

                @if(isset($settings['whatsapp']))
                    <!-- social link -->
                    <a class="top-bar__link" href="{{ $settings['whatsapp'] ?? 'javascript:void(0)' }}" target="_blank">
                        <span class="top-bar__link-icon">
                            <picture>
                                <source srcset="{{ asset('frontend/images/icons/icons.svg#whatsapp') }}" type="image/webp">
                                <img class="icon" src="{{ asset('frontend/images/icons/icons.svg#whatsapp') }}" alt="WhatsApp Icon">
                            </picture>
                        </span>
                    </a>
                @endif
                <!-- // social link -->

                @if(isset($settings['snapchat']))
                    <!-- social link -->
                    <a class="top-bar__link" href="{{ $settings['snapchat'] ?? 'javascript:void(0)' }}" target="_blank">
                        <span class="top-bar__link-icon">
                            <picture>
                                <source srcset="{{ asset('frontend/images/icons/icons.svg#snapchat') }}" type="image/webp">
                                <img class="icon" src="{{ asset('frontend/images/icons/icons.svg#snapchat') }}" alt="Snapchat Icon">
                            </picture>
                        </span>
                    </a>
                    <!-- // social link -->
                @endif
            </div>
            <!-- END :: social  contact -->
        </div>
    </div>
    <!-- END :: top bar section -->

    <!-- BEGIN :: navbar -->
    <nav class="navbar navbar-expand-lg" data-aos="fade-up">
        <div class="container">
            <!-- BEGIN :: logo -->
            <a class="navbar-brand" href="{{ route('web.home.index') }}">
                <picture>
                    <source srcset="{{ asset('frontend/images/logo.svg') }}" type="image/webp" />
                    <img src="{{ asset('frontend/images/logo.svg') }}" alt="Joele Clinic Logo" />
                </picture>
            </a>
            <!-- END :: logo -->

            <!-- mobile buttons -->
            <div class="navbar-icons">
                <button class="btn btn-search d-lg-none" data-bs-toggle="modal" data-bs-target="#searchModal">
                    <picture>
                        <source srcset="{{ asset('frontend/images/icons/icons.svg#search') }}" type="image/webp" />
                        <img class="icon" src="{{ asset('frontend/images/icons/icons.svg#search') }}" alt="Search" />
                    </picture>
                </button>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#joeleNavbar" aria-controls="joeleNavbar" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
            <!-- // mobile buttons -->

            <div class="collapse navbar-collapse" id="joeleNavbar">
                <ul class="navbar-nav mx-auto">
                    <!-- item -->
                    <li class="nav-item"> <a class="nav-link {{ Route::currentRouteName() == 'web.home.index' ? 'active' : '' }}" aria-current="page" href="{{ route('web.home.index') }}">@lang('system.home')</a> </li>
                    <!-- // item -->

                    <!-- item -->
                    <li class="nav-item dropdown"> <a class="nav-link dropdown-toggle" href="javascript:void(0)" role="button" data-bs-toggle="dropdown" aria-expanded="false"> @lang('system.about') </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('web.about-us') }}">@lang('system.our_story')</a></li>
                            <!--<li><a class="dropdown-item" href="{{ route('web.insurance-companies.index') }}">@lang('system.insurance_companies')</a></li>-->
                            <li><a class="dropdown-item" href="{{  route('web.frequently-questions.index') }}">@lang('system.frequently_asked_questions')</a></li>
                            <li><a class="dropdown-item" href="{{ route('web.terms-condition') }}">@lang('system.terms_conditions')</a></li>
                        </ul>
                    </li>
                    <!-- // item -->

                    <!-- item -->
                    <li class="nav-item dropdown"> <a class="nav-link dropdown-toggle" href="javascript:void(0)" role="button" data-bs-toggle="dropdown" aria-expanded="false"> @lang('system.services') </a>
                        <ul class="dropdown-menu">
{{--                            <li><a class="dropdown-item" href="{{ route('web.services.index') }}">@lang('system.all_services')</a></li>--}}
                            @foreach($categoriesHead as $cat)
                                <li><a class="dropdown-item" href="{{ route('web.services.list', ['slug' => $cat->slug ]) }}">@lang('system.service') {{ $cat->name ?? ''}}</a></li>
                            @endforeach
                        </ul>
                    </li>
                    <!-- // item -->

                    <!-- item -->
                    <li class="nav-item dropdown"> <a class="nav-link dropdown-toggle" href="javascript:void(0)" role="button" data-bs-toggle="dropdown" aria-expanded="false"> @lang('system.our_doctors') </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('web.doctors.index') }}">@lang('system.all_doctors')</a></li>
                            <li><a class="dropdown-item" href="{{ route('web.cases.index') }}">@lang('system.before_and_after')</a></li>
                        </ul>
                    </li>
                    <!-- // item -->

                    <!-- item -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="javascript:void(0)" role="button" data-bs-toggle="dropdown" aria-expanded="false"> @lang('system.medical_blog') </a>
                        <ul class="dropdown-menu">
{{--                            <li><a class="dropdown-item" href="{{ route('web.blogs.index') }}">@lang('system.blogs_and_articles')</a></li>--}}
                            @foreach($blogCategories as $blogCategory)
                                <li>
                                    <a class="dropdown-item" href="{{ route('web.blogs.index', ['category' => $blogCategory->id]) }}">
                                        {{ $blogCategory->translate(app()->getLocale())->name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                    <!-- // item -->

                    <!-- item -->
                    <li class="nav-item dropdown"> <a class="nav-link dropdown-toggle" href="javascript:void(0)" role="button" data-bs-toggle="dropdown" aria-expanded="false"> @lang('system.joele_studio') </a>
                        <ul class="dropdown-menu">
                            {{--<li><a class="dropdown-item" href="{{ route('web.lectures.index') }}">@lang('system.display_all')</a></li>--}}
                            @foreach($lectureCategories as $lectureCategory)
                                <li>
                                    <a class="dropdown-item" href="{{ route('web.lectures.index', ['category' => $lectureCategory->id]) }}">
                                        {{ $lectureCategory->translate(app()->getLocale())->name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                    <!-- // item -->

                    <!-- item -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="javascript:void(0)" role="button" data-bs-toggle="dropdown" aria-expanded="false"> @lang('system.call_us') </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('web.branches.index') }}">@lang('system.branches')</a></li>
                            <li><a class="dropdown-item" href="{{ route('web.reviews.create') }}">@lang('system.send_us_your_review')</a></li>
                            <li><a class="dropdown-item" href="{{ route('contact-us.index') }}">@lang('system.contact_us')</a></li>
                        </ul>
                    </li>
                    <!-- // item -->

                    <!-- item -->
                    <li class="nav-item dropdown">
                        <button class="btn btn-search d-none d-lg-block" data-bs-toggle="modal" data-bs-target="#searchModal">
                            <picture>
                                <source srcset="{{ asset('frontend/images/icons/icons.svg#search') }}" type="image/webp">
                                <img class="icon" src="{{ asset('frontend/images/icons/icons.svg#search') }}" alt="Search">
                            </picture>
                        </button>
                    </li> <!-- // item -->
                </ul>
                <div class="navbar-nav ms-auto">
                    <a href="{{ route('web.offers.index') }}" class="btn btn-white"> @lang('system.latest_offers') </a>
                    <a href="{{ route('web.booking.index') }}" class="btn btn-brand-gradient"> @lang('system.book_now') </a>
                </div>
            </div>
        </div>
    </nav>
    <!-- END :: navbar -->
</header>
<!-- END :: header section -->

@yield('content')

<!-- whatsapp -->
@if( isset($settings['whatsapp']) )
    <a class="whatsapp__logo" href="{{ $settings['whatsapp'] ?? 'javascript:void(0)' }}"  target="_blank">
        <picture>
            <source srcset="{{ asset('frontend/images/WhatsApp_icon.png') }}" type="image/webp"/>
            <img src="{{ asset('frontend/images/WhatsApp_icon.png') }}" alt="Whatsapp Logo" />
        </picture>
    </a>
@endif
<!-- // whatsapp -->

<!-- book now -->
<a href="{{ route('web.booking.index') }}" class="btn btn-brand-gradient book_now_sticky"> @lang('system.book_now') </a>
<!-- // book now -->

<!-- footer -->
<footer class="footer" data-aos="fade-up">
    <div class="container">
        <a href="#top" class="btn-top">
            <picture>
                <source srcset="{{ asset('frontend/images/icons/icons.svg#top') }}" type="image/webp">
                <img class="icon" src="{{ asset('frontend/images/icons/icons.svg#top') }}" draggable="false" alt="top">
            </picture>
        </a>
        <div class="row">
            <!-- logo -->
            <div class="col-lg-12">
                <!-- logo -->
                <div class="footer__logo">
                    <picture>
                        <source srcset="{{ asset('frontend/images/logo-white.svg') }}" type="image/webp" />
                        <img src="{{ asset('frontend/images/logo-white.svg') }}" alt="Joele logo" />
                    </picture>
                </div>
                <!-- // logo -->
            </div>
            <!-- // logo -->

            <!-- about -->
            <div class="col-lg-4">
                <div class="footer__block">
                    {{--<h3 class="h5">@lang('system.about')</h3>--}}
                    <p>{{ $settings['about_us_content'][app()->getLocale() == 'en'  ?  'en' : 'ar'] ?? '' }}</p>
                    <div class="footer__pay">
                        <picture>
                            <source srcset="{{ asset('frontend/images/icons/mastercard.webp') }}" type="image/webp">
                            <img src="{{ asset('frontend/images/icons/mastercard.png') }}" alt="mastercard">
                        </picture>
                        <picture>
                            <source srcset="{{ asset('frontend/images/icons/visa.webp') }}" type="image/webp">
                            <img src="{{ asset('frontend/images/icons/visa.png') }}" alt="visa">
                        </picture>
                        <picture>
                            <source srcset="{{ asset('frontend/images/icons/mada.webp') }}" type="image/webp">
                            <img src="{{ asset('frontend/images/icons/mada.png') }}" alt="visa">
                        </picture>
                        <picture>
                            <source srcset="{{ asset('frontend/images/icons/tabby.webp') }}" type="image/webp">
                            <img src="{{ asset('frontend/images/icons/tabby.png') }}" alt="visa">
                        </picture>
                        <picture>
                            <source srcset="{{ asset('frontend/images/icons/tamara.webp') }}" type="image/webp">
                            <img src="{{ asset('frontend/images/icons/tamara.png') }}" alt="visa">
                        </picture>
                    </div>
                </div>
            </div>
            <!-- // about -->

            <!-- quick access -->
            <div class="col-lg-4">
                <div class="footer__block">
                    <h3 class="h5">@lang('system.quick_access')</h3>
                    <ul class="list-unstyled footer__block-links">
                        <li><a href="{{ url('/') }}">@lang('system.home')</a></li>
                        <li><a href="{{  route('web.frequently-questions.index') }}">@lang('system.frequently_asked_questions')</a></li>
                        <li><a href="{{ route('web.about-us') }}">@lang('system.about')</a></li>
                        <li><a href="{{ route('web.terms-condition') }}">@lang('system.terms_conditions')</a></li>
                        <li><a href="{{ route('web.services.index') }}">@lang('system.services')</a></li>
                        <li><a href="{{ route('web.branches.index') }}">@lang('system.branches')</a></li>
                        <li><a href="{{ route('web.doctors.index') }}">@lang('system.our_doctors')</a></li>
                        <li><a href="{{ route('contact-us.index') }}">@lang('system.contact_us')</a></li>
                        <li><a href="{{ route('web.blogs.index') }}">@lang('system.medical_blog')</a></li>
                        <li><a href="#!"></a></li>
                        <li><a href="{{ route('web.offers.index') }}">@lang('system.latest_offers')</a></li>
                    </ul>
                </div>
            </div>
            <!-- // quick access -->

            <!-- quick access -->
            <div class="col-lg-4">
                <section id="register_form">
                    <div class="footer__block">
                        <h3 class="h5">@lang('system.our_latest_news_and_offers')</h3>
                        <p>@lang('system.subscribe_now_to_get_our_latest_news_offers')</p>
                        <form class="row" method="post" action="{{ route('web.subscription-form.index', '?#register_form') }}">
                            @csrf

                            <div class="footer__newsletter d-flex flex-wrap">
                                <label for="phoneNumber" class="visually-hidden">@lang('system.phone_number')</label>

                                <input type="tel"
                                       name="phone"
                                       class="form-control"
                                       id="phoneNumber"
                                       placeholder="@lang('system.phone_number')" />

                                <button type="submit" class="btn btn-brand-gradient">@lang('system.subscribe_now')</button>
                            </div>

                            @error('phone')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </form>
                    </div>
                </section>
                <div class="footer__logo">
                    <!-- social -->
                    <div class="footer__block social">
                        @if( isset($settings['facebook']) )
                        <!-- social link -->
                        <a class="footer__link" href="{{ $settings['facebook'] ?? 'javascript:void(0)' }}">
                            <span class="footer__link-icon">
                                <picture>
                                    <source srcset="{{ asset('frontend/images/icons/icons.svg#facebook') }}" type="image/webp" />
                                    <img class="icon" src="{{ asset('frontend/images/icons/icons.svg#facebook') }}" alt="Facebook Icon" />
                                </picture>
                            </span>
                        </a>
                        <!-- // social link -->
                        @endif

                        @if( isset($settings['twitter']) )
                            <!-- social link -->
                            <a class="footer__link" href="{{ $settings['twitter'] ?? 'javascript:void(0)' }}">
                                <span class="footer__link-icon">
                                    <picture>
                                        <source srcset="{{ asset('frontend/images/icons/icons.svg#twitter') }}" type="image/webp" />
                                        <img class="icon" src="{{ asset('frontend/images/icons/icons.svg#twitter') }}" alt="Twitter Icon" />
                                    </picture>
                                </span>
                            </a>
                            <!-- // social link -->
                        @endif

                        @if( isset($settings['instagram']) )
                            <!-- social link -->
                            <a class="footer__link" href="{{ $settings['instagram'] ?? 'javascript:void(0)' }}">
                                <span class="footer__link-icon">
                                    <picture>
                                        <source srcset="{{ asset('frontend/images/icons/icons.svg#instagram') }}" type="image/webp">
                                        <img class="icon" src="{{ asset('frontend/images/icons/icons.svg#instagram') }}" alt="Instagram Icon">
                                    </picture>
                                </span>
                            </a>
                            <!-- // social link -->
                        @endif

                        @if( isset($settings['youtube']) )
                            <!-- social link -->
                            <a class="footer__link" href="{{ $settings['youtube'] ?? 'javascript:void(0)' }}">
                                <span class="footer__link-icon">
                                    <picture>
                                        <source srcset="{{ asset('frontend/images/icons/icons.svg#youtube') }}" type="image/webp">
                                        <img class="icon" src="{{ asset('frontend/images/icons/icons.svg#youtube') }}" alt="YouTube Icon">
                                    </picture>
                                </span>
                            </a>
                            <!-- // social link -->
                        @endif

                        @if( isset($settings['whatsapp']) )
                            <!-- social link -->
                            <a class="footer__link" href="{{ $settings['whatsapp'] ?? 'javascript:void(0)' }}">
                                <span class="footer__link-icon">
                                    <picture>
                                        <source srcset="{{ asset('frontend/images/icons/icons.svg#whatsapp') }}" type="image/webp">
                                        <img class="icon" src="{{ asset('frontend/images/icons/icons.svg#whatsapp') }}" alt="WhatsApp Icon">
                                    </picture>
                                </span>
                            </a>
                            <!-- // social link -->
                        @endif

                        @if( isset($settings['snapchat']) )
                            <!-- social link -->
                            <a class="footer__link" href="{{ $settings['snapchat'] ?? 'javascript:void(0)' }}">
                                <span class="footer__link-icon">
                                    <picture>
                                        <source srcset="{{ asset('frontend/images/icons/icons.svg#snapchat') }}" type="image/webp">
                                        <img class="icon" src="{{ asset('frontend/images/icons/icons.svg#snapchat') }}" alt="Snapchat Icon">
                                    </picture>
                                </span>
                            </a>
                            <!-- // social link -->
                        @endif
                    </div>
                    <!-- // social -->
                </div>
            </div>
            <!-- // quick access -->

            <!-- copyrights -->
            <div class="col-lg-12">
                <div class="footer__copyrights text-center">
                    <small>{!! $settings['copyright'][app()->getLocale() == 'en'  ?  'en' : 'ar'] ?? '' !!}</small>
                    <div class="my-2 text-center">
                        <small class="mx-1">@lang('system.powered_by')</small>
                        <a href="https://jumppeak.net/" target="_blank" alt="jumppeak website">
                            <picture>
                                <source srcset="{{ asset('frontend/images/icons/jumppeak-logo.svg') }}" type="image/svg">
                                <img src="{{ asset('frontend/images/icons/jumppeak-logo.svg') }}" alt="Jumppeak">
                            </picture>
                        </a>
                    </div>
                </div>
            </div> <!-- // copyrights -->

            <!-- scroll to top -->
            <div class="top-btn-container">
                <a href="#top" class="top">
                    <svg xmlns="http://www.w3.org/2000/svg" width="11.643" height="7.52" viewBox="0 0 11.643 7.52">
                        <path id="Icon_awesome-angle-down" data-name="Icon awesome-angle-down"
                                d="M5.2,11l-4.95,4.95a.87.87,0,0,0,0,1.234L1.076,18a.87.87,0,0,0,1.234,0l3.509-3.509L9.327,18a.87.87,0,0,0,1.234,0l.823-.823a.87.87,0,0,0,0-1.234L6.433,11A.866.866,0,0,0,5.2,11Z"
                                transform="translate(0.004 -10.74)" fill="#7c8494" />
                    </svg>
                    <span class="overline m-0">@lang('system.TOP')</span>
                </a>
            </div>
            <!-- scroll to top -->
        </div>
    </div>
</footer>
<!-- // footer -->

<script src="{{ asset('frontend/js/main.min.js') }}"></script>

@stack('js')

@routes

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js?ver=1.1"></script>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css?ver=1.1">

@if(Session::has('success'))
    @if(app()->getLocale() == 'en')
       <script>
            toastr.options.positionClass = 'toast-top-left';
            toastr.success("{{ Session::get('success') }}");
        </script>
    @else

        <script>
            toastr.options.positionClass = 'toast-top-right';
            toastr.success("{{ Session::get('success') }}");
        </script>
    @endif

@elseif(Session::has('error'))
    @if(app()->getLocale() == 'en')
        <script>
            toastr.options.positionClass = 'toast-top-left';
            toastr.error("{{ Session::get('error') }}");
        </script>
    @else
        <script>
            toastr.options.positionClass = 'toast-top-right';
            toastr.error("{{ Session::get('error') }}");
        </script>
    @endif
@endif
</body>
</html>
