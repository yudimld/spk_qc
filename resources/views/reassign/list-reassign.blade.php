<!DOCTYPE html>
<html lang="en">
    @php
        $title = 'Create SPK';
    @endphp
    @include('layouts.head')

    <style>
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
                                <h2 class="text-white pb-2 fw-bold">Re-assign Request List</h2>
                                <h5 class="text-white op-7 mb-2">Approve Re-assign SPK to QC With a Reason</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="page-inner mt--5">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">SPK Re-assign List</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="multi-filter-select" class="display table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>Status</th>
                                                <th>Department</th>
                                                <th>Material Type</th>
                                                <th>Product Type</th>
                                                <th>No Ticket</th>
                                                <th>Test Results</th>
                                                <th>Details</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>Status</th>
                                                <th>Department</th>
                                                <th>Material Type</th>
                                                <th>Product Type</th>
                                                <th>No Ticket</th>
                                                <th>Test Results</th>
                                                <th>Details</th>
                                                <th>Actions</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                          
                                        </tbody>
                                    </table>
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

    </body>
</html>
