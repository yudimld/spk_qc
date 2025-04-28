<!DOCTYPE html>
<html lang="en">
    @extends('layouts.head')
    @section('title', 'Assign SPK')
    <style>
        Responsiveness for tables with scroll
        .table-responsive {
            width: 100% !important;
            overflow-x: auto; /* Enable horizontal scrolling */
            overflow-y: hidden; /* Hide vertical scrollbar */
            -webkit-overflow-scrolling: touch; /* Smooth scrolling for touch devices */
            white-space: nowrap; /* Prevent text from wrapping in table cells */
        }

        /* Default table layout */
        .table {
            table-layout: fixed; /* Set to fixed for equal column widths */
            width: 100%; /* Make table take full width */
            margin-bottom: 1rem;
            border-collapse: collapse; /* Remove extra spacing between cells */
        }

        /* Ensure columns in the filter row match the table columns */
        .table > thead > tr > th, .table > tfoot > tr > th, .table > tbody > tr > td {
            text-align: center; /* Center-align content */
            vertical-align: middle; /* Vertically center content */
            padding: 4px; /* Adjust padding for better readability */
            white-space: nowrap; /* Prevent text wrapping in cells */
        }

        /* Add margin to the filter dropdown to make it more aligned */
        .table-responsive select.form-control {
            margin-bottom: 10px;
            width: 100%; /* Ensure the dropdown takes the full width of the cell */
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

        /* Perbaiki tampilan dropdown */
        .dropdown-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100%;
            position: relative; /* Pastikan dropdown menyesuaikan dengan container */
        }

        /* Dropdown input */
        .dropdown-input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        /* Perbaiki posisi dropdown */
        .dropdown-list {
            position: absolute;
            width: 100%;
            max-height: 150px;
            overflow-y: auto;
            border: 1px solid #ccc;
            background: white;
            display: none;
            z-index: 1000;
            top: 100%; /* Pastikan dropdown muncul tepat di bawah input */
            left: 0; /* Selaraskan ke kiri */
        }

        /* Pastikan tombol tidak turun sendiri */
        .button-container {
            margin-top: 10px;
            text-align: center;
            display: flex;
            justify-content: center;
        }

        /* Perbaiki posisi container */
        .form-container {
            display: flex;
            gap: 15px; /* Agar form sejajar */
            flex-wrap: wrap; /* Mencegah form bertabrakan jika layar kecil */
        }

        /* Default styles for qcStatus1, qcStatus2, and qcStatus3 */
        #qcStatus1, #qcStatus2, #qcStatus3 {
            background-color: #f0f0f0; /* Light gray */
            color: black;
        }

        /* Styles for 'pass' status */
        #qcStatus1.pass, #qcStatus2.pass, #qcStatus3.pass, #qcStatus5.pass  {
            background-color: green !important;
            color: white !important;
        }

        /* Styles for 'reject' status */
        #qcStatus1.reject, #qcStatus2.reject, #qcStatus3.reject, #qcStatus5.reject {
            background-color: red !important;
            color: white !important;
        }

        #input-container-${index} {
            margin-top: 5px; /* Jarak antara checkbox dan input text */
        }

        .custom-green-badge {
            background-color: #28a745; /* Warna hijau yang lebih gelap atau sesuaikan */
            color: white;
        }

        .badge-reassigned {
            background-color: #f8d800; /* Kuning terang */
            color: black;
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
                                <h2 class="text-white pb-2 fw-bold">Sample Status</h2>
                                <h5 class="text-white op-7 mb-2">List of Status Sample from SPK Assigned & Re-Assigned</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Table SPK Open -->
                <div class="page-inner mt--5">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h2 class="card-title">List of SPK Assigned & Re-Assigned</h2>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="multi-filter-select" class="display table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>Status</th>
                                                <th>Material Name</th>
                                                <th>No Ticket</th>
                                                <th>Batch Number</th>
                                                <th>Product Type</th>
                                                <th>Submit By</th>
                                                <th>Sample Location</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tr>
                                            <th>Status</th>
                                            <th>Material Name</th>
                                            <th>No Ticket</th>
                                            <th>Batch Number</th>
                                            <th>Product Type</th>
                                            <th>Submit By</th>
                                            <th>Sample Location</th>
                                            <th>Actions</th>
                                        </tr>
                                        <tbody>
                                            <!-- DataTable will load data here -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- Modal Detail -->
                        <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content" style="border-radius: 10px; background-color: #f9f9f9;">
                                    <div class="modal-header" style="background-color: #007bff; color: white; border-top-left-radius: 10px; border-top-right-radius: 10px;">
                                        <h5 class="modal-title" id="detailModalLabel">Detail Data SPK</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div id="modalContent">
                                            <!-- Data lainnya akan di-render di sini -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal 1 PLANT, FG, Specialty -->
                        <div class="modal fade" id="modalTest1" tabindex="-1" aria-labelledby="modalForm1Label" aria-hidden="true">
                            <div class="modal-dialog modal-xl" style="max-width: 900px;">
                                <div class="modal-content" style="border-radius: 10px; background-color: #f9f9f9;">
                                    <div class="modal-header" style="background-color: #007bff; color: white; border-bottom-left-radius: 10px; border-bottom-right-radius: 10px;">
                                        <h5 class="modal-title" id="modalForm1Label">Hasil Test Specialty (FG) oleh Analis (QC)</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>

                                    <div class="modal-body">
                                        <form id="formTest1" method="POST" action="{{ route('save.parameter.data1') }}">
                                            @csrf
                                            <input type="hidden" id="spkId1" value="{{ $spkId }}">
                                            <!-- Test Date and QC Status -->
                                            <div class="mb-3 d-flex justify-content-between">
                                                <div style="width: 48%;">
                                                    <label for="testDate1" class="form-label">Test Date and Time</label>
                                                    <input type="datetime-local" class="form-control" id="testDate1" value="{{ now()->format('Y-m-d\TH:i') }}">
                                                </div>

                                                <div style="width: 48%;">
                                                    <label for="qcStatus1" class="form-label">QC Status</label>
                                                    <input type="text" class="form-control" id="qcStatus1" value="-" readonly>
                                                </div>
                                            </div>

                                            <h2>Analytic Results</h2>
                                            <hr>

                                            <!-- Table for analytic results -->
                                            <div style="overflow-x: auto; width: 100%; padding-bottom: 10px;">
                                                <table class="table table-bordered table-hover" style="width: 100%; table-layout: auto;">
                                                    <thead>
                                                        <tr>
                                                            <th>Parameter</th>
                                                            <th>Standard</th>
                                                            <th>Ke-1</th>
                                                            <th>Ke-2</th>
                                                            <th>Avg</th>
                                                            <th>Custom</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="dynamicRowsForm1">
                                                        <!-- Rows will be dynamically added here -->
                                                    </tbody>
                                                </table>
                                            </div>

                                            <div class="modal-footer d-flex justify-content-end">
                                                <button type="button" class="btn btn-round btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-round btn-primary" id="saveButton1">Save</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal 2 PLANT,RM,SPECIALTY -->
                        <div class="modal fade" id="modalTest2" tabindex="-1" aria-labelledby="modalTestLabel2" aria-hidden="true">
                            <div class="modal-dialog modal-xl" style="max-width: 900px;">
                                <div class="modal-content" style="border-radius: 10px; background-color: #f9f9f9;">
                                    <div class="modal-header" style="background-color: #007bff; color: white; border-bottom-left-radius: 10px; border-bottom-right-radius: 10px;">
                                        <h5 class="modal-title" id="modalTestLabel2">Hasil Test Specialty (RM) oleh Analis (QC)</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="formTest2" method="POST" action="{{ route('save.parameter.data2') }}">
                                            @csrf
                                            <input type="hidden" id="spkId2" value="{{ $spkId }}">

                                            <div class="mb-3 d-flex justify-content-between">
                                                <!-- Test Date and Time -->
                                                <div style="width: 48%;">
                                                    <label for="testDate2" class="form-label">Test Date and Time</label>
                                                    <input type="datetime-local" class="form-control" id="testDate2" value="{{ now()->format('Y-m-d\TH:i') }}">
                                                </div>

                                                <!-- QC Status -->
                                                <div style="width: 48%;">
                                                    <label for="qcStatus2" class="form-label">QC Status</label>
                                                    <input type="text" class="form-control" id="qcStatus2" value="-" readonly>
                                                </div>
                                            </div>

                                            <h2>Analytic Results</h2>
                                            <hr>

                                            <!-- Table for analytic results -->
                                            <div style="overflow-x: auto; width: 100%; padding-bottom: 10px;">
                                                <table class="table table-bordered table-hover" style="width: 100%; table-layout: auto;">
                                                    <thead>
                                                        <tr>
                                                            <th>Parameter</th>
                                                            <th>Standard</th>
                                                            <th>Ke-1</th>
                                                            <th>Ke-2</th>
                                                            <th>Avg</th>
                                                            <th>Custom</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="dynamicRowsForm2">
                                                        <!-- Rows will be dynamically added here -->
                                                    </tbody>
                                                </table>
                                            </div>

                                            <div class="modal-footer d-flex justify-content-end">
                                                <button type="button" class="btn btn-round btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-round btn-primary" id="saveButton2">Save</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal 3 PLANT,FG,PAC -->
                        <div class="modal fade" id="modalTest3" tabindex="-1" aria-labelledby="modalForm3Label" aria-hidden="true">
                            <div class="modal-dialog modal-xl" style="max-width: 900px;">
                                <div class="modal-content" style="border-radius: 10px; background-color: #f9f9f9;">
                                    <div class="modal-header" style="background-color: #007bff; color: white; border-bottom-left-radius: 10px; border-bottom-right-radius: 10px;">
                                        <h5 class="modal-title" id="modalForm3Label">Hasil Test PAC oleh Analis (QC)</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>

                                    <div class="modal-body">
                                        <form id="formTest3" method="POST" action="{{ route('save.parameter.data') }}">
                                            @csrf
                                            <input type="hidden" id="spkId3" value="{{ $spkId }}">

                                            <!-- Test Date and QC Status -->
                                            <div class="mb-3 d-flex justify-content-between">
                                                <div style="width: 48%;">
                                                    <label for="testDate3" class="form-label">Test Date and Time</label>
                                                    <input type="datetime-local" class="form-control" id="testDate3" 
                                                        value="{{ \Carbon\Carbon::now('Asia/Jakarta')->format('Y-m-d\TH:i') }}">
                                                </div>

                                                <div style="width: 48%;">
                                                    <label for="qcStatus3" class="form-label">QC Status</label>
                                                    <input type="text" class="form-control" id="qcStatus3" value="-" readonly>
                                                </div>
                                            </div>

                                            <h2>Analytic Results</h2>
                                            <hr>
                                            <div style="overflow-x: auto; width: 100%; padding-bottom: 10px;">
                                                <table class="table table-bordered table-hover" style="width: 100%; table-layout: auto;">
                                                    <thead>
                                                        <tr>
                                                            <th>Parameter</th>
                                                            <th>Standard</th>
                                                            <th>Ke-1</th>
                                                            <th>Ke-2</th>
                                                            <th>Avg</th>
                                                            <th>Custom</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="dynamicRowsForm3">
                                                        <!-- Rows will be dynamically added here -->
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="modal-footer d-flex justify-content-end">
                                                <button type="button" class="btn btn-round btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-round btn-primary" id="saveButton3">Save</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal 5 PLANT,RM,PAC -->
                        <div class="modal fade" id="modalTest5" tabindex="-1" aria-labelledby="modalForm5Label" aria-hidden="true">
                            <div class="modal-dialog modal-xl" style="max-width: 900px;">
                                <div class="modal-content" style="border-radius: 10px; background-color: #f9f9f9;">
                                    <div class="modal-header" style="background-color: #007bff; color: white; border-bottom-left-radius: 10px; border-bottom-right-radius: 10px;">
                                        <h5 class="modal-title" id="modalForm5Label">Hasil Test PAC oleh Analis (QC)</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>

                                    <div class="modal-body">
                                        <form id="formTest5" method="POST" action="{{ route('save.parameter.data') }}">
                                            @csrf
                                            <input type="hidden" id="spkId5" value="{{ $spkId }}">

                                            <!-- Test Date and QC Status -->
                                            <div class="mb-3 d-flex justify-content-between">
                                                <div style="width: 48%;">
                                                    <label for="testDate5" class="form-label">Test Date and Time</label>
                                                    <input type="datetime-local" class="form-control" id="testDate5" 
                                                        value="{{ \Carbon\Carbon::now('Asia/Jakarta')->format('Y-m-d\TH:i') }}">
                                                </div>

                                                <div style="width: 48%;">
                                                    <label for="qcStatus5" class="form-label">QC Status</label>
                                                    <input type="text" class="form-control" id="qcStatus5" value="-" readonly>
                                                </div>
                                            </div>

                                            <h2>Analytic Results</h2>
                                            <hr>
                                            <div style="overflow-x: auto; width: 100%; padding-bottom: 10px;">
                                                <table class="table table-bordered table-hover" style="width: 100%; table-layout: auto;">
                                                    <thead>
                                                        <tr>
                                                            <th>Parameter</th>
                                                            <th>Standard</th>
                                                            <th>Ke-1</th>
                                                            <th>Ke-2</th>
                                                            <th>Avg</th>
                                                            <th>Custom</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="dynamicRowsForm5">
                                                        <!-- Rows will be dynamically added here -->
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="modal-footer d-flex justify-content-end">
                                                <button type="button" class="btn btn-round btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-round btn-primary" id="saveButton5">Save</button>
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
        // $(document).ready(function() {
        //     $('#multi-filter-select').DataTable({
        //         "pageLength": 5,
        //         "scrollX": true,
        //         "responsive": true,
        //         "processing": true,  // Menampilkan loading saat mengambil data
        //         "serverSide": true,  // Mengaktifkan server-side processing
        //         "ajax": {
        //             "url": "{{ route('spk.data') }}",  // URL endpoint untuk mengambil data
        //             "type": "GET",
        //             "dataSrc": function (json) {
        //                 return json.data;
        //             }
        //         },
        //         "columns": [
        //             {
        //                 "data": "status",
        //                 "render": function(data, type, row) {
        //                     var statusBadge = '';
        //                     // Menambahkan badge sesuai dengan status
        //                     switch(data) {
        //                         case 'assigned':
        //                             statusBadge = '<span class="badge badge-warning">Assigned</span>';
        //                             break;
        //                         case 're-assigned':
        //                             statusBadge = '<span class="badge badge-reassigned">Re-assigned</span>';
        //                             break;
        //                         default:
        //                             statusBadge = '<span class="badge badge-primary">Unknown</span>';
        //                     }
        //                     return statusBadge;  // Mengembalikan status dengan badge
        //                 }
        //             },
        //             { "data": "nama_material" },
        //             // { "data": "department" },
        //             { "data": "no_ticket" },
        //             { "data": "batch_number" },
        //             { "data": "product_type" },
        //             { "data": "assign_by" },
        //             { "data": "lokasi" },
        //             { "data": "actions" }
        //         ],
        //         initComplete: function () {
        //             this.api().columns().every(function () {
        //                 var column = this;

        //                 // Membuat dropdown filter untuk setiap kolom
        //                 var select = $('<select class="form-control"><option value="">Filter</option></select>')
        //                     .appendTo($(column.footer()).empty())
        //                     .on('change', function () {
        //                         var val = $.fn.dataTable.util.escapeRegex($(this).val());

        //                         // Mencari berdasarkan data-status jika kolom adalah Status
        //                         if (column.index() === 0) { // hanya untuk kolom pertama (Status)
        //                             column
        //                                 .search(val ? '^' + val + '$' : '', true, false)
        //                                 .draw();
        //                         } else {
        //                             column
        //                                 .search(val ? '^' + val + '$' : '', true, false)
        //                                 .draw();
        //                         }
        //                     });

        //                 // Menambahkan pilihan unik ke dropdown filter
        //                 column.data().unique().sort().each(function (d, j) {
        //                     // Jika kolom adalah 'status', kita gunakan pilihan custom
        //                     if (column.index() === 0) {  // Kolom Status
        //                         let statusOptions = ['open', 'ready', 'assigned', 'request to close', 'closed', 're-assigned', 'unknown'];
        //                         statusOptions.forEach(function(status) {
        //                             select.append('<option value="' + status + '">' + status.charAt(0).toUpperCase() + status.slice(1) + '</option>');
        //                         });
        //                     } else {
        //                         // Untuk kolom lain, menambahkan pilihan berdasarkan data yang ada
        //                         select.append('<option value="' + d + '">' + d + '</option>');
        //                     }
        //                 });
        //             });
        //         }
        //     });
        // });
        $(document).ready(function() {
            $('#multi-filter-select').DataTable({
                "pageLength": 5, // Jumlah baris per halaman
                "scrollX": true, // Mengaktifkan scroll horizontal jika tabel terlalu lebar
                "responsive": true, // Membuat tabel responsif
                "processing": true, // Menampilkan loading saat mengambil data
                "serverSide": true, // Mengaktifkan server-side processing
                "ajax": {
                    "url": "{{ route('spk.data') }}", // Endpoint untuk mengambil data dari server
                    "type": "GET",
                    "dataSrc": function (json) {
                        return json.data; // Mengambil data dari response JSON
                    }
                },
                "columns": [
                    { "data": "status" },
                    { "data": "nama_material" },
                    { "data": "no_ticket" },
                    { "data": "batch_number" },
                    { "data": "product_type" },
                    { "data": "assign_by" },
                    { "data": "lokasi" },
                    { 
                        "data": "actions",
                        "orderable": false, // Kolom actions tidak bisa diurutkan
                        "searchable": false // Kolom actions tidak bisa dicari
                    }
                ],
                initComplete: function () {
                    this.api().columns().every(function () {
                        var column = this;

                        // Membuat dropdown filter untuk setiap kolom (kecuali Actions)
                        if (column.index() !== 7) {
                            var select = $('<select class="form-control"><option value="">Filter</option></select>')
                                .appendTo($(column.footer()).empty())
                                .on('change', function () {
                                    var val = $.fn.dataTable.util.escapeRegex($(this).val());
                                    column.search(val ? '^' + val + '$' : '', true, false).draw();
                                });

                            column.data().unique().sort().each(function (d, j) {
                                select.append('<option value="' + d + '">' + d + '</option>');
                            });
                        }
                    });
                }
            });
        });

    </script>

    <!-- Detail modal -->
    <script>
        // Event listener untuk tombol detail
        $(document).on('click', '#btnDetail', function() {
            var spkId = $(this).data('id'); // Ambil ID dari tombol yang diklik

            // Kirim request untuk mendapatkan detail berdasarkan ID
            $.ajax({
                url: '/assign/detail/' + spkId, // Endpoint API untuk mendapatkan detail data SPK berdasarkan ID
                method: 'GET',
                success: function(response) {
                    var content = '<div style="display: flex; flex-wrap: wrap; gap: 20px;">';  // Flexbox untuk dua kolom

                    // Iterasi dan masukkan data ke dalam kolom kiri dan kanan
                    for (var key in response) {
                        // Mengecualikan data 'updated_at', 'created_at', '_id', dan 'id' dari modal
                        if (response.hasOwnProperty(key) && key !== 'updated_at' && key !== 'created_at' && key !== '_id' && key !== 'id') {
                            var label = key.charAt(0).toUpperCase() + key.slice(1);  // Label untuk field

                            // Jika data adalah selected_checkboxes (untuk checkbox), proses dan tampilkan dalam bentuk list
                            if (key === 'selected_checkboxes') {
                                content += `
                                    <div style="flex: 1; min-width: 200px;">
                                        <strong>Request Parameter:</strong>
                                        <div style="border: 1px solid #ddd; padding: 8px; margin-top: 4px; background-color: #fff;">
                                            <ul style="list-style-type: disc; margin-left: 20px;">
                                `;

                                // Mengambil data checkbox yang disimpan dalam format JSON
                                var checkboxes = JSON.parse(response[key]);
                                var checkboxHtml = '';
                                
                                // Iterasi untuk menghasilkan list checkbox yang dicentang
                                for (var checkbox in checkboxes) {
                                    if (checkboxes.hasOwnProperty(checkbox)) {
                                        checkboxHtml += `
                                            <li>${checkboxes[checkbox]}</li>
                                        `;
                                    }
                                }

                                content += checkboxHtml;  // Menambahkan list checkbox yang dicentang
                                content += `
                                            </ul>
                                        </div>
                                    </div>
                                `;
                            } else {
                                content += `
                                    <div style="flex: 1; min-width: 200px;">
                                        <strong>${label}:</strong>
                                        <div style="border: 1px solid #ddd; padding: 8px; margin-top: 4px; background-color: #fff;">
                                            ${response[key] ? response[key] : 'N/A'}
                                        </div>
                                    </div>
                                `;
                            }
                        }
                    }

                    content += '</div>';  // Tutup flexbox

                    // Sekarang tambahkan parameters_data di bagian bawah modal setelah seluruh data lainnya
                    var parametersContent = '<div style="margin-top: 20px;">'; // Tambahkan margin untuk jarak
                    if (response.parameters_data && response.parameters_data.length > 0) {
                        parametersContent += `<strong>Parameters Data:</strong>
                            <div style="border: 1px solid #ddd; padding: 8px; background-color: #fff;">
                                <div style="display: flex; flex-wrap: wrap; gap: 10px;">
                        `;
                        
                        response.parameters_data.forEach(function(param) {
                            parametersContent += `
                                <div style="flex: 1 1 45%; min-width: 200px; padding: 10px; border: 1px solid #ddd; background-color: #f9f9f9;">
                                    <strong>Parameter Name:</strong> ${param.parameter_name || 'N/A'} <br>
                                    <strong>Standard:</strong> ${param.standard || 'N/A'} <br>
                                    <strong>Ke1:</strong> ${param.ke1 || 'N/A'} <br>
                                    <strong>Ke2:</strong> ${param.ke2 || 'N/A'} <br>
                                    <strong>Avg:</strong> ${param.avg || 'N/A'} <br>
                                    <strong>Custom Input:</strong> ${param.custom_input || '-'} <br>
                                </div>
                            `;
                        });
                        parametersContent += '</div></div>';
                    } else {
                      
                    }
                    parametersContent += '</div>';

                    // Tambahkan parameters_data ke modalContent yang sudah ada
                    $('#modalContent').html(content); // Pastikan modalContent di-update dulu
                    $('#modalContent').append(parametersContent); // Menambahkan parameters_data di bawah modal content

                    // Tampilkan modal
                    $('#detailModal').modal('show');  
                }
            });
        });
    </script>

    <!-- logika show modal for submit assign -->
    <script>
        $(document).ready(function() {
            // Pastikan event listener dipasang dengan benar menggunakan event delegation
            $(document).on('click', '#btnSubmitAssign', function() {
                var spkId = $(this).data('id');
                // Lakukan request AJAX untuk mendapatkan data berdasarkan ID
                $.ajax({
                    url: '/get-parameters', 
                    method: 'POST',
                    data: {
                        id: spkId,
                        _token: $('meta[name="csrf-token"]').attr('content') // CSRF token untuk keamanan
                    },

                    success: function(response) {
                        const modalId = openModalBasedOnCondition(response.spk);
                        // Cek apakah data SPK atau pac_data/specialty_data lengkap
                        if (!response.spk || 
                            (response.spk.product_type === 'PAC' && !response.pac_data) || 
                            (response.spk.product_type === 'Specialty' && !response.specialty_data)) {
                            console.log("Data tidak lengkap!");
                            return; // Jika data tidak lengkap, hentikan eksekusi
                        }
                        window.currentPACResponse = response;

                        // Menampilkan modal berdasarkan kondisi
                        openModalBasedOnCondition(response.spk);

                        // Menampilkan checkbox yang dipilih untuk pacData atau specialtyData
                        if (response.spk.product_type === 'PAC') {
                            showSelectedCheckboxes(response, modalId);
                        } else {
                            // showSpecialtyData(response.specialty_data);
                            showSpecialtyData(response, modalId);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log("Status: " + status);
                        console.log("Error: " + error);
                        console.log(xhr.responseText);
                    }

                });
            });

            // Fungsi untuk membuka modal berdasarkan kondisi
            function openModalBasedOnCondition(spk) {
                if (spk.department === 'Plant' && spk.product_type === 'PAC' && spk.material_type === 'FG') {
                    // Menampilkan modal untuk PAC FG
                    $('#modalTest3').modal('show');
                    $('#spkId3').val(spk.id);
                } else if (spk.department === 'Plant' && spk.product_type === 'PAC' && spk.material_type === 'RM') {
                    // Menampilkan modal untuk PAC RM
                    $('#modalTest5').modal('show');
                    $('#spkId5').val(spk.id);
                } else if (spk.department === 'Plant' && spk.material_type === 'FG' && spk.product_type === 'Specialty') {
                    // Menampilkan modal untuk Specialty FG
                    $('#modalTest1').modal('show');
                    $('#spkId1').val(spk.id);
                } else if (spk.department === 'Plant' && spk.material_type === 'RM' && spk.product_type === 'Specialty') {
                    // Menampilkan modal untuk Specialty RM
                    $('#modalTest2').modal('show');
                    $('#spkId2').val(spk.id);
                } else {
                    console.log("Tidak ada modal yang sesuai dengan kondisi.");
                }
            }

            // Modal Test 3 (PAC FG)
            $('#modalTest3').on('shown.bs.modal', function () {
                if (window.currentPACResponse) {
                    console.log("[ModalTest3] PAC Data loaded from cache:", window.currentPACResponse);
                    showSelectedCheckboxes(window.currentPACResponse, 'modalTest3');
                }
            });

            // Modal Test 5 (PAC RM)
            $('#modalTest5').on('shown.bs.modal', function () {
                if (window.currentPACResponse) {
                    console.log("[ModalTest5] PAC Data loaded from cache:", window.currentPACResponse);
                    showSelectedCheckboxes(window.currentPACResponse, 'modalTest5');
                }
            });


            // === STEP 4: showSelectedCheckboxes function ===
            function showSelectedCheckboxes(response, modalId) {
                if (!response || !response.pac_data) {
                    console.error("PAC data not found in response.");
                    return;
                }

                const pacData = response.pac_data;
                const targetForm = $(`#dynamicRowsForm${modalId === 'modalTest3' ? '3' : '5'}`);
                targetForm.empty();

                const pacParameters = [
                    'Appearance', 'TurbidityJIT', 'SO4', 'pH1', 'AI2O3', 'Basicity', 'SG',
                    'Kadar', 'PhPure', 'Fe', 'Moisture', 'Cl', 'KelarutanHCl'
                ];

                const specialInputParams = ['Appearance', 'KelarutanHCL'];

                const pacAttributes = pacParameters.map(param => ({
                    name: param,
                    value: getStandardValue(param, pacData)
                }));

                const filteredAttributes = pacAttributes.filter(attr =>
                    attr.value && attr.value !== 'Not Available' && attr.value !== '-' && attr.value !== null
                );

                if (filteredAttributes.length === 0) return;

                filteredAttributes.forEach((attr, index) => {
                    let rowHTML = `
                        <tr data-index="${index}">
                            <td>${attr.name}</td>
                            <td id="standardPAC-${index}">${attr.value}</td>
                           
                    `;

                    if (specialInputParams.includes(attr.name)) {
                        rowHTML += `
                            <td colspan="3"></td>
                            <td>
                                <select class="form-control" id="text-input-${index}" data-index="${index}" required>
                                    <option value="-">-</option>
                                    <option value="conform">Conform</option>
                                    <option value="non-conform">Non-Conform</option>
                                </select>
                            </td>

                        `;
                    } else {
                        rowHTML += `
                            <td><input type="number" class="form-control" id="ke1-pac-${index}" value="0" data-index="${index}" step="any"></td>
                            <td><input type="number" class="form-control" id="ke2-pac-${index}" value="0" data-index="${index}" step="any"></td>
                            <td><input type="number" class="form-control" id="avg-pac-${index}" value="0" readonly disabled></td>
                            <td>
                                <input type="checkbox" class="form-check-input" id="checkbox-pac-${index}" data-index="${index}">
                                <div id="input-container-pac-${index}" style="display:none;">
                                    <input type="text" class="form-control" id="text-input-override-pac-${index}" placeholder="Input Standard" required>
                                </div>
                            </td>
                        `;
                    }

                    rowHTML += `</tr>`;
                    targetForm.append(rowHTML);
                    setupDropdownEventListener(modalId);  
                });

                const keterangan = response.spk.keterangan || '';
                const keteranganRow = `
                    <tr>
                        <td colspan="5">
                            <div class="form-group mt-3">
                                <label><strong>Catatan Tambahan:</strong></label>
                                <textarea 
                                    class="form-control" 
                                    name="catatan_tambahan"
                                    rows="3" 
                                    style="background-color: #fff; border: 1px solid #ced4da;"
                                >${keterangan}</textarea>
                            </div>
                        </td>
                    </tr>
                `;
                targetForm.append(keteranganRow);

                // Rebind checkbox handler
                targetForm.off('change', 'input[type="checkbox"]').on('change', 'input[type="checkbox"]', function () {
                    const index = $(this).data('index');
                    const inputContainer = $(`#input-container-pac-${index}`);
                    const overrideInput = $(`#text-input-override-pac-${index}`);
                    const avgInput = $(`#avg-pac-${index}`);
                    const modalId = $(this).closest('.modal').attr('id');

                    if ($(this).prop('checked')) {
                        inputContainer.show();
                        overrideInput.prop('required', true);
                        avgInput.css('color', 'black');
                    } else {
                        inputContainer.hide();
                        overrideInput.prop('required', false);
                        updateAvg(index, modalId);
                    }

                    updateQCStatus(modalId);
                });

                // Menambahkan pemanggilan updateQCStatus untuk memperbarui status QC setelah rata-rata dihitung
                targetForm.on('input', 'input[id^="ke1-pac-"], input[id^="ke2-pac-"]', function () {
                    const index = $(this).data('index');
                    updateAvg(index, modalId);  // Memperbarui nilai rata-rata setelah input Ke-1 atau Ke-2 diubah
                    updateQCStatus(modalId);  // Memperbarui status QC setelah rata-rata dihitung
                });
            }     

            // Fungsi untuk modalTest 1 dan 2 (SPECIALTY)
            function showSpecialtyData(response) {
                var specialtyData = response.specialty_data; // Data specialty yang sudah difilter di controller
                var dynamicRowsForm1 = $('#dynamicRowsForm1'); // Untuk modalTest1
                var dynamicRowsForm2 = $('#dynamicRowsForm2'); // Untuk modalTest2

                var targetForm = dynamicRowsForm1; // Default untuk modalTest1

                // Tentukan form target berdasarkan modal yang dipilih
                if (response.spk.material_type === 'RM') {
                    targetForm = dynamicRowsForm2; 
                    modalId = 'modalTest2';
                } else {
                    targetForm = dynamicRowsForm1; 
                    modalId = 'modalTest1';
                }

                targetForm.empty(); // Clear old content if any

                // Daftar parameter yang ingin ditampilkan (yang sudah dikirim dari controller)
                var specialtyAttributes = [
                    { name: 'Appearance', value: specialtyData.appearance },
                    { name: 'Solution pH(%)', value: specialtyData.solution },
                    { name: 'pH Value', value: specialtyData.ph_value },
                    { name: 'SG', value: specialtyData.sg },
                    { name: 'SG 0,1%', value: specialtyData.sg_01 },
                    { name: 'Viscosity', value: specialtyData.viscosity },
                    { name: 'Viscosity 0,1%', value: specialtyData.viscosity_01 },
                    { name: 'Purity', value: specialtyData.purity },
                    { name: 'Dry Weight', value: specialtyData.dry_weight },
                    { name: 'Moisture', value: specialtyData.moisture },
                    { name: 'Solid Content', value: specialtyData.solid_content },
                    { name: 'Specific Gravity', value: specialtyData.specific_gravity },
                    { name: 'Specific Gravity 0,1%', value: specialtyData.specific_gravity_01 },
                    { name: 'Residue On Ignition', value: specialtyData.residue_on_ignition }
                ];

                // Filter hanya atribut yang memiliki nilai valid (tidak null atau '-')
                var filteredAttributes = specialtyAttributes.filter(function(attr) {
                    return attr.value && attr.value !== '-' && attr.value !== null; // Hanya yang memiliki nilai valid
                });

                // Jika tidak ada atribut yang cocok, beri notifikasi
                if (filteredAttributes.length === 0) {
                    return;
                }

                // Loop untuk menampilkan setiap baris hanya jika value-nya valid (bukan null atau '-')
                filteredAttributes.forEach(function(attr, index) {
                    // Membuat baris untuk tabel
                    var rowHTML = `
                        <tr data-index="${index}">
                            <td>${attr.name}</td>
                            <td id="standardSpecialty-${index}">${attr.value}</td>
                    `;

                    // Logika untuk menyembunyikan input ke1, ke2, avg jika parameter adalah "Appearance" atau "Solution PH(%)"
                    if (attr.name === "Appearance") {
                        rowHTML += `
                            <td colspan="3"></td> <!-- Sembunyikan kolom ke-1 dan ke-2 -->
                            <td>
                                <select class="form-control" id="text-input-${index}" data-index="${index}" required>
                                    <option value="-">-</option>
                                    <option value="conform">Conform</option>
                                    <option value="non-conform">Non-Conform</option>
                                </select>
                            </td>
                        `;
                    } else if (attr.name === "Solution pH(%)") {
                        rowHTML += `
                            <td colspan="4"></td> <!-- Sembunyikan semua kolom input -->
                        `;
                    } else {
                        rowHTML += `
                            <td><input type="number" class="form-control" id="ke1-${index}" value="0" data-index="${index}" step="any"></td>
                            <td><input type="number" class="form-control" id="ke2-${index}" value="0" data-index="${index}" step="any"></td>
                            <td><input type="number" class="form-control" id="avg-${index}" value="0" readonly></td>
                            <td>
                                <input type="checkbox" class="form-check-input" id="checkbox-${index}" data-index="${index}">
                                <div id="input-container-${index}" style="display:none;">
                                    <input type="text" class="form-control" id="text-input-${index}" placeholder="Input Standard" required>
                                </div>
                            </td>
                        `;
                    }


                    targetForm.append(rowHTML); 
                    setupDropdownEventListener(modalId);
                });

                const keterangan = response.spk.keterangan || '';
                const keteranganRow = `
                    <tr>
                        <td colspan="5">
                            <div class="form-group mt-3">
                                <label><strong>Catatan Tambahan:</strong></label>
                                <textarea 
                                    class="form-control" 
                                    name="catatan_tambahan"
                                    rows="3" 
                                    style="background-color: #fff; border: 1px solid #ced4da;"
                                >${keterangan}</textarea>
                            </div>
                        </td>
                    </tr>
                `;
                targetForm.append(keteranganRow);

                targetForm.append('</tbody>'); // Menutup body tabel

                // Tambahkan di sini
                targetForm.on('input', 'input[id^="ke1-"], input[id^="ke2-"]', function() {
                    const index = $(this).data('index');
                    updateAvg(index, modalId);
                    updateQCStatus(modalId);
                });

                // Menambahkan pemanggilan updateQCStatus untuk memperbarui status QC setelah input diubah
                $('#dynamicRowsForm1, #dynamicRowsForm2').on('change', 'input[type="checkbox"]', function() {
                    var index = $(this).data('index');
                    var inputText = $('#text-input-' + index);
                    var avgInput = $('#avg-' + index);
                    var modalId = $(this).closest('.modal').attr('id'); // Mendapatkan modal ID

                    // Memastikan kita memperbarui input saat checkbox diubah
                    if ($(this).prop('checked')) {
                        $('#input-container-' + index).show();  // Menampilkan input-container
                        inputText.prop('required', true);  // Menandai input text sebagai required
                        avgInput.css('color', 'black');  // Menyeting warna avg input jika perlu
                    } else {
                        $('#input-container-' + index).hide();  // Menyembunyikan input-container
                        inputText.prop('required', false);  // Menghapus tanda required
                        updateAvg(index, modalId);  // Memperbarui avg ketika checkbox tidak dicentang
                    }

                    // Memperbarui status QC setelah input berubah
                    updateQCStatus(modalId);
                    
                });
            }

            // Fungsi untuk mengambil nilai standar berdasarkan parameter dan pacData
            function getStandardValue(parameter, pacData) {
                if (!pacData) {
                    console.error('pacData not found');
                    return 'Not Available';
                }

                // Fungsi pengecekan nilai valid
                function isValid(value) {
                    return value && value !== ' - ' && value !== null && value !== '';
                }

                switch(parameter) {
                    case 'Appearance':
                        return isValid(pacData.appearance) ? pacData.appearance : 'Not Available';
                    case 'TurbidityJIT':
                        return isValid(pacData.turbidity) ? pacData.turbidity : 'Not Available';
                    case 'SO4':
                        return isValid(pacData.so4) ? pacData.so4 : 'Not Available';
                    case 'pH1':
                        return isValid(pacData.ph_1_solution) ? pacData.ph_1_solution : 'Not Available';
                    case 'AI2O3':
                        return isValid(pacData.ai2o3) ? pacData.ai2o3 : 'Not Available';
                    case 'Basicity':
                        return isValid(pacData.basicity) ? pacData.basicity : 'Not Available';
                    case 'SG':
                        return isValid(pacData.specific_gravity) ? pacData.specific_gravity : 'Not Available';
                    case 'Kadar':
                        return isValid(pacData.kadar) ? pacData.kadar : 'Not Available';
                    case 'PhPure':
                        return isValid(pacData.ph_pure) ? pacData.ph_pure : 'Not Available';
                    case 'Fe':
                        return isValid(pacData.fe) ? pacData.fe : 'Not Available';
                    case 'Moisture':
                        return isValid(pacData.moisture) ? pacData.moisture : 'Not Available';
                    case 'Cl':
                        return isValid(pacData.cl) ? pacData.cl : 'Not Available';
                    case 'KelarutanHCl':
                        return isValid(pacData.kelarutan_hcl) ? pacData.kelarutan_hcl : 'Not Available';
                    default:
                        return 'Not Available';
                }
            }

            function getStandardSpecialtyValue(parameter, specialtyData) {
                if (!specialtyData) {
                    console.error('specialtyData not found');
                    return 'Not Available';
                }

                // Fungsi untuk memeriksa apakah nilai valid
                function isValid(value) {
                    return value && value !== ' - ' && value !== null && value !== '-';
                }

                switch(parameter) {
                    case 'Appearance':
                        return isValid(specialtyData.appearance) ? specialtyData.appearance : 'Not Available';
                    case 'Solution PH(%)':
                        return isValid(specialtyData.solution) ? specialtyData.solution : 'Not Available';
                    case 'pH Value':
                        return isValid(specialtyData.ph_value) ? specialtyData.ph_value : 'Not Available';
                    case 'SG':
                        return isValid(specialtyData.sg) ? specialtyData.sg : 'Not Available';  // Handle empty value
                    case 'SG 0,1%':
                        return isValid(specialtyData.sg_01) ? specialtyData.sg_01 : 'Not Available'; // Handle empty value
                    case 'Viscosity':
                        return isValid(specialtyData.viscosity) ? specialtyData.viscosity : 'Not Available';
                    case 'Viscosity 0,1%':
                        return isValid(specialtyData.viscosity_01) ? specialtyData.viscosity_01 : 'Not Available';
                    case 'Purity':
                        return isValid(specialtyData.purity) ? specialtyData.purity : 'Not Available';
                    case 'Dry Weight':
                        return isValid(specialtyData.dry_weight) ? specialtyData.dry_weight : 'Not Available';
                    case 'Moisture':
                        return isValid(specialtyData.moisture) ? specialtyData.moisture : 'Not Available';
                    case 'Solid Content':
                        return isValid(specialtyData.solid_content) ? specialtyData.solid_content : 'Not Available';
                    case 'Specific Gravity':
                        return isValid(specialtyData.specific_gravity) ? specialtyData.specific_gravity : 'Not Available';
                    case 'Specific Gravity 0,1%':
                        return isValid(specialtyData.specific_gravity_01) ? specialtyData.specific_gravity_01 : 'Not Available';
                    case 'Residue On Ignition':
                        return isValid(specialtyData.residue_on_ignition) ? specialtyData.residue_on_ignition : 'Not Available';
                    default:
                        return 'Not Available';
                }
            }
                

            // function updateAvg(index, modalId) { 
            function updateAvg(index, modalId) {
                var ke1, ke2, avgInput, standardValue;

                if (modalId === 'modalTest3' || modalId === 'modalTest5') {
                    // Untuk PAC
                    ke1 = parseFloat($(`#ke1-pac-${index}`).val()) || 0;
                    ke2 = parseFloat($(`#ke2-pac-${index}`).val()) || 0;
                    avgInput = $(`#avg-pac-${index}`);
                    standardValue = $(`#standardPAC-${index}`).text();
                } else {
                    // Untuk Specialty (modalTest1 & modalTest2)
                    ke1 = parseFloat($(`#${modalId} #ke1-${index}`).val()) || 0;
                    ke2 = parseFloat($(`#${modalId} #ke2-${index}`).val()) || 0;
                    avgInput = $(`#${modalId} #avg-${index}`);
                    standardValue = $(`#${modalId} #standardSpecialty-${index}`).text();
                }

                // Hitung rata-rata
                var avg = (ke1 + ke2) / 2;
                avgInput.val(avg.toFixed(3));  // <- Ini yang benar

                // Cek apakah avg dalam range
                var isInRange = checkIfInRange(avg, standardValue);

                // Ubah warna
                if (isInRange) {
                    avgInput.css('color', 'black');
                } else {
                    avgInput.css('color', 'red');
                }

                updateQCStatus(modalId);
            }

            // Fungsi untuk memeriksa apakah nilai avg berada dalam rentang standar
            function checkIfInRange(avg, standardValue) {
                if (typeof standardValue === 'string' && standardValue.includes(' - ')) {
                    // Misalkan standar nilai dalam format "min - max"
                    var range = standardValue.split(' - '); // Pisahkan nilai min dan max
                    var min = parseFloat(range[0]); // Mengambil nilai min
                    var max = parseFloat(range[1]); // Mengambil nilai max
                    avg = parseFloat(avg.toFixed(2)); // Membulatkan nilai avg hingga 2 desimal

                    return avg >= min && avg <= max; // Memeriksa apakah avg berada di dalam rentang min dan max
                } else {
                    // Jika nilai tidak dalam format min - max, kita anggap sebagai nilai valid dan lewati pengecekan
                    return true; // Abaikan pengecekan rentang
                }
            }

            // Pemasangan event listener dropdown (setelah elemen dimuat)
            function setupDropdownEventListener(modalId) {
                $(`#${modalId} select[id^="text-input-"]`).off('change').on('change', function() {
                    updateQCStatus(modalId); // Panggil updateQCStatus saat dropdown berubah
                });
            }

            // Fungsi untuk memperbarui status QC
            function updateQCStatus(modalId) {
                let allConditionsMet = true;
                let hasNonConform = false;

                $(`#${modalId} tr[data-index]`).each(function() {
                    const index = $(this).data('index');
                    
                    // 1. Cek dropdown (Appearance)
                    const dropdown = $(this).find('select');
                    if (dropdown.length > 0 && dropdown.val() === 'non-conform') {
                        hasNonConform = true;
                    }

                    // 2. Cek avg PAC
                    let avgInput;
                    if (modalId === 'modalTest3' || modalId === 'modalTest5') {
                        avgInput = $(`#avg-pac-${index}`);
                    } else {
                        avgInput = $(`#avg-${index}`);
                    }

                    if (avgInput.length > 0 && avgInput.css('color') === 'rgb(255, 0, 0)') {
                        allConditionsMet = false;
                    }
                });

                if (hasNonConform || !allConditionsMet) {
                    setQCStatus(modalId, "Reject");
                } else {
                    setQCStatus(modalId, "Pass");
                }
            }

            function setQCStatus(modalId, status) {
                const classToAdd = status === "Pass" ? 'pass' : 'reject';
                const classToRemove = status === "Pass" ? 'reject' : 'pass';

                // Mengupdate elemen status QC dengan benar
                $(`#${modalId} #qcStatus1, #${modalId} #qcStatus2, #${modalId} #qcStatus3, #${modalId} #qcStatus5`)
                    .val(status)
                    .removeClass(classToRemove)
                    .addClass(classToAdd);
            }

            // Memperbarui status QC setiap kali input berubah
            $(document).on('input change', 'input[type="number"]', function() {
                var index = $(this).data('index');
                var modalId = $(this).closest('.modal').attr('id'); // Mendapatkan ID modal aktif
                updateAvg(index, modalId);  // Memanggil fungsi updateAvg untuk memperbarui rata-rata

                // Memperbarui status QC setelah input berubah
                updateQCStatus(modalId);
            });      
        });
    </script>

    <!-- save data test -->
    <!-- form 3 -->
    <script>
        $(document).ready(function() {
            $('#saveButton3').on('click', function(e) {
                e.preventDefault();
                const keterangan = $('#modalTest3 textarea[name="catatan_tambahan"]').val();
                var testDate = $('#testDate3').val();
                var qcStatus = $('#qcStatus3').val();
                var spkId = $('#spkId3').val();
                var formData = [];

                $('#dynamicRowsForm3 tr').each(function(index) {
                    var parameter = $(this).find('td:first').text().trim();
                    var standard = $(this).find(`#standardPAC-${index}`).text().trim() || null;
                    var ke1 = $(this).find(`#ke1-pac-${index}`).val();
                    var ke2 = $(this).find(`#ke2-pac-${index}`).val();
                    var avg = $(this).find(`#avg-pac-${index}`).val();
                    var customInput = $(this).find(`#text-input-${index}`).val();

                    formData.push({
                        parameter_name: parameter,
                        standard: standard,
                        ke1: ke1 === '' ? null : ke1,
                        ke2: ke2 === '' ? null : ke2,
                        avg: avg === '' ? null : avg,
                        custom_input: customInput === '' ? null : customInput
                    });
                });

                swal({
                    title: "Are You Sure?",
                    text: "Once submitted, data cannot be changed!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true
                }).then((willSubmit) => {
                    if (willSubmit) {
                        $.ajax({
                            url: '{{ route('save.parameter.data') }}',
                            method: 'POST',
                            data: {
                                spkId: spkId,
                                testDate: testDate,
                                qcStatus: qcStatus,
                                formData: formData,
                                keterangan: keterangan,
                                _token: $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                swal({
                                    title: "Sukses!",
                                    text: "Data Saved Successfully!",
                                    icon: "success",
                                    button: "OK"
                                }).then(() => {
                                    $('#modalTest3').modal('hide');
                                    $('#multi-filter-select').DataTable().ajax.reload();
                                });
                            },
                            error: function(xhr, status, error) {
                                console.error("Error Response:", xhr.responseText);

                                let errorMsg = "There was an error saving the test results. Please try again.";
                                try {
                                    let res = JSON.parse(xhr.responseText);
                                    if (res.message) {
                                        errorMsg = res.message;
                                    }
                                } catch (e) {
                                    // Not JSON or other issue
                                }

                                swal({
                                    title: "Error!",
                                    text: errorMsg,
                                    icon: "error",
                                    button: "OK"
                                });
                            }
                        });
                    } else {
                        swal("Dibatalkan!", "Data tidak disimpan.", "info");
                    }
                });
            });
        });
    </script>

    <!-- save button 5  -->
    <script>
        $(document).ready(function() {
            $('#saveButton5').on('click', function(e) {
                e.preventDefault();
                const keterangan = $('#modalTest5 textarea[name="catatan_tambahan"]').val();
                var testDate = $('#testDate5').val();
                var qcStatus = $('#qcStatus5').val();
                var spkId = $('#spkId5').val();
                var formData = [];

                $('#dynamicRowsForm5 tr').each(function(index) {
                    var parameter = $(this).find('td:first').text().trim();
                    var standard = $(this).find(`#standardPAC-${index}`).text().trim() || null;
                    var ke1 = $(this).find(`#ke1-pac-${index}`).val();
                    var ke2 = $(this).find(`#ke2-pac-${index}`).val();
                    var avg = $(this).find(`#avg-pac-${index}`).val();
                    var customInput = $(this).find(`#text-input-${index}`).val();

                    formData.push({
                        parameter_name: parameter,
                        standard: standard,
                        ke1: ke1 === '' ? null : ke1,
                        ke2: ke2 === '' ? null : ke2,
                        avg: avg === '' ? null : avg,
                        custom_input: customInput === '' ? null : customInput
                    });
                });

                swal({
                    title: "Are You Sure?",
                    text: "Once submitted, data cannot be changed!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true
                }).then((willSubmit) => {
                    if (willSubmit) {
                        $.ajax({
                            url: '{{ route("save.parameter.data.modal5") }}',
                            method: 'POST',
                            data: {
                                spkId: spkId,
                                testDate: testDate,
                                qcStatus: qcStatus,
                                formData: formData,
                                keterangan: keterangan,
                                _token: $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                swal({
                                    title: "Sukses!",
                                    text: "Data Saved Successfully!",
                                    icon: "success",
                                    button: "OK"
                                }).then(() => {
                                    $('#modalTest5').modal('hide');
                                    $('#multi-filter-select').DataTable().ajax.reload();
                                });
                            },
                            error: function(xhr, status, error) {
                                console.error("Error Response:", xhr.responseText);

                                let errorMsg = "There was an error saving the test results. Please try again.";
                                try {
                                    let res = JSON.parse(xhr.responseText);
                                    if (res.message) {
                                        errorMsg = res.message;
                                    }
                                } catch (e) {}

                                swal({
                                    title: "Error!",
                                    text: errorMsg,
                                    icon: "error",
                                    button: "OK"
                                });
                            }
                        });
                    } else {
                        swal("Dibatalkan!", "Data tidak disimpan.", "info");
                    }
                });
            });
        });
    </script>

    <!-- form 2 -->
    <script>
        $(document).ready(function() {  
            $('#saveButton2').on('click', function(e) {
                e.preventDefault(); // Menghindari form submit default
                const keterangan = $('#modalTest2 textarea[name="catatan_tambahan"]').val();
                var testDate = $('#testDate2').val();  // Ambil tanggal dan waktu test
                var qcStatus = $('#qcStatus2').val();  // Ambil status QC
                var spkId = $('#spkId2').val();  // Ambil ID SPK yang dipilih dari input tersembunyi di Form 2
                var formData = [];

                // Mengambil data parameter dari form
                $('#dynamicRowsForm2 tr').each(function(index) {
                    var parameter = $(this).find('td:first').text();  // Ambil parameter
                    var appearance = $(this).find(`#appearance-${index}`).val();  // Ambil nilai appearance
                    var solution = $(this).find(`#solution-${index}`).val();  // Ambil nilai solution
                    var standard = $(this).find(`#standardSpecialty-${index}`).text();  // Ambil nilai standard
                    var ke1 = $(this).find(`#ke1-${index}`).val();  // Ambil nilai ke1
                    var ke2 = $(this).find(`#ke2-${index}`).val();  // Ambil nilai ke2
                    var avg = $(this).find(`#avg-${index}`).val();  // Ambil nilai avg
                    var customInput = $(this).find(`#text-input-${index}`).val();  // Ambil custom input

                    // Pastikan ke1, ke2, avg diubah menjadi null jika kosong atau undefined
                    ke1 = (ke1 === '' || ke1 === undefined) ? null : ke1;
                    ke2 = (ke2 === '' || ke2 === undefined) ? null : ke2;
                    avg = (avg === '' || avg === undefined) ? null : avg;

                    // Jika "Appearance" atau "Solution PH(%)", pastikan standard ada
                    if ((parameter === "Appearance" || parameter === "Solution PH(%)") && standard) {
                        formData.push({
                            parameter_name: parameter,
                            appearance: appearance || null,  // Pastikan appearance tidak kosong
                            solution: solution || null,  // Pastikan solution tidak kosong
                            standard: standard || null,  // Pastikan standard tidak kosong
                            ke1: ke1,
                            ke2: ke2,
                            avg: avg,
                            custom_input: customInput || null,
                        });
                        return;  // Jangan lanjutkan validasi lainnya
                    }

                    // Validasi ke1, ke2, avg untuk parameter selain "Appearance" dan "Solution PH(%)"
                    if ((parameter !== "Appearance" && parameter !== "Solution PH(%)") && 
                        (ke1 === null || ke2 === null || avg === null)) {
                        return;  // Skip baris ini jika ke1, ke2, atau avg kosong
                    }

                    // Push data parameter ke array formData jika valid
                    formData.push({
                        parameter_name: parameter,
                        appearance: appearance || null,
                        solution: solution || null,
                        standard: standard || null,
                        ke1: ke1,
                        ke2: ke2,
                        avg: avg,
                        custom_input: customInput || null,
                    });
                });


                // Pastikan data valid ada sebelum dikirim ke server
                if (formData.length === 0) {
                    swal("Gagal!", "Tidak ada data valid yang dapat disimpan.", "warning");
                    return;
                }

                // Menampilkan SweetAlert konfirmasi sebelum menyimpan
                swal({
                    title: "Apakah Anda yakin?",
                    text: "Setelah disubmit, data tidak dapat diubah!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true
                }).then((willSubmit) => {
                    if (willSubmit) {
                        // Kirim data menggunakan AJAX jika valid
                        $.ajax({
                            url: '{{ route('save.parameter.data2') }}',  // Ganti dengan nama route yang baru
                            method: 'POST',
                            data: {
                                spkId: spkId,
                                testDate: testDate,
                                qcStatus: qcStatus,
                                formData: formData,
                                keterangan: keterangan,
                                _token: $('meta[name="csrf-token"]').attr('content')  // CSRF Token untuk keamanan
                            },
                            success: function(response) {
                                swal({
                                    title: "Sukses!",
                                    text: "Data Saved Successfully!",
                                    icon: "success",
                                    button: "OK"
                                }).then(() => {
                                    $('#modalTest2').modal('hide');
                                    
                                    // Refresh data di tabel multi-filter
                                    $('#multi-filter-select').DataTable().ajax.reload();  // Pastikan ini sesuai dengan tabel yang digunakan
                                });
                            },
                            error: function(xhr, status, error) {
                                swal({
                                    title: "Error!",
                                    text: "There was an error saving the test results. Please try again.",
                                    icon: "error",
                                    button: "OK"
                                });
                            }
                        });
                    } else {
                        // Jika pengguna membatalkan, menampilkan pesan pembatalan
                        swal("Dibatalkan!", "Data tidak disimpan.", "info");
                    }
                });
            });


        });
    </script>

    <!-- form 1 -->
    <script>
        $(document).ready(function() {
            $('#saveButton1').on('click', function(e) {
                e.preventDefault(); // Menghindari form submit default
                const keterangan = $('#modalTest1 textarea[name="catatan_tambahan"]').val();
                var testDate = $('#testDate1').val();  // Ambil tanggal dan waktu test
                var qcStatus = $('#qcStatus1').val();  // Ambil status QC
                var spkId = $('#spkId1').val();  // Ambil ID SPK yang dipilih dari input tersembunyi di Form 1
                var formData = [];

                // Mengambil data parameter dari form
                $('#dynamicRowsForm1 tr').each(function(index) {
                    var parameter = $(this).find('td:first').text();  // Ambil parameter
                    var standard = $(this).find(`#standardSpecialty-${index}`).text();  // Ambil nilai standard
                    var ke1 = $(this).find(`#ke1-${index}`).val();  // Ambil nilai ke1
                    var ke2 = $(this).find(`#ke2-${index}`).val();  // Ambil nilai ke2
                    var avg = $(this).find(`#avg-${index}`).val();  // Ambil nilai avg
                    // var customInput = $(this).find(`#text-input-${index}`).val();  // Ambil custom input
                    var customInput = $(`#text-input-${index}`).length ? $(`#text-input-${index}`).val() : null;

                    // Pastikan ke1, ke2, avg diubah menjadi null jika kosong atau undefined
                    ke1 = (ke1 === '' || ke1 === undefined) ? null : ke1;
                    ke2 = (ke2 === '' || ke2 === undefined) ? null : ke2;
                    avg = (avg === '' || avg === undefined) ? null : avg;
                    
                    // Pastikan jika parameter adalah "Appearance" atau "Solution PH(%)", data tetap disertakan
                    if (parameter === "Appearance" || parameter === "Solution PH(%)") {
                        // formData.push({
                        //     parameter_name: parameter,
                        //     standard: standard || null,  // Pastikan standard tidak kosong
                        //     ke1: null, // Tetap kirim nilai null untuk ke1
                        //     ke2: null, // Tetap kirim nilai null untuk ke2
                        //     avg: null, // Tetap kirim nilai null untuk avg
                        //     custom_input: customInput || null,
                        // });
                        formData.push({
                            parameter_name: parameter,
                            standard: standard || null,
                            ke1: parameter === "Appearance" ? null : ke1,
                            ke2: parameter === "Appearance" ? null : ke2,
                            avg: parameter === "Appearance" ? null : avg,
                            custom_input: customInput || null,
                        });
                        return;  // Jangan lanjutkan validasi lainnya untuk parameter ini
                    }
                    // Push data parameter ke array formData dengan format yang diinginkan
                    formData.push({
                        parameter_name: parameter,
                        standard: standard || null,  // Pastikan standard tidak kosong
                        ke1: ke1,
                        ke2: ke2,
                        avg: avg,
                        custom_input: customInput || null,
                    });
                });

                // ⛔️ Validasi: Appearance wajib diisi
                let isValid = true;
                $('#dynamicRowsForm1 tr').each(function(index) {
                    const parameter = $(this).find('td:first').text();
                    if (parameter === 'Appearance') {
                        const input = $(`#text-input-${index}`).val();
                        if (!input || input.trim() === '') {
                            isValid = false;
                            swal("Gagal!", "Input untuk parameter 'Appearance' wajib diisi!", "warning");
                            return false; // Stop loop
                        }
                    }
                });
                if (!isValid) return;

                // Pastikan data valid ada sebelum dikirim ke server
                if (formData.length === 0) {
                    swal("Gagal!", "Tidak ada data valid yang dapat disimpan.", "warning");
                    return;
                }

                // Menampilkan SweetAlert konfirmasi sebelum menyimpan
                swal({
                    title: "Apakah Anda yakin?",
                    text: "Setelah disubmit, data tidak dapat diubah!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true
                }).then((willSubmit) => {
                    if (willSubmit) {
                        // Kirim data menggunakan AJAX jika valid
                        $.ajax({
                            url: '{{ route('save.parameter.data1') }}',  // Ganti dengan nama route yang baru
                            method: 'POST',
                            data: {
                                spkId: spkId,
                                testDate: testDate,
                                qcStatus: qcStatus,
                                formData: formData,
                                keterangan: keterangan,
                                _token: $('meta[name="csrf-token"]').attr('content')  // CSRF Token untuk keamanan
                            },
                            success: function(response) {
                                swal({
                                    title: "Sukses!",
                                    text: "Data Saved Successfully!",
                                    icon: "success",
                                    button: "OK"
                                }).then(() => {
                                    $('#modalTest1').modal('hide'); // Menutup modal
                                    // Refresh data di tabel multi-filter
                                    $('#multi-filter-select').DataTable().ajax.reload();
                                });
                            },
                            error: function(xhr, status, error) {
                                swal({
                                    title: "Error!",
                                    text: "There was an error saving the test results. Please try again.",
                                    icon: "error",
                                    button: "OK"
                                });
                            }
                        });
                    } else {
                        // Jika pengguna membatalkan, menampilkan pesan pembatalan
                        swal("Dibatalkan!", "Data tidak disimpan.", "info");
                    }
                });
            });
        });
    </script>





</body>
</html>