@extends('admin.layout.master')
@section('content')
            <!-- [ breadcrumb ] start -->
            <div class="page-header">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h5 class="m-b-10">Score Board</h5>
                            </div>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="feather icon-home"></i></a></li>
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="#">Score Board</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-sm-12">
                    <div class="card user-profile-list">
                        <div class="card-body">
                            <div class="row align-items-center m-l-0">
                                <div class="dt-responsive table-responsive">
                                    <table id="score-table" class="table table-striped table-bordered nowrap">
                                        <thead>
                                            <tr>
                                                <th>Course</th>
                                                <th>Students</th>
                                                <th>Instructors</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($courses as $course)
                                            <tr>
                                                <td>{{ $course->course_name }}</td>
                                                <td class="student-count" data-course-id="{{ $course->id }}" data-lecturer-id="{{ $course->user_id }}">Loading...</td>
                                                <td>{{ $course->users->name ?? 'N/A' }}</td>
                                                <td>
                                                    <button type="button" class="btn btn-primary view-students"
                                                        data-toggle="modal"
                                                        data-target="#exampleModal"
                                                        data-course-id="{{ $course->id }}"
                                                        data-course-name="{{ $course->course_name }}"
                                                        data-lecturer-name="{{ $course->users->name ?? 'N/A' }}">
                                                        Score
                                                    </button>
                                                </td>

                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    </div>
    <!-- [ Main Content ] end -->

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <strong>Lecturer:</strong> <span id="lecturerName"></span><br><br>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Marks</th>
                            </tr>
                        </thead>
                        <tbody id="studentsTableBody">
                            <tr>
                                <td colspan="3">Loading...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success" data-dismiss="modal">Submit</button>
                </div>
            </div>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/echarts/5.4.0/echarts.min.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            let table = $('#score-table').DataTable();
            function fetchStudentCount(courseId, lecturerId, targetElement) {
                $.ajax({
                    url: "/api/admin/get-student-count",
                    type: "GET",
                    data: { course_id: courseId, lecturer_id: lecturerId },
                    success: function (response) {
                        targetElement.text(response.student_count);
                    },
                    error: function () {
                        targetElement.text("Error");
                    }
                });
            }

            // Assuming each row has data-course-id and data-lecturer-id attributes
            $(".student-count").each(function () {
                let courseId = $(this).data("course-id");
                let lecturerId = $(this).data("lecturer-id");
                fetchStudentCount(courseId, lecturerId, $(this));
            });
        });
    </script>


    <script type="text/javascript">
        google.charts.load("current", {packages:["corechart"]});
        google.charts.setOnLoadCallback(drawChart);
        function drawChart() {
          var data = google.visualization.arrayToDataTable([
            ['Captain Addy', 'GAF'],
            ['Lt Twum',     11],
            ['Maj Kabu',      2],
            ['Sgt Kumson',  2],
            ['Mr Johnson', 2]
          ]);

          var options = {
            is3D: true,
            chartArea: {width: '100%'},
          };

          var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
          chart.draw(data, options);
        }
      </script>

      <script>
        google.charts.load('current', {packages: ['corechart', 'bar']});
        google.charts.setOnLoadCallback(drawMultSeries);

        function drawMultSeries() {
              var data = google.visualization.arrayToDataTable([
                ['Distribution','Top 5'],
                ['Karen', 8175000],
                ['Isaac', 3792000],
                ['Michael', 2695000],
                ['MJ', 2099000]
              ]);

              var options = {
                chartArea: {width: '50%'},
                hAxis: {
                  minValue: 0
                },
                vAxis: {
                  title: 'Students'
                }
              };

              var chart = new google.visualization.BarChart(document.getElementById('chart_div'));
              chart.draw(data, options);
            }
      </script>

      <script>
        $(document).ready(function() {
    $('.view-students').click(function() {
        let courseId = $(this).data('course-id');
        let courseName = $(this).data('course-name');
        let lecturerName = $(this).data('lecturer-name');

        $('#exampleModalLabel').text(courseName);
        $('#lecturerName').text(lecturerName);

        $.ajax({
            url: "{{ route('api.getStudentList') }}",
            method: "GET",
            data: { course_id: courseId },
            success: function(response) {
                let students = response.students;
                let tableBody = $('#studentsTableBody');
                tableBody.empty();
                if (students.length > 0) {
                    students.forEach(student => {
                        tableBody.append(`<tr>
                            <td>${student.name}</td>
                            <td>${student.email}</td>
                            <td>MarksHere</td>
                        </tr>`);
                    });
                } else {
                    tableBody.append(`<tr><td colspan="3">No students enrolled.</td></tr>`);
                }
            },
            error: function() {
                $('#studentsTableBody').html(`<tr><td colspan="3">Error loading students.</td></tr>`);
            }
        });
    });
});


      </script>


@endsection
