@extends('admin.layout.master')
@section('title')
    Regions Districts
@endsection
@section('content')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Districts</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html"><i class="feather icon-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="#!">Districtss</a></li>
                        <li class="breadcrumb-item"><a href="#!">Dashboard</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5>Enter Districts.</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('store-districts') }}" method="POST" id="myForm">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="district_name" class="col-sm-3 col-form-label">Districts</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="district_name"
                                            placeholder="Districts">
                                        @error('district_name')
                                            <span class="btn btn-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="region_id" class="col-sm-3 col-form-label">Region</label>
                                    <div class="col-sm-9">
                                        <select name="region_id" class="form-control select2" required>
                                            <option selected="">Open this select menu</option>
                                            @foreach ($districts as $sub)
                                                <option value="{{ $sub->id }}">{{ $sub->region_name }}</option>
                                            @endforeach
                                            @error('region_id')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row" style="float: right;">
                            <div class="col-sm-10">
                                <button type="submit" class="btn  btn-primary">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
