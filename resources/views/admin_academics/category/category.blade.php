@extends('admin.layout.master')
@section('content')
            <!-- [ breadcrumb ] start -->
            <div class="page-header">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h5 class="m-b-10">Course Subjects</h5>
                            </div>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="feather icon-home"></i></a></li>
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="#">Course Subjects</a></li>
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
                            <b>Add New Subject
                                <button id="toggle-form" class="btn btn-primary" style="float:right;">Add</button>
                            </b>
                                <form id="category-form" style="display: none; margin-top: 10px;" method="POST">
                                    @csrf
                                <input type="text" name="category_id" required class="form-control mb-2" placeholder="Enter Subject ID" />

                                <input type="text" name="category_name" required class="form-control mb-2" placeholder="Enter Subject Name" />

                                <input type="number" name="credit_hours" required class="form-control mb-2" placeholder="Enter Credit Hours" />

                                <select name="level" required class="form-control mb-2">
                                    <option value="">--Select Level--</option>
                                    <option value="100">100</option>
                                    <option value="200">200</option>
                                    <option value="300">300</option>
                                    <option value="400">400</option>
                                </select>

                                <textarea class="form-control mb-2" name="category_remarks" placeholder="Enter Remarks"></textarea>

                                <button class="btn btn-primary" style="submit">Submit</button>
                                </form>
                        </div>
                    </div>
                </div>
            </div>

            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script>
                $(document).ready(function() {
                    $("#toggle-form").click(function() {
                        $("#category-form").toggle(); // Show or hide the form instantly
                        $(this).text($("#category-form").is(":visible") ? "Close" : "Add"); // Change button text
                    });
                });
            </script>



            <div class="row justify-content-center">
                <div class="col-sm-12">
                    <div class="card user-profile-list">
                        <div class="card-body">
                            <div class="row align-items-center m-l-0">
                                <div class="dt-responsive table-responsive">
                                    <b>Subject (<span id="total-category">0</span>)</b>
                                    <table id="category-table" class="table table-striped table-bordered nowrap">
                                        <thead>
                                            <tr>
                                                <th>Subject ID</th>
                                                <th>Name</th>
                                                <th>Credit Hours</th>
                                                <th>Level</th>
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
                let table = $('#category-table').DataTable();

                fetchCategory();

                $("#category-form").submit(function(e) {
                    e.preventDefault();
                    $.ajax({
                        url: "{{ route('admin.category.add') }}",
                        method: "POST",
                        data: $(this).serialize(),
                        success: function(response) {
                            alert("Course subject added successfully");
                            $("#category-form")[0].reset();
                            fetchCategory();
                        }
                    });
                });

                function fetchCategory() {
                    $.get("{{ route('api.category') }}", function(data) {
                        let tableBody = "";
                        $("#total-category").text(data.length);
                        data.forEach(category => {
                            tableBody += `<tr data-id="${category.id}">
                                <td contenteditable="true" data-column="category_id">${category.category_id}</td>
                                <td contenteditable="true" data-column="category_name">${category.category_name}</td>
                                <td contenteditable="true" data-column="credit_hours">${category.credit_hours}</td>
                                <td contenteditable="true" data-column="level">${category.level}</td>
                                <td contenteditable="true" data-column="category_remarks">${category.category_remarks}</td>
                                <td>${new Date(category.created_at).toLocaleString()}</td>
                                <td><button class="btn btn-primary delete-btn" data-id="${category.id}"><i class="fas fa-trash"></i></button></td>
                            </tr>`;
                        });
                        // Clear the table before appending new rows
                        table.clear().draw();
                        // Add rows to the DataTable
                        table.rows.add($(tableBody)).draw();
                    });
                }

                $(document).on("blur", "[contenteditable]", function() {
                    let categoryId = $(this).closest("tr").data("id");
                    let column = $(this).data("column");
                    let value = $(this).text();

                    $.ajax({
                        url: `{{ url('api/admin/category/update') }}/${categoryId}`,
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
                    let categoryId = $(this).data("id");
                    if (confirm("Are you sure you want to delete this course subject?")) {
                        $.ajax({
                            url: `{{ url('admin/category/delete') }}/${categoryId}`,
                            method: "DELETE",  // Changed from POST to DELETE
                            data: { _token: "{{ csrf_token() }}" },
                            success: function(response) {
                                alert("Course subject deleted successfully");
                                fetchCategory();
                            }
                        });
                    }
                });

            });
        </script>
        </div>
    </div>
@endsection
