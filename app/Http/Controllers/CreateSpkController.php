<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

use App\Models\Spk;
use App\Models\User;
use App\Models\Pac;
use App\Models\Specialty;
use App\Models\Gresik;
use App\Models\Tangerang;
use Carbon\Carbon;

class CreateSpkController extends Controller
{
    // Menampilkan halaman create
    public function create()
    {
        return view('create_spk.create');
    }

    //  data master untuk memilih nama material/product form 1
    public function getProducts(Request $request)
    {
        try {
            $products = Pac::select('id', 'product_name')
                            ->where('product_name', 'like', '%' . $request->search . '%')
                            ->get();
            return response()->json($products);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }

    // Controller untuk mendapatkan data Material Name di Form 5
    public function getProducts5(Request $request)
    {
        try {
            // Mengambil data material yang cocok dengan pencarian
            $materials = Pac::select('id', 'product_name')
                                ->where('product_name', 'like', '%' . $request->search . '%')
                                ->get();

            return response()->json($materials);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }

    // data master untuk memilih nama material specialty
    public function getSpecialtyProducts(Request $request)
    {
        try {
            // Mengambil data produk dari model Specialty
            $products = Specialty::select('id', 'product_name')  // Gantilah sesuai dengan kolom di model Specialty
                                ->where('product_name', 'like', '%' . $request->search . '%')
                                ->get();
            return response()->json($products);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }
    
    // parameter auto ceklis berdasarkan nama material 
    public function getProductParameters(Request $request)
    {
        $productName = $request->input('product_name');
        \Log::info('Product Name:', [$productName]);
        // Ambil produk berdasarkan nama produk
        $product = Pac::where('product_name', $productName)->first();

        // Jika produk tidak ditemukan
        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        // Ambil parameter terkait produk ini, periksa apakah ada nilai di produk dan kirimkan ke frontend
        $parameters = [
            'ai2o3' => isset($product->ai2o3_min) && isset($product->ai2o3_max), // true jika ada, false jika tidak ada
            'basicity' => isset($product->basicity_min) && isset($product->basicity_max),
            'ph_1_solution' => isset($product->ph_1_solution_min) && isset($product->ph_1_solution_max),
            'specific_gravity' => isset($product->specific_gravity_min) && isset($product->specific_gravity_max),
            'turbidity' => isset($product->turbidity_min) && isset($product->turbidity_max),
            'fe' => isset($product->fe_min) && isset($product->fe_max),
            'moisture' => isset($product->moisture_min) && isset($product->moisture_max),
            'cl' => isset($product->cl_min) && isset($product->cl_max),
            'so4' => isset($product->so4_min) && isset($product->so4_max),
            'shelf_life' => isset($product->shelf_life),
            'kadar' => isset($product->kadar_min) && isset($product->kadar_max),
            'ph_pure' => isset($product->ph_pure_min) && isset($product->ph_pure_max),
            'kelarutan_hcl' => isset($product->kelarutan_hcl)
        ];

        // Kembalikan parameter ke client
        return response()->json($parameters);
    }

    // code material choice untuk modal 1
    public function getMaterials(Request $request)
    {
        // Mendapatkan parameter pencarian (q) dari request
        $searchTerm = $request->input('q');
        
        // Default untuk menyimpan data dari kedua model
        $materials = collect();
    
        // Menggunakan model Gresik jika location adalah 'gresik'
        if ($request->has('location') && $request->input('location') === 'gresik') {
            $materials = Gresik::where('material_name', 'like', '%' . $searchTerm . '%')
                ->limit(30)
                ->get(['material_code', 'material_name', 'dimension']);
        }
        // Menggunakan model Tangerang jika location adalah 'tangerang'
        else if ($request->has('location') && $request->input('location') === 'tangerang') {
            $materials = Tangerang::where('material_name', 'like', '%' . $searchTerm . '%')
                ->limit(30)
                ->get(['material_code', 'material_name', 'dimension']);
        }
        // Default: jika location tidak diatur, bisa mencari dari kedua model
        else {
            $materialsGresik = Gresik::where('material_name', 'like', '%' . $searchTerm . '%')
                ->get(['material_code', 'material_name', 'dimension']);
                    
            $materialsTangerang = Tangerang::where('material_name', 'like', '%' . $searchTerm . '%')
                ->get(['material_code', 'material_name', 'dimension']);
    
            // Gabungkan hasil dari kedua model
            $materials = $materialsGresik->merge($materialsTangerang);
        }
    
        // Mengembalikan hasil pencarian dalam format JSON
        return response()->json([
            'items' => $materials,
            'total_count' => $materials->count()
        ]);
    }

    // code material choice untuk modal 5
    public function getMaterialsForm5(Request $request)
    {
        $searchTerm = $request->input('q');
        $materials = collect();

        // Logika untuk mengambil data material berdasarkan lokasi (misal: 'gresik' atau 'tangerang')
        if ($request->has('location') && $request->input('location') === 'gresik') {
            $materials = Gresik::where('material_name', 'like', '%' . $searchTerm . '%')
                ->get(['material_code', 'material_name', 'dimension']);
        } else if ($request->has('location') && $request->input('location') === 'tangerang') {
            $materials = Tangerang::where('material_name', 'like', '%' . $searchTerm . '%')
                ->get(['material_code', 'material_name', 'dimension']);
        } else {
            $materialsGresik = Gresik::where('material_name', 'like', '%' . $searchTerm . '%')
                ->get(['material_code', 'material_name', 'dimension']);

            $materialsTangerang = Tangerang::where('material_name', 'like', '%' . $searchTerm . '%')
                ->get(['material_code', 'material_name', 'dimension']);

            $materials = $materialsGresik->merge($materialsTangerang);
        }

        return response()->json([
            'items' => $materials,
            'total_count' => $materials->count()
        ]);
    }

    // code material choice untuk modal 2
    public function getMaterialsForm2(Request $request)
    {
        $searchTerm = $request->input('q');  // Query parameter untuk pencarian jika diperlukan
        $materials = collect();

        // Logika untuk mengambil data material berdasarkan kondisi (misalnya berdasarkan lokasi atau lainnya)
        // Ganti sesuai dengan kebutuhan basis data Anda
        if ($request->has('location') && $request->input('location') === 'gresik') {
            $materials = Gresik::where('material_name', 'like', '%' . $searchTerm . '%')
                ->get(['material_code', 'material_name', 'dimension']);
        } else if ($request->has('location') && $request->input('location') === 'tangerang') {
            $materials = Tangerang::where('material_name', 'like', '%' . $searchTerm . '%')
                ->get(['material_code', 'material_name', 'dimension']);
        } else {
            $materialsGresik = Gresik::where('material_name', 'like', '%' . $searchTerm . '%')
                ->get(['material_code', 'material_name', 'dimension']);

            $materialsTangerang = Tangerang::where('material_name', 'like', '%' . $searchTerm . '%')
                ->get(['material_code', 'material_name', 'dimension']);

            $materials = $materialsGresik->merge($materialsTangerang);
        }

        // Mengembalikan response dalam format JSON
        return response()->json([
            'items' => $materials,  // Kembalikan data material dalam format array
            'total_count' => $materials->count()  // Total jumlah material
        ]);
    }

    // code material choice untuk modal 2
    public function getMaterialsForm3(Request $request)
    {
        $searchTerm = $request->input('q');  // Query parameter untuk pencarian jika diperlukan
        $materials = collect();

        // Logika untuk mengambil data material berdasarkan kondisi (misalnya berdasarkan lokasi atau lainnya)
        // Ganti sesuai dengan kebutuhan basis data Anda
        if ($request->has('location') && $request->input('location') === 'gresik') {
            $materials = Gresik::where('material_name', 'like', '%' . $searchTerm . '%')
                ->get(['material_code', 'material_name', 'dimension']);
        } else if ($request->has('location') && $request->input('location') === 'tangerang') {
            $materials = Tangerang::where('material_name', 'like', '%' . $searchTerm . '%')
                ->get(['material_code', 'material_name', 'dimension']);
        } else {
            $materialsGresik = Gresik::where('material_name', 'like', '%' . $searchTerm . '%')
                ->get(['material_code', 'material_name', 'dimension']);

            $materialsTangerang = Tangerang::where('material_name', 'like', '%' . $searchTerm . '%')
                ->get(['material_code', 'material_name', 'dimension']);

            $materials = $materialsGresik->merge($materialsTangerang);
        }

        // Mengembalikan response dalam format JSON
        return response()->json([
            'items' => $materials,  // Kembalikan data material dalam format array
            'total_count' => $materials->count()  // Total jumlah material
        ]);
    }

    // Menyimpan data untuk Form 1
    public function storeForm1(Request $request)
    {
        if ($request->method() !== 'POST') {
            return response()->json(['error' => 'Method not allowed'], 405);
        }
        // Validasi data yang dikirimkan
        $request->validate([
            'department' => 'required|string|max:255',
            'material_type' => 'required|string|max:255',
            'product_type' => 'required|string|max:255',
            'datetime' => 'required|date',
            'code_material' => 'required|string|max:255', 
            'nama_material' => 'required|string|max:255', 
            'nama_supplier' => 'nullable|string|max:255',
            'tanggal_kedatangan' => 'required|date',  
            'no_mobil' => 'nullable|string|max:50',
            'batch_number' => 'nullable|string|max:50',
            'keterangan' => 'nullable|string|max:255',
            // 'selected_checkboxes' => 'nullable|array',  
        ]);

        // Menyimpan data checkbox yang dipilih
        $selectedCheckboxes = $request->selected_checkboxes;
    
        // Ambil ID Card pengguna yang sedang login
        $userId = auth()->user()->nup;
    
        // Ambil bulan dan tahun saat ini
        $yearMonth = now()->format('y-m');
    
        // Ambil nomor tiket terakhir untuk bulan yang sama
        $lastTicket = Spk::where('no_ticket', 'like', '%'.$yearMonth.'%')
                        ->orderBy('created_at', 'desc')
                        ->first();
    
        // Tentukan nomor urut untuk tiket
        if ($lastTicket) {
            $lastNumber = substr($lastTicket->no_ticket, -6);
            $ticketNumber = str_pad((int)$lastNumber + 1, 6, '0', STR_PAD_LEFT);
        } else {
            $ticketNumber = str_pad(1, 6, '0', STR_PAD_LEFT);
        }
    
        // Gabungkan komponen untuk membuat no_ticket
        $noTicket = $userId . '-' . $yearMonth . '-' . $ticketNumber;
    
        // Konversi datetime dan tgl_produksi ke Jakarta time
        $datetimeJakarta = Carbon::now('Asia/Jakarta')->format('Y-m-d H:i:s');
        $tglProduksiJakarta = $this->convertToJakartaTime($request->tgl_produksi);
    
        // Simpan data ke database
        Spk::create([
            'department' => $request->department,
            'material_type' => $request->material_type,
            'product_type' => $request->product_type,
            'datetime' => $datetimeJakarta,
            'code_material' => $request->code_material,
            'nama_material' => $request->nama_material,
            'nama_supplier' => $request->nama_supplier,
            'tanggal_kedatangan' => $request->tanggal_kedatangan,
            'no_mobil' => $request->no_mobil,
            'batch_number' => $request->batch_number,
            'keterangan' => $request->keterangan,
            'status' => 'open',
            'no_ticket' => $noTicket,
            // 'selected_checkboxes' => json_encode($request->selected_checkboxes),
            'created_by' => $userId,
        ]);
    
        return response()->json(['message' => 'Data saved successfully ']);
    } 
    
    // Menyimpan data untuk Form 2
    public function storeForm2(Request $request)
    {
        try {
            // Validasi data yang diterima dari request
            $validatedData = $request->validate([
                'department' => 'required|string|max:255',
                'material_type' => 'required|string|max:255',
                'product_type' => 'required|string|max:255',
                'code_material' => 'required|string|max:255',
                'nama_material' => 'required|string|max:255',
                'batch_number' => 'required|string|max:50',
                'penyerahan_sample' => 'required|date',  // Pastikan format tanggal benar
                'manufacture_date' => 'required|date',
                'keterangan' => 'nullable|string|max:255',
            ]);

            // Ambil ID pengguna yang sedang login
            $userId = auth()->user()->nup;

            // Ambil bulan dan tahun saat ini untuk membuat nomor tiket
            $yearMonth = now()->format('y-m');

            // Ambil nomor tiket terakhir untuk bulan yang sama
            $lastTicket = Spk::where('no_ticket', 'like', '%'.$yearMonth.'%')
                             ->orderBy('created_at', 'desc')
                             ->first();

            // Tentukan nomor urut untuk tiket
            if ($lastTicket) {
                $lastNumber = substr($lastTicket->no_ticket, -6);
                $ticketNumber = str_pad((int)$lastNumber + 1, 6, '0', STR_PAD_LEFT);
            } else {
                $ticketNumber = str_pad(1, 6, '0', STR_PAD_LEFT);
            }

            // Gabungkan komponen untuk membuat no_ticket
            $noTicket = $userId . '-' . $yearMonth . '-' . $ticketNumber;

            // Konversi penyerahan_sample ke waktu Jakarta
            $penyerahanSampleJakarta = Carbon::now('Asia/Jakarta')->format('Y-m-d H:i:s');

            // Simpan data ke dalam database Spk
            Spk::create([
                'department' => $validatedData['department'],
                'material_type' => $validatedData['material_type'],
                'product_type' => $validatedData['product_type'],
                'code_material' => $validatedData['code_material'],
                'nama_material' => $validatedData['nama_material'],
                'batch_number' => $validatedData['batch_number'],
                'penyerahan_sample' => $penyerahanSampleJakarta,  // Simpan dalam waktu Jakarta
                'manufacture_date' => $validatedData['manufacture_date'],
                'keterangan' => $validatedData['keterangan'],
                'status' => 'open',
                'no_ticket' => $noTicket,
                'created_by' => $userId,
            ]);

            // Kembalikan respons sukses
            return response()->json(['message' => 'Data saved successfully']);

        } catch (\Exception $e) {
            // Menangani error yang terjadi
            Log::error('Error storing form data: ', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'An error occurred while saving data.'], 500);
        }
    }

    // Menyimpan data untuk Form 3
    public function storeForm3(Request $request)
    {
        try {
            // Validasi data yang dikirimkan
            $validatedData = $request->validate([
                'department' => 'required|string|max:255',
                'material_type' => 'required|string|max:255',
                'product_type' => 'required|string|max:255',
                'penyerahan_sample' => 'required|date',
                'code_material' => 'required|string|max:255',
                'nama_material' => 'required|string|max:255',  // Nama Material
                'nama_supplier' => 'nullable|string|max:255',  // Nama Supplier
                'tanggal_kedatangan' => 'required|date',       // Tanggal Kedatangan
                'no_mobil' => 'nullable|string|max:50',        // No. Mobil
                'batch_number' => 'nullable|string|max:50',       // Nomor Lot
                'keterangan' => 'nullable|string|max:255',     // Keterangan
            ]);

            // Ambil ID Card pengguna yang sedang login
            $userId = auth()->user()->nup;

            // Ambil bulan dan tahun saat ini
            $yearMonth = now()->format('y-m');

            // Ambil nomor tiket terakhir untuk bulan yang sama
            $lastTicket = Spk::where('no_ticket', 'like', '%'.$yearMonth.'%')
                             ->orderBy('created_at', 'desc')
                             ->first();

            // Tentukan nomor urut untuk tiket
            if ($lastTicket) {
                $lastNumber = substr($lastTicket->no_ticket, -6);
                $ticketNumber = str_pad((int)$lastNumber + 1, 6, '0', STR_PAD_LEFT);
            } else {
                $ticketNumber = str_pad(1, 6, '0', STR_PAD_LEFT);
            }

            // Gabungkan komponen untuk membuat no_ticket
            $noTicket = $userId . '-' . $yearMonth . '-' . $ticketNumber;

            // Konversi penyerahan_sample ke waktu Jakarta
            $penyerahanSampleJakarta = Carbon::now('Asia/Jakarta')->format('Y-m-d H:i:s');

            // Simpan data ke database
            Spk::create([
                'department' => $validatedData['department'],
                'material_type' => $validatedData['material_type'],
                'product_type' => $validatedData['product_type'],
                'penyerahan_sample' => $penyerahanSampleJakarta,
                'code_material' => $validatedData['code_material'],
                'nama_material' => $validatedData['nama_material'],
                'nama_supplier' => $validatedData['nama_supplier'],
                'tanggal_kedatangan' => $validatedData['tanggal_kedatangan'],
                'no_mobil' => $validatedData['no_mobil'],
                'batch_number' => $validatedData['batch_number'],
                'keterangan' => $validatedData['keterangan'],
                'status' => 'open',
                'no_ticket' => $noTicket,
                'created_by' => $userId,
            ]);

            return response()->json(['message' => 'Data saved successfully']);
        } catch (\Exception $e) {
            // Cek jika terjadi kesalahan
            Log::error('Error storing form data: ', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'An error occurred while saving data.'], 500);
        }
    }
    
    // Menyimpan data untuk Form 4
    public function storeForm4(Request $request)
    {
        try {
            // Validasi data yang dikirim
            $validatedData = $request->validate([
                'department' => 'required|string|max:255',
                'tgl_sampling' => 'required|date',
                'nama_pengirim_sample' => 'required|string|max:255',
                'nama_customer' => 'required|string|max:255',
                'jenis_sampel' => 'required|string',
                'jumlah_sample' => 'required|integer',
                'permintaan_tambahan_analisa' => 'nullable|string|max:255',
            ]);

            // Ambil ID Card pengguna yang sedang login
            $userId = auth()->user()->nup; // Asumsi ID card disimpan di kolom nup

            // Ambil bulan dan tahun saat ini
            $yearMonth = now()->format('y-m'); // Format YY-MM

            // Ambil nomor tiket terakhir untuk bulan yang sama
            $lastTicket = Spk::where('no_ticket', 'like', '%'.$yearMonth.'%')
                            ->orderBy('created_at', 'desc')
                            ->first();

            // Tentukan nomor urut untuk tiket
            if ($lastTicket) {
                // Ambil nomor urut terakhir dan tambahkan 1
                $lastNumber = substr($lastTicket->no_ticket, -6);
                $ticketNumber = str_pad((int)$lastNumber + 1, 6, '0', STR_PAD_LEFT);
            } else {
                // Jika belum ada, mulai dari 1
                $ticketNumber = str_pad(1, 6, '0', STR_PAD_LEFT);
            }

            // Gabungkan komponen untuk membuat no_ticket
            $noTicket = $userId . '-' . $yearMonth . '-' . $ticketNumber;


            // Simpan data ke database (menyesuaikan dengan model dan struktur tabel di database)
            Spk::create([
                'department' => $request->department,
                'tgl_sampling' => $request->tgl_sampling,
                'nama_pengirim_sample' => $request->nama_pengirim_sample,
                'nama_customer' => $request->nama_customer,
                'jenis_sampel' => $request->jenis_sampel,
                'jumlah_sample' => $request->jumlah_sample,
                'permintaan_tambahan_analisa' => $request->permintaan_tambahan_analisa,
                'status' => 'open',  // Menambahkan status 'open'
                'no_ticket' => $noTicket, // Simpan no_ticket
                'created_by' => $userId,
            ]);

            // Kirimkan respon sukses
            return response()->json(['message' => 'Data saved successfully']);
        } catch (\Exception $e) {
            // Log error jika ada masalah
            \Log::error("Error saving form 4 data: " . $e->getMessage());

            // Kirimkan respon error
            return response()->json(['message' => 'An error occurred while saving data.'], 500);
        }
    }

    // Menyimpan data untuk Form 5 FG PAC
    public function storeForm5(Request $request)
    {
        if ($request->method() !== 'POST') {
            return response()->json(['error' => 'Method not allowed'], 405);
        }

        // Validasi data yang dikirimkan
        $request->validate([
            'department' => 'required|string|max:255',
            'material_type' => 'required|string|max:255',
            'product_type' => 'required|string|max:255',
            'datetime' => 'required|date',
            'code_material' => 'required|string|max:255',  // Code material
            'nama_material' => 'required|string|max:255',  // Material name
            'no_spk' => 'nullable|string|max:50',
            'batch_number' => 'nullable|string|max:50',
            'manufacture_date' => 'nullable|string|max:50',
            'keterangan' => 'nullable|string|max:255',
        ]);

        // Menyimpan data checkbox yang dipilih
        $selectedCheckboxes = $request->selected_checkboxes;

        // Ambil ID Card pengguna yang sedang login
        $userId = auth()->user()->nup;

        // Ambil bulan dan tahun saat ini
        $yearMonth = now()->format('y-m');

        // Ambil nomor tiket terakhir untuk bulan yang sama
        $lastTicket = Spk::where('no_ticket', 'like', '%'.$yearMonth.'%')
                        ->orderBy('created_at', 'desc')
                        ->first();

        // Tentukan nomor urut untuk tiket
        if ($lastTicket) {
            $lastNumber = substr($lastTicket->no_ticket, -6);
            $ticketNumber = str_pad((int)$lastNumber + 1, 6, '0', STR_PAD_LEFT);
        } else {
            $ticketNumber = str_pad(1, 6, '0', STR_PAD_LEFT);
        }

        // Gabungkan komponen untuk membuat no_ticket
        $noTicket = $userId . '-' . $yearMonth . '-' . $ticketNumber;

        // Konversi datetime dan tgl_produksi ke Jakarta time
        $datetimeJakarta = Carbon::now('Asia/Jakarta')->format('Y-m-d H:i:s');
        $tglProduksiJakarta = $this->convertToJakartaTime($request->tgl_produksi);

        // Simpan data ke database
        Spk::create([
            'department' => $request->department,
            'material_type' => $request->material_type,
            'product_type' => $request->product_type,
            'datetime' => $datetimeJakarta,
            'code_material' => $request->code_material,  // Code material
            'nama_material' => $request->nama_material,  // Material name
            'no_spk' => $request->no_spk,
            'batch_number' => $request->batch_number,
            'manufacture_date' => $request->manufacture_date,
            'keterangan' => $request->keterangan,
            'status' => 'open',
            'no_ticket' => $noTicket,
            'created_by' => $userId,
        ]);

        return response()->json(['message' => 'Data saved successfully']);
    }

    // Fungsi untuk mengonversi waktu UTC ke waktu Jakarta (WIB)
    public function convertToJakartaTime($utcDate)
    {
        // Membuat objek DateTime dari string UTC
        $date = new \DateTime($utcDate, new \DateTimeZone('UTC'));

        // Mengubah zona waktu ke Jakarta (Asia/Jakarta)
        $date->setTimezone(new \DateTimeZone('Asia/Jakarta'));

        // Mengembalikan waktu dalam format yang diinginkan, misalnya 'Y-m-d H:i:s'
        return $date->format('Y-m-d H:i:s');
    }


}
