@extends('admin.layout.base')

@section('title', 'Create a new Casing')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="basic-form">
                            <form class="form" method="POST" enctype="multipart/form-data" action="{{ route('admin.cases.store') }}">
                                @method('POST')
                                @csrf

                                <div class="form-row" style="margin-bottom:  10px">
                                    <div class="form-group col-md-6 @error('image_before') has-danger @enderror">
                                        <label class="font-bold">Before image <span class="text-danger">*</span></label>

                                        <input type="file"
                                               name="image_before"
                                               class="dropify"
                                               data-height="200"
                                               data-default-file=""/>

                                        @error('image_before')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6 @error('image_after') has-danger @enderror">
                                        <label class="font-bold">After image <span class="text-danger">*</span></label>

                                        <input type="file"
                                               name="image_after"
                                               class="dropify"
                                               data-height="200"
                                               data-default-file=""/>

                                        @error('image_after')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div  class="form-group col-md-4 @error('branch_id') has-danger @enderror">
                                        <label for="branches_select_input">Branch<span style="color: red">*</span></label>

                                        <select class="custom-select form-control city-type" id="branches_select_input" name="branch_id">
                                            <option value="">-- Select --</option>

                                            @foreach($branches as $branch)
                                                <option value="{{ $branch->id }}"
                                                        data-doctors="{{ $branch->listDoctors->pluck('id', 'name') }}"
                                                        {{ old('branch_id') == $branch->id ? 'selected' : '' }}>{{ $branch->name }}</option>
                                            @endforeach
                                        </select>

                                        @error('branch_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div  class="form-group col-md-4 @error('doctor_id') has-danger @enderror">
                                           <label for="doctors_select_input">Doctor<span style="color: red">*</span></label>

                                            <select class="custom-select form-control city-type" id="doctors_select_input" name="doctor_id">
                                                <option value="">-- Select --</option>
                                            </select>

                                        @error('doctor_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div  class="form-group col-md-4 @error('category_id') has-danger @enderror">
                                       <label for="category_id">Category<span style="color: red">*</span></label>
                                        <select class="custom-select form-control city-type" id="category_id" name="category_id">
                                            <option value="">-- Select --</option>
                                            @foreach($categories as $category)
                                                <option value="{{$category->id}}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                            @endforeach
                                        </select>

                                        @error('category_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary pull-right mt-3">Save</button>
                                <button type="button" onclick="{{ route('admin.cases.index') }}" class="btn btn-danger mt-3">Back</button>
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
        $(document).on('change', '#branches_select_input', function () {
            $('#doctors_select_input').find('option').not(':first').remove();

            $.each($(this).find(":selected").data('doctors'), function (val, key) {
                $('#doctors_select_input').append('<option value="'+ key +'">'+ val +'</option>')
            })
        });
    </script>
@endpush
