<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Sacrosys</title>

    @php
        $path = asset('/');
    @endphp
    <!-- Global stylesheets -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
    <link href="{{ $path }}global_assets/css/icons/icomoon/styles.min.css" rel="stylesheet" type="text/css">
    <link href="{{ $path }}assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="{{ $path }}assets/css/bootstrap_limitless.min.css" rel="stylesheet" type="text/css">
    <link href="{{ $path }}assets/css/layout.min.css" rel="stylesheet" type="text/css">
    <link href="{{ $path }}assets/css/components.min.css" rel="stylesheet" type="text/css">
    <link href="{{ $path }}assets/css/colors.min.css" rel="stylesheet" type="text/css">
    <!-- /global stylesheets -->

    <!-- Core JS files -->
    <script src="{{ $path }}global_assets/js/main/jquery.min.js"></script>
    <script src="{{ $path }}global_assets/js/main/bootstrap.bundle.min.js"></script>
    <script src="{{ $path }}global_assets/js/plugins/loaders/blockui.min.js"></script>
    <!-- /core JS files -->

    <!-- Theme JS files -->
    <script src="{{ $path }}global_assets/js/plugins/tables/datatables/datatables.min.js"></script>
    <script src="{{ $path }}global_assets/js/plugins/forms/selects/select2.min.js"></script>

	<script src="{{ $path }}global_assets/js/plugins/forms/styling/uniform.min.js"></script>

	<script src="{{ $path }}global_assets/js/demo_pages/form_layouts.js"></script>

    <script src="{{ $path }}global_assets/js/plugins/notifications/pnotify.min.js"></script>


    <script src="{{ $path }}assets/js/app.js"></script>
    <script src="{{ $path }}global_assets/js/demo_pages/datatables_basic.js"></script>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCbF9O9Ks9_-QNWHi2SFxLqLUBOwrMyzXk"></script>

    <script src="{{ $path }}global_assets/js/demo_maps/google/basic/basic.js"></script>
	<script src="{{ $path }}global_assets/js/demo_maps/google/basic/geolocation.js"></script>
	<script src="{{ $path }}global_assets/js/demo_maps/google/basic/coordinates.js"></script>
	<script src="{{ $path }}global_assets/js/demo_maps/google/basic/click_event.js"></script>

</head>

<body>

    <!-- Page content -->
    <div class="page-content">

        <!-- Main content -->
        <div class="content-wrapper">

            <!-- Page header -->
            <div class="page-header page-header-light">
                <div class="page-header-content header-elements-md-inline">
                    <div class="page-title d-flex">
                    </div>
                </div>

                <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
                    <div class="d-flex">
                        <div class="breadcrumb">
                            <a href="/" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Home</a>
                            <span class="breadcrumb-item active">@yield('title')</span>
                        </div>

                        <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
                    </div>
                </div>
            </div>
            <!-- /page header -->


            @yield('content')

            @include('template.footer')

            <script>
                $(document).ready(function() {
                    var sessionData = <?php echo json_encode(session()->all()); ?>;
                    if (sessionData.success) {
                        new PNotify({
                            title: 'Success',
                            text: sessionData.success,
                            addclass: 'bg-success border-success'
                        });
                    }
                    if (sessionData.error) {
                        new PNotify({
                            title: 'Error !',
                            text: sessionData.error,
                            addclass: 'bg-danger border-danger'
                        });
                    }
                });
            </script>

        </div>
        <!-- /main content -->

    </div>
    <!-- /page content -->

</body>

</html>
