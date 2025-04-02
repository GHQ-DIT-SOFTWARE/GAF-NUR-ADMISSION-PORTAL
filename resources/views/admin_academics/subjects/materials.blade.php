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
                                <h5 class="m-b-10">Subject Materials</h5>
                            </div>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="feather icon-home"></i></a></li>
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="#">Subject Materials</a></li>
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
                            <b>Add New Material
                                <button id="toggle-form" class="btn btn-primary" style="float:right;">Add</button>
                            </b>
                            <div class="form-container-row">
                                <form id="material-form" method="POST" enctype="multipart/form-data" style="display: none; margin-top: 10px;">
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
                                        
                                
                                        Video: <input class="form-control mb-2" type="file" name="subject_video" accept="video/*" required />
                                        PDF: <input class="form-control mb-2" type="file" name="subject_pdf" accept="application/pdf" required />
                                
                                        <textarea class="form-control mb-2" name="subject_remarks" placeholder="Enter Remarks"></textarea>
                                
                                        <button class="btn btn-primary" type="submit">Submit</button>
                                    </div>
                                </form>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script>
                $(document).ready(function() {
                    $("#toggle-form").click(function() {
                        $("#material-form").toggle(); // Show or hide the form instantly
                        $(this).text($("#material-form").is(":visible") ? "Close" : "Add"); // Change button text
                    });
                });
            </script>


            <div class="row justify-content-center">
                <div class="col-sm-12">
                    <div class="card user-profile-list">
                        <div class="card-body">
                            <div class="row align-items-center m-l-0">
                                <div class="dt-responsive table-responsive">
                                    <b>Materials (<span id="total-material">0</span>)</b>
                                    <table id="material-table" class="table table-striped table-bordered nowrap">
                                        <thead>
                                            <tr>
                                                <th>Course</th>
                                                <th>Category</th>
                                                <th>Subject</th>
                                                <th>Video</th>
                                                <th>Material(PDF)</th>
                                                <th>Remarks</th>
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

            <!-- Include jQuery, DataTables JS, and DataTables CSS -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

        <script>
            $(document).ready(function() {
                // Initialize the DataTable
                let table = $('#material-table').DataTable();

                fetchMaterial();

                $("#material-form").submit(function(e) {
                    e.preventDefault();
                    
                    let formData = new FormData(this); // Collect all form data, including files
                    
                    $.ajax({
                        url: "{{ route('admin.materials.store') }}",
                        method: "POST",
                        data: formData,
                        processData: false, // Important: prevent jQuery from processing data
                        contentType: false, // Important: prevent jQuery from setting content-type
                        success: function(response) {
                            alert("Material added successfully");
                            $("#material-form")[0].reset();
                            fetchMaterial();
                        },
                        error: function(xhr) {
                            console.log(xhr.responseText); // Show error for debugging
                        }
                    });
                });


                function fetchMaterial() {
                    $.get("{{ route('api.materials') }}", function(data) {
                        let tableBody = "";
                        $("#total-material").text(data.length);
                        data.forEach(material => {
                        tableBody += `<tr data-id="${material.id}">
                            <td>${material.courses ? material.courses.course_name : 'N/A'}</td>
                            <td>${material.category ? material.category.category_name : 'N/A'}<br>(Level ${material.category ? material.category.level : 'N/A'})</td>
                            <td>${material.subject ? material.subject.subject_name : 'N/A'}</td>
                            <td>
                                <video width="150" height="100" controls>
                                    <source src="{{ url('/') }}/${material.video_path}" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            </td>
                            <td><a href="{{ url('/') }}/${material.pdf_path}" target="_blank"><button class="btn btn-primary">View</button></a></td>
                            <td>${material.subject_remarks}</td>
                            <td>${new Date(material.created_at).toLocaleString()}</td>
                            <td><button class="btn btn-primary delete-btn" data-id="${material.id}"><i class="fas fa-trash"></i></button></td>
                        </tr>`;
                    });   

                        // Clear the table before appending new rows
                        table.clear().draw();
                        // Add rows to the DataTable
                        table.rows.add($(tableBody)).draw();
                    });
                }

                $(document).on("blur", "[contenteditable]", function() {
                    let materialId = $(this).closest("tr").data("id");
                    let column = $(this).data("column");
                    let value = $(this).text();
                
                    $.ajax({
                        url: `{{ url('api/admin/material/update') }}/${materialId}`,
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
                    let materialId = $(this).data("id");
                    if (confirm("Are you sure you want to delete this material?")) {
                        $.ajax({
                            url: `{{ url('admin/material/delete') }}/${materialId}`,
                            method: "DELETE",  // Changed from POST to DELETE
                            data: { _token: "{{ csrf_token() }}" },
                            success: function(response) {
                                alert("Material deleted successfully");
                                fetchMaterial();
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
