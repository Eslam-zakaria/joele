@extends('admin.layout.base')

@section('title', 'Doctor Schedule')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="basic-form">
                            <form class="form" method="POST" action="{{ route('admin.doctor.working-days.store', $doctor->id) }}">
                                @method('POST')
                                @csrf

                                @foreach($doctor->branches as $branch)

                                    @php($branchOldData = $oldWorkingDaysArray[$branch->id] ?? [])

                                    <div class="mt-5">
                                        <h2>{{ $branch->translate(app()->getLocale())->name }}</h2>

                                        <hr>

                                        <div class="row">
                                            @foreach($monthsArray as $key => $monthArray)
                                                <div class="col-md-6">

                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <h4 class="mb-3">{{ $key }}</h4>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <input class="form-check-input main_permission_switch"
                                                                   type="checkbox"
                                                                   id="select_all_{{ $key . '_' . $branch->id }}" />

                                                            <label class="form-check-label text-center" for="select_all_{{ $key . '_' . $branch->id }}">Select all</label>
                                                        </div>
                                                    </div>

                                                    <hr>

                                                    <div class="row">
                                                        @foreach($monthArray['calendar'] as $monthArrayKey => $calendarData)
                                                            <div class="form-group col-md-3 @error('image') has-danger @enderror">
                                                                <div class="form-check">

                                                                    <input class="form-check-input {{ $calendarData['day_name'] != 'friday' ? 'child_permission_switch' : '' }}"
                                                                           type="checkbox"
                                                                           name="appointment[{{ $branch->id }}][{{ $monthArray['month'] }}][]"
                                                                           value="{{ $calendarData['date'] }}"
                                                                           id="appointment_{{ $branch->id }}_{{ $key }}_{{ $calendarData['day_number'] }}"
                                                                        {{ ( isset($branchOldData[$monthArray['month']]) && in_array($calendarData['date'], $branchOldData[$monthArray['month']]) ) ? 'checked' : '' }} />

                                                                    <label class="form-check-label text-center" for="appointment_{{ $branch->id }}_{{ $key }}_{{ $calendarData['day_number'] }}">
                                                                        <span class="d-block">{{ $calendarData['day_name'] }}</span>
                                                                        <span>{{ $calendarData['date'] }}</span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach

                                <button type="submit" class="btn btn-primary pull-right mt-3">Save</button>
                                <a href="{{ route('admin.doctors.index') }}" class="btn btn-danger mt-3">Back</a>
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
