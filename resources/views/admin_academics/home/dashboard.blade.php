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
                                <h5 class="m-b-10">GAF | BCCC LMS</h5>
                            </div>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="feather icon-home"></i></a></li>
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->
            <!-- [ Main Content ] start -->
            <div class="row">
                <!-- Card for Total Personnel -->
                <div class="col-xl-4 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <i class="icon feather icon-users f-30 text-c-yellow"></i>
                                </div>
                                <div class="col-3">
                                    <p class="text-muted m-b-5">M</p>
                                    <h6>{{$student_male}}</h6>
                                </div>
                                <div class="col-3">
                                    <p class="text-muted m-b-5">F</p>
                                    <h6>{{$student_female}}</h6>
                                </div>
                                <div class="col-auto">
                                    <h6 class="text-muted m-b-10">Students</h6>
                                    <h2 class="m-b-0">{{$student_total}}</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Card for Officers -->
                <div class="col-xl-4 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <i class="icon feather icon-users f-30 text-c-green"></i>
                                </div>
                                <div class="col-3">
                                    <p class="text-muted m-b-5">M</p>
                                    <h6>{{$lecturer_male}}</h6>
                                </div>
                                <div class="col-3">
                                    <p class="text-muted m-b-5">F</p>
                                    <h6>{{$lecturer_female}}</h6>
                                </div>
                                <div class="col-auto">
                                    <h6 class="text-muted m-b-10">Instructors</h6>
                                    <h2 class="m-b-0">{{$lecturer_total}}</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Card for Soldiers -->
                <!-- Service Personnel Section -->
                <div class="col-xl-4 col-md-6">
                    <div class="card overflow-hidden">
                        <div class="card-body  pb-0">
                            <div class="row text-white">
                                <div class="col-auto">
                                    <h4 class="m-b-5 text-black">Courses Summary</h4>
                                </div>
                                <div class="col text-right">
                                    <h6 class="text-white">
                                        <a href="#" id="time-date" style="color:black">Time/Date Here</a>
                                    </h6>
                                </div>
                                
                                <script>
                                    function updateTimeDate() {
                                        const now = new Date();
                                        const options = { 
                                            weekday: 'long', 
                                            year: 'numeric', 
                                            month: 'long', 
                                            day: 'numeric', 
                                            hour: '2-digit', 
                                            minute: '2-digit', 
                                            second: '2-digit' 
                                        };
                                        document.getElementById("time-date").textContent = now.toLocaleDateString("en-US", options);
                                    }
                                
                                    // Update the time and date every second
                                    setInterval(updateTimeDate, 1000);
                                
                                    // Set initial time and date
                                    updateTimeDate();
                                </script>
                                
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-8">
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col">
                                    <p class="text-muted m-b-5">Categories</p>
                                    <h6>{{$category_total}}</h6>
                                </div>
                                <div class="col-span">
                                    <p class="text-muted m-b-5">Courses</p>
                                    <h6>{{$course_total}}</h6>
                                </div>
                                <div class="col">
                                    <div class="col-span">
                                        <p class="text-muted m-b-5">Subjects</p>
                                        <h6>{{$subject_total}}</h6>
                                    </div>
                                </div>
                                <div class="col">
                                    <p class="text-muted m-b-5">Materials</p>
                                    <h6>{{$material_total}}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- customar project  end -->


            <!--Course Distribution chart -->
            {{-- <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5>STUDENT PERFORMANCE RANKING</h5>
                        </div>
                        <div class="card-body">
                            <div id="chart_div" style="width: 500px; height: 300px;"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5>INSTRUCTOR RATING</h5>
                        </div>
                        <div class="card-body">
                            <div id="piechart_3d" style="width: 550px; height: 300px;"></div>
                        </div>
                    </div>
                </div>
            </div> --}}


            <div class="row justify-content-center">
                <div class="col-sm-12">
                    <div class="card user-profile-list">
                        <div class="card-body">
                            <div class="row align-items-center m-l-0">
                                <div class="dt-responsive table-responsive">
                                    <table class="table table-striped table-bordered nowrap">
                                        <thead>
                                            <tr>
                                                <th>Course</th>
                                                <th>Subjects</th>
                                                <th>Students</th>
                                                <th>Lecturers</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
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
                                <th>Students</th>
                                <th>Lecturers</th>
                                <th>Subjects</th>
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
                </div>
            </div>
        </div>
    </div>
    

    <script src="https://cdnjs.cloudflare.com/ajax/libs/echarts/5.4.0/echarts.min.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
    function fetchStudentCount(courseId, targetElement) {
        $.ajax({
            url: "/api/admin/get-student-count",
            type: "GET",
            data: { course_id: courseId },
            success: function (response) {
                targetElement.text(response.student_count);
            },
            error: function () {
                targetElement.text("Error");
            }
        });
    }

    $(".student-count").each(function () {
        let courseId = $(this).data("course-id");
        fetchStudentCount(courseId, $(this));
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
                                <td>${student.phone}</td>
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
