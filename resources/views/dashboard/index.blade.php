<!DOCTYPE html>
<html lang="en">
    @extends('layouts.head')
	@section('title', 'Dashboard Ticketing')
	<style>
		.card-yellow-custom {
			background-color: #f1c40f !important; /* Kuning terang */
			border-color: #f39c12; /* Border kuning */
			color: white; /* Warna teks putih agar kontras dengan latar belakang kuning */
		}

		.card-yellow-custom .card-category, .card-yellow-custom .card-title {
			color: #ffff; /* Warna teks di dalam card menjadi putih */
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
								<h2 class="text-white pb-2 fw-bold">Dashboard</h2>
								<h5 class="text-white op-7 mb-2">Free Bootstrap 4 Admin Dashboard</h5>
							</div>
						</div>
					</div>

				</div>
				<div class="page-inner mt--5">
					<div class="col-md-12">
						<div class="card">
							<div class="card-body">
								<div class="row">
									<!-- Card untuk Open -->
									<div class="col-sm-6 col-md-4">
										<div class="card card-stats card-danger card-round">
											<div class="card-body">
												<div class="row">
													<div class="col-5">
														<div class="icon-big text-center">
															<i class="fas fa-folder-open"></i>
														</div>
													</div>
													<div class="col-7 col-stats">
														<div class="numbers">
															<p class="card-category">Open</p>
															<h4 class="card-title">{{ $openCount }}</h4>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>

									<!-- Card untuk Ready -->
									<div class="col-sm-6 col-md-4">
										<div class="card card-stats card-primary card-round">
											<div class="card-body">
												<div class="row">
													<div class="col-5">
														<div class="icon-big text-center">
															<i class="fas fa-clock"></i>
														</div>
													</div>
													<div class="col-7 col-stats">
														<div class="numbers">
															<p class="card-category">Ready</p>
															<h4 class="card-title">{{ $readyCount }}</h4>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>

									<!-- Card untuk Assigned -->
									<div class="col-sm-6 col-md-4">
										<div class="card card-stats card-warning card-round">
											<div class="card-body">
												<div class="row">
													<div class="col-5">
														<div class="icon-big text-center">
															<i class="fas fa-check-circle"></i>
														</div>
													</div>
													<div class="col-7 col-stats">
														<div class="numbers">
															<p class="card-category">Assigned</p>
															<h4 class="card-title">{{ $assignedCount }}</h4>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>

									<!-- Card untuk Closed -->
									<div class="col-sm-6 col-md-4">
										<div class="card card-stats card-info card-round">
											<div class="card-body">
												<div class="row">
													<div class="col-5">
														<div class="icon-big text-center">
															<i class="fas fa-check-circle"></i>
														</div>
													</div>
													<div class="col-7 col-stats">
														<div class="numbers">
															<p class="card-category">Request to Closed</p>
															<h4 class="card-title">{{ $requestToClosedCount }}</h4>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									
									<!-- Card untuk Closed -->
									<div class="col-sm-6 col-md-4">
										<div class="card card-stats card-success card-round">
											<div class="card-body">
												<div class="row">
													<div class="col-5">
														<div class="icon-big text-center">
															<i class="fas fa-check-circle"></i>
														</div>
													</div>
													<div class="col-7 col-stats">
														<div class="numbers">
															<p class="card-category">Closed</p>
															<h4 class="card-title">{{ $closedCount }}</h4>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>

								

									<!-- Card untuk Re-Assigned -->
									<div class="col-sm-6 col-md-4">
										<div class="card card-stats card-yellow-custom card-round">
											<div class="card-body">
												<div class="row">
													<div class="col-5">
														<div class="icon-big text-center">
															<i class="fas fa-sync-alt"></i>
														</div>
													</div>
													<div class="col-7 col-stats">
														<div class="numbers">
															<p class="card-category">Re-Assigned</p>
															<h4 class="card-title">{{ $reAssignedCount }}</h4>
														</div>
													</div>
												</div>
											</div>
										</div>
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

</body>
</html>
