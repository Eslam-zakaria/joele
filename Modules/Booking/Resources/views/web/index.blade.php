@extends('frontend.layouts.master')

@section('title', __('system.book_now'))

@section('meta')
    {!! $settings['booking_page_seo'][app()->getLocale() == 'en'  ?  'en' : 'ar'] ?? '' !!}
@stop

@push('styles')
<link rel="stylesheet preload" href="{{ asset('frontend/css/' . ( app()->getLocale() == 'en' ? 'book.min.css' : 'book-rtl.min.css' ) ) }}" as="style" crossorigin>
@endpush

@push('lang')

@include('frontend.components.lang_url.lang', ['path' => '/book-an-appointment'])

@endpush

@section('schema_code')
{!! $settings['book_page_schema'] ?? '' !!}
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
                <h2 data-aos="fade-up">@lang('system.book_now')</h2>
                <!-- breadcrumb -->
                <nav aria-label="breadcrumb" data-aos="fade-up" data-aos-delay="50">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('web.home.index') }}">@lang('system.home')</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('system.book_now')</li>
                    </ol>
                </nav>
                <!-- // breadcrumb -->
            </div>
        </div>
    </div>
    <!-- // page header -->

    <!-- wrapper -->
    <div class="wrapper">

        <!-- book -->
        <section class="book d-pad">
            <div class="container">
                <!-- section title -->
                <div class="section-title" data-aos="fade-up">
                    <h2>@lang('system.book_now')</h2>
                </div>
                <!-- // section title -->
                <form class="form" method="post" action="{{ route('web.booking.store') }}">
                    @csrf
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="book__block">
                                <h3 class="h4" data-aos="fade-up">@lang('system.personal_data')</h3>
                                <!-- form -->
                                <div class="mb-3" data-aos="fade-up">
                                    <label for="fullName" class="visually-hidden">@lang('system.full_name')</label>
                                    <input type="text" class="form-control" id="fullName" name="name" value="{{ old('name') }}" placeholder="@lang('system.full_name')">
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <!-- // form -->
                                <!-- form -->
                                <div class="mb-3" data-aos="fade-up">
                                    <label for="phone" class="visually-hidden">@lang('system.mobile_number')</label>
                                    <input type="tel" class="form-control" id="phone" onchange="validateContact(this)" maxlength="10" name="phone" value="{{ old('phone') }}" placeholder="@lang('system.mobile_number')">
                                    @error('phone')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <div class="invalid-feedback">
                                    {{ (app()->getLocale() == 'ar') ? 'يجب أن يكون هذا الحقل جوالًا سعوديًا (05xxxxxxxx).' : 'This field must be saudi arabia mobile (05xxxxxxxx).'}}
                                    </div>
                                </div>
                                <!-- // form -->
                                <!-- form -->
                                <div class="mb-3" data-aos="fade-up">
                                    <select class="form-select" aria-label="Default select example" onchange="return showDoctors();" id="bookBranch" name="branch_id">
                                        <option value="">{{ __('system.brancherequired') }}</option>
                                        @if(!empty($branches))
                                            @foreach($branches as $branche)
                                            <option value="{{ $branche->id}}" {{ old('branch_id') ==  $branche->id  ? 'selected' : '' }}>{{ $branche->name ?? ''}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @error('branch_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <!-- // form -->
                                <!-- form -->
                                <div class="mb-3" data-aos="fade-up">
                                    <select class="form-select" aria-label="Default select example" onchange="return showAvailableAppointments();" id="bookDoctor" name="doctor_id">
                                       <option value="">{{ __('system.doctorrequired') }}</option>
                                    </select>
                                    @error('doctor_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <!-- // form -->
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="book__block">
                                <h3 class="h4" data-aos="fade-up">@lang('system.reservation_data')</h3>
                                <!-- form -->
                                <div class="mb-3" data-aos="fade-up">
                                        <select class="form-select" aria-label="Default select example" id="bookingDate" name="attendance_date" >
                                            <option value="">{{ __('system.choose_appropriate') }}</option>
                                        </select>

                                        @error('attendance_date')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                </div>
                                <!-- // form -->
                                <!-- form -->
                                <div class="mb-3" data-aos="fade-up">
                                    <select class="form-select" aria-label="Default select example" id="bookingTime" name="available_time">
                                        <option value="">@lang('system.choose_time')</option>
                                        <option value="@lang('system.morning')" {{ old('available_time') ==  __('system.morning')  ? 'selected' : '' }}>@lang('system.morning')</option>
                                        <option value="@lang('system.evening')" {{ old('available_time') ==  __('system.evening') ? 'selected' : '' }}>@lang('system.evening')</option>
                                    </select>
                                    @error('available_time')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <!-- // form -->
                            </div>
                            <div class="book__block d-none">
                                <h3 class="h4" data-aos="fade-up">@lang('system.payment_options')</h3>
                                <!-- form -->
                                <div class="filters" data-aos="fade-up">
                                    <!-- filter -->
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" onclick="PayBranch()" name="payment_type" id="payAtClinic" value="Pay in branch" checked>
                                        <label class="form-check-label checked" for="payAtClinic">
                                            <!-- add class 'checked' when input checked -->
                                            @lang('system.pay_clinic')
                                        </label>
                                    </div>
                                    <!-- // filter -->
                                    <!-- filter -->
                                    <!-- <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" onclick="PayOnline()" name="payment_type" id="onlinePayment" value="Pay online">
                                        <label class="form-check-label" for="onlinePayment">
                                        @lang('system.online_payment')
                                        </label>
                                    </div> -->
                                    @error('payment_type')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <!-- // filter -->
                                </div>
                                <input type="hidden" id="TypeId" name="type" value="1">
                                <!-- // form -->
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <button class="btn btn-brand-gradient" data-aos="fade-up">
                            @lang('system.book_now')
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </section>
        <!-- // book -->
    </div>
@stop

@push('js')
    <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.js"></script>
    <script>

        $(document).ready(function () {
            showDoctors();
        })

        function PayBranch() {
            $("#onlinePayment").removeAttr('checked');
            $("#payAtClinic").attr('checked', 'checked');
        }

        function PayOnline() {
            $("#payAtClinic").removeAttr('checked');
            $("#onlinePayment").attr('checked', 'checked');
        }

        function validateContact(tel) {

            var xyz=document.getElementById('phone').value.trim();

            var  phoneno = /^\d{10}$/;
            if((tel.value.match(phoneno)) && tel.value.length == 10 && xyz.substr(0,2)==='05' && $.isNumeric(xyz))
            {
                $(tel).removeClass('is-invalid');
                $(tel).addClass('is-valid');

            }
            else
            {
                $("#phone").val('');
                $(tel).removeClass('is-valid');
                $(tel).addClass('is-invalid');

            }
        }


        function showDoctors() {

           branchId  = $("#bookBranch option:selected").val();

           if (branchId) {

                $.ajax({
                    type: 'GET',
                    url: route('api.branch.doctors', {
                        'branch': branchId
                    }),
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        var selectdoctor = $("#bookDoctor");
                        selectdoctor.empty();
                        var contentdoctor = '<option value="">{{ __('system.doctorrequired') }}</option>';
                        selectdoctor.append(contentdoctor);
                            $.each(data.doctors, function (index, doctor) {
                                    var content3 = '<option value="' + doctor.id + '" {{ old('doctor_id') == "'doctor.id'" ? 'selected' : '' }}>' + doctor.name + '</option>';
                                    selectdoctor.append(content3);
                            });
                            showAvailableAppointments();
                    },
                    error: function (data) {
                        var selectdoctor = $("#bookDoctor");
                        selectdoctor.empty();
                        var contentdoctor = '<option value="">{{ __('system.doctorrequired') }}</option>';
                        selectdoctor.append(contentdoctor);
                    }
                });

            } else {
                var selectdoctor = $("#bookDoctor");
                selectdoctor.empty();
                var contentdoctor = '<option value="">{{ __('system.doctorrequired') }}</option>';
                selectdoctor.append(contentdoctor);

                var selecttime = $("#bookingDate");
                selecttime.empty();
                var contenttime = '<option value="">{{ __('system.choose_appropriate') }}</option>';
                selecttime.append(contenttime);
            }
       }

        function showAvailableAppointments() {
            doctorId = $("#bookDoctor option:selected").val();
            branchId  = $("#bookBranch option:selected").val();
            if (doctorId && branchId) {
                $.ajax({
                    type: 'GET',
                    url: route('api.doctors.appointments', {'doctor': doctorId , 'branch' : branchId}),
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        // console.log(data);
                        var selecttime = $("#bookingDate");
                        selecttime.empty();
                        var contenttime = '<option value="">{{ __('system.choose_appropriate') }}</option>';
                        selecttime.append(contenttime);
                        $.each(data.doctorAppointments, function (index, appointment) {
                            var contenttime = '<option value="' + appointment.date + '">' + appointment.schedule + '</option>';
                            selecttime.append(contenttime);
                        });

                    },
                    error: function (data) {
                        var selecttime = $("#bookingDate");
                        selecttime.empty();
                        var contenttime = '<option value="">{{ __('system.choose_appropriate') }}</option>';
                        selecttime.append(contenttime);
                    }
                });
            } else {
                var selecttime = $("#bookingDate");
                selecttime.empty();
                var contenttime = '<option value="">{{ __('system.choose_appropriate') }}</option>';
                selecttime.append(contenttime);
            }
        }

        function checkAvailableAppointment() {
            doctorId = $("#bookDoctor option:selected").val();
            brancheId = $("#bookBranch option:selected").val();
            date = $("#bookingDate option:selected").val();
            time = $("#bookingTime option:selected").val();

            if (doctorId) {
                $.ajax({
                    type: 'GET',
                    url: route('web.booking.check.availability', {
                        'doctor_id': doctorId,
                        'branch_id': brancheId,
                        'attendance_date': date,
                        'available_time': time
                    }),
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        console.log(data);
                        if (data == '0') {
                            $("#availability_alert").css('display', 'block');
                        } else {
                            $("#availability_alert").css('display', 'none');
                        }
                    },
                    error: function (data) {
                    }
                });
            }
        }


    </script>
@endpush
