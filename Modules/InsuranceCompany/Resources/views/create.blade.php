@extends('admin.layout.base')

@section('title', 'Create a new insurance company')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="basic-form">
                            <form class="form" method="POST" enctype="multipart/form-data" action="{{ route('admin.insurance-companies.store') }}">
                                @method('POST')
                                @csrf

                                <div class="form-row" style="margin-bottom:  10px">
                                    <div class="form-group col-md-6 @error('image') has-danger @enderror">
                                        <label class="font-bold">Main Image (1920px x 1080px) <span class="text-danger">*</span></label>

                                        <input type="file"
                                               name="image"
                                               class="dropify"
                                               data-height="200"
                                               data-default-file="" />

                                        @error('image')
                                            <span class="text-danger">{{ $errors->first('image') }}</span>
                                        @enderror

                                    </div>

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
                                                    <div class="pt-4 row">
                                                        <div class="form-group col-md-12">
                                                            <label for="select_page_id"> @lang("system.$locale") Title</label>

                                                            <input name="{{ $locale }}[title]"
                                                                   value="{{ old("$locale.title") }}"
                                                                   class="form-control" />

                                                            @error("$locale.title")
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>

                                                        <div class="form-group col-md-12">
                                                            <label for="content_input"> @lang("system.$locale") Content </label>

                                                            <textarea name="{{ $locale }}[content]"
                                                                      id="content_input"
                                                                      cols="30"
                                                                      class="form-control"
                                                                      rows="10">{{ old("$locale.content") }}</textarea>

                                                            @error("$locale.content")
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
                                <a href="{{ route('admin.insurance-companies.index') }}" class="btn btn-danger">Back</a>
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
@endpush
