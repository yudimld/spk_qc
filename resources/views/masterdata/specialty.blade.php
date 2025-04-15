<!DOCTYPE html>
<html lang="en">
    @extends('layouts.head')
    @section('title', 'Master Data Specialty')
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
                                <h2 class="text-white pb-2 fw-bold">Master Data Specialty</h2>
                                <h5 class="text-white op-7 mb-2">List of Master Data Parameters for Specialty (FG / RM)</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="page-inner mt--5">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4 class="card-title">Master Data Specialty</h4>
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
                                                <th>Solution (%)</th>
                                                <th>pH Value</th>
                                                <th>SG</th>
                                                <th>SG 0,1% sol</th>
                                                <th>Specific Gravity</th>
                                                <th>Specific Gravity 0.1% Sol</th>
                                                <th>Viscosity</th>
                                                <th>Viscosity 0.1% Sol</th>
                                                <th>Dry Weight</th>
                                                <th>Purity (%)</th>
                                                <th>Moisture Water (%)</th>
                                                <th>Residue on Ignition (%)</th>
                                                <th>Solid Content </th>
                                                <th>Shelf Life</th>
                                                <th>Keterangan</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>Actions</th>
                                                <th>Product Name</th>
                                                <th>Appearance</th>
                                                <th>Solution </th>
                                                <th>pH Value </th>
                                                <th>SG</th>
                                                <th>SG 0,1% sol</th>
                                                <th>Specific Gravity </th>
                                                <th>Specific Gravity 0.1 </th>
                                                <th>Viscosity </th>
                                                <th>Viscosity 0.1 </th>
                                                <th>Dry Weight</th>
                                                <th>Purity </th>
                                                <th>Moisture Water </th>
                                                <th>Residue on Ignition </th>
                                                <th>Solid Content </th>
                                                <th>Shelf Life</th>
                                                <th>Keterangan</th>
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
                                        <form id="addPacForm" method="POST" action="{{ route('specialties.store') }}">
                                            @csrf
                                            <div class="row">
                                                <!-- Kolom Kiri -->
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label class="form-label">Product Name</label>
                                                        <input type="text" name="product_name" class="form-control" id="product_name" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Appearance</label>
                                                        <input type="text" name="appearance" class="form-control">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Solution (%)</label>
                                                        <div class="input-group">
                                                            <input type="number" step="0.01" name="solution" class="form-control" placeholder="% solution">
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">pH Value</label>
                                                        <div class="input-group">
                                                            <input type="number" step="0.01" name="ph_value_min" class="form-control" placeholder="Min">
                                                            <span class="input-group-text"> - </span>
                                                            <input type="number" step="0.01" name="ph_value_max" class="form-control" placeholder="Max">
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Specific Gravity</label>
                                                        <div class="input-group">
                                                            <input type="number" step="0.001" name="specific_gravity_min" class="form-control" placeholder="Min">
                                                            <span class="input-group-text"> - </span>
                                                            <input type="number" step="0.001" name="specific_gravity_max" class="form-control" placeholder="Max">
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">SG</label>
                                                        <div class="input-group">
                                                            <input type="number" step="0.001" name="sg_min" class="form-control" placeholder="Min">
                                                            <span class="input-group-text"> - </span>
                                                            <input type="number" step="0.001" name="sg_max" class="form-control" placeholder="Max">
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Kolom Tengah -->
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label class="form-label">SG 0,1% Sol</label>
                                                        <div class="input-group">
                                                            <input type="number" step="0.001" name="sg_01_min" class="form-control" placeholder="Min">
                                                            <span class="input-group-text"> - </span>
                                                            <input type="number" step="0.001" name="sg_01_max" class="form-control" placeholder="Max">
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Specific Gravity 0.1% Sol</label>
                                                        <div class="input-group">
                                                            <input type="number" step="0.001" name="specific_gravity_01_min" class="form-control" placeholder="Min">
                                                            <span class="input-group-text"> - </span>
                                                            <input type="number" step="0.001" name="specific_gravity_01_max" class="form-control" placeholder="Max">
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Viscosity</label>
                                                        <div class="input-group">
                                                            <input type="number" step="0.01" name="viscosity_min" class="form-control" placeholder="Min">
                                                            <span class="input-group-text"> - </span>
                                                            <input type="number" step="0.01" name="viscosity_max" class="form-control" placeholder="Max">
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Viscosity 0.1% Sol</label>
                                                        <div class="input-group">
                                                            <input type="number" step="0.01" name="viscosity_01_min" class="form-control" placeholder="Min">
                                                            <span class="input-group-text"> - </span>
                                                            <input type="number" step="0.01" name="viscosity_01_max" class="form-control" placeholder="Max">
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Dry Weight</label>
                                                        <input type="number" step="0.01" name="dry_weight" class="form-control">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Purity (%)</label>
                                                        <div class="input-group">
                                                            <input type="number" step="0.01" name="purity_min" class="form-control" placeholder="Min">
                                                            <span class="input-group-text"> - </span>
                                                            <input type="number" step="0.01" name="purity_max" class="form-control" placeholder="Max">
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Kolom Kanan -->
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label class="form-label">Moisture Water (%)</label>
                                                        <div class="input-group">
                                                            <input type="number" step="0.01" name="moisture_water_min" class="form-control" placeholder="Min">
                                                            <span class="input-group-text"> - </span>
                                                            <input type="number" step="0.01" name="moisture_water_max" class="form-control" placeholder="Max">
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Residue on Ignition (%)</label>
                                                        <div class="input-group">
                                                            <input type="number" step="0.01" name="residue_on_ignition_min" class="form-control" placeholder="Min">
                                                            <span class="input-group-text"> - </span>
                                                            <input type="number" step="0.01" name="residue_on_ignition_max" class="form-control" placeholder="Max">
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Solid Content</label>
                                                        <div class="input-group">
                                                            <input type="number" step="0.01" name="solid_content_min" class="form-control" placeholder="Min">
                                                            <span class="input-group-text"> - </span>
                                                            <input type="number" step="0.01" name="solid_content_max" class="form-control" placeholder="Max">
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Shelf Life (month)</label>
                                                        <input type="text" name="shelf_life" class="form-control">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Keterangan</label>
                                                        <textarea name="keterangan" class="form-control" rows="3"></textarea>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-round btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-round btn-primary">Save</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Edit Data -->
                        <div class="modal fade" id="editSpecialtyModal" tabindex="-1" aria-labelledby="editSpecialtyModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content" style="border-radius: 10px; background-color: #f9f9f9;">
                                    <div class="modal-header" style="background-color: #007bff; color: white; border-bottom-left-radius: 10px; border-bottom-right-radius: 10px;">
                                        <h5 class="modal-title" id="editSpecialtyModalLabel">Edit Data Specialty</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="editSpecialtyForm">
                                            @csrf
                                            <input type="hidden" id="edit_specialty_id"> <!-- ID tersembunyi -->
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
                                                        <label class="form-label">Solution</label>
                                                        <div class="input-group">
                                                            <input type="number" step="0.01" id="edit_solution" name="solution" class="form-control" placeholder="% Solution">
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">pH Value</label>
                                                        <div class="input-group">
                                                            <input type="number" step="0.01" id="edit_ph_value_min" name="ph_value_min" class="form-control" placeholder="Min">
                                                            <span class="input-group-text"> - </span>
                                                            <input type="number" step="0.01" id="edit_ph_value_max" name="ph_value_max" class="form-control" placeholder="Max">
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
                                                        <label class="form-label">SG</label>
                                                        <div class="input-group">
                                                            <input type="number" step="0.001" id="edit_sg_min" name="sg_min" class="form-control" placeholder="Min">
                                                            <span class="input-group-text"> - </span>
                                                            <input type="number" step="0.001" id="edit_sg_max" name="sg_max" class="form-control" placeholder="Max">
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Kolom Tengah -->
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label class="form-label">SG 0,1% Sol</label>
                                                        <div class="input-group">
                                                            <input type="number" step="0.001" id="edit_sg_01_min" name="sg_01_min" class="form-control" placeholder="Min">
                                                            <span class="input-group-text"> - </span>
                                                            <input type="number" step="0.001" id="edit_sg_01_max" name="sg_01_max" class="form-control" placeholder="Max">
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Specific Gravity 0.1% Sol</label>
                                                        <div class="input-group">
                                                            <input type="number" step="0.01" id="edit_specific_gravity_01_min" name="specific_gravity_01_min" class="form-control" placeholder="Min">
                                                            <span class="input-group-text"> - </span>
                                                            <input type="number" step="0.01" id="edit_specific_gravity_01_max" name="specific_gravity_01_max" class="form-control" placeholder="Max">
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Viscosity</label>
                                                        <div class="input-group">
                                                            <input type="number" step="0.01" id="edit_viscosity_min" name="viscosity_min" class="form-control" placeholder="Min">
                                                            <span class="input-group-text"> - </span>
                                                            <input type="number" step="0.01" id="edit_viscosity_max" name="viscosity_max" class="form-control" placeholder="Max">
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Viscosity 0.1% Sol</label>
                                                        <div class="input-group">
                                                            <input type="number" step="0.01" id="edit_viscosity_01_min" name="viscosity_01_min" class="form-control" placeholder="Min">
                                                            <span class="input-group-text"> - </span>
                                                            <input type="number" step="0.01" id="edit_viscosity_01_max" name="viscosity_01_max" class="form-control" placeholder="Max">
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Dry Weight</label>
                                                        <input type="number" step="0.01" id="edit_dry_weight" name="dry_weight" class="form-control">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Purity (%)</label>
                                                        <div class="input-group">
                                                            <input type="number" step="0.01" id="edit_purity_min" name="purity_min" class="form-control" placeholder="Min">
                                                            <span class="input-group-text"> - </span>
                                                            <input type="number" step="0.01" id="edit_purity_max" name="purity_max" class="form-control" placeholder="Max">
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Kolom Kanan -->
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label class="form-label">Moisture Water (%)</label>
                                                        <div class="input-group">
                                                            <input type="number" step="0.01" id="edit_moisture_water_min" name="moisture_water_min" class="form-control" placeholder="Min">
                                                            <span class="input-group-text"> - </span>
                                                            <input type="number" step="0.01" id="edit_moisture_water_max" name="moisture_water_max" class="form-control" placeholder="Max">
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Residue on Ignition (%)</label>
                                                        <div class="input-group">
                                                            <input type="number" step="0.01" id="edit_residue_on_ignition_min" name="residue_on_ignition_min" class="form-control" placeholder="Min">
                                                            <span class="input-group-text"> - </span>
                                                            <input type="number" step="0.01" id="edit_residue_on_ignition_max" name="residue_on_ignition_max" class="form-control" placeholder="Max">
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Solid Content</label>
                                                        <div class="input-group">
                                                            <input type="number" step="0.01" id="edit_solid_content_min" name="solid_content_min" class="form-control" placeholder="Min">
                                                            <span class="input-group-text"> - </span>
                                                            <input type="number" step="0.01" id="edit_solid_content_max" name="solid_content_max" class="form-control" placeholder="Max">
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Shelf Life (month)</label>
                                                        <input type="text" id="edit_shelf_life" name="shelf_life" class="form-control">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Keterangan</label>
                                                        <textarea id="edit_keterangan" name="keterangan" class="form-control" rows="3"></textarea>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-round btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-round btn-primary">Save</button>
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

    <!-- multifilter datatabel -->
    <script>
        $(document).ready(function() {
            let tableElement = $('#multi-filter-select');

            if (tableElement.length === 0) {
                console.error("Tabel #multi-filter-select tidak ditemukan!");
                return;
            }

            var table = tableElement.DataTable({
                "processing": true,
                "serverSide": false,
                "ajax": {
                    "url": "{{ route('specialties.get') }}",
                    "dataSrc": function (json) {
                            
                            if (!json.data) {
                                console.error('Tidak ada data dalam JSON');
                                return [];
                            }
                            return json.data || [];
                        }
                },
                "columns": [
                    { 
                        "data": null, 
                        "orderable": false,
                        "render": function(data, type, row) {
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
                    { data: 'product_name' },
                    { data: 'appearance' },
                    { data: 'solution' },  
                    { data: 'ph_value' },  
                    { data: 'sg' },  
                    { data: 'sg_01' },  
                    { data: 'specific_gravity' },  
                    { data: 'specific_gravity_01' },  
                    { data: 'viscosity' },  
                    { data: 'viscosity_01' }, 
                    { data: 'dry_weight' },
                    { data: 'purity' }, 
                    { data: 'moisture_water' }, 
                    { data: 'residue_on_ignition' },  
                    { data: 'solid_content' }, 
                    { data: 'shelf_life' },
                    { data: 'keterangan' }
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

                            // Menambahkan opsi filter berdasarkan data unik di kolom
                            column.data().unique().sort().each(function (d) {
                                if (d && typeof d !== 'object') {
                                    // Pastikan hanya nilai primitif (string, number) yang dimasukkan ke dalam dropdown
                                    select.append('<option value="' + d + '">' + d + '</option>');
                                }
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
                            url: `/delete-specialty/${id}`,
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

    <!-- btn edit  -->
    <script>
        // Event listener untuk tombol Edit
        $(document).on('click', '.edit-btn', function() {
            var id = $(this).data('id'); // Ambil id dari data-id tombol Edit

            // Ambil data dari API berdasarkan ID
            $.ajax({
                url: '/get-specialty/' + id,
                type: 'GET',
                success: function(response) {
                    var specialty = response.data;

                    // Isi modal dengan data dari backend
                    $('#edit_specialty_id').val(specialty.id); 
                    $('#edit_product_name').val(specialty.product_name); 
                    $('#edit_appearance').val(specialty.appearance);
                    $('#edit_solution').val(specialty.solution);
                    $('#edit_ph_value_min').val(specialty.ph_value_min);
                    $('#edit_ph_value_max').val(specialty.ph_value_max);
                    $('#edit_sg_min').val(specialty.sg_min);
                    $('#edit_sg_max').val(specialty.sg_max);
                    $('#edit_sg_01_min').val(specialty.sg_01_min);
                    $('#edit_sg_01_max').val(specialty.sg_01_max);
                    $('#edit_specific_gravity_min').val(specialty.specific_gravity_min);
                    $('#edit_specific_gravity_max').val(specialty.specific_gravity_max);
                    $('#edit_specific_gravity_01_min').val(specialty.specific_gravity_01_min);
                    $('#edit_specific_gravity_01_max').val(specialty.specific_gravity_01_max);
                    $('#edit_viscosity_min').val(specialty.viscosity_min);
                    $('#edit_viscosity_max').val(specialty.viscosity_max);
                    $('#edit_viscosity_01_min').val(specialty.viscosity_01_min);
                    $('#edit_viscosity_01_max').val(specialty.viscosity_01_max);
                    $('#edit_dry_weight').val(specialty.dry_weight);
                    $('#edit_purity_min').val(specialty.purity_min);
                    $('#edit_purity_max').val(specialty.purity_max);
                    $('#edit_moisture_water_min').val(specialty.moisture_water_min);
                    $('#edit_moisture_water_max').val(specialty.moisture_water_max);
                    $('#edit_residue_on_ignition_min').val(specialty.residue_on_ignition_min);
                    $('#edit_residue_on_ignition_max').val(specialty.residue_on_ignition_max);
                    $('#edit_solid_content_min').val(specialty.solid_content_min);
                    $('#edit_solid_content_max').val(specialty.solid_content_max);
                    $('#edit_shelf_life').val(specialty.shelf_life);
                    $('#edit_keterangan').val(specialty.keterangan);

                    // Tampilkan modal edit
                    $('#editSpecialtyModal').modal('show');
                },
                error: function(xhr) {
                    console.error("Error retrieving data:", xhr);
                }
            });
        });

        // Handle form submit untuk edit data
        $('#editSpecialtyForm').on('submit', function(e) {
            e.preventDefault();  // Mencegah form untuk melakukan submit default

            // Konfirmasi menggunakan SweetAlert sebelum submit
            swal({
                title: "Apakah Anda yakin?",
                text: "Data yang diubah akan disimpan!",
                icon: "warning",
                buttons: {
                    cancel: {
                        text: "Batal",
                        visible: true,
                        className: "btn btn-secondary"
                    },
                    confirm: {
                        text: "Ya, Simpan!",
                        className: "btn btn-primary"
                    }
                },
                dangerMode: true,
            }).then((willUpdate) => {
                if (willUpdate) {
                    var formData = $(this).serialize();  // Ambil data form

                    var specialtyId = $('#edit_specialty_id').val();  // Ambil ID specialty yang sedang diedit

                    // Kirim data yang sudah diedit ke server menggunakan AJAX
                    $.ajax({
                        url: `/update-specialty/${specialtyId}`,  // URL untuk mengupdate specialty berdasarkan ID
                        type: 'PUT',
                        data: formData,  // Data form yang sudah diserialisasi
                        success: function(response) {
                            // Tutup modal setelah data berhasil disimpan
                            $('#editSpecialtyModal').modal('hide');

                            // Reload DataTable dengan data terbaru
                            $('#multi-filter-select').DataTable().ajax.reload();

                            // Tampilkan alert sukses
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: 'Data berhasil diperbarui!',
                                showConfirmButton: false,
                                timer: 2000
                            });
                        },
                        error: function(xhr, status, error) {
                            // Tampilkan alert error
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Terjadi kesalahan saat memperbarui data!',
                            });
                        }
                    });
                } else {
                    // Jika pengguna membatalkan konfirmasi
                    Swal.fire({
                        icon: 'info',
                        title: 'Cancel!',
                        text: 'Perubahan data dibatalkan.',
                        showConfirmButton: false,
                        timer: 2000
                    });
                }
            });
        });
    </script>

    <!-- cek duplikasi data -->
    <!-- cek duplikasi data -->
    <script>
        document.getElementById('addPacForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Mencegah pengiriman formulir langsung

            // Mendapatkan nama produk yang diinputkan
            const productName = document.getElementById('product_name').value.trim();

            // Memeriksa apakah nama produk kosong
            if (productName === "") {
                // Menampilkan SweetAlert error jika nama produk kosong
                swal("Error", "Product name cannot be empty.", "error");
                return;
            }

            // Menampilkan konfirmasi menggunakan SweetAlert2 sebelum menyimpan data
            swal({
                title: "Are you sure?",
                text: "Do you want to save this product?",
                icon: "warning",
                buttons: ["Cancel", "Save"],
                dangerMode: true,
            })
            .then((willSave) => {
                if (willSave) {
                    // Melakukan pengecekan duplikasi produk di server menggunakan fetch (AJAX)
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
                            // Menampilkan SweetAlert error jika produk duplikat ditemukan
                            swal("Error", "Product name already exists. Please provide a unique name.", "error");
                        } else {
                            // Jika tidak ada duplikasi, submit form
                            document.getElementById('addPacForm').submit();
                        }
                    })
                    .catch(error => {
                        // Menampilkan SweetAlert error jika terjadi masalah saat pengecekan
                        console.error('Error checking product name:', error);
                        swal("Error", "There was an error checking the product name. Please try again.", "error");
                    });
                } else {
                    // Jika user memilih "Cancel", menampilkan pesan
                    swal("Your product is not saved!");
                }
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

    @if(session('success'))
        <script>
            swal({
                title: "Success",
                text: "{{ session('success') }}",
                icon: "success",
                button: "OK",
            });
        </script>
    @endif


    </body>
</html>
