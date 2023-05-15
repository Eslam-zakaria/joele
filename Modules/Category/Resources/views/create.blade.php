@extends('admin.layout.base')

@section('title', 'Create a new category')

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="basic-form">
                            <form class="form" method="POST" enctype="multipart/form-data" action="{{ route('admin.categories.store') }}">
                                @method('POST')
                                @csrf

                                <div class="form-row" style="margin-bottom:  10px">
                                    <div class="col-md-4"></div>
                                    <div class="form-group col-md-4 @error('image') has-danger @enderror">
                                        <label class="font-bold">Main Image (1920px x 1080px) <span class="text-danger">*</span></label>
                                        <input type="file" name="image" class="dropify" data-height="200" data-default-file=""/>
                                        @if($errors->has('image'))
                                            <span class="text-danger">{{ $errors->first('image') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-row" style="margin-bottom: 10px">
                                    <div class="default-tab" style="width: 100%">
                                        <ul class="nav nav-tabs" role="tablist">
                                            @foreach(config('translatable.locales') as $locale)
                                                <li class="nav-item">
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
                                                <div class="tab-pane fade {{ $loop->first ? "active show" : '' }}" id="{{ $locale }}" role="tabpanel">
                                                    <div class="row pt-4">
                                                        <div class="form-group col-md-6">
                                                            <label for="name_input"> @lang("system.$locale") Name </label>

                                                            <input name="{{ $locale }}[name]"
                                                                   value="{{ old("$locale.name") }}"
                                                                   id="name_input"
                                                                   onload="convertToSlug(this.value, 'slug_input_{{ $locale }}')"
                                                                   onkeyup="convertToSlug(this.value, 'slug_input_{{ $locale }}')"
                                                                   class="form-control" />

                                                            @error("$locale.name")
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>

                                                        <div class="form-group col-md-6">
                                                            <label for="slug_input_{{ $locale }}"> @lang("system.$locale") Slug </label>

                                                            <input name="{{ $locale }}[slug]"
                                                                   value="{{ old("$locale.slug") }}"
                                                                   id="slug_input_{{ $locale }}"
                                                                   class="form-control" />

                                                            @error("$locale.slug")
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>

                                                        <div class="form-group col-md-12">
                                                            <label for="input_description"> @lang("system.$locale") Description</label>

                                                            <textarea id="input_description"
                                                                      name="{{ $locale }}[description]"
                                                                      class="form-control"
                                                                      rows="10">{{ old("$locale.description") }}</textarea>

                                                            @error("$locale.description")
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>

                                                        <div class="form-group col-md-12">
                                                            <label for="alt_image_input"> @lang("system.$locale") Alt Image </label>

                                                            <input name="{{ $locale }}[alt_image]"
                                                                   value="{{ old("$locale.alt_image") }}"
                                                                   id="alt_image_input"
                                                                   class="form-control" />

                                                            @error("$locale.alt_image")
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>

                                                        <div class="form-group col-md-12">
                                                            <label for="meta_title_input"> @lang("system.$locale") Meta Title </label>

                                                            <input name="{{ $locale }}[meta_title]"
                                                                   value="{{ old("$locale.meta_title") }}"
                                                                   id="meta_title_input"
                                                                   class="form-control" />

                                                            @error("$locale.meta_title")
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>

                                                        <div class="form-group col-md-12">
                                                            <label for="input_meta_description"> @lang("system.$locale") Meta Description</label>

                                                            <textarea id="input_meta_description"
                                                                      name="{{ $locale }}[meta_description]"
                                                                      class="form-control"
                                                                      rows="10">{{ old("$locale.meta_description") }}</textarea>

                                                            @error("$locale.meta_description")
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>

                                                        <div class="form-group col-md-12">
                                                            <label for="input_meta_keywords"> @lang("system.$locale") Meta Keywords </label>

                                                            <textarea id="input_meta_keywords"
                                                                      name="{{ $locale }}[meta_keywords]"
                                                                      class="form-control"
                                                                      rows="10">{{ old("$locale.meta_keywords") }}</textarea>

                                                            @error("$locale.meta_keywords")
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>

                                                        <div class="form-group col-md-12">
                                                            <label for="canonical_input"> @lang("system.$locale") Canonical </label>

                                                            <input name="{{ $locale }}[canonical]"
                                                                   value="{{ old("$locale.canonical") }}"
                                                                   id="canonical_input"
                                                                   class="form-control" />

                                                            @error("$locale.canonical")
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label for="select_page_id"> Display In </label>

                                        <select class="js-example-basic-multiple" id="select_display_in_input" name="display_in[]" multiple="multiple">
                                            @foreach($categoriesRelation as $relation)
                                                <option value="{{ $relation }}" {{ old('display_in') && in_array($relation, old('display_in')) ? 'selected' : '' }}>{{ $relation }}</option>
                                            @endforeach
                                        </select>

                                        @error('display_in')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-12 d-none">
                                        <label for="select_page_id"> Service items per row </label>

                                        <select class="form-control" id="select_grid_option_input" name="service_items_per_row">
                                            <option value="">-- Select --</option>

                                            @foreach($gridOptions as $gridOptionKey => $gridOption)
                                                <option value="{{ $gridOptionKey }}" {{ old('service_items_per_row') == $gridOptionKey ? 'selected' : '' }}>
                                                    {{ $gridOption['name'] }}
                                                </option>
                                            @endforeach
                                        </select>

                                        @error('service_items_per_row')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary pull-right">Save</button>
                                <a href="{{ route('admin.categories.index') }}" class="btn btn-danger">Back</a>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@stop

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"></script>

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

        $(document).on('change', '#select_display_in_input', function () {

            if(jQuery.inArray("services", $(this).val()) !== -1)
            {
                $('#select_grid_option_input').parent().removeClass('d-none')
            }else {
                $('#select_grid_option_input').parent().addClass('d-none')
            }

        });

        $(document).ready(function () {

            if(jQuery.inArray("services", $('#select_display_in_input').val()) !== -1)
            {
                $('#select_grid_option_input').parent().removeClass('d-none')
            }else {
                $('#select_grid_option_input').parent().addClass('d-none')
            }

        });
    </script>
@endpush
