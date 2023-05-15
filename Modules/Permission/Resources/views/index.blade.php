@extends('admin.layout.base')

@section('title', 'Permissions')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="basic-form">
                            <form class="form" method="POST" enctype="multipart/form-data" action="{{ route('admin.permissions.update', $user->id) }}">
                                @method('PUT')
                                @csrf

                                <div class="row p-t-20">
                                    @foreach($permissions as $key => $permisionRow)
                                    <div class="col-md-3">
                                        <div class="trigger">
                                            <div class="card-header">
                                                <label for="main_{{ $key }}"> {{ ucfirst($key) }} </label>
                                                <label class="label-switch switch-success float-left m-0">

                                                    <input
                                                        type="checkbox"
                                                        id="main_{{ $key }}"
                                                        class="switch switch-bootstrap status main_permission_switch"
                                                        data-key="{{ $key }}"
                                                    />

                                                    <span class="lable"></span>
                                                </label>
                                            </div>
                                            <div class="card-body">
                                                @foreach ($permisionRow as $permission)
                                                    <div class="form-group row">
                                                        <label class="label-switch switch-success">
                                                            <input
                                                                type="checkbox"
                                                                class="switch switch-bootstrap status child_permission_switch"
                                                                name="permissions[]"
                                                                value="{{ $permission->id }}"
                                                                {{ in_array($permission->id, $user_permissions) ? 'checked' : '' }}
                                                            />

                                                            <span class="lable"></span> {{ $permission->display_name }}</label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
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

@push('js')
    <script>
        // when check main permission checked make check for all child.
        $(Document).on('change', '.main_permission_switch', function (){
            if($(this).prop("checked") == true){
                $(this).parents().eq(2).find('.child_permission_switch').prop("checked", true);
            }else {
                $(this).parents().eq(2).find('.child_permission_switch').prop("checked", false);
            }
        });

        $(document).on('change', '.child_permission_switch', function (){
            if(!$(this).parents().eq(2).find('.child_permission_switch').is(':not(:checked)')){
                $(this).parents().eq(3).find('.main_permission_switch').prop("checked", true);
            }else{
                $(this).parents().eq(3).find('.main_permission_switch').prop("checked", false);
            }
        });

        $(document).ready(function (){
            $('.main_permission_switch').each( function() {
                if(!$(this).parents().eq(2).find('.child_permission_switch').is(':not(:checked)')){
                    $(this).prop("checked", true);
                }
            });
        });
    </script>
@endpush
