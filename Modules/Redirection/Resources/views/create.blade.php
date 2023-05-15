@extends('admin.layout.base')

@section('title', 'Create a new redirection')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="basic-form">
                            <form class="form" method="POST" action="{{ route('admin.redirections.store') }}" enctype="multipart/form-data">
                                @method('POST')
                                @csrf

                                <div class="row">
                                    <div class="form-group col-md-4 @error("from") has-danger @enderror">
                                        <label for="from_input"> From <span class="text-danger">*</span></label>

                                        <input type="text"
                                               id="from_input"
                                               name="from"
                                               placeholder="Enter from url"
                                               value="{{ old("from") }}"
                                               class="form-control" />

                                        @error("from")
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-4 @error("to") has-danger @enderror">
                                        <label for="to_input"> To <span class="text-danger">*</span></label>

                                        <input type="text"
                                               id="to_input"
                                               name="to"
                                               placeholder="Enter to url"
                                               value="{{ old("to") }}"
                                               class="form-control" />

                                        @error("to")
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-4 @error("code") has-danger @enderror">
                                        <label for="code_input"> Code <span class="text-danger">*</span></label>

                                        <select name="code" class="form-control" id="code_select">
                                            <option value="">--select--</option>
                                            <option value="301" {{ old('code') == '301' ? 'selected' : '' }}>301 ( Moved Permanently )</option>
                                            <option value="302" {{ old('code') == '302' ? 'selected' : '' }}>302 ( Found )</option>
                                            <option value="303" {{ old('code') == '303' ? 'selected' : '' }}>303 ( See other )</option>
                                            <option value="304" {{ old('code') == '304' ? 'selected' : '' }}>304 ( Not modified )</option>
                                            <option value="307" {{ old('code') == '307' ? 'selected' : '' }}>307 ( Temporary Redirect )</option>
                                            <option value="308" {{ old('code') == '308' ? 'selected' : '' }}>308 ( Permanent Redirect )</option>
                                        </select>

                                        @error("code")
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
