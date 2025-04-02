@extends('admin.layout.master')
@section('content')
            <!-- [ breadcrumb ] start -->
            <div class="page-header">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h5 class="m-b-10">Course Allocation</h5>
                            </div>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="feather icon-home"></i></a></li>
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="#">Course Allocation</a></li>
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
                    flex-wrap: wrap;
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
                    flex: 1;
                    min-width: 150px;
                }

                .form-textarea {
                    flex: 2;
                    resize: none;
                    height: 40px;
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

                #searchUser {
                    width: 100%;
                    padding: 8px;
                    margin-bottom: 10px;
                    border: 1px solid #ddd;
                    border-radius: 5px;
                }

            </style>

            <div class="row justify-content-center">
                <div class="col-sm-12">
                    <div class="card user-profile-list">
                        <div class="card-body">
                            <b>Allocate Course</b>
                            <form id="allocation-form" method="POST">
                                @csrf
                                <select class="form-input" name="course_id" id="courseSelect" required>
                                    <option value="">--Select Course--</option>
                                    @foreach($packages as $package)
                                        <option value="{{ $package->course_id }}"
                                                data-level="{{ $package->level }}"
                                                data-semester="{{ $package->semester }}">
                                            {{ $package->course->course_name ?? 'Unknown Course' }}, Level {{ $package->level }}, {{ $package->semester }}
                                        </option>
                                    @endforeach
                                </select>

                                <!-- Hidden inputs to store selected course details -->
                                <input type="text" hidden name="level" id="levelInput" readonly>
                                <input type="text" hidden name="semester" id="semesterInput" readonly>

                                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                                <script>
                                    $(document).ready(function () {
                                        $('#courseSelect').change(function () {
                                            let selectedOption = $(this).find(':selected'); // Get the selected option
                                            let level = selectedOption.data('level');       // Get the level from data attribute
                                            let semester = selectedOption.data('semester'); // Get the semester from data attribute

                                            console.log('Selected Level:', level);
                                            console.log('Selected Semester:', semester);

                                            // Set the values in the hidden inputs
                                            $('#levelInput').val(level);
                                            $('#semesterInput').val(semester);
                                        });
                                    });
                                </script>



                                <select class="form-input" name="user_type" id="typeSelect">
                                    <option value="">--Type--</option>
                                    <option value="Lecturer">Lecturer</option>
                                    <option value="Student">Student</option>
                                </select>

                                <select class="form-input" name="program" id="programSelect">
                                    <option value="">--Program--</option>
                                    <option value="1st Semester">1st Semester</option>
                                    <option value="2nd Semester">2nd Semester</option>
                                </select>

                                <select class="form-input" name="level" id="levelSelect">
                                    <option value="">--Level--</option>
                                    <option value="100">100</option>
                                    <option value="200">200</option>
                                    <option value="300">300</option>
                                    <option value="400">400</option>
                                </select>


                                <input type="text" id="searchUser" style="margin-top: 2%" placeholder="Search users..." style="display: none;">

                                <table id="userTable" class="table table-striped table-bordered" style="display: none; margin-top: 10px;">
                                    <thead>
                                        <tr>
                                            <th>Index</th>
                                            <th>Name</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>

                                <button class="form-button" type="submit">Assign</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>



            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
            <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

            <script>
                $(document).ready(function() {

                    let table = $('#allocation-table').DataTable();

                fetchAllocation();

                $("#allocation-form").submit(function(e) {
                    e.preventDefault();
                    $.ajax({
                        url: "{{ route('admin.user.course.add') }}",
                        method: "POST",
                        data: $(this).serialize(),
                        success: function(response) {
                            alert("Course allocated successfully");
                            $("#allocation-form")[0].reset();
                            fetchAllocation();
                        }
                    });
                });

                function fetchAllocation() {
    $.get("/admin/user/course/allocation", function(response) {
        if (Array.isArray(response)) { // Ensure response is an array
            let tableBody = "";
            response.forEach(category => {
                tableBody += `<tr>
                    <td>${category.category_id}</td>
                    <td>${category.category_name}</td>
                    <td>${category.credit_hours}</td>
                    <td>${category.level}</td>
                    <td>${category.category_remarks}</td>
                    <td>${new Date(category.created_at).toLocaleString()}</td>
                    <td><button class="btn btn-primary delete-btn" data-id="${category.id}"><i class="fas fa-trash"></i></button></td>
                </tr>`;
            });
            $("#allocation-table tbody").html(tableBody);
        } else {
            console.error("Error: Expected an array but got", response);
        }
    }).fail(function (jqXHR, textStatus, errorThrown) {
        console.error("AJAX Error:", textStatus, errorThrown);
    });
}



                    $('#typeSelect').change(function() {
                        let role = $(this).val();
                        if (!role) {
                            $('#userTable').hide();
                            $('#searchUser').hide();
                            return;
                        }

                        $('#userTable tbody').html('<tr><td colspan="3">Loading...</td></tr>');
                        $('#userTable').show();
                        $('#searchUser').show();

                        $.ajax({
                            url: '/admin/fetch-users',
                            type: 'GET',
                            data: { role: role },
                            success: function(response) {
                                let rows = '';
                                response.forEach((user, index) => {
                                    rows += `<tr>
                                                <td>${user.index_number}</td>
                                                <td>${user.name}</td>
                                                <td><input type="checkbox" name="user_id[]" value="${user.id}"></td>
                                            </tr>`;
                                });
                                $('#userTable tbody').html(rows);
                            },
                            error: function() {
                                $('#userTable tbody').html('<tr><td colspan="3">Error loading data</td></tr>');
                            }
                        });
                    });

                    $('#searchUser').on('keyup', function() {
                        let value = $(this).val().toLowerCase();
                        $('#userTable tbody tr').filter(function() {
                            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                        });
                    });
                });
            </script>

<script>
    $(document).ready(function () {
    function fetchUsers() {
        let userType = $('#typeSelect').val();
        let semester = $('#programSelect').val();
        let level = $('#levelSelect').val();

        if (userType === 'Student' && semester && level) {
            $.ajax({
                url: "{{ route('fetch.students') }}",
                type: "GET",
                data: {
                    semester: semester,
                    level: level
                },
                success: function (response) {
                    let userTable = $('#userTable tbody');
                    userTable.empty();

                    if (response.length > 0) {
                        $('#userTable').show();
                        response.forEach((user, index) => {
                            userTable.append(`
                                <tr>
                                    <td>${index + 1}</td>
                                    <td>${user.name}</td>
                                    <td>
                                        <input type="checkbox" name="user_id[]" value="${user.id}">
                                    </td>
                                </tr>
                            `);
                        });
                    } else {
                        $('#userTable').hide();
                    }
                }
            });
        } else {
            $('#userTable').hide();
        }
    }

    $('#typeSelect, #programSelect, #levelSelect').change(fetchUsers);
});

</script>

        </div>
    </div>
@endsection
