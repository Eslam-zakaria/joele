@extends('admin.layout.base')

@section('title', "Copy blog ( " . $blog->translate(app()->getLocale())->title . " )")

@push('styles')
    <style>
        .form-control {
            border: 1px solid #c3c4c9;
        }
    </style>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.css" />
    <!-- include summernote css/js -->
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
                                @csrf

                                <div class="row">
                                    <div class="form-group col-md-6 @error('image') has-danger @enderror">
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
                                    <div class="form-group col-md-6 @error('category_id') has-danger @enderror">
                                        <label for="category_id"> Category <span style="color: red">*</span></label>
                                        <select class="custom-select form-control city-type" id="category_id" name="category_id">
                                            <option value="">-- Select --</option>
                                            @if(!empty($categories))
                                                @foreach($categories as $cat)
                                                    <option value="{{$cat->id}}" {{ $blog->category_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>

                                        @error('category_id')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6 @error('doctor_id') has-danger @enderror">
                                        <label for="doctor_id"> Doctor <span style="color: red">*</span></label>
                                        <select class="custom-select form-control city-type" id="doctor_id" name="doctor_id">
                                            <option value="">-- Select --</option>
                                            @if(!empty($doctors))
                                                @foreach($doctors as $doctor)
                                                    <option value="{{ $doctor->id }}" {{ $blog->doctor_id == $doctor->id ? 'selected' : '' }}>{{ $doctor->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>

                                        @error('doctor_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="default-tab" style="width: 100%">
                                        <ul class="nav nav-tabs" role="tablist">
                                            @foreach(config('translatable.locales') as $locale)
                                                <li class="nav-item">
                                                    <a class="nav-link {{ $loop->first ? 'active' : '' }}" data-toggle="tab" href="#{{ $locale }}">@lang("system.$locale")</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                        <div class="tab-content">
                                            @foreach(config('translatable.locales') as $locale)
                                                <div class="tab-pane fade {{ $loop->first ? "active show" : '' }}" id="{{ $locale }}" role="tabpanel">
                                                    <div class="pt-4 row">
                                                        <div class="form-group bmd-form-group col-md-12 @error("$locale.title") has-danger @enderror">
                                                            <label for="name_id"> Name {{ $locale }} <span class="text-danger">*</span></label>

                                                            <input type="text"
                                                                   id="name_id"
                                                                   name="{{ $locale }}[title]"
                                                                   placeholder="Enter title"
                                                                   value="{{ $blog->translate($locale)->title }}"
                                                                   onload="convertToSlug(this.value, 'slug_input_{{ $locale }}')"
                                                                   onkeyup="convertToSlug(this.value, 'slug_input_{{ $locale }}')"
                                                                   class="form-control" />

                                                            @error("$locale.title")
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>

                                                        <div class="form-group col-md-6 @error("$locale.slug") has-danger @enderror">
                                                            <label for="slug_id"> Slug {{ $locale }} <span class="text-danger">*</span></label>

                                                            <input type="text"
                                                                   id="slug_input_{{ $locale }}"
                                                                   name="{{ $locale }}[slug]"
                                                                   placeholder="Enter slug"
                                                                   value="{{ $blog->translate($locale)->slug }}"
                                                                   class="form-control" />

                                                            @error("$locale.slug")
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>

                                                        <div class="form-group col-md-6 @error("$locale.new_slug") has-danger @enderror">
                                                            <label for="new_slug"> new slug {{ $locale }}</label>

                                                            <input type="text"
                                                                   id="new_slug"
                                                                   name="{{ $locale }}[new_slug]"
                                                                   placeholder="Enter new slug"
                                                                   value="{{ $blog->translate($locale)->new_slug }}"
                                                                   class="form-control" />

                                                            @error("$locale.new_slug")
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>

                                                        <div class="form-group col-md-12 @error("$locale.description") has-danger @enderror">
                                                            <label for="description_input"> Description {{ $locale }} <span class="text-danger">*</span></label>

                                                            <textarea id="description_input"
                                                                      name="{{ $locale }}[description]"
                                                                      class="form-control"
                                                                      rows="10">{{ $blog->translate($locale)->description }}</textarea>

                                                            @error("$locale.description")
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>

                                                        <div class="form-group col-md-12 mt-4">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <h1 class="">Blog Sections</h1>
                                                                </div>

                                                                <div class="col-md-6">
                                                                    <button type="button" class="btn btn-primary float-right btn_add_section">
                                                                        Add <i class="fa fa-1x fa-plus-square-o"></i>
                                                                    </button>
                                                                </div>
                                                            </div>

                                                            <div class="blog_sections_{{ $locale }} mt-4">
                                                                @if($blog->sections)
                                                                    @foreach($blog->sections as $key => $sectionRow)
                                                                        <div class="row border p-3 mt-3 blog_section blog_row_{{ $key }}">
                                                                            <div class="form-group col-md-12">
                                                                                <button type="button" class="btn btn-danger float-right btn_clear_section" data-row_name="blog_row_{{ $key }}">
                                                                                    <i class="fa fa-trash"></i>
                                                                                </button>
                                                                            </div>

                                                                            <div class="col-md-2">
                                                                                <div class="form-group">
                                                                                    <label for="content_name"> Section color {{ $locale }} <span class="text-danger">*</span></label>

                                                                                    <input type="color"
                                                                                           class="form-control"
                                                                                           value="{{ $sectionRow->translate($locale)->section_color ?? '#ffffff' }}"
                                                                                           name="sections[{{ $key }}][{{ $locale }}][section_color]" />

                                                                                    @error("sections.$key.$locale.section_color")
                                                                                        <span class="text-danger">{{ $message }}</span>
                                                                                    @enderror
                                                                                </div>
                                                                            </div>


                                                                            <div class="col-md-10">
                                                                                <div class="form-group">
                                                                                    <label for="content_name"> Section title {{ $locale }} <span class="text-danger">*</span></label>

                                                                                    <input type="text"
                                                                                           class="form-control"
                                                                                           value="{{ $sectionRow->translate($locale)->title }}"
                                                                                           name="sections[{{ $key }}][{{ $locale }}][title]" />

                                                                                    @error("sections.$key.$locale.title")
                                                                                        <span class="text-danger">{{ $message }}</span>
                                                                                    @enderror
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-md-12">
                                                                                <div class="form-group">
                                                                                    <label for="content_input"> Section content {{ $locale }} <span class="text-danger">*</span></label>

                                                                                    <textarea id="content_input"
                                                                                              name="sections[{{ $key }}][{{ $locale }}][content]"
                                                                                              class="form-control summernote_content"
                                                                                              rows="10">{{ $sectionRow->translate($locale)->content }}</textarea>

                                                                                    @error("sections.$key.$locale.content")
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

                                                        <div class="form-group col-md-12">
                                                            <label for="meta_title"> Meta Title {{ $locale }} </label>

                                                            <input type="text"
                                                                   id="meta_title"
                                                                   name="{{ $locale }}[meta_title]"
                                                                   placeholder="Enter title"
                                                                   value="{{ $blog->translate($locale)->meta_title }}"
                                                                   class="form-control" />

                                                            @error("$locale.meta_title")
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>

                                                        <div class="form-group col-md-12">
                                                            <label for="canonical"> Canonical Url {{ $locale }} </label>
                                                            <input type="text"
                                                                   id="canonical"
                                                                   name="{{ $locale }}[canonical]"
                                                                   placeholder="Enter title"
                                                                   value="{{ $blog->translate($locale)->canonical }}"
                                                                   class="form-control" />

                                                            @error("$locale.canonical")
                                                            <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>

                                                        <div class="form-group col-md-12">
                                                            <label for="meta_description"> Meta Description {{ $locale }} </label>

                                                            <textarea id="meta_description" name="{{ $locale }}[meta_description]" class="form-control" rows="10">{{ $blog->translate($locale)->meta_description }}</textarea>

                                                            @error("$locale.meta_description")
                                                            <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>

                                                        <div class="form-group col-md-12">

                                                            <label for="meta_keywords"> Meta Keywords {{ $locale }} </label>

                                                            <textarea id="meta_keywords" name="{{ $locale }}[meta_keywords]" class="form-control" rows="10">{{ $blog->translate($locale)->meta_keywords }}</textarea>

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
                                                                   value="{{ $blog->translate($locale)->alt_image }}"
                                                                   class="form-control" />

                                                            @error("$locale.alt_image")
                                                            <span class="text-danger">{{ $message }}</span>
                                                            @enderror
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

            $('.' + $(this).data('row_name')).remove();

        });
        // END :: remove section

        $(document).on('click', '.btn_add_section', function (){

            let rowCount = $('.blog_section').length / 2;

            @foreach(config('translatable.locales') as $localeScript)
                $row =
                '<div class="row border p-3 mt-3 blog_section blog_row_'+ rowCount +'"> \n'+
                '<div class="form-group col-md-12"> \n'+
                '<button type="button" class="btn btn-danger float-right btn_clear_section" data-row_name="blog_row_'+ rowCount +'"> \n'+
                '<i class="fa fa-trash"></i> \n'+
                '</button> \n'+
                '</div> \n'+
                '<div class="col-md-2"> \n'+
                '<div class="form-group"> \n'+
                '<label for="content_name"> Section color {{ $localeScript }} <span class="text-danger">*</span></label> \n'+
                '<input type="color" class="form-control" value="#ffffff" name="sections['+ rowCount +'][{{ $localeScript }}][section_color]" /> \n'+
                '</div> \n'+
                '</div> \n'+
                '<div class="col-md-10"> \n'+
                '<div class="form-group"> \n'+
                '<label for="content_name"> Section title {{ $localeScript }} <span class="text-danger">*</span></label> \n'+
                '<input type="text" class="form-control" name="sections['+ rowCount +'][{{ $localeScript }}][title]" /> \n'+
                '</div> \n'+
                '</div> \n'+
                '<div class="col-md-12"> \n'+
                '<div class="form-group"> \n'+
                '<label for="content_input"> Section content {{ $localeScript }} <span class="text-danger">*</span></label> \n'+
                '<textarea id="content_input" name="sections['+ rowCount +'][{{ $localeScript }}][content]" class="form-control summernote_content" rows="10"></textarea> \n'+
                '</div> \n'+
                '</div> \n'+
                '</div>';

            $('.blog_sections_{{ $localeScript }}').append($row);
            @endforeach

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
@endpush

