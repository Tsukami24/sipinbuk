<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Admin Dashboard')</title>

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- DataTables --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">


    <style>
        body {
            background-color: #F8F9FA;
            color: #0B132B;
        }

        .admin-sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 260px;
            background-color: #0B132B;
            padding: 20px;
            overflow-y: auto;
        }

        .admin-sidebar .brand {
            font-size: 1.2rem;
            font-weight: 700;
            color: #74C69D;
            margin-bottom: 1.5rem;
            display: block;
            text-decoration: none;
        }

        .admin-sidebar .nav-link {
            color: #F8F9FA;
            border-radius: 6px;
            padding: 10px 12px;
            margin-bottom: 4px;
            transition: all 0.2s ease;
        }

        .admin-sidebar .nav-link:hover {
            background-color: rgba(116, 198, 157, 0.15);
            color: #74C69D;
        }

        .admin-sidebar .nav-link.active {
            background-color: #2D6A4F !important;
            color: #F8F9FA !important;
            font-weight: 600;
        }

        .admin-content {
            margin-left: 260px;
            padding: 24px;
        }

        table.dataTable thead th {
            background-color: #0B132B !important;
            color: #F8F9FA !important;
            border-color: #2D6A4F !important;
        }

        table.dataTable tbody tr {
            background-color: #F8F9FA;
        }

        table.dataTable tbody tr:hover {
            background-color: rgba(116, 198, 157, 0.2);
        }

        .dataTables_wrapper .pagination .page-item.active .page-link {
            background-color: #2D6A4F;
            border-color: #2D6A4F;
            color: #fff;
        }

        .dataTables_wrapper .pagination .page-link {
            color: #0B132B;
        }

        .dataTables_wrapper .pagination .page-link:hover {
            background-color: #74C69D;
            color: #0B132B;
        }

        .dataTables_wrapper .dataTables_filter input,
        .dataTables_wrapper .dataTables_length select {
            border-radius: 6px;
            border: 1px solid #2D6A4F;
        }

        .dataTables_wrapper .dataTables_info {
            color: #0B132B;
            font-weight: 500;
        }

        .dropdown-menu .dropdown-item.active,
        .dropdown-menu .dropdown-item:active,
        .dropdown-menu .dropdown-item:focus,
        .dropdown-menu .dropdown-item:focus-visible {
            background-color: #2D6A4F !important;
            color: #F8F9FA !important;
        }

        .dropdown-menu .dropdown-item:hover {
            background-color: rgba(116, 198, 157, 0.25) !important;
            color: #0B132B !important;
        }

        .dropdown-menu .dropdown-item.text-danger.active,
        .dropdown-menu .dropdown-item.text-danger:active {
            background-color: rgba(220, 53, 69, 0.2) !important;
            color: #DC3545 !important;
        }

        /* =============================
   FORM FOCUS THEME
============================= */
        .form-control:focus,
        .form-select:focus {
            border-color: #2D6A4F !important;
            box-shadow: 0 0 0 0.2rem rgba(45, 106, 79, 0.25) !important;
        }

        input[type="file"]:focus {
            box-shadow: none !important;
            border-color: #2D6A4F !important;
        }

        /* =============================
   FORM THEME - NO BLUE
============================= */
        .form-control:focus,
        .form-select:focus {
            border-color: #2D6A4F !important;
            box-shadow: 0 0 0 0.2rem rgba(45, 106, 79, 0.25) !important;
            outline: none !important;
        }

        /* =============================
   SELECT OPTION FIX (KILL BLUE)
============================= */
        .form-select option:checked,
        .form-select option:active {
            background-color: #2D6A4F !important;
            color: #fff !important;
        }

        .form-select option:hover {
            background-color: rgba(45, 106, 79, 0.2) !important;
            color: #0B132B !important;
        }

        .form-select {
    background-color: #fff;
    color: #0B132B;
}

.form-select:focus {
    border-color: #2D6A4F !important;
    box-shadow: 0 0 0 0.15rem rgba(45, 106, 79, 0.25) !important;
}


        /* =============================
   TEXT SELECTION
============================= */
        ::selection {
            background-color: rgba(45, 106, 79, 0.35);
            color: #0B132B;
        }

        ::-moz-selection {
            background-color: rgba(45, 106, 79, 0.35);
            color: #0B132B;
        }

        /* =============================
   FIREFOX SELECT FIX
============================= */
        select:-moz-focusring {
            color: transparent;
            text-shadow: 0 0 0 #0B132B;
        }
    </style>
</head>

<body>

    {{-- Sidebar --}}
    @include('components.admin.sidebar')

    {{-- Content --}}
    <div class="admin-content">
        @yield('content')
    </div>

    {{-- JS --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

    @stack('scripts')
</body>

</html>
