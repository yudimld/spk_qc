<!DOCTYPE html>
<html lang="en">
    @extends('layouts.head')
    @section('title', 'Master Data PAC')
    <style>
        
        /* Responsiveness for tables with scroll */
        .table-responsive {
        width: 100% !important;
        overflow-x: auto; /* Enable horizontal scrolling */
        overflow-y: hidden; /* Hide vertical scrollbar */
        -webkit-overflow-scrolling: touch; /* Smooth scrolling for touch devices */
        white-space: nowrap !important; /* Prevent text from wrapping in table cells */
        }

        /* Default table layout */
        .table {
        table-layout: auto; /* Columns adjust based on content */
        width: 100%; /* Make table take full width */
        margin-bottom: 1rem;
        border-collapse: collapse; /* Remove extra spacing between cells */
        }

        /* Table cell and header styling */
        .table > thead > tr > th, .table > tbody > tr > td {
        text-align: center; /* Center-align content */
        vertical-align: middle; /* Vertically center content */
        padding: 4px; /* Adjust padding for better readability */
        white-space: nowrap; /* Prevent text wrapping in cells */
        }

        /* Table hover and striped rows */
        .table-striped tbody tr:nth-of-type(odd) {
        background-color: #f8f9fa; /* Add alternating row color */
        }

        .table-hover tbody tr:hover {
        background-color: #e9ecef; /* Highlight row on hover */
        }

        /* Header styling */
        .table > thead > tr > th {
        font-size: 14px;
        font-weight: 600;
        background-color: #f8f9fa; /* Light background for headers */
        color: #343a40; /* Dark text for contrast */
        border-bottom: 2px solid #dee2e6;
        }

        /* Cell borders */
        .table-bordered td, .table-bordered th {
        border: 1px solid #dee2e6 !important;
        }

        /* Badges for status */
        .badge {
        font-size: 12px;
        padding: 5px 10px;
        border-radius: 12px;
        }

        .badge-success {
        background-color: #31ce36; /* Green for assigned */
        color: #fff;
        }

        .badge-warning {
        background-color: #ffad46; /* Orange for open */
        color: #fff;
        }

        /* Scrollable container adjustments */
        @media (max-width: 768px) {
        .table-responsive {
            overflow-x: auto; /* Ensure horizontal scrolling for small screens */
        }

        .table {
            font-size: 12px; /* Reduce font size for compact view */
        }

        .badge {
            font-size: 10px; /* Reduce badge size on smaller screens */
            padding: 3px 7px;
        }
        }
    </style>
