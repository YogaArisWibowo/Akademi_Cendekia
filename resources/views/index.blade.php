<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ auth()->user()->role }} - @yield('title')</title>
</head>

<!-- Main Style -->
@include('layouts.style')

<body class="hold-transition sidebar-mini layout-fixed sidebar-collapse" style="background-color: #D9D9D9;">

    <!-- Navbar -->
    @include('layouts.navbar')
    <!-- /.navbar -->

    <!-- Sidebar -->
    @if (auth()->user()->role == 'admin')
    @include('layouts.sidebar.sidebar_admin')
    @endif

    @if (auth()->user()->role == 'perusahaan')
    @include('layouts.sidebar.sidebar_mitra')
    @endif

    @if (auth()->user()->role == 'dosen')
    @include('layouts.sidebar.sidebar_dpl')
    @endif

    @if (auth()->user()->role == 'mahasiswa')
    @include('layouts.sidebar.sidebar_mhs')
    @endif
    <!-- /.sidebar -->

    <!-- Content Wrapper. Contains page content -->
    @yield('content')
    <!-- /.content-wrapper -->

    <!-- Main JS -->
    @include('layouts.script')

</body>

</html>