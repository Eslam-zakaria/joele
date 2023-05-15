@extends('frontend.layouts.master')

@section('meta')
    {!! $settings['installment_page_seo'][app()->getLocale()] ?? '' !!}
@stop

@section('title', __('messages.Installment') . ' | ' . ( $settings['website_name'][app()->getLocale()] ?? '' ))

@push('styles')
    <link rel="stylesheet" href="{{ asset('frontend/css/book' . ( app()->getLocale() == 'ar' ? '-rtl.min.css' : '.min.css') ) }}" crossorigin="anonymous">
@endpush

@section('content')
    <!-- BEGIN :: page header section -->
    <div class="page-header">
        <div class="container">
            <div class="page-header__image">
                <picture>
                    <source srcset="{{ asset('frontend/images/page-header.webp') }}" type="image/webp" />
                    <img src="{{ asset('frontend/images/page-header.png') }}" draggable="false" alt="image" data-aos="zoom-out" />
                </picture>
            </div>

            <h2 class="h3" data-aos="fade-up" data-aos-delay="100">@lang('messages.Installment')</h2>
        </div>
    </div>
    <!-- END :: page header section -->

    <!-- BEGIN :: page content -->
    <div class="page-content book brd-top-rad d-pad">
        <div class="container">
            <!-- title -->
            <div class="section-title">
                <h2 class="title" data-aos="fade-up">@lang('messages.Installment')</h2>
                <p data-aos="fade-up" data-aos-delay="100">{{ $settings['page_installment_content'][app()->getLocale()] ?? '' }}</p>
            </div>
            <!-- // title -->
            <!-- form -->
            <form class="form" method="post" action="{{ route('web.leads.store', (app()->getLocale() == 'en' ? ['lang' => app()->getLocale()] : '')) }}">
                @csrf

                <div class="row">
                    <!-- block -->
                    <div class="col-lg-12">
                        <div class="book__block" data-aos="fade-up">
                            <h3 class="h5">@lang('messages.Department')</h3>
                            <!-- services -->
                            <nav class="services-nav">
                                @if(!empty($services))
                                    @foreach($services as $serv)
                                        <span class="btn btn-brand-secondary {{ $loop->first ? 'active' : '' }}" onclick="updateServiceId({{ $serv->id }})" id="services-{{ $serv->id }}">
                                            {{ $serv->name }}
                                        </span>
                                    @endforeach
                                @endif
                            </nav>
                            <!-- // services -->

                            <input type="hidden" id="ServiceId" name="service" value="{{ $serviceId }}">
                            <input type="hidden" name="source" value="installment">
                            <input type="hidden" name="branche_id" value="3">
                        </div>
                    </div>
                    <!-- // block -->
                    <!-- block -->
                    <div class="col-lg-6">
                        <div class="book__block" data-aos="fade-up">
                            <h3 class="h5">@lang('messages.Personal Information')</h3>
                            <!-- name -->
                            <div class="form-group row d-flex align-items-center">
                                <label for="installmentName" class="col-lg-3 col-form-label">@lang(('messages.Full Name'))</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" id="installmentName" placeholder="@lang('messages.namerequired')" name="name" value="{{ old('name') }}" required>
                                </div>
                            </div>
                            <!-- // name -->
                            <!-- phone -->
                            <div class="form-group row d-flex align-items-center">
                                <label for="installmentPhone" class="col-lg-3 col-form-label">@lang('messages.Phone')</label>
                                <div class="col-lg-9">
                                    <input type="tel" class="form-control" onchange="validateContact(this)" maxlength="10" id="installmentPhone" placeholder="@lang('messages.phonerequired') (05xxxxxxxx)." name="phone" value="{{ old('phone') }}" required>
                                    <div class="invalid-feedback">
                                        {{ (app()->getLocale() == 'ar') ? 'أدخل رقم جوالك' : 'Enter your mobile number'}}
                                    </div>
                                </div>
                            </div>
                            <!-- // phone -->
                            <!-- email -->
                            <div class="form-group row d-flex align-items-center">
                                <label for="installmentMail" class="col-lg-3 col-form-label">@lang('messages.Email Address')</label>
                                <div class="col-lg-9">
                                    <input type="email" class="form-control" id="installmentEmail" placeholder="@lang('messages.emailrequired')" name="email" value="{{ old('email') }}" required>
                                </div>
                            </div>
                            <!-- // email -->
                        </div>
                    </div>
                    <!-- // block -->
                    <!-- block -->
                    <div class="col-lg-6">
                        <div class="book__block" data-aos="fade-up">
                            <h3 class="h5">@lang('messages.booking_data')</h3>
                            <!-- service -->
                            <div class="form-group row d-flex align-items-center">
                                <label for="installmentService" class="col-lg-3 col-form-label">@lang('messages.service')</label>
                                <div class="col-lg-9">
                                    <select class="custom-select" onchange="return showDoctors();"  id="installmentService" name="speciality_id" required>
                                        <option value="">@lang('messages.specialityrequired')</option>
                                        @if(!empty($services))
                                            @foreach($services as $service)
                                                <optgroup label="{{ $service->name }}">
                                                    @foreach($service->specialities as $specialit)
                                                        <option value="{{ $specialit->id }}" {{ $request->speciality_id == $specialit->id ? 'selected' : '' }}>{{ $specialit->name }}</option>
                                                    @endforeach
                                                </optgroup>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <!-- // service -->
                            <!-- doctor -->
                            <div class="form-group row d-flex align-items-center">
                                <label for="installmentDoctor" class="col-lg-3 col-form-label">@lang('messages.doctor')</label>
                                <div class="col-lg-9">
                                    <select class="custom-select"  id="installmentDoctor" name="doctor_id" required>
                                        <option value="">@lang('messages.doctorrequired')</option>
                                        @if(!empty($doctors))
                                            @foreach($doctors as $doctor)
                                                <option value="{{ $doctor->id }}" {{ $request->doctor_id == $doctor->id ? 'selected' : '' }}>{{ $doctor->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <!-- // doctor -->
                            <!-- date -->
                            <div class="form-group row d-flex align-items-center">
                                <label for="installmentDate" class="col-lg-3 col-form-label">@lang('messages.Book Date')</label>
                                <div class="col-lg-9">
                                    <input type="date" class="form-control" name="book_date" id="installmentDate" required>
                                </div>
                            </div>
                            <!-- // date -->
                        </div>
                    </div>
                    <!-- // block -->
                    <!-- block -->
                    <div class="col-lg-6">
                        <div class="book__block" data-aos="fade-up">
                            <h3 class="h5">@lang('messages.Installment Company')</h3>
                            <!-- service -->
                            <div class="form-group row d-flex align-items-center">
                                <label for="installmentCompnay" class="col-lg-3 col-form-label">@lang('messages.Installment Company')</label>
                                <div class="col-lg-9">
                                    <select class="custom-select" id="installmentCompany" name="company" required>
                                        <option value="">@lang('messages.Choose right installment')</option>
                                        @if(!empty($company))
                                            @foreach($company as $key => $com)
                                                <option value="{{ $key }}" {{ $request->company == $key ? 'selected' : '' }}>{{ $com }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <!-- // service -->
                        </div>
                    </div>
                    <!-- // block -->
                </div>

                <!-- btn -->
                <div class="row d-flex align-items-center">
                    <div class="col-lg-12">
                        <button type="submit" class="btn btn-brand-primary" data-aos="fade-up">@lang('messages.Get Installment Service')</button>
                    </div>
                </div>
                <!-- // btn -->
            </form>
            <!-- // form -->
        </div>
    </div>
    <!-- END :: page content -->
@stop

@push('js')
    <script language="javascript">
        $(document).ready(function(){
            var today = new Date();
            var dd = String(today.getDate()).padStart(2, '0');
            var mm = String(today.getMonth() + 1).padStart(2, '0');
            var yyyy = today.getFullYear();

            today = yyyy + '-' + mm + '-' + dd;

            $('#installmentDate').attr('min',today).attr('value',today);
    });
    </script>
    <script>

        $(document).ready(function () {
            service_id = $("#ServiceId").val();
            $("#services-"+ service_id +"").addClass("active");
            $("#ServiceId").val(service_id);

            updateServiceId(service_id);
            showDoctors();

        })

        function ResetServices() {
            $('#installmentService option:selected').prop('selected', false);
        }

        function updateServiceId(btnId) {
            $(".services-nav span").removeClass("active");
            $("#services-"+ btnId +"").addClass("active");
            $("#ServiceId").val(btnId);
            service_id = $("#ServiceId").val();

            //empty all seclect
            var select = $("#installmentBranch");
            select.empty();
            var content = '<option value="">@lang('messages.brancherequired')</option>';
            select.append(content);

            var selectspecialt = $("#installmentService");
            selectspecialt.empty();
            var contentspecialt = '<option value="">@lang('messages.specialityrequired')</option>';
            selectspecialt.append(contentspecialt);

            var selectdoctor = $("#installmentDoctor");
            selectdoctor.empty();
            var contentdoctor = '<option value="">@lang('messages.doctorrequired')</option>';
            selectdoctor.append(contentdoctor);

            var selecttime = $("#installmentTime");
            selecttime.empty();
            var contenttime = '<option value="">@lang('messages.timerequired')</option>';
            selecttime.append(contenttime);

            if (service_id) {
                $.ajax({
                    type: 'GET',
                    url: route('api.services.specificities', {
                        'lang': '{{ app()->getLocale() }}',
                        'service': service_id
                    }),
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        if( data.services != null ){

                            var selectspecialt = $("#installmentService");
                            selectspecialt.empty();
                            var contentspecialt = '<option value="">@lang('messages.specialityrequired')</option>';
                            selectspecialt.append(contentspecialt);
                            selectspecialt.append('<optgroup label="' + data.services.name + '">');
                            $.each(data.specialities, function (index, specialit) {
                                var content2 = '<option value="' + specialit.id + '">' + specialit.name + '</option>';
                                selectspecialt.append(content2);
                            });
                            selectspecialt.append('</optgroup>');
                            showDoctors();

                        }
                    },
                    error: function (data) {
                    }
                });
            }

        }

        function showDoctors() {

            service_id = $("#ServiceId").val();
            specialtId  = $("#installmentService option:selected").val();

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
                        var selectdoctor = $("#installmentDoctor");
                        selectdoctor.empty();
                        var contentdoctor = '<option value="">@lang('messages.doctorrequired')</option>';
                        selectdoctor.append(contentdoctor);
                        $.each(data.doctors, function (index, doctor) {
                            var content3 = '<option value="' + doctor.id + '">' + doctor.name + '</option>';
                            selectdoctor.append(content3);
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

    </script>
@endpush