<body>
    <div class="wrapper">
        <div class="main-header">
            <!-- Logo Header -->
                @include('layouts.logo_header')
            <!-- End Logo Header -->

            <!-- Navbar Header -->
                @include('layouts.navbar')
            <!-- End Navbar -->
        </div>

        <!-- Sidebar -->
            @include('layouts.sidebar')
        <!-- End Sidebar -->

        <div class="main-panel">
            <div class="content">
                <div class="panel-header bg-primary-gradient">
                    <div class="page-inner py-5">
                        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
                            <div>
                                <h2 class="text-white pb-2 fw-bold">Master Data PAC</h2>
                                <h5 class="text-white op-7 mb-2">List of Master Data Parameters for PAC</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="page-inner mt--5">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4 class="card-title">Master Data PAC</h4>
                                <button type="button" class="btn btn-round btn-primary ms-auto" data-toggle="modal" data-target="#addPacModal">
                                    <i class="fas fa-plus"></i> Data Add
                                </button>

                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="multi-filter-select" class="display table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>Actions</th>
                                                <th>Product Name</th>
                                                <th>Appearance</th>
                                                <th>AI2O3 (%)</th>
                                                <th>Basicity (%)</th>
                                                <th>pH 1% Solution</th>
                                                <th>Specific Gravity</th>
                                                <th>Turbidity (FNU)</th>
                                                <th>Fe (ppm)</th>
                                                <th>Moisture (%)</th>
                                                <th>CI (%)</th>
                                                <th>SO4 (%)</th>
                                                <th>Shelf life</th>
                                                <th>Kadar (%)</th>
                                                <th>pH Pure</th>
                                                <th>Kelarutan di dalam HCl 1:1</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>Actions</th>
                                                <th>Product Name</th>
                                                <th>Appearance</th>
                                                <th>AI2O3 (%)</th>
                                                <th>Basicity (%)</th>
                                                <th>pH 1% Solution</th>
                                                <th>Specific Gravity</th>
                                                <th>Turbidity (FNU)</th>
                                                <th>Fe (ppm)</th>
                                                <th>Moisture (%)</th>
                                                <th>CI (%)</th>
                                                <th>SO4 (%)</th>
                                                <th>Shelf life</th>
                                                <th>Kadar (%)</th>
                                                <th>pH Pure</th>
                                                <th>Kelarutan di dalam HCl 1:1</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                           
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Tambah Data -->
                        <div class="modal fade" id="addPacModal" tabindex="-1" aria-labelledby="addPacModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content" style="border-radius: 10px; background-color: #f9f9f9;">
                                    <div class="modal-header" style="background-color: #007bff; color: white; border-bottom-left-radius: 10px; border-bottom-right-radius: 10px;">
                                        <h5 class="modal-title" id="addPacModalLabel">Tambah Data PAC</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="addPacForm">
                                            @csrf
                                            <div class="row">
                                                <!-- Kolom Kiri -->
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label class="form-label">Product Name</label>
                                                        <input type="text" name="product_name" id="product_name" class="form-control" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Appearance</label>
                                                        <input type="text" name="appearance" class="form-control" >
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">AI<sub>2</sub>O<sub>3</sub> (%)</label>
                                                        <div class="input-group">
                                                            <input type="number" step="0.01" min="0.00" max="100.00" name="ai2o3_min" class="form-control" placeholder="Min" >
                                                            <span class="input-group-text"> - </span>
                                                            <input type="number" step="0.01" min="0.00" max="100.00" name="ai2o3_max" class="form-control" placeholder="Max" >
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Basicity (%)</label>
                                                        <div class="input-group">
                                                            <input type="number" step="0.01" name="basicity_min" class="form-control" placeholder="Min" >
                                                            <span class="input-group-text"> - </span>
                                                            <input type="number" step="0.01" name="basicity_max" class="form-control" placeholder="Max" >
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">pH 1% Solution</label>
                                                        <div class="input-group">
                                                            <input type="number" step="0.01" name="ph_1_solution_min" class="form-control" placeholder="Min" >
                                                            <span class="input-group-text"> - </span>
                                                            <input type="number" step="0.01" name="ph_1_solution_max" class="form-control" placeholder="Max" >
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Kolom Tengah -->
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label class="form-label">Moisture (%)</label>
                                                        <div class="input-group">
                                                            <input type="number" step="0.01" name="moisture_min" class="form-control" placeholder="Min" >
                                                            <span class="input-group-text"> - </span>
                                                            <input type="number" step="0.01" name="moisture_max" class="form-control" placeholder="Max" >
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">CI (%)</label>
                                                        <div class="input-group">
                                                            <input type="number" step="0.01" name="cl_min" class="form-control" placeholder="Min" >
                                                            <span class="input-group-text"> - </span>
                                                            <input type="number" step="0.01" name="cl_max" class="form-control" placeholder="Max" >
                                                        </div>
                                                    </div>  
                                                    <div class="mb-3">
                                                        <label class="form-label">Specific Gravity</label>
                                                        <div class="input-group">
                                                            <input type="number" step="0.01" name="specific_gravity_min" class="form-control" placeholder="Min" >
                                                            <span class="input-group-text"> - </span>
                                                            <input type="number" step="0.01" name="specific_gravity_max" class="form-control" placeholder="Max" >
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Turbidity (FNU)</label>
                                                        <div class="input-group">
                                                            <input type="number" step="0.01" name="turbidity_min" class="form-control" placeholder="Min" >
                                                            <span class="input-group-text"> - </span>
                                                            <input type="number" step="0.01" name="turbidity_max" class="form-control" placeholder="Max" >
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Fe (ppm)</label>
                                                        <div class="input-group">
                                                            <input type="number" step="0.01" name="fe_min" class="form-control" placeholder="Min" >
                                                            <span class="input-group-text"> - </span>
                                                            <input type="number" step="0.01" name="fe_max" class="form-control" placeholder="Max" >
                                                        </div>
                                                    </div>  
                                                </div>

                                                <!-- Kolom Kanan -->
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label class="form-label">SO<sub>4</sub> (%)</label>
                                                        <div class="input-group">
                                                            <input type="number" step="0.01" name="so4_min" class="form-control" placeholder="Min" >
                                                            <span class="input-group-text"> - </span>
                                                            <input type="number" step="0.01" name="so4_max" class="form-control" placeholder="Max" >
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Shelf life (Month)</label>
                                                        <input type="text" name="shelf_life" class="form-control" >
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Kadar (%)</label>
                                                        <div class="input-group">
                                                            <input type="number" step="0.01" name="kadar_min" class="form-control" placeholder="Min" >
                                                            <span class="input-group-text"> - </span>
                                                            <input type="number" step="0.01" name="kadar_max" class="form-control" placeholder="Max" >
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">pH Pure</label>
                                                        <div class="input-group">
                                                            <input type="number" step="0.01" name="ph_pure_min" class="form-control" placeholder="Min" >
                                                            <span class="input-group-text"> - </span>
                                                            <input type="number" step="0.01" name="ph_pure_max" class="form-control" placeholder="Max" >
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Kelarutan di dalam HCl 1:1</label>
                                                        <input type="text" name="kelarutan_hcl" class="form-control" >
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-round btn-secondary" data-dismiss="modal">Tutup</button>
                                                <button type="submit" class="btn btn-round btn-primary">Simpan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Edit Data PAC -->
                        <div class="modal fade" id="editPacModal" tabindex="-1" aria-labelledby="editPacModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content" style="border-radius: 10px; background-color: #f9f9f9;">
                                    <div class="modal-header" style="background-color: #007bff; color: white; border-bottom-left-radius: 10px; border-bottom-right-radius: 10px;">
                                        <h5 class="modal-title" id="editPacModalLabel">Edit Data PAC</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="editPacForm">
                                            @csrf
                                            <input type="hidden" id="edit_pac_id"> <!-- ID tersembunyi -->
                                            <div class="row">
                                                <!-- Kolom Kiri -->
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label class="form-label">Product Name</label>
                                                        <input type="text" id="edit_product_name" name="product_name" class="form-control" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Appearance</label>
                                                        <input type="text" id="edit_appearance" name="appearance" class="form-control">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">AI<sub>2</sub>O<sub>3</sub> (%)</label>
                                                        <div class="input-group">
                                                            <input type="number" step="0.01" min="0.00" max="100.00" name="ai2o3_min" id="edit_ai2o3_min" class="form-control" placeholder="Min">
                                                            <span class="input-group-text"> - </span>
                                                            <input type="number" step="0.01" min="0.00" max="100.00" name="ai2o3_max" id="edit_ai2o3_max" class="form-control" placeholder="Max">
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Basicity (%)</label>
                                                        <div class="input-group">
                                                            <input type="number" step="0.01" id="edit_basicity_min" name="basicity_min" class="form-control" placeholder="Min">
                                                            <span class="input-group-text"> - </span>
                                                            <input type="number" step="0.01" id="edit_basicity_max" name="basicity_max" class="form-control" placeholder="Max">
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">pH 1% Solution</label>
                                                        <div class="input-group">
                                                            <input type="number" step="0.01" id="edit_ph_1_solution_min" name="ph_1_solution_min" class="form-control" placeholder="Min">
                                                            <span class="input-group-text"> - </span>
                                                            <input type="number" step="0.01" id="edit_ph_1_solution_max" name="ph_1_solution_max" class="form-control" placeholder="Max">
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Kolom Tengah -->
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label class="form-label">Moisture (%)</label>
                                                        <div class="input-group">
                                                            <input type="number" step="0.01" id="edit_moisture_min" name="moisture_min" class="form-control" placeholder="Min">
                                                            <span class="input-group-text"> - </span>
                                                            <input type="number" step="0.01" id="edit_moisture_max" name="moisture_max" class="form-control" placeholder="Max">
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">CI (%)</label>
                                                        <div class="input-group">
                                                            <input type="number" step="0.01" id="edit_cl_min" name="cl_min" class="form-control" placeholder="Min">
                                                            <span class="input-group-text"> - </span>
                                                            <input type="number" step="0.01" id="edit_cl_max" name="cl_max" class="form-control" placeholder="Max">
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Specific Gravity</label>
                                                        <div class="input-group">
                                                            <input type="number" step="0.01" id="edit_specific_gravity_min" name="specific_gravity_min" class="form-control" placeholder="Min">
                                                            <span class="input-group-text"> - </span>
                                                            <input type="number" step="0.01" id="edit_specific_gravity_max" name="specific_gravity_max" class="form-control" placeholder="Max">
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Turbidity (FNU)</label>
                                                        <div class="input-group">
                                                            <input type="number" step="0.01" id="edit_turbidity_min" name="turbidity_min" class="form-control" placeholder="Min">
                                                            <span class="input-group-text"> - </span>
                                                            <input type="number" step="0.01" id="edit_turbidity_max" name="turbidity_max" class="form-control" placeholder="Max">
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Fe (ppm)</label>
                                                        <div class="input-group">
                                                            <input type="number" step="0.01" id="edit_fe_min" name="fe_min" class="form-control" placeholder="Min">
                                                            <span class="input-group-text"> - </span>
                                                            <input type="number" step="0.01" id="edit_fe_max" name="fe_max" class="form-control" placeholder="Max">
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Kolom Kanan -->
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label class="form-label">SO<sub>4</sub> (%)</label>
                                                        <div class="input-group">
                                                            <input type="number" step="0.01" id="edit_so4_min" name="so4_min" class="form-control" placeholder="Min">
                                                            <span class="input-group-text"> - </span>
                                                            <input type="number" step="0.01" id="edit_so4_max" name="so4_max" class="form-control" placeholder="Max">
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Shelf life (Month)</label>
                                                        <input type="text" id="edit_shelf_life" name="shelf_life" class="form-control">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Kadar (%)</label>
                                                        <div class="input-group">
                                                            <input type="number" step="0.01" id="edit_kadar_min" name="kadar_min" class="form-control" placeholder="Min">
                                                            <span class="input-group-text"> - </span>
                                                            <input type="number" step="0.01" id="edit_kadar_max" name="kadar_max" class="form-control" placeholder="Max">
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">pH Pure</label>
                                                        <div class="input-group">
                                                            <input type="number" step="0.01" id="edit_ph_pure_min" name="ph_pure_min" class="form-control" placeholder="Min">
                                                            <span class="input-group-text"> - </span>
                                                            <input type="number" step="0.01" id="edit_ph_pure_max" name="ph_pure_max" class="form-control" placeholder="Max">
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Kelarutan di dalam HCl 1:1</label>
                                                        <input type="text" id="edit_kelarutan_hcl" name="kelarutan_hcl" class="form-control">
                                                    </div>
                                                </div>
                                                </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Footer -->
                @include('layouts.footer')
            <!-- End Footer -->
        </div>
    </div>

    <!-- Core JS Files -->
    <script src="{{ asset('atlantis/assets/js/core/jquery.3.2.1.min.js') }}"></script>
    <script src="{{ asset('atlantis/assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('atlantis/assets/js/core/bootstrap.min.js') }}"></script>

    <!-- jQuery UI -->
    <script src="{{ asset('atlantis/assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('atlantis/assets/js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js') }}"></script>

    <!-- jQuery Scrollbar -->
    <script src="{{ asset('atlantis/assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>

    <!-- Chart JS -->
    <script src="{{ asset('atlantis/assets/js/plugin/chart.js/chart.min.js') }}"></script>

    <!-- Datatables -->
    <script src="{{ asset('atlantis/assets/js/plugin/datatables/datatables.min.js') }}"></script>

    <!-- Bootstrap Notify -->
    <script src="{{ asset('atlantis/assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js') }}"></script>

    <!-- Sweet Alert -->
    <script src="{{ asset('atlantis/assets/js/plugin/sweetalert/sweetalert.min.js') }}"></script>

    <!-- Atlantis JS -->
    <script src="{{ asset('atlantis/assets/js/atlantis.min.js') }}"></script>

    <!-- datatable multi filter -->
    <script>
        $(document).ready(function () {
            let tableElement = $('#multi-filter-select');

            if (tableElement.length === 0) {
                console.error("Tabel #multi-filter-select tidak ditemukan!");
                return;
            }

            var table = tableElement.DataTable({
                "processing": true,
                "serverSide": false,
                "ajax": {
                    "url": "{{ route('get.pac.data') }}",
                    "dataSrc": function (json) {
                        return json.data || [];  // Pastikan JSON memiliki "data"
                    }
                },
                "columns": [
                    
                    { 
                        "data": null,
                        "orderable": false,
                        "render": function (data, type, row) {
                            return `
                                <button class="btn btn-link btn-warning edit-btn" data-id="${row.id}">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-link btn-danger delete-btn" data-id="${row.id}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            `;
                        }
                    },
                    { "data": "product_name" },
                    { "data": "appearance" },
                    { "data": "ai2o3" },
                    { "data": "basicity" },
                    { "data": "ph_1_solution" },
                    { "data": "specific_gravity" },
                    { "data": "turbidity" },
                    { "data": "fe" },
                    { "data": "moisture" },
                    { "data": "cl" },
                    { "data": "so4" },
                    { "data": "shelf_life" },
                    { "data": "kadar" },
                    { "data": "ph_pure" },
                    { "data": "kelarutan_hcl" }
                ],
                "pageLength": 5,
                "initComplete": function () {
                    let api = this.api();
                    api.columns().every(function () {
                        let column = this;
                        let footer = $(column.footer());

                        if (footer.length > 0) {
                            let select = $('<select class="form-control"><option value="">Filter</option></select>')
                                .appendTo(footer.empty())
                                .on('change', function () {
                                    let val = $.fn.dataTable.util.escapeRegex($(this).val());
                                    column.search(val ? '^' + val + '$' : '', true, false).draw();
                                });

                            column.data().unique().sort().each(function (d) {
                                if (d) select.append('<option value="' + d + '">' + d + '</option>');
                            });
                        }
                    });
                }
            });

            // Handle Delete Button
            $(document).on('click', '.delete-btn', function () {
                var id = $(this).data('id');

                swal({
                    title: "Apakah Anda yakin?",
                    text: "Data yang dihapus tidak dapat dikembalikan!",
                    icon: "warning",
                    buttons: {
                        cancel: {
                            text: "Batal",
                            visible: true,
                            className: "btn btn-default"
                        },
                        confirm: {
                            text: "Ya, Hapus!",
                            className: "btn btn-danger"
                        }
                    },
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });

                        $.ajax({
                            url: `/delete-pac/${id}`,
                            type: "DELETE",
                            success: function (response) {
                                swal({
                                    title: "Sukses!",
                                    text: "Data berhasil dihapus!",
                                    icon: "success",
                                    buttons: false,
                                    timer: 2000
                                });

                                table.ajax.reload();
                            },
                            error: function (xhr) {
                                console.error(xhr.responseText);
                                swal({
                                    title: "Gagal!",
                                    text: "Terjadi kesalahan saat menghapus data!",
                                    icon: "error",
                                    buttons: false,
                                    timer: 2000
                                });
                            }
                        });
                    }
                });
            });
        });
    </script>

    <!-- edit btn -->
    <script>
        $(document).on('click', '.edit-btn', function() {
            var id = $(this).data('id');

            $.ajax({
                url: `/get-pac/${id}`,
                type: "GET",
                success: function(response) {
                    $('#edit_pac_id').val(response.id);
                    $('#edit_product_name').val(response.product_name);
                    $('#edit_appearance').val(response.appearance);
                    $('#edit_ai2o3_min').val(response.ai2o3_min);
                    $('#edit_ai2o3_max').val(response.ai2o3_max);
                    $('#edit_basicity_min').val(response.basicity_min);
                    $('#edit_basicity_max').val(response.basicity_max);
                    $('#edit_ph_1_solution_min').val(response.ph_1_solution_min);
                    $('#edit_ph_1_solution_max').val(response.ph_1_solution_max);
                    $('#edit_specific_gravity_min').val(response.specific_gravity_min);
                    $('#edit_specific_gravity_max').val(response.specific_gravity_max);
                    $('#edit_turbidity_min').val(response.turbidity_min);
                    $('#edit_turbidity_max').val(response.turbidity_max);
                    $('#edit_fe_min').val(response.fe_min);
                    $('#edit_fe_max').val(response.fe_max);
                    $('#edit_moisture_min').val(response.moisture_min);
                    $('#edit_moisture_max').val(response.moisture_max);
                    $('#edit_cl_min').val(response.cl_min);
                    $('#edit_cl_max').val(response.cl_max);
                    $('#edit_so4_min').val(response.so4_min);
                    $('#edit_so4_max').val(response.so4_max);
                    $('#edit_shelf_life').val(response.shelf_life);
                    $('#edit_kadar_min').val(response.kadar_min);
                    $('#edit_kadar_max').val(response.kadar_max);
                    $('#edit_ph_pure_min').val(response.ph_pure_min);
                    $('#edit_ph_pure_max').val(response.ph_pure_max);
                    $('#edit_kelarutan_hcl').val(response.kelarutan_hcl);
                    $('#editPacModal').modal('show');
                }
            });
        });

        // Simpan perubahan
        $('#editPacForm').on('submit', function(e) {
            e.preventDefault();

            var id = $('#edit_pac_id').val();
            var formData = {
                product_name: $('#edit_product_name').val(),
                appearance: $('#edit_appearance').val(),
                ai2o3_min: $('#edit_ai2o3_min').val(),
                ai2o3_max: $('#edit_ai2o3_max').val(),
                basicity_min: $('#edit_basicity_min').val(),
                basicity_max: $('#edit_basicity_max').val(),
                ph_1_solution_min: $('#edit_ph_1_solution_min').val(),
                ph_1_solution_max: $('#edit_ph_1_solution_max').val(),
                specific_gravity_min: $('#edit_specific_gravity_min').val(),
                specific_gravity_max: $('#edit_specific_gravity_max').val(),
                turbidity_min: $('#edit_turbidity_min').val(),
                turbidity_max: $('#edit_turbidity_max').val(),
                fe_min: $('#edit_fe_min').val(),
                fe_max: $('#edit_fe_max').val(),
                moisture_min: $('#edit_moisture_min').val(),
                moisture_max: $('#edit_moisture_max').val(),
                cl_min: $('#edit_cl_min').val(),
                cl_max: $('#edit_cl_max').val(),
                so4_min: $('#edit_so4_min').val(),
                so4_max: $('#edit_so4_max').val(),
                shelf_life: $('#edit_shelf_life').val(),
                kadar_min: $('#edit_kadar_min').val(),
                kadar_max: $('#edit_kadar_max').val(),
                ph_pure_min: $('#edit_ph_pure_min').val(),
                ph_pure_max: $('#edit_ph_pure_max').val(),
                kelarutan_hcl: $('#edit_kelarutan_hcl').val(),
            };

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')  // Ambil token dari meta tag
                }
            });

            $.ajax({
                url: `/update-pac/${id}`,
                type: "PUT",
                data: formData,
                success: function(response) {
                    $('#editPacModal').modal('hide');
                    $('#multi-filter-select').DataTable().ajax.reload();
                    
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Data berhasil diperbarui!',
                        showConfirmButton: false,
                        timer: 2000
                    });
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Terjadi kesalahan saat memperbarui data!',
                    });
                }
            });
        });

    </script>

    <!-- Modal Tambah Data -->
    <script>
        $(document).ready(function () {
            $("#addPacForm button[type='submit']").on("click", function (e) {
                e.preventDefault();

                const productName = document.getElementById('product_name').value.trim();

                if (productName === "") {
                    swal("Error", "Product name cannot be empty.", "error");
                    return;
                }

                fetch('{{ route('check.product.name') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ product_name: productName })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.exists) {
                        swal("Error", "Product name already exists. Please provide a unique name.", "error");
                        return;
                    }

                    swal({
                        title: "Are you sure?",
                        text: "The data will be saved!",
                        icon: "warning",
                        buttons: ["Cancel", "Yes, Save!"],
                        dangerMode: true,
                    }).then((willSubmit) => {
                        if (willSubmit) {
                            var formData = $("#addPacForm").serialize();
                            $.ajax({
                                url: "{{ route('master-data-pac.store') }}",
                                type: "POST",
                                data: formData,
                                success: function (response) {
                                    if (response.success) {
                                        $("#addPacModal").modal("hide");
                                        $("#addPacForm")[0].reset();

                                        swal({
                                            title: "Success!",
                                            text: "Data PAC has been added.",
                                            icon: "success",
                                            buttons: false,
                                            timer: 2000
                                        });

                                        $('#multi-filter-select').DataTable().ajax.reload();
                                    }
                                },
                                error: function (xhr) {
                                    if (xhr.responseJSON.error) {
                                        swal("Failed!", xhr.responseJSON.error, "error");
                                    } else {
                                        swal("Error", "There was an error saving the data. Please try again.", "error");
                                    }
                                }
                            });
                        }
                    });
                })
                .catch(error => {
                    console.error('Error checking product name:', error);
                    swal("Error", "There was an error checking the product name. Please try again.", "error");
                });
            });
        });
    </script>

    @if(session('error'))
        <script>
            swal({
                title: "Error",
                text: "{{ session('error') }}",
                icon: "error",
                button: "OK",
            });
        </script>
    @endif


    

    </body>
</html>
