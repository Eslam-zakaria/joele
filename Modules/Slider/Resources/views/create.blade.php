@extends('admin.layout.base')

@section('title', 'Create a new Slider')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="basic-form">
                            <form class="form" method="POST" enctype="multipart/form-data" action="{{ route('admin.sliders.store') }}">
                                @method('POST')
                                @csrf

                                <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label class="font-bold"> File type <span class="text-danger">*</span></label>

                                        <div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input"
                                                       type="radio"
                                                       name="upload_type"
                                                       id="upload_file"
                                                       value="upload" checked />

                                                <label class="form-check-label" for="upload_file">Upload</label>
                                            </div>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input"
                                                       type="radio"
                                                       name="upload_type"
                                                       id="upload_link"
                                                       value="link" {{ old('upload_type') == 'link' ? 'checked' : '' }} />

                                                <label class="form-check-label" for="upload_link">Link</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-5 group_input_file">
                                        <div class="form-group @error('image') has-danger @enderror">
                                            <label class="font-bold">Main Image (1920px x 1080px) <span class="text-danger">*</span></label>

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

                                    <div class="col-md-12 d-none group_input_link">
                                        <div class="form-group @error('image') has-danger @enderror">
                                            <label class="font-bold"> Link <span class="text-danger">*</span></label>

                                            <input type="text"
                                                   name="link"
                                                   id="input_upload_file"
                                                   class="form-control" disabled />

                                            @error('link')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row mb-4">
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
                                                    <div class="pt-4">
                                                        <div class="form-group col-md-12">
                                                            <label for="select_page_id"> @lang("system.$locale") First Title</label>

                                                            <input name="{{ $locale }}[first_title]"
                                                                   value="{{ old("$locale.first_title") }}"
                                                                   class="form-control" />

                                                            @error("$locale.first_title")
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>

                                                        <div class="form-group col-md-12">
                                                            <label for="select_page_id"> @lang("system.$locale") Second Title</label>

                                                            <input name="{{ $locale }}[second_title]"
                                                                   value="{{ old("$locale.second_title") }}"
                                                                   class="form-control" />

                                                            @error("$locale.second_title")
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>

                                                        <div class="form-group col-md-12">
                                                            <label for="select_page_id"> @lang("system.$locale") Description</label>

                                                            <textarea id="input_page_name"
                                                                      name="{{ $locale }}[description]"
                                                                      class="form-control"
                                                                      rows="10">
                                                                {{ old("$locale.description") }}
                                                            </textarea>

                                                            @error("$locale.description")
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
                                <a href="{{ route('admin.sliders.index') }}" class="btn btn-danger">Back</a>
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

        $(document).ready(function (){
            if('{{ old('upload_type') }}' === 'link'){

                $('.group_input_file').addClass('d-none')
                $('.group_input_link').removeClass('d-none')
                $('#input_upload_file').attr('disabled', false);

            } else {

                $('.group_input_file').removeClass('d-none')
                $('.group_input_link').addClass('d-none')
                $('#input_upload_file').attr('disabled', true);
            }
        });

        $("input[type='radio'][name='upload_type']").click(function() {
            let value = $(this).val();

            if(value === 'link'){

                $('.group_input_file').addClass('d-none')
                $('.group_input_link').removeClass('d-none')
                $('#input_upload_file').attr('disabled', false);

            } else {

                $('.group_input_file').removeClass('d-none')
                $('.group_input_link').addClass('d-none')
                $('#input_upload_file').attr('disabled', true);
            }
        });
    </script>
@endpush
