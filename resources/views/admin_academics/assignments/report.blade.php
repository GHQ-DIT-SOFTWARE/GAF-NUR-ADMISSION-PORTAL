@extends('admin.layout.master')
@section('content')
            <div class="page-header">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h5 class="m-b-10">Assignment Reports</h5>
                            </div>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="feather icon-home"></i></a></li>
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="#">Assignment Reports</a></li>
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
                    flex: 1;
                    min-width: 150px;
                    padding: 10px;
                    font-size: 16px;
                    border: 1px solid #ddd;
                    border-radius: 5px;
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
                }

                .form-button:hover {
                    background-color: #0056b3;
                }
            </style>

            <div class="row justify-content-center">
                <div class="col-sm-12">
                    <div class="card user-profile-list">
                        <div class="card-body">
                            <b>Filter Assignment(s)</b>
                            <form id="assignment-form" class="form-container-row">
                                @csrf
                                <select class="form-input" name="category_id" id="categorySelect" required>
                                    <option value="">--Select Category--</option>
                                    @foreach($category as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->category_name }}</option>
                                    @endforeach
                                </select>

                                <select class="form-input" name="subject_id" id="subjectSelect" required>
                                    <option value="">--Select Subject--</option>
                                </select>

                                <input class="form-input" type="date" name="start_date" required />
                                <input class="form-input" type="date" name="end_date" required />
                                <button class="form-button" type="submit">Filter</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Table for displaying assignments -->
            <div class="row justify-content-center">
                <div class="col-sm-12">
                    <div class="card user-profile-list">
                        <div class="card-body">
                            <b>Assignments (<span id="assignment-count">0</span>)</b>
                            <table id="assignments-table" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Assignment ID</th>
                                        <th>Name</th>
                                        <th>Category</th>
                                        <th>Subject</th>
                                        <th>Created On</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

    <script>
        $(document).ready(function() {
    $("#categorySelect").change(function() {
        let categoryId = $(this).val();
        if (categoryId) {
            $.ajax({
                url: "/api/get-subjects",
                method: "GET",
                data: { category_id: categoryId },
                dataType: "json",  // Ensure JSON response
                success: function(response) {
                    let subjectSelect = $("#subjectSelect");
                    subjectSelect.empty();
                    subjectSelect.append('<option value="">--Select Subject--</option>');
                    if (response.length > 0) {
                        response.forEach(subject => {
                            subjectSelect.append(`<option value="${subject.id}">${subject.subject_name}</option>`);
                        });
                    } else {
                        subjectSelect.append('<option value="">No subjects found</option>');
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching subjects:", xhr.responseText);
                }
            });
        } else {
            $("#subjectSelect").empty().append('<option value="">--Select Subject--</option>');
        }
    });
});

    </script>
@endsection
