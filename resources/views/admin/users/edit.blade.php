@extends('admin.layout.base')

@section('title', "Edit a User ( $user->name )")

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="basic-form">
                            <form class="form" method="POST" action="{{ route('admin.users.update', ['user' => $user->id]) }}">
                                @method('PUT')
                                @csrf

                                <div class="form-row">
                                    <div class="form-group col-md-6 bmd-form-group  @error('name') has-danger @enderror">
                                        <label for="name_input"> Name <span class="text-danger"> * </span></label>

                                        <input type="text"
                                               name="name"
                                               id="name_input"
                                               value="{{ $user->name }}"
                                               class="form-control" />

                                        @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6 bmd-form-group  @error('username') has-danger @enderror">
                                        <label for="name_input"> Username <span class="text-danger"> * </span></label>

                                        <input type="text"
                                               name="username"
                                               id="username_input"
                                               value="{{ $user->username }}"
                                               class="form-control" />

                                        @error('username')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-12 bmd-form-group  @error('email') has-danger @enderror">
                                        <label for="name_input"> Email <span class="text-danger"> * </span></label>

                                        <input type="text"
                                               name="email"
                                               id="email_input"
                                               value="{{ $user->email }}"
                                               class="form-control" />

                                        @error('email')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6 bmd-form-group  @error('password') has-danger @enderror">
                                        <label for="name_input"> Password <span class="text-danger"> * </span></label>

                                        <input type="password"
                                               name="password"
                                               id="password_input"
                                               value="{{ old('password') }}"
                                               class="form-control" />

                                        @error('password')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6 bmd-form-group  @error('password_confirmation') has-danger @enderror">
                                        <label for="name_input"> Retype Password <span class="text-danger"> * </span></label>

                                        <input type="password"
                                               name="password_confirmation"
                                               id="password_confirmation_input"
                                               value="{{ old('password_confirmation') }}"
                                               class="form-control" />

                                        @error('password_confirmation')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary btn-block">Save</button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
