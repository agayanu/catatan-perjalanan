<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Catatan Perjalanan</title>
    <link rel="shortcut icon" href="{{asset('logo/favicon.png')}}" type="image/x-icon">
    <link rel="stylesheet" href="{{asset('coreui/css/coreui.min.css')}}">
    <link rel="stylesheet" href="{{asset('coreui/simplebar/simplebar.min.css')}}">
    <link rel="stylesheet" href="{{asset('@coreui/icons/css/all.min.css')}}">
    @include('layouts.app-style')
    @yield('header')
</head>
<body>
    <div class="sidebar sidebar-dark sidebar-fixed" id="sidebar">
        <div class="sidebar-brand d-none d-md-flex">
            <img class="sidebar-brand-full" width="55" height="46" src="{{ asset('logo/favicon.png') }}" alt="Pesat Logo"/>
            <img class="sidebar-brand-narrow" width="46" height="46" src="{{ asset('logo/favicon.png') }}" alt="Pesat Logo"/>
        </div>
        <ul class="sidebar-nav" data-coreui="navigation" data-simplebar="">
            @include('layouts.menu')
        </ul>
        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
            {{ csrf_field() }}
        </form>
        <button class="sidebar-toggler" type="button" data-coreui-toggle="unfoldable"></button>
    </div>
    <div class="wrapper d-flex flex-column min-vh-100 bg-light">
        <header class="header header-sticky mb-4">
            <div class="container-fluid">
                <button class="header-toggler px-md-0 me-md-3" type="button"
                    onclick="coreui.Sidebar.getInstance(document.querySelector('#sidebar')).toggle()">
                    <i class="nav-icon icon-lg cil-menu"></i>
                </button>
                <a class="header-brand d-md-none" href="{{ url('/') }}">
                    <img class="sidebar-brand-full" width="55" height="46" src="{{ asset('logo/favicon.png') }}" alt="Pesat Logo"/><div class="logoatt">PESAT</div>
                </a>
            </div>
        </header>
        <div class="body flex-grow-1 px-3">
            <div class="container">
            @yield('content')
            </div>
        </div>
        <footer class="footer">
            <div class="footer-item"><a href="{{url('/')}}">Catatan Perjalanan</a> © 2022 Departemen TIK.</div>
            <div class="ms-auto footer-item">Powered by&nbsp;<a href="https://smapluspgri.sch.id">PESAT</a></div>
        </footer>
    </div>
    @yield('footer')
    <script src="{{asset('coreui/js/coreui.bundle.min.js')}}"></script>
    <script src="{{asset('coreui/simplebar/simplebar.min.js')}}"></script>
</body>
</html>