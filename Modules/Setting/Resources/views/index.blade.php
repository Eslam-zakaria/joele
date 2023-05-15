@extends('admin.layout.base')

@section('title', 'Settings')

@push('styles')
    <style>
        .form-control {
            border: 1px solid #c3c4c9;
        }

        .bootstrap-tagsinput .tag {
            background: red;
            padding: 4px;
            font-size: 14px;
        }
        .bootstrap-tagsinput .tag {
            margin: 3px;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.css" />
    <!-- include summernote css/js -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css" integrity="sha512-xmGTNt20S0t62wHLmQec2DauG9T+owP9e6VU8GigI0anN7OXLip9i7IwEhelasml2osdxX71XcYm6BQunTQeQg==" crossorigin="anonymous" />
@endpush

@section('content')
    <div class="container-fluid">
    @include('admin.layout.alerts')
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="basic-form">
                            <div class="form-row mb-4">
                                <div class="default-tab " style="width: 100%">
                                    <ul class="nav nav-tabs" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-toggle="tab" href="#main_setting">
                                                <i class="fa fa-cog mr-1" style="font-size: 13px;"></i>
                                                Main setting
                                            </a>
                                        </li>

                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#textarea_settings">
                                                <i class="fa fa-text-width mr-1" style="font-size: 13px;"></i>
                                                Textarea
                                            </a>
                                        </li>

                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#images_settings">
                                                <i class="fa fa-file-image-o mr-1" style="font-size: 13px;"></i>
                                                Images
                                            </a>
                                        </li>

                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#seo_settings">
                                                <i class="fa fa-search mr-1" style="font-size: 13px;"></i>
                                                SEO
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#schema_settings">
                                                <i class="fa fa-edit mr-1" style="font-size: 13px;"></i>
                                                Schema
                                            </a>
                                        </li>

                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#site_map_settings">
                                                <i class="fa fa-map mr-1" style="font-size: 13px;"></i>
                                                Site Map
                                            </a>
                                        </li>
                                    </ul>

                                    <div class="tab-content pt-4 mt-3">
                                        <div class="tab-pane fade active show" id="main_setting" role="tabpanel">
                                            <form class="form" method="POST" action="{{ route('admin.settings.update') }}">
                                                @method('PUT')
                                                @csrf
                                                <div class="pt-4">
                                                    <div class="row mb-3">
                                                        <h4 class="ml-2">Website Name</h4>
                                                        <div class="default-tab " style="width: 100%">
                                                            <ul class="nav nav-tabs" role="tablist">
                                                                @foreach(config('translatable.locales') as $locale)
                                                                    <li class="nav-item">
                                                                        <a class="nav-link {{ $loop->first ? 'active' : '' }} {{ $errors->has("website_name.$locale.value") ? 'text-danger' : '' }}" data-toggle="tab" href="#{{ $locale }}_website_name">
                                                                            {{ $locale == 'en' ? 'English' : 'Arabic' }}
                                                                        </a>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                            <div class="tab-content">
                                                                @foreach(config('translatable.locales') as $locale)
                                                                    <div class="tab-pane fade {{ $errors->has("website_name.*") ? ( $errors->has("website_name.$locale.value") ? 'active show' : '' ) : ( $loop->first ? 'active show' : '' ) }}" id="{{ $locale }}_website_name" role="tabpanel">
                                                                        <div class="pt-4">
                                                                            <div class="col-md-12">
                                                                                <div class="form-group">
                                                                                    <label class="control-label" for="title">{{ $locale == 'en' ? 'English' : 'Arabic' }} Website Name</label>

                                                                                    <input type="text"
                                                                                           name="website_name[{{ $locale }}][value]"
                                                                                           value="{{ $settings['website_name'][$locale] ?? old("website_name.$locale.value") }}"
                                                                                           class="form-control"
                                                                                           placeholder="{{ $locale == 'en' ? 'English' : 'Arabic' }} Site Name" />

                                                                                    @error("website_name.$locale.value")
                                                                                        <span class="text-danger">{{ $message }}</span>
                                                                                    @enderror
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <hr>

                                                    <div class="row mb-3">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="control-label" for="phone">Email</label>

                                                                <input type="email"
                                                                       name="email"
                                                                       value="{{ $settings['email'] ?? old('email') }}"
                                                                       class="form-control"
                                                                       placeholder="Email" />

                                                                @error('email')
                                                                <span class="text-danger">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="control-label" for="phone">Phone</label>

                                                                <input type="text"
                                                                       name="phone"
                                                                       value="{{ $settings['phone'] ?? old('phone') }}"
                                                                       class="form-control"
                                                                       placeholder="Phone" />

                                                                @error('phone')
                                                                <span class="text-danger">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <hr>

                                                    <div class="row mb-3">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="control-label" for="facebook">
                                                                    <i class="fa fa-facebook"></i>
                                                                    Facebook
                                                                </label>

                                                                <input type="text"
                                                                       name="facebook"
                                                                       value="{{ $settings['facebook'] ?? '' }}"
                                                                       class="form-control"
                                                                       placeholder="Facebook" />
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="control-label" for="twitter">
                                                                    <i class="fa fa-twitter"></i>
                                                                    Twitter
                                                                </label>

                                                                <input type="text"
                                                                       name="twitter"
                                                                       value="{{ $settings['twitter'] ?? '' }}"
                                                                       class="form-control"
                                                                       placeholder="Twitter" />
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="control-label" for="instagram">
                                                                    <i class="fa fa-instagram"></i>
                                                                    Instagram
                                                                </label>

                                                                <input type="text"
                                                                       name="instagram"
                                                                       value="{{ $settings['instagram'] ?? '' }}"
                                                                       class="form-control"
                                                                       placeholder="Instagram" />
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="control-label" for="snapchat">
                                                                    <i class="fa fa-snapchat"></i>
                                                                    Snapchat
                                                                </label>

                                                                <input type="text"
                                                                       name="snapchat"
                                                                       value="{{ $settings['snapchat'] ?? '' }}"
                                                                       class="form-control"
                                                                       placeholder="Snapchat" />
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="control-label" for="youtube">
                                                                    <i class="fa fa-youtube"></i>
                                                                    Youtube
                                                                </label>

                                                                <input type="text"
                                                                       name="youtube"
                                                                       value="{{ $settings['youtube'] ?? '' }}"
                                                                       class="form-control"
                                                                       placeholder="Youtube" />
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="control-label" for="whatsapp">
                                                                    <i class="fa fa-whatsapp"></i>
                                                                    Whatsapp
                                                                </label>

                                                                <input type="text"
                                                                       name="whatsapp"
                                                                       value="{{ $settings['whatsapp'] ?? '' }}"
                                                                       class="form-control"
                                                                       placeholder="Whatsapp" />
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <hr>

                                                    <div class="row mb-3">
                                                        <h4 class="ml-2">Address</h4>
                                                        <div class="default-tab " style="width: 100%">
                                                            <ul class="nav nav-tabs" role="tablist">
                                                                @foreach(config('translatable.locales') as $locale)
                                                                    <li class="nav-item">
                                                                        <a class="nav-link {{ $errors->has("address.*") ? ( $errors->has("website_name.$locale.value") ? 'active text-danger' : '' ) : ( $loop->first ? 'active' : '' ) }}" data-toggle="tab" href="#{{ $locale }}_address">
                                                                            {{ $locale == 'en' ? 'English' : 'Arabic' }}
                                                                        </a>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                            <div class="tab-content">
                                                                @foreach(config('translatable.locales') as $locale)
                                                                    <div class="tab-pane fade {{ $loop->first ? "active show" : '' }}" id="{{ $locale }}_address" role="tabpanel">
                                                                        <div class="pt-4">
                                                                            <div class="col-md-12">
                                                                                <div class="form-group">
                                                                                    <label class="control-label">{{ $locale == 'en' ? 'English' : 'Arabic' }} Address</label>

                                                                                    <input type="text"
                                                                                           name="address[{{ $locale }}][value]"
                                                                                           value="{{ $settings['address'][$locale] ?? old("address.$locale.value") }}"
                                                                                           class="form-control"
                                                                                           placeholder="{{ $locale == 'en' ? 'English' : 'Arabic' }} address" />
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <hr>

                                                    <div class="row mb-3">
                                                        <h4 class="ml-2">Working Days</h4>
                                                        <div class="default-tab " style="width: 100%">
                                                            <ul class="nav nav-tabs" role="tablist">
                                                                @foreach(config('translatable.locales') as $locale)
                                                                    <li class="nav-item">
                                                                        <a class="nav-link {{ $loop->first ? 'active' : '' }}" data-toggle="tab" href="#{{ $locale }}_working_days">
                                                                            {{ $locale == 'en' ? 'English' : 'Arabic' }}
                                                                        </a>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                            <div class="tab-content">
                                                                @foreach(config('translatable.locales') as $locale)
                                                                    <div class="tab-pane fade {{ $loop->first ? "active show" : '' }}" id="{{ $locale }}_working_days" role="tabpanel">
                                                                        <div class="pt-4">
                                                                            <div class="col-md-12">
                                                                                <div class="form-group">
                                                                                    <label class="control-label">{{ $locale == 'en' ? 'English' : 'Arabic' }} working days</label>

                                                                                    <input type="text"
                                                                                           name="working_days[{{ $locale }}][value]"
                                                                                           value="{{ $settings['working_days'][$locale] ?? old("working_days.$locale.value") }}"
                                                                                           class="form-control"
                                                                                           placeholder="{{ $locale == 'en' ? 'English' : 'Arabic' }} working days" />
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-12">
                                                                                <div class="form-group">
                                                                                    <label class="control-label" for="working_time">
                                                                                        {{ $locale == 'en' ? 'English' : 'Arabic' }} working time
                                                                                    </label>

                                                                                    <input type="text"
                                                                                           name="working_time[{{ $locale }}][value]"
                                                                                           value="{{ $settings['working_time'][$locale] ?? '' }}"
                                                                                           class="form-control"
                                                                                           placeholder="Working Time" />
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <hr>

{{--                                                    <div class="row mb-3">--}}
{{--                                                       --}}
{{--                                                    </div>--}}

{{--                                                    <hr>--}}

                                                    <div class="row mb-3">
                                                        <h4 class="ml-2">Day Off</h4>
                                                        <div class="default-tab " style="width: 100%">
                                                            <ul class="nav nav-tabs" role="tablist">
                                                                @foreach(config('translatable.locales') as $locale)
                                                                    <li class="nav-item">
                                                                        <a class="nav-link {{ $loop->first ? 'active' : '' }}" data-toggle="tab" href="#{{ $locale }}_day_off">
                                                                            {{ $locale == 'en' ? 'English' : 'Arabic' }}
                                                                        </a>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                            <div class="tab-content">
                                                                @foreach(config('translatable.locales') as $locale)
                                                                    <div class="tab-pane fade {{ $loop->first ? "active show" : '' }}" id="{{ $locale }}_day_off" role="tabpanel">
                                                                        <div class="pt-4">
                                                                            <div class="col-md-12">
                                                                                <div class="form-group">
                                                                                    <label class="control-label">{{ $locale == 'en' ? 'English' : 'Arabic' }} Day Off</label>

                                                                                    <input type="text"
                                                                                           name="day_off[{{ $locale }}][value]"
                                                                                           value="{{ $settings['day_off'][$locale] ?? old("day_off.$locale.value") }}"
                                                                                           class="form-control"
                                                                                           placeholder="{{ $locale == 'en' ? 'English' : 'Arabic' }} Day Off" />
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <hr>

                                                    <div class="row mb-3">
                                                        <h4 class="ml-2">Copyright</h4>
                                                        <div class="default-tab " style="width: 100%">
                                                            <ul class="nav nav-tabs" role="tablist">
                                                                @foreach(config('translatable.locales') as $locale)
                                                                    <li class="nav-item">
                                                                        <a class="nav-link {{ $loop->first ? 'active' : '' }}" data-toggle="tab" href="#{{ $locale }}_copyright">
                                                                            {{ $locale == 'en' ? 'English' : 'Arabic' }}
                                                                        </a>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                            <div class="tab-content">
                                                                @foreach(config('translatable.locales') as $locale)
                                                                    <div class="tab-pane fade {{ $loop->first ? "active show" : '' }}" id="{{ $locale }}_copyright" role="tabpanel">
                                                                        <div class="pt-4">
                                                                            <div class="col-md-12">
                                                                                <div class="form-group">
                                                                                    <label class="control-label">{{ $locale == 'en' ? 'English' : 'Arabic' }} Copyright</label>

                                                                                    <input type="text"
                                                                                           name="copyright[{{ $locale }}][value]"
                                                                                           value="{{ $settings['copyright'][$locale] ?? old("copyright.$locale.value") }}"
                                                                                           class="form-control"
                                                                                           placeholder="{{ $locale == 'en' ? 'English' : 'Arabic' }} Copyright" />
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <hr>

                                                    <div class="row mb-3">
                                                        <h4 class="ml-2">Right Now System</h4>
                                                        <div class="default-tab " style="width: 100%">
                                                            <ul class="nav nav-tabs" role="tablist">
                                                                @foreach(config('translatable.locales') as $locale)
                                                                    <li class="nav-item">
                                                                        <a class="nav-link {{ $loop->first ? 'active' : '' }}" data-toggle="tab" href="#{{ $locale }}_token_api">
                                                                            {{ $locale == 'en' ? 'English' : 'Arabic' }}
                                                                        </a>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                            <div class="tab-content">
                                                                @foreach(config('translatable.locales') as $locale)
                                                                    <div class="tab-pane fade {{ $loop->first ? "active show" : '' }}" id="{{ $locale }}_token_api" role="tabpanel">
                                                                        <div class="pt-4">
                                                                            <div class="col-md-12">
                                                                                <div class="form-group">
                                                                                    <label class="control-label">{{ $locale == 'en' ? 'English' : 'Arabic' }} Integration REST Token</label>

                                                                                    <input type="text"
                                                                                           name="token_api[{{ $locale }}][value]"
                                                                                           value="{{ $settings['token_api'][$locale] ?? old("token_api.$locale.value") }}"
                                                                                           class="form-control"
                                                                                           placeholder="{{ $locale == 'en' ? 'English' : 'Arabic' }} Token" />
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-12">
                                                                                <div class="form-group">
                                                                                    <label class="control-label">{{ $locale == 'en' ? 'English' : 'Arabic' }} Integration REST URL</label>

                                                                                    <input type="text"
                                                                                           name="url_api[{{ $locale }}][value]"
                                                                                           value="{{ $settings['url_api'][$locale] ?? old("url_api.$locale.value") }}"
                                                                                           class="form-control"
                                                                                           placeholder="{{ $locale == 'en' ? 'English' : 'Arabic' }} Url" />
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <hr>

                                                    <div class="row mb-3">
                                                        <h4 class="ml-2">Salesiq Code</h4>
                                                        <div class="default-tab " style="width: 100%">
                                                            <ul class="nav nav-tabs" role="tablist">
                                                                @foreach(config('translatable.locales') as $locale)
                                                                    <li class="nav-item">
                                                                        <a class="nav-link {{ $loop->first ? 'active' : '' }}" data-toggle="tab" href="#{{ $locale }}_salesiq">
                                                                            {{ $locale == 'en' ? 'English' : 'Arabic' }}
                                                                        </a>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                            <div class="tab-content">
                                                                @foreach(config('translatable.locales') as $locale)
                                                                    <div class="tab-pane fade {{ $loop->first ? "active show" : '' }}" id="{{ $locale }}_salesiq" role="tabpanel">
                                                                        <div class="pt-4">
                                                                            <div class="col-md-12">
                                                                                <div class="form-group">
                                                                                    <label class="control-label">{{ $locale == 'en' ? 'English' : 'Arabic' }} Salesiq Code</label>

                                                                                    <textarea type="text"
                                                                                           name="salesiq[{{ $locale }}][value]" rows="4"
                                                                                           class="form-control"
                                                                                           placeholder="{{ $locale == 'en' ? 'English' : 'Arabic' }} Token" >{{ $settings['salesiq'][$locale] ?? old("salesiq.$locale.value") }}</textarea>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <hr>

                                                    <div class="row mb-3">
                                                        <h4 class="ml-2">Terms and Conditions</h4>
                                                        <div class="default-tab " style="width: 100%">
                                                            <ul class="nav nav-tabs" role="tablist">
                                                                @foreach(config('translatable.locales') as $locale)
                                                                    <li class="nav-item">
                                                                        <a class="nav-link {{ $loop->first ? 'active' : '' }}" data-toggle="tab" href="#{{ $locale }}_terms">
                                                                            {{ $locale == 'en' ? 'English' : 'Arabic' }}
                                                                        </a>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                            <div class="tab-content">
                                                                @foreach(config('translatable.locales') as $locale)
                                                                    <div class="tab-pane fade {{ $loop->first ? "active show" : '' }}" id="{{ $locale }}_terms" role="tabpanel">
                                                                        <div class="pt-4">
                                                                            <div class="col-md-12">
                                                                                <div class="form-group">
                                                                                    <label class="control-label">{{ $locale == 'en' ? 'English' : 'Arabic' }} Terms and Conditions</label>

                                                                                    <textarea type="text"
                                                                                           name="terms_content[{{ $locale }}][value]" rows="7"
                                                                                           class="form-control"
                                                                                           placeholder="{{ $locale == 'en' ? 'English' : 'Arabic' }} Token" >{{ $settings['terms_content'][$locale] ?? old("terms_content.$locale.value") }}</textarea>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <hr>

                                                    <div class="row mb-3">
                                                        <h4 class="ml-2">Any Code All Pges Header</h4>
                                                        <div class="default-tab " style="width: 100%">
                                                            <ul class="nav nav-tabs" role="tablist">
                                                                @foreach(config('translatable.locales') as $locale)
                                                                    <li class="nav-item">
                                                                        <a class="nav-link {{ $loop->first ? 'active' : '' }}" data-toggle="tab" href="#{{ $locale }}_code_head">
                                                                            {{ $locale == 'en' ? 'English' : 'Arabic' }}
                                                                        </a>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                            <div class="tab-content">
                                                                @foreach(config('translatable.locales') as $locale)
                                                                    <div class="tab-pane fade {{ $loop->first ? "active show" : '' }}" id="{{ $locale }}_code_head" role="tabpanel">
                                                                        <div class="pt-4">
                                                                            <div class="col-md-12">
                                                                                <div class="form-group">
                                                                                    <label class="control-label">{{ $locale == 'en' ? 'English' : 'Arabic' }} Code All Pges Header</label>

                                                                                    <textarea type="text"
                                                                                           name="code_head[{{ $locale }}][value]" rows="7"
                                                                                           class="form-control"
                                                                                           placeholder="{{ $locale == 'en' ? 'English' : 'Arabic' }} Token" >{{ $settings['code_head'][$locale] ?? old("code_head.$locale.value") }}</textarea>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <hr>

                                                    <div class="row mb-3">
                                                        <h4 class="ml-2">Any Code All Pges Footer</h4>
                                                        <div class="default-tab " style="width: 100%">
                                                            <ul class="nav nav-tabs" role="tablist">
                                                                @foreach(config('translatable.locales') as $locale)
                                                                    <li class="nav-item">
                                                                        <a class="nav-link {{ $loop->first ? 'active' : '' }}" data-toggle="tab" href="#{{ $locale }}_code_foot">
                                                                            {{ $locale == 'en' ? 'English' : 'Arabic' }}
                                                                        </a>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                            <div class="tab-content">
                                                                @foreach(config('translatable.locales') as $locale)
                                                                    <div class="tab-pane fade {{ $loop->first ? "active show" : '' }}" id="{{ $locale }}_code_foot" role="tabpanel">
                                                                        <div class="pt-4">
                                                                            <div class="col-md-12">
                                                                                <div class="form-group">
                                                                                    <label class="control-label">{{ $locale == 'en' ? 'English' : 'Arabic' }} Code All Pges Footer</label>

                                                                                    <textarea type="text"
                                                                                           name="code_foot[{{ $locale }}][value]" rows="7"
                                                                                           class="form-control"
                                                                                           placeholder="{{ $locale == 'en' ? 'English' : 'Arabic' }} Token" >{{ $settings['code_foot'][$locale] ?? old("code_foot.$locale.value") }}</textarea>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <hr>

                                                    <div class="row mb-3">
                                                        <h4 class="ml-2">Hidden Online Payment</h4>
                                                        <div class="default-tab " style="width: 100%">
                                                            <ul class="nav nav-tabs" role="tablist">
                                                                @foreach(config('translatable.locales') as $locale)
                                                                    <li class="nav-item">
                                                                        <a class="nav-link {{ $loop->first ? 'active' : '' }}" data-toggle="tab" href="#{{ $locale }}_hidden_pay">
                                                                            {{ $locale == 'en' ? 'English' : 'Arabic' }}
                                                                        </a>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                            <div class="tab-content">
                                                                @foreach(config('translatable.locales') as $locale)
                                                                    <div class="tab-pane fade {{ $loop->first ? "active show" : '' }}" id="{{ $locale }}_hidden_pay" role="tabpanel">
                                                                        <div class="pt-4">
                                                                            <div class="col-md-12">
                                                                                <div class="form-group">
                                                                                    <label class="control-label">{{ $locale == 'en' ? 'English' : 'Arabic' }} Hidden Online Payment</label>

                                                                                    <input type="text"
                                                                                           name="hidden_pay[{{ $locale }}][value]"
                                                                                           value="{{ $settings['hidden_pay'][$locale] ?? old("hidden_pay.$locale.value") }}"
                                                                                           class="form-control"
                                                                                           placeholder="{{ $locale == 'en' ? 'English' : 'Arabic' }} Hidden Online Payment" />
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <hr>

                                                    <div class="row mb-3">
                                                        <h4 class="ml-2">Hidden Installment Payment</h4>
                                                        <div class="default-tab " style="width: 100%">
                                                            <ul class="nav nav-tabs" role="tablist">
                                                                @foreach(config('translatable.locales') as $locale)
                                                                    <li class="nav-item">
                                                                        <a class="nav-link {{ $loop->first ? 'active' : '' }}" data-toggle="tab" href="#{{ $locale }}_hidden_install_pay">
                                                                            {{ $locale == 'en' ? 'English' : 'Arabic' }}
                                                                        </a>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                            <div class="tab-content">
                                                                @foreach(config('translatable.locales') as $locale)
                                                                    <div class="tab-pane fade {{ $loop->first ? "active show" : '' }}" id="{{ $locale }}_hidden_install_pay" role="tabpanel">
                                                                        <div class="pt-4">
                                                                            <div class="col-md-12">
                                                                                <div class="form-group">
                                                                                    <label class="control-label">{{ $locale == 'en' ? 'English' : 'Arabic' }} Hidden Installment Payment</label>

                                                                                    <input type="text"
                                                                                           name="hidden_install_pay[{{ $locale }}][value]"
                                                                                           value="{{ $settings['hidden_install_pay'][$locale] ?? old("hidden_install_pay.$locale.value") }}"
                                                                                           class="form-control"
                                                                                           placeholder="{{ $locale == 'en' ? 'English' : 'Arabic' }} Hidden Installment Payment" />
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <hr>

                                                    <button type="submit" class="btn btn-primary btn-block">Save</button>
                                                </div>
                                            </form>
                                        </div>

                                        <div class="tab-pane fade" id="textarea_settings" role="tabpanel">
                                            <form class="form" method="POST" action="{{ route('admin.settings.update') }}">
                                                @method('PUT')
                                                @csrf
                                                <div class="pt-4">
                                                    <div class="row mb-3">
                                                        <div class="col-md-6">
                                                            <h4 class="ml-2">About us title home page</h4>
                                                            <div class="default-tab " style="width: 100%">
                                                                <ul class="nav nav-tabs" role="tablist">
                                                                    @foreach(config('translatable.locales') as $locale)
                                                                        <li class="nav-item">
                                                                            <a class="nav-link {{ $loop->first ? 'active' : '' }}" data-toggle="tab" href="#{{ $locale }}_about_us_title">
                                                                                {{ $locale == 'en' ? 'English' : 'Arabic' }}
                                                                            </a>
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                                <div class="tab-content">
                                                                    @foreach(config('translatable.locales') as $locale)
                                                                        <div class="tab-pane fade {{ $loop->first ? "active show" : '' }}" id="{{ $locale }}_about_us_title" role="tabpanel">
                                                                            <div class="pt-4">
                                                                                <div class="col-md-12">
                                                                                    <div class="form-group">
                                                                                        <label class="control-label">{{ $locale == 'en' ? 'English' : 'Arabic' }} About us title</label>

                                                                                        <textarea name="about_us_title[{{ $locale }}][value]"
                                                                                                  rows="4"
                                                                                                  class="form-control"
                                                                                                  placeholder="{{ $locale == 'en' ? 'English' : 'Arabic' }} About us title">{{ $settings['about_us_title'][$locale] ?? old("about_us_title.$locale.value") }}</textarea>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <h4 class="ml-2">About us content home page</h4>
                                                            <div class="default-tab " style="width: 100%">
                                                                <ul class="nav nav-tabs" role="tablist">
                                                                    @foreach(config('translatable.locales') as $locale)
                                                                        <li class="nav-item">
                                                                            <a class="nav-link {{ $loop->first ? 'active' : '' }}" data-toggle="tab" href="#{{ $locale }}_about_us_content">
                                                                                {{ $locale == 'en' ? 'English' : 'Arabic' }}
                                                                            </a>
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                                <div class="tab-content">
                                                                    @foreach(config('translatable.locales') as $locale)
                                                                        <div class="tab-pane fade {{ $loop->first ? "active show" : '' }}" id="{{ $locale }}_about_us_content" role="tabpanel">
                                                                            <div class="pt-4">
                                                                                <div class="col-md-12">
                                                                                    <div class="form-group">
                                                                                        <label class="control-label">{{ $locale == 'en' ? 'English' : 'Arabic' }} About us Content</label>

                                                                                        <textarea name="about_us_content[{{ $locale }}][value]"
                                                                                                  rows="4"
                                                                                                  class="form-control"
                                                                                                  placeholder="{{ $locale == 'en' ? 'English' : 'Arabic' }} About us Content">{{ $settings['about_us_content'][$locale] ?? old("about_us_content.$locale.value") }}</textarea>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <hr>

                                                    <div class="row mb-3">
                                                        <h4 class="ml-2">Doctor content home page</h4>
                                                        <div class="default-tab " style="width: 100%">
                                                            <ul class="nav nav-tabs" role="tablist">
                                                                @foreach(config('translatable.locales') as $locale)
                                                                    <li class="nav-item">
                                                                        <a class="nav-link {{ $loop->first ? 'active' : '' }}" data-toggle="tab" href="#{{ $locale }}_doctor_content">
                                                                            {{ $locale == 'en' ? 'English' : 'Arabic' }}
                                                                        </a>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                            <div class="tab-content">
                                                                @foreach(config('translatable.locales') as $locale)
                                                                    <div class="tab-pane fade {{ $loop->first ? "active show" : '' }}" id="{{ $locale }}_doctor_content" role="tabpanel">
                                                                        <div class="pt-4">
                                                                            <div class="col-md-12">
                                                                                <div class="form-group">
                                                                                    <label class="control-label">{{ $locale == 'en' ? 'English' : 'Arabic' }} Doctor Content</label>

                                                                                    <textarea name="doctor_content[{{ $locale }}][value]"
                                                                                              rows="4"
                                                                                              class="form-control"
                                                                                              placeholder="{{ $locale == 'en' ? 'English' : 'Arabic' }} Doctor Content">{{ $settings['doctor_content'][$locale] ?? old("doctor_content.$locale.value") }}</textarea>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <hr>

                                                    <div class="row mb-3">
                                                        <h4 class="ml-2">Lectures content home page</h4>
                                                        <div class="default-tab " style="width: 100%">
                                                            <ul class="nav nav-tabs" role="tablist">
                                                                @foreach(config('translatable.locales') as $locale)
                                                                    <li class="nav-item">
                                                                        <a class="nav-link {{ $loop->first ? 'active' : '' }}" data-toggle="tab" href="#{{ $locale }}_lectures_content">
                                                                            {{ $locale == 'en' ? 'English' : 'Arabic' }}
                                                                        </a>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                            <div class="tab-content">
                                                                @foreach(config('translatable.locales') as $locale)
                                                                    <div class="tab-pane fade {{ $loop->first ? "active show" : '' }}" id="{{ $locale }}_lectures_content" role="tabpanel">
                                                                        <div class="pt-4">
                                                                            <div class="col-md-12">
                                                                                <div class="form-group">
                                                                                    <label class="control-label">{{ $locale == 'en' ? 'English' : 'Arabic' }} Lectures Content</label>

                                                                                    <textarea name="lectures_content[{{ $locale }}][value]"
                                                                                              rows="4"
                                                                                              class="form-control"
                                                                                              placeholder="{{ $locale == 'en' ? 'English' : 'Arabic' }} Lectures Content">{{ $settings['lectures_content'][$locale] ?? old("lectures_content.$locale.value") }}</textarea>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <hr>

                                                    <div class="row mb-3">
                                                        <h4 class="ml-2">review content home page</h4>
                                                        <div class="default-tab " style="width: 100%">
                                                            <ul class="nav nav-tabs" role="tablist">
                                                                @foreach(config('translatable.locales') as $locale)
                                                                    <li class="nav-item">
                                                                        <a class="nav-link {{ $loop->first ? 'active' : '' }}" data-toggle="tab" href="#{{ $locale }}_review_content">
                                                                            {{ $locale == 'en' ? 'English' : 'Arabic' }}
                                                                        </a>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                            <div class="tab-content">
                                                                @foreach(config('translatable.locales') as $locale)
                                                                    <div class="tab-pane fade {{ $loop->first ? "active show" : '' }}" id="{{ $locale }}_review_content" role="tabpanel">
                                                                        <div class="pt-4">
                                                                            <div class="col-md-12">
                                                                                <div class="form-group">
                                                                                    <label class="control-label">{{ $locale == 'en' ? 'English' : 'Arabic' }} review home Content</label>

                                                                                    <textarea name="review_content[{{ $locale }}][value]"
                                                                                              rows="4"
                                                                                              class="form-control"
                                                                                              placeholder="{{ $locale == 'en' ? 'English' : 'Arabic' }} review home Content">{{ $settings['review_content'][$locale] ?? old("review_content.$locale.value") }}</textarea>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <hr>

                                                    <div class="row mb-3">
                                                        <h4 class="ml-2">Articles content home page</h4>
                                                        <div class="default-tab " style="width: 100%">
                                                            <ul class="nav nav-tabs" role="tablist">
                                                                @foreach(config('translatable.locales') as $locale)
                                                                    <li class="nav-item">
                                                                        <a class="nav-link {{ $loop->first ? 'active' : '' }}" data-toggle="tab" href="#{{ $locale }}_articles_content">
                                                                            {{ $locale == 'en' ? 'English' : 'Arabic' }}
                                                                        </a>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                            <div class="tab-content">
                                                                @foreach(config('translatable.locales') as $locale)
                                                                    <div class="tab-pane fade {{ $loop->first ? "active show" : '' }}" id="{{ $locale }}_articles_content" role="tabpanel">
                                                                        <div class="pt-4">
                                                                            <div class="col-md-12">
                                                                                <div class="form-group">
                                                                                    <label class="control-label">{{ $locale == 'en' ? 'English' : 'Arabic' }} Articles Content</label>

                                                                                    <textarea name="articles_content[{{ $locale }}][value]"
                                                                                              rows="4"
                                                                                              class="form-control"
                                                                                              placeholder="{{ $locale == 'en' ? 'English' : 'Arabic' }} Articles Content">{{ $settings['articles_content'][$locale] ?? old("articles_content.$locale.value") }}</textarea>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <hr>

                                                    <div class="row mb-3">
                                                        <h4 class="ml-2">Insurance Companies content home page</h4>
                                                        <div class="default-tab " style="width: 100%">
                                                            <ul class="nav nav-tabs" role="tablist">
                                                                @foreach(config('translatable.locales') as $locale)
                                                                    <li class="nav-item">
                                                                        <a class="nav-link {{ $loop->first ? 'active' : '' }}" data-toggle="tab" href="#{{ $locale }}_insurance_companies">
                                                                            {{ $locale == 'en' ? 'English' : 'Arabic' }}
                                                                        </a>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                            <div class="tab-content">
                                                                @foreach(config('translatable.locales') as $locale)
                                                                    <div class="tab-pane fade {{ $loop->first ? "active show" : '' }}" id="{{ $locale }}_insurance_companies" role="tabpanel">
                                                                        <div class="pt-4">
                                                                            <div class="col-md-12">
                                                                                <div class="form-group">
                                                                                    <label class="control-label">{{ $locale == 'en' ? 'English' : 'Arabic' }} Insurance Companies Content</label>

                                                                                    <textarea name="insurance_companies[{{ $locale }}][value]"
                                                                                              rows="4"
                                                                                              class="form-control"
                                                                                              placeholder="{{ $locale == 'en' ? 'English' : 'Arabic' }} Insurance Companies Content">{{ $settings['insurance_companies'][$locale] ?? old("insurance_companies.$locale.value") }}</textarea>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <hr>

                                                    <div class="row mb-3">
                                                        <h4 class="ml-2">About US page title</h4>
                                                        <div class="default-tab " style="width: 100%">
                                                            <ul class="nav nav-tabs" role="tablist">
                                                                @foreach(config('translatable.locales') as $locale)
                                                                    <li class="nav-item">
                                                                        <a class="nav-link {{ $loop->first ? 'active' : '' }}" data-toggle="tab" href="#{{ $locale }}_about_us_page_title">
                                                                            {{ $locale == 'en' ? 'English' : 'Arabic' }}
                                                                        </a>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                            <div class="tab-content">
                                                                @foreach(config('translatable.locales') as $locale)
                                                                    <div class="tab-pane fade {{ $loop->first ? "active show" : '' }}" id="{{ $locale }}_about_us_page_title" role="tabpanel">
                                                                        <div class="pt-4">
                                                                            <div class="col-md-12">
                                                                                <div class="form-group">
                                                                                    <label class="control-label">{{ $locale == 'en' ? 'English' : 'Arabic' }} About US page title</label>

                                                                                    <textarea name="about_us_page_title[{{ $locale }}][value]"
                                                                                              rows="4"
                                                                                              class="form-control"
                                                                                              placeholder="{{ $locale == 'en' ? 'English' : 'Arabic' }} About US page title">{{ $settings['about_us_page_title'][$locale] ?? old("about_us_page_title.$locale.value") }}</textarea>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <hr>

                                                    <div class="row mb-3">
                                                        <h4 class="ml-2">About US page content</h4>
                                                        <div class="default-tab " style="width: 100%">
                                                            <ul class="nav nav-tabs" role="tablist">
                                                                @foreach(config('translatable.locales') as $locale)
                                                                    <li class="nav-item">
                                                                        <a class="nav-link {{ $loop->first ? 'active' : '' }}" data-toggle="tab" href="#{{ $locale }}_about_us_page_content">
                                                                            {{ $locale == 'en' ? 'English' : 'Arabic' }}
                                                                        </a>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                            <div class="tab-content">
                                                                @foreach(config('translatable.locales') as $locale)
                                                                    <div class="tab-pane fade {{ $loop->first ? "active show" : '' }}" id="{{ $locale }}_about_us_page_content" role="tabpanel">
                                                                        <div class="pt-4">
                                                                            <div class="col-md-12">
                                                                                <div class="form-group">
                                                                                    <label class="control-label">{{ $locale == 'en' ? 'English' : 'Arabic' }} About US page content</label>

                                                                                    <textarea name="about_us_page_content[{{ $locale }}][value]"
                                                                                              rows="6"
                                                                                              id="summernote_aboutus_{{ $locale }}"
                                                                                              class="form-control"
                                                                                              placeholder="{{ $locale == 'en' ? 'English' : 'Arabic' }} About US page content">{!! $settings['about_us_page_content'][$locale] ?? old("about_us_page_content.$locale.value") !!}</textarea>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <hr>

                                                    <div class="row mb-3">
                                                        <h4 class="ml-2">Terms and conditions page content</h4>
                                                        <div class="default-tab " style="width: 100%">
                                                            <ul class="nav nav-tabs" role="tablist">
                                                                @foreach(config('translatable.locales') as $locale)
                                                                    <li class="nav-item">
                                                                        <a class="nav-link {{ $loop->first ? 'active' : '' }}" data-toggle="tab" href="#{{ $locale }}_terms_conditions_page_content">
                                                                            {{ $locale == 'en' ? 'English' : 'Arabic' }}
                                                                        </a>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                            <div class="tab-content">
                                                                @foreach(config('translatable.locales') as $locale)
                                                                    <div class="tab-pane fade {{ $loop->first ? "active show" : '' }}" id="{{ $locale }}_terms_conditions_page_content" role="tabpanel">
                                                                        <div class="pt-4">
                                                                            <div class="col-md-12">
                                                                                <div class="form-group">
                                                                                    <label class="control-label">{{ $locale == 'en' ? 'English' : 'Arabic' }} Terms and conditions page content</label>

                                                                                    <textarea name="terms_conditions_page_content[{{ $locale }}][value]"
                                                                                              rows="6"
                                                                                              id="summernote_terms_conditions_{{ $locale }}"
                                                                                              class="form-control"
                                                                                              placeholder="{{ $locale == 'en' ? 'English' : 'Arabic' }} Terms and conditions page content">{!! $settings['terms_conditions_page_content'][$locale] ?? old("terms_conditions_page_content.$locale.value") !!}</textarea>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <hr>

                                                    <div class="row mb-3">
                                                        <div class="col-md-6">
                                                            <h4 class="ml-2">Message Content</h4>
                                                            <div class="default-tab " style="width: 100%">
                                                                <ul class="nav nav-tabs" role="tablist">
                                                                    @foreach(config('translatable.locales') as $locale)
                                                                        <li class="nav-item">
                                                                            <a class="nav-link {{ $loop->first ? 'active' : '' }}" data-toggle="tab" href="#{{ $locale }}_message">
                                                                                {{ $locale == 'en' ? 'English' : 'Arabic' }}
                                                                            </a>
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                                <div class="tab-content">
                                                                    @foreach(config('translatable.locales') as $locale)
                                                                        <div class="tab-pane fade {{ $loop->first ? "active show" : '' }}" id="{{ $locale }}_message" role="tabpanel">
                                                                            <div class="pt-4">
                                                                                <div class="col-md-12">
                                                                                    <div class="form-group">
                                                                                        <label class="control-label">{{ $locale == 'en' ? 'English' : 'Arabic' }} Message Content</label>

                                                                                        <textarea name="message[{{ $locale }}][value]"
                                                                                                  rows="6"
                                                                                                  class="form-control"
                                                                                                  placeholder="{{ $locale == 'en' ? 'English' : 'Arabic' }} Message Content">{{ $settings['message'][$locale] ?? old("message.$locale.value") }}</textarea>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <h4 class="ml-2">Vision Content</h4>
                                                            <div class="default-tab " style="width: 100%">
                                                                <ul class="nav nav-tabs" role="tablist">
                                                                    @foreach(config('translatable.locales') as $locale)
                                                                        <li class="nav-item">
                                                                            <a class="nav-link {{ $loop->first ? 'active' : '' }}" data-toggle="tab" href="#{{ $locale }}_vision">
                                                                                {{ $locale == 'en' ? 'English' : 'Arabic' }}
                                                                            </a>
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                                <div class="tab-content">
                                                                    @foreach(config('translatable.locales') as $locale)
                                                                        <div class="tab-pane fade {{ $loop->first ? "active show" : '' }}" id="{{ $locale }}_vision" role="tabpanel">
                                                                            <div class="pt-4">
                                                                                <div class="col-md-12">
                                                                                    <div class="form-group">
                                                                                        <label class="control-label">{{ $locale == 'en' ? 'English' : 'Arabic' }} Vision Content</label>

                                                                                        <textarea name="vision[{{ $locale }}][value]"
                                                                                                  rows="6"
                                                                                                  class="form-control"
                                                                                                  placeholder="{{ $locale == 'en' ? 'English' : 'Arabic' }} Vision Content">{{ $settings['vision'][$locale] ?? old("vision.$locale.value") }}</textarea>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <hr>

                                                    <div class="row mb-3">
                                                        <h4 class="ml-2">Page Booking content</h4>
                                                        <div class="default-tab " style="width: 100%">
                                                            <ul class="nav nav-tabs" role="tablist">
                                                                @foreach(config('translatable.locales') as $locale)
                                                                    <li class="nav-item">
                                                                        <a class="nav-link {{ $loop->first ? 'active' : '' }}" data-toggle="tab" href="#{{ $locale }}_page_booking_content">
                                                                            {{ $locale == 'en' ? 'English' : 'Arabic' }}
                                                                        </a>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                            <div class="tab-content">
                                                                @foreach(config('translatable.locales') as $locale)
                                                                    <div class="tab-pane fade {{ $loop->first ? "active show" : '' }}" id="{{ $locale }}_page_booking_content" role="tabpanel">
                                                                        <div class="pt-4">
                                                                            <div class="col-md-12">
                                                                                <div class="form-group">
                                                                                    <label class="control-label">{{ $locale == 'en' ? 'English' : 'Arabic' }} Page Booking content</label>

                                                                                    <textarea name="page_booking_content[{{ $locale }}][value]"
                                                                                              rows="4"
                                                                                              class="form-control"
                                                                                              placeholder="{{ $locale == 'en' ? 'English' : 'Arabic' }} Page Booking content">{!! $settings['page_booking_content'][$locale] ?? old("page_booking_content.$locale.value") !!}</textarea>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <hr>

                                                    <div class="row mb-3">
                                                        <h4 class="ml-2">Page Offer content</h4>
                                                        <div class="default-tab " style="width: 100%">
                                                            <ul class="nav nav-tabs" role="tablist">
                                                                @foreach(config('translatable.locales') as $locale)
                                                                    <li class="nav-item">
                                                                        <a class="nav-link {{ $loop->first ? 'active' : '' }}" data-toggle="tab" href="#{{ $locale }}_page_offer_content">
                                                                            {{ $locale == 'en' ? 'English' : 'Arabic' }}
                                                                        </a>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                            <div class="tab-content">
                                                                @foreach(config('translatable.locales') as $locale)
                                                                    <div class="tab-pane fade {{ $loop->first ? "active show" : '' }}" id="{{ $locale }}_page_offer_content" role="tabpanel">
                                                                        <div class="pt-4">
                                                                            <div class="col-md-12">
                                                                                <div class="form-group">
                                                                                    <label class="control-label">{{ $locale == 'en' ? 'English' : 'Arabic' }} Page Offer content</label>

                                                                                    <textarea name="page_offer_content[{{ $locale }}][value]"
                                                                                              rows="4"
                                                                                              class="form-control"
                                                                                              placeholder="{{ $locale == 'en' ? 'English' : 'Arabic' }} About US page content">{!! $settings['page_offer_content'][$locale] ?? old("page_offer_content.$locale.value") !!}</textarea>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <hr>

                                                    <div class="row mb-3">
                                                        <h4 class="ml-2">Page installment content</h4>
                                                        <div class="default-tab " style="width: 100%">
                                                            <ul class="nav nav-tabs" role="tablist">
                                                                @foreach(config('translatable.locales') as $locale)
                                                                    <li class="nav-item">
                                                                        <a class="nav-link {{ $loop->first ? 'active' : '' }}" data-toggle="tab" href="#{{ $locale }}_page_installment_content">
                                                                            {{ $locale == 'en' ? 'English' : 'Arabic' }}
                                                                        </a>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                            <div class="tab-content">
                                                                @foreach(config('translatable.locales') as $locale)
                                                                    <div class="tab-pane fade {{ $loop->first ? "active show" : '' }}" id="{{ $locale }}_page_installment_content" role="tabpanel">
                                                                        <div class="pt-4">
                                                                            <div class="col-md-12">
                                                                                <div class="form-group">
                                                                                    <label class="control-label">{{ $locale == 'en' ? 'English' : 'Arabic' }} Page installment content</label>

                                                                                    <textarea name="page_installment_content[{{ $locale }}][value]"
                                                                                              rows="4"
                                                                                              class="form-control"
                                                                                              placeholder="{{ $locale == 'en' ? 'English' : 'Arabic' }} page installment content">{!! $settings['page_installment_content'][$locale] ?? old("page_installment_content.$locale.value") !!}</textarea>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <hr>

                                                    <div class="row mb-3">
                                                        <h4 class="ml-2">Booking Services Page content</h4>
                                                        <div class="default-tab " style="width: 100%">
                                                            <ul class="nav nav-tabs" role="tablist">
                                                                @foreach(config('translatable.locales') as $locale)
                                                                    <li class="nav-item">
                                                                        <a class="nav-link {{ $loop->first ? 'active' : '' }}" data-toggle="tab" href="#{{ $locale }}_book_page_services_content">
                                                                            {{ $locale == 'en' ? 'English' : 'Arabic' }}
                                                                        </a>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                            <div class="tab-content">
                                                                @foreach(config('translatable.locales') as $locale)
                                                                    <div class="tab-pane fade {{ $loop->first ? "active show" : '' }}" id="{{ $locale }}_book_page_services_content" role="tabpanel">
                                                                        <div class="pt-4">
                                                                            <div class="col-md-12">
                                                                                <div class="form-group">
                                                                                    <label class="control-label">{{ $locale == 'en' ? 'English' : 'Arabic' }} Page Services content</label>

                                                                                    <textarea name="book_page_services_content[{{ $locale }}][value]"
                                                                                              rows="4"
                                                                                              class="form-control"
                                                                                              placeholder="{{ $locale == 'en' ? 'English' : 'Arabic' }} Services page content">{!! $settings['book_page_services_content'][$locale] ?? old("book_page_services_content.$locale.value") !!}</textarea>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <hr>

                                                    <div class="row mb-3">
                                                        <h4 class="ml-2">Cases content home page</h4>
                                                        <div class="default-tab " style="width: 100%">
                                                            <ul class="nav nav-tabs" role="tablist">
                                                                @foreach(config('translatable.locales') as $locale)
                                                                    <li class="nav-item">
                                                                        <a class="nav-link {{ $loop->first ? 'active' : '' }}" data-toggle="tab" href="#{{ $locale }}_cases_content_home">
                                                                            {{ $locale == 'en' ? 'English' : 'Arabic' }}
                                                                        </a>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                            <div class="tab-content">
                                                                @foreach(config('translatable.locales') as $locale)
                                                                    <div class="tab-pane fade {{ $loop->first ? "active show" : '' }}" id="{{ $locale }}_cases_content_home" role="tabpanel">
                                                                        <div class="pt-4">
                                                                            <div class="col-md-12">
                                                                                <div class="form-group">
                                                                                    <label class="control-label">{{ $locale == 'en' ? 'English' : 'Arabic' }} Cases content home page</label>

                                                                                    <textarea name="cases_content_home[{{ $locale }}][value]"
                                                                                              rows="4"
                                                                                              class="form-control"
                                                                                              placeholder="{{ $locale == 'en' ? 'English' : 'Arabic' }} jobs page content">{!! $settings['cases_content_home'][$locale] ?? old("cases_content_home.$locale.value") !!}</textarea>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <hr>

                                                    <div class="row mb-3">
                                                        <h4 class="ml-2">Booking Careers Page content</h4>
                                                        <div class="default-tab " style="width: 100%">
                                                            <ul class="nav nav-tabs" role="tablist">
                                                                @foreach(config('translatable.locales') as $locale)
                                                                    <li class="nav-item">
                                                                        <a class="nav-link {{ $loop->first ? 'active' : '' }}" data-toggle="tab" href="#{{ $locale }}_book_page_careers_content">
                                                                            {{ $locale == 'en' ? 'English' : 'Arabic' }}
                                                                        </a>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                            <div class="tab-content">
                                                                @foreach(config('translatable.locales') as $locale)
                                                                    <div class="tab-pane fade {{ $loop->first ? "active show" : '' }}" id="{{ $locale }}_book_page_careers_content" role="tabpanel">
                                                                        <div class="pt-4">
                                                                            <div class="col-md-12">
                                                                                <div class="form-group">
                                                                                    <label class="control-label">{{ $locale == 'en' ? 'English' : 'Arabic' }} Page Careers content</label>

                                                                                    <textarea name="book_page_careers_content[{{ $locale }}][value]"
                                                                                              rows="4"
                                                                                              class="form-control"
                                                                                              placeholder="{{ $locale == 'en' ? 'English' : 'Arabic' }} Careers page content">{!! $settings['book_page_careers_content'][$locale] ?? old("book_page_careers_content.$locale.value") !!}</textarea>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <hr>

                                                    <div class="row mb-3">
                                                        <h4 class="ml-2">Before & After Page content</h4>
                                                        <div class="default-tab " style="width: 100%">
                                                            <ul class="nav nav-tabs" role="tablist">
                                                                @foreach(config('translatable.locales') as $locale)
                                                                    <li class="nav-item">
                                                                        <a class="nav-link {{ $loop->first ? 'active' : '' }}" data-toggle="tab" href="#{{ $locale }}_cases_page_content">
                                                                            {{ $locale == 'en' ? 'English' : 'Arabic' }}
                                                                        </a>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                            <div class="tab-content">
                                                                @foreach(config('translatable.locales') as $locale)
                                                                    <div class="tab-pane fade {{ $loop->first ? "active show" : '' }}" id="{{ $locale }}_cases_page_content" role="tabpanel">
                                                                        <div class="pt-4">
                                                                            <div class="col-md-12">
                                                                                <div class="form-group">
                                                                                    <label class="control-label">{{ $locale == 'en' ? 'English' : 'Arabic' }} Before & After Page content</label>

                                                                                    <textarea name="cases_page_content[{{ $locale }}][value]"
                                                                                              rows="4"
                                                                                              class="form-control"
                                                                                              placeholder="{{ $locale == 'en' ? 'English' : 'Arabic' }} Before & After page content">{!! $settings['cases_page_content'][$locale] ?? old("cases_page_content.$locale.value") !!}</textarea>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <hr>

                                                    <div class="row mb-3">
                                                        <h4 class="ml-2">Booking Cases Page content</h4>
                                                        <div class="default-tab " style="width: 100%">
                                                            <ul class="nav nav-tabs" role="tablist">
                                                                @foreach(config('translatable.locales') as $locale)
                                                                    <li class="nav-item">
                                                                        <a class="nav-link {{ $loop->first ? 'active' : '' }}" data-toggle="tab" href="#{{ $locale }}_book_page_cases_content">
                                                                            {{ $locale == 'en' ? 'English' : 'Arabic' }}
                                                                        </a>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                            <div class="tab-content">
                                                                @foreach(config('translatable.locales') as $locale)
                                                                    <div class="tab-pane fade {{ $loop->first ? "active show" : '' }}" id="{{ $locale }}_book_page_cases_content" role="tabpanel">
                                                                        <div class="pt-4">
                                                                            <div class="col-md-12">
                                                                                <div class="form-group">
                                                                                    <label class="control-label">{{ $locale == 'en' ? 'English' : 'Arabic' }} Page Cases content</label>

                                                                                    <textarea name="book_page_cases_content[{{ $locale }}][value]"
                                                                                              rows="4"
                                                                                              class="form-control"
                                                                                              placeholder="{{ $locale == 'en' ? 'English' : 'Arabic' }} Cases page content">{!! $settings['book_page_cases_content'][$locale] ?? old("book_page_cases_content.$locale.value") !!}</textarea>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <hr>

                                                    <div class="row mb-3">
                                                        <h4 class="ml-2">Booking InsuranceCompany Page content</h4>
                                                        <div class="default-tab " style="width: 100%">
                                                            <ul class="nav nav-tabs" role="tablist">
                                                                @foreach(config('translatable.locales') as $locale)
                                                                    <li class="nav-item">
                                                                        <a class="nav-link {{ $loop->first ? 'active' : '' }}" data-toggle="tab" href="#{{ $locale }}_book_page_insurance_content">
                                                                            {{ $locale == 'en' ? 'English' : 'Arabic' }}
                                                                        </a>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                            <div class="tab-content">
                                                                @foreach(config('translatable.locales') as $locale)
                                                                    <div class="tab-pane fade {{ $loop->first ? "active show" : '' }}" id="{{ $locale }}_book_page_insurance_content" role="tabpanel">
                                                                        <div class="pt-4">
                                                                            <div class="col-md-12">
                                                                                <div class="form-group">
                                                                                    <label class="control-label">{{ $locale == 'en' ? 'English' : 'Arabic' }} Page InsuranceCompany content</label>

                                                                                    <textarea name="book_page_insurance_content[{{ $locale }}][value]"
                                                                                              rows="4"
                                                                                              class="form-control"
                                                                                              placeholder="{{ $locale == 'en' ? 'English' : 'Arabic' }} InsuranceCompany page content">{!! $settings['book_page_insurance_content'][$locale] ?? old("book_page_insurance_content.$locale.value") !!}</textarea>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <hr>

                                                    <div class="row mb-3">
                                                        <h4 class="ml-2">InsuranceCompany Page content</h4>
                                                        <div class="default-tab " style="width: 100%">
                                                            <ul class="nav nav-tabs" role="tablist">
                                                                @foreach(config('translatable.locales') as $locale)
                                                                    <li class="nav-item">
                                                                        <a class="nav-link {{ $loop->first ? 'active' : '' }}" data-toggle="tab" href="#{{ $locale }}_insurance_page_content">
                                                                            {{ $locale == 'en' ? 'English' : 'Arabic' }}
                                                                        </a>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                            <div class="tab-content">
                                                                @foreach(config('translatable.locales') as $locale)
                                                                    <div class="tab-pane fade {{ $loop->first ? "active show" : '' }}" id="{{ $locale }}_insurance_page_content" role="tabpanel">
                                                                        <div class="pt-4">
                                                                            <div class="col-md-12">
                                                                                <div class="form-group">
                                                                                    <label class="control-label">{{ $locale == 'en' ? 'English' : 'Arabic' }} InsuranceCompany Page content</label>

                                                                                    <textarea name="insurance_page_content[{{ $locale }}][value]"
                                                                                              rows="4"
                                                                                              class="form-control"
                                                                                              placeholder="{{ $locale == 'en' ? 'English' : 'Arabic' }} InsuranceCompany page content">{!! $settings['insurance_page_content'][$locale] ?? old("insurance_page_content.$locale.value") !!}</textarea>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <hr>

                                                    <div class="row mb-3">
                                                        <h4 class="ml-2">Contact Us Content</h4>
                                                        <div class="default-tab " style="width: 100%">
                                                            <ul class="nav nav-tabs" role="tablist">
                                                                @foreach(config('translatable.locales') as $locale)
                                                                    <li class="nav-item">
                                                                        <a class="nav-link {{ $loop->first ? 'active' : '' }}" data-toggle="tab" href="#{{ $locale }}_contact_us_content">
                                                                            {{ $locale == 'en' ? 'English' : 'Arabic' }}
                                                                        </a>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                            <div class="tab-content">
                                                                @foreach(config('translatable.locales') as $locale)
                                                                    <div class="tab-pane fade {{ $loop->first ? "active show" : '' }}" id="{{ $locale }}_contact_us_content" role="tabpanel">
                                                                        <div class="pt-4">
                                                                            <div class="col-md-12">
                                                                                <div class="form-group">
                                                                                    <label class="control-label">{{ $locale == 'en' ? 'English' : 'Arabic' }} Contact Us Content</label>

                                                                                    <textarea name="contact_us_content[{{ $locale }}][value]"
                                                                                              rows="4"
                                                                                              class="form-control"
                                                                                              placeholder="{{ $locale == 'en' ? 'English' : 'Arabic' }} Contact Us Content">{!! $settings['contact_us_content'][$locale] ?? old("contact_us_content.$locale.value") !!}</textarea>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <hr>

                                                    <div class="row mb-3">
                                                        <h4 class="ml-2">Review Page Content</h4>
                                                        <div class="default-tab " style="width: 100%">
                                                            <ul class="nav nav-tabs" role="tablist">
                                                                @foreach(config('translatable.locales') as $locale)
                                                                    <li class="nav-item">
                                                                        <a class="nav-link {{ $loop->first ? 'active' : '' }}" data-toggle="tab" href="#{{ $locale }}_review_page_content">
                                                                            {{ $locale == 'en' ? 'English' : 'Arabic' }}
                                                                        </a>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                            <div class="tab-content">
                                                                @foreach(config('translatable.locales') as $locale)
                                                                    <div class="tab-pane fade {{ $loop->first ? "active show" : '' }}" id="{{ $locale }}_review_page_content" role="tabpanel">
                                                                        <div class="pt-4">
                                                                            <div class="col-md-12">
                                                                                <div class="form-group">
                                                                                    <label class="control-label">{{ $locale == 'en' ? 'English' : 'Arabic' }} Review Page Content</label>

                                                                                    <textarea name="review_page_content[{{ $locale }}][value]"
                                                                                              rows="4"
                                                                                              class="form-control"
                                                                                              placeholder="{{ $locale == 'en' ? 'English' : 'Arabic' }} Review Page Content">{!! $settings['review_page_content'][$locale] ?? old("review_page_content.$locale.value") !!}</textarea>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <hr>

                                                    <div class="pt-4">
                                                        <div class="row mb-3">
                                                            <!-- BEGIN :: home page seo -->
                                                            <div class="col-md-12">
                                                                <h4 class="ml-2">Title Services Page</h4>
                                                                <div class="default-tab " style="width: 100%">
                                                                    <ul class="nav nav-tabs" role="tablist">
                                                                        @foreach(config('translatable.locales') as $locale)
                                                                            <li class="nav-item">
                                                                                <a class="nav-link {{ $loop->first ? 'active' : '' }}" data-toggle="tab" href="#{{ $locale }}_services_page_title">
                                                                                    {{ $locale == 'en' ? 'English' : 'Arabic' }}
                                                                                </a>
                                                                            </li>
                                                                        @endforeach
                                                                    </ul>
                                                                    <div class="tab-content">
                                                                        @foreach(config('translatable.locales') as $locale)
                                                                            <div class="tab-pane fade {{ $loop->first ? "active show" : '' }}" id="{{ $locale }}_services_page_title" role="tabpanel">
                                                                                <div class="pt-4">
                                                                                    <div class="col-md-12">
                                                                                        <div class="form-group">
                                                                                            <label class="control-label">{{ $locale == 'en' ? 'English' : 'Arabic' }} Services Page Title</label>

                                                                                            <input name="services_page_title[{{ $locale }}][value]"
                                                                                                   rows="3"
                                                                                                   class="form-control"
                                                                                                   placeholder="{{ $locale == 'en' ? 'English' : 'Arabic' }} Services Page Title"
                                                                                                   value="{{ $settings['services_page_title'][$locale] ?? old("services_page_title.$locale.value") }}">
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        @endforeach
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- END :: home page seo -->

                                                            <!-- BEGIN :: about us page seo -->
                                                            <div class="col-md-12">
                                                                <h4 class="ml-2">Text Services Page</h4>
                                                                <div class="default-tab " style="width: 100%">
                                                                    <ul class="nav nav-tabs" role="tablist">
                                                                        @foreach(config('translatable.locales') as $locale)
                                                                            <li class="nav-item">
                                                                                <a class="nav-link {{ $loop->first ? 'active' : '' }}" data-toggle="tab" href="#{{ $locale }}_services_page_content">
                                                                                    {{ $locale == 'en' ? 'English' : 'Arabic' }}
                                                                                </a>
                                                                            </li>
                                                                        @endforeach
                                                                    </ul>
                                                                    <div class="tab-content">
                                                                        @foreach(config('translatable.locales') as $locale)
                                                                            <div class="tab-pane fade {{ $loop->first ? "active show" : '' }}" id="{{ $locale }}_services_page_content" role="tabpanel">
                                                                                <div class="pt-4">
                                                                                    <div class="col-md-12">
                                                                                        <div class="form-group">
                                                                                            <label class="control-label">{{ $locale == 'en' ? 'English' : 'Arabic' }} Services Page Text</label>

                                                                                            <textarea name="services_page_content[{{ $locale }}][value]"
                                                                                                    rows="3"
                                                                                                    class="form-control"
                                                                                                    placeholder="{{ $locale == 'en' ? 'English' : 'Arabic' }} Services Page Text">{!! $settings['services_page_content'][$locale] ?? old("services_page_content.$locale.value") !!}</textarea>
                                                                                       ` </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        @endforeach
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- END :: about us page seo -->
                                                        </div>

                                                    <hr>
                                                    </div>

                                                    <button type="submit" class="btn btn-primary btn-block">Save</button>
                                                </div>
                                            </form>
                                        </div>

                                        <div class="tab-pane fade" id="images_settings" role="tabpanel">
                                            <form class="form" method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
                                                @method('PUT')
                                                @csrf
                                                <div class="pt-4">
                                                    <div class="row">
                                                        <div class="col-md-6 form-group">
                                                            <label class="control-label">Website Logo</label>
                                                            <input type="file"
                                                                   name="images[website_logo]"
                                                                   class="dropify"
                                                                   data-max-file-size="3M"
                                                                   data-default-file="{{ $settings['website_logo'] ?? '' }}" />
                                                        </div>

                                                        <div class="col-md-6 form-group">
                                                            <label class="control-label">Website Icon</label>
                                                            <input type="file"
                                                                   name="images[website_icon]"
                                                                   class="dropify"
                                                                   data-max-file-size="3M"
                                                                   data-default-file="{{ $settings['website_icon'] ?? '' }}" />
                                                        </div>

                                                        <div class="col-md-6 form-group">
                                                            <label class="control-label">Home about image</label>
                                                            <input type="file"
                                                                   name="images[home_about_image]"
                                                                   class="dropify"
                                                                   data-max-file-size="3M"
                                                                   data-default-file="{{ $settings['home_about_image'] ?? '' }}" />
                                                        </div>

                                                        <div class="col-md-6 form-group">
                                                            <label class="control-label">About page image</label>
                                                            <input type="file"
                                                                   name="images[about_page_image]"
                                                                   class="dropify"
                                                                   data-max-file-size="3M"
                                                                   data-default-file="{{ $settings['about_page_image'] ?? '' }}" />
                                                        </div>
                                                    </div>

                                                    <hr>

                                                    <button type="submit" class="btn btn-primary btn-block">Save</button>
                                                </div>
                                            </form>
                                        </div>

                                        <div class="tab-pane fade" id="seo_settings" role="tabpanel">
                                            <form class="form" method="POST" action="{{ route('admin.settings.update') }}">
                                                @method('PUT')
                                                @csrf

                                                <div class="pt-4">
                                                    <div class="row mb-3">
                                                        <!-- BEGIN :: home page seo -->
                                                        <div class="col-md-6">
                                                            <h4 class="ml-2">Home Page SEO</h4>
                                                            <div class="default-tab " style="width: 100%">
                                                                <ul class="nav nav-tabs" role="tablist">
                                                                    @foreach(config('translatable.locales') as $locale)
                                                                        <li class="nav-item">
                                                                            <a class="nav-link {{ $loop->first ? 'active' : '' }}" data-toggle="tab" href="#{{ $locale }}_home_page_seo">
                                                                                {{ $locale == 'en' ? 'English' : 'Arabic' }}
                                                                            </a>
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                                <div class="tab-content">
                                                                    @foreach(config('translatable.locales') as $locale)
                                                                        <div class="tab-pane fade {{ $loop->first ? "active show" : '' }}" id="{{ $locale }}_home_page_seo" role="tabpanel">
                                                                            <div class="pt-4">
                                                                                <div class="col-md-12">
                                                                                    <div class="form-group">
                                                                                        <label class="control-label">{{ $locale == 'en' ? 'English' : 'Arabic' }} Home Page SEO</label>

                                                                                        <textarea name="home_page_seo[{{ $locale }}][value]"
                                                                                                  rows="10"
                                                                                                  class="form-control"
                                                                                                  placeholder="{{ $locale == 'en' ? 'English' : 'Arabic' }} Home Page SEO">{!! $settings['home_page_seo'][$locale] ?? old("home_page_seo.$locale.value") !!}</textarea>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- END :: home page seo -->

                                                        <!-- BEGIN :: about us page seo -->
                                                        <div class="col-md-6">
                                                            <h4 class="ml-2">About Us Page SEO</h4>
                                                            <div class="default-tab " style="width: 100%">
                                                                <ul class="nav nav-tabs" role="tablist">
                                                                    @foreach(config('translatable.locales') as $locale)
                                                                        <li class="nav-item">
                                                                            <a class="nav-link {{ $loop->first ? 'active' : '' }}" data-toggle="tab" href="#{{ $locale }}_about_us_page_seo">
                                                                                {{ $locale == 'en' ? 'English' : 'Arabic' }}
                                                                            </a>
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                                <div class="tab-content">
                                                                    @foreach(config('translatable.locales') as $locale)
                                                                        <div class="tab-pane fade {{ $loop->first ? "active show" : '' }}" id="{{ $locale }}_about_us_page_seo" role="tabpanel">
                                                                            <div class="pt-4">
                                                                                <div class="col-md-12">
                                                                                    <div class="form-group">
                                                                                        <label class="control-label">{{ $locale == 'en' ? 'English' : 'Arabic' }} About Us Page SEO</label>

                                                                                        <textarea name="about_us_page_seo[{{ $locale }}][value]"
                                                                                                  rows="10"
                                                                                                  class="form-control"
                                                                                                  placeholder="{{ $locale == 'en' ? 'English' : 'Arabic' }} About Us Page SEO">{!! $settings['about_us_page_seo'][$locale] ?? old("about_us_page_seo.$locale.value") !!}</textarea>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- END :: about us page seo -->
                                                    </div>

                                                    <hr>


                                                    <div class="row mb-3">
                                                        <!-- BEGIN :: insurance companies page seo -->
                                                        <div class="col-md-6">
                                                            <h4 class="ml-2">Insurance companies Page SEO</h4>
                                                            <div class="default-tab " style="width: 100%">
                                                                <ul class="nav nav-tabs" role="tablist">
                                                                    @foreach(config('translatable.locales') as $locale)
                                                                        <li class="nav-item">
                                                                            <a class="nav-link {{ $loop->first ? 'active' : '' }}" data-toggle="tab" href="#{{ $locale }}_insurance_companies_page_seo">
                                                                                {{ $locale == 'en' ? 'English' : 'Arabic' }}
                                                                            </a>
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                                <div class="tab-content">
                                                                    @foreach(config('translatable.locales') as $locale)
                                                                        <div class="tab-pane fade {{ $loop->first ? "active show" : '' }}" id="{{ $locale }}_insurance_companies_page_seo" role="tabpanel">
                                                                            <div class="pt-4">
                                                                                <div class="col-md-12">
                                                                                    <div class="form-group">
                                                                                        <label class="control-label">{{ $locale == 'en' ? 'English' : 'Arabic' }} Insurance companies Page SEO</label>

                                                                                        <textarea name="insurance_companies_page_seo[{{ $locale }}][value]"
                                                                                                  rows="10"
                                                                                                  class="form-control"
                                                                                                  placeholder="{{ $locale == 'en' ? 'English' : 'Arabic' }} Insurance companies Page SEO">{!! $settings['insurance_companies_page_seo'][$locale] ?? old("insurance_companies_page_seo.$locale.value") !!}</textarea>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- END :: insurance companies page seo -->

                                                        <!-- BEGIN :: services page seo -->
                                                        <div class="col-md-6">
                                                            <h4 class="ml-2">Services Page SEO</h4>
                                                            <div class="default-tab " style="width: 100%">
                                                                <ul class="nav nav-tabs" role="tablist">
                                                                    @foreach(config('translatable.locales') as $locale)
                                                                        <li class="nav-item">
                                                                            <a class="nav-link {{ $loop->first ? 'active' : '' }}" data-toggle="tab" href="#{{ $locale }}_services_page_seo">
                                                                                {{ $locale == 'en' ? 'English' : 'Arabic' }}
                                                                            </a>
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                                <div class="tab-content">
                                                                    @foreach(config('translatable.locales') as $locale)
                                                                        <div class="tab-pane fade {{ $loop->first ? "active show" : '' }}" id="{{ $locale }}_services_page_seo" role="tabpanel">
                                                                            <div class="pt-4">
                                                                                <div class="col-md-12">
                                                                                    <div class="form-group">
                                                                                        <label class="control-label">{{ $locale == 'en' ? 'English' : 'Arabic' }} Services Page SEO</label>

                                                                                        <textarea name="services_page_seo[{{ $locale }}][value]"
                                                                                                  rows="10"
                                                                                                  class="form-control"
                                                                                                  placeholder="{{ $locale == 'en' ? 'English' : 'Arabic' }} Services Page SEO">{!! $settings['services_page_seo'][$locale] ?? old("services_page_seo.$locale.value") !!}</textarea>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- END :: services page seo -->

                                                    </div>

                                                    <hr>

                                                    <div class="row mb-3">
                                                        <!-- BEGIN :: doctors page seo -->
                                                        <div class="col-md-6">
                                                            <h4 class="ml-2">Doctors Page SEO</h4>
                                                            <div class="default-tab " style="width: 100%">
                                                                <ul class="nav nav-tabs" role="tablist">
                                                                    @foreach(config('translatable.locales') as $locale)
                                                                        <li class="nav-item">
                                                                            <a class="nav-link {{ $loop->first ? 'active' : '' }}" data-toggle="tab" href="#{{ $locale }}_doctors_page_seo">
                                                                                {{ $locale == 'en' ? 'English' : 'Arabic' }}
                                                                            </a>
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                                <div class="tab-content">
                                                                    @foreach(config('translatable.locales') as $locale)
                                                                        <div class="tab-pane fade {{ $loop->first ? "active show" : '' }}" id="{{ $locale }}_doctors_page_seo" role="tabpanel">
                                                                            <div class="pt-4">
                                                                                <div class="col-md-12">
                                                                                    <div class="form-group">
                                                                                        <label class="control-label">{{ $locale == 'en' ? 'English' : 'Arabic' }} Doctors Page SEO</label>

                                                                                        <textarea name="doctors_page_seo[{{ $locale }}][value]"
                                                                                                  rows="10"
                                                                                                  class="form-control"
                                                                                                  placeholder="{{ $locale == 'en' ? 'English' : 'Arabic' }} Doctors Page SEO">{!! $settings['doctors_page_seo'][$locale] ?? old("doctors_page_seo.$locale.value") !!}</textarea>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- END :: doctors page seo -->

                                                        <!-- BEGIN :: cases page seo -->
                                                        <div class="col-md-6">
                                                            <h4 class="ml-2">Cases Page SEO</h4>
                                                            <div class="default-tab " style="width: 100%">
                                                                <ul class="nav nav-tabs" role="tablist">
                                                                    @foreach(config('translatable.locales') as $locale)
                                                                        <li class="nav-item">
                                                                            <a class="nav-link {{ $loop->first ? 'active' : '' }}" data-toggle="tab" href="#{{ $locale }}_cases_page_seo">
                                                                                {{ $locale == 'en' ? 'English' : 'Arabic' }}
                                                                            </a>
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                                <div class="tab-content">
                                                                    @foreach(config('translatable.locales') as $locale)
                                                                        <div class="tab-pane fade {{ $loop->first ? "active show" : '' }}" id="{{ $locale }}_cases_page_seo" role="tabpanel">
                                                                            <div class="pt-4">
                                                                                <div class="col-md-12">
                                                                                    <div class="form-group">
                                                                                        <label class="control-label">{{ $locale == 'en' ? 'English' : 'Arabic' }} Cases Page SEO</label>

                                                                                        <textarea name="cases_page_seo[{{ $locale }}][value]"
                                                                                                  rows="10"
                                                                                                  class="form-control"
                                                                                                  placeholder="{{ $locale == 'en' ? 'English' : 'Arabic' }} Cases Page SEO">{!! $settings['cases_page_seo'][$locale] ?? old("cases_page_seo.$locale.value") !!}</textarea>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- END :: cases page seo -->
                                                    </div>

                                                    <hr>

                                                    <div class="row mb-3">
                                                        <!-- BEGIN :: careers page seo -->
                                                        <div class="col-md-6">
                                                            <h4 class="ml-2">Terms and Conditions Page SEO</h4>
                                                            <div class="default-tab " style="width: 100%">
                                                                <ul class="nav nav-tabs" role="tablist">
                                                                    @foreach(config('translatable.locales') as $locale)
                                                                        <li class="nav-item">
                                                                            <a class="nav-link {{ $loop->first ? 'active' : '' }}" data-toggle="tab" href="#{{ $locale }}_terms_conditions_seo">
                                                                                {{ $locale == 'en' ? 'English' : 'Arabic' }}
                                                                            </a>
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                                <div class="tab-content">
                                                                    @foreach(config('translatable.locales') as $locale)
                                                                        <div class="tab-pane fade {{ $loop->first ? "active show" : '' }}" id="{{ $locale }}_terms_conditions_seo" role="tabpanel">
                                                                            <div class="pt-4">
                                                                                <div class="col-md-12">
                                                                                    <div class="form-group">
                                                                                        <label class="control-label">{{ $locale == 'en' ? 'English' : 'Arabic' }} Terms and Conditions Page SEO</label>

                                                                                        <textarea name="terms_conditions_seo[{{ $locale }}][value]"
                                                                                                  rows="10"
                                                                                                  class="form-control"
                                                                                                  placeholder="{{ $locale == 'en' ? 'English' : 'Arabic' }} Terms and Conditions Page SEO">{!! $settings['terms_conditions_seo'][$locale] ?? old("terms_conditions_seo.$locale.value") !!}</textarea>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- END :: careers page seo -->

                                                        <!-- BEGIN :: contact us page seo -->
                                                        <div class="col-md-6">
                                                            <h4 class="ml-2">Contact Us Page SEO</h4>
                                                            <div class="default-tab " style="width: 100%">
                                                                <ul class="nav nav-tabs" role="tablist">
                                                                    @foreach(config('translatable.locales') as $locale)
                                                                        <li class="nav-item">
                                                                            <a class="nav-link {{ $loop->first ? 'active' : '' }}" data-toggle="tab" href="#{{ $locale }}_contact_us_page_seo">
                                                                                {{ $locale == 'en' ? 'English' : 'Arabic' }}
                                                                            </a>
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                                <div class="tab-content">
                                                                    @foreach(config('translatable.locales') as $locale)
                                                                        <div class="tab-pane fade {{ $loop->first ? "active show" : '' }}" id="{{ $locale }}_contact_us_page_seo" role="tabpanel">
                                                                            <div class="pt-4">
                                                                                <div class="col-md-12">
                                                                                    <div class="form-group">
                                                                                        <label class="control-label">{{ $locale == 'en' ? 'English' : 'Arabic' }} Contact Us Page SEO</label>

                                                                                        <textarea name="contact_us_page_seo[{{ $locale }}][value]"
                                                                                                  rows="10"
                                                                                                  class="form-control"
                                                                                                  placeholder="{{ $locale == 'en' ? 'English' : 'Arabic' }} Contact Us Page SEO">{!! $settings['contact_us_page_seo'][$locale] ?? old("contact_us_page_seo.$locale.value") !!}</textarea>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- END :: contact us page seo -->
                                                    </div>

                                                    <hr>

                                                    <div class="row mb-3">
                                                        <!-- BEGIN :: offers page seo -->
                                                        <div class="col-md-6">
                                                            <h4 class="ml-2">Offers Page SEO</h4>
                                                            <div class="default-tab " style="width: 100%">
                                                                <ul class="nav nav-tabs" role="tablist">
                                                                    @foreach(config('translatable.locales') as $locale)
                                                                        <li class="nav-item">
                                                                            <a class="nav-link {{ $loop->first ? 'active' : '' }}" data-toggle="tab" href="#{{ $locale }}_offers_page_seo">
                                                                                {{ $locale == 'en' ? 'English' : 'Arabic' }}
                                                                            </a>
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                                <div class="tab-content">
                                                                    @foreach(config('translatable.locales') as $locale)
                                                                        <div class="tab-pane fade {{ $loop->first ? "active show" : '' }}" id="{{ $locale }}_offers_page_seo" role="tabpanel">
                                                                            <div class="pt-4">
                                                                                <div class="col-md-12">
                                                                                    <div class="form-group">
                                                                                        <label class="control-label">{{ $locale == 'en' ? 'English' : 'Arabic' }} Offers Page SEO</label>

                                                                                        <textarea name="offers_page_seo[{{ $locale }}][value]"
                                                                                                  rows="10"
                                                                                                  class="form-control"
                                                                                                  placeholder="{{ $locale == 'en' ? 'English' : 'Arabic' }} Offers Page SEO">{!! $settings['offers_page_seo'][$locale] ?? old("offers_page_seo.$locale.value") !!}</textarea>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- END :: offers page seo -->

                                                        <!-- BEGIN :: offer book page seo -->
                                                        <div class="col-md-6">
                                                            <h4 class="ml-2">offer book Page SEO</h4>
                                                            <div class="default-tab " style="width: 100%">
                                                                <ul class="nav nav-tabs" role="tablist">
                                                                    @foreach(config('translatable.locales') as $locale)
                                                                        <li class="nav-item">
                                                                            <a class="nav-link {{ $loop->first ? 'active' : '' }}" data-toggle="tab" href="#{{ $locale }}_offer_book_page_seo">
                                                                                {{ $locale == 'en' ? 'English' : 'Arabic' }}
                                                                            </a>
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                                <div class="tab-content">
                                                                    @foreach(config('translatable.locales') as $locale)
                                                                        <div class="tab-pane fade {{ $loop->first ? "active show" : '' }}" id="{{ $locale }}_offer_book_page_seo" role="tabpanel">
                                                                            <div class="pt-4">
                                                                                <div class="col-md-12">
                                                                                    <div class="form-group">
                                                                                        <label class="control-label">{{ $locale == 'en' ? 'English' : 'Arabic' }} offer book Page SEO</label>

                                                                                        <textarea name="offer_book_page_seo[{{ $locale }}][value]"
                                                                                                  rows="10"
                                                                                                  class="form-control"
                                                                                                  placeholder="{{ $locale == 'en' ? 'English' : 'Arabic' }} offer book Page SEO">{!! $settings['offer_book_page_seo'][$locale] ?? old("offer_book_page_seo.$locale.value") !!}</textarea>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- END :: offer book page seo -->
                                                    </div>

                                                    <hr>

                                                    <div class="row mb-3">
                                                        <!-- BEGIN :: review page seo -->
                                                        <div class="col-md-6">
                                                            <h4 class="ml-2">Review Page SEO</h4>
                                                            <div class="default-tab " style="width: 100%">
                                                                <ul class="nav nav-tabs" role="tablist">
                                                                    @foreach(config('translatable.locales') as $locale)
                                                                        <li class="nav-item">
                                                                            <a class="nav-link {{ $loop->first ? 'active' : '' }}" data-toggle="tab" href="#{{ $locale }}_review_page_seo">
                                                                                {{ $locale == 'en' ? 'English' : 'Arabic' }}
                                                                            </a>
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                                <div class="tab-content">
                                                                    @foreach(config('translatable.locales') as $locale)
                                                                        <div class="tab-pane fade {{ $loop->first ? "active show" : '' }}" id="{{ $locale }}_review_page_seo" role="tabpanel">
                                                                            <div class="pt-4">
                                                                                <div class="col-md-12">
                                                                                    <div class="form-group">
                                                                                        <label class="control-label">{{ $locale == 'en' ? 'English' : 'Arabic' }} Review Page SEO</label>

                                                                                        <textarea name="review_page_seo[{{ $locale }}][value]"
                                                                                                  rows="10"
                                                                                                  class="form-control"
                                                                                                  placeholder="{{ $locale == 'en' ? 'English' : 'Arabic' }} Review Page SEO">{!! $settings['review_page_seo'][$locale] ?? old("review_page_seo.$locale.value") !!}</textarea>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- END :: review page seo -->

                                                        <!-- BEGIN :: booking page seo -->
                                                        <div class="col-md-6">
                                                            <h4 class="ml-2">booking Page SEO</h4>
                                                            <div class="default-tab " style="width: 100%">
                                                                <ul class="nav nav-tabs" role="tablist">
                                                                    @foreach(config('translatable.locales') as $locale)
                                                                        <li class="nav-item">
                                                                            <a class="nav-link {{ $loop->first ? 'active' : '' }}" data-toggle="tab" href="#{{ $locale }}_booking_page_seo">
                                                                                {{ $locale == 'en' ? 'English' : 'Arabic' }}
                                                                            </a>
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                                <div class="tab-content">
                                                                    @foreach(config('translatable.locales') as $locale)
                                                                        <div class="tab-pane fade {{ $loop->first ? "active show" : '' }}" id="{{ $locale }}_booking_page_seo" role="tabpanel">
                                                                            <div class="pt-4">
                                                                                <div class="col-md-12">
                                                                                    <div class="form-group">
                                                                                        <label class="control-label">{{ $locale == 'en' ? 'English' : 'Arabic' }} booking Page SEO</label>

                                                                                        <textarea name="booking_page_seo[{{ $locale }}][value]"
                                                                                                  rows="10"
                                                                                                  class="form-control"
                                                                                                  placeholder="{{ $locale == 'en' ? 'English' : 'Arabic' }} booking Page SEO">{!! $settings['booking_page_seo'][$locale] ?? old("booking_page_seo.$locale.value") !!}</textarea>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- END :: booking page seo -->

                                                        <!-- BEGIN :: frequently asked questions page seo -->
                                                        <div class="col-md-6">
                                                            <h4 class="ml-2">frequently asked questions Page SEO</h4>
                                                            <div class="default-tab " style="width: 100%">
                                                                <ul class="nav nav-tabs" role="tablist">
                                                                    @foreach(config('translatable.locales') as $locale)
                                                                        <li class="nav-item">
                                                                            <a class="nav-link {{ $loop->first ? 'active' : '' }}" data-toggle="tab" href="#{{ $locale }}_frequently_questions_seo">
                                                                                {{ $locale == 'en' ? 'English' : 'Arabic' }}
                                                                            </a>
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                                <div class="tab-content">
                                                                    @foreach(config('translatable.locales') as $locale)
                                                                        <div class="tab-pane fade {{ $loop->first ? "active show" : '' }}" id="{{ $locale }}_frequently_questions_seo" role="tabpanel">
                                                                            <div class="pt-4">
                                                                                <div class="col-md-12">
                                                                                    <div class="form-group">
                                                                                        <label class="control-label">{{ $locale == 'en' ? 'English' : 'Arabic' }} frequently questions Page SEO</label>

                                                                                        <textarea name="frequently_questions_seo[{{ $locale }}][value]"
                                                                                                  rows="10"
                                                                                                  class="form-control"
                                                                                                  placeholder="{{ $locale == 'en' ? 'English' : 'Arabic' }} frequently questions Page SEO">{!! $settings['frequently_questions_seo'][$locale] ?? old("frequently_questions_seo.$locale.value") !!}</textarea>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- END :: frequently asked questions page seo -->

                                                        <!-- BEGIN :: blogs page seo -->
                                                        <div class="col-md-6">
                                                            <h4 class="ml-2">Blogs Page SEO</h4>
                                                            <div class="default-tab " style="width: 100%">
                                                                <ul class="nav nav-tabs" role="tablist">
                                                                    @foreach(config('translatable.locales') as $locale)
                                                                        <li class="nav-item">
                                                                            <a class="nav-link {{ $loop->first ? 'active' : '' }}" data-toggle="tab" href="#{{ $locale }}_blogs_page_seo">
                                                                                {{ $locale == 'en' ? 'English' : 'Arabic' }}
                                                                            </a>
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                                <div class="tab-content">
                                                                    @foreach(config('translatable.locales') as $locale)
                                                                        <div class="tab-pane fade {{ $loop->first ? "active show" : '' }}" id="{{ $locale }}_blogs_page_seo" role="tabpanel">
                                                                            <div class="pt-4">
                                                                                <div class="col-md-12">
                                                                                    <div class="form-group">
                                                                                        <label class="control-label">{{ $locale == 'en' ? 'English' : 'Arabic' }} Blogs Page SEO</label>

                                                                                        <textarea name="blogs_page_seo[{{ $locale }}][value]"
                                                                                                  rows="10"
                                                                                                  class="form-control"
                                                                                                  placeholder="{{ $locale == 'en' ? 'English' : 'Arabic' }} Blogs Page SEO">{!! $settings['blogs_page_seo'][$locale] ?? old("blogs_page_seo.$locale.value") !!}</textarea>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- END :: blogs page seo -->

                                                        <!-- BEGIN :: branches page seo -->
                                                        <div class="col-md-6">
                                                            <h4 class="ml-2">branches Page SEO</h4>
                                                            <div class="default-tab " style="width: 100%">
                                                                <ul class="nav nav-tabs" role="tablist">
                                                                    @foreach(config('translatable.locales') as $locale)
                                                                        <li class="nav-item">
                                                                            <a class="nav-link {{ $loop->first ? 'active' : '' }}" data-toggle="tab" href="#{{ $locale }}_branches_page_seo">
                                                                                {{ $locale == 'en' ? 'English' : 'Arabic' }}
                                                                            </a>
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                                <div class="tab-content">
                                                                    @foreach(config('translatable.locales') as $locale)
                                                                        <div class="tab-pane fade {{ $loop->first ? "active show" : '' }}" id="{{ $locale }}_branches_page_seo" role="tabpanel">
                                                                            <div class="pt-4">
                                                                                <div class="col-md-12">
                                                                                    <div class="form-group">
                                                                                        <label class="control-label">{{ $locale == 'en' ? 'English' : 'Arabic' }} branches Page SEO</label>

                                                                                        <textarea name="branches_page_seo[{{ $locale }}][value]"
                                                                                                  rows="10"
                                                                                                  class="form-control"
                                                                                                  placeholder="{{ $locale == 'en' ? 'English' : 'Arabic' }} branches Page SEO">{!! $settings['branches_page_seo'][$locale] ?? old("branches_page_seo.$locale.value") !!}</textarea>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- END :: branches page seo -->

                                                        <!-- BEGIN :: reviews page seo -->
                                                        <div class="col-md-6">
                                                            <h4 class="ml-2">reviews Page SEO</h4>
                                                            <div class="default-tab " style="width: 100%">
                                                                <ul class="nav nav-tabs" role="tablist">
                                                                    @foreach(config('translatable.locales') as $locale)
                                                                        <li class="nav-item">
                                                                            <a class="nav-link {{ $loop->first ? 'active' : '' }}" data-toggle="tab" href="#{{ $locale }}_reviews_page_seo">
                                                                                {{ $locale == 'en' ? 'English' : 'Arabic' }}
                                                                            </a>
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                                <div class="tab-content">
                                                                    @foreach(config('translatable.locales') as $locale)
                                                                        <div class="tab-pane fade {{ $loop->first ? "active show" : '' }}" id="{{ $locale }}_reviews_page_seo" role="tabpanel">
                                                                            <div class="pt-4">
                                                                                <div class="col-md-12">
                                                                                    <div class="form-group">
                                                                                        <label class="control-label">{{ $locale == 'en' ? 'English' : 'Arabic' }} reviews Page SEO</label>

                                                                                        <textarea name="reviews_page_seo[{{ $locale }}][value]"
                                                                                                  rows="10"
                                                                                                  class="form-control"
                                                                                                  placeholder="{{ $locale == 'en' ? 'English' : 'Arabic' }} reviews Page SEO">{!! $settings['reviews_page_seo'][$locale] ?? old("reviews_page_seo.$locale.value") !!}</textarea>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- END :: reviews page seo -->
                                                    </div>

                                                    <hr>

                                                    <div class="row mb-3">
                                                        <!-- BEGIN :: robots page seo -->
                                                        <div class="col-md-12">
                                                            <h4 class="ml-2">Robots Page .txt</h4>
                                                            <div class="default-tab " style="width: 100%">
                                                                <div class="tab-content">
                                                                    <div class="pt-4">
                                                                        <div class="col-md-12">
                                                                            <div class="form-group">
                                                                                <label class="control-label">Robots Page .txt</label>
                                                                                <textarea name="robots_page_seo" rows="10" class="form-control">{!! $settings['robots_page_seo'] ?? old("robots_page_seo.") !!}</textarea>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- END :: robots page seo -->
                                                    </div>
                                                </div>

                                                <button type="submit" class="btn btn-primary btn-block">Save</button>
                                            </form>
                                        </div>

                                        <div class="tab-pane fade" id="schema_settings" role="tabpanel">
                                            <form class="form" method="POST" action="{{ route('admin.settings.update') }}">
                                                @method('PUT')
                                                @csrf

                                                <div class="pt-0">
                                                    <div class="row mb-3">
                                                        <!-- BEGIN :: home page seo -->
                                                        <div class="col-md-6">
                                                            <div class="pt-4">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Home Page Schema</label>
                                                                        <textarea name="home_page_schema" rows="10" class="form-control" placeholder="Home Page Schema">{!! $settings['home_page_schema'] ?? old("home_page_schema") !!}</textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- END :: home page seo -->

                                                        <!-- BEGIN :: about us page seo -->
                                                        <div class="col-md-6">
                                                            <div class="pt-4">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label class="control-label">About Us Page Schema</label>
                                                                        <textarea name="about_us_page_schema" rows="10" class="form-control" placeholder="About Us Page Schema">{!! $settings['about_us_page_schema'] ?? old("about_us_page_schema") !!}</textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- END :: about us page seo -->
                                                    </div>

                                                    <hr>

                                                    <div class="row mb-3">
                                                        <!-- BEGIN :: Terms page seo -->
                                                        <div class="col-md-6">
                                                            <div class="pt-4">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Terms Page Schema</label>
                                                                        <textarea name="terms_page_schema" rows="10" class="form-control" placeholder="Terms Page Schema">{!! $settings['terms_page_schema'] ?? old("terms_page_schema") !!}</textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- END :: Terms page seo -->

                                                        <!-- BEGIN :: Services page seo -->
                                                        <div class="col-md-6">
                                                            <div class="pt-4">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Services Page Schema</label>
                                                                        <textarea name="services_page_schema" rows="10" class="form-control" placeholder="Services Page Schema">{!! $settings['services_page_schema'] ?? old("services_page_schema") !!}</textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- END :: Services page seo -->
                                                    </div>

                                                    <hr>

                                                    <div class="row mb-3">
                                                        <!-- BEGIN :: Doctors page seo -->
                                                        <div class="col-md-6">
                                                            <div class="pt-4">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Doctors Page Schema</label>
                                                                        <textarea name="doctors_page_schema" rows="10" class="form-control" placeholder="Doctors Page Schema">{!! $settings['doctors_page_schema'] ?? old("doctors_page_schema") !!}</textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- END :: Doctors page seo -->

                                                        <!-- BEGIN :: Cases page seo -->
                                                        <div class="col-md-6">
                                                            <div class="pt-4">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Cases Page Schema</label>
                                                                        <textarea name="cases_page_schema" rows="10" class="form-control" placeholder="Cases Page Schema">{!! $settings['cases_page_schema'] ?? old("cases_page_schema") !!}</textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- END :: Cases page seo -->
                                                    </div>

                                                    <hr>

                                                    <div class="row mb-3">
                                                        <!-- BEGIN :: Blogs page seo -->
                                                        <div class="col-md-6">
                                                            <div class="pt-4">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Blogs Page Schema</label>
                                                                        <textarea name="blogs_page_schema" rows="10" class="form-control" placeholder="Blogs Page Schema">{!! $settings['blogs_page_schema'] ?? old("blogs_page_schema") !!}</textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- END :: Blogs page seo -->

                                                        <!-- BEGIN :: Lectures page seo -->
                                                        <div class="col-md-6">
                                                            <div class="pt-4">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Lectures Page Schema</label>
                                                                        <textarea name="lectures_page_schema" rows="10" class="form-control" placeholder="Lectures Page Schema">{!! $settings['lectures_page_schema'] ?? old("lectures_page_schema") !!}</textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- END :: Lectures page seo -->
                                                    </div>

                                                    <hr>

                                                    <div class="row mb-3">
                                                        <!-- BEGIN :: Branches page seo -->
                                                        <div class="col-md-6">
                                                            <div class="pt-4">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Branches Page Schema</label>
                                                                        <textarea name="branches_page_schema" rows="10" class="form-control" placeholder="Branches Page Schema">{!! $settings['branches_page_schema'] ?? old("branches_page_schema") !!}</textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- END :: Branches page seo -->

                                                        <!-- BEGIN :: Review page seo -->
                                                        <div class="col-md-6">
                                                            <div class="pt-4">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Review Page Schema</label>
                                                                        <textarea name="review_page_schema" rows="10" class="form-control" placeholder="Review Page Schema">{!! $settings['review_page_schema'] ?? old("review_page_schema") !!}</textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- END :: Review page seo -->
                                                    </div>

                                                    <hr>

                                                    <div class="row mb-3">
                                                        <!-- BEGIN :: Contact page seo -->
                                                        <div class="col-md-6">
                                                            <div class="pt-4">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Contact Us Page Schema</label>
                                                                        <textarea name="contact_page_schema" rows="10" class="form-control" placeholder="Contact Page Schema">{!! $settings['contact_page_schema'] ?? old("contact_page_schema") !!}</textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- END :: Contact page seo -->

                                                        <!-- BEGIN :: Offer page seo -->
                                                        <div class="col-md-6">
                                                            <div class="pt-4">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Offer Page Schema</label>
                                                                        <textarea name="offer_page_schema" rows="10" class="form-control" placeholder="Offer Page Schema">{!! $settings['offer_page_schema'] ?? old("offer_page_schema") !!}</textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- END :: Offer page seo -->
                                                    </div>

                                                    <hr>

                                                    <div class="row mb-3">
                                                        <!-- BEGIN :: Booking page seo -->
                                                        <div class="col-md-6">
                                                            <div class="pt-4">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Booking Page Schema</label>
                                                                        <textarea name="book_page_schema" rows="10" class="form-control" placeholder="Booking Page Schema">{!! $settings['book_page_schema'] ?? old("book_page_schema") !!}</textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- END :: Booking page seo -->
                                                    </div>

                                                    <hr>
                                                </div>
                                                <button type="submit" class="btn btn-primary btn-block">Save</button>
                                            </form>
                                        </div>

                                        <div class="tab-pane fade" id="site_map_settings" role="tabpanel">
                                            <form class="form" method="POST" action="{{ route('admin.settings.sitemap') }}">
                                                @csrf

                                                <button type="submit" class="btn btn-primary btn-block">Generate sit map</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.min.js" integrity="sha512-9UR1ynHntZdqHnwXKTaOm1s6V9fExqejKvg5XMawEMToW4sSw+3jtLrYfZPijvnwnnE8Uol1O9BcAskoxgec+g==" crossorigin="anonymous"></script>
    <script>
        @foreach(config('translatable.locales') as $locale)
            $(document).ready(function() {
                $('#summernote_aboutus_{{ $locale }}').summernote({
                    height: 200
                });
            });

            $(document).ready(function() {
                $('#summernote_terms_conditions_{{ $locale }}').summernote({
                    height: 200
                });
            });
        @endforeach
    </script>

    <script>
        $('.dropify').dropify();

        $(document).ready(function(){
            var tagInputEle = $('.tags-input');
            tagInputEle.tagsinput();
        });
    </script>
@endpush
