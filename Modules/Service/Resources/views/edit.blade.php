@extends('admin.layout.base')

@section('title', "Edit a Services ( $service->name )")

@push('styles')
    <style>
        .form-control {
            border: 1px solid #c3c4c9;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.css" />
@endpush

@section('content')
    <div class="container-fluid">
        @include('admin.layout.alerts')
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="basic-form">
                            <form class="form" method="POST" enctype="multipart/form-data" action="{{ route('admin.services.update', $service->id) }}">
                                @method('PUT')
                                @csrf

                                <div class="row">
                                    <div class="form-group col-md-6 @error('image') has-danger @enderror">
                                        <label class="font-bold">Image <span class="text-danger">*</span></label>

                                        <input type="file"
                                               name="image"
                                               class="dropify"
                                               data-height="200"
                                               data-default-file="{{ $service->service_image }}"/>

                                        @error('image')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-4 @error('category_id') has-danger @enderror">
                                        <label for="category_id">Category<span style="color: red">*</span></label>

                                        <select class="custom-select form-control city-type" id="category_id" name="category_id">
                                            <option value="">-- Select --</option>
                                            @if(!empty($categories))
                                                @foreach($categories as $category)
                                                    <option value="{{$category->id}}" {{ $service->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>

                                        @error('category_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-4 @error('title_header_option') has-danger @enderror">
                                        <label for="locale"> H optional <span style="color: red">*</span></label>
                                        <select class="custom-select form-control" name="title_header_option">
                                            <option value="h1" {{ $service->title_header_option == 'h1' ? 'selected' : '' }}>h1</option>
                                            <option value="h2" {{ $service->title_header_option == 'h2' ? 'selected' : '' }}>h2</option>
                                            <option value="h3" {{ $service->title_header_option == 'h3' ? 'selected' : '' }}>h3</option>
                                            <option value="h4" {{ $service->title_header_option == 'h4' ? 'selected' : '' }}>h4</option>
                                            <option value="h5" {{ $service->title_header_option == 'h5' ? 'selected' : '' }}>h5</option>
                                            <option value="h6" {{ $service->title_header_option == 'h6' ? 'selected' : '' }}>h6</option>
                                        </select>

                                        @error("title_header_option")
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-4 @error('language') has-danger @enderror">
                                        <label for="locale"> Frequently Lang <span style="color: red">*</span></label>

                                        <select class="custom-select form-control" id="language_input" disabled>
                                            <option value="">-- Select --</option>
                                            @foreach(config('translatable.locales') as $key => $locale)
                                                @php(++$key)
                                                <option value="{{ $key }}" {{ $service->language == $key ? 'selected' : '' }}>
                                                    @lang("system.$locale")
                                                </option>
                                            @endforeach
                                            <option value="3" {{ $service->language == 3 ? 'selected' : '' }}>All</option>
                                        </select>
                                        <input type="hidden" name="language" value="{{ $service->language }}" />
                                    </div>
                                </div>

                                <div class="form-row">
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
                                                    <div class="row pt-4">
                                                        <div class="form-group col-md-4 @error("$locale.name") has-danger @enderror">
                                                            <label for="name_id"> Name {{ $locale }} <span style="color: red">*</span></label>

                                                            <input type="text"
                                                                   id="name_id"
                                                                   name="{{ $locale }}[name]"
                                                                   placeholder="Enter name"
                                                                   onload="convertToSlug(this.value, 'slug_input_{{ $locale }}')"
                                                                   onkeyup="convertToSlug(this.value, 'slug_input_{{ $locale }}')"
                                                                   value="{{ $service->translate($locale)->name ?? '' }}"
                                                                   class="form-control input_{{ $locale }}" />

                                                            @error("$locale.name")
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>

                                                        <div class="form-group col-md-4 @error("$locale.slug") has-danger @enderror">
                                                            <label for="slug_id"> Slug {{ $locale }} <span class="text-danger">*</span></label>

                                                            <input type="text"
                                                                   id="slug_input_{{ $locale }}"
                                                                   name="{{ $locale }}[slug]"
                                                                   placeholder="Enter slug"
                                                                   value="{{ $service->translate($locale)->slug ?? '' }}"
                                                                   class="form-control input_{{ $locale }}" />

                                                            @error("$locale.slug")
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>

                                                        <div class="form-group col-md-4 @error("$locale.new_slug") has-danger @enderror">
                                                            <label for="new_slug"> new slug {{ $locale }}</label>

                                                            <input type="text"
                                                                   id="new_slug"
                                                                   name="{{ $locale }}[new_slug]"
                                                                   placeholder="Enter new slug"
                                                                   value="{{ $service->translate($locale)->new_slug ?? '' }}"
                                                                   class="form-control input_{{ $locale }}" />

                                                            @error("$locale.new_slug")
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>

                                                        <div class="form-group bmd-form-group col-md-12 @error("$locale.description") has-danger @enderror">
                                                            <label for="brif_id"> Description {{ $locale }} <span style="color: red">*</span></label>

                                                            <textarea id="brif_id"
                                                                      name="{{ $locale }}[description]"
                                                                      class="form-control summernote_content input_{{ $locale }}"
                                                                      rows="10">{{ $service->translate($locale)->description ?? '' }}</textarea>

                                                            @error("$locale.description")
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>

                                                        <div class="form-group col-md-12 @error("$locale.content") has-danger @enderror">
                                                            <div class="desciption">
                                                                <label for="content_name"> Content {{ $locale }} <span class="text-danger">*</span></label>

                                                                <textarea id="content_name"
                                                                          name="{{ $locale }}[content]"
                                                                          class="form-control summernote_content input_{{ $locale }}"
                                                                          rows="10">{{ $service->translate($locale)->content ?? '' }}</textarea>

                                                                @error("$locale.content")
                                                                    <span class="text-danger">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                        </div>

                                                        <div class="col-md-12 mt-3">
                                                            <h2>SEO Details</h2>
                                                            <hr>
                                                            <div class="row">
                                                                <div class="form-group col-md-4">
                                                                    <label for="meta_title"> Meta Title {{ $locale }} </label>

                                                                    <input type="text"
                                                                           id="meta_title"
                                                                           name="{{ $locale }}[meta_title]"
                                                                           placeholder="Enter title"
                                                                           value="{{ $service->translate($locale)->meta_title ?? '' }}"
                                                                           class="form-control input_{{ $locale }}" />

                                                                    @error("$locale.meta_title")
                                                                        <span class="text-danger">{{ $message }}</span>
                                                                    @enderror
                                                                </div>

                                                                <div class="form-group col-md-4">
                                                                    <label for="canonical"> Canonical Url {{ $locale }} </label>
                                                                    <input type="text"
                                                                           id="canonical"
                                                                           name="{{ $locale }}[canonical]"
                                                                           placeholder="Enter Canonical Url"
                                                                           value="{{ $service->translate($locale)->canonical ?? '' }}"
                                                                           class="form-control input_{{ $locale }}" />

                                                                    @error("$locale.canonical")
                                                                        <span class="text-danger">{{ $message }}</span>
                                                                    @enderror
                                                                </div>

                                                                <div class="form-group col-md-4">
                                                                    <label for="alt_image"> Alt image {{ $locale }} </label>

                                                                    <input type="text"
                                                                           id="alt_image"
                                                                           name="{{ $locale }}[alt_image]"
                                                                           placeholder="Enter title"
                                                                           value="{{ $service->translate($locale)->alt_image ?? '' }}"
                                                                           class="form-control input_{{ $locale }}" />

                                                                    @error("$locale.alt_image")
                                                                        <span class="text-danger">{{ $message }}</span>
                                                                    @enderror
                                                                </div>

                                                                <div class="form-group col-md-6">
                                                                    <label for="meta_description"> Meta Description {{ $locale }}  </label>

                                                                    <textarea id="meta_description"
                                                                              name="{{ $locale }}[meta_description]"
                                                                              class="form-control input_{{ $locale }}"
                                                                              rows="10">{{ $service->translate($locale)->meta_description ?? '' }}</textarea>

                                                                    @error("$locale.meta_description")
                                                                        <span class="text-danger">{{ $message }}</span>
                                                                    @enderror
                                                                </div>

                                                                <div class="form-group col-md-6">
                                                                    <label for="meta_keywords"> Meta Keywords {{ $locale }} </label>

                                                                    <textarea id="meta_keywords"
                                                                              name="{{ $locale }}[meta_keywords]"
                                                                              class="form-control input_{{ $locale }}"
                                                                              rows="10">{{ $service->translate($locale)->meta_keywords ?? '' }}</textarea>

                                                                    @error("$locale.meta_keywords")
                                                                        <span class="text-danger">{{ $message }}</span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <hr>
                                                        </div>
                                                        <div class="form-group col-md-12 mt-3" id="doctor_experience_{{ $locale }}">
                                                            <div class="d-flex row">
                                                                <div class="col-md-6">
                                                                    <h2>FAQ</h2>
                                                                </div>

                                                                <div class="col-md-6">
                                                                    <button class="btn btn-outline-success float-right btn_add_experience" type="button">
                                                                        <i class="fa fa-plus"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                            <hr>

                                                            @if( $getQuestions )
                                                                @foreach($getQuestions as $key => $experienceData)
                                                                    <div class="row doctor_experience_row_{{ $locale }} mb-4" style="background-color: #f0f1f5d6;">
                                                                        <input type="hidden" name="experienceEdit[{{ $key }}][id]" value="{{ $experienceData->id }}" class="form-control">

                                                                        <div class="form-group col-md-12">
                                                                            <a onclick="return confirm('Are You Sure You Want To Delete This Record ?')" href="{{ route('admin.service.details.deleted',['question' => $experienceData->id]) }}" class="btn btn-danger btn-flat btn-icon-only mt-2" style="float: right;"> <i class="fa fa-trash-o"></i> </a>
                                                                        </div>
                                                                        <div class="form-group col-md-12">
                                                                            <label for="company_name_input"> Question {{ $locale }} <span class="text-danger">*</span></label>
                                                                            <input type="text"
                                                                                   id="question_input"
                                                                                   name="experienceEdit[{{ $key }}][{{ $locale }}][question]"
                                                                                   value="{{ $experienceData->translate($locale)->question ?? '' }}"
                                                                                   placeholder="Enter Question title"
                                                                                   class="form-control input_{{ $locale }}" />

                                                                            @error("experience.$key.$locale.question")
                                                                                <span class="text-danger">{{ $message }}</span>
                                                                            @enderror
                                                                        </div>

                                                                        <div class="form-group col-md-12">
                                                                            <label for="company_name_input"> Answer {{ $locale }} <span class="text-danger">*</span></label>
                                                                            <textarea name="experienceEdit[{{ $key }}][{{ $locale }}][answer]"
                                                                                      id="answer_input"
                                                                                      cols="30"
                                                                                      class="form-control summernote_content input_{{ $locale }}"
                                                                                      rows="6">{{ $experienceData->translate($locale)->answer ?? '' }}</textarea>

                                                                            @error("experience.$key.$locale.answer")
                                                                                <span class="text-danger">{{ $message }}</span>
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            @endif

                                                            @if( old('experience') )
                                                                @foreach(old('experience') as $key => $experienceData)
                                                                    <div class="row doctor_experience_row_{{ $locale }} mb-4" style="background-color: #f0f1f5d6;">
                                                                        <div class="form-group col-md-12">
                                                                            <a onclick="return confirm('Are You Sure You Want To Delete This Record ?')" class="btn btn-danger btn-flat btn-icon-only remove_field mt-2" style="float: right;"> <i class="fa fa-trash-o"></i> </a>
                                                                        </div>
                                                                        <div class="form-group col-md-12">
                                                                            <label for="company_name_input"> Question {{ $locale }} <span class="text-danger">*</span> </label>
                                                                            <input type="text"
                                                                                   id="question_input"
                                                                                   name="experience[{{ $key }}][{{ $locale }}][question]"
                                                                                   value="{{ old("experience.$key.$locale.question") }}"
                                                                                   placeholder="Enter Question title"
                                                                                   class="form-control input_{{ $locale }}" />

                                                                            @error("experience.$key.$locale.question")
                                                                                <span class="text-danger">{{ $message }}</span>
                                                                            @enderror
                                                                        </div>

                                                                        <div class="form-group col-md-12">
                                                                            <label for="company_name_input"> Answer {{ $locale }} <span class="text-danger">*</span></label>
                                                                            <textarea name="experience[{{ $key }}][{{ $locale }}][answer]"
                                                                                      id="answer_input"
                                                                                      cols="30"
                                                                                      class="form-control summernote_content input_{{ $locale }}"
                                                                                      rows="6">{{ old("experience.$key.$locale.answer") }}</textarea>

                                                                            @error("experience.$key.$locale.answer")
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

                                <button type="submit" class="btn btn-primary pull-right">Save</button>
                                <button type="button" onclick="parent.history.back();" class="btn btn-danger">Back</button>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote.min.js"></script>

    <script>
        $('.dropify').dropify();

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
                '<div class="row doctor_experience_row_{{ $locale }} mb-4" style="background-color: #f0f1f5d6;"> \n'+
                '<div class="form-group col-md-12">\n'+
                '<a onClick="return confirm(\'Are You Sure You Want To Delete This Record ?  \')" class="btn btn-danger btn-flat btn-icon-only remove_field mt-2" style="float: right;"> <i class="fa fa-trash-o"></i> </a>' +
                '</div>\n'+
                '<div class="form-group col-md-12"> \n'+
                '<label for="company_name_input"> Question {{ $locale }} <span class="text-danger">*</span> </label> \n'+
                '<input type="text" id="question_input" name="experience['+ row_length_{{ $locale }} +'][{{ $locale }}][question]" placeholder="Enter Question title" class="form-control input_{{ $locale }}" /> \n'+
                '</div> \n'+

                '<div class="form-group col-md-12"> \n'+
                '<label for="answer_input"> Answer {{ $locale }} <span class="text-danger">*</span> </label> \n'+
                '<textarea name="experience['+ row_length_{{ $locale }} +'][{{ $locale }}][answer]" id="answer_input" cols="30" class="form-control summernote_content input_{{ $locale }}" rows="6"></textarea>\n'+
                '</div> \n'+
                '</div>';

                $('#doctor_experience_{{ $locale }}').append(element_{{ $locale }});

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
            @endforeach
            $(document).on('click', '.remove_field', function(e) {
                e.preventDefault();
                $(this).parent().parent().remove();
            });
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
