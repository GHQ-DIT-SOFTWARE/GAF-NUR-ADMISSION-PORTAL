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
                                <h5 class="m-b-10">Dashboard</h5>
                            </div>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#"><i class="feather icon-home"></i></a></li>
                                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
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
                                    <table id="personnels" class="table table-striped table-bordered nowrap"
                                        data-autoscroll>
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>SVC ID</th>
                                                <th>Rank</th>
                                                <th>Name</th>
                                                <th>Gender</th>
                                                <th>Unit</th>
                                                <th>Category</th>
                                                <th>Arm of Service</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <script src="https://code.jquery.com/jquery-3.6.0.min.js"
                integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
            <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
            <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
            <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
            <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
            <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
            <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
            <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.colVis.min.js"></script>

            <script>
                $(document).ready(function() {
                    $('#personnels').DataTable({
                        dom: "<'row'<'col-sm-2'l><'col'B><'col-sm-2'f>>" +
                            "<'row'<'col-sm-12'tr>>" +
                            "<'row'<'col-sm-6'i><'col-sm-6'p>>",
                        buttons: [
                            'colvis',
                            {
                                extend: 'copy',
                                text: 'Copy to clipboard'
                            },
                            'excel',
                        ],
                        scrollY: 960,
                        scrollCollapse: true,
                        processing: true,
                        serverSide: true,
                        lengthMenu: [
                            [15, 25, 50, 100, 200, -1],
                            [15, 25, 50, 100, 200, 'All'],
                        ],
                        ajax: {
                            url: "{{ route('api.personnels.index') }}",
                            type: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: function(d) {
                                var formData = $('#filter-form').serializeArray();
                                $.each(formData, function(index, item) {
                                    d[item.name] = item.value;
                                });
                            },
                        },
                        columns: [{
                                data: null,
                                orderable: false,
                                searchable: false,
                                render: function(data, type, full, meta) {
                                    return meta.row + 1;
                                }
                            },
                            {
                                data: 'service_no',
                                name: 'service_no'
                            },
                            {
                                data: 'rank',
                                name: 'rank'
                            },
                            {
                                data: 'initials',
                                name: 'initials'
                            },
                            {
                                data: 'sex',
                                name: 'sex'
                            },
                            {
                                data: 'unit',
                                name: 'unit'
                            },
                            {
                                data: 'level',
                                name: 'level'
                            },
                            {
                                data: 'arm_of_service',
                                name: 'arm_of_service'
                            },
                            {
                                data: 'action',
                                name: 'action',
                                orderable: false,
                                searchable: false
                            }
                        ],
                    });
                });
            </script>
        </div>
    </div>
@endsection
