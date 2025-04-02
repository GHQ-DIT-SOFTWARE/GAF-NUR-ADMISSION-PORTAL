@extends('admin.layout.master')
@section('content')


<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5 class="m-b-10">Courses</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="feather icon-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="#">Courses</a></li>
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
        flex: 3; /* Allows the textarea to be larger */
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
        background-color: #023c13;
    }

    .form-button:active {
        background-color: #023c13;
    }


</style>
<div class="row justify-content-center">
<div class="col-sm-12">
<div class="card user-profile-list">
    <div class="card-body">
        <b>Add Course
            <button id="toggle-form" class="btn btn-primary" style="float:right;">Add</button>
        </b>

        <form id="course-form" method="POST" style="display: none; margin-top: 10px;">
            @csrf
            <input type="text" name="course_id" required class="form-control mb-2" placeholder="Enter Course ID" />
            <input type="text" name="course_name" class="form-control mb-2" placeholder="Enter Course Name" />
            <textarea name="remarks" class="form-control mb-2" placeholder="Enter Remarks"></textarea>
            <button class="btn btn-primary" type="submit">Submit</button>
        </form>
    </div>
</div>
</div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
$("#toggle-form").click(function() {
    $("#course-form").toggle(); // Show or hide the form instantly
    $(this).text($("#course-form").is(":visible") ? "Close" : "Add"); // Change button text
});
});
</script>

<div class="row justify-content-center">
    <div class="col-sm-12">
        <div class="card user-profile-list">
            <div class="card-body">
                <b>Courses (<span id="total-courses">0</span>)</b>
                <table id="courses-table" class="table table-striped">
                    <thead>
                        <tr>
                            <th>Course ID</th>
                            <th>Course Name</th>
                            <th>Remarks</th>
                            <th>Created On</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
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
        let table = $('#courses-table').DataTable();

        fetchCourses();

        $("#course-form").submit(function(e) {
            e.preventDefault();
            $.ajax({
                url: "{{ route('admin.course.add') }}",
                method: "POST",
                data: $(this).serialize(),
                success: function(response) {
                    alert("Course added successfully");
                    $("#course-form")[0].reset();
                    fetchCourses();
                }
            });
        });

        function fetchCourses() {
            $.get("{{ route('api.courses') }}", function(data) {
                let tableBody = "";
                $("#total-courses").text(data.length);
                data.forEach(course => {
                    tableBody += `<tr data-id="${course.id}">
                        <td contenteditable="true" data-column="course_id">${course.course_id}</td>
                        <td contenteditable="true" data-column="location">${course.course_name}</td>
                        <td contenteditable="true" data-column="remarks">${course.remarks}</td>
                        <td>${new Date(course.created_at).toLocaleString()}</td>
                        <td><button class="btn btn-primary delete-btn" data-id="${course.id}"><i class="fas fa-trash"></i></button></td>
                    </tr>`;
                });
                // Clear the table before appending new rows
                table.clear().draw();
                // Add rows to the DataTable
                table.rows.add($(tableBody)).draw();
            });
        }

        $(document).on("blur", "[contenteditable]", function() {
            let courseId = $(this).closest("tr").data("id");
            let column = $(this).data("column");
            let value = $(this).text();

            $.ajax({
                url: `{{ url('api/admin/course/update') }}/${courseId}`,
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
            if (confirm("Are you sure you want to delete this course?")) {
                $.ajax({
                    url: `{{ url('admin/course/delete') }}/${courseId}`,
                    method: "DELETE",  // Changed from POST to DELETE
                    data: { _token: "{{ csrf_token() }}" },
                    success: function(response) {
                        alert("Course deleted successfully");
                        fetchCourses();
                    }
                });
            }
        });

    });
</script>
@endsection
