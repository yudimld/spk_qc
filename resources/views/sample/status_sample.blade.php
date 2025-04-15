<!DOCTYPE html>
<html lang="en">
    @extends('layouts.head')
    @section('title', 'Status Sample')
    <style>
        /* Table wrapper */
        .table-responsive {
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        /* Table base style */
        table.dataTable {
            width: 100% !important;
            border-collapse: collapse;
            font-size: 14px;
        }

        /* Header */
        table.dataTable thead th {
            text-align: center;
            vertical-align: middle;
            font-weight: 600;
            background-color: #f1f1f1;
            border-bottom: 2px solid #dee2e6;
            white-space: nowrap;
        }

        /* Footer */
        table.dataTable tfoot th {
            text-align: center;
            vertical-align: middle;
            background-color: #f9f9f9;
            border-top: 1px solid #dee2e6;
            font-weight: 500;
            white-space: nowrap;
        }

        /* Table body cells */
        table.dataTable tbody td {
            vertical-align: middle;
            padding: 8px 10px;
            white-space: normal;
        }

        /* Center alignment for Status & Actions only */
        td.status, td.actions {
            text-align: center;
            white-space: nowrap;
        }

        /* Zebra striping */
        table.dataTable tbody tr:nth-of-type(odd) {
            background-color: #f8f9fa;
        }

        /* Hover effect */
        table.dataTable tbody tr:hover {
            background-color: #e9ecef;
        }

        /* Buttons */
        .btn-link {
            padding: 4px 6px;
            font-size: 14px;
        }

        /* Badge */
        .badge {
            padding: 4px 8px;
            font-size: 12px;
            font-weight: 500;
        }

        /* Responsive tweaks */
        @media (max-width: 768px) {
            table.dataTable {
                font-size: 12px;
            }

            .btn-link {
                font-size: 12px;
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
                                <h2 class="text-white pb-2 fw-bold">Sample Status</h2>
                                <h5 class="text-white op-7 mb-2">List of Status Sample from SPK Open</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Table SPK Open -->
                <div class="page-inner mt--5">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h2 class="card-title">List of SPK Open</h2>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="multi-filter-select" class="display table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>Status</th>
                                                <th>Material Name</th>
                                                <th>Create Date</th>
                                                <th>No Ticket</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>Status</th>
                                                <th>Material Name</th>
                                                <th>Create Date</th>
                                                <th>No Ticket</th>
                                                <th>Actions</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            @foreach($spks as $spk)
                                                <tr>
                                                <td class="status" data-status="{{ $spk->status }}">
                                                        @if($spk->status == 'open')
                                                            <span class="badge badge-danger">Open</span>
                                                        @elseif($spk->status == 'ready')
                                                            <span class="badge badge-success">Ready</span>
                                                        @elseif($spk->status == 'assigned')
                                                            <span class="badge badge-warning">Assigned</span>
                                                        @elseif($spk->status == 'request to close')
                                                            <span class="badge badge-dark">Request to Close</span>
                                                        @elseif($spk->status == 'closed')
                                                            <span class="badge badge-secondary">Closed</span>
                                                        @else
                                                            <span class="badge badge-primary">Unknown</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $spk->nama_material }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($spk->created_at)->timezone('Asia/Jakarta')->format('Y-m-d H:i') }}</td>
                                                    <td>{{ $spk->no_ticket }}</td>
                                                    <td class="actions">
                                                        <!-- Tombol Detail -->
                                                        <a href="javascript:void(0);" class="btn btn-link btn-info" data-id="{{ $spk->id }}" id="btnDetail"><i class="fa fa-eye"></i></a>

                                                        <!-- Tombol Submit (Menampilkan Modal) -->
                                                        <button type="button" class="btn btn-link btn-warning" data-id="{{ $spk->id }}" id="btnSubmit">
                                                            <i class="fa fa-paper-plane"></i>
                                                        </button>
                                                    </td>
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

                        <!-- Modal Submit -->
                        <div class="modal fade" id="submitModal" tabindex="-1" aria-labelledby="submitModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content" style="border-radius: 10px; background-color: #f9f9f9;">
                                    <div class="modal-header" style="background-color: #007bff; color: white; border-top-left-radius: 10px; border-top-right-radius: 10px;">
                                        <h5 class="modal-title" id="submitModalLabel">Submit Data SPK</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="color: white;"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="submitForm">
                                            <input type="hidden" id="spkId" name="spkId">

                                            <!-- By (User NUP) -->
                                            <div class="form-group">
                                                <label for="by">By</label>
                                                <input type="text" class="form-control" id="by" name="by" value="{{ auth()->user()->nup }}" readonly>
                                            </div>

                                            <!-- Lokasi Penyimpanan -->
                                            <div class="form-group">
                                                <label for="lokasi">Lokasi Penyimpanan Sample</label>
                                                <input type="text" class="form-control" id="lokasi" name="lokasi" placeholder="Enter lokasi penyimpanan" required>
                                            </div>

                                            <!-- Keterangan -->
                                            <div class="form-group">
                                                <label for="keterangan">Keterangan</label>
                                                <textarea class="form-control" id="keterangan" name="keterangan" rows="3" placeholder="Enter keterangan" required></textarea>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- Modal Footer with Buttons aligned to the bottom right -->
                                    <div class="modal-footer" style="display: flex; justify-content: flex-end; gap: 10px;">
                                        <button type="submit" class="btn btn-round btn-primary" id="saveButton">Save</button>
                                        <button type="button" class="btn btn-round btn-warning" id="assignButton">Assign</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Table SPK Ready -->
                <div class="page-inner mt--5">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h2 class="card-title">List of SPK Ready</h2>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="table-ready" class="display table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>Status</th>
                                                <th>Material Name</th>
                                                <th>Submit By</th>
                                                <th>Sample Location</th>
                                                <th>No Ticket</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>Status</th>
                                                <th>Material Name</th>
                                                <th>Submit By</th>
                                                <th>Sample Location</th>
                                                <th>No Ticket</th>
                                                <th>Actions</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            @foreach($spkr as $spkready)
                                                <tr>
                                                    <td class="status">
                                                        <span class="badge badge-success">{{ $spkready->status }}</span>
                                                    </td>
                                                    <td>{{ $spkready->nama_material }}</td>
                                                    <td>{{ $spkready->by }}</td>
                                                    <td>{{ $spkready->lokasi }}</td>
                                                    <td>{{ $spkready->no_ticket }}</td>
                                                    <td class="actions">
                                                        <!-- Tombol Detail -->
                                                        <a href="javascript:void(0);" class="btn btn-link btn-info" data-id="{{ $spkready->id }}" id="btnDetail"><i class="fa fa-eye"></i></a>

                                                        <!-- Tombol Submit (Menampilkan Modal) -->
                                                        <button type="button" class="btn btn-link btn-warning" data-id="{{ $spkready->id }}" id="btnSubmitAssign">
                                                            <i class="fa fa-paper-plane"></i>
                                                        </button>
                                                    </td>
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

                        <!-- Modal Submit -->
                        <div class="modal fade" id="submitModal" tabindex="-1" aria-labelledby="submitModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content" style="border-radius: 10px; background-color: #f9f9f9;">
                                    <div class="modal-header" style="background-color: #007bff; color: white; border-top-left-radius: 10px; border-top-right-radius: 10px;">
                                        <h5 class="modal-title" id="submitModalLabel">Submit Data SPK</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="color: white;"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="submitForm">
                                            <input type="hidden" id="spkId" name="spkId">

                                            <!-- By (User NUP) -->
                                            <div class="form-group">
                                                <label for="by">By</label>
                                                <input type="text" class="form-control" id="by" name="by" value="{{ auth()->user()->nup }}" readonly>
                                            </div>

                                            <!-- Lokasi Penyimpanan -->
                                            <div class="form-group">
                                                <label for="lokasi">Lokasi Penyimpanan Sample</label>
                                                <input type="text" class="form-control" id="lokasi" name="lokasi" placeholder="Enter lokasi penyimpanan" required>
                                            </div>

                                            <!-- Keterangan -->
                                            <div class="form-group">
                                                <label for="keterangan">Keterangan</label>
                                                <textarea class="form-control" id="keterangan" name="keterangan" rows="3" placeholder="Enter keterangan" required></textarea>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- Modal Footer with Buttons aligned to the bottom right -->
                                    <div class="modal-footer" style="display: flex; justify-content: flex-end; gap: 10px;">
                                        <button type="submit" class="btn btn-round btn-primary" id="saveButton">Save</button>
                                        <button type="button" class="btn btn-round btn-warning" id="readyToAssignButton">Assign</button>
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

    <!-- datatable multi filter  Open-->
    <script>
        $('#multi-filter-select').DataTable({
            "pageLength": 5,
            responsive: true,
            autoWidth: false,
            initComplete: function () {
                this.api().columns().every(function () {
                    var column = this;
                    
                    // Membuat dropdown filter untuk setiap kolom
                    var select = $('<select class="form-control"><option value="">Filter</option></select>')
                        .appendTo($(column.footer()).empty())
                        .on('change', function () {
                            var val = $.fn.dataTable.util.escapeRegex($(this).val());

                            // Mencari berdasarkan data-status jika kolom adalah Status
                            if (column.index() === 0) { // hanya untuk kolom pertama (Status)
                                column
                                    .search(val ? '^' + val + '$' : '', true, false)
                                    .draw();
                            } else {
                                column
                                    .search(val ? '^' + val + '$' : '', true, false)
                                    .draw();
                            }
                        });

                    // Menambahkan pilihan unik ke dropdown filter
                    column.data().unique().sort().each(function (d, j) {
                        if (column.index() === 0) {  // Kolom Status
                            // Menambahkan status ke dalam dropdown filter berdasarkan data-status
                            let statusOptions = ['open', 'ready', 'assigned', 'request to close', 'closed', 'unknown'];
                            statusOptions.forEach(function(status) {
                                select.append('<option value="' + status + '">' + status.charAt(0).toUpperCase() + status.slice(1) + '</option>');
                            });
                        } else {
                            select.append('<option value="' + d + '">' + d + '</option>');
                        }
                    });
                });
            }
        });
    </script>

    <!-- datatable multi filter Ready -->
    <script>
        $('#table-ready').DataTable({
            "pageLength": 5,
            responsive: true,
            autoWidth: false,
            initComplete: function () {
                this.api().columns().every(function () {
                    var column = this;
                    
                    // Membuat dropdown filter untuk setiap kolom
                    var select = $('<select class="form-control"><option value="">Filter</option></select>')
                        .appendTo($(column.footer()).empty())
                        .on('change', function () {
                            var val = $.fn.dataTable.util.escapeRegex($(this).val());

                            // Mencari berdasarkan data-status jika kolom adalah Status
                            if (column.index() === 0) { // hanya untuk kolom pertama (Status)
                                column
                                    .search(val ? '^' + val + '$' : '', true, false)
                                    .draw();
                            } else {
                                column
                                    .search(val ? '^' + val + '$' : '', true, false)
                                    .draw();
                            }
                        });

                    // Menambahkan pilihan unik ke dropdown filter
                    column.data().unique().sort().each(function (d, j) {
                        if (column.index() === 0) {  // Kolom Status
                            // Menambahkan status ke dalam dropdown filter berdasarkan data-status
                            let statusOptions = ['open', 'ready', 'assigned', 'request to close', 'closed', 'unknown'];
                            statusOptions.forEach(function(status) {
                                select.append('<option value="' + status + '">' + status.charAt(0).toUpperCase() + status.slice(1) + '</option>');
                            });
                        } else {
                            select.append('<option value="' + d + '">' + d + '</option>');
                        }
                    });
                });
            }
        });
    </script>

    <!-- Detail modal -->
    <!-- <script>
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
                        if (response.hasOwnProperty(key) && key !== 'updated_at' && key !== 'created_at' && key !== '_id' && key !== 'id') {
                            var label = key.charAt(0).toUpperCase() + key.slice(1);  // Label untuk field

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

                    content += '</div>';  // Tutup flexbox

                    // Isi modal dengan data yang sudah di-generate
                    $('#modalContent').html(content);

                    // Tampilkan modal
                    $('#detailModal').modal('show');  
                }
            });
        });
    </script> -->
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

                    // Isi modal dengan data yang sudah di-generate
                    $('#modalContent').html(content);

                    // Tampilkan modal
                    $('#detailModal').modal('show');  
                }
            });
        });
    </script>



    <!-- submit assign / ready modal -->
    <script>
        // Event listener for the "Submit" button (modal pop-up for editing)
        $(document).on('click', '#btnSubmit', function() {
            var spkId = $(this).data('id'); // Get the ID of the clicked item

            // Set the ID in the hidden input field inside the modal
            $('#spkId').val(spkId);

            // Show the modal
            $('#submitModal').modal('show');
        });

        // Action for the "Save" button (update status to ready)
        $('#saveButton').on('click', function(e) {
            e.preventDefault(); // Prevent the default form submission

            var spkId = $('#spkId').val(); // Get the ID from the hidden input
            var formData = $('#submitForm').serialize(); // Serialize the form data

            // Show a SweetAlert confirmation before submitting
            swal({
                title: "Are you sure?",
                text: "You are about to update the status to 'Ready'. Do you want to continue?",
                icon: "warning",
                buttons: true,
                dangerMode: true
            }).then((willSubmit) => {
                if (willSubmit) {
                    // If the user confirms, send the data to the server to update the status to "ready"
                    $.ajax({
                        url: '/status/update/' + spkId, // URL for updating status to ready
                        method: 'PUT',
                        data: formData,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')  // Add CSRF token
                        },
                        success: function(response) {
                            // Show success message with SweetAlert
                            swal('Success!', response.message, 'success');
                            $('#submitModal').modal('hide');
                            location.reload(); // Reload the page to reflect the changes
                        },
                        error: function() {
                            // Show error message with SweetAlert
                            swal('Error!', 'There was an error updating the data.', 'error');
                        }
                    });
                } else {
                    // If the user cancels, show a cancellation message
                    swal('Cancelled', 'The action has been cancelled.', 'info');
                }
            });
        });

        // Action for the "Assign" button (update status to assigned)
        $('#assignButton').on('click', function() {
            var spkId = $('#spkId').val(); // Get the ID from the hidden input
            var formData = $('#submitForm').serialize(); // Serialize the form data

            // Show a SweetAlert confirmation before proceeding with "Assign"
            swal({
                title: "Are you sure?",
                text: "You are about to assign this task. Do you want to continue?",
                icon: "warning",
                buttons: true,
                dangerMode: true
            }).then((willAssign) => {
                if (willAssign) {
                    // If the user confirms, send the data to the server to update the status to "assigned"
                    $.ajax({
                        url: '/status/assign1/' + spkId, // URL for updating status to assigned
                        method: 'PUT',
                        data: formData,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')  // Add CSRF token
                        },
                        success: function(response) {
                            // Show success message with SweetAlert
                            swal('Assigned!', response.message, 'success');
                            $('#submitModal').modal('hide');
                            location.reload(); // Reload the page to reflect the changes
                        },
                        error: function() {
                            // Show error message with SweetAlert
                            swal('Error!', 'There was an error assigning the data.', 'error');
                        }
                    });
                } else {
                    // If the user cancels, show a cancellation message
                    swal('Cancelled', 'The action has been cancelled.', 'info');
                }
            });
        });
    </script>

    <!-- submit assign spk table ready -->
    <script>
        $(document).on('click', '#btnSubmitAssign', function() {
            var spkId = $(this).data('id'); // Mengambil ID dari tombol yang diklik

            // Menampilkan SweetAlert konfirmasi
            swal({
                title: "Are you sure?",
                text: "You are about to assign this task. Do you want to continue?",
                icon: "warning",
                buttons: true,
                dangerMode: true
            }).then((willAssign) => {
                if (willAssign) {
                    // Jika pengguna menekan "Yes, assign it", kirim permintaan untuk mengubah status
                    $.ajax({
                        url: '/status/assign/' + spkId, // Menggunakan route yang sesuai
                        method: 'PUT',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')  // Menambahkan CSRF token
                        },
                        success: function(response) {
                            // Menampilkan pesan sukses dengan SweetAlert
                            swal('Assigned!', response.message, 'success');
                            location.reload(); // Memuat ulang halaman untuk memperbarui status
                        },
                        error: function() {
                            // Menampilkan pesan error dengan SweetAlert
                            swal('Error!', 'There was an error assigning the task.', 'error');
                        }
                    });
                } else {
                    // Jika pengguna membatalkan, menampilkan pesan dibatalkan
                    swal('Cancelled', 'The task was not assigned.', 'info');
                }
            });
        });
    </script>





</body>
</html>