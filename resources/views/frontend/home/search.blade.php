@extends('frontend.layouts.master')

@section('title', __('system.search_results_for') . ' ' . request()->keyword ?? '' )

@push('styles')
    <link rel="stylesheet" href="{{ asset('frontend/css/book' . ( app()->getLocale() == 'en' ? '.min.css' : '-rtl.min.css' )) }}" crossorigin="anonymous">
@endpush

@section('content')
    <!-- BEGIN :: page header -->
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
                <h2 data-aos="fade-up">@lang('system.search_results_for')   {{ request()->keyword }}</h2>
                <!-- breadcrumb -->
                <nav aria-label="breadcrumb" data-aos="fade-up" data-aos-delay="50">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">@lang('system.home')</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('system.search_results_for')   {{ request()->keyword }}</li>
                    </ol>
                </nav>
                <!-- // breadcrumb -->
            </div>
        </div>
    </div>
    <!-- END :: page header -->

    <!-- BEGIN :: search -->
    <div class="wrapper">
        <section class="search-result d-pad">
            <div class="container">
                <div id="list_articles">
                    <!-- section title -->
                    <div class="section-title" data-aos="fade-up">
                        <h2>@lang('system.search_results_for') @lang('system.blogs') ( <span class="articles_search_count"></span> ) </h2>
                    </div>
                    <!-- // section title -->
                    <div class="row" id="articles_section">
                        <div class="spinner" id="spinner_articles_section">
                            <div class="double-bounce1"></div>
                            <div class="double-bounce2"></div>
                        </div>
                    </div>

                    <div class="text-center mt-5 mb-5">
                        <button class="btn btn-brand-primary d-none"
                                id="btn_more_articles"
                                data-link="{{ route('api.blogs.index') }}">@lang('system.see_more')</button>
                    </div>
                </div>

                <div id="list_doctors">
                    <!-- section title -->
                    <div class="section-title" data-aos="fade-up">
                        <h2>@lang('system.search_results_for') @lang('system.doctors') ( <span class="doctors_search_count"></span> ) </h2>
                    </div>
                    <!-- // section title -->
                    <div class="row" id="doctors_section">
                        <div class="spinner" id="spinner_doctors_section">
                            <div class="double-bounce1"></div>
                            <div class="double-bounce2"></div>
                        </div>
                    </div>

                    <div class="text-center mt-5 mb-5">
                        <button class="btn btn-brand-primary d-none"
                                id="btn_more_doctors"
                                data-link="{{ route('api.doctors.get') }}">@lang('system.see_more')</button>
                    </div>
                </div>

                <div id="list_services">
                    <!-- section title -->
                    <div class="section-title" data-aos="fade-up">
                        <h2>@lang('system.search_results_for') @lang('system.services') ( <span class="services_search_count"></span> ) </h2>
                    </div>
                    <!-- // section title -->
                    <div class="row" id="services_section">
                        <div class="spinner" id="spinner_services_section">
                            <div class="double-bounce1"></div>
                            <div class="double-bounce2"></div>
                        </div>
                    </div>

                    <div class="text-center mt-5 mb-5">
                        <button class="btn btn-brand-primary d-none"
                                id="btn_more_services"
                                data-link="{{ route('api.services.index') }}">@lang('system.see_more')</button>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!-- END :: search -->
@stop

