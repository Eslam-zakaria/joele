@extends('admin.layout.base')

@section('title', 'Create a new Blog')

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
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="basic-form">
                            <form class="form" method="POST" enctype="multipart/form-data" action="{{ route('admin.blogs.store') }}">
                                @method('POST')
                                @csrf

                                <div class="row">
                                    <div class="form-group col-md-4"></div>
                                    <div class="form-group col-md-4 @error('image') has-danger @enderror">
                                        <label class="font-bold">Main Image <span class="text-danger">*</span></label>

                                        <input type="file"
                                               name="image"
                                               class="dropify"
                                               data-height="200"
                                               data-default-file="" />

                                        @error('image')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-4 @error('category_id') has-danger @enderror">
                                        <label for="category_id"> Category <span style="color: red">*</span></label>
                                        <select class="custom-select form-control city-type" id="category_id" name="category_id">
                                            <option value="">-- Select --</option>
                                            @if(!empty($categories))
                                                @foreach($categories as $cat)
                                                    <option value="{{$cat->id}}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{$cat->name}}</option>
                                                @endforeach
                                            @endif
                                        </select>

                                        @error('category_id')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-4 @error('doctor_id') has-danger @enderror">
                                        <label for="doctor_id"> Doctor <span style="color: red">*</span></label>
                                        <select class="custom-select form-control city-type" id="doctor_id" name="doctor_id">
                                            <option value="">-- Select --</option>
                                            @if(!empty($doctors))
                                                @foreach($doctors as $doctor)
                                                    <option value="{{ $doctor->id }}" {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}>{{ $doctor->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>

                                        @error('doctor_id')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-4 @error('locale') has-danger @enderror">
                                        <label for="locale"> Blog Lang <span style="color: red">*</span></label>
                                        <select class="custom-select form-control" id="locale_input" name="locale">
                                            <option value="">-- Select --</option>
                                            @foreach(config('translatable.locales') as $locale)
                                                <option value="{{ $locale }}" {{ old('locale') == $locale ? 'selected' : '' }}>@lang("system.$locale")</option>
                                            @endforeach
                                        </select>

                                        @error('locale')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-12 form-group">
                                        <label for="category_select_input"> Articles</label>

                                        <select class="form-control js-example-basic-multiple" id="parents_select_input" name="parent_id"></select>

                                        @error("parent_id")
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="default-tab" style="width: 100%">
                                        <ul class="nav nav-tabs" role="tablist">
                                            {{-- @foreach(config('translatable.locales') as $locale)
                                                <li class="nav-item">
                                                    <a class="nav-link {{ $loop->first ? 'active' : '' }}" data-toggle="tab" href="#{{ $locale }}"> @lang("system") </a>
                                                </li>
                                            @endforeach --}}
                                        </ul>

                                        <div class="tab-content">

                                            <div class="pt-4 row">
                                                <div class="form-group bmd-form-group col-md-9 @error("title") has-danger @enderror">
                                                    <label for="name_id"> Title <span class="text-danger">*</span></label>
                                                    <input type="text"
                                                           name="title"
                                                           placeholder="Enter title"
                                                           value="{{ old("title") }}"
                                                           onload="convertToSlug(this.value, 'slug_input')"
                                                           onkeyup="convertToSlug(this.value, 'slug_input')"
                                                           class="form-control" />

                                                    @error("title")
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>

                                                <div class="form-group col-md-3">
                                                    <label for="locale">Title header optional</label>
                                                    <select class="custom-select form-control" name="title_header_optional">
                                                        <option value="">-- select --</option>
                                                        <option value="h1" {{ old('title_header_optional') == 'h1' ? 'selected' : '' }}>h1</option>
                                                        <option value="h2" {{ old('title_header_optional') == 'h2' ? 'selected' : '' }}>h2</option>
                                                        <option value="h3" {{ old('title_header_optional') == 'h3' ? 'selected' : '' }}>h3</option>
                                                        <option value="h4" {{ old('title_header_optional') == 'h4' ? 'selected' : '' }}>h4</option>
                                                        <option value="h5" {{ old('title_header_optional') == 'h5' ? 'selected' : '' }}>h5</option>
                                                        <option value="h6" {{ old('title_header_optional') == 'h6' ? 'selected' : '' }}>h6</option>
                                                    </select>

                                                    @error("title_header_optional")
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="form-group col-md-6 @error("slug") has-danger @enderror">
                                                    <label for="slug_id"> Slug <span class="text-danger">*</span></label>

                                                    <input type="text"
                                                           id="slug_input"
                                                           name="slug"
                                                           placeholder="Enter slug"
                                                           value="{{ old("slug") }}"
                                                           class="form-control" />

                                                    @error("slug")
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>

                                                <div class="form-group col-md-6 @error("new_slug") has-danger @enderror">
                                                    <label for="new_slug"> new slug</label>

                                                    <input type="text"
                                                           id="new_slug"
                                                           name="new_slug"
                                                           placeholder="Enter new slug" value="{{ old("new_slug") }}" class="form-control" />

                                                    @error("new_slug")
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>

                                                <div class="form-group col-md-12 @error("description") has-danger @enderror">
                                                    <label for="description_input"> Description <span class="text-danger">*</span></label>

                                                    <textarea id="description_input"
                                                              name="description"
                                                              class="form-control"
                                                              rows="10">{{ old("description") }}</textarea>

                                                    @error("description")
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <hr>
                                            {{-- @foreach(config('translatable.locales') as $locale) --}}
                                            <div class="tab-pane fade active show" id="#" role="tabpanel">

                                                <div class="form-group col-md-12 mt-4">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <h2>Blog Sections</h2>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <button type="button" class="btn btn-primary float-right btn_add_section">
                                                                Add <i class="fa fa-1x fa-plus-square-o"></i>
                                                            </button>
                                                        </div>
                                                    </div>

                                                    <div class="blog_sections mt-4">
                                                        @if(old('sections'))
                                                            @foreach(old('sections') as $key => $sectionRow)
                                                                <div class="row border p-3 mt-3 blog_section blog_row_{{ $key }}">
                                                                    <div class="form-group col-md-12">
                                                                        <button type="button" class="btn btn-danger float-right btn_clear_section" data-row_name="blog_row_{{ $key }}">
                                                                            <i class="fa fa-trash"></i>
                                                                        </button>
                                                                    </div>

                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label for="content_name"> Section color <span class="text-danger">*</span></label>

                                                                            <input type="color"
                                                                                   class="form-control"
                                                                                   value="{{ old("sections.$key.section_color") }}"
                                                                                   name="sections[{{ $key }}][section_color]" />

                                                                            @error("sections.$key.section_color")
                                                                            <span class="text-danger">{{ $message }}</span>
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label for="content_name"> Section Border color </label>

                                                                            <input type="color"
                                                                                   class="form-control"
                                                                                   value="{{ old("sections.$key.color_border") }}"
                                                                                   name="sections[{{ $key }}][color_border]" />

                                                                            @error("sections.$key.color_border")
                                                                            <span class="text-danger">{{ $message }}</span>
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label for="content_name"> Sorting <span class="text-danger">*</span></label>

                                                                            <input type="number"
                                                                                   class="form-control"
                                                                                   value="{{ old("sections.$key.sorting") }}"
                                                                                   name="sections[{{ $key }}][sorting]" />

                                                                            @error("sections.$key.sorting")
                                                                                <span class="text-danger">{{ $message }}</span>
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group col-md-4">
                                                                        <label for="locale"> H optional <span style="color: red">*</span></label>
                                                                        <select class="custom-select form-control" name="sections[{{ $key }}][h_optionl]">
                                                                            <option value="h1" {{ old("sections.$key.h_optionl") == 'h1' ? 'selected' : '' }}>h1</option>
                                                                            <option value="h2" {{ old("sections.$key.h_optionl") == 'h2' ? 'selected' : '' }}>h2</option>
                                                                            <option value="h3" {{ old("sections.$key.h_optionl") == 'h3' ? 'selected' : '' }}>h3</option>
                                                                            <option value="h4" {{ old("sections.$key.h_optionl") == 'h4' ? 'selected' : '' }}>h4</option>
                                                                            <option value="h5" {{ old("sections.$key.h_optionl") == 'h5' ? 'selected' : '' }}>h5</option>
                                                                            <option value="h6" {{ old("sections.$key.h_optionl") == 'h6' ? 'selected' : '' }}>h6</option>
                                                                        </select>

                                                                        @error("sections.$key.h_optionl")
                                                                        <span class="text-danger">{{ $message }}</span>
                                                                        @enderror
                                                                    </div>

                                                                    <div class="col-md-8">
                                                                        <div class="form-group">
                                                                            <label for="content_name"> Section title <span class="text-danger">*</span></label>

                                                                            <input type="text"
                                                                                   class="form-control"
                                                                                   value="{{ old("sections.$key.title") }}"
                                                                                   name="sections[{{ $key }}][title]" />

                                                                            @error("sections.$key.title")
                                                                            <span class="text-danger">{{ $message }}</span>
                                                                            @enderror
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label for="content_input"> Section content <span class="text-danger">*</span></label>

                                                                            <textarea id="content_input"
                                                                                      name="sections[{{ $key }}][content]"
                                                                                      class="form-control summernote_content"
                                                                                      rows="10">{{ old("sections.$key.content") }}</textarea>

                                                                            @error("sections.$key.content")
                                                                            <span class="text-danger">{{ $message }}</span>
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                </div>

                                                <hr>
                                                <div class="col-md-12 mt-3">
                                                    <h2>SEO Details</h2>
                                                    <hr>
                                                    <div class="row">
                                                        <div class="form-group col-md-4">
                                                            <label for="meta_title"> Meta Title</label>

                                                            <input type="text"
                                                                   id="meta_title"
                                                                   name="meta_title"
                                                                   placeholder="Enter title"
                                                                   value="{{ old("meta_title") }}"
                                                                   class="form-control" />

                                                            @error("meta_title")
                                                            <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>

                                                        <div class="form-group col-md-4">
                                                            <label for="canonical"> Canonical Url</label>
                                                            <input type="text"
                                                                   id="canonical"
                                                                   name="canonical"
                                                                   placeholder="Enter Canonical Url"
                                                                   value="{{ old("canonical") }}"
                                                                   class="form-control" />

                                                            @error("canonical")
                                                            <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>

                                                        <div class="form-group col-md-4">
                                                            <label for="alt_image"> Alt image</label>

                                                            <input type="text"
                                                                   id="alt_image"
                                                                   name="alt_image"
                                                                   placeholder="Enter title"
                                                                   value="{{ old("alt_image") }}"
                                                                   class="form-control" />

                                                            @error("alt_image")
                                                            <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>

                                                        <div class="form-group col-md-6">
                                                            <label for="meta_description"> Meta Description</label>

                                                            <textarea id="meta_description"
                                                                      name="meta_description"
                                                                      class="form-control"
                                                                      rows="10">{{ old("meta_description") }}</textarea>

                                                            @error("meta_description")
                                                            <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>

                                                        <div class="form-group col-md-6">
                                                            <label for="meta_keywords"> Meta Keywords</label>

                                                            <textarea id="meta_keywords"
                                                                      name="meta_keywords"
                                                                      class="form-control"
                                                                      rows="10">{{ old("meta_keywords") }}</textarea>

                                                            @error("meta_keywords")
                                                            <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <hr>
                                                </div>
                                                <div class="form-group col-md-12 mt-3" id="doctor_experience">
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

                                                    @if( old('experience') )
                                                        @foreach(old('experience') as $key => $experienceData)
                                                            <div class="row doctor_experience_row mb-4" style="background-color: #f0f1f5d6;">
                                                                <div class="form-group col-md-12">
                                                                    <a onclick="return confirm('Are You Sure You Want To Delete This Record ?')" class="btn btn-danger btn-flat btn-icon-only remove_field mt-2" style="float: right;"> <i class="fa fa-trash-o"></i> </a>
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                    <label for="company_name_input"> Question <span class="text-danger">*</span> </label>
                                                                    <input type="text" id="question_input" name="experience[{{ $key }}][question]" value="{{ old("experience.$key.question") }}" placeholder="Enter Question title" class="form-control" />

                                                                    @error("experience.$key.question")
                                                                    <span class="text-danger">{{ $message }}</span>
                                                                    @enderror
                                                                </div>

                                                                <div class="form-group col-md-6">
                                                                    <label for="company_name_input"> Answer <span class="text-danger">*</span></label>
                                                                    <textarea name="experience[{{ $key }}][answer]" id="answer_input" cols="30" class="form-control" rows="6">{{ old("experience.$key.answer") }}</textarea>

                                                                    @error("experience.$key.answer")
                                                                    <span class="text-danger">{{ $message }}</span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </div>
                                            {{-- @endforeach --}}
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
    <script>
        $('.dropify').dropify();
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote.min.js"></script>

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
        // BEGIN :: remove section
        $(document).on('click', '.btn_clear_section', function (){
            $(this).parent().parent().remove();
        });
        // END :: remove section

        $(document).on('click', '.btn_add_section', function (){

            let rowCount = $('.blog_section').length / 2;

            $row =
                '<div class="row border p-3 mt-3 blog_section blog_row_'+ rowCount +'"> \n'+
                    '<div class="form-group col-md-12"> \n'+
                        '<button type="button" class="btn btn-danger float-right btn_clear_section" data-row_name="blog_row_'+ rowCount +'"> \n'+
                            '<i class="fa fa-trash"></i> \n'+
                        '</button> \n'+
                    '</div> \n'+
                    '<div class="col-md-4"> \n'+
                        '<div class="form-group"> \n'+
                            '<label for="content_name"> Section color <span class="text-danger">*</span></label> \n'+
                            '<input type="color" class="form-control" value="#ffffff" name="sections['+ rowCount +'][section_color]" /> \n'+
                        '</div> \n'+
                    '</div> \n'+
                    '<div class="col-md-4"> \n'+
                        '<div class="form-group"> \n'+
                            '<label for="content_name"> Section Border color </label> \n'+
                            '<input type="color" class="form-control" value="#ffffff" name="sections['+ rowCount +'][color_border]" /> \n'+
                        '</div> \n'+
                    '</div> \n'+

                    '<div class="form-group col-md-4"> \n'+
                        '<label for="locale">Sorting</label> \n'+
                        '<input type="number" min="1" class="form-control" name="sections['+ rowCount +'][sorting]" /> \n'+
                    '</div>\n'+

                    '<div class="form-group col-md-4"> \n'+
                        '<label for="locale"> H optional</label> \n'+
                        '<select class="custom-select form-control" name="sections['+ rowCount +'][h_optionl]"> \n'+
                            '<option value="h1">h1</option> \n'+
                            '<option value="h2">h2</option> \n'+
                            '<option value="h3">h3</option> \n'+
                            '<option value="h4">h4</option> \n'+
                            '<option value="h5">h5</option> \n'+
                            '<option value="h6">h6</option> \n'+
                        '</select> \n'+
                    '</div>\n'+

                    '<div class="col-md-8"> \n'+
                        '<div class="form-group"> \n'+
                            '<label for="content_name"> Section title <span class="text-danger">*</span></label> \n'+
                            '<input type="text" class="form-control" name="sections['+ rowCount +'][title]" /> \n'+
                        '</div> \n'+
                    '</div> \n'+
                    '<div class="col-md-12"> \n'+
                        '<div class="form-group"> \n'+
                            '<label for="content_input"> Section content <span class="text-danger">*</span></label> \n'+
                            '<textarea id="content_input" name="sections['+ rowCount +'][content]" class="form-control summernote_content" rows="10"></textarea> \n'+
                        '</div> \n'+
                    '</div> \n'+
                '</div>';

            $('.blog_sections').append($row);

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
        });
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

            let row_length = $(".doctor_experience_row").length + 1;

            let element =
                '<div class="row doctor_experience_row mb-4" style="background-color: #f0f1f5d6;"> \n'+
                    '<div class="form-group col-md-12">\n'+
                        '<a onClick="return confirm(\'Are You Sure You Want To Delete This Record ?  \')" class="btn btn-danger btn-flat btn-icon-only remove_field mt-2" style="float: right;"> <i class="fa fa-trash-o"></i> </a>' +
                    '</div>\n'+
                    '<div class="form-group col-md-12"> \n'+
                        '<label for="company_name_input"> Question <span class="text-danger">*</span> </label> \n'+
                        '<input type="text" id="question_input" name="experience['+ row_length +'][question]" placeholder="Enter Question title" class="form-control" /> \n'+
                    '</div> \n'+

                '<div class="form-group col-md-12"> \n'+
                    '<label for="answer_input"> Answer <span class="text-danger">*</span> </label> \n'+
                        '<textarea name="experience['+ row_length +'][answer]" id="answer_input" cols="30" class="form-control summernote_content" rows="6"></textarea>\n'+
                    '</div> \n'+
                '</div>';

            $('#doctor_experience').append(element);

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

            $(document).on('click', '.remove_field', function(e) {
                e.preventDefault();
                $(this).parent().parent().remove();
            });
        });
    </script>
    <script>
        $(document).ready(function() {

            var locale_input = $("select[name='locale']").val();
            var category = $("select[name='category_id']").val();
            var token = $("input[name='_token']").val();
            $.ajax({
                url: "<?php echo Url('/super/ajax-BlogsByLocale') ?>",
                method: 'get',
                data: {
                    locale_input: locale,
                    category_id: category,
                    _token: token
                },
                success: function (data) {
                    var myBlogs = $('select[name="parent_id"]');
                    myBlogs.find('option').remove();
                    if (data.status != 401) {
                        myBlogs.append('<option value="">-- Select --</option>');
                        $.each(data.data, function (key, val) {
                            myBlogs.append('<option value="' + val.id + '">' + val.title + '</option>');
                        });
                    } else {
                        myBlogs.append('<option value="">-- No Data Fetch --</option>');
                        // myBranches.prop('disabled', true);
                    }
                }
            });
        });
        $("select[name='locale']").change(function () {
            var locale = $(this).val();
            var category = $("select[name='category_id']").val();
            var token = $("input[name='_token']").val();
            $.ajax({
                url: "<?php echo Url('/super/ajax-BlogsByLocale') ?>",
                method: 'get',
                data: {
                    locale_input: locale,
                    category_id: category,
                    _token: token
                },
                success: function (data) {
                    var myBlogs = $('select[name="parent_id"]');
                    myBlogs.find('option').remove();
                    if (data.status != 401) {
                        myBlogs.append('<option value="">-- Select --</option>');
                        $.each(data.data, function (key, val) {
                            myBlogs.append('<option value="' + val.id + '">' + val.title + '</option>');
                        });
                    } else {
                        myBlogs.append('<option value="">-- No Data Fetch --</option>');
                        // myBranches.prop('disabled', true);
                    }
                }
            });
        });
    </script>
@endpush
