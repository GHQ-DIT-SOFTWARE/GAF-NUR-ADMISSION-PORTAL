@extends('admin.layout.master')
@section('title')
    Scan
@endsection
@section('content')
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Decrypt Applicant Details</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html"><i class="feather icon-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="#!">Decrypt</a></li>

                    </ul>
                </div>
            </div>
        </div>
    </div>
    {{-- <h1>Decrypt QR Code Data</h1>
    <form action="{{ route('decrypt-qr-code') }}" method="POST">
        @csrf
        <label for="encryptedData">Enter Encrypted Data:</label>
        <textarea name="data" id="encryptedData" rows="4" required></textarea>
        <label for="password">Enter Password:</label>
        <input type="password" name="password" id="password" required>
        <button type="submit">Decrypt</button>
    </form> --}}

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h1>Decrypt QR Code Data</h1>
                </div>
                <div class="card-body">
                    <form action="{{ route('decrypt-qr-code') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="encryptedData" class="form-label">Enter Encrypted Data:</label>
                                    <textarea name="data" class="form-control" id="encryptedData" rows="4" required></textarea>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="password" class="form-label">Enter Password:</label>
                                    <input type="password" class="form-control" name="password" id="password" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-primary">Decrypt</button>
                                {{-- <button type="submit" class="btn btn-primary">Save</button> --}}
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection
