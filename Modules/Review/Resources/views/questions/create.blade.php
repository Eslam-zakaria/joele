@extends('admin.layout.base')

@section('title', 'Create a new review questions')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="basic-form">
                            <form class="form" method="POST" enctype="multipart/form-data" action="{{ route('admin.reviews-questions.store') }}">
                                @method('POST')
                                @csrf

                                <div class="form-row" style="margin-bottom:  10px">
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
                                                            <label for="select_page_id"> @lang("system.$locale") Question </label>

                                                            <input name="{{ $locale }}[question]"
                                                                   value="{{ old("$locale.question") }}"
                                                                   class="form-control" />

                                                            @error("$locale.question")
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
    </script>
@endpush
