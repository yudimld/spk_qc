<!DOCTYPE html>
<html lang="en">
    @extends('layouts.head')
    @section('title', 'List of SPK')

    <style>
        .custom-green-badge {
            background-color: #28a745; /* Warna hijau yang lebih gelap atau sesuaikan */
            color: white;
        }

        .badge-reassigned {
            background-color: #f8d800; /* Kuning terang */
            color: black;
        }
        /* Container utama untuk Show entries dan Filter Status */
        .dataTables_length {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
        }

        /* Memastikan filter status berada di sebelah kanan */
        #statusFilterContainer {
            margin-left: 20px;  /* Memberikan jarak antara Show entries dan filter */
        }

    </style>

    <style>
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
        #qcStatus1.pass, #qcStatus2.pass, #qcStatus3.pass {
            background-color: green !important;
            color: white !important;
        }

        /* Styles for 'reject' status */
        #qcStatus1.reject, #qcStatus2.reject, #qcStatus3.reject {
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
                                <h2 class="text-white pb-2 fw-bold">List SPK</h2>
                                <h5 class="text-white op-7 mb-2">Check your SPK status</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="page-inner mt--5">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">List Status of SPK QC</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-filter" style="margin-bottom: 10px; display: flex; justify-content: space-between; align-items: center;">
                                    <label for="statusFilter" style="margin-right: 10px;"></label>
                                    <div id="statusFilterContainer"></div>  <!-- Tempat dropdown filter -->
                                </div>

                                <div class="table-responsive">
                                    <table id="multi-filter-select" class="display table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>Status</th>
                                                <th>Actions</th>
                                                <th>Material Name</th>
                                                <th>Batch Number</th>
                                                <th>Test Result</th>
                                                <th>Details</th>
                                                <th>Doc.</th>
                                                <th>No Ticket</th>
                                                <th>Department</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>Status</th>
                                                <th>Actions</th>
                                                <th>Material Name</th>
                                                <th>Bacth Number</th>
                                                <th>Test Result</th>
                                                <th>Doc.</th>
                                                <th>Details</th>
                                                <th>No Ticket</th>
                                                <th>Department</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            @foreach($spks as $spk)
                                                <tr>
                                                    <td data-status="{{ $spk->status }}">
                                                        @if($spk->status == 'open')
                                                            <span class="badge badge-danger">Open</span>
                                                        @elseif($spk->status == 'ready')
                                                            <span class="badge badge-success">Ready</span>
                                                        @elseif($spk->status == 'assigned')
                                                            <span class="badge badge-warning">Assigned</span>
                                                        @elseif($spk->status == 'request to close')
                                                            <span class="badge badge-info">Request to Close</span>
                                                        @elseif($spk->status == 'closed')
                                                            <span class="badge custom-green-badge">Closed</span>
                                                        @elseif($spk->status == 're-assigned')
                                                            <span class="badge badge-reassigned">Re-assigned</span>
                                                        @else
                                                            <span class="badge badge-primary">Unknown</span>
                                                        @endif
                                                    </td>
                                                    <td style="display: flex; justify-content:">
                                                        @if($spk->status == 'request to close')
                                                        <!-- tombol close SPK -->
                                                        <a href="javascript:void(0);" class="btn btn-link btn-success" data-id="{{ $spk->id }}" id="btnCloseSpk" style="margin-top: 10px;"><i class="fa fa-check"></i></a>
                                                        @endif
                                                        
                                                        @if($spk->status == 'request to close' && $spk->qc_status == 'Reject')
                                                        <!-- Tombol Re-assign -->
                                                        <a href="javascript:void(0);" class="btn btn-link btn-warning" data-id="{{ $spk->id }}" id="btnReassignSpk" style="margin-top: 10px;">
                                                            <i class="fa fa-sync-alt"></i>
                                                        </a>
                                                        @endif
                                                        
                                                        @if($spk->status != 'request to close' && $spk->status != 'closed' && $spk->created_by == Auth::user()->nup)
                                                        <!-- Tombol Delete -->
                                                        <button type="button" class="btn btn-link btn-danger deleteButton" data-id="{{ $spk->id }}" style="margin: 0;">
                                                            <i class="fa fa-trash"></i> 
                                                        </button>
                                                        @endif
                                                        
                                                    </td>
                                                    <td>{{ $spk->nama_material }}</td>
                                                    <td>{{ $spk->batch_number }}</td>
                                                    <td style="color: {{ $spk->qc_status == 'Reject' ? 'red' : ($spk->qc_status == 'Pass' ? 'green' : 'black') }}; font-weight: bold;">
                                                        {{ $spk->qc_status }}
                                                    </td>
                                                    <td>
                                                        <!-- Tombol PDF (Test Results) hanya muncul jika statusnya "request to close" -->
                                                        @if($spk->status == 'request to close' || $spk->status == 'closed')
                                                        <a href="{{ route('spk.generatePdf', $spk->id) }}" class="btn btn-link btn-danger" id="btnGeneratePdf" target="_blank">
                                                            <i class="fa fa-file-pdf"></i>
                                                        </a>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <!-- Tombol Detail -->
                                                        <a href="javascript:void(0);" class="btn btn-link btn-info" data-id="{{ $spk->id }}" id="btnDetail"><i class="fa fa-eye"></i></a>
                                                        
                                                        <!-- Tombol Edit -->
                                                        <!-- <a href="javascript:void(0);" class="btn btn-link btn-warning" data-id="{{ $spk->id }}" id="btnEdit"><i class="fa fa-edit"></i></a> -->
                                                    </td>
                                                    <td>{{ $spk->no_ticket }}</td>
                                                    <td>{{ $spk->department ?? 'No department' }}</td> <!-- Menghindari error jika user null -->
                                                </tr>
                                            @endforeach
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
                                    </div>
                                    <div class="modal-body">
                                        <div id="modalContent">
                                            <!-- Data lainnya akan di-render di sini -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Edit --> 
                        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content" style="border-radius: 10px; background-color: #f9f9f9;">
                                    <div class="modal-header" style="background-color: #007bff; color: white; border-top-left-radius: 10px; border-top-right-radius: 10px;">
                                        <h5 class="modal-title" id="editModalLabel">Edit Data SPK</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="color: white;"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="editForm">
                                            <div id="modalEditContent">
                                                <!-- Form input akan di-render di sini -->
                                            </div>
                                            <button type="submit" class="btn btn-primary">Save Changes</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Reassign SPK -->
                        <div class="modal fade" id="reassignSpkModal" tabindex="-1" role="dialog" aria-labelledby="reassignSpkModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <!-- Modal Header -->
                                    <div class="modal-header" style="background-color: #266CA9; color: #fff;">
                                        <h5 class="modal-title" id="reassignSpkModalLabel">Reassign SPK</h5>
                                    </div>

                                    <div class="modal-body">
                                        <!-- Reassign By Field -->
                                        <div class="form-group">
                                            <label for="reassign-by">Reassign By</label>
                                            <input type="text" class="form-control" id="reassign-by" readonly value="{{ auth()->user()->nup }}">
                                        </div>

                                        <!-- Reason Field -->
                                        <div class="form-group">
                                            <label for="reason">Reason</label>
                                            <textarea class="form-control" id="reason" rows="4" required placeholder="Please enter the reason for reassigning."></textarea>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary btn-round" data-dismiss="modal">Cancel</button>
                                        <button type="button" class="btn btn-warning btn-round" id="submit-reassign">Reassign</button>
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
        $(document).ready(function() {
            var table = $('#multi-filter-select').DataTable({
                "pageLength": 5,
                "scrollX": true,
                "responsive": true,
                "columnDefs": [
                    {
                        "targets": 0,  // Kolom Status
                        "render": function(data, type, row) {
                            // Menampilkan status dengan badge berwarna sesuai status
                            switch (data) {
                                case 'open':
                                    return '<span class="badge badge-danger">Open</span>';
                                case 'assigned':
                                    return '<span class="badge badge-warning">Assigned</span>';
                                case 'request to close':
                                    return '<span class="badge badge-dark">Request to Close</span>';
                                case 'closed':
                                    return '<span class="badge badge-secondary">Closed</span>';
                                case 'ready':
                                    return '<span class="badge badge-success">Ready</span>';
                                default:
                                    return data;
                            }
                        }
                    }
                ]
            });

            // Membuat filter untuk kolom Status
            table.columns(0).every(function() {
                var column = this;

                // Membuat dropdown filter hanya untuk kolom Status
                var select = $('<select class="form-control" style="width: 200px; margin-bottom: 10px;"><option value="">Filter Status</option></select>')
                    .appendTo('#statusFilterContainer')  // Memasukkan dropdown ke dalam div dengan id 'statusFilterContainer'
                    .on('change', function() {
                        var val = $.fn.dataTable.util.escapeRegex($(this).val());

                        // Pencarian berdasarkan nilai yang dipilih
                        column.search(val ? '^' + val + '$' : '', true, false).draw();
                    });

                // Pilihan status yang valid untuk dropdown filter
                var statusOptions = ['open', 'assigned', 'request to close', 'closed', 'ready'];

                // Menambahkan pilihan ke dropdown filter
                statusOptions.forEach(function(status) {
                    select.append('<option value="' + status + '">' + status.charAt(0).toUpperCase() + status.slice(1) + '</option>');
                });
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
                url: '/status/detail/' + spkId, // Endpoint API untuk mendapatkan detail data SPK berdasarkan ID
                method: 'GET',
                success: function(response) {
                    var content = '<div style="display: flex; flex-wrap: wrap; gap: 20px;">';  // Flexbox untuk dua kolom

                    // Iterasi dan masukkan data ke dalam kolom kiri dan kanan
                    for (var key in response) {
                        // Mengecualikan data 'updated_at', 'created_at', '_id', dan 'id' dari modal
                        if (response.hasOwnProperty(key) && key !== 'updated_at' && key !== 'created_at' && key !== '_id' && key !== 'id' && key !== 'parameters_data') {
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
                                    <strong>Custom Input:</strong> ${param.custom_input || 'N/A'} <br>
                                </div>
                            `;
                        });
                        parametersContent += '</div></div>';
                    } else {
                        parametersContent += '<p>No parameters data available.</p>';
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

    <!-- JavaScript untuk Tombol Delete -->
    <script>
        // JavaScript untuk Tombol Delete
        document.querySelectorAll(".deleteButton").forEach(function(button) {
            button.addEventListener("click", function(e) {
                e.preventDefault(); // Mencegah aksi default

                // Ambil ID dari data-id
                let spkId = this.getAttribute("data-id");

                // Konfirmasi dengan SweetAlert
                swal({
                    title: "Apakah Anda yakin?",
                    text: "Data yang dihapus tidak dapat dikembalikan!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true
                }).then((willDelete) => {
                    if (willDelete) {
                        // Mengirimkan request DELETE menggunakan fetch
                        fetch(`/spk/${spkId}`, {
                            method: 'DELETE',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.message) {
                                // Menampilkan SweetAlert sukses
                                swal("Deleted!", data.message, "success").then(() => {
                                    // Jika berhasil, reload halaman atau lakukan tindakan lain
                                    window.location.reload();
                                });
                            } else {
                                // Menampilkan SweetAlert error
                                swal("Error!", "Terjadi kesalahan saat menghapus data.", "error");
                            }
                        })
                        .catch(error => {
                            console.error("Error:", error);
                            swal("Error!", "Terjadi kesalahan saat mengirim data.", "error");
                        });
                    } else {
                        // Jika batal, tampilkan pesan info
                        swal("Dibatalkan!", "Data Anda aman :)", "info");
                    }
                });
            });
        });

    </script>

    <!-- BTN CLOSE SPK -->
    <script>
        // Set CSRF Token untuk semua permintaan AJAX
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        // Event listener untuk tombol Close SPK
        $(document).on('click', '#btnCloseSpk', function() {
            var spkId = $(this).data('id'); // Ambil ID SPK dari tombol yang diklik

            // Tampilkan SweetAlert konfirmasi
            swal({
                title: "Apakah Anda yakin?",
                text: "Setelah di-close, status SPK ini tidak dapat diubah!",
                icon: "warning",
                buttons: true,
                dangerMode: true
            }).then((willClose) => {
                if (willClose) {
                    // Kirim request untuk mengupdate status SPK menjadi "close"
                    $.ajax({
                        url: '/spk/close/' + spkId,
                        method: 'POST',  // Menggunakan POST karena Laravel memerlukan _method=PUT untuk menangani PUT via POST
                        data: {
                            _method: 'PUT',  // Memberitahu Laravel untuk menangani ini sebagai PUT
                            _token: $('meta[name="csrf-token"]').attr('content')  // CSRF token
                        },
                        success: function(response) {
                            if (response.status === 'success') {
                                swal("Sukses!", "SPK berhasil ditutup.", "success");
                                window.location.reload();
                            } else {
                                swal("Error!", "Gagal menutup SPK. Coba lagi nanti.", "error");
                            }
                        },
                        error: function(xhr, status, error) {
                            swal("Error!", "Terjadi kesalahan. Silakan coba lagi.", "error");
                        }
                    });

                } else {
                    swal("Dibatalkan", "SPK tetap terbuka.", "info");
                }
            });
        });
    </script>

    <!-- BTN RE-ASSIGN -->
    <!-- <script>
        $(document).ready(function() {
            // Ketika tombol Re-assign ditekan
            $('#btnReassignSpk').on('click', function() {
                var spkId = $(this).data('id'); // Ambil ID SPK dari data-id
                $('#reassignSpkModal').modal('show'); // Tampilkan modal Reassign SPK
                $('#submit-reassign').data('spk-id', spkId); // Menyimpan ID SPK di tombol submit
            });

            // Ketika tombol Reassign diklik di dalam modal
            $('#submit-reassign').on('click', function() {
                var spkId = $(this).data('spk-id'); // Ambil ID SPK yang disimpan
                var reason = $('#reason').val(); // Ambil nilai alasan
                var reassignBy = $('#reassign-by').val(); // Ambil NUP yang sedang login

                // Validasi jika alasan kosong
                if (!reason) {
                    swal("Error", "Please enter a reason.", "error");
                    return;
                }

                // Konfirmasi sebelum submit
                swal({
                    title: "Are you sure?",
                    text: "The re-assign data will be saved!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true
                }).then((willSubmit) => {
                    if (willSubmit) {
                        // Kirim data ke server untuk disimpan
                        $.ajax({
                            url: '{{ route('spk.reassign') }}', // Route untuk menyimpan data re-assign
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                spk_id: spkId,
                                reason: reason,
                                reassign_by: reassignBy
                            },
                            success: function(response) {
                                if (response.message) {
                                    swal("Success!", response.message, "success").then(() => {
                                        $('#reassignSpkModal').modal('hide'); // Tutup modal setelah berhasil
                                        location.reload(); // Reload halaman untuk melihat perubahan
                                    });
                                } else {
                                    swal("Error!", "There was an error while saving the re-assign.", "error");
                                }
                            },
                            error: function(xhr, status, error) {
                                swal("Error!", "An error occurred while sending the data.", "error");
                            }
                        });
                    } else {
                        swal("Canceled", "Re-assign canceled", "info");
                    }
                });
            });

        });
    </script> -->
    <!-- BTN RE-ASSIGN -->
<script>
    $(document).ready(function() {
        // Event delegation untuk menangani tombol Re-assign (jika ada lebih dari satu)
        $(document).on('click', '#btnReassignSpk', function() {
            var spkId = $(this).data('id'); // Ambil ID SPK dari data-id
            $('#reassignSpkModal').modal('show'); // Tampilkan modal Reassign SPK
            $('#submit-reassign').data('spk-id', spkId); // Menyimpan ID SPK di tombol submit
        });

        // Ketika tombol Reassign diklik di dalam modal
        $('#submit-reassign').on('click', function() {
            var spkId = $(this).data('spk-id'); // Ambil ID SPK yang disimpan
            var reason = $('#reason').val(); // Ambil nilai alasan
            var reassignBy = $('#reassign-by').val(); // Ambil NUP yang sedang login

            // Validasi jika alasan kosong
            if (!reason) {
                swal("Error", "Please enter a reason.", "error");
                return;
            }

            // Konfirmasi sebelum submit
            swal({
                title: "Are you sure?",
                text: "The re-assign data will be saved!",
                icon: "warning",
                buttons: true,
                dangerMode: true
            }).then((willSubmit) => {
                if (willSubmit) {
                    // Kirim data ke server untuk disimpan
                    $.ajax({
                        url: '{{ route('spk.reassign') }}', // Route untuk menyimpan data re-assign
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            spk_id: spkId,
                            reason: reason,
                            reassign_by: reassignBy
                        },
                        success: function(response) {
                            if (response.message) {
                                swal("Success!", response.message, "success").then(() => {
                                    $('#reassignSpkModal').modal('hide'); // Tutup modal setelah berhasil
                                    location.reload(); // Reload halaman untuk melihat perubahan
                                });
                            } else {
                                swal("Error!", "There was an error while saving the re-assign.", "error");
                            }
                        },
                        error: function(xhr, status, error) {
                            swal("Error!", "An error occurred while sending the data.", "error");
                        }
                    });
                } else {
                    swal("Canceled", "Re-assign canceled", "info");
                }
            });
        });

    });
</script>


    @if(session('success'))
        <script>
            Swal.fire(
                'Deleted!',
                '{{ session('success') }}',
                'success'
            );
        </script>
    @endif

    @if(session('error'))
        <script>
            Swal.fire(
                'Error!',
                '{{ session('error') }}',
                'error'
            );
        </script>
    @endif

    </body>
</html>
