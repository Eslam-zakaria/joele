@extends('admin.layout.base')

@section('title', "Edit a Review ( $review->name )")

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="basic-form">
                            <div class="form-row " style="margin-bottom:  10px">
                                <div class="form-group col-md-4 bmd-form-gtroup">
                                    <label for="attendance_date"> Name </label>
                                    <br>
                                    <input type="text" class="form-control"  value="{{ $review->name ?? ''}}" readonly>
                                </div>

                                <div class="form-group col-md-4 bmd-form-gtroup">
                                    <label for="attendance_date"> Phone </label>
                                    <br>
                                    <input type="text" class="form-control"  value="{{ $review->phone ?? ''}}" readonly>
                                </div>

                                <div class="form-group col-md-4 bmd-form-gtroup">
                                    <label for="attendance_date"> Date </label>
                                    <br>
                                    <input type="text" class="form-control"  value="{{ $review->created_at ?? ''}}" readonly>
                                </div>

                                <div class="form-group col-md-6  bmd-form-gtroup">
                                    <label for="attendance_date"> Branch </label>
                                    <br>
                                    <input type="text" class="form-control"  value="{{ $review->branch->name ?? ''}}" readonly>
                                </div>

                                <div class="form-group col-md-6 bmd-form-gtroup">
                                    <label for="attendance_date"> Doctor </label>
                                    <br>
                                    <input type="text" class="form-control"  value="{{ $review->doctor->name ?? ''}}" readonly>
                                </div>

                                <hr>

                                <div class="form-group col-md-12  bmd-form-gtroup">
                                    <label for="attendance_date"> Message </label>
                                    <br>
                                    <textarea cols="30" rows="10" class="form-control" readonly>{{ $review->message ?? ''}}</textarea>
                                </div>

                                <hr>

                                @foreach($review->review_answer as $review_answer)
                                    <div class="form-group col-md-6 bmd-form-gtroup">
                                        <label for="attendance_date"> {{ $review_answer->question->translate(app()->getLocale())->question ?? '' }}</label>
                                        <br>
                                        <input type="text" class="form-control"  value="{{ $status[$review_answer->answer] ?? ''}}" readonly>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
