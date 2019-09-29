<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>
        @yield('title')
    </title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:400,400i,700,700i,600,600i">
    <link rel="stylesheet" href="{{ asset('fonts/fontawesome-all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('fonts/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('fonts/simple-line-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('fonts/fontawesome5-overrides.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.10.0/baguetteBox.min.css">
    <link rel="stylesheet" href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/Map-Clean.css') }}">
    <link rel="stylesheet" href="{{ asset('css/smoothproducts.css') }}">
    <link rel="stylesheet" href="{{ asset('css/Testimonials.css') }}">

    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">
    <link rel="icon" href="{{ asset('') }}">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        @include('layouts.module.sidebar')

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                @include('layouts.module.topbar')

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    @yield('container')

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            @include('layouts.module.footer')

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>

    <!-- Page level plugins -->
    <script src="{{ asset('vendor/chart.js/Chart.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('js/demo/chart-area-demo.js') }}"></script>
    <script src="{{ asset('js/demo/chart-pie-demo.js') }}"></script>
    <script>
        $(document).ready(function(){
            $('#dataTable').DataTable();
            $(".custom-file-input").on("change", function() {
                var fileName = $(this).val().split("\\").pop();
                $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
            });
            $('.accessMenu').on('click', function() {
                const menuId = $(this).data('menu');
                const roleId = $(this).data('role');
                const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url: "{{ url('/change-access') }}",
                    type: 'post',
                    data: {
                        _token: CSRF_TOKEN,
                        menuId: menuId,
                        roleId: roleId
                    },
                    success: function() {
                        document.location.href = "{{ url('role') }}/" + roleId +"/edit";
                    }
                });
            });
            $('.editRole').on('click', function() {
                const id = $(this).data('id');
                const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                $('#newRoleModalLabel').html('Edit Role');
                $('#submitRole').html('Edit');
                $('#postRole').attr('action', "{{ url('role') }}/" + id);
                $('#method-role').val('patch');
                $.ajax({
                    url: "{{ url('getRole') }}/" + id,
                    method: 'post',
                    dataType: 'json',
                    data: {
                        _token: CSRF_TOKEN,
                        id: id
                    },
                    success: function(data) {
                        $('#role').val(data.role);
                    }
                });
            });
            $('.addRole').on('click', function() {
                $('#newRoleModalLabel').html('Add New Role');
                $('#submitRole').html('Add');
                $('#postRole').attr('action', "{{ route('role.store') }}");
                $('#method-role').val('post');
                $('#role').val('');
            });
            $('.editMenu').on('click', function() {
                const id = $(this).data('id');
                const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                $('#newMenuModalLabel').html('Edit Menu');
                $('#submitMenu').html('Edit');
                $('#postMenu').attr('action', "{{ url('menu') }}/" + id);
                $('#method-menu').val('patch');
                $.ajax({
                    url: "{{ url('/getMenu') }}",
                    method: 'post',
                    dataType: 'json',
                    data: {
                        _token: CSRF_TOKEN,
                        id: id
                    },
                    success: function(data) {
                        $('#menu').val(data.menu);
                    }
                });
            });
            $('.addMenu').on('click', function() {
                $('#newMenuModalLabel').html('Add New Menu');
                $('#submitMenu').html('Add');
                $('#postMenu').attr('action', "{{ route('menu.store') }}");
                $('#method-menu').val('post');
                $('#menu').val('');
            });
            $('.editSubMenu').on('click', function() {
                const id = $(this).data('id');
                const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                $('#newSubMenuModalLabel').html('Edit Submenu');
                $('#submitSubMenu').html('Edit');
                $('#postSubMenu').attr('action', "{{ url('submenu') }}/" + id);
                $('#method-submenu').val('patch');
                $.ajax({
                    url: "{{ url('/getSubmenu') }}",
                    method: 'post',
                    dataType: 'json',
                    data: {
                        _token: CSRF_TOKEN,
                        id: id
                    },
                    success: function(data) {
                        $('#title').val(data.title);
                        $('#menu_id').val(data.menu_id);
                        $('#url').val(data.url);
                        $('#icon').val(data.icon);
                        if (data.is_active == 1) {
                            $('#is_active').attr('checked', true);
                        } else {
                            $('#is_active').attr('checked', false);
                        }
                    }
                });
            });
            $('.addSubMenu').on('click', function() {
                $('#newSubMenuModalLabel').html('Add New Submenu');
                $('#submitSubMenu').html('Add');
                $('#postSubMenu').attr('action', "{{ route('submenu.store') }}");
                $('#title').val('');
                $('#menu_id').val('');
                $('#url').val('');
                $('#icon').val('');
                $('#is_active').attr('checked', false);
                $('#method-submenu').val('post');
            });
        });
    </script>
</body>

</html>