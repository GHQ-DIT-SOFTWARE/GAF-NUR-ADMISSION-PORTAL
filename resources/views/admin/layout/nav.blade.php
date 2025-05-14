@php
    $usr = Auth::guard('web')->user();
@endphp
<nav class="pcoded-navbar menu-light ">
    <div class="navbar-wrapper  ">
        <div class="navbar-content scroll-div ">
            <div class="">
                <div class="collapse" id="nav-user-link">
                    <ul class="list-inline">
                        <li class="list-inline-item"><a href="user-profile.html" data-toggle="tooltip"
                                title="View Profile"><i class="feather icon-user"></i></a></li>
                        <li class="list-inline-item"><a href="email_inbox.html"><i class="feather icon-mail"
                                    data-toggle="tooltip" title="Messages"></i><small
                                    class="badge badge-pill badge-primary">5</small></a></li>
                        <li class="list-inline-item"><a href="auth-signin.html" data-toggle="tooltip" title="Logout"
                                class="text-danger"><i class="feather icon-power"></i></a></li>
                    </ul>
                </div>
            </div>

            <ul class="nav pcoded-inner-navbar ">
                <li class="nav-item pcoded-menu-caption">
                    <label>Dashboard</label>
                </li>
                @role('dashboard')
                    <li class="nav-item active"><a href="{{ route('dashboard.analysis-dashboard') }}"
                            class="nav-link has-ripple"><span class="pcoded-micon"><i
                                    class="feather icon-sidebar"></i></span><span class="pcoded-mtext">Dashboard</span>
                        </a>
                    </li>
                @endrole


                <li class="nav-item pcoded-menu-caption">
                    <label>Admin Amission Control</label>
                </li>
                {{-- @hasanyrole('superadmin|admin')
                    <li class="nav-item pcoded-hasmenu">
                        <a href="#!" class="nav-link "><span class="pcoded-micon"><i
                                    class="feather icon-bookmark"></i></span><span class="pcoded-mtext">Report
                                Generate</span></a>
                        <ul class="pcoded-submenu">
                            <li><a href="{{ route('report.report-generation') }}">Generate</a></li>
                        </ul>
                    </li>
                @endhasanyrole --}}
                <li
                class="nav-item pcoded-hasmenu {{ Route::is('report.report-generation', 'document.master-filter-documentation') ? 'active' : '' }}">
                <a href="#!" class="nav-link "><span class="pcoded-micon"><i
                            class="feather icon-settings"></i></span><span class="pcoded-mtext">Admission Process</span></a>
                <ul class="pcoded-submenu">
                    @can('view.documentation')
                                        <li class="{{ Route::is('report.report-generation') ? 'active' : '' }}">
                                            <a href="{{ route('report.report-generation') }}">Verify Results</a>
                                        </li>
                                    @endcan
                                    @can('view.aptitude')
                                    <li class="{{ Route::is('test.applicant-aptitude-test') ? 'active' : '' }}">
                                        <a href="{{ route('test.applicant-aptitude-test') }}">Aptitude</a>
                                    </li>
                                @endcan
                                @can('view.interview')
                                <li class="{{ Route::is('test.applicant-interview') ? 'active' : '' }}">
                                    <a href="{{ route('test.applicant-interview') }}">Interview</a>
                                </li>
                            @endcan

                </ul>
            </li>

                {{-- <li class="nav-item pcoded-hasmenu">
                    <a href="#!" class="nav-link "><span class="pcoded-micon"><i
                                class="feather icon-user-plus"></i></span><span class="pcoded-mtext">Phases</span></a>
                    <ul class="pcoded-submenu">
                        @hasanyrole('superadmin|documentation|user-documentation')
                            <li
                                class="nav-item pcoded-hasmenu {{ Route::is('report.report-generation', 'document.master-filter-documentation') ? 'active' : '' }}">
                                <a href="#!" class="nav-link has-ripple">
                                    <span class="pcoded-mtext">Results Verification</span>
                                    <span class="ripple ripple-animate"></span>
                                </a>
                                <ul class="pcoded-submenu">
                                    @can('view.documentation')
                                        <li class="{{ Route::is('report.report-generation') ? 'active' : '' }}">
                                            <a href="{{ route('report.report-generation') }}">Verify Results</a>
                                        </li>
                                    @endcan
                                    @can('documentation.edit')
                                        <li class="{{ Route::is('document.master-filter-documentation') ? 'active' : '' }}">
                                            <a href="{{ route('document.master-filter-documentation') }}">Master
                                                Filter</a>
                                        </li>
                                    @endcan
                                </ul>
                            </li>
                        @endhasanyrole

                        @hasanyrole('superadmin|aptitude|user-aptitude')
                        <li
                            class="nav-item pcoded-hasmenu {{ Route::is('test.applicant-aptitude-test', 'test.master-filter-aptitude') ? 'active' : '' }}">
                            <a href="#!" class="nav-link has-ripple">
                                <span class="pcoded-mtext">Aptitude</span>
                                <span class="ripple ripple-animate"></span>
                            </a>
                            <ul class="pcoded-submenu">
                                @can('view.aptitude')
                                    <li class="{{ Route::is('test.applicant-aptitude-test') ? 'active' : '' }}">
                                        <a href="{{ route('test.applicant-aptitude-test') }}">Filter</a>
                                    </li>
                                @endcan
                                @can('aptitude.edit')
                                    <li class="{{ Route::is('test.master-filter-aptitude') ? 'active' : '' }}">
                                        <a href="{{ route('test.master-filter-aptitude') }}">Master Filter</a>
                                    </li>
                                @endcan
                            </ul>
                        </li>
                    @endhasanyrole



                        @hasanyrole('superadmin|interview|user-interview')
                            <li
                                class="nav-item pcoded-hasmenu {{ Route::is('test.applicant-interview', 'test.master-filter-interview') ? 'active' : '' }}">
                                <a href="#!" class="nav-link has-ripple">
                                    <span class="pcoded-mtext">Interview</span>
                                    <span class="ripple ripple-animate"></span>
                                </a>
                                <ul class="pcoded-submenu">
                                    @can('view.interview')
                                        <li class="{{ Route::is('test.applicant-interview') ? 'active' : '' }}">
                                            <a href="{{ route('test.applicant-interview') }}">Filter</a>
                                        </li>
                                    @endcan
                                    @can('interview.edit')
                                        <li class="{{ Route::is('test.master-filter-interview') ? 'active' : '' }}">
                                            <a href="{{ route('test.master-filter-interview') }}">Master Filter</a>
                                        </li>
                                    @endcan
                                </ul>
                            </li>
                        @endhasanyrole
                    </ul>
                </li>
 --}}

                @role('superadmin')
                    <li
                        class="nav-item pcoded-hasmenu {{ Route::is(
                            'view-index',
                            'view-districts',
                            'results.bece-results-index',
                            'subject.bece-subject-index',
                            'subject.wassce-subject-index',
                            'results.wassce-results-index',
                            'course.courses-index')
                            ? 'active'
                            : '' }}">
                        <a href="#!" class="nav-link "><span class="pcoded-micon"><i
                                    class="feather icon-settings"></i></span><span class="pcoded-mtext">System
                                Setting</span></a>
                        <ul class="pcoded-submenu">

                            <li class="{{ Route::is('results.bece-results-index') ? 'active' : '' }}"><a
                                    href="{{ route('results.bece-results-index') }}">Bece Results</a></li>
                            <li class="{{ Route::is('subject.bece-subject-index') ? 'active' : '' }}"><a
                                    href="{{ route('subject.bece-subject-index') }}">Bece Subjects</a></li>
                            <li class="{{ Route::is('results.wassce-results-index') ? 'active' : '' }}"><a
                                    href="{{ route('results.wassce-results-index') }}">Wassce Results</a></li>
                            <li class="{{ Route::is('subject.wassce-subject-index') ? 'active' : '' }}"><a
                                    href="{{ route('subject.wassce-subject-index') }}">Wassce Subjects</a></li>
                            <li class="{{ Route::is('arm.arm-of-service') ? 'active' : '' }}"><a
                                    href="{{ route('arm.arm-of-service') }}">Courses</a></li>

                        </ul>
                    </li>

                    <li
                        class="nav-item pcoded-hasmenu {{ Route::is('index-user', 'index-roles', 'user-audit-trail', 'login_and_logout') ? 'active' : '' }}">
                        <a href="#!" class="nav-link "><span class="pcoded-micon"><i
                                    class="feather icon-settings"></i></span><span class="pcoded-mtext">Account
                                Setting</span></a>
                        <ul class="pcoded-submenu">
                            <li class="{{ Route::is('index-user') ? 'active' : '' }}"><a
                                    href="{{ route('index-user') }}">Users</a></li>
                            <li class="{{ Route::is('index-roles') ? 'active' : '' }}"><a
                                    href="{{ route('index-roles') }}">Roles</a></li>
                            <li class="{{ Route::is('user-audit-trail') ? 'active' : '' }}"><a
                                    href="{{ route('user-audit-trail') }}">Audit Trail</a></li>
                            <li class="{{ Route::is('login_and_logout') ? 'active' : '' }}"><a
                                    href="{{ route('login_and_logout') }}">Actives Logs</a></li>
                        </ul>
                    </li>
                @endrole


                <li class="nav-item pcoded-menu-caption">
                    <label>Admin Academics Control</label>
                </li>

                <li class="nav-item ">
                    <a href="{{ route('admin.courses') }}" class="nav-link "><span class="pcoded-micon"><i
                                class="feather icon-users"></i></span><span
                            class="pcoded-mtext">Progams</span></a>
                </li>
                <li class="nav-item ">
                    <a href="{{ route('admin.category') }}" class="nav-link "><span class="pcoded-micon"><i
                                class="feather icon-book"></i></span><span
                            class="pcoded-mtext">Course Subjects</span></a>
                </li>
                <li class="nav-item ">
                    <a href="{{ route('admin.course.packaging') }}" class="nav-link "><span class="pcoded-micon"><i
                                class="feather icon-box"></i></span><span
                            class="pcoded-mtext">Course Packaging</span></a>
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
