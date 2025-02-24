@extends('portal.master')
@section('content')
    <style>
        .btn-file {
            position: relative;
            overflow: hidden;
        }

        .input_container {
            border: 1px solid #e5e5e5;
            /* height: 42px; */
        }

        input[type=file]::file-selector-button {
            background-color: #fff;
            color: #000;
            border: 0px;
            border-right: 1px solid #e5e5e5;
            /* padding: 10px 15px; */
            margin-right: 10px;
            transition: .5s;

        }

        input[type=file]::file-selector-button:hover {
            background-color: #eee;
            border: 0px;
            border-right: 1px solid #e5e5e5;
        }

        #img-upload {
            /* width: 255px;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        height: 220px; */
            width: 100%;
        }
    </style>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/css/select2.min.css" rel="stylesheet" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/plugins/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/style.css') }}">

    <body class=""style="background-image: url('assets/images/nav-bg/body-bg-9.jpg'); background-repeat: no-repeat; background-size: cover; background-position: center;">
        <section class="pcoded-apply-container">
            <div class="pcoded-content">
                <div class="page-header">
                    <div class="page-block">
                        <div class="row align-items-center">
                            <div class="col-md-12">
                                <div class="page-header-title">
                                    <nav class="navbar justify-content-between p-0 align-items-center">
                                        <h5>Home</h5>
                                        <div class="input-group" style="width: auto;">
                                            <div class="col text-right">
                                                <div class="btn-group mb-2 mr-2" style="display: inline-block;">
                                                    <form method="POST" action="{{ route('logout') }}">
                                                        @csrf
                                                        <button type="submit" class="btn btn-link"
                                                            style="color: white;">Cancel Application</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </nav>
                                </div>
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.html"><i class="feather icon-home"></i></a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="#!"> VACANCY SELECTED: ARM OF SERVICE:
                                            {{ $applied_applicant->arm_of_service }}/
                                            COMMISSION
                                            TYPE: {{ $applied_applicant->commission_type }}/
                                            BRANCH: {{ $applied_applicant->branches->branch ?? 'N/A' }}</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 style="text-align: center; font-family: Arial Black, Helvetica, sans-serif;">
                                    GHANA ARMED FORCES - ONLINE ENLISTMENT PORTAL
                                </h4>
                                <marquee behavior="scroll" direction="left" scrollamount="2"
                                    style="font-family: Arial, sans-serif; font-size: 16px; color: #ff0000; font-weight: bold; text-transform: uppercase;">
                                    PLEASE COMPLETE THE VARIOUS FORMS BY CLICKING "NEXT" TO COMPLETE YOUR APPLICATION.
                                </marquee>
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <h5>Application Form</h5>
                            </div>
                            <div class="card-body" style="margin-left: 2cm; margin-right: 2cm;">
                                <div class="bt-wizard" id="progresswizard">
                                    <ul class="nav nav-pills nav-fill mb-3"
                                        style="text-align: center; font-family: Arial Black, Helvetica, sans-serif;">
                                        <li class="nav-item"><a href="#b-w-tab3" class="nav-link"
                                                data-toggle="tab">PROFESSIONAL DETAILS</a></li>
                                    </ul>
                                    <div id="bar" class="bt-wizard progress mb-3" style="height:6px">
                                        <div class="progress-bar bg-success" role="progressbar" aria-valuenow="0"
                                            aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
                                    </div>
                                    <div class="tab-content">
                                        <div class="tab-pane" id="b-w-tab3">
                                            <form id="form3" action="{{ route('saveProfessionalData') }}" method="POST"
                                                enctype="multipart/form-data">
                                                @csrf
                                                <div class="col-md-12">
                                                    <h5 class="mt-12" style="text-align: left">Professional
                                                        Qualification
                                                        details</h5>
                                                    <hr>
                                                    <div style="">
                                                        <div class="form-group row">
                                                            <label for="b-t-name" class="col-sm-2 col-form-label">Name
                                                                of
                                                                Institution</label>
                                                            <div class="col-sm-2">
                                                                <input type="text" class="form-control required"
                                                                    id="name_of_professional_school"
                                                                    name="name_of_professional_school"
                                                                    value="{{ old('name_of_professional_school', $applied_applicant->name_of_professional_school) }}">
                                                            </div>
                                                            <label for="b-t-name"
                                                                class="col-sm-2 col-form-label">Programme</label>
                                                            <div class="col-sm-1">
                                                                <select id="professional_programme"
                                                                    name="professional_programme"
                                                                    class="form-control required">
                                                                    <option value="">Select Option</option>
                                                                    <option
                                                                        value="MBChB."{{ old('professional_programme', $applied_applicant->professional_programme) == 'MBChB.' ? 'selected' : '' }}>
                                                                        MBChB.
                                                                    </option>
                                                                    <option value="MSc."
                                                                        {{ old('professional_programme', $applied_applicant->professional_programme) == 'MSc.' ? 'selected' : '' }}>
                                                                        MSc.
                                                                    </option>
                                                                    <option value="MA."
                                                                        {{ old('professional_programme', $applied_applicant->professional_programme) == 'MA.' ? 'selected' : '' }}>
                                                                        MA.
                                                                    </option>
                                                                    <option value="MEng."
                                                                        {{ old('professional_programme', $applied_applicant->professional_programme) == 'MEng.' ? 'selected' : '' }}>
                                                                        MEng.
                                                                    </option>
                                                                    <option value="PhD."
                                                                        {{ old('professional_programme', $applied_applicant->professional_programme) == 'PhD.' ? 'selected' : '' }}>
                                                                        PhD.
                                                                    </option>
                                                                </select>
                                                            </div>
                                                            <div class="col-sm-2">
                                                                <select id="professional_qualification"
                                                                    name="professional_qualification"
                                                                    class="form-control required">
                                                                    <option value="">CHOOSE
                                                                        professional_qualification
                                                                    </option>
                                                                    <option value="COMPUTER SCIENCE"
                                                                        {{ old('professional_qualification', $applied_applicant->professional_qualification) == 'COMPUTER SCIENCE' ? 'selected' : '' }}>
                                                                        COMPUTER SCIENCE
                                                                    </option>
                                                                    <option value="BUSINESS ADMINISTRATION"
                                                                        {{ old('professional_qualification', $applied_applicant->professional_qualification) == 'BUSINESS ADMINISTRATION' ? 'selected' : '' }}>
                                                                        BUSINESS ADMINISTRATION
                                                                    </option>
                                                                    <option value="MECHANICAL ENGINEERING"
                                                                        {{ old('professional_qualification', $applied_applicant->professional_qualification) == 'MECHANICAL ENGINEERING' ? 'selected' : '' }}>
                                                                        MECHANICAL ENGINEERING
                                                                    </option>
                                                                    <option value="ELECTRICAL ENGINEERING"
                                                                        {{ old('professional_qualification', $applied_applicant->professional_qualification) == 'ELECTRICAL ENGINEERING' ? 'selected' : '' }}>
                                                                        ELECTRICAL ENGINEERING
                                                                    </option>
                                                                    <option value="CIVIL ENGINEERING"
                                                                        {{ old('professional_qualification', $applied_applicant->professional_qualification) == 'CIVIL ENGINEERING' ? 'selected' : '' }}>
                                                                        CIVIL ENGINEERING
                                                                    </option>
                                                                    <option value="LAW"
                                                                        {{ old('professional_qualification', $applied_applicant->professional_qualification) == 'LAW' ? 'selected' : '' }}>
                                                                        LAW
                                                                    </option>
                                                                    <option value="MEDICINE"
                                                                        {{ old('professional_qualification', $applied_applicant->professional_qualification) == 'MEDICINE' ? 'selected' : '' }}>
                                                                        MEDICINE
                                                                    </option>
                                                                    <option value="PHARMACY"
                                                                        {{ old('professional_qualification', $applied_applicant->professional_qualification) == 'PHARMACY' ? 'selected' : '' }}>
                                                                        PHARMACY
                                                                    </option>
                                                                    <option value="NURSING"
                                                                        {{ old('professional_qualification', $applied_applicant->professional_qualification) == 'NURSING' ? 'selected' : '' }}>
                                                                        NURSING
                                                                    </option>
                                                                    <option value="ARCHITECTURE"
                                                                        {{ old('professional_qualification', $applied_applicant->professional_qualification) == 'ARCHITECTURE' ? 'selected' : '' }}>
                                                                        ARCHITECTURE
                                                                    </option>
                                                                </select>
                                                            </div>
                                                            <label for="b-t-name" class="col-sm-2 col-form-label">Year
                                                                of
                                                                Completion</label>
                                                            <div class="col-sm-1">
                                                                <input type="date" class="form-control required"
                                                                    name="year_of_professional_completion"
                                                                    value="{{ old('year_of_professional_completion', $applied_applicant->year_of_professional_completion) }}">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label for="b-t-name" class="col-sm-2 col-form-label">Years of
                                                                Experience</label>
                                                            <div class="col-sm-2">
                                                                <select
                                                                    id="year_of_professional_experience"name="year_of_professional_experience"
                                                                    class="form-control required">
                                                                    <option value="">select option</option>
                                                                    <option value="1"
                                                                        {{ old('year_of_professional_experience', $applied_applicant->year_of_professional_experience) == '1' ? 'selected' : '' }}>
                                                                        1
                                                                    </option>
                                                                    <option value="2"
                                                                        {{ old('year_of_professional_experience', $applied_applicant->year_of_professional_experience) == '2' ? 'selected' : '' }}>
                                                                        2
                                                                    </option>
                                                                    <option value="3"
                                                                        {{ old('year_of_professional_experience', $applied_applicant->year_of_professional_experience) == '3' ? 'selected' : '' }}>
                                                                        3
                                                                    </option>
                                                                    <option value="4"
                                                                        {{ old('year_of_professional_experience', $applied_applicant->year_of_professional_experience) == '4' ? 'selected' : '' }}>
                                                                        4
                                                                    </option>
                                                                    <option value="5 YEARS AND ABOVE"
                                                                        {{ old('year_of_professional_experience', $applied_applicant->year_of_professional_experience) == '5 YEARS AND ABOVEA' ? 'selected' : '' }}>
                                                                        5 YEARS AND ABOVEA
                                                                    </option>
                                                                </select>
                                                            </div>
                                                            <label for="b-t-name"
                                                                class="col-sm-2 col-form-label">PIN/AIN/HIN/Certificate
                                                                Number</label>
                                                            <div class="col-sm-2">
                                                                <input type="text" class="form-control required"
                                                                    id="pin_id" name="pin_number"
                                                                    value="{{ old('pin_number', $applied_applicant->pin_number) }}">
                                                            </div>
                                                            <label for="b-t-name" class="col-sm-2 col-form-label">Upload
                                                                Certificate</label>
                                                            <div class="col-sm-2">
                                                                <div
                                                                    class="file btn waves-effect waves-light btn-outline-primary mt-3 file-btn">
                                                                    <i class="feather icon-paperclip"></i> Add
                                                                    Attachment
                                                                    <input type="file" name="professional_certificate"
                                                                        accept=".pdf" id="professional_certificate" />
                                                                </div>
                                                                <div id="professional-file-preview" class="mt-2">
                                                                    @if (!empty($applied_applicant->professional_certificate))
                                                                        <p>Selected file:
                                                                            {{ basename($applied_applicant->professional_certificate) }}
                                                                        </p>
                                                                        <a href="{{ asset($applied_applicant->professional_certificate) }}"
                                                                            target="_blank">View PDF</a>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <hr>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary save-btn"
                                                        id="saveProfessionalData" style="float:right;">Next</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

        </section>
    </body>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <!-- Required Js -->
    <script src="{{ asset('frontend/assets/js/vendor-all.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/plugins/bootstrap.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/ripple.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/pcoded.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/plugins/jquery.bootstrap.wizard.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/plugins/moment.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/plugins/daterangepicker.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/pages/ac-datepicker.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/js/select2.min.js"></script>
    <script src="{{ asset('frontend/assets/js/plugins/select2.full.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/pages/form-select-custom.js') }}"></script>




    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkSame = document.getElementById('check_same');
            const examTypeOne = document.getElementById('exam_type_one');
            const resultSlipOne = document.getElementById('results_slip_one');
            checkSame.addEventListener('change', function() {
                if (checkSame.checked) {
                    const examTypeValue = examTypeOne.value;
                    const resultSlipValue = resultSlipOne.value;
                    // Copy values to other fields
                    document.getElementById('exam_type_two').value = examTypeValue;
                    document.getElementById('results_slip_two').value = resultSlipValue;

                    document.getElementById('exam_type_three').value = examTypeValue;
                    document.getElementById('results_slip_three').value = resultSlipValue;

                    document.getElementById('exam_type_four').value = examTypeValue;
                    document.getElementById('results_slip_four').value = resultSlipValue;

                    document.getElementById('exam_type_five').value = examTypeValue;
                    document.getElementById('results_slip_five').value = resultSlipValue;

                    document.getElementById('exam_type_six').value = examTypeValue;
                    document.getElementById('results_slip_six').value = resultSlipValue;
                } else {
                    // Optionally clear the copied values when unchecked
                    document.getElementById('exam_type_two').value = '';
                    document.getElementById('results_slip_two').value = '';

                    document.getElementById('exam_type_three').value = '';
                    document.getElementById('results_slip_three').value = '';

                    document.getElementById('exam_type_four').value = '';
                    document.getElementById('results_slip_four').value = '';

                    document.getElementById('exam_type_five').value = '';
                    document.getElementById('results_slip_five').value = '';

                    document.getElementById('exam_type_six').value = '';
                    document.getElementById('results_slip_six').value = '';
                }
            });
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#image').change(function(e) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#showImage').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            const oldBranch = '{{ old('branch', $applied_applicant->branch ?? '') }}';
            const oldCourse = '{{ old('course', $applied_applicant->course ?? '') }}';
            // Fetch branches on page load
            $.ajax({
                url: '{{ route('get.branches') }}',
                method: 'GET',
                success: function(data) {
                    let branchSelect = $('#branch');
                    branchSelect.empty();
                    branchSelect.append('<option value="">Select Branch</option>');
                    $.each(data, function(key, branch) {
                        let selected = (oldBranch == branch.id) ? 'selected' : '';
                        branchSelect.append('<option value="' + branch.id + '" ' + selected +
                            '>' + branch.branch + '</option>');
                    });
                    // If a branch was previously selected, trigger the change event to load the courses
                    if (oldBranch) {
                        branchSelect.trigger('change');
                    }
                },
                error: function(xhr) {
                    console.log('Error fetching branches:', xhr);
                }
            });

            // Fetch courses when branch is selected
            $('#branch').on('change', function() {
                let branchId = $(this).val();
                if (branchId) {
                    $.ajax({
                        url: '{{ route('get.courses') }}',
                        method: 'GET',
                        data: {
                            branch_id: branchId
                        },
                        success: function(data) {
                            let courseSelect = $('#course');
                            courseSelect.empty();
                            courseSelect.append('<option value="">Select Course</option>');
                            $.each(data, function(key, course) {
                                let selected = (oldCourse == course.id) ? 'selected' :
                                    '';
                                courseSelect.append('<option value="' + course.id +
                                    '" ' + selected + '>' + course.course_name +
                                    '</option>');
                            });
                        },
                        error: function(xhr) {
                            console.log('Error fetching courses:', xhr);
                        }
                    });
                } else {
                    $('#course').empty();
                    $('#course').append('<option value="">Select Course</option>');
                }
            });
        });
    </script>

    <script>
        document.getElementById('bece_certificate').addEventListener('change', function(event) {
            var fileInput = event.target;
            var filePreview = document.getElementById('file-preview');
            // Clear previous preview
            filePreview.innerHTML = '';
            if (fileInput.files.length > 0) {
                var file = fileInput.files[0];
                if (file.type === 'application/pdf') {
                    // Display file name
                    var fileName = document.createElement('p');
                    fileName.textContent = 'Selected file: ' + file.name;
                    filePreview.appendChild(fileName);
                    // Optionally, provide a link to open the PDF
                    var fileLink = document.createElement('a');
                    fileLink.href = URL.createObjectURL(file);
                    fileLink.textContent = 'View PDF';
                    fileLink.target = '_blank';
                    filePreview.appendChild(fileLink);
                } else {
                    filePreview.textContent = 'Please select a PDF file.';
                }
            }
        });
    </script>

    <script>
        document.getElementById('wassce_certificate').addEventListener('change', function(event) {
            var fileInput = event.target;
            var filePreview = document.getElementById('wassce-file-preview');
            // Clear previous preview
            filePreview.innerHTML = '';
            if (fileInput.files.length > 0) {
                var file = fileInput.files[0];
                if (file.type === 'application/pdf') {
                    // Display file name
                    var fileName = document.createElement('p');
                    fileName.textContent = 'Selected file: ' + file.name;
                    filePreview.appendChild(fileName);
                    // Optionally, provide a link to open the PDF
                    var fileLink = document.createElement('a');
                    fileLink.href = URL.createObjectURL(file);
                    fileLink.textContent = 'View PDF';
                    fileLink.target = '_blank';
                    filePreview.appendChild(fileLink);
                } else {
                    filePreview.textContent = 'Please select a PDF file.';
                }
            }
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#district').change(function() {
                var district_id = $(this).val();
                if (district_id) {
                    $.ajax({
                        url: '/get-regions/' + district_id,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            $('#region').empty();
                            if (data.length > 0) {
                                $.each(data, function(key, value) {
                                    $('#region').append('<option value="' + value.id +
                                        '">' + value.region_name + '</option>');
                                });
                            } else {
                                $('#region').append(
                                    '<option value="">No regions available</option>');
                            }
                        }
                    });
                } else {
                    $('#region').empty();
                    $('#region').append('<option value="">Select Region</option>');
                }
            });
        });
    </script>

    <script>
        document.getElementById('degree_certificate').addEventListener('change', function(event) {
            var fileInput = event.target;
            var filePreview = document.getElementById('degree-file-preview');
            // Clear previous preview
            filePreview.innerHTML = '';
            if (fileInput.files.length > 0) {
                var file = fileInput.files[0];
                if (file.type === 'application/pdf') {
                    // Display file name
                    var fileName = document.createElement('p');
                    fileName.textContent = 'Selected file: ' + file.name;
                    filePreview.appendChild(fileName);
                    // Optionally, provide a link to open the PDF
                    var fileLink = document.createElement('a');
                    fileLink.href = URL.createObjectURL(file);
                    fileLink.textContent = 'View PDF';
                    fileLink.target = '_blank';
                    filePreview.appendChild(fileLink);
                } else {
                    filePreview.textContent = 'Please select a PDF file.';
                }
            }
        });
    </script>
    <script>
        document.getElementById('professional_certificate').addEventListener('change', function(event) {
            var fileInput = event.target;
            var filePreview = document.getElementById('professional-file-preview');
            // Clear previous preview
            filePreview.innerHTML = '';
            if (fileInput.files.length > 0) {
                var file = fileInput.files[0];
                if (file.type === 'application/pdf') {
                    // Display file name
                    var fileName = document.createElement('p');
                    fileName.textContent = 'Selected file: ' + file.name;
                    filePreview.appendChild(fileName);
                    // Optionally, provide a link to open the PDF
                    var fileLink = document.createElement('a');
                    fileLink.href = URL.createObjectURL(file);
                    fileLink.textContent = 'View PDF';
                    fileLink.target = '_blank';
                    filePreview.appendChild(fileLink);
                } else {
                    filePreview.textContent = 'Please select a PDF file.';
                }
            }
        });
    </script>
    <script>
        $(document).ready(function() {

            $(document).on('change', '.btn-file :file', function() {
                var input = $(this),
                    label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
                input.trigger('fileselect', [label]);
            });
            $('.btn-file :file').on('fileselect', function(event, label) {
                var input = $(this).parents('.input-group').find(':text'),
                    log = label;
                if (input.length) {
                    input.val(log);
                } else {
                    if (log) alert(log);
                }

            });

            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function(e) {
                        $('#img-upload').attr('src', e.target.result);
                    }

                    reader.readAsDataURL(input.files[0]);
                }
            }

            $("#imgInp").change(function() {
                readURL(this);
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#besicwizard').bootstrapWizard({
                withVisible: false,
                'nextSelector': '.button-next',
                'previousSelector': '.button-previous',
                'firstSelector': '.button-first',
                'lastSelector': '.button-last'
            });
            $('#btnwizard').bootstrapWizard({
                withVisible: false,
                'nextSelector': '.button-next',
                'previousSelector': '.button-previous',
                'firstSelector': '.button-first',
                'lastSelector': '.button-last'
            });
            $('#progresswizard').bootstrapWizard({
                withVisible: false,
                'nextSelector': '.button-next',
                'previousSelector': '.button-previous',
                'firstSelector': '.button-first',
                'lastSelector': '.button-last',
                onTabShow: function(tab, navigation, index) {
                    var $total = navigation.find('li').length;
                    var $current = index + 1;
                    var $percent = ($current / $total) * 100;
                    $('#progresswizard .progress-bar').css({
                        width: $percent + '%'
                    });
                }
            });
            $('#validationwizard').bootstrapWizard({
                withVisible: false,
                'nextSelector': '.button-next',
                'previousSelector': '.button-previous',
                'firstSelector': '.button-first',
                'lastSelector': '.button-last',
                onNext: function(tab, navigation, index) {
                    if (index == 1) {
                        if (!$('#validation-t-name').val()) {
                            $('#validation-t-name').focus();
                            $('.form-1').addClass('was-validated');
                            return false;
                        }
                        if (!$('#validation-t-email').val()) {
                            $('#validation-t-email').focus();
                            $('.form-1').addClass('was-validated');
                            return false;
                        }
                        if (!$('#validation-t-pwd').val()) {
                            $('#validation-t-pwd').focus();
                            $('.form-1').addClass('was-validated');
                            return false;
                        }
                    }
                    if (index == 2) {
                        if (!$('#validation-t-address').val()) {
                            $('#validation-t-address').focus();
                            $('.form-2').addClass('was-validated');
                            return false;
                        }
                    }
                }
            });
            $('#tabswizard').bootstrapWizard({
                'nextSelector': '.button-next',
                'previousSelector': '.button-previous',
            });
            $('#verticalwizard').bootstrapWizard({
                'nextSelector': '.button-next',
                'previousSelector': '.button-previous',
            });
        });
    </script>
    <script type="text/javascript">
        $('#jhs_completion_year').datepicker({
            format: "yyyy",
            endDate: "31/12/2024",
            startView: 2,
            minViewMode: 2,
            autoclose: true,
            calendarWeeks: true

        });
    </script>

    <script>
        function printData() {
            var divToPrint = document.getElementById("printTable");
            newWin = window.open("");
            newWin.document.write(divToPrint.outerHTML);
            newWin.print();
            newWin.close();
        }
        $('.btn-print-invoice').on('click', function() {
            printData();
        })
    </script>

    <script>
        $(document).ready(function() {
            $("#datepicker").datepicker({
                format: "yyyy",
                viewMode: "years",
                minViewMode: "years",
                autoclose: true
            });
        })
    </script>
@endsection
