@extends('admin.layout.master')
@section('content')

<style>
    h3 {
        color: #023c13
        font-weight: bold;
    }
    h5 {
        color: #333;
        font-weight: bold;
    }
    h6 {
        font-style: italic;
        font-weight: bold;
    }
    .list-group-item {
        border: none;
        background: #f8f9fa;
        padding: 8px 15px;
    }
</style>
            <!-- [ breadcrumb ] start -->
            <div class="page-header">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h5 class="m-b-10">Course Packaging</h5>
                            </div>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="feather icon-home"></i></a></li>
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="#">Course Packaging</a></li>
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
                            <b>Add New Package
                                <button id="toggle-form" class="btn btn-primary" style="float:right;">Add</button>
                            </b>
                        <form id="allocation-form" action="#" style="display: none; margin-top: 10px;" method="POST" enctype="multipart/form-data">
                                @csrf
                            <div class="form-container-row">
                                <select class="form-control mb-2" name="course_id" required>
                                    <option value="">--Select Course/Program--</option>
                                    @foreach($courses as $course)
                                        <option value="{{ $course->id }}">{{ $course->cause_offers }}</option>
                                    @endforeach
                                </select>

                                <select class="form-control mb-2" name="level" required>
                                    <option value="">--Select Level--</option>
                                    <option value="100">100</option>
                                    <option value="200">200</option>
                                    <option value="300">300</option>
                                    <option value="400">400</option>
                                </select>

                                <select class="form-control mb-2" name="semester" required>
                                    <option value="">--Select Semester--</option>
                                    <option value="1st Semester">1st Semester</option>
                                    <option value="2nd Semester">2nd Semester</option>
                                </select>

                                <select class="form-control mb-2" name="category_id[]" multiple required>
                                    <option value="">--Select Course Category--</option>
                                    @foreach($category as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->category_name }} - Level {{ $cat->level }}</option>
                                    @endforeach
                                </select>

                                <textarea class="form-control mb-2" name="remarks" placeholder="Enter Remarks"></textarea>

                                 <button class="btn btn-primary" type="submit">Package</button>
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
                    <div class="container mt-4">
                        <h3>Course Packaging</h3>
                        <div id="package-list"></div>
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

                    fetchPackages();

                    $("#allocation-form").submit(function(e) {
                        e.preventDefault();

                        let formData = new FormData(this); // Collect all form data, including files

                        $.ajax({
                            url: "{{ route('admin.add.course.package') }}",
                            method: "POST",
                            data: formData,
                            processData: false, // Important: prevent jQuery from processing data
                            contentType: false, // Important: prevent jQuery from setting content-type
                            success: function(response) {
                                alert("Course packaged successfully");
                                $("#allocation-form")[0].reset();
                                fetchPackages();
                            },
                            error: function(xhr) {
                                console.log(xhr.responseText); // Show error for debugging
                            }
                        });
                    });


                    function fetchPackages() {
                        $.get("{{ route('api.packages') }}", function (data) {
                            let output = "";

                            $.each(data, function (index, courseData) {
                                output += `<h3 class="mt-3">${courseData.course.name}</h3>`;

                                $.each(courseData.levels, function (index, levelData) {
                                    output += `<h5 class="mt-2">Level: ${levelData.level}</h5>`;

                                    $.each(levelData.semesters, function (index, semesterData) {
                                        output += `<h6 class="mt-1 text-primary">${semesterData.semester}</h6>`;
                                        output += `<ul class="list-group mb-3">`;

                                        $.each(semesterData.subjects, function (index, subject) {
                                            output += `<li class="list-group-item">${subject.name}</li>`;
                                        });

                                        output += `</ul>`;
                                    });
                                });
                            });

                            $("#package-list").html(output);
                        });
                    }



                    $(document).on("blur", "[contenteditable]", function() {
                        let allocationId = $(this).closest("tr").data("id");
                        let column = $(this).data("column");
                        let value = $(this).text();

                        $.ajax({
                            url: `{{ url('api/admin/course-allocation/update') }}/${allocationId}`,
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
                        let allocationId = $(this).data("id"); // Get ID from the button
                        if (confirm("Are you sure you want to delete this package?")) {
                            $.ajax({
                                url: `{{ url('admin/course-packaging/delete') }}/${allocationId}`,
                                method: "POST",  // Laravel expects a POST with _method=DELETE
                                data: {
                                    _token: "{{ csrf_token() }}",
                                    _method: "DELETE"
                                },
                                success: function(response) {
                                    alert("Package deleted successfully");
                                    fetchPackages(); // Refresh table
                                },
                                error: function(xhr) {
                                    alert("Error deleting package: " + xhr.responseText);
                                }
                            });
                        }
                    });



                });
            </script>
        </div>
    </div>
@endsection
