@extends('admin.layout.base')

@section('title', "Edit a Frequently Asked Questions")

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.css" />
@endpush

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="basic-form">
                            <form class="form" method="POST" enctype="multipart/form-data" action="{{ route('admin.frequently-questions.update', $frequentlyQuestion->id) }}">
                                @method('PUT')
                                @csrf

                                <div class="form-row " style="margin-bottom:  10px">
                                    <div class="form-group col-md-8 @error('image') has-danger @enderror">
                                        <label class="font-bold" for="category_input_selector">Category <span class="text-danger">*</span></label>

                                        <select name="category_id" id="category_input_selector" class="form-control">
                                            <option value="">-- Select --</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" {{ $frequentlyQuestion->category_id == $category->id ? 'selected' : '' }}>
                                                    {{ $category->translate(app()->getLocale())->name }}
                                                </option>
                                            @endforeach
                                        </select>

                                        @error('category_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-4 @error('language') has-danger @enderror">
                                        <label for="locale"> Frequently Lang <span style="color: red">*</span></label>

                                        <select class="custom-select form-control" id="language_input" disabled="">
                                            <option value="">-- Select --</option>
                                            @foreach(config('translatable.locales') as $key => $locale)
                                                @php(++$key)
                                                <option value="{{ $key }}" {{ $frequentlyQuestion->language == $key ? 'selected' : '' }}>
                                                    @lang("system.$locale")
                                                </option>
                                            @endforeach
                                            <option value="3" {{ $frequentlyQuestion->language == 3 ? 'selected' : '' }}>All</option>
                                        </select>

                                        @error('language')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="default-tab " style="width: 100%">
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
                                                    <div class="pt-4 row">
                                                        <div class="form-group col-md-12">
                                                            <label for="select_page_id"> @lang("system.$locale") Question</label>

                                                            <input name="{{ $locale }}[question]"
                                                                   value="{{ $frequentlyQuestion->translate($locale)->question ?? '' }}"
                                                                   class="form-control input_{{ $locale }}" />

                                                            @error("$locale.question")
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>

                                                        <div class="form-group col-md-12">
                                                            <label for="answer_input"> @lang("system.$locale") Answer</label>

                                                            <textarea name="{{ $locale }}[answer]"
                                                                      id="answer_input"
                                                                      cols="30"
                                                                      class="form-control summernote_content input_{{ $locale }}"
                                                                      rows="10">{{ $frequentlyQuestion->translate($locale)->answer ?? '' }}</textarea>

                                                            @error("$locale.answer")
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
                                <a href="{{ route('admin.frequently-questions.index') }}" class="btn btn-danger">Back</a>
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
