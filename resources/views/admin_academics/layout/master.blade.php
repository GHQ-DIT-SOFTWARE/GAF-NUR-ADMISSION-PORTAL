<!DOCTYPE html>
<html lang="en">

<head>
    <title>GAF | BCCC LMS</title>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta content="GAF | BCCC LMS" name="description" />
    <meta content="GAF | BCCC LMS" name="author" />
    <!-- Favicon icon -->
    <link rel="icon" href="{{ asset('gaflogo.png') }}" type="image/x-icon">
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/22b05698b3.js" crossorigin="anonymous"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <!-- Vendor CSS -->
    <link rel="stylesheet" href="{{ asset('backend/assets/css/style.css') }}">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('backend/assets/css/ui/_buttons.scss') }}">
    <link rel="stylesheet" type="text/css"href=" https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-yH2zHd5M9iRW5jj/mhFn4HIZfSRa5TH4+VSpC5JAwJkkFZWpY9TWuhjxPZXGZg2cmFb1kgP9wliQ6BVwVqnA5w==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body>
    <!-- Pre-loader -->
    
    <!-- Navigation menu -->
    @include('admin.layout.nav')

    <!-- Header -->
    @include('admin.layout.header')

    <!-- Main Content -->
    @yield('main')

    <!-- Required Js -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="{{ asset('backend/assets/js/vendor-all.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/plugins/bootstrap.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/ripple.js') }}"></script>
    <script src="{{ asset('backend/assets/js/pcoded.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/menu-setting.min.js') }}"></script>

    <!-- DataTables -->
    <script src="{{ asset('backend/assets/js/plugins/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/plugins/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Toastr -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript">
        setTimeout(function() {
            $('#simpletable').DataTable();
        }, 600);
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/notify/0.4.2/notify.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        @if (Session::has('message'))
            var type = "{{ Session::get('alert-type', 'info') }}"
            switch (type) {
                case 'info':
                    toastr.info(" {{ Session::get('message') }} ");
                    break;

                case 'success':
                    toastr.success(" {{ Session::get('message') }} ");
                    break;

                case 'warning':
                    toastr.warning(" {{ Session::get('message') }} ");
                    break;
                case 'error':
                    toastr.error(" {{ Session::get('message') }} ");
                    break;
            }
        @endif
    </script>

    <script type="text/javascript">
        $(function() {
            $(document).on('click', '#delete', function(e) {
                e.preventDefault();
                var link = $(this).attr("href");
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Delete This Data?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = link
                        Swal.fire(
                            'Deleted!',
                            'Your file has been deleted.',
                            'success'
                        )
                    }
                })
            });

        });
    </script>

    {{-- <script type="text/javascript">
        $(function() {
            // Deletion confirmation
            $(document).on('click', '#delete', function(e) {
                e.preventDefault();
                var link = $(this).attr("href");
                Swal.fire({
                    title: "Are you sure?",
                    text: "Delete This Data?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = link;
                        Swal.fire("Deleted!", "Your file has been deleted.", "success");
                    }
                });
            });

            // DataTable initialization
            $('#report-table').DataTable();

            // Toastr notifications
            @if (Session::has('message'))
                var type = "{{ Session::get('alert-type', 'info') }}";
                toastr[type]("{{ Session::get('message') }}");
            @endif
        });
    </script> --}}
</body>

</html>
