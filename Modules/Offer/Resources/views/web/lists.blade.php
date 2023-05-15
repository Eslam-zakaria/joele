@extends('frontend.layouts.master')

@section('title')
    @lang('system.joele_offer') - {{ $branche->name ?? '' }}
@endsection

@section('meta')
    {!! $settings['offers_page_seo'][app()->getLocale() == 'en'  ?  'en' : 'ar'] ?? '' !!}
@stop

@push('styles')
    <link rel="stylesheet preload" href="{{ asset('frontend/css/' . ( app()->getLocale() == 'en' ? 'offers.min.css' : 'offers-rtl.min.css' ) ) }}" as="style" crossorigin>
@endpush

@push('lang')

@include('frontend.components.lang_url.lang', $request->get('category') != null ? ['path' => (app()->getLocale() == 'en' ? '/offers/'.$branche->translate('ar')->slug.'?category='.$request->get('category') : '/offers/'.$branche->translate('en')->slug.'?category='.$request->get('category'))] : ['path' => (app()->getLocale() == 'en' ? '/offers/'.$branche->translate('ar')->slug : '/offers/'.$branche->translate('en')->slug)])

@endpush

@section('schema_code')

<script type="application/ld+json">
{
    "@context": "http://schema.org",
    "@type": "WebPage",
    "name": "{{ $branche->translate('en')->name ?? ''}}",
    "description": "Branche Offers"
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
                <h2 data-aos="fade-up">@lang('system.joele_offer') - {{ $branche->name ?? '' }}</h2>
                <!-- breadcrumb -->
                <nav aria-label="breadcrumb" data-aos="fade-up" data-aos-delay="50">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('web.home.index') }}">@lang('system.home')</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('web.offers.index') }}">@lang('system.offers')</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('system.joele_offer') - {{ $branche->name ?? '' }}</li>
                    </ol>
                </nav>
                <!-- // breadcrumb -->
            </div>
        </div>
    </div>
    <!-- // page header -->



    <!-- wrapper -->
    <div class="wrapper">

        <!-- offers -->
        <section class="offers d-pad">
            <div class="container">
                <!-- title -->
                <div class="section-title" data-aos="fade-up">
                    <h2>@lang('system.joele_offer') - {{ $branche->name ?? '' }}</h2>
                </div>
                <!-- // title -->
                <div class="row">
                    <div class="col-lg-6">
                        <p data-aos="fade-up">
                            {{ $settings['page_offer_content'][app()->getLocale() == 'en'  ?  'en' : 'ar'] ?? '' }}
                        </p>
                    </div>
                    <!-- filters -->
                    <div class="col-lg-6">
                        <form action="" id="filter_form">
                            <div class="filters" data-aos="fade-up">
                                <!-- filter -->
                                <a @if(empty($request->get('category'))) class="btn btn-brand-gradient" @else class="btn btn-white" @endif href="{{ route('web.offers.lists', ['slug' => $branche->slug]) }}">@lang('system.all_offers')</a>
                                <!-- // filter -->
                                <!-- @if(count($categories) > 0)
                                    @foreach($categories as $cat)
                                    <a @if($cat->id == $request->get('category')) class="btn btn-brand-gradient" @else class="btn btn-white" @endif href="{{ route('web.offers.lists', ['lang' => app()->getLocale(),'slug' => $branche->slug ,'category' => $cat->id ]) }}">{{ $cat->name ?? ''}}</a>
                                    @endforeach
                                @endif -->
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
                    <!-- branch offers -->
                    <div class="col-lg-12">
                        <div class="branch-offers">
                            <div class="row">
                                <!-- offer -->
                                @if(count($offers) > 0)
                                    @foreach($offers as $offer)
                                    <div class="col-lg-3">
                                        <div class="card offer__card" data-aos="fade-up">
                                            <div class="offer__card-image">
                                                <picture>
                                                    <source srcset="{{ $offer->offer_image ?? '' }}" type="image/webp"><img loading="lazy" src="{{ $offer->offer_image ?? '' }}" alt="{{ $offer->name ?? '' }}">
                                                </picture>
                                            </div>
                                            <h3 class="offer__card-title h5">
                                               {{ $offer->name ?? '' }}
                                            </h3>
                                            <div class="h4">
                                            {{ $offer->price ?? '' }} <small class="color">@lang('system.sr')</small>
                                            </div>
                                            <a href="{{ route('web.offers.book', ['slug' => $branche->slug , 'offerId' => $offer->id ]) }}" class="btn btn-brand-gradient">@lang('system.book_now')</a>
                                        </div>
                                    </div>
                                    @endforeach
                                @endif
                                <!-- // offer -->
                                <!-- pagination -->
                                <div class="col-lg-12">
                                    <div class="pagination__container" data-aos="fade-up">
                                        <nav aria-label="Page navigation example">
                                            <ul class="pagination">
                                                {{ $offers->appends(['category' => request()->get('category')])->links('frontend.home.pagination') }}
                                            </ul>
                                        </nav>
                                    </div>
                                </div>
                                <!-- // pagination -->
                            </div>
                        </div>
                    </div>
                    <!-- // branch offers -->
                </div>
            </div>
        </section>
        <!-- // offers -->
    </div>
@endsection

