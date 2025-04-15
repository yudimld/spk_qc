<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $spk->no_ticket }}</title>
    
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- <link rel="icon" href="{{ asset('atlantis/assets/img/pdf.ico') }}" type="image/x-icon"> -->
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .header {
            text-align: center;
            font-size: 22px;
        }
        .logo {
            position: absolute;
            top: 20px;
            left: 10px;
            width: 300px;
            height: auto;
        }
        .no-ticket {
            position: absolute;
            top: 80px;
            right: 60px;
            font-size: 16px;
            font-weight: bold;
        }

        .test-results {
            font-size: 50px;
            font-weight: bold;
            padding: 2px;
            text-align: center;
            border-radius: 8px;
            margin-left: 20px;
            width: 400px;
            height: 30px;
            color: white !important; /* Teks berwarna putih untuk kontras yang lebih baik */
        }

        /* Warna hijau untuk PASS */
        .test-results.pass {
            background-color: green !important;
        }

        /* Warna merah untuk REJECT */
        .test-results.reject {
            background-color: red !important;
        }


        /* Tabel untuk parameters_data */
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 16px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        td {
            background-color: #fafafa;
        }

        /* Menjaga Kolom Kiri dan Kanan */
        .row {
            margin-top: 20px;
        }
        .col-left, .col-right {
            padding: 10px;
        }

        .info-row {
            display: flex;
            align-items: flex-start; /* atau center kalau kamu ingin rata tengah */
            margin-bottom: 8px;
        }

        /* Pastikan kolom kiri dan kanan terbagi 50% */
        .col-left, .col-right {
            width: 48%;
        }

        /* Menjaga jarak antara kolom */
        .col-left {
            float: left;
            margin-right: 4%;
        }
        .col-right {
            float: left;
        }

        /* Styling untuk Label */
        .label {
            font-weight: bold;
            font-size: 18px;
            margin-bottom: 8px;
        }

        /* Styling untuk isi */
        .isi {
            font-size: 18px;
            line-height: 1.5;
        }
    </style>
</head>
<body>
    <img src="{{ public_path('atlantis/assets/img/LogoLAI.png') }}" class="logo" alt="Logo LAI">

    <div class="no-ticket">
        {{ $spk->no_ticket }}
    </div>

    <div class="header">
        <h3>Test Results of SPK</h3>
    </div>

    <hr>

    <!-- Grid Layout untuk Kolom Kiri dan Kanan menggunakan Bootstrap -->
    <div class="container">
        <div class="row">
            <!-- Kolom Kiri -->
            <div class="col-left">
                <div class="info-row">
                    <span class="label">Department : </span>
                    <span class="isi">{{ $spk->department }}</span>
                </div>
                <div class="info-row">
                    <span class="label">Material Type : </span>
                    <span class="isi">{{ $spk->material_type }}</span>
                </div>
                <div class="info-row">
                    <span class="label">Product Type : </span>
                    <span class="isi">{{ $spk->product_type }}</span>
                </div>
                <div class="info-row">
                    <span class="label">Material Code : </span>
                    <span class="isi">{{ $spk->code_material }}</span>
                </div>
                <div class="info-row">
                    <span class="label">Material Name : </span>
                    <span class="isi">{{ $spk->nama_material }}</span>
                </div>
                <div class="info-row">
                    <span class="label">Bacth Number : </span>
                    <span class="isi">{{ $spk->batch_number }}</span>
                </div>
                <div class="info-row">
                    <span class="label">
                        {{ $spk->material_type === 'RM' ? 'Arrival Date :' : 'Manufacture Date :' }}
                    </span>
                    <span class="isi">
                        {{ $spk->material_type === 'RM' ? $spk->tanggal_kedatangan : $spk->manufacture_date }}
                    </span>
                </div>

            </div>

            <!-- Kolom Kanan -->
            <div class="col-right">
                <div class="info-row">
                    <span class="label">
                        Expiry Date :
                    </span>
                    <span class="isi">
                        {{ $spk->material_type === 'RM' ? ($arrivalExpiryDate ?? 'N/A') : ($expiryDate ?? 'N/A') }}
                    </span>
                </div>
                <div class="info-row">
                    <span class="label">Test Date and Time : </span>
                    <span class="isi">{{ \Carbon\Carbon::parse($spk->test_date)->setTimezone('Asia/Jakarta')->format('d-m-Y H:i') }}</span>
                </div>
                <div class="info-row">
                    <span class="label">Assigned By : </span>
                    <span class="isi">{{ $spk->assign_by }}</span>
                </div>
                
                <div class="info-row">
                    <span class="label">Test Results : </span>
                    <div class="test-results {{ $spk->qc_status == 'Pass' ? 'pass' : 'reject' }}">
                        {{ strtoupper($spk->qc_status) }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel untuk Parameter Data -->
    <div>
        <h3>Parameter Data Test:</h3>
        <table>
            <thead>
                <tr>
                    <th>Parameter Name</th>
                    <th>Standard</th>
                    <th>Ke1</th>
                    <th>Ke2</th>
                    <th>Average</th>
                    <th>Information</th>
                </tr>
            </thead>
            <tbody>
                @foreach($parametersData as $parameter)
                <tr>
                    <td>{{ $parameter['parameter_name'] }}</td>
                    <td>{{ $parameter['standard'] ?? '-' }}</td>
                    <td>{{ $parameter['ke1'] }}</td>
                    <td>{{ $parameter['ke2'] }}</td>
                    <td>{{ $parameter['avg'] }}</td>
                    <td>{{ $parameter['custom_input'] ?? '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
