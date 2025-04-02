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
                                <h5 class="m-b-10">Subjects</h5>
                            </div>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="feather icon-home"></i></a></li>
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="#">Subjects</a></li>
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
                            <b>Add Subject
                                <button id="toggle-form" class="btn btn-primary" style="float:right;">Add</button>
                            </b>
                            <form id="subject-form" method="POST" style="display: none; margin-top: 10px;">
                                @csrf
                            <div class="form-container-row">
                                <input class="form-control mb-2" name="subject_id" required placeholder="Enter Subject ID" />
                                
                                <input class="form-control mb-2" name="subject_name" required placeholder="Enter Subject Name" />
            
                                <textarea class="form-control mb-2" name="subject_remarks" placeholder="Enter Remarks"></textarea>
            
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
                        $("#subject-form").toggle(); // Show or hide the form instantly
                        $(this).text($("#subject-form").is(":visible") ? "Close" : "Add"); // Change button text
                    });
                });
            </script>



            <div class="row justify-content-center">
                <div class="col-sm-12">
                    <div class="card user-profile-list">
                        <div class="card-body">
                            <div class="row align-items-center m-l-0">
                                <div class="dt-responsive table-responsive">
                                    <b>Subjects (<span id="total-subject">0</span>)</b>
                                    <table id="subject-table" class="table table-striped table-bordered nowrap">
                                        <thead>
                                            <tr>
                                                <th>Subject ID</th>
                                                <th>Subject Name</th>
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
                </div>
            </div>

            <!-- Include jQuery, DataTables JS, and DataTables CSS -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

        <script>
            $(document).ready(function() {
                // Initialize the DataTable
                let table = $('#subject-table').DataTable();

                fetchSubject();

                $("#subject-form").submit(function(e) {
                    e.preventDefault();
                    $.ajax({
                        url: "{{ route('admin.subject.add') }}",
                        method: "POST",
                        data: $(this).serialize(),
                        success: function(response) {
                            alert("Subject added successfully");
                            $("#subject-form")[0].reset();
                            fetchSubject();
                        }
                    });
                });

                function fetchSubject() {
                    $.get("{{ route('api.subjects') }}", function(data) {
                        console.log("Subjects received:", data); // Debugging line
                
                        let tableBody = "";
                        $("#total-subject").text(data.length);
                        data.forEach(subject => {
                            tableBody += `<tr data-id="${subject.id}">
                                <td contenteditable="true" data-column="subject_id">${subject.subject_id}</td>
                                <td contenteditable="true" data-column="subject_name">${subject.subject_name}</td>
                                <td contenteditable="true" data-column="subject_remarks">${subject.subject_remarks}</td>
                                <td>${new Date(subject.created_at).toLocaleString()}</td>
                                <td><button class="btn btn-primary delete-btn" data-id="${subject.id}"><i class="fas fa-trash"></i></button></td>
                            </tr>`;
                        });
                
                        // Clear the table before appending new rows
                        table.clear().draw();
                        // Add rows to the DataTable
                        table.rows.add($(tableBody)).draw();
                    }).fail(function(xhr) {
                        console.error("Error fetching subjects:", xhr.responseText);
                    });
                }


                $(document).on("blur", "[contenteditable]", function() {
                    let subjectId = $(this).closest("tr").data("id");
                    let column = $(this).data("column");
                    let value = $(this).text();
                
                    $.ajax({
                        url: `{{ url('api/admin/subject/update') }}/${subjectId}`,
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
                    let subjectId = $(this).data("id");
                    if (confirm("Are you sure you want to delete this subject?")) {
                        $.ajax({
                            url: `{{ url('admin/subject/delete') }}/${subjectId}`,
                            method: "DELETE",
                            data: { _token: "{{ csrf_token() }}" },
                            success: function(response) {
                                alert("Subject deleted successfully");
                                fetchSubject();
                            }
                        });
                    }
                });


            });
        </script>
        </div>
    </div>
@endsection
