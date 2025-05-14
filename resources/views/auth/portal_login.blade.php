<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content=""/>
    <title>PORTAL | {{ config('app.name') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="{{ config('app.name') }}" name="description" />
    <meta content="{{ config('app.name') }}" name="author" />
    <link rel="icon" href="{{ asset('logo-icon.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
</head>
<div class="auth-wrapper align-items-stretch aut-bg-img">
    <div class="flex-grow-1">
        @if($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
{{-- <div class="h-100 d-md-flex align-items-center auth-side-img">
    <div class="col-sm-10 auth-content w-auto" style="background-color: #0cbc6d;">
        <h1 class="text-white my-4">General Requirement</h1>
        <ul class="text-white">
            <li>Kindly <b><a href="https://apply.mil.gh/" class="text-white"><u>read</u></a></b> the general eligibility before
                applying.</li>
            <li>Once <b>Submitted</b>, the information provided <b>cannot</b> be changed</li>
            <li>If at any point during the application process, an applicant decides not to continue , simply
                close the page to discontinue without submitting. Applications are only saved when the submit
                button is clicked.
            </li>
            <li>Once a scratch card is used for application, it cannot be reused.</li>
            <li>
                ENTRY REQUIREMENT FOR ADMISSION INTO NURSING AND MIDWIFERY TRAINING INSTITUTIONS
                (BASIC PROGRAMMES: RGN, RM, RCN/PHN, RMN, RCPN)
                <ul>
                    <li>An Aggregate Score of thirty–six (36) or better comprising (A1 – C6) in three (3) Core Subjects i.e. ENGLISH, MATHEMATICS and INTEGRATED SCIENCE and in three elective Subjects (A1 – C6) in any of the following programmes itemized below.</li>
                    <li>NB:
                        <ul>
                            <li>Applicants must be 16–35 years old</li>
                            <li>Applicants who are above 35 years must be serving officers with letters from employers</li>
                            <li>A combination of SSSCE and WASSCE results are not acceptable</li>
                            <li>Applicants for Top-up programmes must have served for 3 years post auxiliary training with valid license</li>
                            <li><strong>PROVISIONAL RESULTS</strong> were instructed to be uploaded</li>
                            <li><strong>Certified/verified results</strong> from WAEC will be accepted</li>
                            <li><strong>Passport picture requirement:</strong> in uniform, red background, 200KB size</li>
                            <li>All documents must be in PDF</li>
                            <li>Copy of Ghana Card/NHIA/Voter's ID</li>
                            <li>Date of birth and name inconsistencies cannot be verified</li>
                        </ul>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</div> --}}


        <div class="auth-side-form">
            <form method="post" action="{{ route('portal.apply') }}">
                @csrf
                 <div style="text-align: center;">
                        {{-- <h3 class="mb-4 f-w-400">Sign in with your serial number and Pincode</h3> --}}
                        <img src="{{ asset('03.png') }}" alt=""
                             style=" width: 150px; height: 150px; object-fit: cover;">
                    </div>
                <div class=" auth-content">
                    <div class="form-group mb-3">
                        <label class="floating-label" for="serial_number">Serial Number</label>
                        <input type="text" class="form-control @error('serial_number') is-invalid @enderror"
                            id="serial" name="serial_number" placeholder="">
                        @error('serial_number')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group mb-4">
                        <label class="floating-label" for="pincode">Pincode</label>
                        <input type="pincode" class="form-control @error('pincode') is-invalid @enderror" name="pincode"
                            id="pincode" placeholder="">
                        @error('pincode')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group mb-4">
                        <label class="floating-label" for="contact">Contact</label>
                        <input type="contact" class="form-control @error('contact') is-invalid @enderror" name="contact"
                            id="contact" placeholder="">
                        @error('contact')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>


                    <div class="form-group mb-4">
                        <select class="form-control" id="arm_of_service" name="cause_offers" required>
                            <option value="">SELECT COURSE</option>
                            @foreach ($arms as $list)
                                <option value="{{$list->cause_offers }}">{{$list->cause_offers }}</option>
                            @endforeach
                        </select>

                        @error('cause_offers')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    </div>
                    <button type="submit" class="btn btn-block btn-primary mb-4">Submit</button>
                    <p class="mb-2 text-muted">Forgot to Print Summary Sheet? <a
                            href="{{ route('print-summary-sheet') }}" class="f-w-400">Print</a></p>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="{{ asset('assets/js/vendor-all.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/ripple.js') }}"></script>
<script src="{{ asset('assets/js/pcoded.min.js') }}"></script>
</body>

</html>
