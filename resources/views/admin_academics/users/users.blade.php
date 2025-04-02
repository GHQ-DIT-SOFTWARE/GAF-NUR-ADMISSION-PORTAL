@extends('admin.layout.master')
@section('content')
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="m-b-10">Users</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="feather icon-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="#">Users</a></li>
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
                <b>Add User
                    <button id="toggle-form" class="btn btn-primary" style="float:right;">Add</button>
                </b>

                <form id="users-form" method="POST" action="{{route('admin.users.add')}}" style="display: none; margin-top: 10px;">
                    @csrf
                    <input type="text" name="index_number" required class="form-control mb-2" readonly placeholder="Index No." />
                    <input type="text" name="name" placeholder="Name" required class="form-control mb-2" />
                    <select name="gender" class="form-control mb-2">
                        <option value="">--Select Gender--</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                    <input type="email" name="email" placeholder="Email" required class="form-control mb-2" />
                    <input type="text" name="phone" placeholder="Phone" class="form-control mb-2" />
                    <input type="text" name="gps" placeholder="GPS" class="form-control mb-2" />
                    <input type="text" name="service_no" placeholder="Service Number" class="form-control mb-2"/>
                    <select name="role" class="form-control mb-2">
                        <option value="">--Select Role--</option>
                        <option value="Student">Student</option>
                        <option value="Lecturer">Lecturer</option>
                        <option value="Admin">Admin</option>
                    </select>
                    <input type="password" name="password" placeholder="Password" class="form-control mb-2"/>

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
            $("#users-form").toggle(); // Show or hide the form instantly
            $(this).text($("#users-form").is(":visible") ? "Close" : "Add"); // Change button text

            // Generate a random alphanumeric index number when form is displayed
            if ($("#users-form").is(":visible")) {
                let randomIndex = generateIndexNumber();
                $("input[name='index_number']").val(randomIndex);
            }
        });

        function generateIndexNumber() {
            let chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
            let indexNumber = "";
            for (let i = 0; i < 10; i++) {
                indexNumber += chars.charAt(Math.floor(Math.random() * chars.length));
            }
            return indexNumber;
        }
    });
</script>


        <div class="row justify-content-center">
            <div class="col-sm-12">
                <div class="card user-profile-list">
                    <div class="card-body">
                        <b>Users (<span id="total-users">0</span>)</b>
                        <table id="users-table" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Index No.</th>
                                    <th>Service</th>
                                    <th>Name</th>
                                    <th>Gender</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>GPS</th>
                                    <th>Role</th>
                                    <th>Phone</th>
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
                let table = $('#users-table').DataTable();

                fetchUsers();

                $("#users-form").submit(function(e) {
                    e.preventDefault();
                    $.ajax({
                        url: "{{ route('admin.users.add') }}",
                        method: "POST",
                        data: $(this).serialize(),
                        success: function(response) {
                            alert("users added successfully");
                            $("#users-form")[0].reset();
                            fetchUsers();
                        }
                    });
                });

                function fetchUsers() {
                    $.get("{{ route('api.users') }}", function(data) {
                        let tableBody = "";
                        $("#total-users").text(data.length);
                        data.forEach(users => {
                            tableBody += `<tr data-id="${users.id}">
                                <td contenteditable="true" data-column="index_number">${users.index_number}</td>
                                <td contenteditable="true" data-column="service_number">${users.service_no}</td>
                                <td contenteditable="true" data-column="name">${users.name}</td>
                                <td contenteditable="true" data-column="gender">${users.gender}</td>
                                <td contenteditable="true" data-column="email">${users.email}</td>
                                <td contenteditable="true" data-column="phone">${users.phone}</td>
                                <td contenteditable="true" data-column="gps">${users.gps}</td>
                                <td contenteditable="true" data-column="role">${users.role}</td>
                                <td contenteditable="true" data-column="phone">${users.phone}</td>
                                <td>${new Date(users.created_at).toLocaleString()}</td>
                                <td><button class="btn btn-primary delete-btn" data-id="${users.id}"><i class="fas fa-trash"></i></button></td>
                            </tr>`;
                        });
                        // Clear the table before appending new rows
                        table.clear().draw();
                        // Add rows to the DataTable
                        table.rows.add($(tableBody)).draw();
                    });
                }

                $(document).on("blur", "[contenteditable]", function() {
                    let usersId = $(this).closest("tr").data("id");
                    let column = $(this).data("column");
                    let value = $(this).text();

                    $.ajax({
                        url: `{{ url('api/admin/users/update') }}/${usersId}`,
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
                    let usersId = $(this).data("id");
                    if (confirm("Are you sure you want to delete this users?")) {
                        $.ajax({
                            url: `{{ url('admin/users/delete') }}/${usersId}`,
                            method: "DELETE",  // Changed from POST to DELETE
                            data: { _token: "{{ csrf_token() }}" },
                            success: function(response) {
                                alert("users deleted successfully");
                                fetchUsers();
                            }
                        });
                    }
                });

            });
        </script>
@endsection
