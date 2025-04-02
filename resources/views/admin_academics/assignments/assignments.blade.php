@extends('admin.layout.master')
@section('content')
            <!-- [ breadcrumb ] start -->
            <div class="page-header">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h5 class="m-b-10">Assignments</h5>
                            </div>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="feather icon-home"></i></a></li>
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="#">Assignments</a></li>
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
                            <b>Add New Assignment
                                <button id="toggle-form" class="btn btn-primary" style="float:right;">Add</button>
                            </b>
                        <form id="assignment-form" action="{{ route('admin.assignment.store') }}" style="display: none; margin-top: 10px;" method="POST" enctype="multipart/form-data">
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

                                <input class="form-control mb-2" name="assignment_id" required placeholder="Enter Assig. ID" />

                                <input class="form-control mb-2" name="assignment_name" required placeholder="Assignment Name" />

                                PDF: <input class="form-control mb-2" type="file" name="assignment_pdf" accept="application/pdf" required />

                                <textarea class="form-control mb-2" name="assignment_remarks" placeholder="Enter Remarks"></textarea>

                                <button class="btn btn-primary" type="submit">Submit</button>
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
                        $("#assignment-form").toggle(); // Show or hide the form instantly
                        $(this).text($("#assignment-form").is(":visible") ? "Close" : "Add"); // Change button text
                    });
                });
            </script>


            <div class="row justify-content-center">
                <div class="col-sm-12">
                    <div class="card user-profile-list">
                        <div class="card-body">
                            <div class="row align-items-center m-l-0">
                                <div class="dt-responsive table-responsive">
                                    <b>Assignments (<span id="total-assignment">0</span>)</b>
                                    <table id="assignment-table" class="table table-striped table-bordered nowrap">
                                        <thead>
                                            <tr>
                                                <th>Course</th>
                                                <th>Category</th>
                                                <th>Subject</th>
                                                <th>Assignment ID</th>
                                                <th>Assignment Name</th>
                                                <th>File</th>
                                                <th>Remarks</th>
                                                <th>Created On</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                    </table>
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
                let table = $('#assignment-table').DataTable();

                fetchAssignment();

                $("#assignment-form").submit(function(e) {
                    e.preventDefault();

                    let formData = new FormData(this); // Collect all form data, including files

                    $.ajax({
                        url: "{{ route('admin.assignment.store') }}",
                        method: "POST",
                        data: formData,
                        processData: false, // Important: prevent jQuery from processing data
                        contentType: false, // Important: prevent jQuery from setting content-type
                        success: function(response) {
                            alert("Assignment added successfully");
                            $("#assignment-form")[0].reset();
                            fetchAssignment();
                        },
                        error: function(xhr) {
                            console.log(xhr.responseText); // Show error for debugging
                        }
                    });
                });

                function fetchAssignment() {
                    $.get("{{ route('api.assignments') }}", function(data) {
                        let tableBody = "";
                        $("#total-assignment").text(data.length);
                        data.forEach(assignment => {
                        tableBody += `<tr data-id="${assignment.id}">
                            <td>${assignment.courses ? assignment.courses.course_name : 'N/A'}</td>
                            <td>${assignment.category ? assignment.category.category_name : 'N/A'}</td>
                            <td>${assignment.subject ? assignment.subject.subject_name : 'N/A'}</td>
                            <td>${assignment.assignment_id}</td>
                            <td>${assignment.assignment_name}</td>
                            <td><a href="{{ url('/') }}/${assignment.assignment_pdf}" target="_blank"><button class="btn btn-primary">View</button></a></td>
                            <td>${assignment.assignment_remarks}</td>
                            <td>${new Date(assignment.created_at).toLocaleString()}</td>
                            <td><button class="btn btn-primary delete-btn" data-id="${assignment.id}"><i class="fas fa-trash"></i></button></td>
                        </tr>`;
                    });

                        // Clear the table before appending new rows
                        table.clear().draw();
                        // Add rows to the DataTable
                        table.rows.add($(tableBody)).draw();
                    });
                }

                $(document).on("blur", "[contenteditable]", function() {
                    let assignmentId = $(this).closest("tr").data("id");
                    let column = $(this).data("column");
                    let value = $(this).text();

                    $.ajax({
                        url: `{{ url('api/admin/assignment/update') }}/${assignmentId}`,
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
                    let assignmentId = $(this).data("id");
                    if (confirm("Are you sure you want to delete this assignment?")) {
                        $.ajax({
                            url: `{{ url('admin/assignment/delete') }}/${assignmentId}`,
                            method: "DELETE",  // Changed from POST to DELETE
                            data: { _token: "{{ csrf_token() }}" },
                            success: function(response) {
                                alert("Assignment deleted successfully");
                                fetchAssignment();
                            }
                        });
                    }
                });

            });
        </script>

        <script>
            $(document).ready(function() {
                $("#categorySelect").change(function() {
                    let categoryId = $(this).val();
                    if (categoryId) {
                        $.ajax({
                            url: "/api/get-subjects",
                            method: "GET",
                            data: { category_id: categoryId },
                            success: function(response) {
                                let subjectSelect = $("#subjectSelect");
                                subjectSelect.empty(); // Clear existing options
                                subjectSelect.append('<option value="">--Select Subject--</option>');

                                if (response.length > 0) {
                                    $.each(response, function(index, subject) {
                                        subjectSelect.append('<option value="' + subject.id + '">' + subject.subject_name + '</option>');
                                    });
                                } else {
                                    subjectSelect.append('<option value="">No subjects found</option>');
                                }
                            },
                            error: function(xhr) {
                                console.error("Error fetching subjects:", xhr.responseText);
                            }
                        });
                    } else {
                        $("#subjectSelect").empty().append('<option value="">--Select Subject--</option>');
                    }
                });
            });

        </script>
        </div>
    </div>
@endsection
