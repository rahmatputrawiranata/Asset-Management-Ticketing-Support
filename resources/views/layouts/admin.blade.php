<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Laravel SB Admin 2">
    <meta name="author" content="Alejandro RH">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <link href='https://api.mapbox.com/mapbox-gl-js/v1.12.0/mapbox-gl.css' rel='stylesheet' />
    <link rel="stylesheet" href="{{asset('vendor/datatables/dataTables.bootstrap4.min.css')}}">
    <link
        rel="stylesheet"
        href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.5.1/mapbox-gl-geocoder.css"
        type="text/css"
        />
    <!-- Custom Styles for spesific pages -->
    <style>
        canvas.mapboxgl-canvas {
            width: 100% !important;
        }
    </style>

    @stack('styles')


    <!-- Favicon -->
    <link href="{{ asset('img/favicon.png') }}" rel="icon" type="image/png">
</head>
<body id="page-top">

<!-- Page Wrapper -->
<div id="wrapper">

    @include('layouts.admin.sidebar')
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

            @include('layouts.admin.nav')

            <!-- Begin Page Content -->
            <div class="container-fluid">

                @yield('main-content')

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->

        @include('layouts.admin.footer')

    </div>
    <!-- End of Content Wrapper -->

</div>

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('Ready to Leave?') }}</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
            <div class="modal-footer">
                <button class="btn btn-link" type="button" data-dismiss="modal">{{ __('Cancel') }}</button>
                <a class="btn btn-danger" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>
<script src="{{ asset('js/sb-admin-2.min.js') }}"></script>


<script src='https://api.mapbox.com/mapbox-gl-js/v1.12.0/mapbox-gl.js'></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script src="{{asset('vendor/datatables/jquery.dataTables.min.js')}}" ></script>
<script src="{{asset('vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
<script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.5.1/mapbox-gl-geocoder.min.js"></script>


<script>
    $(document).ready(function() {
        $('.select2').select2({

        });
    })


    function optionData(url, id, selected = null) {
        var el = id;
        $.ajax({
            url : url,
            method : 'GET',
            beforeSend : function() {
                if(selected !== null) {
                    $(el).html('<option disabled="disabled" value="0">Chose Data</option>')
                }else{
                    $(el).html('<option selected="true" disabled="disabled">Choose Data</option>')
                }
            },
            success : function(res) {
                let data = res.data;
                data.forEach(element => {
                    if(selected !== null && element.value === selected) {
                        $(el).append('<option value="' + element.value + '" selected="selected">' + element.title + '</option>')
                    }else{
                        $(el).append('<option value="' + element.value + '">' + element.title + '</option>')
                    }
                });
            }
        })
    }

</script>

<!-- Custom Plugin -->

@stack('plugins')
<scrip src="{{ asset('js/core.js') }}"></scrip>
</body>
</html>
