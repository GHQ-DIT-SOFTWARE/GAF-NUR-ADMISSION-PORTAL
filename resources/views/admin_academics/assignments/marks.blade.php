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
                                <h5 class="m-b-10">Assignment Marks</h5>
                            </div>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="feather icon-home"></i></a></li>
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="#">Assignment Marks</a></li>
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
                            <b>Add New Assignment Marks</b>
                            <div class="form-container-row">
                                <select class="form-input">
                                    <option>--Select Category--</option>
                                </select>

                                <select class="form-input">
                                    <option>--Select Course--</option>
                                </select>

                                <select class="form-input">
                                    <option>--Select Student--</option>
                                </select>

                                <input 
                                    class="form-input" 
                                    list="assignment-options" 
                                    placeholder="Assignment Name" 
                                />
                                <datalist id="assignment-options">
                                    <option value="Select Assignments"></option>
                                </datalist>
                                
                                <input class="form-input" placeholder="Enter Assig. Marks" />
            
                                <textarea class="form-textarea" placeholder="Enter Remarks"></textarea>
            
                                <button class="form-button">Add</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row justify-content-center">
                <div class="col-sm-12">
                    <div class="card user-profile-list">
                        <div class="card-body">
                            <div class="row align-items-center m-l-0">
                                <div class="dt-responsive table-responsive">
                                    <b>Assignment Marks (0)</b>
                                    <table class="table table-striped table-bordered nowrap">
                                        <thead>
                                            <tr>
                                                <th>Course</th>
                                                <th>Student</th>
                                                <th>Assignment</th>
                                                <th>Marks</th>
                                                <th>Added On</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <script src="https://code.jquery.com/jquery-3.6.0.min.js"
                integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
            <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
            <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
            <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
            <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
            <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
            <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
            <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.colVis.min.js"></script>

            <script>
                $(document).ready(function() {
                    $('#personnels').DataTable({
                        dom: "<'row'<'col-sm-2'l><'col'B><'col-sm-2'f>>" +
                            "<'row'<'col-sm-12'tr>>" +
                            "<'row'<'col-sm-6'i><'col-sm-6'p>>",
                        buttons: [
                            'colvis',
                            {
                                extend: 'copy',
                                text: 'Copy to clipboard'
                            },
                            'excel',
                        ],
                        scrollY: 960,
                        scrollCollapse: true,
                        processing: true,
                        serverSide: true,
                        lengthMenu: [
                            [15, 25, 50, 100, 200, -1],
                            [15, 25, 50, 100, 200, 'All'],
                        ],
                        ajax: {
                            url: "#",
                            type: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: function(d) {
                                var formData = $('#filter-form').serializeArray();
                                $.each(formData, function(index, item) {
                                    d[item.name] = item.value;
                                });
                            },
                        },
                        columns: [{
                                data: null,
                                orderable: false,
                                searchable: false,
                                render: function(data, type, full, meta) {
                                    return meta.row + 1;
                                }
                            },
                            {
                                data: 'service_no',
                                name: 'service_no'
                            },
                            {
                                data: 'rank',
                                name: 'rank'
                            },
                            {
                                data: 'initials',
                                name: 'initials'
                            },
                            {
                                data: 'sex',
                                name: 'sex'
                            },
                            {
                                data: 'unit',
                                name: 'unit'
                            },
                            {
                                data: 'level',
                                name: 'level'
                            },
                            {
                                data: 'arm_of_service',
                                name: 'arm_of_service'
                            },
                            {
                                data: 'action',
                                name: 'action',
                                orderable: false,
                                searchable: false
                            }
                        ],
                    });
                });
            </script>
        </div>
    </div>
@endsection
