@extends('admin.layout.base')

@section('title', 'Create a new Doctor')

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.css" />
@endpush

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="basic-form">
                            <form class="form" method="POST" enctype="multipart/form-data" action="{{ route('admin.doctors.store') }}">
                                @method('POST')
                                @csrf

                                <div class="row">
                                    <div class="form-group col-md-3"></div>
                                    <div class="form-group col-md-4 @error('image') has-danger @enderror">
                                        <label class="font-bold"> Image <span class="text-danger">*</span></label>

                                        <input type="file"
                                               name="image"
                                               class="dropify"
                                               data-height="200"
                                               data-default-file=""/>

                                        @error('image')
                                            <span class="text-danger">{{ $message }}</span>
                                        @endError
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-4 @error('title_header_option') has-danger @enderror">
                                        <label for="locale"> H optional <span style="color: red">*</span></label>
                                        <select class="custom-select form-control" name="title_header_option">
                                            <option value="h1" {{ old("title_header_option") == 'h1' ? 'selected' : '' }}>h1</option>
                                            <option value="h2" {{ old("title_header_option") == 'h2' ? 'selected' : '' }}>h2</option>
                                            <option value="h3" {{ old("title_header_option") == 'h3' ? 'selected' : '' }}>h3</option>
                                            <option value="h4" {{ old("title_header_option") == 'h4' ? 'selected' : '' }}>h4</option>
                                            <option value="h5" {{ old("title_header_option") == 'h5' ? 'selected' : '' }}>h5</option>
                                            <option value="h6" {{ old("title_header_option") == 'h6' ? 'selected' : '' }}>h6</option>
                                        </select>

                                        @error("title_header_option")
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-4 @error('specialization_title_header_option') has-danger @enderror">
                                        <label for="locale"> Specialization H optional <span style="color: red">*</span></label>
                                        <select class="custom-select form-control" name="specialization_title_header_option">
                                            <option value="h1" {{ old("specialization_title_header_option") == 'h1' ? 'selected' : '' }}>h1</option>
                                            <option value="h2" {{ old("specialization_title_header_option") == 'h2' ? 'selected' : '' }}>h2</option>
                                            <option value="h3" {{ old("specialization_title_header_option") == 'h3' ? 'selected' : '' }}>h3</option>
                                            <option value="h4" {{ old("specialization_title_header_option") == 'h4' ? 'selected' : '' }}>h4</option>
                                            <option value="h5" {{ old("specialization_title_header_option") == 'h5' ? 'selected' : '' }}>h5</option>
                                            <option value="h6" {{ old("specialization_title_header_option") == 'h6' ? 'selected' : '' }}>h6</option>
                                        </select>

                                        @error("specialization_title_header_option")
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-4 @error('language') has-danger @enderror">
                                        <label for="locale"> Frequently Lang <span style="color: red">*</span></label>

                                        <select class="custom-select form-control" id="language_input" name="language">
                                            <option value="">-- Select --</option>
                                            @foreach(config('translatable.locales') as $key => $locale)
                                                @php(++$key)
                                                <option value="{{ $key }}" {{ old('language') == $key ? 'selected' : '' }}>
                                                    @lang("system.$locale")
                                                </option>
                                            @endforeach
                                            <option value="3" {{ old('language') == 3 ? 'selected' : '' }}>All</option>
                                        </select>

                                        @error('language')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-5">
                                    <!-- BEGIN :: regular data -->
                                    <div class="col-md-12">
                                        <div class="default-tab" style="width: 100%">
                                            <ul class="nav nav-tabs" role="tablist">
                                                @foreach(config('translatable.locales') as $locale)
                                                    <li class="nav-item tab_lang_{{ $locale }}">
                                                        <a class="nav-link {{ $loop->first ? 'active' : '' }}"
                                                           data-toggle="tab"
                                                           href="#{{ $locale }}">
                                                            @lang("system.$locale")
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>

                                            <div class="tab-content">
                                                @foreach(config('translatable.locales') as $locale)
                                                    <div class="tab-pane fade {{ $loop->first ? "active show" : '' }} tab_content_{{ $locale }}" id="{{ $locale }}" role="tabpanel">
                                                        <div class="pt-4 row">
                                                            <div class="form-group bmd-form-group col-md-6 @error("$locale.name") has-danger @enderror">
                                                                <label for="name_id"> Name {{ $locale }} <span class="text-danger">*</span></label>

                                                                <input type="text"
                                                                       id="name_id"
                                                                       name="{{ $locale }}[name]"
                                                                       placeholder="Enter name"
                                                                       value="{{ old("$locale.name") }}"
                                                                       onload="convertToSlug(this.value, 'slug_input_{{ $locale }}')"
                                                                       onkeyup="convertToSlug(this.value, 'slug_input_{{ $locale }}')"
                                                                       class="form-control input_{{ $locale }}" />

                                                                @error("$locale.name")
                                                                    <span class="text-danger">{{ $message }}</span>
                                                                @enderror
                                                            </div>

                                                            <div class="form-group bmd-form-group col-md-6 @error("$locale.slug") has-danger @enderror">
                                                                <label for="select_page_id"> Slug {{ $locale }} <span class="text-danger">*</span></label>

                                                                <input type="text"
                                                                       id="slug_input_{{ $locale }}"
                                                                       name="{{ $locale }}[slug]"
                                                                       placeholder="Enter slug"
                                                                       value="{{ old("$locale.slug") }}"
                                                                       class="form-control input_{{ $locale }}" />

                                                                @error("$locale.slug")
                                                                    <span class="text-danger">{{ $message }}</span>
                                                                @enderror
                                                            </div>

                                                            <div class="form-group bmd-form-group col-md-12 @error("$locale.experience_years") has-danger @enderror">
                                                                <label for="name_id"> Experience years {{ $locale }} <span class="text-danger">*</span></label>

                                                                <input type="text"
                                                                       id="name_id"
                                                                       name="{{ $locale }}[experience_years]"
                                                                       placeholder="Enter experience years"
                                                                       value="{{ old("$locale.experience_years") }}"
                                                                       class="form-control input_{{ $locale }}" />

                                                                @error("$locale.experience_years")
                                                                    <span class="text-danger">{{ $message }}</span>
                                                                @enderror
                                                            </div>

                                                            <div class="form-group bmd-form-group col-md-12 @error("$locale.description") has-danger @enderror">
                                                                <label for="select_page_id"> Description {{ $locale }} <span class="text-danger">*</span></label>

                                                                <textarea
                                                                    id="input_page_name"
                                                                    name="{{ $locale }}[description]"
                                                                    class="form-control summernote_content input_{{ $locale }}"
                                                                    rows="10">{{ old("$locale.description") }}</textarea>

                                                                @error("$locale.description")
                                                                    <span class="text-danger">{{ $message }}</span>
                                                                @enderror
                                                            </div>

                                                            <div class="form-group col-md-12">
                                                                <label for="meta_title"> Meta Title {{ $locale }} </label>

                                                                <input type="text"
                                                                       id="meta_title"
                                                                       name="{{ $locale }}[meta_title]"
                                                                       placeholder="Enter title"
                                                                       value="{{ old("$locale.meta_title") }}"
                                                                       class="form-control input_{{ $locale }}" />

                                                                @error("$locale.meta_title")
                                                                    <span class="text-danger">{{ $message }}</span>
                                                                @enderror
                                                            </div>

                                                            <div class="form-group col-md-12">
                                                                <label for="canonical"> Canonical Url {{ $locale }} </label>

                                                                <input type="text"
                                                                       id="canonical"
                                                                       name="{{ $locale }}[canonical]"
                                                                       placeholder="Enter Canonical Url"
                                                                       value="{{ old("$locale.canonical") }}"
                                                                       class="form-control input_{{ $locale }}" />

                                                                @error("$locale.canonical")
                                                                    <span class="text-danger">{{ $message }}</span>
                                                                @enderror
                                                            </div>

                                                            <div class="form-group col-md-12">
                                                                <label for="meta_description"> Meta Description {{ $locale }} </label>

                                                                <textarea id="meta_description"
                                                                          name="{{ $locale }}[meta_description]"
                                                                          class="form-control summernote_content input_{{ $locale }}"
                                                                          rows="10">{{ old("$locale.meta_description") }}</textarea>

                                                                @error("$locale.meta_description")
                                                                    <span class="text-danger">{{ $message }}</span>
                                                                @enderror
                                                            </div>

                                                            <div class="form-group col-md-12">
                                                                <label for="meta_keywords"> Meta Keywords {{ $locale }} </label>

                                                                <textarea id="meta_keywords"
                                                                          name="{{ $locale }}[meta_keywords]"
                                                                          class="form-control input_{{ $locale }}"
                                                                          rows="5">{{ old("$locale.meta_keywords") }}</textarea>

                                                                @error("$locale.meta_keywords")
                                                                    <span class="text-danger">{{ $message }}</span>
                                                                @enderror
                                                            </div>

                                                            <div class="form-group col-md-12">
                                                                <label for="alt_image"> Alt image {{ $locale }} </label>

                                                                <input type="text"
                                                                       id="alt_image"
                                                                       name="{{ $locale }}[alt_image]"
                                                                       placeholder="Enter title"
                                                                       value="{{ old("$locale.alt_image") }}"
                                                                       class="form-control input_{{ $locale }}" />

                                                                @error("$locale.alt_image")
                                                                    <span class="text-danger">{{ $message }}</span>
                                                                @enderror
                                                            </div>

                                                            <div class="form-group col-md-12 mt-5" id="doctor_experience_{{ $locale }}">
                                                                <div class="d-flex row">
                                                                    <div class="col-md-6">
                                                                        <h2>Experience</h2>
                                                                    </div>

                                                                    <div class="col-md-6">
                                                                        <button class="btn btn-primary float-right btn_add_experience" type="button">
                                                                            <i class="fa fa-plus"></i>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                                <hr>

                                                                @if( old('experience') )
                                                                    @foreach(old('experience') as $key => $experienceData)
                                                                        <div class="row doctor_experience_row_{{ $locale }}">
                                                                            <div class="form-group col-md-6">
                                                                                <label for="company_name_input"> Company name {{ $locale }} </label>

                                                                                <input type="text"
                                                                                       id="company_name_input"
                                                                                       name="experience[{{ $key }}][{{ $locale }}][company_name]"
                                                                                       placeholder="Enter company name"
                                                                                       value="{{ old("experience.$key.$locale.company_name") }}"
                                                                                       class="form-control input_{{ $locale }}" />

                                                                                @error("experience.$key.$locale.company_name")
                                                                                    <span class="text-danger">{{ $message }}</span>
                                                                                @enderror
                                                                            </div>

                                                                            <div class="form-group col-md-6">
                                                                                <label for="company_name_input"> Specialization {{ $locale }} </label>

                                                                                <input type="text"
                                                                                       id="specialization_input"
                                                                                       name="experience[{{ $key }}][{{ $locale }}][specialization]"
                                                                                       placeholder="Enter specialization"
                                                                                       value="{{ old("experience.$key.$locale.specialization") }}"
                                                                                       class="form-control input_{{ $locale }}" />

                                                                                @error("experience.$key.$locale.specialization")
                                                                                    <span class="text-danger">{{ $message }}</span>
                                                                                @enderror
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <!-- END :: regular data -->

                                    <!-- BEGIN :: Category and services section -->
                                    <div class="col-md-12 mt-5">
                                        <h2>Category And Services</h2>

                                        <hr>

                                        <div class="row">
                                            <div class="col-md-12 form-group">
                                                <label for="category_select_input"> Category </label>

                                                <select name="category_id" id="category_select_input" class="form-control">
                                                    <option value="">-- select --</option>

                                                    @foreach($categories as $category)
                                                        <option value="{{ $category->id }}" data-services="{{ $category->services }}" data-specialization="{{ $category->specialization }}" {{ old('category_id') ==  $category->id ? 'selected' : '' }}>
                                                            {{ $category->name }}
                                                        </option>
                                                    @endforeach
                                                </select>

                                                @error("category_id")
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="col-md-12 form-group">
                                                <label for="category_select_input"> Services </label>

                                                <select class="form-control js-example-basic-multiple" id="services_select_input" name="services[]" multiple="multiple"></select>

                                                @error("services")
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <!-- END :: Category and services section -->

                                    <!-- BEGIN :: branches section -->
                                    <div class="col-md-12 mt-5">
                                        <h2>Branches</h2>

                                        <hr>

                                        <div class="row">
                                            <div class="col-md-12 form-group">
                                                <label for="category_select_input"> Branches </label>

                                                <select class="form-control js-example-basic-multiple" id="branches_select_input" name="branches[]" multiple="multiple">
                                                    @foreach($branches as $branch)
                                                        <option value="{{ $branch->id }}" {{ ( old('branches') && in_array($branch->id, old('branches')) ) ? 'selected' : '' }}>
                                                            {{ $branch->name }}
                                                        </option>
                                                    @endforeach
                                                </select>

                                                @error('branches')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <!-- END :: branches section -->

                                    <!-- BEGIN :: specializations section -->
                                    <div class="col-md-12 mt-5">
                                        <h2>Specializations</h2>

                                        <hr>

                                        <div class="row">
                                            <div class="col-md-12 form-group">
                                                <label for="specializations_select_input"> Specializations </label>

                                                <select class="form-control js-example-basic-multiple" id="specializations_select_input" name="specializations[]" multiple="multiple">
                                                </select>

                                                @error('specializations')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <!-- END :: specializations section -->

                                    <!-- BEGIN :: social media -->
                                    <div class="col-md-12 mt-5">
                                        <h2>Social media links</h2>

                                        <hr>

                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label for="social_instagram"> Instagram </label>

                                                <input type="text"
                                                       id="social_instagram"
                                                       name="social[instagram]"
                                                       placeholder="Enter instagram link"
                                                       value="{{ old("social.instagram") }}"
                                                       class="form-control" />

                                                @error("social.instagram")
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="col-md-6 form-group">
                                                <label for="social_youtube"> Youtube </label>

                                                <input type="text"
                                                       id="social_youtube"
                                                       name="social[youtube]"
                                                       placeholder="Enter youtube link"
                                                       value="{{ old("social.youtube") }}"
                                                       class="form-control" />

                                                @error("social.youtube")
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="col-md-6 form-group">
                                                <label for="social_facebook"> Facebook </label>

                                                <input type="text"
                                                       id="social_facebook"
                                                       name="social[facebook]"
                                                       placeholder="Enter facebook link"
                                                       value="{{ old("social.facebook") }}"
                                                       class="form-control" />

                                                @error("social.facebook")
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="col-md-6 form-group">
                                                <label for="social_twitter"> Twitter </label>

                                                <input type="text"
                                                       id="social_twitter"
                                                       name="social[twitter]"
                                                       placeholder="Enter twitter link"
                                                       value="{{ old("social.twitter") }}"
                                                       class="form-control" />

                                                @error("social.twitter")
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="col-md-6 form-group">
                                                <label for="social_snapchat"> Snapchat </label>

                                                <input type="text"
                                                       id="social_snapchat"
                                                       name="social[snapchat]"
                                                       placeholder="Enter snapchat link"
                                                       value="{{ old("social.snapchat") }}"
                                                       class="form-control" />

                                                @error("social.snapchat")
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="col-md-6 form-group">
                                                <label for="social_whats_app"> Whats app </label>

                                                <input type="text"
                                                       id="social_whats_app"
                                                       name="social[whats_app]"
                                                       placeholder="Enter whats_app link"
                                                       value="{{ old("social.whats_app") }}"
                                                       class="form-control" />

                                                @error("social.whats_app")
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="col-md-6 form-group">
                                                <label for="social_email"> Email </label>

                                                <input type="text"
                                                       id="social_email"
                                                       name="social[email]"
                                                       placeholder="Enter email link"
                                                       value="{{ old("social.email") }}"
                                                       class="form-control" />

                                                @error("social.email")
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <!-- END :: social media -->
                                </div>

                                <button type="submit" class="btn btn-primary pull-right mt-3">Save</button>
                                <button type="button" onclick="parent.history.back();" class="btn btn-danger mt-3">Back</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote.min.js"></script>

    <script>
        $(document).ready(function () {
            $('.dropify').dropify();
        })

        $('body').ready(".js-example-basic-multiple", function(){
            $(this).select2();
        });
    </script>

    <script>
        $(document).ready(function () {
            let services = $('#category_select_input').find(':selected').data('services');

            let specialization = $('#category_select_input').find(':selected').data('specialization');

            if( services != undefined ){
                $.each(services, function (index, value){
                    $('#services_select_input').append('<option value="'+ value.id +'">'+ value.name +'</option>');
                });
            }

            if( specialization != undefined ){
                $.each(specialization, function (index, value){
                    $('#specializations_select_input').append('<option value="'+ value.id +'">'+ value.name +'</option>');
                });
            }
        })

        $(document).on('click', '#category_select_input', function () {
            let services = $('#category_select_input').find(':selected').data('services');

            let specialization = $('#category_select_input').find(':selected').data('specialization');

            $('#services_select_input').empty();

            $('#specializations_select_input').empty();

            $.each(services, function (index, value){
                $('#services_select_input').append('<option value="'+ value.id +'">'+ value.name +'</option>');
            });

            $.each(specialization, function (index, value){
                $('#specializations_select_input').append('<option value="'+ value.id +'">'+ value.name +'</option>');
            });
        })
    </script>

    <script>
        /* Encode string to slug */
        function convertToSlug( str, element ) {

            //replace all special characters | symbols with a space
            str = str.replace(/[`~!@#$%^&*()_\-+=\[\]{};:'"\\|\/,.<>?\s]/g, ' ')
                .toLowerCase();

            // trim spaces at start and end of string
            str = str.replace(/^\s+|\s+$/gm,'');

            // replace space with dash/hyphen
            str = str.replace(/\s+/g, '-');

            $('#' + element).val(str);
        }
    </script>

    <script>
        $(document).on('click', '.btn_add_experience', function () {

            @foreach(config('translatable.locales') as $locale)

                let row_length_{{ $locale }} = $(".doctor_experience_row_{{ $locale }}").length + 1;

                let element_{{ $locale }} =
                    '<div class="row doctor_experience_row_{{ $locale }}"> \n'+
                        '<div class="form-group col-md-6"> \n'+
                            '<label for="company_name_input"> Company name {{ $locale }} <span class="text-danger">*</span> </label> \n'+
                            '<input type="text" id="company_name_input" name="experience['+ row_length_{{ $locale }} +'][{{ $locale }}][company_name]" placeholder="Enter company name" class="form-control input_{{ $locale }}" /> \n'+
                        '</div> \n'+

                        '<div class="form-group col-md-6"> \n'+
                            '<label for="specialization_input"> Specialization {{ $locale }} <span class="text-danger">*</span> </label> \n'+
                            '<input type="text" id="specialization_input" name="experience['+ row_length_{{ $locale }} +'][{{ $locale }}][specialization]" placeholder="Enter Specialization" class="form-control input_{{ $locale }}" /> \n'+
                        '</div> \n'+
                    '</div>';

                $('#doctor_experience_{{ $locale }}').append(element_{{ $locale }});
            @endforeach
        });
    </script>

    <script>
        $('.summernote_content').summernote({
            placeholder: 'Enter your content.',
            tabsize: 10,
            height: 300,
            callbacks: {
                onPaste(e) {
                    const bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData).getData('Text');
                    e.preventDefault();
                    document.execCommand('insertText', false, bufferText);
                }
            }
        });
    </script>

    <script>
        $(document).on('change', '#language_input', function () {
            if( $(this).val() == 1 ){
                // English
                $('.tab_lang_en').removeClass('d-none').find('.nav-link').addClass('active');
                $('.tab_lang_ar').addClass('d-none');
                $('.tab_content_ar').addClass('d-none').removeClass('active show');
                $('.tab_content_en').removeClass('d-none').addClass('active show');
                $('.input_ar').attr('disabled', true);
                $('.input_en').removeAttr('disabled');

            }else if ( $(this).val() == 2 ) {
                // Arabic
                $('.tab_lang_en').addClass('d-none');
                $('.tab_lang_ar').removeClass('d-none').find('.nav-link').addClass('active');
                $('.tab_content_en').addClass('d-none').removeClass('active show');
                $('.tab_content_ar').removeClass('d-none').addClass('active show');
                $('.input_en').attr('disabled', true);
                $('.input_ar').removeAttr('disabled');

            }else if( $(this).val() == 3 ) {
                // Both
                $('.tab_lang_en').removeClass('d-none').find('.nav-link').addClass('active');
                $('.tab_lang_ar').removeClass('d-none').find('.nav-link').removeClass('active');
                $('.tab_content_en').removeClass('d-none').addClass('active show');
                $('.tab_content_ar').removeClass('d-none active show');
                $('.input_ar').removeAttr('disabled');
                $('.input_en').removeAttr('disabled');
            }
        });

        $(document).ready(function () {
            if( $('#language_input').val() == 1 ){
                // English
                $('.tab_lang_en').removeClass('d-none').find('.nav-link').addClass('active');
                $('.tab_lang_ar').addClass('d-none');
                $('.tab_content_ar').addClass('d-none').removeClass('active show');
                $('.tab_content_en').removeClass('d-none').addClass('active show');
                $('.input_ar').attr('disabled', true);
                $('.input_en').removeAttr('disabled');

            }else if ( $('#language_input').val() == 2 ) {
                // Arabic
                $('.tab_lang_en').addClass('d-none');
                $('.tab_lang_ar').removeClass('d-none').find('.nav-link').addClass('active');
                $('.tab_content_en').addClass('d-none').removeClass('active show');
                $('.tab_content_ar').removeClass('d-none').addClass('active show');
                $('.input_en').attr('disabled', true);
                $('.input_ar').removeAttr('disabled');

            }else if( $('#language_input').val() == 3 ) {
                // Both
                $('.tab_lang_en').removeClass('d-none').find('.nav-link').addClass('active');
                $('.tab_lang_ar').removeClass('d-none').find('.nav-link').removeClass('active');
                $('.tab_content_en').removeClass('d-none').addClass('active show');
                $('.tab_content_ar').removeClass('d-none active show');
                $('.input_ar').removeAttr('disabled');
                $('.input_en').removeAttr('disabled');
            }
        });
    </script>
@endpush
