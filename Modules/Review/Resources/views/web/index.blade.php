@extends('frontend.layouts.master')

@section('meta')
    <!-- BEGIN :: Met section -->
    {!! $settings['reviews_page_seo'][app()->getLocale() == 'en'  ?  'en' : 'ar'] ?? '' !!}
    <!-- END :: Met section -->
@stop

@push('lang')
    @include('frontend.components.lang_url.lang', ['path' => '/review'])
@endpush

@section('title', __('system.send_us_your_review'))

@push('styles')
    <link rel="stylesheet" href="{{ asset('frontend/css/rate' . ( app()->getLocale() == 'ar' ? '-rtl.min.css' : '.min.css') ) }}" crossorigin="anonymous">
@endpush

@section('styles')
    <style>
        .form-check-inline {
            margin-right: 0;
        }

        .form-check-input {
            display: none;
        }
    </style>
@stop

@section('schema_code')
    {!! $settings['review_page_schema'] ?? '' !!}
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
                <h2 data-aos="fade-up">@lang('system.send_us_your_review')</h2>
                <!-- breadcrumb -->
                <nav aria-label="breadcrumb" data-aos="fade-up" data-aos-delay="50">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">@lang('system.home')</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('system.send_us_your_review')</li>
                    </ol>
                </nav>
                <!-- // breadcrumb -->
            </div>
        </div>
    </div>
    <!-- END :: page header section -->

    <!-- BEGIN :: page content -->
    <div class="wrapper">
        <section class="rate d-pad">
            <div class="container">
                <!-- section title -->
                <div class="section-title" data-aos="fade-up">
                    <h2>@lang('system.send_us_your_review')</h2>
                </div>
                <!-- // section title -->
                <form action="{{ route('web.reviews.store') }}" method="post">
                    @csrf

                    <div class="row">
                    <div class="col-lg-6">
                        <div class="rate__block">
                            <h3 class="h4" data-aos="fade-up">@lang('system.rate')</h3>

                            <div class="mb-3" data-aos="fade-up">
                                <select class="form-select" aria-label="Default select example" name="branch_id" id="branches_select_input">
                                    <option value="">@lang('system.choose_a_branch_to_rate')</option>
                                    @foreach($branches as $branch)
                                        <option value="{{ $branch->id }}"
                                                data-doctors="{{ $branch->listDoctors->pluck('id', 'name') }}"
                                                {{ $branch->id == old('branch_id') ? 'selected' : '' }} >
                                            {{ $branch->translate(app()->getLocale())->name }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('branch_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3" data-aos="fade-up">
                                <select class="form-select" aria-label="Default select example" name="doctor_id" id="doctors_select_input">
                                    <option value="">@lang('system.choose_a_doctor_to_rate')</option>
                                </select>

                                @error('doctor_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="rate__block">
                            <h3 class="h4" data-aos="fade-up">@lang('system.personal_information')</h3>

                            <div class="mb-3" data-aos="fade-up">
                                <label for="fullName" class="visually-hidden">@lang('system.full_name')</label>

                                <input type="text"
                                       class="form-control"
                                       id="fullName"
                                       placeholder="@lang('system.full_name')"
                                       name="name"
                                       value="{{ old('name') }}" />

                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3" data-aos="fade-up">
                                <label for="phoneNumber" class="visually-hidden">@lang('system.phone')</label>

                                <input type="tel"
                                       class="form-control"
                                       id="phoneNumber"
                                       value="{{ old('phone') }}"
                                       name="phone"
                                       placeholder="@lang('system.phone')" />

                                @error('phone')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="rate__block">
                            <h3 class="h4" data-aos="fade-up">@lang('system.your_voice_matters')</h3>
                            <div class="mb-3" data-aos="fade-up">
                                <label for="message" class="visually-hidden">@lang('system.message')</label>

                                <textarea class="form-control"
                                          id="message"
                                          name="message"
                                          placeholder="@lang('system.message')">{{ old('message') }}</textarea>

                                @error('message')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="rate__block">
                            <h3 class="h4" data-aos="fade-up">@lang('system.your_voice_matters')</h3>
                            @foreach($questions as $key => $question)
                                <div class="rate__block-rate" data-aos="fade-up">
                                    <h4 class="h5">{{ $question->translate(app()->getLocale())->question }}</h4>
                                    <div class="filters" data-aos="fade-up">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input"
                                                   type="radio"
                                                   name="questions[{{ $question->id }}]"
                                                   id="ease_of_communication_radio_first_{{ $key }}"
                                                   value="1" {{ old('dealing_with_reception_staff') == 1 ? 'checked' : '' }}/>

                                            <label class="form-check-label {{ old('dealing_with_reception_staff') == 1 ? 'checked' : '' }}" for="ease_of_communication_radio_first_{{ $key }}">
                                                @lang('system.unsatisfactory')
                                            </label>
                                        </div>

                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input"
                                                   type="radio"
                                                   name="questions[{{ $question->id }}]"
                                                   id="dealing_with_reception_staff_radio_second_{{ $key }}"
                                                   value="2" {{ old('dealing_with_reception_staff') == 2 ? 'checked' : 'checked' }}/>

                                            <label class="form-check-label {{ old('dealing_with_reception_staff') == 2 ? 'checked' : 'checked' }}" for="dealing_with_reception_staff_radio_second_{{ $key }}">
                                                @lang('system.satisfying')
                                            </label>
                                        </div>

                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input"
                                                   type="radio"
                                                   name="questions[{{ $question->id }}]"
                                                   id="dealing_with_reception_staff_radio_third_{{ $key }}"
                                                   value="3" {{ old('questions') == 3 ? 'checked' : '' }} />

                                            <label class="form-check-label {{ old('questions.*') == 3 ? 'checked' : '' }}" for="dealing_with_reception_staff_radio_third_{{ $key }}">
                                                @lang('system.very_satisfying')
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <button class="btn btn-brand-gradient" data-aos="fade-up">
                            @lang('system.rate_your_appointment_now')
                        </button>
                    </div>
                </div>
                </form>
            </div>
        </section>
    </div>
    <!-- END :: page content -->
@stop

@push('js')
    <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.js"></script>

    <script>
        $(document).on('change', '#branches_select_input', function () {
            $('#doctors_select_input').find('option').not(':first').remove();

            $.each($(this).find(":selected").data('doctors'), function (val, key) {
                $('#doctors_select_input').append('<option value="'+ key +'">'+ val +'</option>')
            })
        });
    </script>

    <!-- Begin :: script for checked inputs -->
    <script>
        $("input[type=radio]:checked").each( function() {

            $(this).parent().find('.form-check-label').addClass('checked');

        });

        $('input[type=radio]').on('click', function () {

            $(this).parents().eq(1).find('.form-check-label').removeClass('checked');

            $(this).parent().find('.form-check-label').addClass('checked');

        });
    </script>
    <!-- END :: script for checked inputs -->

    <script>
        function ResetServices() {
            $('#installmentService option:selected').prop('selected', false);
        }

        function updateServiceId(btnId) {

            $("#services_selectors").find('option').not(':first').remove();

            $("#doctors_selectors").find('option').not(':first').remove();

            if (btnId) {
                $.ajax({
                    type: 'GET',
                    url: route('api.services.specificities', {
                        'lang': '{{ app()->getLocale() }}',
                        'service': btnId
                    }),
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        if( data.specialities != null ){

                            $.each(data.specialities, function (index, specialit) {
                                if( specialit.id == '{{ old('speciality_id') }}' ){
                                    $('#services_selectors').append('<option value="' + specialit.id + '" selected>' + specialit.name + '</option>');
                                } else{
                                    $('#services_selectors').append('<option value="' + specialit.id + '">' + specialit.name + '</option>');
                                }
                            });

                            showDoctors();

                        }
                    },
                    error: function (data) {
                    }
                });
            }

        }

        function showDoctors() {
            service_id = $('input[name=service_id]:checked').val();

            specialtId  = $("#services_selectors option:selected").val();

            if (service_id && specialtId) {
                $.ajax({
                    type: 'GET',
                    url: route('api.specificities.doctors', {
                        'lang': '{{ app()->getLocale() }}',
                        'service': service_id,
                        'specificity': specialtId
                    }),
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        $.each(data.doctors, function (index, doctor) {
                            if( doctor.id == '{{ old('doctor_id') }}' ){
                                $('#doctors_selectors').append('<option value="' + doctor.id + '" selected>' + doctor.name + '</option>');
                            } else{
                                $('#doctors_selectors').append('<option value="' + doctor.id + '">' + doctor.name + '</option>');
                            }
                        });
                    },
                    error: function (data) {
                    }
                });

            }
        }
    </script>

    <script type='text/javascript'>
        function validateContact(tel) {

            var xyz=document.getElementById('installmentPhone').value.trim();

            var  phoneno = /^\d{10}$/;
            if((tel.value.match(phoneno)) && tel.value.length == 10 && xyz.substr(0,2)==='05' && $.isNumeric(xyz))
            {
                $(tel).removeClass('is-invalid');
                $(tel).addClass('is-valid');
            }
            else
            {
                $("#installmentPhone").val('');
                $(tel).removeClass('is-valid');
                $(tel).addClass('is-invalid');
            }
        }

        $('.form').validate({
            rules: {
                speciality_id:"required",
                doctor_id:"required",
                company:"required",
                name:"required",
                phone:"required",
                email: {
                    required: true,
                    email: true
                }
            },
            messages: {
                email: "@lang('messages.mailval')",
                name: "@lang('messages.namerequired')",
                phone: "@lang('messages.phonerequired')",
                speciality_id: "@lang('messages.specialityrequired')",
                doctor_id: "@lang('messages.doctorrequired')",
                company: "@lang('messages.Choose right installment')",
            },
        });
    </script>
@endpush
