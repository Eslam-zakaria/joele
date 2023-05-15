@extends('admin.layout.base')

@section('title', "Edit a Frequently Asked Question category")

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="basic-form">
                            <form class="form" method="POST" enctype="multipart/form-data" action="{{ route('admin.questions-category.update', $questions_category->id) }}">
                                @method('PUT')
                                @csrf

                                <div class="row">
                                    <div class="form-group col-md-12 @error('locale') has-danger @enderror">
                                        <label for="locale"> Category Lang <span style="color: red">*</span></label>
                                        <select class="custom-select form-control" id="language_input" name="language">
                                            <option value="">-- Select --</option>
                                            @foreach(config('translatable.locales') as $key => $locale)
                                                @php(++$key)
                                                <option value="{{ $key }}" {{ $questions_category->language == $key ? 'selected' : '' }}>
                                                    @lang("system.$locale")
                                                </option>
                                            @endforeach
                                            <option value="3" {{ $questions_category->language == 3 ? 'selected' : '' }}>All</option>
                                        </select>

                                        @error('language')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-row " style="margin-bottom:  10px">
                                    <div class="default-tab " style="width: 100%">
                                        <ul class="nav nav-tabs" role="tablist">
                                            @foreach(config('translatable.locales') as $locale)
                                                <li class="nav-item tab_lang_{{ $locale }}">
                                                    <a class="nav-link {{ $loop->first ? 'active' : '' }}" data-toggle="tab" href="#{{ $locale }}">  {{ trans('system.'.$locale) }}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                        <div class="tab-content">
                                            @foreach(config('translatable.locales') as $locale)
                                                <div class="tab-pane fade {{ $loop->first ? "active show" : '' }} tab_content_{{ $locale }}" id="{{ $locale }}" role="tabpanel">
                                                    <div class="pt-4 row">
                                                        <div class="form-group col-md-12">
                                                            <label for="select_page_id"> @lang("system.$locale") Name</label>

                                                            <input name="{{ $locale }}[name]"
                                                                   value="{{ $questions_category->translate($locale)->name ?? '' }}"
                                                                   placeholder="@lang("system.$locale") name"
                                                                   class="form-control input_{{ $locale }}" />

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

                                <button type="submit" class="btn btn-primary pull-right">Save</button>
                                <a href="{{ route('admin.questions-category.index') }}" class="btn btn-danger">Back</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@push('js')
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
