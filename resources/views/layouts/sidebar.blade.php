<div class="sidebar sidebar-style-2">			
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <div class="user">
                <div class="avatar-sm float-left mr-2">
                    <img src="{{ asset('atlantis/assets/img/user.png') }}" alt="..." class="avatar-img rounded-circle">
                </div>
                <div class="info">
                    <a data-toggle="collapse" href="#collapseExample" aria-expanded="true">
                        <span>
                            {{ Auth::user()->name }} 
                            <span class="user-level">{{ Auth::user()->department }}</span> 
                            <span class="caret"></span>
                        </span>

                    </a>
                    <div class="clearfix"></div>

                    <div class="collapse in" id="collapseExample">
                        <ul class="nav">
                            <li>
                                <a href="#" data-toggle="modal" data-target="#changePasswordModal">
                                    <span class="link-collapse">Change Password</span>
                                </a>
                            </li>
                        </ul>
                    </div>                </div>
            </div>
            <ul class="nav nav-primary">
                <!-- Dashboard -->
                @if (Auth::user()->role === 'staff_edc' || Auth::user()->role === 'manager_qc' || Auth::user()->role === 'spv_qc' || Auth::user()->role === 'staff_qc' || Auth::user()->role === 'director' || Auth::user()->role === 'manager_edc')
                    <li class="nav-item {{ request()->routeIs('dashboard.index') ? 'active' : '' }}">
                        <a href="{{ route('dashboard.index') }}" class="collapsed" aria-expanded="false">
                            <i class="fas fa-home"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                @endif

                <!-- Status Sample -->
                @if (Auth::user()->role === 'staff_edc' || Auth::user()->role === 'manager_qc' || Auth::user()->role === 'spv_qc' || Auth::user()->role === 'staff_qc')
                    <li class="nav-item {{ request()->routeIs('status_sample') ? 'active' : '' }}">
                        <a href="{{ route('status_sample') }}">
                            <i class="fas fa-clipboard-list"></i>
                            <p>Status Sample</p>
                        </a>
                    </li>

                    <!-- SPK Assign -->
                    <li class="nav-item {{ request()->routeIs('spk_assign') ? 'active' : '' }}">
                        <a href="{{ route('spk_assign') }}">
                            <i class="fas fa-tasks"></i>
                            <p>SPK Assign</p>
                        </a>
                    </li>
                @endif

                
                @if (Auth::user()->role === 'staff_edc' || Auth::user()->role === 'manager_pdqa' || Auth::user()->role === 'spv_pdqa' || Auth::user()->role === 'staff_pdqa')
                    <!-- Master Data PAC -->
                    <li class="nav-section">
                        <span class="sidebar-mini-icon">
                            <i class="fa fa-ellipsis-h"></i>
                        </span>
                        <h4 class="text-section">Master Data</h4>
                    </li>
                    <li class="nav-item {{ request()->routeIs('master_data_pac') ? 'active' : '' }}">
                        <a href="{{ route('master_data_pac') }}">
                            <i class="fas fa-database"></i>
                            <p>Master Data PAC</p>
                        </a>
                    </li>

                    <!-- Master Data Specialty -->
                    <li class="nav-item {{ request()->routeIs('master_data_specialty') ? 'active' : '' }}">
                        <a href="{{ route('master_data_specialty') }}">
                            <i class="fas fa-layer-group"></i>
                            <p>Master Data Specialty</p>
                        </a>
                    </li>
                @endif

                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">Users</h4>
                </li>

                <!-- Create SPK -->
                
                <li class="nav-item {{ request()->routeIs('create_spk') ? 'active' : '' }}">
                    <a href="{{ route('create_spk') }}">
                        <i class="fas fa-plus"></i>
                        <p>Create SPK</p>
                    </a>
                </li>
           

                <!-- List of SPK -->
                <li class="nav-item {{ request()->routeIs('list_spk') ? 'active' : '' }}">
                    <a href="{{ route('list_spk') }}">
                        <i class="fas fa-list"></i>
                        <p>List of SPK</p>
                    </a>
                </li>
            </ul>


        </div>
    </div>
</div>

<!-- Modal Change Password -->
<div class="modal fade" id="changePasswordModal" tabindex="-1" role="dialog" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form id="changePasswordForm" method="POST" action="{{ route('password.update') }}">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="changePasswordModalLabel">Change Password</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label for="currentPassword">Current Password</label>
                        <input type="password" name="current_password" id="currentPassword" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="newPassword">New Password</label>
                        <input type="password" name="password" id="newPassword" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="confirmNewPassword">Confirm New Password</label>
                        <input type="password" name="password_confirmation" id="confirmNewPassword" class="form-control" required>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="confirmChangePassword">Update Password</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.getElementById('confirmChangePassword').addEventListener('click', function (e) {
        e.preventDefault();

        const currentPassword = document.getElementById('currentPassword').value.trim();
        const newPassword = document.getElementById('newPassword').value.trim();
        const confirmNewPassword = document.getElementById('confirmNewPassword').value.trim();

        if (!currentPassword || !newPassword || !confirmNewPassword) {
            Swal.fire({
                icon: 'warning',
                title: 'Incomplete Form',
                text: 'Please fill out all fields before submitting.',
                confirmButtonText: 'OK'
            });
            return;
        }

        if (newPassword !== confirmNewPassword) {
            Swal.fire({
                icon: 'error',
                title: 'Password Mismatch',
                text: 'New password and confirmation do not match.',
                confirmButtonText: 'OK'
            });
            return;
        }

        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to change your password?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, change it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('changePasswordForm').submit();
            }
        });
    });
</script>

<!-- SweetAlert2 for Success or Error Feedback -->
@if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: '{{ session('success') }}',
            timer: 3000,
            showConfirmButton: false
        });
    </script>
@endif

@if(session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: '{{ session('error') }}',
            timer: 3000,
            showConfirmButton: false
        });
    </script>
@endif
