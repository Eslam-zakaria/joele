@extends('admin.layout.base')

@section('title', "Show ( $contact_u->name )")

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="basic-form">
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="attendance_date"> Name </label>

                                    <input type="text"
                                           class="form-control"
                                           value="{{ $contact_u->name }}" readonly />
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="attendance_date"> Phone </label>

                                    <input type="text"
                                           class="form-control"
                                           value="{{ $contact_u->phone }}" readonly />
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="attendance_date"> Subject </label>

                                    <input type="text"
                                           class="form-control"
                                           value="{{ $contact_u->topic }}" readonly />
                                </div>

                                <div class="form-group col-md-12">
                                    <label for="attendance_date"> Message </label>

                                    <textarea type="text"
                                              rows="7"
                                              class="form-control" readonly>{{ $contact_u->message }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="basic-form">
                            <form class="form" method="post" action="{{ route('admin.contact-us.update', $contact_u->id) }}">
                                @method('PUT')
                                @csrf

                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label for="attendance_date"> Notes </label>

                                        <textarea type="text"
                                                  rows="7"
                                                  name="notes"
                                                  class="form-control">{{ $contact_u->notes }}</textarea>

                                        @error('notes')
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