@push('js')
    <!-- BEGIN :: script for articles -->
    <script>
        $(window).on('load', function(){
            $('#spinner_articles_section').addClass('d-none')

            getArticles($('#btn_more_articles').data('link'))
        });

        $(document).on('click', '#btn_more_articles', function(){

            getArticles($('#btn_more_articles').data('link'))
        });

        function getArticles(url) {
            $.ajax({
                url: url,//url.replace(/^http:/, 'https:'),
                type: 'GET',
                data: {
                    'lang': '{{ app()->getLocale() }}',
                    'q': '{{ request()->keyword }}',
                    'status': '2'
                },
                success: function(response) {

                    if( response.total == 0 )
                        $('#list_articles').addClass('d-none')

                    $('.articles_search_count').text(response.total)

                    if( response.next_page_url != null ){
                        $('#btn_more_articles').removeClass('d-none')
                    }else{
                        $('#btn_more_articles').addClass('d-none')
                    }

                    $('#btn_more_articles').data('link', response.next_page_url);

                    $.each(response.data, function( index, value ) {

                        let $element =
                        '<div class="col-lg-3"> \n'+
                            '<a href="{{ url('/blog') }}/'+ value.slug +'" class="service__card" data-aos="fade-up"> \n'+
                                '<div class="service__card-image"> \n'+
                                    '<picture> \n'+
                                        '<source srcset="'+ value.blog_image +'" type="image/webp"> \n'+
                                        '<img src="'+ value.blog_image +'" draggable="false" loading="lazy" alt="blog"> \n'+
                                    '</picture> \n'+
                                '</div> \n'+
                                '<div class="search__result-text"> \n'+
                                    '<span class="color small">@lang('system.blogs')</span> \n'+
                                    '<h3 class="h6">'+ value.title +'</h3> \n'+
                                '</div> \n'+
                            '</a> \n'+
                        '</div>';

                        $('#articles_section').append($element);
                    });
                },
                error : function(request,error)
                {
                    alert("Request: "+JSON.stringify(request));
                }
            });        }
    </script>
    <!-- END :: script for articles -->

    <!-- BEGIN :: script for doctors -->
    <script>
        $(window).on('load', function(){
            $('#spinner_doctors_section').addClass('d-none')

            getDoctors($('#btn_more_doctors').data('link'))
        });

        $(document).on('click', '#btn_more_doctors', function(){

            getDoctors($('#btn_more_doctors').data('link'))
        });

        function getDoctors(url) {
            $.ajax({
                url: url,
                type: 'GET',
                data: {
                    'lang': '{{ app()->getLocale() }}',
                    'q': '{{ request()->keyword }}',
                    'status': '2'
                },
                success: function(response) {

                    if( response.total == 0 )
                        $('#list_doctors').addClass('d-none')

                    $('.doctors_search_count').text(response.total)

                    if( response.next_page_url != null ){
                        $('#btn_more_doctors').removeClass('d-none')
                    }else{
                        $('#btn_more_doctors').addClass('d-none')
                    }

                    $('#btn_more_doctors').data('link', response.next_page_url);

                    $.each(response.data, function( index, value ) {

                        let $element =
                            '<div class="col-lg-3"> \n'+
                                '<a href="{{ url('/doctor') }}/'+ value.slug + '" class="service__card" data-aos="fade-up"> \n'+
                                    '<div class="service__card-image"> \n'+
                                        '<picture> \n'+
                                            '<source srcset="'+ value.doctor_image +'" type="image/webp"> \n'+
                                            '<img src="'+ value.doctor_image +'" draggable="false" loading="lazy" alt="doctor"> \n'+
                                        '</picture> \n'+
                                    '</div> \n'+
                                    '<div class="search__result-text"> \n'+
                                        '<span class="color small">@lang('system.doctor')</span> \n'+
                                        '<h3 class="h6">'+ value.name +'</h3> \n'+
                                    '</div> \n'+
                                '</a> \n'+
                            '</div>';

                        $('#doctors_section').append($element);
                    });
                },
                error : function(request,error)
                {
                    alert("Request: "+JSON.stringify(request));
                }
            });
        }
    </script>
    <!-- END :: script for doctors -->

    <!-- BEGIN :: script for services -->
    <script>
        $(window).on('load', function(){
            $('#spinner_services_section').addClass('d-none')

            getServices($('#btn_more_services').data('link'))
        });

        $(document).on('click', '#btn_more_services', function(){

            getServices($('#btn_more_services').data('link'))
        });

        function getServices(url) {
            $.ajax({
                url: url,
                type: 'GET',
                data: {
                    'lang': '{{ app()->getLocale() }}',
                    'q': '{{ request()->keyword }}',
                    'status': '2'
                },
                success: function(response) {

                    if( response.total == 0 )
                        $('#list_services').addClass('d-none')

                    $('.services_search_count').text(response.total)

                    if( response.next_page_url != null ){
                        $('#btn_more_services').removeClass('d-none')
                    }else{
                        $('#btn_more_services').addClass('d-none')
                    }

                    $('#btn_more_services').data('link', response.next_page_url);

                    $.each(response.data, function( index, value ) {

                        let $element =
                            '<div class="col-lg-3"> \n'+
                                '<a href="{{ url('/services-details') }}/'+ value.slug + '" class="service__card" data-aos="fade-up"> \n'+
                                    '<div class="service__card-image"> \n'+
                                        '<picture> \n'+
                                            '<source srcset="'+ value.service_image +'" type="image/webp"> \n'+
                                            '<img src="'+ value.service_image +'" draggable="false" loading="lazy" alt="doctor"> \n'+
                                        '</picture> \n'+
                                    '</div> \n'+
                                    '<div class="search__result-text"> \n'+
                                        '<span class="color small">@lang('system.service')</span> \n'+
                                        '<h3 class="h6">'+ value.name +'</h3> \n'+
                                    '</div> \n'+
                                '</a> \n'+
                            '</div>';

                        $('#services_section').append($element);
                    });
                },
                error : function(request,error)
                {
                    alert("Request: "+JSON.stringify(request));
                }
            });
        }
    </script>
    <!-- END :: script for specificities -->
@endpush
