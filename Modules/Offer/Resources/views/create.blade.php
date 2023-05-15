@extends('admin.layout.base')

@section('title', 'Create a new Offer')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="basic-form">
                            <form class="form" method="POST" action="{{ route('admin.offers.store') }}" enctype="multipart/form-data">
                                @method('POST')
                                @csrf

                                <div class="row">
                                    <div class="form-group col-md-4"></div>
                                    <div class="form-group col-md-4 @error('image') has-danger @enderror">
                                        <label class="font-bold">Image <span class="text-danger">*</span></label>

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
                                    <div class="default-tab col-md-12">
                                        <ul class="nav nav-tabs" role="tablist">
                                            @foreach(config('translatable.locales') as $locale)
                                                <li class="nav-item">
                                                    <a class="nav-link {{ $loop->first ? 'active' : '' }}" data-toggle="tab" href="#{{ $locale }}">  @lang("system.$locale")</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                        <div class="tab-content mt-4">
                                            @foreach(config('translatable.locales') as $locale)
                                                <div class="tab-pane fade {{ $loop->first ? "active show" : '' }}" id="{{ $locale }}" role="tabpanel">
                                                    <div class="row">
                                                        <div class="form-group bmd-form-group col-md-12 @error("$locale.name") has-danger @enderror">
                                                            <label for="name_id"> Name {{ $locale }} <span class="text-danger">*</span></label>

                                                            <input type="text"
                                                                   id="name_id"
                                                                   name="{{ $locale }}[name]"
                                                                   placeholder="Enter name"
                                                                   value="{{ old("$locale.name") }}"
                                                                   class="form-control" />

                                                            @error("$locale.name")
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
                                    <div class="form-group col-md-12 @error("price") has-danger @enderror">
                                        <label for="price_id"> Price <span class="text-danger">*</span></label>

                                        <input type="text"
                                               id="price_id"
                                               name="price"
                                               placeholder="Enter Price"
                                               value="{{ old("price") }}"
                                               class="form-control" />

                                        @error("price")
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-12 @error('category_id') has-danger @enderror">
                                        <label for="categories_select_input">Categories <span style="color: red">*</span> </label>

                                        <select class="custom-select form-control city-type" id="categories_select_input" name="category_id">
                                            <option value="">-- Select --</option>

                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }} data-branches="{{ $category->branches }}">
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>

                                        @error('category_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-12 form-group">
                                        <label for="branches_select_input"> Branches </label>

                                        <select class="form-control js-example-basic-multiple" id="branches_select_input" name="branches[]" multiple="multiple"></select>

                                        @error("branches")
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
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

    <script>
        $(document).ready(function () {
            let branches = $('#categories_select_input').find(':selected').data('branches');

            $.each(branches, function (index, value){
                $("#branches_select_input").append('<option value="'+ value.id +'">'+ value.name +'</option>');
            });
        })

        $(document).on('change', '#categories_select_input', function () {

            let branches = $(this).find(':selected').data('branches');

            $('#branches_select_input').empty();

            $.each(branches, function (index, value){
                $("#branches_select_input").append('<option value="'+ value.id +'">'+ value.name +'</option>');
            });
        })


    </script>
@endpush
