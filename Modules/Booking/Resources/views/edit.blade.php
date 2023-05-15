@extends('admin.layout.base')

@section('title', "Edit a Booking ( $booking->name )")

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="basic-form">
                            <form class="form" method="POST" enctype="multipart/form-data" action="{{ route('admin.bookings.update', ['booking' => $booking->id]) }}">
                                @method('PUT')
                                @csrf

                                <div class="form-row " style="margin-bottom:  10px">

                                    <div class="form-group col-md-4  bmd-form-gtroup">
                                        <label for="attendance_date"> Order Number </label>
                                        <br>
                                        <input type="text" class="form-control"  value="{{$booking->order_reference}}" readonly>
                                    </div>

                                    <div class="form-group col-md-4  bmd-form-gtroup">

                                    <label for="attendance_date"> Client Name </label>
                                        <br>
                                        <input type="text" class="form-control"  value="{{$booking->name}}" readonly>
                                    </div>


                                    <div class="form-group col-md-4  bmd-form-gtroup">

                                    <label for="attendance_date"> Client Phone </label>
                                        <br>
                                        <input type="text" class="form-control"  value="{{$booking->phone}}" readonly>
                                    </div>
                                   @if($booking->type == 2)
                                    <div class="form-group col-md-4 bmd-form-gtroup">
                                        <label for="attendance_date"> Offer Name </label>
                                        <br>
                                        <input type="text" class="form-control"  value="{{ $booking->offer->name ?? '' }}" readonly>
                                    </div>

                                    <div class="form-group col-md-4 bmd-form-gtroup">
                                        <label for="attendance_date"> Offer Price </label>
                                        <br>
                                        <input type="text" class="form-control"  value="{{$booking->offer->price ?? ''}}" readonly>
                                    </div>
                                    @else
                                    <div class="form-group col-md-4 bmd-form-gtroup">
                                        <label for="attendance_date"> Doctor Name </label>
                                        <br>
                                        <input type="text" class="form-control"  value="{{ $booking->doctor->name ?? '' }}" readonly>
                                    </div>
                                    @endif

                                    <div class="form-group col-md-4 bmd-form-gtroup">
                                        <label for="attendance_date"> Branche </label>
                                        <br>
                                        <input type="text" class="form-control"  value="{{$booking->branch->name}}" readonly>
                                    </div>

                                    <div class="form-group col-md-4  bmd-form-gtroup">
                                        <label for="attendance_date"> Attendance Date  </label>
                                        <br>
                                        <input type="datetime" class="form-control"  value="{{$booking->attendance_date}}" readonly>
                                    </div>

                                    <div class="form-group col-md-4  bmd-form-gtroup">
                                        <label for="available_time"> Available Time  </label>
                                        <br>
                                        <input type="text" class="form-control" name="available_time" value="{{ $booking->available_time }}">
                                    </div>

                                    @if($booking->email)
                                    <div class="form-group col-md-4  bmd-form-gtroup">

                                    <label for="attendance_date"> Client Email </label>
                                        <br>
                                        <input type="text" class="form-control"  value="{{$booking->email ?? ''}}" readonly>
                                    </div>
                                    @endif

                                    <div class="form-group col-md-12  bmd-form-gtroup">
                                            <label for="status">Status</label>
                                            <select class="form-control" name="status">
                                                <option value="">-- Select --</option>
                                                <option value="1" {{ $booking->status == 1 ? 'selected' : '' }}>Pending</option>
                                                <option value="2"{{ $booking->status == 2 ? 'selected' : '' }}>Confirmed</option>
                                                <option value="3" {{ $booking->status == 3 ? 'selected' : '' }}>Not Answer</option>
                                                <option value="4" {{ $booking->status == 4 ? 'selected' : '' }}>Canceled</option>
                                                <option value="5" {{ $booking->status == 5 ? 'selected' : '' }}>Not Confirmed</option>
                                            </select>
                                    </div>

                                    <div class="form-group col-md-12">
                                        <label for="note"> Notes</label>
                                        <textarea type="text" class="form-control" name="note" rows="5">{{ $booking->note }}</textarea>
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
@endsection
