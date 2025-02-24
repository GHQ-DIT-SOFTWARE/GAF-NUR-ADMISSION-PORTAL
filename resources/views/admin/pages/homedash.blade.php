@extends('admin.layout.master')
@section('title')
     Dashboard
@endsection
@section('content')
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Dashboard</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html"><i class="feather icon-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="#!">Main</a></li>
                        <li class="breadcrumb-item"><a href="#!">Dashboard</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-12">
        <div class="card" style="background-color:rgb(250, 253, 251);">
            <h1 class="font-weight-normal" style="text-align: center; color:rgb(19, 20, 20);"><b
                    class="font-weight-bolder">WELCOME TO 37 MILITARY HOSPITAL NMTC ADMIN PORTAL</b></h1>
            <div style="display: flex; justify-content: center; align-items: center; height: 100vh;">
                <img src="{{ asset('37 school.png') }}" style="height: 700px; width: 700px;" alt="" class="img-fluid">
            </div>


        </div>
    </div>
@endsection
