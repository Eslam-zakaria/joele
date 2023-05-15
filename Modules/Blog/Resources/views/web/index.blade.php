@extends('frontend.layouts.master')

@section('meta')
    {!! $settings['blogs_page_seo'][app()->getLocale() == 'en'  ?  'en' : 'ar'] ?? '' !!}
@stop

@section('title', __('system.medical_blog'))

@push('styles')
    <link rel="stylesheet" href="{{ asset('frontend/css/' . ( app()->getLocale() == 'en' ? 'articles.min.css' : 'articles-rtl.min.css' ) ) }}" crossorigin="anonymous">
@endpush

@push('lang')
    @include('frontend.components.lang_url.lang', request()->get('category') != null ? ['path' => '/blogs'.'?category='.request()->get('category')] : ['path' => '/blogs'])
@endpush

@section('schema_code')
    {!! $settings['blogs_page_schema'] ?? '' !!}
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
                <h2 data-aos="fade-up">@lang('system.medical_blog')</h2>
                <!-- breadcrumb -->
                <nav aria-label="breadcrumb" data-aos="fade-up" data-aos-delay="50">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('web.home.index') }}">@lang('system.home')</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('system.medical_blog')</li>
                    </ol>
                </nav>
                <!-- // breadcrumb -->
            </div>
        </div>
    </div>
    <!-- // page header -->

    <!-- wrapper -->
    <div class="wrapper">

        <!-- articles -->
        <section class="articles-page d-pad">
            <div class="container">
                <!-- title -->
                <div class="section-title" data-aos="fade-up">
                    <h2>@lang('system.medical_blog')</h2>
                </div>
                <!-- // title -->
                <form action="" id="filter_form">
                    <div class="row">
                        <div class="col-lg-6">
                            <p data-aos="fade-up" data-aos-delay="50">{{ $settings['articles_content'][app()->getLocale() == 'en'  ?  'en' : 'ar'] ?? '' }}</p>
                        </div>
                        <!-- filters -->
                        <div class="col-lg-6">
                            <div class="filters" data-aos="fade-up">
                                <!-- filter -->
                                <a class="btn {{ !request()->category ? 'btn-brand-gradient' : 'btn-white' }} d-none" href="{{ route('web.blogs.index') }}">@lang('system.blogs')</a>
                                <!-- // filter -->
                                @foreach($categories as $key => $category)
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input"
                                               type="radio"
                                               name="category"
                                               id="category_{{ $key }}"
                                               value="{{ $category->id }}"
                                               onclick="document.getElementById('filter_form').submit();" />

                                        <label class="form-check-label {{ $category->id == request()->category ? 'checked' : '' }}" for="category_{{ $key }}">
                                            {{ $category->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <!-- // filters -->
                    </div>
                </form>

                <div class="row">
                    <!-- articles -->
                    @if(count($blogs) > 0)
                    <div class="col-lg-12">
                         <!-- article cover slider -->
                        <div class="article__cover-slider article__cover-container" data-aos="fade-up">
                            <div class="swiper articleCoverSlider">
                                <div class="swiper-wrapper">
                                    @foreach($blogs->slice(0, 3) as $blog)
                                        <div class="swiper-slide">
                                            <a href="{{ route('web.blog.show', $blog->slug) }}">
                                            <picture>
                                                <source class="swiper-lazy lazyload" srcset="{{ $blog->blog_image }}" type="image/webp">
                                                <img class="swiper-lazy lazyload" src="{{ asset('frontend/images/placeholder.svg') }}" data-src="{{ $blog->blog_image }}" alt="alt">
                                            </picture>
                                            <div class="swiper-lazy-preloader"></div>
                                            <div class="slider__slide-text">
                                                <div class="article__card-text">
                                                    <span class="color">{{ $blog->category->name }}</span>
                                                    <h3 class="h5">{{ $blog->title }}</h3>
                                                    <small class="article__card-text_sub">{{ $blog->created_at->diffForHumans() }}</small>
                                                </div>
                                            </div>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="swiper-pagination articleCover-pagination"></div>
                                <div class="slider-controls">
                                    <div class="swiper-button-next articleCover-next"></div>
                                    <div class="swiper-button-prev articleCover-prev"></div>
                                </div>
                            </div>
                        </div>
                        <!-- // slider -->
                    </div>
                    <div class="col-lg-12">
                        <div class="articles-container">
                            <div class="row">
                                @foreach($blogs as $blog)
                                    <!-- article card -->
                                    <div class="col-lg-6">
                                        <div data-aos="fade-up">
                                            <a class="article__card card" href="{{ route('web.blog.show', $blog->slug) }}">
                                                <div class="article__card-image">
                                                    <picture>
                                                        <source srcset="{{ $blog->blog_image }}" type="image/webp" />
                                                        <img loading="lazy" src="{{ $blog->blog_image }}" alt="{{ $blog->alt_image }}" />
                                                    </picture>
                                                </div>
                                                <div class="article__card-text">
                                                    <span class="color">{{ $blog->category->name }}</span>
                                                    <h3 class="h5">{{ $blog->title }}</h3>
                                                    <p class="article__card-text-content">{{ $blog->description ?? '' }}</p>
                                                    <div class="article__card-text_footer">
                                                        <small>{{ $blog->created_at->diffForHumans() }}</small>
                                                        <span class="btn btn-white article__card-text_btn">@lang('system.read_more')</span>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                    <!-- // article card -->
                                @endforeach

                                <!-- pagination -->
                                <div class="col-lg-12">
                                    <div class="pagination__container" data-aos="fade-up">
                                        <nav aria-label="Page navigation example">
                                            <ul class="pagination">
                                                {{ $blogs->appends(['category' => request()->get('category')])->links('frontend.home.pagination') }}
                                            </ul>
                                        </nav>
                                    </div>
                                </div>
                                <!-- // pagination -->
                            </div>
                        </div>
                    </div>

                    @else
                         <div class="col-lg-12">
                            <div class="row text-center" style="margin-top:90px">
                              <h2 class="text-danger">{{ app()->getLocale() == 'en'  ?  'There are currently no articles' : 'لا يوجد مقالات حالياً' }}</h3>
                            </div>
                         </div>
                    @endif
                    <!-- // articles -->
                </div>
            </div>
        </section>
        <!-- // articles -->
    </div>
    <!-- // wrapper -->
@stop
