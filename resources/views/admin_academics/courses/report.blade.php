@extends('admin.layout.master')
@section('content')
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="m-b-10">Courses Report</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="feather icon-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="#">Courses Report</a></li>
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

            .form-input {
                padding: 10px;
                font-size: 16px;
                border: 1px solid #ddd;
                border-radius: 5px;
                flex: 1;
                min-width: 150px;
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
                        <b>Filter Course</b>
                        <form id="course-form" method="POST" class="form-container-row">
                            @csrf
                            <input type="date" name="start_date" required class="form-input" />
                            <input type="date" name="end_date" required class="form-input" />
                            <input type="text" name="location" class="form-input" placeholder="Enter Location" />
                            <button class="btn btn-primary form-button" type="submit">Filter</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-sm-12">
                <div class="card user-profile-list">
                    <div class="card-body">
                        <b>Courses (<span id="course-count">0</span>)</b> <!-- Display total count here -->
                        <table id="courses-table" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Course ID</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Location</th>
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
<script>
document.getElementById("course-form").addEventListener("submit", function (event) {
    event.preventDefault();

    let start_date = document.querySelector("input[name='start_date']").value;
    let end_date = document.querySelector("input[name='end_date']").value;
    let location = document.querySelector("input[name='location']").value;

    fetch(`/api/courses/filter?start_date=${start_date}&end_date=${end_date}&location=${location}`)
        .then(response => response.json())
        .then(data => {
            let tableBody = document.querySelector("#courses-table tbody");
            let courseCount = document.getElementById("course-count");

            tableBody.innerHTML = ""; // Clear previous data
            courseCount.textContent = data.length; // Update course count

            if (data.length === 0) {
                tableBody.innerHTML = "<tr><td colspan='7' class='text-center'>No courses found</td></tr>";
                return;
            }

            data.forEach(course => {
                let row = `
                    <tr>
                        <td>${course.course_id}</td>
                        <td>${course.start_date}</td>
                        <td>${course.end_date}</td>
                        <td>${course.location || 'N/A'}</td>
                        <td>${course.remarks || 'N/A'}</td>
                        <td>${new Date(course.created_at).toLocaleString()}</td>
                        <td>
                            <button class="btn btn-sm btn-primary">Enrollers</button>
                        </td>
                    </tr>
                `;
                tableBody.innerHTML += row;
            });
        })
        .catch(error => console.error("Error fetching data:", error));
});
</script>

@endsection
