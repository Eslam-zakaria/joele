@extends('frontend.layouts.master')

@section('title')
    @lang('system.latest_offers') - {{ $offer->name ?? '' }}
@endsection

@push('meta')
    {!! $settings['offer_book_page_seo'][app()->getLocale() == 'en'  ?  'en' : 'ar'] ?? '' !!}
@endpush

@push('styles')
<link rel="stylesheet preload" href="{{ asset('frontend/css/' . ( app()->getLocale() == 'en' ? 'book.min.css' : 'book-rtl.min.css' ) ) }}" as="style" crossorigin>
@endpush

@push('lang')
    @include('frontend.components.lang_url.lang', ['path' => (app()->getLocale() == 'en' ? '/offer/'.$branche->translate('ar')->slug.'/'.$offer->id.'/book' : '/offer/'.$branche->translate('en')->slug.'/'.$offer->id.'/book')])
@endpush

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
                <h2 data-aos="fade-up">@lang('system.latest_offers') - {{ $offer->name ?? '' }}</h2>
                <!-- breadcrumb -->
                <nav aria-label="breadcrumb" data-aos="fade-up" data-aos-delay="50">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('web.home.index') }}">@lang('system.home')</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('web.offers.index') }}">@lang('system.offers')</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('web.offers.lists', ['slug' => $branche->slug ]) }}">@lang('system.joele_offer') - {{ $branche->name ?? '' }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('system.latest_offers') - {{ $offer->name ?? '' }}</li>
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
                    <h2>@lang('system.latest_offers') - {{ $offer->name ?? '' }} ({{ $offer->price ?? '' }} @lang('system.sr'))</h2>
                </div>

                <!-- // section title -->
                <form class="form" method="post" action="{{ request()->get('step_num') == 1  ? route('web.offer-booking.checkTabby') : route('web.offer-booking.store')}}">
                    @csrf
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="book__block">
                                <h3 class="h4" data-aos="fade-up">@lang('system.personal_data')</h3>
                                <!-- form -->
                                <div class="mb-3" data-aos="fade-up">
                                    <label for="fullName" class="visually-hidden">@lang('system.full_name')</label>
                                    <input type="text" class="form-control" id="fullName" name="name" value="{{ old('name') }}" placeholder="@lang('system.full_name')" {{ request()->get('step_num') == 2  ?  'readonly' : '' }}>
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3" data-aos="fade-up">
                                    <label for="fullemail" class="visually-hidden">@lang('system.email')</label>
                                    <input type="email" class="form-control" id="fullemail" name="email" value="{{ old('email') }}" placeholder="@lang('system.email')" {{ request()->get('step_num') == 2  ?  'readonly' : '' }}>
                                    @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <!-- // form -->
                                <!-- form -->
                                <div class="mb-3" data-aos="fade-up">
                                    <label for="phone" class="visually-hidden">@lang('system.mobile_number')</label>
                                    <input type="tel" class="form-control" id="phone" onchange="validateContact(this)" maxlength="10" name="phone" value="{{ old('phone') }}" placeholder="@lang('system.mobile_number')" {{ request()->get('step_num') == 2  ?  'readonly' : '' }}>
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
                                    <select class="form-select" aria-label="Default select example" name="branch_id">
                                        <option value="{{ $branche->id}}" selected>{{ $branche->name ?? ''}}</option>
                                    </select>
                                    @error('branch_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <!-- // form -->
                                <!-- form -->
                                <div class="mb-3" data-aos="fade-up">
                                    <select class="form-select" aria-label="Default select example" name="offer_id">
                                        <option value="{{ $offer->id}}" selected>{{ $offer->name ?? ''}}</option>
                                    </select>
                                    @error('offer_id')
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
                                    <label for="bookingDate" class="visually-hidden">@lang('system.choose_appropriate')</label>
                                    <input type="date" class="form-control" id="bookingDate" name="attendance_date" value="{{ old('attendance_date') }}" {{ request()->get('step_num') == 2  ?  'readonly' : '' }}>
                                    @error('attendance_date')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <!-- // form -->
                                <!-- form -->
                                <div class="mb-3" data-aos="fade-up">
                                    <select class="form-select" aria-label="Default select example" name="available_time" {{ request()->get('step_num') == 2  ?  'readonly' : '' }}>
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
                            <div class="{{ request()->get('step_num') == 1 ?  'book__block d-none' : 'book__block' }}">
                                <h3 class="h4" data-aos="fade-up">@lang('system.payment_options')</h3>
                                <!-- form -->
                                <div class="filters" data-aos="fade-up">
                                    <!-- filter -->
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" onclick="PayBranch()" name="payment_type" id="payAtClinic" value="Pay in branch" @if(old('payment_type') == 'Pay in branch') checked @endif>
                                        <label class="form-check-label @if(old('payment_type') == 'Pay in branch') checked @endif" for="payAtClinic">
                                            <!-- add class 'checked' when input checked -->
                                            @lang('system.pay_clinic')
                                        </label>
                                    </div>
                                    <!-- // filter -->
                                    <!-- filter -->
                                    <div class="form-check form-check-inline {{ $settings['hidden_install_pay'][app()->getLocale() == 'en'  ?  'en' : 'ar'] ?? '' }}">
                                        <input class="form-check-input" type="radio" onclick="PayInstallment()" name="payment_type" id="payInstallment" value="Pay Installment" @if(old('payment_type') == 'Pay Installment') checked @endif>
                                        <label class="form-check-label @if(old('payment_type') == 'Pay Installment') checked @endif" for="payInstallment">
                                            <!-- add class 'checked' when input checked -->
                                            @lang('system.pay_Installment')
                                        </label>
                                    </div>
                                    <!-- // filter -->
                                    <!-- filter -->
                                    <div class="form-check form-check-inline {{ $settings['hidden_pay'][app()->getLocale() == 'en'  ?  'en' : 'ar'] ?? '' }}">
                                        <input class="form-check-input" type="radio" onclick="PayOnline()" name="payment_type" id="onlinePayment" value="Pay online" @if(old('payment_type') == 'Pay online') checked @endif>
                                        <label class="form-check-label @if(old('payment_type') == 'Pay online') checked @endif" for="onlinePayment">
                                        @lang('system.online_payment')
                                        </label>
                                    </div>
                                    <!-- // filter -->
                                </div>
                                @error('payment_type')
                                    <span class="text-danger" style="display: block;">{{ $message }}</span>
                                @enderror

                                <input type="hidden" id="TypeId" name="type" value="2">
                                <input type="hidden" Id="StepNum" name="step_num" value="{{ request()->get('step_num') == 2  ? 2 : 1 }}">
                                <!-- // form -->
                            </div>
                            <div id="Installment" class="book__block d-none">
                                <h3 class="h4" data-aos="fade-up">{{ app()->getLocale() == 'en'  ?  'Installment options' : 'خيارات التقسيط' }}</h3>
                                    <div  class="filters" data-aos="fade-up">
                                        <!-- filter -->
                                       @if($offer->price >= '1000')
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" onclick="PayFortInstal()" name="type_installment" id="payFortInstal" value="payFort Installment" @if(old('type_installment') == 'payFort Installment') checked @endif>
                                            <label class="form-check-sublabel @if(old('type_installment') == 'payFort Installment') checked @endif" for="payFortInstal">
                                                <!-- add class 'checked' when input checked -->
                                                @lang('system.Payfort')
                                            </label>
                                        </div>
                                        @endif

                                        <div class="form-check form-check-inline {{ request()->get('tabby_status') == 0  ? 'd-none' : '' }}">
                                            <input class="form-check-input" type="radio" onclick="PayTabby()" name="type_installment" id="payTabby" value="Tabby" @if(old('type_installment') == 'Tabby') checked @endif>
                                            <label class="form-check-sublabel @if(old('type_installment') == 'Tabby') checked @endif" for="payTabby">
                                                <!-- add class 'checked' when input checked -->
                                                @lang('system.Tabby')
                                            </label>
                                        </div>
                                        <!-- // filter -->
                                        <!-- filter -->
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" onclick="PayTamara()" name="type_installment" id="payTamara" value="Tamara" @if(old('type_installment') == 'Tamara') checked @endif>
                                            <label class="form-check-sublabel @if(old('type_installment') == 'Tamara') checked @endif" for="payTamara">
                                            @lang('system.Tamara')
                                            </label>
                                        </div>
                                    </div>
                                    <div class="book__block mt-3" data-aos="fade-up">
                                    <!-- online payment -->
                                        <div class="installment-payment-tamara d-none">
                                            <div class="card">
                                                    <div class="tamara-product-widget" data-lang="{{ app()->getLocale() == 'en'  ?  'en' : 'ar' }}" data-price="{{ $offer->price ? $offer->price : '0' }}" data-currency="SAR" data-country-code="SA" data-color-type="default" data-show-border="false" data-payment-type="installment" data-disable-installment="false" data-disable-paylater="true" >
                                                    </div>
                                            </div>
                                        </div>
                                        <div class="installment-payment-tabby d-none">
                                            <div class="card">
                                                <div id="tabbyCard">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @error('type_installment')
                                            <span class="text-danger" style="display: block;">{{ $message }}</span>
                                        @enderror
                                </div>
                            </div>
                        <div class="col-lg-12">
                            <button class="btn btn-brand-gradient" data-aos="fade-up">
                            {{ request()->get('step_num') == 1  ? __('system.Next') : __('system.book_now') }}
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
    <script language="javascript">
        $(document).ready(function(){
            var stepNum = $("#StepNum").val();

            var today = new Date();
            var dd = String(today.getDate()).padStart(2, '0');
            var mm = String(today.getMonth() + 1).padStart(2, '0');
            var yyyy = today.getFullYear();

            today = yyyy + '-' + mm + '-' + dd;

            if(stepNum == 2){
                $('#bookingDate').attr('min',today);
            } else {
                $('#bookingDate').attr('min',today).attr('value',today);
            }

        });
        $(document).on('click', '.form-check-label', function() {
            $('.form-check-label').removeClass("checked");
            $(this).addClass('checked');
        });
        $(document).on('click', '.form-check-sublabel', function() {
            $('.form-check-sublabel').removeClass("checked");
            $(this).addClass('checked');
        });
    </script>
    <script>

        function PayBranch() {
            $("#onlinePayment").removeAttr('checked');
            $("#payInstallment").removeAttr('checked');
            $("#payTabby").removeAttr('checked');
            $("#payTamara").removeAttr('checked');
            $('.form-check-sublabel').removeClass("checked");
            $("#payAtClinic").attr('checked', 'checked');
            $("#Installment").addClass("d-none");
            $(".installment-payment-tamara").addClass("d-none");
            $(".installment-payment-tabby").addClass("d-none").css("display", "inline-block");
        }

        function PayOnline() {
            $("#payAtClinic").removeAttr('checked');
            $("#payInstallment").removeAttr('checked');
            $("#payTabby").removeAttr('checked');
            $("#payTamara").removeAttr('checked');
            $('.form-check-sublabel').removeClass("checked");
            $("#onlinePayment").attr('checked', 'checked');
            $("#Installment").addClass("d-none");
            $(".installment-payment-tamara").addClass("d-none");
            $(".installment-payment-tabby").addClass("d-none").css("display", "inline-block");
        }

        function PayInstallment() {
            $("#payAtClinic").removeAttr('checked');
            $("#onlinePayment").removeAttr('checked');
            $("#payInstallment").attr('checked', 'checked');
            $("#Installment").removeClass("d-none");
            $(".installment-payment-tamara").addClass("d-none");
            $(".installment-payment-tabby").addClass("d-none").css("display", "inline-block");
        }

        function PayTabby() {
            $("#payFortInstal").removeAttr('checked');
            $("#payTamara").removeAttr('checked');
            $("#payTabby").attr('checked', 'checked');
            $(".installment-payment-tamara").addClass("d-none");
            $(".installment-payment-tabby").removeClass("d-none").css("display", "inline-block");
        }

        function PayTamara() {
            $("#payFortInstal").removeAttr('checked');
            $("#payTabby").removeAttr('checked');
            $("#payTamara").attr('checked', 'checked');
            $(".installment-payment-tamara").removeClass("d-none");
            $(".installment-payment-tabby").addClass("d-none").css("display", "inline-block");
        }

        function PayFortInstal() {
            $("#payTamara").removeAttr('checked');
            $("#payTabby").removeAttr('checked');
            $("#payFortInstal").attr('checked', 'checked');
            $(".installment-payment-tamara").addClass("d-none");
            $(".installment-payment-tabby").addClass("d-none").css("display", "inline-block");
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

    </script>

    <script src="https://cdn.tamara.co/widget/product-widget.min.js"></script>
    <script>
        setTimeout(() => {
        if (window.TamaraProductWidget) {
            window.TamaraProductWidget.init({ lang: 'en' })
            window.TamaraProductWidget.render()
        }
        }, 2000) // Waiting for 2s - Make sure Tamara's widget is installed
    </script>

    <script src="https://checkout.tabby.ai/tabby-promo.js"></script>
    <script>
        new TabbyPromo({
        selector: '#tabbyCard', // required, content of tabby Promo Snippet will be placed in element with that selector
        currency: 'SAR', // required, currency of your product
        price: '{{ $offer->price ? $offer->price : '0' }}', // required, price or your product
        installmentsCount: 4, // Optional - custom installments number for tabby promo snippet (if not downpayment + 3 installments)
        lang: "{{ app()->getLocale() == 'en'  ?  'en' : 'ar'}}", // optional, language of snippet and popups, if the property is not set, then it is based on the attribute 'lang' of your html tag
        source: 'product', // optional, snippet placement; `product` for product page and `cart` for cart page
        api_key: '{{ $ApiKey }}' // optional, public key which identifies your account when communicating with tabby
        });
    </script>
@endpush
