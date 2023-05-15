@extends('frontend.layouts.master')

@section('meta')
    {!! $settings['advices_page_seo'][app()->getLocale() == 'en'  ?  'en' : 'ar'] ?? '' !!}
@stop

@section('title', __('system.joele_studio') . ' | ' . ( $settings['website_name'][app()->getLocale() == 'en'  ?  'en' : 'ar'] ?? '' ))

@push('styles')
    <link rel="stylesheet" href="{{ asset('frontend/css/lectures' . ( app()->getLocale() == 'en' ? '.min.css' : '-rtl.min.css') ) }}" crossorigin="anonymous" />
@endpush

@push('lang')

@include('frontend.components.lang_url.lang', request()->get('category') != null ? ['path' => '/lectures'.'?category='.request()->get('category')] : ['path' => '/lectures'])

@endpush

@section('schema_code')
{!! $settings['lectures_page_schema'] ?? '' !!}
@stop

@section('content')
    <!-- BEGIN :: page header section -->
    <div class="page-header">
        <!-- image -->
        <div class="page-header__image" data-aos="zoom-out">
            <picture>
                <source srcset="{{ asset('frontend/images/page-header.webp') }}" type="image/webp" />
                <img src="{{ asset('frontend/images/page-header.png') }}" draggable="false" alt="@lang('system.joele_studio')" />
            </picture>
        </div>
        <!-- // image -->
        <div class="page-header__text">
            <div class="container">
                <h2 data-aos="fade-up">@lang('system.joele_studio')</h2>
                <!-- breadcrumb -->
                <nav aria-label="breadcrumb" data-aos="fade-up" data-aos-delay="50">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('web.home.index') }}">@lang('system.home')</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('system.joele_studio')</li>
                    </ol>
                </nav>
                <!-- // breadcrumb -->
            </div>
        </div>
    </div>
    <!-- END ::  page header section -->

    <!-- page content -->
    <div class="wrapper">
        <section class="lectures-page d-pad">
            <div class="container">
                <!-- title -->
                <div class="section-title" data-aos="fade-up">
                    <h2>@lang('system.joele_studio')</h2>
                </div>
                <!-- // title -->
                <div class="row">
                    <div class="col-lg-6"></div>
                    <!-- filters -->
                    <div class="col-lg-6">
                        <form id="filter_form">
                            <div class="filters" data-aos="fade-up">
                                <a class="btn {{ !request()->category ? 'btn-brand-gradient' : 'btn-white' }} d-none" href="{{ route('web.lectures.index') }}">@lang('system.joele_studio')</a>

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
                        </form>
                    </div>
                    <!-- // filters -->
                    <!-- lectures -->
                    <div class="col-lg-12">
                        <div class="lectures-container">
                            <div class="row">
                                @foreach($lectures as $lecture)
                                    <div class="col-lg-3">
                                        <div data-aos="fade-up">
                                            <a class="lecture__card card" href="#" data-bs-toggle="modal" data-bs-target="#lectureModal" data-link="{{ $lecture->link }}">
                                                <div class="lecture__card-image">
                                                    <picture>
                                                        <source srcset="{{ $lecture->lecture_image }}" type="image/webp">
                                                        <img loading="lazy" src="{{ $lecture->lecture_image }}" alt="alt">
                                                    </picture>
                                                </div>
                                                <div class="lecture__card-info">
                                                    <h3 class="h5">{{ $lecture->translate(app()->getLocale())->title }}</h3>
                                                    <small class="color">{{ $lecture->category->translate(app()->getLocale())->name }}</small>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                @endforeach

                                <!-- pagination -->
                                <div class="col-lg-12">
                                    <div class="pagination__container" data-aos="fade-up">
                                        <ul class="pagination">
                                            {{ $lectures->appends(['category' => request()->get('category')])->links('frontend.home.pagination') }}
                                        </ul>
                                    </div>
                                </div>
                                <!-- // pagination -->
                            </div>
                        </div>
                    </div>
                    <!-- // lectures -->
                </div>
            </div>
        </section>
    </div>
    <!-- // page content -->

    <!-- BEGIN :: lecture modal -->
    <div class="lecture-overlay" id="lectureOverlay">
        <div class="modal fade" id="lectureModal" tabindex="-1" aria-labelledby="lectureModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content card p-0" id="lectureModalLabel">
                    <!-- close btn -->
                    <button type="button" class="btn btn-transparent" data-bs-dismiss="modal">
                        <picture>
                            <source srcset="{{ asset('frontend/images/icons/icons.svg#close') }}" type="image/webp" />
                            <img class="icon" src="{{ asset('frontend/images/icons/icons.svg#close') }}" draggable="false" alt="close" />
                        </picture>
                    </button>
                    <!-- // close btn -->
                    <!-- video -->
                    <!--<video controls>
                        <source src="http://127.0.0.1:8000/frontend/videos/video.mp4" id="video_source_element" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>-->
                    <!-- // video -->
                    <!-- youtube -->
                    <iframe src=""
                            title="YouTube video player" frameborder="0"
                            id="video_source_element"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    <!-- // youtube -->
                </div>
            </div>
        </div>
    </div>
    <!-- END :: lecture modal -->
@stop

@push('js')
    <script>
        var videoElement = $('#video_source_element');

        $(document).on('click', '.lecture__card', function() {
            videoElement.attr('src', $(this).data('link'));
        });
        $('#lectureModal').on('hidden.bs.modal', function () {
            var tempSrc = videoElement.attr("src");
            videoElement.attr("src", tempSrc);
        });
    </script>
@endpush
