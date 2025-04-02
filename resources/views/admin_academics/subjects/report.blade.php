@extends('admin.layout.master')
@section('main')
    <div class="pcoded-main-container">
        <div class="pcoded-content">
            <!-- [ breadcrumb ] start -->
            <div class="page-header">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h5 class="m-b-10">Course Reports</h5>
                            </div>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="feather icon-home"></i></a></li>
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="#">Course Reports</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <style>
                .form-container-row {
                    display: flex;
                    align-items: center;
                    gap: 15px;
                    flex-wrap: wrap; /* Ensures responsiveness */
                    margin-top: 20px;
                }
                
                .form-input,
                .form-select,
                .form-textarea {
                    padding: 10px;
                    font-size: 16px;
                    border: 1px solid #ddd;
                    border-radius: 5px;
                    transition: all 0.3s ease;
                }
                
                .form-input {
                    flex: 1; /* Makes input fields flexible */
                    min-width: 150px; /* Ensures fields don’t get too small */
                }
                
                .form-textarea {
                    flex: 2; /* Allows the textarea to be larger */
                    resize: none;
                    height: 40px; /* Adjust for single-line appearance */
                }
                
                .form-button {
                    padding: 10px 20px;
                    font-size: 16px;
                    font-weight: bold;
                    color: #fff;
                    background-color: #023c13;
                    border: none;
                    border-radius: 5px;
                    cursor: pointer;
                    transition: background-color 0.3s ease;
                }
                
                .form-button:hover {
                    background-color: #0056b3;
                }
                
                .form-button:active {
                    background-color: #004085;
                }


            </style>


            <div class="row justify-content-center">
                <div class="col-sm-12">
                    <div class="card user-profile-list">
                        <div class="card-body">
                            <b>Filter Course(s)</b>
                            <div class="form-container-row">
                                <select class="form-input">
                                    <option>--Select Category--</option>
                                </select>
                                <select class="form-input">
                                    <option>--Select Course--</option>
                                </select>

                                Start Date
                                <input class="form-input" type="date" placeholder="Start Date" />
                                
                                End Date
                                <input class="form-input" type="date" placeholder="End Date" />
            
                                <button class="form-button">Filter</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            
        </div>
    </div>
@endsection
