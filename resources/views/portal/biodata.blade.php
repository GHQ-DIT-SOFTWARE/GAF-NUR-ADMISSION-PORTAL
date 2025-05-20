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
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
    {{-- 18570a --}}
    <body class="" >
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
                                                            style="color: white;">Save & Logout</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </nav>
                                </div>
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.html"><i class="feather icon-home"></i></a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="#!">COURSE:
                                            {{ $applied_applicant->cause_offers }}</a></li>
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
                                     WELCOME TO GHANA ARMED FORCES  COLLEGE OF NURSING AND MIDWIFERY ONLINE PORTAL
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
                                        <li class="nav-item"><a href="#b-w-tab1" class="nav-link active"
                                                data-toggle="tab">BIO DATA DETAILS</a></li>
                                    </ul>
                                    <div id="bar" class="bt-wizard progress mb-3" style="height:6px">
                                        <div class="progress-bar bg-success" role="progressbar" aria-valuenow="0"
                                            aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
                                    </div>
                                    <div class="tab-content">
                                        <div class="tab-pane active show" id="b-w-tab1" style="text-align: right">
                                            <form id="form1" action="{{ route('saveBioData') }}"
                                                method="POST"enctype="multipart/form-data">
                                                @csrf
                                                <div class="form-group row">
                                                    @php
                                                        $imagePath = public_path($applied_applicant->applicant_image);
                                                    @endphp
                                                    <div class="col-md-2 border-right">
                                                        <div
                                                            class="d-flex flex-column align-items-center text-center p-1 py-5">
                                                            @if ($applied_applicant->applicant_image == null)
                                                                <img id="showImage"
                                                                    src="{{ url('uploads/profile_image.png') }}"alt=""
                                                                    class="rounded-circle mt-2" height="150px"
                                                                    width="150px">
                                                            @elseif(file_exists($imagePath))
                                                                <img id="showImage"
                                                                    src="{{ asset($applied_applicant->applicant_image) }}"
                                                                    alt="" class="rounded-circle mt-2"
                                                                    height="150px" width="150px">
                                                            @endif
                                                            <span class="font-weight-bold">Passport Picture</span>
                                                            <div class="form-group row">
                                                                <div class="input_container">
                                                                    <input name="applicant_image" class="form-control"
                                                                        type="file" id="image" accept=".jpg, .png">
                                                                    @error('applicant_image')
                                                                        <div class="alert alert-danger mt-2">
                                                                            {{ $message }} Please upload a valid file
                                                                            (jpg,png).
                                                                        </div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-10">
                                                        <div class="form-group row">
                                                            <label for="b-t-name"
                                                                class="col-sm-2 col-form-label">Surname</label>
                                                            <div class="col-sm-2">
                                                                <input type="text" class="form-control" id="surname"
                                                                    name="surname" placeholder=""
                                                                    value="{{ old('surname', $applied_applicant->surname) }}">
                                                                @error('surname')
                                                                    <span class="text-danger">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                            <label for="b-t-name" class="col-sm-2 col-form-label">Other
                                                                Name(s)</label>
                                                            <div class="col-sm-2">
                                                                <input type="text" class="form-control"
                                                                    id="other_names" name="other_names" placeholder=""
                                                                    value="{{ old('other_names', $applied_applicant->other_names) }}">
                                                                @error('other_names')
                                                                    <span class="text-danger">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                            <label for="b-t-name"
                                                                class="col-sm-2 col-form-label">Sex</label>
                                                            <div class="col-sm-2">
                                                                <select class="form-control required" id="sex"
                                                                    name="sex">
                                                                    <option value="">Select</option>
                                                                    <option value="MALE"
                                                                        {{ old('sex', $applied_applicant->sex) == 'MALE' ? 'selected' : '' }}>
                                                                        MALE</option>
                                                                    <option value="FEMALE"
                                                                        {{ old('sex', $applied_applicant->sex) == 'FEMALE' ? 'selected' : '' }}>
                                                                        FEMALE</option>
                                                                </select>
                                                                @error('sex')
                                                                    <span class="text-danger">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                        </div>


                                                        <div class="form-group row">
                                                            <label for="b-t-name" class="col-sm-2 col-form-label">Marital
                                                                Status</label>
                                                            <div class="col-sm-2">
                                                                <select class="form-control required" id="marital_status"
                                                                    name="marital_status">
                                                                    <option value="">Choose option</option>
                                                                    <option value="SINGLE"
                                                                        {{ old('marital_status', $applied_applicant->marital_status) == 'SINGLE' ? 'selected' : '' }}>
                                                                        SINGLE</option>
                                                                    <option value="MARRIED"
                                                                        {{ old('marital_status', $applied_applicant->marital_status) == 'MARRIED' ? 'selected' : '' }}>
                                                                        MARRIED</option>
                                                                    <option value="DIVORSED"
                                                                        {{ old('marital_status', $applied_applicant->marital_status) == 'DIVORSED' ? 'selected' : '' }}>
                                                                        DIVORSED</option>
                                                                </select>
                                                                @error('marital_status')
                                                                    <span class="text-danger">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                            <label for="b-t-name" class="col-sm-2 col-form-label">National
                                                                ID (Ghana Card)</label>
                                                            <div class="col-sm-2">
                                                                <input type="text" class="form-control"
                                                                    class="required" id="national_identity_card"
                                                                    placeholder="" name="national_identity_card"
                                                                    value="{{ old('national_identity_card', $applied_applicant->national_identity_card) }}">
                                                                @error('national_identity_card')
                                                                    <span class="text-danger">{{ $message }}</span>
                                                                @enderror
                                                            </div>

                                                            <label for="b-t-name" class="col-sm-2 col-form-label">Date of
                                                                Birth</label>
                                                            <div class="col-sm-2">
                                                                <div class="form-group fill">
                                                                    <input type="date" class="form-control date-picker"
                                                                        id="date_of_birth" name="date_of_birth"
                                                                        value="{{ old('date_of_birth', $applied_applicant->date_of_birth) }}">
                                                                    @error('date_of_birth')
                                                                        <span class="text-danger">{{ $message }}</span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>


                                                        <div class="form-group row">
                                                            <label for="b-t-name"
                                                                class="col-sm-2 col-form-label">Telephone
                                                                Number</label>
                                                            <div class="col-sm-2">
                                                                <input type="text" class="form-control required"
                                                                    id="contact" name="contact"
                                                                    value="{{ old('contact', $applied_applicant->contact) }}"
                                                                    readonly>
                                                                @error('contact')
                                                                    <span class="text-danger">{{ $message }}</span>
                                                                @enderror
                                                            </div>

                                                            <label for="b-t-name" class="col-sm-2 col-form-label">Email
                                                                Address</label>
                                                            <div class="col-sm-3">
                                                                <input type="text" class="form-control required"
                                                                    id="email" name="email"
                                                                    value="{{ old('email', $applied_applicant->email) }}">
                                                                @error('email')
                                                                    <span class="text-danger">{{ $message }}</span>
                                                                @enderror
                                                            </div>

                                                        </div>
                                                        <div class="form-group row">
                                                            <label for="b-t-name"
                                                                class="col-sm-2 col-form-label">Residential Address</label>
                                                            <div class="col-sm-4">
                                                                <input type="text" class="form-control"
                                                                    id="residential_address" name="residential_address"
                                                                    value="{{ old('residential_address', $applied_applicant->residential_address) }}">
                                                                @error('residential_address')
                                                                    <span class="text-danger">{{ $message }}</span>
                                                                @enderror
                                                            </div>

                                                            <label for="b-t-name" class="col-sm-2 col-form-label">Digital
                                                                Address</label>
                                                            <div class="col-sm-4">
                                                                <input type="text" class="form-control"
                                                                    id="digital_address" name="digital_address"
                                                                    value="{{ old('digital_address', $applied_applicant->digital_address) }}">
                                                                @error('digital_address')
                                                                    <span class="text-danger">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <label for="languages" class="col-sm-2 col-form-label">Language(s) Spoken</label>
                                                            <div class="col-sm-5">
                                                                <select class="form-control" multiple="multiple" id="languages" name="language[]">
                                                                    @foreach ($ghanaian_languages as $language)
                                                                        <option value="{{ $language }}"
                                                                            {{ in_array($language, old('language', $applied_applicant->language ?? [])) ? 'selected' : '' }}>
                                                                            {{ $language }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                                @error('language')
                                                                    <span class="text-danger">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                            <input type="hidden" id="hidden_disability_reason" name="disability_reason" value="{{ old('disability_reason', $applied_applicant->disability_reason ?? '') }}">
                                                            <!-- Disability Status Dropdown -->
                                                            <label for="b-t-name" class="col-sm-2 col-form-label">Do you have a disability?</label>
                                                            <div class="col-sm-2">
                                                                <select class="form-control required" id="disability_status" name="disability_status">
                                                                    <option value="">Choose option</option>
                                                                    <option value="YES" {{ old('disability_status', $applied_applicant->disability_status) == 'YES' ? 'selected' : '' }}>YES</option>
                                                                    <option value="NO" {{ old('disability_status', $applied_applicant->disability_status) == 'NO' ? 'selected' : '' }}>NO</option>
                                                                </select>
                                                                @error('disability_status')
                                                                    <span class="text-danger">{{ $message }}</span>
                                                                @enderror
                                                            </div>

                                                            <!-- Edit Reason Button (Only visible when a reason is set) -->
                                                            <div id="edit_reason_section" class="mt-2" style="display: none;">
                                                                <button type="button" id="edit_reason" class="btn btn-sm btn-primary">Edit Disability Reason</button>
                                                            </div>
                                                        </div>
                                                        <hr>
                                                        <button type="submit" class="btn btn-primary save-btn"
                                                            style="float: right;" id="saveBioData">Next</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="disabilityReasonModal" tabindex="-1" role="dialog" aria-labelledby="disabilityReasonLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="disabilityReasonLabel">Specify Disability</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <textarea id="disability_reason" class="form-control" rows="3" name="disability_reason">{{ $applied_applicant->disability_reason}}</textarea>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" id="saveDisabilityReason">Save</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Hidden Field to Store Disability Reason -->
<input type="hidden" id="hidden_disability_reason" name="disability_reason" value="{{ old('disability_reason', $applied_applicant->disability_reason ?? '') }}">
                <!-- Disability Status Dropdown -->
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>


    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let disabilityStatus = document.getElementById("disability_status");
            let disabilityReasonModal = new bootstrap.Modal(document.getElementById("disabilityReasonModal"));
            let disabilityReasonInput = document.getElementById("disability_reason");
            let hiddenDisabilityReason = document.getElementById("hidden_disability_reason");
            let editReasonBtn = document.getElementById("edit_reason");
            let editReasonSection = document.getElementById("edit_reason_section");

            // Function to show/hide the Edit Reason button
            function updateEditButton() {
                if (hiddenDisabilityReason.value.trim()) {
                    editReasonSection.style.display = "block";
                } else {
                    editReasonSection.style.display = "none";
                }
            }

            // Open modal when "YES" is selected
        disabilityStatus.addEventListener("change", function () {
    if (this.value === "YES") {
        if (!hiddenDisabilityReason.value.trim()) {
            disabilityReasonInput.value = ""; // Reset if no previous reason
            disabilityReasonModal.show();
        }
    } else {
        hiddenDisabilityReason.value = ""; // Clear reason if "NO" is selected
        updateEditButton();
    }
});


            // Save reason when modal closes
            document.getElementById("saveDisabilityReason").addEventListener("click", function () {
                hiddenDisabilityReason.value = disabilityReasonInput.value.trim(); // Store value in hidden input
                updateEditButton();
                disabilityReasonModal.hide();
            });

            // Open modal when Edit button is clicked
            editReasonBtn.addEventListener("click", function () {
                disabilityReasonInput.value = hiddenDisabilityReason.value; // Load saved reason
                disabilityReasonModal.show();
            });

            // Show the edit button if a reason already exists
            updateEditButton();

            // Automatically open modal if "YES" was selected before page reload
            if (disabilityStatus.value === "YES" && hiddenDisabilityReason.value) {
                updateEditButton();
            }
        });
    </script>

    <style>
        /* Change text color of selected options */
        .select2-selection__choice {
            color: red !important;
            font-weight: bold;
        }
    </style>

    <!-- Initialize Select2 -->
    <script>
        $(document).ready(function() {
            $('#languages').select2({
                placeholder: "Select languages",
                allowClear: true
            });
        });
    </script>
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
        document.addEventListener("DOMContentLoaded", function () {
            // Get the current date in YYYY-MM-DD format
            let today = new Date().toISOString().split("T")[0];

            // Apply max date to all date inputs
            document.querySelectorAll(".date-picker").forEach(function (input) {
                input.setAttribute("max", today); // Set max attribute to prevent future dates

                input.addEventListener('keydown', function (event) {
                    event.preventDefault(); // Prevent manual typing
                });
            });
        });
    </script>
{{-- <script>
    // Select all inputs with class "date-picker" and disable manual typing
    document.querySelectorAll('.date-picker').forEach(function (input) {
        input.addEventListener('keydown', function (event) {
            event.preventDefault(); // Prevent typing
        });
    });
</script> --}}


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
