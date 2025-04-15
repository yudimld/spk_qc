<!DOCTYPE html>
<html lang="en">
    @extends('layouts.head')
    @section('title', 'Create SPK')
    <style>
        /* Styling untuk input pencarian */
        #search-material, #search-material-specialty, #search-material-specialty3 {
            width: 100%;
            padding: 12px 40px 12px 12px;  /* Tambahkan padding kiri dan kanan */
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
            box-sizing: border-box;
            background-color: #fff;
            outline: none;  /* Hapus outline default */
            position: relative; /* Tambahkan posisi relatif agar caret bisa diposisikan */
        }

        /* Menambahkan caret pada bagian kanan input */
        #search-material::after, #search-material-specialty::after, #search-material-specialty3::after {
            content: '\25BC'; /* Unicode untuk tanda caret bawah */
            font-size: 14px;
            color: #007bff;  /* Warna caret */
            position: absolute;
            top: 50%;
            right: 12px;  /* Posisi caret di sebelah kanan */
            transform: translateY(-50%);  /* Menjaga caret tetap di tengah secara vertikal */
            pointer-events: none; /* Agar caret tidak mengganggu interaksi dengan input */
        }

        /* Styling untuk dropdown */
        #material-dropdown, #material-dropdown-specialty, #material-dropdown-specialty3 {
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 4px;
            max-height: 200px;
            overflow-y: auto;
            position: absolute;
            width: 100%;
            z-index: 9999;
            box-sizing: border-box;
            margin-top: 4px;  /* Jarak antara input dan dropdown */
            display: none;
        }

        /* Styling untuk item dropdown */
        #material-dropdown div, #material-dropdown-specialty div, #material-dropdown-specialty3 div {
            padding: 10px;
            cursor: pointer;
            font-size: 14px;
            color: #333;
        }

        /* Gaya ketika item dropdown dihover */
        #material-dropdown div:hover, #material-dropdown-specialty div:hover, #material-dropdown-specialty3 div:hover {
            background-color: #f4f4f4;
            color: #007bff;  /* Ganti warna teks saat hover */
        }

        /* Styling untuk item yang dipilih */
        #search-material:focus, #search-material-specialty:focus, #search-material-specialty3:focus {
            border-color: #007bff;  /* Warna border saat fokus pada input */
        }

        /* Item yang dipilih */
        .selected-item {
            font-weight: bold;
            background-color: #f4f4f4;
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
                                <h2 class="text-white pb-2 fw-bold">Create SPK</h2>
                                <h5 class="text-white op-7 mb-2">create a SPK based on your department</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="page-inner mt--5">
                    <div class="row mt--2">
                        <div class="col-md-8">
                            <div class="card full-height">
                                <div class="card-body">
                                    <!-- Form starts here -->
                                    <form id="spk-form">
                                        @csrf

                                        <!-- Radio Buttons: Plant, Technical -->
                                        <div class="form-group" style="background-color: #f0f0f0; padding: 15px; border-radius: 8px; margin-bottom: 15px;">
                                            <label for="department">Department</label><br>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="department" id="plant" value="Plant" checked>
                                                <label class="form-check-label" for="plant">Plant</label>
                                            </div>
                                            <!-- <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="department" id="technical" value="Technical">
                                                <label class="form-check-label" for="technical">Technical</label>
                                            </div> -->
                                        </div>

                                        <!-- Select Dropdown 1: Finish Good, Raw Material -->
                                        <div class="form-group" id="material-select" style="background-color: #f0f0f0; padding: 15px; border-radius: 8px; margin-bottom: 15px;">
                                            <label for="material">Material Type</label>
                                            <select class="form-control" id="material" name="material">
                                                <option value="FG">Finish Good (FG)</option>
                                                <option value="RM">Raw Material (RM)</option>
                                            </select>
                                        </div>

                                        <!-- Select Dropdown 2: PAC, Specialty -->
                                        <div class="form-group" id="product-select" style="background-color: #f0f0f0; padding: 15px; border-radius: 8px; margin-bottom: 15px;">
                                            <label for="product">Product Type</label>
                                            <select class="form-control" id="product" name="product">
                                                <option value="PAC">PAC</option>
                                                <option value="Specialty">Specialty</option>
                                            </select>
                                        </div>

                                        <!-- Button Submit - Positioned to the right -->
                                        <div class="d-flex justify-content-end">
                                            <button type="submit" class="btn btn-primary btn-round" id="submit-button">Create</button>
                                        </div>
                                    </form>
                                    <!-- Form ends here -->

                                    <!-- Modal 1 - Form 1 -->
                                    <div class="modal fade" id="form1Modal" tabindex="-1" role="dialog" aria-labelledby="form1ModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <!-- Modal Header -->
                                                <div class="modal-header" style="background-color: #266CA9; color: #fff; border-bottom-left-radius: 10px; border-bottom-right-radius: 10px; display: flex; align-items: center; justify-content: center;">
                                                    <h5 class="modal-title fw-bold" id="form1ModalLabel" style="flex: 1; text-align: center;">FORM PAC PLANT RM</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>

                                                <div class="modal-body">
                                        
                                                    <!-- Form 1 content with horizontal layout and background colors -->
                                                    <div class="row">
                                                        <!-- Department Field -->
                                                        <div class="col-md-4">
                                                            <div class="form-group" style="background-color: #f4f4f4; padding: 15px; border-radius: 8px;">
                                                                <label for="department-form1">Department</label>
                                                                <input type="text" class="form-control" id="department-form1" readonly >
                                                            </div>
                                                        </div>

                                                        <!-- Material Type Field -->
                                                        <div class="col-md-4">
                                                            <div class="form-group" style="background-color: #f4f4f4; padding: 15px; border-radius: 8px;">
                                                                <label for="material-form1">Material Type</label>
                                                                <input type="text" class="form-control" id="material-form1" readonly>
                                                            </div>
                                                        </div>

                                                        <!-- Product Type Field -->
                                                        <div class="col-md-4">
                                                            <div class="form-group" style="background-color: #f4f4f4; padding: 15px; border-radius: 8px;">
                                                                <label for="product-form1">Product Type</label>
                                                                <input type="text" class="form-control" id="product-form1" readonly>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <hr> <!-- Horizontal line to separate sections -->

                                                    <!-- Nama Material -->
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form-group" style="background-color: #f4f4f4; padding: 15px; border-radius: 8px;">
                                                                <label for="datetime1">Datetime of Submission</label>
                                                                <input type="datetime-local" class="form-control" id="datetime1" value="{{ now()->setTimezone('Asia/Jakarta')->format('Y-m-d\TH:i') }}" readonly>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <div class="form-group" style="background-color: #f4f4f4; padding: 15px; border-radius: 8px;">
                                                                <label for="code_material1">Code Material</label>
                                                                <!-- Mengganti select2 dengan Choices.js -->
                                                                <select class="form-control" id="code_material1" style="width: 100%">
                                                                    <option value="">Choose Code Material</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <hr> <!-- Horizontal line to separate sections -->

                                                    <!-- Feed (PAC Padat) -->
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form-group" style="background-color: #f4f4f4; padding: 15px; border-radius: 8px;">
                                                                <label for="nama-material1">Material Name</label>
                                                                <select class="form-control" id="nama-material1" style="width: 100%">
                                                                    <option value="">Choose Material Name</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <!-- Nama Supplier -->
                                                        <div class="col-md-4">
                                                            <div class="form-group" style="background-color: #f4f4f4; padding: 15px; border-radius: 8px;">
                                                                <label for="nama-supplier1">Supplier Name</label>
                                                                <input type="text" class="form-control" id="nama-supplier1" placeholder="Enter supplier name">
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <div class="form-group" style="background-color: #f4f4f4; padding: 15px; border-radius: 8px;">
                                                                <label for="tanggal-kedatangan1">Arrival Date</label>
                                                                <input type="date" class="form-control" id="tanggal-kedatangan1" value="{{ now()->format('Y-m-d') }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr> 

                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group" style="background-color: #f4f4f4; padding: 15px; border-radius: 8px;">
                                                                <label for="no-mobil1">Car Number</label>
                                                                <input type="text" class="form-control" id="no-mobil1" placeholder="Enter vehicle number">
                                                            </div>
                                                        </div>

                                                        <!-- Daftar Nomor Lot -->
                                                        <div class="col-md-6">
                                                            <div class="form-group" style="background-color: #f4f4f4; padding: 15px; border-radius: 8px;">
                                                                <label for="batch_number1">Batch Number</label>
                                                                <input type="text" class="form-control" id="batch_number1" placeholder="Enter Batch Numbers">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group" style="background-color: #f4f4f4; padding: 15px; border-radius: 8px;">
                                                                <label for="keterangan1">Information</label>
                                                                <textarea class="form-control" id="keterangan1" rows="3" placeholder="Enter description (optional)"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary btn-round" data-dismiss="modal">Cancel</button>
                                                        <button type="button" class="btn btn-primary btn-round" id="submit-form1">Submit</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Modal 2 - Form 2 -->
                                    <div class="modal fade" id="form2Modal" tabindex="-1" role="dialog" aria-labelledby="form2ModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <!-- Modal Header -->
                                                <div class="modal-header" style="background-color: #266CA9; color: #fff; border-bottom-left-radius: 10px; border-bottom-right-radius: 10px; display: flex; align-items: center; justify-content: center;">
                                                    <h5 class="modal-title fw-bold" id="form2ModalLabel" style="flex: 1; text-align: center;">FORM SPECIALTY PLANT (FG)</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>

                                                <div class="modal-body">
                                                    <!-- Form 2 content with horizontal layout and background colors -->
                                                    <div class="row">
                                                        <!-- Department Field -->
                                                        <div class="col-md-4">
                                                            <div class="form-group" style="background-color: #f4f4f4; padding: 15px; border-radius: 8px;">
                                                                <label for="department-form1">Department</label>
                                                                <input type="text" class="form-control" id="department-form2" readonly>
                                                            </div>
                                                        </div>

                                                        <!-- Material Type Field -->
                                                        <div class="col-md-4">
                                                            <div class="form-group" style="background-color: #f4f4f4; padding: 15px; border-radius: 8px;">
                                                                <label for="material-form1">Material Type</label>
                                                                <input type="text" class="form-control" id="material-form2" readonly>
                                                            </div>
                                                        </div>

                                                        <!-- Product Type Field -->
                                                        <div class="col-md-4">
                                                            <div class="form-group" style="background-color: #f4f4f4; padding: 15px; border-radius: 8px;">
                                                                <label for="product-form1">Product Type</label>
                                                                <input type="text" class="form-control" id="product-form2" readonly>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="row">
                                                        <!-- Tanggal dan Jam Penyerahan Sample -->
                                                        <div class="col-md-4">
                                                            <div class="form-group" style="background-color: #f4f4f4; padding: 15px; border-radius: 8px;">
                                                                <label for="penyerahan-sample2">Datetime of Submission</label>
                                                                <input type="datetime-local" class="form-control" id="penyerahan-sample2" value="{{ now()->setTimezone('Asia/Jakarta')->format('Y-m-d\TH:i') }}" readonly>
                                                            </div>
                                                        </div>

                                                        <!-- Material Code Field -->
                                                        <div class="col-md-8">
                                                            <div class="form-group" style="background-color: #f4f4f4; padding: 15px; border-radius: 8px;">
                                                                <label for="code-material2">Material Code</label>
                                                                <select class="form-control" id="code-material2" style="width: 100%">
                                                                    <option value="">Choose Material Code</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <hr> <!-- Horizontal line to separate sections -->

                                                    <!-- Jenis Bahan -->
                                                    <div class="row">
                                                        <!-- Nama Material -->
                                                        <div class="col-md-4">
                                                            <div class="form-group" style="background-color: #f4f4f4; padding: 15px; border-radius: 8px;">
                                                                <label for="material-name2">Material Name</label>
                                                                <select class="form-control" id="material-name2" style="width: 100%">
                                                                    <option value="">Choose Material Name</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <!-- Nomor Lot -->
                                                        <div class="col-md-4">
                                                            <div class="form-group" style="background-color: #f4f4f4; padding: 15px; border-radius: 8px;">
                                                                <label for="batch_number2">Batch Number</label>
                                                                <input type="text" class="form-control" id="batch_number2" placeholder="Enter Batch number">
                                                            </div>
                                                        </div>

                                                        <!-- Manufacture Date -->
                                                        <div class="col-md-4">
                                                            <div class="form-group" style="background-color: #f4f4f4; padding: 15px; border-radius: 8px;">
                                                                <label for="manufacture_date2">Manufacture Date</label>
                                                                <input type="date" class="form-control" id="manufacture_date2" name="manufacture_date2" 
                                                                    value="<?= date('Y-m-d'); ?>">
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <hr> <!-- Horizontal line to separate sections -->

                                                    <div class="div row">
                                                        <!-- Keterangan -->
                                                        <div class="col-md-12">
                                                            <div class="form-group" style="background-color: #f4f4f4; padding: 15px; border-radius: 8px;">
                                                                <label for="keterangan2">Information</label>
                                                                <textarea class="form-control" id="keterangan2" rows="3" placeholder="Enter description"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary btn-round" data-dismiss="modal">Cancel</button>
                                                    <button type="button" class="btn btn-primary btn-round" id="submit-form2">Submit</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Modal 3 - Form 3 -->
                                    <div class="modal fade" id="form3Modal" tabindex="-1" role="dialog" aria-labelledby="form3ModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <!-- Modal Header -->
                                                <div class="modal-header" style="background-color: #266CA9; color: #fff; border-bottom-left-radius: 10px; border-bottom-right-radius: 10px; display: flex; align-items: center; justify-content: center;">
                                                    <h5 class="modal-title fw-bold" id="form3ModalLabel" style="flex: 1; text-align: center;">FORM SPECIALTY PLANT (RM)</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>

                                                <div class="modal-body">
                                                    <!-- Form 3 content with horizontal layout and background colors -->
                                                    <hr>
                                                    <div class="row">
                                                        <!-- Department Field -->
                                                        <div class="col-md-4">
                                                            <div class="form-group" style="background-color: #f4f4f4; padding: 15px; border-radius: 8px;">
                                                                <label for="department-form3">Department</label>
                                                                <input type="text" class="form-control" id="department-form3" readonly>
                                                            </div>
                                                        </div>

                                                        <!-- Material Type Field -->
                                                        <div class="col-md-4">
                                                            <div class="form-group" style="background-color: #f4f4f4; padding: 15px; border-radius: 8px;">
                                                                <label for="material-form3">Material Type</label>
                                                                <input type="text" class="form-control" id="material-form3" readonly>
                                                            </div>
                                                        </div>

                                                        <!-- Product Type Field -->
                                                        <div class="col-md-4">
                                                            <div class="form-group" style="background-color: #f4f4f4; padding: 15px; border-radius: 8px;">
                                                                <label for="product-form3">Product Type</label>
                                                                <input type="text" class="form-control" id="product-form3" readonly>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="row">
                                                        <!-- Tanggal dan Jam Penyerahan Sample -->
                                                        <div class="col-md-4">
                                                            <div class="form-group" style="background-color: #f4f4f4; padding: 15px; border-radius: 8px;">
                                                                <label for="penyerahan-sample3">Datetime of Submission</label>
                                                                <input type="datetime-local" class="form-control" id="penyerahan-sample3" value="{{ now()->setTimezone('Asia/Jakarta')->format('Y-m-d\TH:i') }}" readonly>
                                                            </div>
                                                        </div>

                                                        <!-- Material Code Field -->
                                                        <div class="col-md-8">
                                                            <div class="form-group" style="background-color: #f4f4f4; padding: 15px; border-radius: 8px;">
                                                                <label for="code-material3">Material Code</label>
                                                                <select class="form-control" id="code-material3" style="width: 100%">
                                                                    <option value="">Choose Material Code</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <hr> <!-- Horizontal line to separate sections -->

                                                    <!-- Tanggal Kedatangan -->
                                                    <div class="row">
                                                        <!-- Nama Material -->
                                                        <div class="col-md-4">
                                                            <div class="form-group" style="background-color: #f4f4f4; padding: 15px; border-radius: 8px;">
                                                                <label for="material-name3">Material Name</label>
                                                                <select class="form-control" id="material-name3" style="width: 100%">
                                                                    <option value="">Choose Material Name</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <!-- Nama Supplier -->
                                                        <div class="col-md-4">
                                                            <div class="form-group" style="background-color: #f4f4f4; padding: 15px; border-radius: 8px;">
                                                                <label for="nama-supplier3">Supplier Name</label>
                                                                <input type="text" class="form-control" id="nama-supplier3" placeholder="Enter supplier name">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group" style="background-color: #f4f4f4; padding: 15px; border-radius: 8px;">
                                                                <label for="tanggal-kedatangan3">Arrival Date</label>
                                                                <input type="date" class="form-control" id="tanggal-kedatangan3" value="{{ now()->format('Y-m-d') }}">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <hr> <!-- Horizontal line to separate sections -->

                                                    <!-- Jenis Bahan -->
                                                    <div class="row">
                                                        <!-- No. Mobil -->
                                                        <div class="col-md-6">
                                                            <div class="form-group" style="background-color: #f4f4f4; padding: 15px; border-radius: 8px;">
                                                                <label for="no-mobil3">Car Number</label>
                                                                <input type="text" class="form-control" id="no-mobil3" placeholder="Enter vehicle number">
                                                            </div>
                                                        </div>
                                                        
                                                        <!-- Daftar Nomor Lot -->
                                                        <div class="col-md-6">
                                                            <div class="form-group" style="background-color: #f4f4f4; padding: 15px; border-radius: 8px;">
                                                                <label for="batch_number3">Batch Number</label>
                                                                <input type="text" class="form-control" id="batch_number3" placeholder="Enter Batch Numbers">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <hr>
                                                    <div class="row">
                                                        <!-- Keterangan -->
                                                        <div class="col-md-12">
                                                            <div class="form-group" style="background-color: #f4f4f4; padding: 15px; border-radius: 8px;">
                                                                <label for="keterangan">Information</label>
                                                                <textarea class="form-control" id="keterangan" rows="3" placeholder="Enter description"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary btn-round" data-dismiss="modal">Cancel</button>
                                                    <button type="button" class="btn btn-primary btn-round" id="submit-form3">Submit</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Modal 4 - Form 4 -->
                                    <div class="modal fade" id="form4Modal" tabindex="-1" role="dialog" aria-labelledby="form4ModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <!-- Modal Header -->
                                                <div class="modal-header" style="background-color: #266CA9; color: #fff; border-bottom-left-radius: 10px; border-bottom-right-radius: 10px; display: flex; align-items: center; justify-content: center;">
                                                    <h5 class="modal-title fw-bold" id="form4ModalLabel" style="flex: 1; text-align: center;">FORM TECHNICAL REQUEST (FG / RM)</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>

                                                <div class="modal-body">
                                                    <!-- Form 4 content with horizontal layout and background colors -->
                                                    <div class="row">
                                                        <!-- Department Field -->
                                                        <div class="col-md-4">
                                                            <div class="form-group" style="background-color: #f4f4f4; padding: 15px; border-radius: 8px;">
                                                                <label for="department-form1">Department</label>
                                                                <input type="text" class="form-control" id="department-form4" readonly>
                                                            </div>
                                                        </div>
                                                        <!-- Tanggal Sampling -->
                                                        <div class="col-md-4">
                                                            <div class="form-group" style="background-color: #f4f4f4; padding: 15px; border-radius: 8px;">
                                                                <label for="tanggal-sampling">Sampling Date</label>
                                                                <input type="date" class="form-control" id="tanggal-sampling" value="{{ now()->format('Y-m-d') }}">
                                                            </div>
                                                        </div>

                                                        <!-- Nama Pengirim Sample -->
                                                        <div class="col-md-4">
                                                            <div class="form-group" style="background-color: #f4f4f4; padding: 15px; border-radius: 8px;">
                                                                <label for="nama-pengirim">Name of Sample Sender</label>
                                                                <input type="text" class="form-control" id="nama-pengirim" placeholder="Enter sender name">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="row">
                                                        <!-- Nama Customer -->
                                                        <div class="col-md-6">
                                                            <div class="form-group" style="background-color: #f4f4f4; padding: 15px; border-radius: 8px;">
                                                                <label for="nama-customer">Customer Name</label>
                                                                <input type="text" class="form-control" id="nama-customer" placeholder="Enter customer name">
                                                            </div>
                                                        </div>
                                                   
                                                        <!-- Jenis Sampel  -->
                                                        <div class="col-md-6" style="background-color: #f4f4f4; padding: 15px; border-radius: 8px;">
                                                            <label for="jenis-sampel">Type of Sample</label><br>
                                                            <select class="form-control" id="jenis-sampel" name="jenis-sampel">
                                                                <option value="Boiler Water">Boiler Water (Make Up, RO, Demin, Softener, Feed Water, Boiler)</option>
                                                                <option value="Cooling Water">Cooling Water (Make Up, CT, Chiller)</option>
                                                                <option value="Drinking Water">Drinking Water</option>
                                                                <option value="Air Baku dan WTP">Air Baku dan WTP (Inlet WTP, Outlet WTP)</option>
                                                                <option value="Waste Water">Waste Water (Inlet WWT, Aerasi atau proses WWTP, Outlet WWT)</option>
                                                                <option value="Scale & Sludge">Scale & Sludge</option>
                                                            </select>
                                                        </div>

                                                    </div>

                                                    <hr> <!-- Horizontal line to separate sections -->
                                                    <!-- Jumlah Sample -->
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form-group" style="background-color: #f4f4f4; padding: 15px; border-radius: 8px;">
                                                                <label for="jumlah-sample">Number of Samples</label>
                                                                <input type="text" class="form-control" id="jumlah-sample" placeholder="Enter sample quantity">
                                                            </div>
                                                        </div>

                                                        <!-- Permintaan Tambahan Analisa -->
                                                        <div class="col-md-8">
                                                            <div class="form-group" style="background-color: #f4f4f4; padding: 15px; border-radius: 8px;">
                                                                <label for="permintaan-analisa">Request Additional Analysis</label>
                                                                <textarea class="form-control" id="permintaan-analisa" rows="3" placeholder="Enter additional analysis request"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary btn-round" data-dismiss="modal">Cancel</button>
                                                    <button type="button" class="btn btn-primary btn-round" id="submit-form4">Submit</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Modal 5 - Form 5 -->
                                    <div class="modal fade" id="form5Modal" tabindex="-1" role="dialog" aria-labelledby="form5ModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <!-- Modal Header -->
                                                <div class="modal-header" style="background-color: #266CA9; color: #fff; border-bottom-left-radius: 10px; border-bottom-right-radius: 10px; display: flex; align-items: center; justify-content: center;">
                                                    <h5 class="modal-title fw-bold" id="form5ModalLabel" style="flex: 1; text-align: center;">FORM PAC PLANT FG</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>

                                                <div class="modal-body">
                                                    <!-- Form 5 content -->
                                                    <div class="row">
                                                        <!-- Department Field -->
                                                        <div class="col-md-4">
                                                            <div class="form-group" style="background-color: #f4f4f4; padding: 15px; border-radius: 8px;">
                                                                <label for="department-form5">Department</label>
                                                                <input type="text" class="form-control" id="department-form5" readonly>
                                                            </div>
                                                        </div>

                                                        <!-- Material Type Field -->
                                                        <div class="col-md-4">
                                                            <div class="form-group" style="background-color: #f4f4f4; padding: 15px; border-radius: 8px;">
                                                                <label for="material-form5">Material Type</label>
                                                                <input type="text" class="form-control" id="material-form5" readonly>
                                                            </div>
                                                        </div>

                                                        <!-- Product Type Field -->
                                                        <div class="col-md-4">
                                                            <div class="form-group" style="background-color: #f4f4f4; padding: 15px; border-radius: 8px;">
                                                                <label for="product-form5">Product Type</label>
                                                                <input type="text" class="form-control" id="product-form5" readonly>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <hr>

                                                    <!-- Code Material Field -->
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form-group" style="background-color: #f4f4f4; padding: 15px; border-radius: 8px;">
                                                                <label for="datetime5">Datetime of Submission</label>
                                                                <input type="datetime-local" class="form-control" id="datetime5" value="{{ now()->setTimezone('Asia/Jakarta')->format('Y-m-d\TH:i') }}" readonly>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <div class="form-group" style="background-color: #f4f4f4; padding: 15px; border-radius: 8px;">
                                                                <label for="code-material5">Code Material</label>
                                                                <select class="form-control" id="code-material5" style="width: 100%">
                                                                    <option value="">Choose Code Material</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <hr>

                                                    <!-- Material Name -->
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form-group" style="background-color: #f4f4f4; padding: 15px; border-radius: 8px;">
                                                                <label for="material-name5">Material Name</label>
                                                                <select class="form-control" id="material-name5" style="width: 100%">
                                                                    <option value="">Choose Material Name</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <!-- Additional Inputs (SPK, Keterangan) -->
                                                        <div class="col-md-4">
                                                            <div class="form-group" style="background-color: #f4f4f4; padding: 15px; border-radius: 8px;">
                                                                <label for="no-spk5">No. SPK</label>
                                                                <input type="text" class="form-control" id="no-spk5" placeholder="Enter SPK Number">
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <div class="form-group" style="background-color: #f4f4f4; padding: 15px; border-radius: 8px;">
                                                                <label for="batch_number5">Batch Number</label>
                                                                <input type="text" class="form-control" id="batch_number5" placeholder="Enter Batch Numbers">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form-group" style="background-color: #f4f4f4; padding: 15px; border-radius: 8px;">
                                                                <label for="manufacture_date5">Manufacture Date</label>
                                                                <input type="date" class="form-control" id="manufacture_date5" name="manufacture_date2" 
                                                                    value="<?= date('Y-m-d'); ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <div class="form-group" style="background-color: #f4f4f4; padding: 15px; border-radius: 8px;">
                                                                <label for="keterangan5">Information</label>
                                                                <textarea class="form-control" id="keterangan5" rows="3" placeholder="Enter description (optional)"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Modal Footer -->
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary btn-round" data-dismiss="modal">Cancel</button>
                                                    <button type="button" class="btn btn-primary btn-round" id="submit-form5">Submit</button>
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

    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>


    <!-- Logika Departmen  -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Ambil elemen radio button dan form terkait
            const departmentRadioButtons = document.getElementsByName('department');
            const materialSelect = document.getElementById('material-select');
            const productSelect = document.getElementById('product-select');

            // Fungsi untuk menangani perubahan radio button department
            function handleDepartmentChange() {
                // Cek apakah "Technical" dipilih
                if (document.getElementById('technical').checked) {
                    // Sembunyikan material-select dan product-select
                    materialSelect.style.display = 'none';
                    productSelect.style.display = 'none';
                } else {
                    // Tampilkan material-select dan product-select (untuk "Plant")
                    materialSelect.style.display = 'block';
                    productSelect.style.display = 'block';
                }
            }
            // Set event listener untuk perubahan pada radio button department
            departmentRadioButtons.forEach(button => {
                button.addEventListener('change', handleDepartmentChange);
            });

            // Panggil fungsi sekali saat pertama kali load halaman untuk set tampilan yang benar
            handleDepartmentChange();
        });

    </script>

    <!-- Script logika form modal yang tampil -->
    <script>
        $('#spk-form').on('submit', function(e) {
            e.preventDefault(); // Mencegah form submit secara langsung

            // Mendapatkan nilai dari form
            var department = $('input[name="department"]:checked').val();
            var materialType = $('#material').val();
            var productType = $('#product').val();

            // Menentukan modal yang akan ditampilkan berdasarkan kondisi
            var showModal = '';

            // Mengisi field di modal dengan data yang dipilih
            if (department === 'Plant' && (materialType === 'RM') && productType === 'PAC') {
                showModal = '#form1Modal'; // Form 1
                $('#department-form1').val(department);
                $('#material-form1').val(materialType);
                $('#product-form1').val(productType);
            } else if (department === 'Plant' && materialType === 'FG' && productType === 'PAC') {
                showModal = '#form5Modal'; // Form 5
                $('#department-form5').val(department);
                $('#material-form5').val(materialType);
                $('#product-form5').val(productType);
            } else if (department === 'Plant' && materialType === 'FG' && productType === 'Specialty') {
                showModal = '#form2Modal'; // Form 2
                $('#department-form2').val(department);
                $('#material-form2').val(materialType);
                $('#product-form2').val(productType);
            } else if (department === 'Plant' && materialType === 'RM' && productType === 'Specialty') {
                showModal = '#form3Modal'; // Form 3
                $('#department-form3').val(department);
                $('#material-form3').val(materialType);
                $('#product-form3').val(productType);
            } else if (department === 'Technical') {
                showModal = '#form4Modal'; // Form 4
                $('#department-form4').val(department);
                $('#material-form4').val(materialType);
                $('#product-form4').val(productType);
            }

            // Menampilkan modal sesuai dengan kondisi
            if (showModal) {
                // Menghapus atribut 'aria-hidden' dan menampilkan modal
                $(showModal).removeAttr('aria-hidden').modal('show');
            } else {
                swal("Error!", "The selected combination does not match any form.", "error");
            }
        });

    </script>

    <!-- form 1 code material -->
    <script>
        $(document).ready(function() {
            // Pastikan Choices.js diinisialisasi setelah modal terbuka
            $('#form1Modal').on('shown.bs.modal', function () {
                // Inisialisasi Choices.js untuk dropdown
                const codeMaterialElement = document.getElementById('code_material1');
                const choices = new Choices(codeMaterialElement, {
                    removeItemButton: true,  // Menambahkan tombol untuk menghapus pilihan
                    placeholderValue: 'Choose Code Material',  // Placeholder
                    searchEnabled: true,  // Mengaktifkan pencarian
                    itemSelectText: '',  // Menghapus teks "Select"
                });

                // Memuat data ke Choices.js menggunakan AJAX
                $.ajax({
                    url: '{{ route('get.materials') }}', // URL untuk mendapatkan data material
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        // Format data untuk Choices.js
                        const formattedData = data.items.map(item => ({
                            value: item.material_code,  // Value untuk dipilih
                            label: item.material_code + ' - ' + item.material_name + ' - ' + item.dimension  // Label yang akan ditampilkan di dropdown
                        }));

                        // Menggunakan setChoices untuk memasukkan data ke dalam dropdown Choices.js
                        choices.setChoices(formattedData, 'value', 'label', true);
                    },
                    error: function(error) {
                        console.error("Error loading materials", error);
                    }
                });
            });
        });
    </script>

    <!-- Form 5 code material-->
    <script>
        $(document).ready(function() {
            // Pastikan Choices.js diinisialisasi setelah modal terbuka
            $('#form5Modal').on('shown.bs.modal', function () {
                // Inisialisasi Choices.js untuk dropdown
                const codeMaterialElement = document.getElementById('code-material5');
                const choices = new Choices(codeMaterialElement, {
                    removeItemButton: true,
                    placeholderValue: 'Choose Code Material',
                    searchEnabled: true,
                    itemSelectText: '',
                });

                // Memuat data ke Choices.js menggunakan AJAX
                $.ajax({
                    url: '{{ route('get.materials.form5') }}',
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        // Format data untuk Choices.js
                        const formattedData = data.items.map(item => ({
                            value: item.material_code,
                            label: item.material_code + ' - ' + item.material_name + ' - ' + item.dimension
                        }));

                        // Menggunakan setChoices untuk memasukkan data ke dalam dropdown Choices.js
                        choices.setChoices(formattedData, 'value', 'label', true);
                    },
                    error: function(error) {
                        console.error("Error loading materials", error);
                    }
                });
            });
        });
    </script>

    <!-- Form 2 Material Code -->
    <script>
        $(document).ready(function () {
            // Pastikan Choices.js diinisialisasi setelah modal terbuka
            $('#form2Modal').on('shown.bs.modal', function () {
                // Inisialisasi Choices.js untuk dropdown Material Code
                const codeMaterialElement = document.getElementById('code-material2');
                const choices = new Choices(codeMaterialElement, {
                    removeItemButton: true,
                    placeholderValue: 'Choose Material Code',
                    searchEnabled: true,
                    itemSelectText: '',
                });

                // Memuat data ke Choices.js menggunakan AJAX untuk Material Code
                $.ajax({
                    url: '{{ route('get.materials.form2') }}',  // Pastikan route ini sesuai dengan controller yang meng-handle
                    type: 'GET',
                    dataType: 'json',
                    success: function (data) {
                        // Format data untuk Choices.js
                        const formattedData = data.items.map(item => ({
                            value: item.material_code,  // ID material sebagai value
                            label: item.material_code + ' - ' + item.material_name + ' - ' + item.dimension
                        }));

                        // Menggunakan setChoices untuk memasukkan data ke dalam dropdown
                        choices.setChoices(formattedData, 'value', 'label', true);
                    },
                    error: function (error) {
                        console.error("Error loading materials", error);
                    }
                });
            });
        });
    </script>

    <!-- Form 3 Material Code -->
    <script>
        $(document).ready(function () {
            // Pastikan Choices.js diinisialisasi setelah modal terbuka
            $('#form3Modal').on('shown.bs.modal', function () {
                // Inisialisasi Choices.js untuk dropdown Material Code
                const codeMaterialElement = document.getElementById('code-material3');
                const choices = new Choices(codeMaterialElement, {
                    removeItemButton: true,
                    placeholderValue: 'Choose Material Code',
                    searchEnabled: true,
                    itemSelectText: '',
                });

                // Memuat data ke Choices.js menggunakan AJAX untuk Material Code
                $.ajax({
                    url: '{{ route('get.materials.form3') }}',  // Pastikan route ini sesuai dengan controller yang meng-handle
                    type: 'GET',
                    dataType: 'json',
                    success: function (data) {
                        // Format data untuk Choices.js
                        const formattedData = data.items.map(item => ({
                            value: item.material_code,  // ID material sebagai value
                            label: item.material_code + ' - ' + item.material_name + ' - ' + item.dimension
                        }));

                        // Menggunakan setChoices untuk memasukkan data ke dalam dropdown
                        choices.setChoices(formattedData, 'value', 'label', true);
                    },
                    error: function (error) {
                        console.error("Error loading materials", error);
                    }
                });
            });
        });
    </script>

    <!-- Search Dropdown  PAC form modal 1 untuk nama material-->
    <script>
        $(document).ready(function() {
            var choices = null;  // Menyimpan instance Choices.js

            // Pastikan Choices.js diinisialisasi setelah modal terbuka
            $('#form1Modal').on('shown.bs.modal', function () {
                // Inisialisasi Choices.js untuk dropdown Material Name
                const materialNameElement = document.getElementById('nama-material1');
                choices = new Choices(materialNameElement, {
                    removeItemButton: true,  // Menambahkan tombol untuk menghapus pilihan
                    placeholderValue: 'Choose Material Name',  // Placeholder
                    searchEnabled: true,  // Mengaktifkan pencarian
                    itemSelectText: '',  // Menghapus teks "Select"
                });

                // Memuat data ke Choices.js menggunakan AJAX untuk Material Name
                $.ajax({
                    url: '{{ route('products.get') }}', // URL untuk mendapatkan data produk
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {

                        // Format data untuk Choices.js
                        const formattedData = data.map(product => ({
                            value: product.id,  // ID produk sebagai value
                            label: product.product_name  // Nama produk sebagai label
                        }));

                        // Menggunakan setChoices untuk memasukkan data ke dalam dropdown Choices.js
                        choices.setChoices(formattedData, 'value', 'label', true);
                    },
                    error: function(error) {
                        console.error("Error loading products", error);
                    }
                });
            });

            // Ketika pengguna memilih item dari dropdown Material Name
            $('#nama-material1').on('change', function() {
                var selectedProductId = $(this).val();  // Ambil ID produk yang dipilih
                var selectedProductName = $(this).find('option:selected').text();  // Ambil nama produk yang dipilih

                // Kirimkan product_name (bukan ID) ke server
                $.ajax({
                    url: '/get-product-parameters',  // URL untuk mengambil parameter produk
                    method: 'GET',
                    data: { product_name: selectedProductName },  // Kirimkan product_name
                    success: function(data) {
                        // Menampilkan parameter terkait produk di checkbox
                        if (data) {
                            $('#AI2O3').prop('checked', data.ai2o3);
                            $('#CI').prop('checked', data.cl);
                            $('#SG').prop('checked', data.specific_gravity);
                            $('#Suhu').prop('checked', data.suhu);
                            $('#App').prop('checked', data.app);
                            $('#Basicity').prop('checked', data.basicity);

                            $('#Moisture').prop('checked', data.moisture);
                            $('#Viscosity').prop('checked', data.viscosity);
                            $('#TurbidityJIT').prop('checked', data.turbidity);
                            $('#Turbidity30min').prop('checked', data.turbidity_30min);
                            $('#S04').prop('checked', data.so4);
                            $('#Fe').prop('checked', data.fe);

                            $('#pHPure').prop('checked', data.ph_pure);
                            $('#pH1').prop('checked', data.ph_1_solution);
                            $('#pH30').prop('checked', data.ph_30);
                            $('#FSAM').prop('checked', data.fsam);
                            $('#BE').prop('checked', data.be);
                            $('#LainLain').prop('checked', data.lain_lain);
                        } else {
                            $('#parameter-checkbox-container').html('<div>No parameters found for this product.</div>');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log("Error:", xhr.responseText);
                    }
                });
            });

        });
    </script>

    <!-- Search Dropdown  PAC form modal 5 untuk nama material-->
    <script>
        $(document).ready(function() {
            $('#form5Modal').on('shown.bs.modal', function () {
                const materialNameElement = document.getElementById('material-name5');
                const choices = new Choices(materialNameElement, {
                    removeItemButton: true,
                    placeholderValue: 'Choose Material Name',
                    searchEnabled: true,
                    itemSelectText: '',
                });

                $.ajax({
                    url: '{{ route('products.get') }}',
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        const formattedData = data.map(product => ({
                            value: product.id,
                            label: product.product_name
                        }));

                        choices.setChoices(formattedData, 'value', 'label', true);
                    },
                    error: function(error) {
                        console.error("Error loading products", error);
                    }
                });
            });

            $('#material-name5').on('change', function() {
                var selectedProductName = $(this).find('option:selected').text();

                $.ajax({
                    url: '/get-product-parameters',
                    method: 'GET',
                    data: { product_name: selectedProductName },
                    success: function(data) {                        
                        if (data) {
                            $('#AI2O3_5').prop('checked', data.ai2o3);
                            $('#CI_5').prop('checked', data.cl);
                            $('#SG_5').prop('checked', data.specific_gravity);
                            $('#Suhu_5').prop('checked', data.suhu);
                            $('#App_5').prop('checked', data.app);
                            $('#Basicity_5').prop('checked', data.basicity);

                            $('#Moisture_5').prop('checked', data.moisture);
                            $('#Viscosity_5').prop('checked', data.viscosity);
                            $('#TurbidityJIT_5').prop('checked', data.turbidity);
                            $('#Turbidity30min_5').prop('checked', data.turbidity_30min);
                            $('#S04_5').prop('checked', data.so4);
                            $('#Fe_5').prop('checked', data.fe);

                            $('#pHPure_5').prop('checked', data.ph_pure);
                            $('#pH1_5').prop('checked', data.ph_1_solution);
                            $('#pH30_5').prop('checked', data.ph_30);
                            $('#FSAM_5').prop('checked', data.fsam);
                            $('#BE_5').prop('checked', data.be);
                            $('#LainLain_5').prop('checked', data.lain_lain);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log("Error:", xhr.responseText);
                    }
                });
            });
        });
    </script>

    <!-- Search Dropdown Specialty form modal 2 untuk nama material -->
    <script>
        $(document).ready(function () {
            // Pastikan Choices.js diinisialisasi setelah modal terbuka
            $('#form2Modal').on('shown.bs.modal', function () {
                // Inisialisasi Choices.js untuk dropdown Material Name
                const materialNameElement = document.getElementById('material-name2');
                const choices = new Choices(materialNameElement, {
                    removeItemButton: true,
                    placeholderValue: 'Choose Material Name',
                    searchEnabled: true,
                    itemSelectText: '',
                });

                // Memuat data ke Choices.js menggunakan AJAX untuk Material Name
                $.ajax({
                    url: '{{ route('specialty.products.get') }}', // Ganti dengan URL yang sesuai untuk mendapatkan data specialty products
                    type: 'GET',
                    dataType: 'json',
                    success: function (data) {
                        // Format data untuk Choices.js
                        const formattedData = data.map(item => ({
                            value: item.id, // Gunakan id sebagai value
                            label: item.product_name // Gunakan nama produk sebagai label
                        }));

                        // Menggunakan setChoices untuk memasukkan data ke dalam dropdown Choices.js
                        choices.setChoices(formattedData, 'value', 'label', true);
                    },
                    error: function (error) {
                        console.error("Error loading materials", error);
                    }
                });
            });
        });
    </script>

    <!-- Search Dropdown Specialty form modal 3 untuk nama material -->
    <script>
        $(document).ready(function () {
            // Pastikan Choices.js diinisialisasi setelah modal terbuka
            $('#form3Modal').on('shown.bs.modal', function () {
                // Inisialisasi Choices.js untuk dropdown Material Name
                const materialNameElement = document.getElementById('material-name3');
                const choices = new Choices(materialNameElement, {
                    removeItemButton: true,
                    placeholderValue: 'Choose Material Name',
                    searchEnabled: true,
                    itemSelectText: '',
                });

                // Memuat data ke Choices.js menggunakan AJAX untuk Material Name
                $.ajax({
                    url: '{{ route('specialty.products.get') }}', // Ganti dengan URL yang sesuai untuk mendapatkan data specialty products
                    type: 'GET',
                    dataType: 'json',
                    success: function (data) {
                        // Format data untuk Choices.js
                        const formattedData = data.map(item => ({
                            value: item.id, // Gunakan id sebagai value
                            label: item.product_name // Gunakan nama produk sebagai label
                        }));

                        // Menggunakan setChoices untuk memasukkan data ke dalam dropdown Choices.js
                        choices.setChoices(formattedData, 'value', 'label', true);
                    },
                    error: function (error) {
                        console.error("Error loading materials", error);
                    }
                });
            });
        });
    </script>

    <!-- Form 1 save data-->
    <script>
        document.getElementById("submit-form1").addEventListener("click", function(event) {
            event.preventDefault(); // Mencegah form mengirim GET request
            let csrfToken = document.querySelector('meta[name="csrf-token"]');
            if (!csrfToken) {
                console.error("CSRF token not found");
                return;
            }

            csrfToken = csrfToken.getAttribute('content');

            // Mengambil ID dan nama material
            var materialNameValue = document.getElementById('nama-material1').value;
            var materialNameText = $('#nama-material1 option:selected').text();  // Get selected text (product name)

            // Mengumpulkan data dari form
            var form1Data = {
                department: document.getElementById("department-form1").value,
                material_type: document.getElementById("material-form1").value,
                product_type: document.getElementById("product-form1").value,
                datetime: document.getElementById("datetime1").value, // Datetime submission
                code_material: document.getElementById("code_material1").value, // Code material
                nama_material: materialNameText,
                nama_supplier: document.getElementById("nama-supplier1").value,
                tanggal_kedatangan: document.getElementById("tanggal-kedatangan1").value,
                no_mobil: document.getElementById("no-mobil1").value, // No. Mobil
                batch_number: document.getElementById("batch_number1").value,
                keterangan: document.getElementById("keterangan1").value, // Keterangan (description)

                // Mengumpulkan data checkbox yang dicentang
                selected_checkboxes: {}
            };

            // Mengumpulkan data checkbox yang dicentang
            var checkboxes = document.querySelectorAll('input[type="checkbox"]:checked');
            checkboxes.forEach(function(checkbox) {
                form1Data.selected_checkboxes[checkbox.id] = checkbox.value;
            });

            // Menggunakan SweetAlert untuk konfirmasi pengiriman data
            swal({
                title: "Are You Sure?",
                text: "The data sent cannot be changed!",
                icon: "warning",
                buttons: true,
                dangerMode: true
            }).then((willSubmit) => {
                if (willSubmit) {
                    // Mengirimkan data ke server menggunakan fetch
                    fetch('/store-form1', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify(form1Data)
                    })
                    .then(response => response.json())  // Mengonversi respons menjadi JSON
                    .then(data => {
                        if (data.message) {
                            swal("Sukses!", data.message, "success").then(() => {
                                // Tutup modal jika sukses
                                $('#form1Modal').modal('hide');
                                // Tidak perlu reset form karena data sudah tersimpan
                            });
                        } else {
                            swal("Error!", "An error occurred while saving data.", "error");
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        swal("Error!", "An error occurred while sending data.", "error");
                    });
                } else {
                    swal("Canceled!", "Your data is safe :)", "info");
                }
            });
        });
    </script>

    <!-- Form 2 save data -->
    <script>
        document.getElementById("submit-form2").addEventListener("click", function () {
            // Ambil CSRF Token
            let csrfToken = document.querySelector('meta[name="csrf-token"]');
            if (!csrfToken) {
                console.error("CSRF token not found");
                return;
            }

            csrfToken = csrfToken.getAttribute('content');
            // Mengambil ID dan nama material
            var materialNameValue = document.getElementById('material-name2').value;
            var materialNameText = $('#material-name2 option:selected').text();  // Get selected text (product name)

            // Menyimpan data dari form
            var form2Data = {
                department: document.getElementById("department-form2") ? document.getElementById("department-form2").value : '',
                material_type: document.getElementById("material-form2") ? document.getElementById("material-form2").value : '',
                product_type: document.getElementById("product-form2") ? document.getElementById("product-form2").value : '',
                code_material: document.getElementById("code-material2") ? document.getElementById("code-material2").value : '',
                nama_material: materialNameText,
                batch_number: document.getElementById("batch_number2") ? document.getElementById("batch_number2").value : '',  // Pastikan nilai batch_number dikirim
                penyerahan_sample: document.getElementById("penyerahan-sample2") ? document.getElementById("penyerahan-sample2").value : '',
                manufacture_date: document.getElementById("manufacture_date2") ? document.getElementById("manufacture_date2").value : '',  // Pastikan nilai manufacture_date dikirim
                keterangan: document.getElementById("keterangan2") ? document.getElementById("keterangan2").value : ''
            };

            // Menampilkan SweetAlert konfirmasi
            swal({
                title: "Are you sure?",
                text: "Once submitted, data cannot be changed!",
                icon: "warning",
                buttons: true,
                dangerMode: true
            }).then((willSubmit) => {
                if (willSubmit) {
                    // Mengirimkan data ke server
                    fetch('/store-form2', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify(form2Data)
                    })
                    .then(response => {
                        // Cek apakah respons dari server ok
                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        // Jika berhasil menyimpan
                        if (data.message) {
                            // Menampilkan SweetAlert jika berhasil
                            swal("Sukses!", data.message, "success").then(() => {
                                $('#form2Modal').modal('hide');
                                document.getElementById("form2").reset();  // Reset form setelah submit
                            });
                        } else {
                            // Menampilkan SweetAlert jika terjadi error
                            swal("Error!", "An error occurred while saving data.", "error").then(() => {
                                $('#form2Modal').modal('hide');
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        swal("Error!", "An error occurred while sending data.", "error").then(() => {
                            $('#form2Modal').modal('hide');
                        });
                    });
                } else {
                    swal("Canceled!", "Data is not saved.", "info");
                }
            });
        });
    </script>

    <!-- Form 3 save data-->
    <script>
        document.getElementById("submit-form3").addEventListener("click", function(event) {
            event.preventDefault(); // Mencegah form mengirim GET request

            let csrfToken = document.querySelector('meta[name="csrf-token"]');
            if (!csrfToken) {
                console.error("CSRF token not found");
                return;
            }

            csrfToken = csrfToken.getAttribute('content');
            // Mengambil ID dan nama material
            var materialNameValue = document.getElementById('material-name3').value;
            var materialNameText = $('#material-name3 option:selected').text();  // Get selected text (product name)

            // Mengambil data dari form
            var form3Data = {
                department: document.getElementById("department-form3").value,
                material_type: document.getElementById("material-form3").value,
                product_type: document.getElementById("product-form3").value,
                penyerahan_sample: document.getElementById("penyerahan-sample2").value, 
                code_material: document.getElementById("code-material3").value,
                nama_material: materialNameText,
                nama_supplier: document.getElementById("nama-supplier3").value,
                tanggal_kedatangan: document.getElementById("tanggal-kedatangan3").value,
                no_mobil: document.getElementById("no-mobil3").value,
                batch_number: document.getElementById("batch_number3").value,
                keterangan: document.getElementById("keterangan").value,
            };

            // Menampilkan SweetAlert konfirmasi
            swal({
                title: "Are you sure?",
                text: "Once submitted, data cannot be changed!",
                icon: "warning",
                buttons: true,
                dangerMode: true
            }).then((willSubmit) => {
                if (willSubmit) {
                    // Mengirimkan data ke server menggunakan fetch
                    fetch('/store-form3', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify(form3Data)
                    })
                    .then(response => response.json())  // Mengonversi respons menjadi JSON
                    .then(data => {
                        if (data.message) {
                            swal("Sukses!", data.message, "success").then(() => {
                                // Tutup modal jika sukses
                                $('#form3Modal').modal('hide');
                                document.getElementById("form3").reset();  // Reset form setelah submit
                            });
                        } else {
                            swal("Error!", "An error occurred while saving data.", "error");
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        swal("Error!", "An error occurred while sending data.", "error");
                    });
                } else {
                    swal("Canceled!", "Your data is safe :)", "info");
                }
            });
        });

    </script>


    <!-- Form 4 save data-->
    <script>
        document.getElementById("submit-form4").addEventListener("click", function() {
            let csrfToken = document.querySelector('meta[name="csrf-token"]');
            if (!csrfToken) {
                console.error("CSRF token not found");
                return;
            }

            csrfToken = csrfToken.getAttribute('content');

            // Menyimpan data dari form
            var form4Data = {
                department: document.getElementById("department-form4").value,
                tgl_sampling: document.getElementById("tanggal-sampling").value,
                nama_pengirim_sample: document.getElementById("nama-pengirim").value,
                nama_customer: document.getElementById("nama-customer").value,
                jenis_sampel: document.getElementById("jenis-sampel").value,
                jumlah_sample: document.getElementById("jumlah-sample").value,
                permintaan_tambahan_analisa: document.getElementById("permintaan-analisa").value
            };

            // Menampilkan SweetAlert konfirmasi
            swal({
                title: "Are You Sure?",
                text: "Once submitted, data cannot be changed!",
                icon: "warning",
                buttons: true,
                dangerMode: true
            }).then((willSubmit) => {
                if (willSubmit) {
                    // Mengirimkan data ke server
                    fetch('/store-form4', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify(form4Data)
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.message) {
                            // Menampilkan SweetAlert jika berhasil
                            swal("Sukses!", data.message, "success").then(() => {
                                $('#form4Modal').modal('hide');
                                document.getElementById("form4").reset();
                            });
                        } else {
                            // Menampilkan SweetAlert jika terjadi error
                            swal("Error!", "An error occurred while saving data.", "error").then(() => {
                                $('#form4Modal').modal('hide');
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        swal("Error!", "An error occurred while sending data.", "error").then(() => {
                            $('#form4Modal').modal('hide');
                        });
                    });
                } else {
                    swal("Canceled!", "Data is Not Saved", "info");
                }
            });
        });
    </script>

    <!-- Form 5 save data -->
    <script>
        document.getElementById("submit-form5").addEventListener("click", function(event) {
            event.preventDefault(); // Mencegah form mengirim GET request
            let csrfToken = document.querySelector('meta[name="csrf-token"]');
            if (!csrfToken) {
                console.error("CSRF token not found");
                return;
            }

            csrfToken = csrfToken.getAttribute('content');
            
            // Mengambil ID dan nama material
            var materialNameValue = document.getElementById('material-name5').value;
            var materialNameText = $('#material-name5 option:selected').text();  // Get selected text (product name)

            // Mengumpulkan data dari form
            var form5Data = {
                department: document.getElementById("department-form5").value,
                material_type: document.getElementById("material-form5").value,
                product_type: document.getElementById("product-form5").value,
                datetime: document.getElementById("datetime5").value,
                code_material: document.getElementById("code-material5").value,
                nama_material: materialNameText,
                no_spk: document.getElementById("no-spk5").value,
                batch_number: document.getElementById("batch_number5").value,
                manufacture_date: document.getElementById("manufacture_date5").value,
                keterangan: document.getElementById("keterangan5").value,
                // Data Checkbox (parameter yang dicentang)
                // selected_checkboxes: {}
            };

            // Mengumpulkan data checkbox yang dicentang
            // var checkboxes = document.querySelectorAll('input[type="checkbox"]:checked');
            // checkboxes.forEach(function(checkbox) {
            //     form5Data.selected_checkboxes[checkbox.id] = checkbox.value;
            // });

            // Menggunakan SweetAlert untuk konfirmasi pengiriman data
            swal({
                title: "Are You Sure?",
                text: "The data sent cannot be changed!",
                icon: "warning",
                buttons: true,
                dangerMode: true
            }).then((willSubmit) => {
                if (willSubmit) {
                    // Mengirimkan data ke server menggunakan fetch
                    fetch('/store-form5', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify(form5Data)
                    })
                    .then(response => response.json())  // Mengonversi respons menjadi JSON
                    .then(data => {
                        if (data.message) {
                            swal("Sukses!", data.message, "success").then(() => {
                                // Tutup modal jika sukses
                                $('#form5Modal').modal('hide');
                                document.getElementById("form5").reset();  // Reset form setelah submit
                            });
                        } else {
                            swal("Error!", "An error occurred while saving data.", "error");
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        swal("Error!", "An error occurred while sending data.", "error");
                    });
                } else {
                    swal("Canceled!", "Your data is safe :)", "info");
                }
            });
        });
    </script>

    <!-- Search Dropdown Specialty form 3 -->
    <script>
        // Pencarian untuk material di Form 3
        $('#search-material-specialty3').on('input', function() {
            var searchQuery = $(this).val().toLowerCase();
            var dropdown = $('#material-dropdown-specialty3');

            // Menyembunyikan dropdown jika input kosong
            if (searchQuery === "") {
                dropdown.hide();
                return;
            }

            // Mengambil data produk berdasarkan input pencarian melalui API
            $.ajax({
                url: '/api/specialty-products',  // URL API untuk mengambil produk Specialty
                method: 'GET',
                data: { search: searchQuery },  // Kirimkan query pencarian ke server
                success: function(data) {
                    // Proses data yang diterima dari API
                    if (data.length > 0) {
                        var dropdownContent = data.map(function(product) {
                            return '<div class="dropdown-item" data-name="' + product.product_name + '">' + product.product_name + '</div>';
                        }).join('');
                        $('#material-dropdown-specialty3').html(dropdownContent).show();
                    } else {
                        $('#material-dropdown-specialty3').html('<div class="dropdown-item">No results found</div>').show();
                    }
                },
                error: function(xhr, status, error) {
                    console.log("AJAX Error:", xhr.responseText);
                    try {
                        var response = JSON.parse(xhr.responseText);  // Coba parsing JSON
                    } catch (e) {
                        console.error("Error parsing JSON:", e);
                        alert("An error occurred while retrieving data:" + xhr.responseText);
                    }
                }
            });
        });

        // Ketika pengguna memilih item dari dropdown
        $('#material-dropdown-specialty3').on('click', '.dropdown-item', function() {
            var selectedItem = $(this).text();
            $('#search-material-specialty3').val(selectedItem);  // Isi input dengan nama produk yang dipilih
            $('#material-dropdown-specialty3').hide();  // Sembunyikan dropdown setelah memilih produk
        });

    </script>

</body>
</html>
