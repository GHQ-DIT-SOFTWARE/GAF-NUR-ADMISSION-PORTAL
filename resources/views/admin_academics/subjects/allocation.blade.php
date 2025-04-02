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
                                <h5 class="m-b-10">Subject Allocation</h5>
                            </div>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="feather icon-home"></i></a></li>
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="#">Subject Allocation</a></li>
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
                            <b>Allocate Subject
                                <button id="toggle-form" class="btn btn-primary" style="float:right;">Add</button>
                            </b>
                            <form id="allocation-form" style="display: none; margin-top: 10px;" action="{{ route('admin.allocation.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                            <div class="form-container-row">
                                <select class="form-control mb-2" name="course_id" required>
                                    <option value="">--Select Course--</option>
                                    @foreach($courses as $course)
                                        <option value="{{ $course->id }}">{{ $course->course_name }}</option>
                                    @endforeach
                                </select>

                                <select class="form-control mb-2" name="category_id" required>
                                    <option value="">--Select Category--</option>
                                    @foreach($category as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->category_name }} - Level {{ $cat->level }}</option>
                                    @endforeach
                                </select>
                                
                                <select class="form-control mb-2" name="subject_id" required>
                                    <option value="">--Select Subject--</option>
                                    @foreach($subjects as $subject)
                                        <option value="{{ $subject->id }}">{{ $subject->subject_name }}</option>
                                    @endforeach
                                </select>

                                <select class="form-control mb-2" name="course_id" required>
                                    <option>--Course/Program--</option>
                                    @foreach($courses as $course)
                                        <option value="{{ $course->id }}">{{ $course->course_id }}</option>
                                    @endforeach
                                </select>
            
                                <textarea class="form-control mb-2" name="allocation_remarks" placeholder="Enter Remarks"></textarea>
            
                                <button class="form-button" type="submit">Allocate</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script>
                $(document).ready(function() {
                    $("#toggle-form").click(function() {
                        $("#allocation-form").toggle(); // Show or hide the form instantly
                        $(this).text($("#allocation-form").is(":visible") ? "Close" : "Add"); // Change button text
                    });
                });
            </script>

            



            <div class="row justify-content-center">
                <div class="col-sm-12">
                    <div class="card user-profile-list">
                        <div class="card-body">
                            <div class="row align-items-center m-l-0">
                                <div class="dt-responsive table-responsive">
                                    <b>Subject Allocations (<span id="total-allocation">0</span>)</b>
                                    <table id="allocation-table" class="table table-striped table-bordered nowrap">
                                        <thead>
                                            <tr>
                                                <th>Category</th>
                                                <th>Subject</th>
                                                <th>Course/Program</th>
                                                <th>Remarks</th>
                                                <th>Allocated On</th>
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

            <!-- Include jQuery, DataTables JS, and DataTables CSS -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

        <script>
            $(document).ready(function() {
                // Initialize the DataTable
                let table = $('#allocation-table').DataTable();

                fetchAllocation();

                $("#allocation-form").submit(function(e) {
                    e.preventDefault();
                    $.ajax({
                        url: "{{ route('admin.allocation.store') }}",
                        method: "POST",
                        data: $(this).serialize(),
                        success: function(response) {
                            alert("Subject allocated successfully");
                            $("#allocation-form")[0].reset();
                            fetchAllocation();
                        }
                    });
                });

                function fetchAllocation() {
                    $.get("{{ route('api.allocations') }}", function(data) {
                        let tableBody = "";
                        $("#total-allocation").text(data.length);
                        data.forEach(allocation => {
                            tableBody += `<tr data-id="${allocation.id}">
                                <td contenteditable="true" data-column="category_id">${allocation.category ? allocation.category.category_name : 'N/A'}</td>
                                <td contenteditable="true" data-column="subject_id">${allocation.subject ? allocation.subject.subject_name : 'N/A'}</td>
                                <td contenteditable="true" data-column="course_id">${allocation.subject ? allocation.course.course_id : 'N/A'}</td>
                                <td contenteditable="true" data-column="allocation_remarks">${allocation.allocation_remarks}</td>
                                <td>${new Date(allocation.created_at).toLocaleString()}</td>
                                <td><button class="btn btn-danger delete-btn" data-id="${allocation.id}">Delete</button></td>
                            </tr>`;
                        });
                        // Clear the table before appending new rows
                        table.clear().draw();
                        // Add rows to the DataTable
                        table.rows.add($(tableBody)).draw();
                    });
                }

                $(document).on("blur", "[contenteditable]", function() {
                    let allocationId = $(this).closest("tr").data("id");
                    let column = $(this).data("column");
                    let value = $(this).text();
                
                    $.ajax({
                        url: `{{ url('api/admin/allocation/update') }}/${allocationId}`,
                        method: "POST",
                        contentType: "application/json",
                        dataType: "json",
                        data: JSON.stringify({
                            _token: "{{ csrf_token() }}",
                            [column]: value
                        }),
                        success: function(response) {
                            console.log("Updated successfully", response);
                        },
                        error: function(xhr) {
                            console.log("Update failed", xhr.responseText);
                        }
                    });
                });

                $(document).on("click", ".delete-btn", function() {
                    let courseId = $(this).data("id");
                    if (confirm("Are you sure you want to delete this allocation?")) {
                        $.ajax({
                            url: `{{ url('admin/allocation/delete') }}/${allocationId}`,
                            method: "DELETE",  // Changed from POST to DELETE
                            data: { _token: "{{ csrf_token() }}" },
                            success: function(response) {
                                alert("Allocation deleted successfully");
                                fetchAllocation();
                            }
                        });
                    }
                });

            });
        </script>
        </div>
    </div>
@endsection
