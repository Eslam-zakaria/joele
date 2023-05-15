@extends('admin.layout.base')

@section('title', 'Create a new Branch')

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
                            <form class="form" method="POST" action="{{ route('admin.branches.store') }}" enctype="multipart/form-data">
                                @method('POST')
                                @csrf

                                <div class="row">
                                    <div class="form-group col-md-4"></div>
                                    <div class="form-group col-md-4 @error('offer_image') has-danger @enderror">
                                        <label class="font-bold">Offer Image <span class="text-danger">*</span></label>

                                        <input type="file"
                                               name="offer_image"
                                               class="dropify"
                                               data-height="200"
                                               data-default-file=""/>

                                        @error('offer_image')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-row" style="margin-bottom: 10px">
                                    <div class="default-tab " style="width: 100%">
                                        <ul class="nav nav-tabs" role="tablist">
                                            @foreach(config('translatable.locales') as $locale)
                                                <li class="nav-item">
                                                    <a class="nav-link {{ $loop->first ? 'active' : '' }}" data-toggle="tab" href="#{{ $locale }}"> @lang("system.$locale") </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                        <div class="tab-content">
                                            @foreach(config('translatable.locales') as $locale)
                                                <div class="tab-pane fade {{ $loop->first ? "active show" : '' }}" id="{{ $locale }}" role="tabpanel">
                                                    <div class="pt-4 row">
                                                        <div class="form-group col-md-6 @error("$locale.name") has-danger @enderror">
                                                            <label for="name_id"> Name {{ $locale }} <span class="text-danger">*</span></label>

                                                            <input type="text"
                                                                   name="{{ $locale }}[name]"
                                                                   placeholder="Enter name"
                                                                   value="{{ old("$locale.name") }}"
                                                                   onload="convertToSlug(this.value, 'slug_input_{{ $locale }}')"
                                                                   onkeyup="convertToSlug(this.value, 'slug_input_{{ $locale }}')"
                                                                   class="form-control" />

                                                            @error("$locale.name")
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>

                                                        <div class="form-group col-md-6 @error("$locale.slug") has-danger @enderror">
                                                            <label for="slug_id"> Slug {{ $locale }} <span class="text-danger">*</span></label>

                                                            <input type="text"
                                                                   id="slug_input_{{ $locale }}"
                                                                   name="{{ $locale }}[slug]"
                                                                   placeholder="Enter slug"
                                                                   value="{{ old("$locale.slug") }}"
                                                                   class="form-control" />

                                                            @error("$locale.slug")
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>

                                                        <div class="form-group col-md-12 @error("$locale.address") has-danger @enderror">
                                                            <label for="address_input"> Address {{ $locale }} <span class="text-danger">*</span></label>

                                                            <input type="text"
                                                                   id="address_input"
                                                                   name="{{ $locale }}[address]"
                                                                   placeholder="Enter address"
                                                                   value="{{ old("$locale.address") }}"
                                                                   class="form-control" />

                                                            @error("$locale.address")
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <div class="form-group col-md-6 @error("phone") has-danger @enderror">
                                        <label for="phone"> Phone <span class="text-danger">*</span></label>

                                        <input type="text"
                                               id="phone"
                                               name="phone"
                                               placeholder="Enter phone"
                                               value="{{ old("phone") }}"
                                               class="form-control" />

                                        @error("phone")
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6 @error("another_phone") has-danger @enderror">
                                        <label for="another_phone_input"> Another phone </label>

                                        <input type="text"
                                               id="another_phone_input"
                                               name="another_phone"
                                               placeholder="Enter another phone"
                                               value="{{ old("another_phone") }}"
                                               class="form-control" />

                                        @error("another_phone")
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <hr>

                                <div>
                                    <div class="form-group row">
                                        <div class="col-md-10">
                                            <label for="categories_select_input"> Categories </label>
                                            <select class="form-control" id="categories_select_input">
                                                <option value="">-- Select --</option>
                                                @foreach($categories as $category)
                                                    <option data-category="{{ $category }}">
                                                        {{ $category->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-2 d-flex align-items-end justify-content-center">
                                            <button class="btn btn-primary" type="button" id="btn_add_category">Add</button>
                                        </div>
                                    </div>

                                    <span class="text-danger span_category_error"></span>
                                </div>

                                <div class="form-group row" id="categories_services_group">
                                    @if(old('categories'))
                                        @foreach($categories as $category)
                                            @if( in_array($category->id, array_keys( old('categories') )) )

                                                <div class="form-group col-md-12 row">
                                                    <div class="col-md-10">
                                                        <label for="services_select_input" class="d-flex align-items-center">
                                                            <img src="{{ $category->category_image }}" width="60" class="rounded-circle mr-4" alt="">
                                                            <h4>{{ $category->name }}</h4>
                                                        </label>
                                                        <select class="form-control js-example-basic-multiple" id="services_select_{{ $category->id }}" name="categories[{{ $category->id }}][]" multiple="multiple">
                                                            <option value="">-- Select --</option>
                                                            @foreach($category->services as $service)
                                                                <option value="{{ $service->id }}" {{ in_array($service->id , old('categories')[$category->id] ) ? 'selected' : '' }}>{{ $service->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-2 d-flex align-items-end justify-content-center">
                                                        <button class="btn_delete_categories_services_selector btn btn-danger"> <i class="fa fa-trash"></i> </button>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    @endif
                                </div>

                                <hr>

                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <h4 class="kt-portlet__head-title">
                                            <i class="fa fa-map-marker"></i>
                                            Geographical location
                                        </h4>

                                        <label for="map_link">Map Link</label>

                                        <textarea name="map_link"
                                                  id="map_link"
                                                  cols="30"
                                                  class="form-control"
                                                  rows="3">{{ old('map_link') }}</textarea>

                                        @error("map_link")
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <hr>

                                <button type="submit" class="btn btn-primary pull-right">Save</button>
                                <a type="button" href="{{ route('admin.branches.index') }}" class="btn btn-danger">Back</a>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@stop

@push('js')
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDtaIwmepScDMmCOqr7-WszNY0HU4uwhdY&libraries=places&callback=initAutocomplete"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.dropify').dropify();
        })

        $('body').ready(".js-example-basic-multiple", function(){
            $(this).select2({ });
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
        var categories = [];

        $(document).on('click', '#btn_add_category', function () {
            let category = $('#categories_select_input').find(':selected').data('category');

            if( category != undefined ) {

                if( categories.indexOf(category.id) == -1 ){

                    categories.push(category.id);

                    $('.span_category_error').addClass('d-none').text('');

                    $element =
                        '<div class="form-group col-md-12 row"> \n'+
                            '<div class="col-md-10"> \n'+
                                '<label for="services_select_input" class="d-flex align-items-center"> \n'+
                                    '<img src="'+ category.category_image +'" width="60" class="rounded-circle mr-4" alt=""> \n'+
                                    '<h4>'+ category.name +'</h4> \n'+
                                '</label> \n'+
                                '<select class="form-control js-example-basic-multiple select2" id="services_select_'+ category.id +'" name="categories['+ category.id +'][]" multiple="multiple"> \n'+
                                    '<option value="">-- Select --</option> \n'+
                                '</select> \n'+
                            '</div> \n'+
                            '<div class="col-md-2 d-flex align-items-end justify-content-center"> \n'+
                                '<button class="btn_delete_categories_services_selector btn btn-danger"> <i class="fa fa-trash"></i> </button> \n'+
                            '</div> \n'+
                        '</div>';

                    $('#categories_services_group').append($element);

                    $('.select2').select2();

                    $.each(category.services, function (index, value){
                        $("#services_select_" + category.id).append('<option value="'+ value.id +'">'+ value.name +'</option>');
                    })

                } else {

                    $('.span_category_error').removeClass('d-none').text('The selected category already exists.');

                }

            }else {

                $('.span_category_error').removeClass('d-none').text('category field is required');
            }
        })

        $(document).on('click', '.btn_delete_categories_services_selector', function (){
            $(this).parent().parent().remove();
        })
    </script>
@endpush

