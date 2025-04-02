@extends('admin.layout.master')
@section('title')
    Personnels
@endsection

@section('main')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                {{-- <div class="panel-heading">
                    Carousel Slides Management
                    <a href="{{ route('admin.carousel.create') }}" class="btn btn-success mb-5 float-right">Add New
                        Slide</a>
                </div> --}}

                <div class="panel-body">
                    <div class="table-responsive">
                        <table id="personnels" class="table table-borderless">
                            <thead>
                                <tr>
                                    <th>SVC ID</th>
                                    <th>Rank</th>
                                    <th>Initials</th>
                                    <th>Gender</th>
                                    <th>Unit</th>
                                    <th>Level</th>
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#lantam').DataTable({
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
                    url: "{{ route('api.personnel.index') }}",
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
@endsection
