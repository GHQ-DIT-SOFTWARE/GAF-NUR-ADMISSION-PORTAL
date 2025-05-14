<nav class="pcoded-navbar menu-light ">
    <div class="navbar-wrapper  ">
        <div class="navbar-content scroll-div ">

            <div class="">
                <div class="main-menu-header">
                    <img class="img-radius" src="{{ asset('gaflogo.png') }}" height="60px"
                        width="50px"alt="User-Profile-Image">
                    <div class="user-details">
                        <div id="more-details">Admin </div>
                    </div>
                </div>
            </div><br>

            <ul class="nav pcoded-inner-navbar ">
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link "><span class="pcoded-micon"><i
                                class="feather icon-home"></i></span><span class="pcoded-mtext">Dashboard</span></a>
                </li>
                <li class="nav-item ">
                    <a href="{{ route('admin.courses') }}" class="nav-link "><span class="pcoded-micon"><i
                                class="feather icon-users"></i></span><span
                            class="pcoded-mtext">Courses/Progams</span></a>
                </li>
                <li class="nav-item ">
                    <a href="{{ route('admin.category') }}" class="nav-link "><span class="pcoded-micon"><i
                                class="feather icon-settings"></i></span><span
                            class="pcoded-mtext">Subjects</span></a>
                </li>
                {{-- <li class="nav-item pcoded-hasmenu">
                    <a href="#!" class="nav-link "><span class="pcoded-micon"><i  class="feather icon-book"></i></span><span class="pcoded-mtext">Subjects</span></a>
                    <ul class="pcoded-submenu">
                        <li><a href="{{ route('admin.subjects') }}">Add/View Subjects</a></li>
                        <li><a href="{{ route('admin.subject.material') }}">Subject Material</a></li>
                        <li><a href="{{ route('admin.subject.allocation') }}">Subject Allocation</a></li>
                    </ul>
                </li> --}}
                <li class="nav-item pcoded-hasmenu">
                    <a href="#!" class="nav-link "><span class="pcoded-micon"><i  class="feather icon-book"></i></span><span class="pcoded-mtext">Assignments</span></a>
                    <ul class="pcoded-submenu">
                        <li><a href="{{ route('admin.assignments') }}">Add/View Assignments</a></li>
                    </ul>
                </li>
                <li class="nav-item pcoded-hasmenu">
                    <a href="#!" class="nav-link "><span class="pcoded-micon"><i  class="feather icon-check"></i></span><span class="pcoded-mtext">Assessments</span></a>
                    <ul class="pcoded-submenu">
                        {{-- <li><a href="{{ route('admin.assignments.marks') }}">Assignments</a></li>
                        <li><a href="{{ route('admin.quizzes') }}">Quizzes</a></li>
                        <li><a href="{{ route('admin.exams') }}">Exams</a></li> --}}
                        <li><a href="{{ route('admin.scores') }}">Scores</a></li>
                    </ul>
                </li>
                </li>
                <li class="nav-item pcoded-hasmenu">
                    <a href="#!" class="nav-link "><span class="pcoded-micon"><i
                                class="feather icon-box"></i></span><span class="pcoded-mtext">Report</span></a>
                    <ul class="pcoded-submenu">
                        <li><a href="{{ route('admin.report.courses') }}">Courses</a></li>
                        <li><a href="{{ route('admin.report.assignments') }}">Assignments</a></li>
                        <li><a href="{{ route('admin.report.performance') }}">Performance</a></li>
                    </ul>
                </li>
                <li class="nav-item pcoded-hasmenu">
                    <a href="#!" class="nav-link "><span class="pcoded-micon"><i class="feather icon-settings"></i></span><span class="pcoded-mtext">Settings</span></a>
                    <ul class="pcoded-submenu">
                        <li><a href="{{ route('admin.users') }}">Users</a></li>
                        <li><a href="{{ route('admin.course.packaging') }}">Course Packaging</a></li>
                        <li><a href="{{route('admin.user.course.allocation')}}">User-Course Allocation</a></li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link "><span class="pcoded-micon"><i
                                class="feather icon-book"></i></span><span class="pcoded-mtext">Guide</span></a>
                </li>

            </ul>

        </div>
    </div>
</nav>
