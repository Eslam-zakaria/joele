@extends('frontend.layouts.master')

@section('title')
    {{ $service->name ?? ''}}
@stop

@push('meta')
    <meta property="og:title" content="{{ $service->name ?? '' }}"/>
    <meta property="og:description" content="{{ $service->meta_description ?? '' }}" />
    <meta property="og:image" content="{{ $service->service_image ?? '/frontend/images/logo.svg' }}"/>
    <meta property="og:url" content="{{ url()->current() ?? '' }}"/>

    <!-- Meta description for twitter. -->
    <meta name="twitter:card" content="{{ $service->service_image ?? '/frontend/images/logo.svg' }}">
    <meta name="twitter:site" content="{{ url('/') }}">
    <meta name="twitter:title" content="{{ $service->name ?? '' }}"/>
    <meta name="twitter:description" content="{{ $service->meta_description ?? '' }}" />
    <meta name="twitter:image" content="{{ $service->service_image ?? '/frontend/images/logo.svg' }}" />

    <link rel="canonical" href="{{ $service->canonical_url ?? '' }}" />
    <meta name="title" content="{{ $service->meta_title ?? '' }}"/>
    <meta name="keywords" content="{{ $service->meta_keywords ?? '' }}"/>
    <meta name="description" content="{{ $service->meta_description ?? '' }}"/>
@endpush

@push('styles')
    <link rel="stylesheet preload" href="{{ asset('frontend/css/' . ( app()->getLocale() == 'en' ? 'services.min.css' : 'services-rtl.min.css' ) ) }}" as="style" crossorigin>
    <link rel="stylesheet" href="{{ asset('frontend/css/faqs.min.css') }}" crossorigin="anonymous" />
@endpush

@push('lang')
    @if($service->translate('ar'))
        @include('frontend.components.lang_url.lang', ['path' => (app()->getLocale() == 'en' ? '/services-details/'.$service->translate('ar')->slug : '/services-details/'.$service->translate('en')->slug)])
    @endif
@endpush

@section('schema_code')

<script type="application/ld+json">
{
  "@context": "https://schema.org/",
  "@type": "Product",
  "image": "{{ $service->service_image ?? '/frontend/images/logo.svg' }}",
  "name": "{{ $service->translate('en')->name ?? '' }}",
  "review": {
    "@type": "Review",
    "reviewRating": {
      "@type": "Rating",
      "ratingValue": "5"
    },
    "name": "{{ $service->translate('en')->name ?? '' }}",
    "author": {
      "@type": "Organization",
      "name": "Joele Clinics"
    },
    "datePublished": "{{ $service->created_at ?? '' }}"
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
                <{{ $service->title_header_option ?? 'h2' }} data-aos="fade-up">{{ $service->name ?? ''}}</{{ $service->title_header_option ?? 'h2' }}>
                <!-- breadcrumb -->
                <nav aria-label="breadcrumb" data-aos="fade-up" data-aos-delay="50">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('web.home.index') }}">@lang('system.home')</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('web.services.index') }}">@lang('system.services')</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('web.services.list', ['slug' => $service->category->slug ]) }}">@lang('system.service') {{ $service->category->name ?? ''}}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $service->name ?? ''}}</li>
                    </ol>
                </nav>
                <!-- // breadcrumb -->
            </div>
        </div>
    </div>
    <!-- // page header -->

      <!-- wrapper -->
      <div class="wrapper">

<!-- services -->
<section class="service-detail d-pad">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <!-- title -->
                <div class="section-title" data-aos="fade-up">
                    <{{ $service->title_header_option ?? 'h2' }}>{{ $service->name ?? ''}}</{{ $service->title_header_option ?? 'h2' }}>
                </div>
                <!-- // title -->
                <p data-aos="fade-up">{!! $service->description ?? '' !!}</p>
                <h3 class="h4 mb-2" data-aos="fade-up">
                  @lang('system.service_description')
                </h3>
                <p data-aos="fade-up">{!! $service->content ?? '' !!}</p>
            </div>
            <div class="col-lg-6">
                <div class="service-detail__image" data-aos="zoom-out">
                    <picture>
                        <source srcset="{{ $service->service_image ?? ''}}" type="image/webp"><img src="{{ $service->service_image ?? ''}}" draggable="false" alt="{{ $service->alt_image ?? $service->name }}">
                    </picture>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- // services -->
      </div>

@if(count($getQuestions) > 0)
     <div class="related-services d-pad">
      <div class="container">
          <!-- section title -->
          <div class="section-title text-center" data-aos="fade-up">
              <h2>@lang('system.frequently_asked_questions')</h2>
          </div>
          <div class="accordion faqs-container" id="accordionExample">
          @foreach($getQuestions as $key => $question)
              <div class="accordion-item">
                  <h2 class="accordion-header" id="question_{{ $key }}">
                      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#question_answer_{{ $key }}" aria-expanded="{{ $key == 0 ? 'true' : 'false' }}" aria-controls="question_answer_{{ $key }}">
                          <label class="faqs-container__title-container">
                              {{ $question->translate(app()->getLocale())->question ?? '' }}
                              <span class="faq__category">{{ $service->name ?? ''}}</span>
                          </label>
                      </button>
                  </h2>
                  <div id="question_answer_{{ $key }}" class="accordion-collapse collapse {{ $key == 0 ? 'show' : '' }}" aria-labelledby="question_{{ $key }}" data-bs-parent="#accordionExample">
                      <div class="accordion-body">{!! $question->translate(app()->getLocale())->answer ?? '' !!}</div>
                  </div>
              </div>
          @endforeach
      </div>
      </div>
     </div>
@endif

<!-- related services -->
@if(count($servicesRelated) > 0)
<div class="related-services d-pad">
    <div class="container">
        <!-- section title -->
        <div class="section-title text-center" data-aos="fade-up">
            <h2>@lang('system.related_services')</h2>
        </div>
        <!-- // section title -->
        <!-- slider -->
        <div class="related-slider" data-aos="fade-up">
            <div class="swiper relatedSlider">
                <div class="swiper-wrapper">
                    <!-- service -->
                    @foreach($servicesRelated as $related)
                    <div class="swiper-slide">
                        <a class="card service__card" href="{{ route('web.services.details', ['slug' => $related->slug ]) }}">
                            <div class="service__card-image">
                                <picture>
                                    <source srcset="{{ $related->service_image ?? ''}}" type="image/webp"><img loading="lazy" src="{{ $related->service_image ?? ''}}" alt="{{ $related->alt_image ?? $related->name }}">
                                </picture>
                            </div>
                            <h3 class="service__card-title h5">
                            {{ $related->name ?? ''}}
                            </h3>
                        </a>
                    </div>
                    @endforeach
                    <!-- // service -->
                </div>
                <div class="swiper-pagination"></div>
                <div class="slider-controls">
                    <div class="swiper-button-next related-next"></div>
                    <div class="swiper-button-prev related-prev"></div>
                </div>
            </div>
        </div>
        <!-- // slider -->
    </div>
</div>
@endif
<!-- // related services -->
@stop
