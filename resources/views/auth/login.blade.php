@extends('admin.layout.locked')

@section('contents')
    <div class="row justify-content-center align-items-center">
        <div class="col-md-6">
            <div class="authincation-content">
                <div class="row no-gutters">
                    <div class="col-xl-12">
                        <div class="auth-form">
                            <h4 class="text-center mb-4 text-white">Sign in your account</h4>
                            <form method="POST" action="{{ route('login') }}">
                                @csrf

                                <div class="form-group">
                                    <label class="mb-1 text-white" for="identifier">
                                        <strong>Email or username</strong>
                                    </label>
                                    <input type="text"
                                           name="identifier"
                                           class="form-control"
                                           value="{{ old('identifier') }}"
                                           autocomplete />

                                    @error('identifier')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label class="mb-1 text-white"><strong>Password</strong></label>
                                    <input type="password"
                                           name="password"
                                           class="form-control"
                                           autocomplete />

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-row d-flex justify-content-between mt-4 mb-2">
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox ml-1 text-white">
                                            <input type="checkbox"
                                                   class="custom-control-input"
                                                   name="remember"
                                                   id="remember"
                                                   checked />

                                            <label class="custom-control-label" for="remember">Remember my preference</label>
                                        </div>
                                    </div>

                                    {{--<div class="form-group">
                                        <a class="text-white" href="#">Forgot Password?</a>
                                    </div>--}}
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn bg-white text-primary btn-block">Sign In</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
