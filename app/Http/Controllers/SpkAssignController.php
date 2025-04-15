<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Spk;
use App\Models\Pac;
use App\Models\Specialty;
use Log;

class SpkAssignController extends Controller
{
    public function index()
    {
        // Ambil semua SPK yang statusnya 'assigned' atau 're-assigned' menggunakan whereIn untuk MongoDB
        $spksAssigned = Spk::whereIn('status', ['assigned', 're-assigned'])->get(); // Menggunakan whereIn
    
        // Ambil SPK pertama atau SPK tertentu jika diperlukan
        // Jika Anda ingin mengambil salah satu SPK untuk ditampilkan sebagai default
        $spkId = $spksAssigned->isNotEmpty() ? $spksAssigned->first()->_id : null; // Gunakan _id untuk MongoDB
    
        // Kirim data SPK yang telah di-assign dan spkId ke view
        return view('assign.spk_assign', compact('spksAssigned', 'spkId'));
    }
    
    // public function getSpkData(Request $request)
    // public function getSpkData(Request $request)
    // {
    //     // Ambil data SPK yang statusnya 'assigned' dan 're-assigned', dan urutkan berdasarkan created_at
    //     $query = Spk::whereIn('status', ['assigned', 're-assigned'])->orderBy('created_at', 'desc');


    //     // Ambil data dengan pagination untuk server-side processing
    //     $spksAssigned = $query->paginate(5);  // Gunakan pagination untuk memfilter dan membatasi data

    //     // Format data untuk dikirim ke DataTable
    //     $data = $spksAssigned->map(function ($spk) {
    //         return [
    //             'status' => $spk->status,
    //             'department' => $spk->department,
    //             'material_type' => $spk->material_type,
    //             'product_type' => $spk->product_type,
    //             'assign_by' => $spk->assign_by,
    //             'lokasi' => $spk->lokasi,
    //             'no_ticket' => $spk->no_ticket,
    //             'actions' => '<a href="javascript:void(0);" class="btn btn-link btn-info" data-id="' . $spk->id . '" id="btnDetail"><i class="fa fa-eye"></i></a><button type="button" class="btn btn-link btn-info" data-id="' . $spk->id . '" id="btnSubmitAssign"><i class="fa fa-paper-plane"></i></button>',
    //             // Menambahkan data lainnya sesuai fillable
    //             'jenis_material' => $spk->jenis_material,
    //             'bahan_baku' => $spk->bahan_baku,
    //             'produksi' => $spk->produksi,
    //             'nama_material' => $spk->nama_material,
    //             'no_spk' => $spk->no_spk,
    //             'batch' => $spk->batch,
    //             'feed' => $spk->feed,
    //             'datetime' => $spk->datetime,
    //             'tgl_produksi' => $spk->tgl_produksi,
    //             'equipment' => $spk->equipment,
    //             'keterangan' => $spk->keterangan,
    //             'no_mobil' => $spk->no_mobil,
    //             'penyerahan_sample' => $spk->penyerahan_sample,
    //             'batch_number' => $spk->batch_number,
    //             'tanggal_kedatangan' => $spk->tanggal_kedatangan,
    //             'manufacture_date' => $spk->manufacture_date,
    //             'dokumen' => $spk->dokumen,
    //             'jenis_bahan' => $spk->jenis_bahan,
    //             'nama_supplier' => $spk->nama_supplier,
    //             'tgl_sampling' => $spk->tgl_sampling,
    //             'nama_pengirim_sample' => $spk->nama_pengirim_sample,
    //             'nama_customer' => $spk->nama_customer,
    //             'jenis_sampel' => $spk->jenis_sampel,
    //             'jumlah_sample' => $spk->jumlah_sample,
    //             'permintaan_tambahan_analisa' => $spk->permintaan_tambahan_analisa,
    //             'qc_status' => $spk->qc_status,
    //             'test_date' => $spk->test_date,
    //             'parameters_data' => $spk->parameters_data,  // Jika kamu ingin mengirimkan data array
    //         ];
    //     });

    //     // Mengembalikan data dalam format yang sesuai untuk DataTable
    //     return response()->json([
    //         'draw' => $request->draw,
    //         'recordsTotal' => $spksAssigned->total(),  // Total records tanpa filter
    //         'recordsFiltered' => $spksAssigned->total(),  // Total records setelah filter diterapkan
    //         'data' => $data
    //     ]);
    // }
    public function getSpkData(Request $request)
    {
        $query = Spk::whereIn('status', ['assigned', 're-assigned'])->orderBy('created_at', 'desc');
    
        // Pencarian global (search.value)
        if ($request->has('search.value')) {
            $searchValue = $request->input('search.value');
            $query->where(function ($q) use ($searchValue) {
                $q->where('status', 'like', "%$searchValue%")
                  ->orWhere('nama_material', 'like', "%$searchValue%")
                  ->orWhere('no_ticket', 'like', "%$searchValue%")
                  ->orWhere('batch_number', 'like', "%$searchValue%")
                  ->orWhere('product_type', 'like', "%$searchValue%")
                  ->orWhere('assign_by', 'like', "%$searchValue%")
                  ->orWhere('lokasi', 'like', "%$searchValue%");
            });
        }
    
        // Pagination dan sorting
        $start = $request->input('start') ?? 0;
        $length = $request->input('length') ?? 10;
        $orderColumnIndex = $request->input('order')[0]['column'] ?? 0;
        $orderDirection = $request->input('order')[0]['dir'] ?? 'asc';
        $columns = ['status', 'nama_material', 'no_ticket', 'batch_number', 'product_type', 'assign_by', 'lokasi'];
    
        if (isset($columns[$orderColumnIndex])) {
            $query->orderBy($columns[$orderColumnIndex], $orderDirection);
        }
    
        // Hitung total data sebelum filter
        $totalRecords = Spk::count();
        // Hitung total data setelah filter
        $filteredRecords = $query->count();
    
        // Ambil data dengan pagination
        $spks = $query->skip($start)->take($length)->get();
    
        // Format data untuk DataTables
        $data = $spks->map(function ($spk) {
            return [
                'status' => '<span class="badge badge-' . ($spk->status == 'assigned' ? 'warning' : 'reassigned') . '">' . ucfirst($spk->status) . '</span>',
                'department' => ucfirst($spk->department),
                'material_type' => ucfirst($spk->material_type),
                'product_type' => ucfirst($spk->product_type),
                'assign_by' => ucfirst($spk->assign_by),
                'lokasi' => ucfirst($spk->lokasi),
                'no_ticket' => ucfirst($spk->no_ticket),
                'actions' => '<a href="javascript:void(0);" class="btn btn-link btn-info" data-id="' . $spk->id . '" id="btnDetail"><i class="fa fa-eye"></i></a><button type="button" class="btn btn-link btn-info" data-id="' . $spk->id . '" id="btnSubmitAssign"><i class="fa fa-paper-plane"></i></button>',
                // Menambahkan data lainnya sesuai kebutuhan
                'jenis_material' => ucfirst($spk->jenis_material),
                'bahan_baku' => ucfirst($spk->bahan_baku),
                'produksi' => ucfirst($spk->produksi),
                'nama_material' => ucfirst($spk->nama_material),
                'no_spk' => ucfirst($spk->no_spk),
                'batch' => ucfirst($spk->batch),
                'feed' => ucfirst($spk->feed),
                'datetime' => ucfirst($spk->datetime),
                'tgl_produksi' => ucfirst($spk->tgl_produksi),
                'equipment' => ucfirst($spk->equipment),
                'keterangan' => ucfirst($spk->keterangan),
                'no_mobil' => $spk->no_mobil,
                'penyerahan_sample' => $spk->penyerahan_sample,
                'batch_number' => $spk->batch_number,
                'tanggal_kedatangan' => $spk->tanggal_kedatangan,
                'manufacture_date' => $spk->manufacture_date,
                'dokumen' => $spk->dokumen,
                'jenis_bahan' => $spk->jenis_bahan,
                'nama_supplier' => $spk->nama_supplier,
                'tgl_sampling' => $spk->tgl_sampling,
                'nama_pengirim_sample' => $spk->nama_pengirim_sample,
                'nama_customer' => $spk->nama_customer,
                'jenis_sampel' => $spk->jenis_sampel,
                'jumlah_sample' => $spk->jumlah_sample,
                'permintaan_tambahan_analisa' => $spk->permintaan_tambahan_analisa,
                'qc_status' => $spk->qc_status,
                'test_date' => $spk->test_date,
                'parameters_data' => $spk->parameters_data,
            ];
        });
    
        return response()->json([
            'draw' => intval($request->input('draw')),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data' => $data,
        ]);
    }
    

    

    public function showDetail($id)
    {
        $spk = Spk::findOrFail($id);  // Ambil data SPK berdasarkan ID
        return response()->json($spk);  // Kembalikan data dalam format JSON
    }

    // parameter submit 
    public function getSpkDetail($id)
    {
        // Find SPK by ID
        $spk = Spk::findOrFail($id);
        
        return response()->json($spk); // Return SPK data as JSON
    }

    // Mengambil parameter berdasarkan selected_checkboxes
    public function getParameters(Request $request)
    {
        // Ambil ID SPK dari request
        $spkId = $request->input('id');

        // Ambil data SPK berdasarkan ID yang diberikan
        $spk = Spk::find($spkId);

        // Jika SPK tidak ditemukan, kembalikan response error
        if (!$spk) {
            return response()->json(['error' => 'SPK not found'], 404);
        }

        // Ambil nama material dari SPK
        $namaMaterial = is_array($spk->nama_material) ? $spk->nama_material[0] : $spk->nama_material;
        $namaMaterial = trim($namaMaterial);

        // === CASE 1: Plant + PAC + FG/RM ===
        if (
            $spk->department === 'Plant' &&
            $spk->product_type === 'PAC' &&
            in_array($spk->material_type, ['FG', 'RM'])
        ) {
            $pacData = Pac::where('product_name', $namaMaterial)->first();

            if (!$pacData) {
                Log::warning("PAC data not found for material: $namaMaterial");
                return response()->json(['error' => 'PAC data not found for this material'], 404);
            }

            $selectedCheckboxes = json_decode($pacData->selected_checkboxes ?? '[]', true);
            $pacDataFiltered = array_filter([
                'appearance' => $pacData->appearance ?: null,
                'ai2o3' => (isset($pacData->ai2o3_min) && isset($pacData->ai2o3_max)) ? "{$pacData->ai2o3_min} - {$pacData->ai2o3_max}" : null,
                'basicity' => (isset($pacData->basicity_min) && isset($pacData->basicity_max)) ? "{$pacData->basicity_min} - {$pacData->basicity_max}" : null,
                'ph_1_solution' => (isset($pacData->ph_1_solution_min) && isset($pacData->ph_1_solution_max)) ? "{$pacData->ph_1_solution_min} - {$pacData->ph_1_solution_max}" : null,
                'specific_gravity' => (isset($pacData->specific_gravity_min) && isset($pacData->specific_gravity_max)) ? "{$pacData->specific_gravity_min} - {$pacData->specific_gravity_max}" : null,
                'turbidity' => (isset($pacData->turbidity_min) && isset($pacData->turbidity_max)) ? "{$pacData->turbidity_min} - {$pacData->turbidity_max}" : null,
                'fe' => (isset($pacData->fe_min) && isset($pacData->fe_max)) ? "{$pacData->fe_min} - {$pacData->fe_max}" : null,
                'moisture' => (isset($pacData->moisture_min) && isset($pacData->moisture_max)) ? "{$pacData->moisture_min} - {$pacData->moisture_max}" : null,
                'cl' => (isset($pacData->cl_min) && isset($pacData->cl_max)) ? "{$pacData->cl_min} - {$pacData->cl_max}" : null,
                'so4' => (isset($pacData->so4_min) && isset($pacData->so4_max)) ? "{$pacData->so4_min} - {$pacData->so4_max}" : null,
                'kadar' => (isset($pacData->kadar_min) && isset($pacData->kadar_max)) ? "{$pacData->kadar_min} - {$pacData->kadar_max}" : null,
                'ph_pure' => (isset($pacData->ph_pure_min) && isset($pacData->ph_pure_max)) ? "{$pacData->ph_pure_min} - {$pacData->ph_pure_max}" : null,
                'kelarutan_hcl' => $pacData->kelarutan_hcl ?: null,
            ], fn($value) => !is_null($value));

            return response()->json([
                'spk' => $spk,
                'material_type' => $spk->material_type,
                'product_type' => $spk->product_type,
                'pac_data' => $pacDataFiltered,
                'selected_checkboxes' => $selectedCheckboxes,
            ]);
        }

        // === CASE 2 & 3: Plant + Specialty (FG atau RM) ===
        if (
            $spk->department === 'Plant' &&
            $spk->product_type === 'Specialty' &&
            in_array($spk->material_type, ['FG', 'RM'])
        ) {
            $specialtyData = Specialty::where('product_name', $namaMaterial)->first();

            if (!$specialtyData) {
                Log::warning("Specialty data not found for material: $namaMaterial");
                return response()->json(['error' => 'Specialty data not found for this material'], 404);
            }

            $specialtyDataFiltered = $this->filterSpecialtyData($specialtyData);

            return response()->json([
                'spk' => $spk,
                'material_type' => $spk->material_type,
                'product_type' => $spk->product_type,
                'specialty_data' => $specialtyDataFiltered,
            ]);
        }

        // === Default: Kondisi tidak dikenali ===
        Log::warning('Invalid SPK condition or unrecognized modal type');
        return response()->json(['error' => 'Invalid SPK or modal type'], 400);
    }


    /**
     * Helper function to filter Specialty data
     */
    private function filterSpecialtyData($data)
    {
        return array_filter([
            'appearance' => $data->appearance ?: null,
            'solution' => $data->solution ?: null,
            'ph_value' => (isset($data->ph_value_min) && isset($data->ph_value_max)) ? "{$data->ph_value_min} - {$data->ph_value_max}" : null,
            'sg' => (isset($data->sg_min) && isset($data->sg_max)) ? "{$data->sg_min} - {$data->sg_max}" : null,
            'sg_01' => (isset($data->sg_01_min) && isset($data->sg_01_max)) ? "{$data->sg_01_min} - {$data->sg_01_max}" : null,
            'viscosity' => (isset($data->viscosity_min) && isset($data->viscosity_max)) ? "{$data->viscosity_min} - {$data->viscosity_max}" : null,
            'viscosity_01' => (isset($data->viscosity_01_min) && isset($data->viscosity_01_max)) ? "{$data->viscosity_01_min} - {$data->viscosity_01_max}" : null,
            'dry_weight' => $data->dry_weight ?: null,
            'purity' => (isset($data->purity_min) && isset($data->purity_max)) ? "{$data->purity_min} - {$data->purity_max}" : null,
            'specific_gravity' => (isset($data->specific_gravity_min) && isset($data->specific_gravity_max)) ? "{$data->specific_gravity_min} - {$data->specific_gravity_max}" : null,
            'specific_gravity_01' => (isset($data->specific_gravity_01_min) && isset($data->specific_gravity_01_max)) ? "{$data->specific_gravity_01_min} - {$data->specific_gravity_01_max}" : null,
            'moisture' => (isset($data->moisture_water_min) && isset($data->moisture_water_max)) ? "{$data->moisture_water_min} - {$data->moisture_water_max}" : null,
            'residue_on_ignition' => (isset($data->residue_on_ignition_min) && isset($data->residue_on_ignition_max)) ? "{$data->residue_on_ignition_min} - {$data->residue_on_ignition_max}" : null,
            'solid_content' => (isset($data->solid_content_min) && isset($data->solid_content_max)) ? "{$data->solid_content_min} - {$data->solid_content_max}" : null,
        ], fn($value) => !is_null($value));
    }

    // form 3 save
    public function saveParameterData(Request $request)
    {
        try {
            // Ambil data dari request
            $spkId = $request->input('spkId');
            $testDate = $request->input('testDate');
            $qcStatus = $request->input('qcStatus');
            $formData = $request->input('formData');
            $keterangan = $request->input('keterangan');

            // Validasi awal: cek apakah formData adalah array
            if (!is_array($formData)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'formData harus berupa array!',
                    'debug_formData' => $formData
                ], 422);
            }

            // Cek SPK ada atau tidak
            $spk = Spk::find($spkId);
            if (!$spk) {
                return response()->json(['message' => 'SPK not found!'], 404);
            }

            // Update data utama SPK
            $spk->test_date = $testDate;
            $spk->qc_status = $qcStatus;
            $spk->status = "request to close";
            $spk->keterangan = $keterangan;

            $parametersData = [];

            // Proses setiap parameter
            foreach ($formData as $parameter) {
                $paramName = $parameter['parameter_name'] ?? null;

                if (!$paramName) {
                    continue;
                }

                // === Validasi khusus untuk "Appearance"
                if ($paramName === "Appearance") {
                    if (empty($parameter['custom_input'])) {
                        return response()->json([
                            'status' => 'error',
                            'message' => "Input untuk parameter 'Appearance' wajib diisi."
                        ], 422);
                    }

                    $parametersData[] = [
                        'parameter_name' => $paramName,
                        'standard' => $parameter['standard'] ?? null,
                        'ke1' => null,
                        'ke2' => null,
                        'avg' => null,
                        'custom_input' => $parameter['custom_input'],
                    ];
                }
                // === Jika parameter adalah "Solution PH(%)"
                elseif ($paramName === "Solution PH(%)") {
                    $parametersData[] = [
                        'parameter_name' => $paramName,
                        'standard' => $parameter['standard'] ?? null,
                        'ke1' => $parameter['ke1'] ?? null,
                        'ke2' => $parameter['ke2'] ?? null,
                        'avg' => $parameter['avg'] ?? null,
                        'custom_input' => $parameter['custom_input'] ?? null,
                    ];
                }
                // === Parameter umum, jika ada isian numeric
                elseif (!empty($parameter['ke1']) || !empty($parameter['ke2']) || !empty($parameter['avg'])) {
                    $parametersData[] = [
                        'parameter_name' => $paramName,
                        'standard' => $parameter['standard'] ?? null,
                        'ke1' => $parameter['ke1'] ?? null,
                        'ke2' => $parameter['ke2'] ?? null,
                        'avg' => $parameter['avg'] ?? null,
                        'custom_input' => $parameter['custom_input'] ?? null,
                    ];
                }
            }

            // Simpan semua data parameter ke dalam field JSON (atau array jika pakai cast)
            $spk->parameters_data = $parametersData;
            $spk->save();

            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            // Tangani error tak terduga
            return response()->json([
                'status' => 'error',
                'message' => 'Unexpected error occurred!',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Form 5 save
    public function saveParameterDataModal5(Request $request)
    {
        try {
            // Ambil data dari request
            $spkId = $request->input('spkId');
            $testDate = $request->input('testDate');
            $qcStatus = $request->input('qcStatus');
            $formData = $request->input('formData');
            $keterangan = $request->input('keterangan');
    
            // Validasi awal: cek apakah formData adalah array
            if (!is_array($formData)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'formData harus berupa array!',
                    'debug_formData' => $formData
                ], 422);
            }
    
            // Cek SPK ada atau tidak
            $spk = Spk::find($spkId);
            if (!$spk) {
                return response()->json(['message' => 'SPK not found!'], 404);
            }
    
            // Update data utama SPK
            $spk->test_date = $testDate;
            $spk->qc_status = $qcStatus;
            $spk->status = "request to close";
            $spk->keterangan = $keterangan;
    
            $parametersData = [];
    
            // Proses setiap parameter
            foreach ($formData as $parameter) {
                $paramName = $parameter['parameter_name'] ?? null;
    
                if (!$paramName) {
                    continue;
                }
    
                // Proses data parameter sesuai kebutuhan
                $parametersData[] = [
                    'parameter_name' => $paramName,
                    'standard' => $parameter['standard'] ?? null,
                    'ke1' => $parameter['ke1'] ?? null,
                    'ke2' => $parameter['ke2'] ?? null,
                    'avg' => $parameter['avg'] ?? null,
                    'custom_input' => $parameter['custom_input'] ?? null,
                ];
            }
    
            // Simpan semua data parameter ke dalam field JSON (atau array jika pakai cast)
            $spk->parameters_data = $parametersData;
            $spk->save();
    
            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            // Tangani error tak terduga
            return response()->json([
                'status' => 'error',
                'message' => 'Unexpected error occurred!',
                'error' => $e->getMessage()
            ], 500);
        }
    } 

    // form 2 save
    public function saveParameterData2(Request $request)
    {
        $spkId = $request->input('spkId');
        $testDate = $request->input('testDate');
        $qcStatus = $request->input('qcStatus');
        $formData = $request->input('formData');

        $spk = Spk::find($spkId);

        if (!$spk) {
            return response()->json(['message' => 'SPK not found!'], 404);
        }

        $spk->test_date = $testDate;
        $spk->qc_status = $qcStatus;
        $spk->status = "request to close";

        $parametersData = [];

        foreach ($formData as $parameter) {
            // === Tambahan Validasi untuk Appearance ===
            if ($parameter['parameter_name'] === "Appearance") {
                if (empty($parameter['custom_input'])) {
                    return response()->json([
                        'status' => 'error',
                        'message' => "Input untuk parameter 'Appearance' wajib diisi."
                    ], 422);
                }

                $parametersData[] = [
                    'parameter_name' => $parameter['parameter_name'],
                    'standard' => $parameter['standard'] ?? null,
                    'ke1' => null,
                    'ke2' => null,
                    'avg' => null,
                    'custom_input' => $parameter['custom_input'],
                ];
            }
            // === Jika parameter Solution PH(%) tetap disimpan ===
            elseif ($parameter['parameter_name'] === "Solution PH(%)") {
                $parametersData[] = [
                    'parameter_name' => $parameter['parameter_name'],
                    'standard' => $parameter['standard'] ?? null,
                    'ke1' => $parameter['ke1'] ?? null,
                    'ke2' => $parameter['ke2'] ?? null,
                    'avg' => $parameter['avg'] ?? null,
                    'custom_input' => $parameter['custom_input'] ?? null,
                ];
            }
            // === Untuk parameter lain ===
            elseif (!empty($parameter['ke1']) || !empty($parameter['ke2']) || !empty($parameter['avg'])) {
                $parametersData[] = [
                    'parameter_name' => $parameter['parameter_name'],
                    'standard' => $parameter['standard'] ?? null,
                    'ke1' => $parameter['ke1'] ?? null,
                    'ke2' => $parameter['ke2'] ?? null,
                    'avg' => $parameter['avg'] ?? null,
                    'custom_input' => $parameter['custom_input'] ?? null,
                ];
            }
        }
        $spk->keterangan = $request->keterangan;
        $spk->parameters_data = $parametersData;
        $spk->save();

        return response()->json(['status' => 'success']);
    }

    
    // form 1 save
    public function saveParameterData1(Request $request)
    {
        // Ambil data form dari request
        $spkId = $request->input('spkId');
        $testDate = $request->input('testDate');
        $qcStatus = $request->input('qcStatus');
        $formData = $request->input('formData');  // Data parameter

        // Cari SPK berdasarkan ID
        $spk = Spk::find($spkId);

        if (!$spk) {
            return response()->json(['message' => 'SPK not found!'], 404);
        }

        // Update data SPK
        $spk->test_date = $testDate;
        $spk->qc_status = $qcStatus;
        // Menambahkan status "request to close"
        $spk->status = "request to close";

        // Validasi dan persiapkan data untuk disimpan
        $parametersData = [];

        foreach ($formData as $parameter) {
            // Periksa apakah parameter "Appearance" atau "Solution PH(%)"
            if ($parameter['parameter_name'] === "Appearance") {
                if (empty($parameter['custom_input'])) {
                    return response()->json([
                        'status' => 'error',
                        'message' => "Input untuk parameter 'Appearance' wajib diisi."
                    ], 422);
                }
            
                $parametersData[] = [
                    'parameter_name' => $parameter['parameter_name'],
                    'standard' => $parameter['standard'] ?? null,
                    'ke1' => null,
                    'ke2' => null,
                    'avg' => null,
                    'custom_input' => $parameter['custom_input'],
                ];
            } elseif ($parameter['parameter_name'] === "Solution PH(%)") {
                $parametersData[] = [
                    'parameter_name' => $parameter['parameter_name'],
                    'standard' => $parameter['standard'] ?? null,
                    'ke1' => null,
                    'ke2' => null,
                    'avg' => null,
                    'custom_input' => $parameter['custom_input'] ?? null,
                ];
            } elseif (!empty($parameter['ke1']) || !empty($parameter['ke2']) || !empty($parameter['avg'])) {
                // Tambahkan parameter lainnya yang valid
                $parametersData[] = [
                    'parameter_name' => $parameter['parameter_name'],
                    'standard' => $parameter['standard'] ?? null,
                    'ke1' => $parameter['ke1'] ?? null,
                    'ke2' => $parameter['ke2'] ?? null,
                    'avg' => $parameter['avg'] ?? null,
                    'custom_input' => $parameter['custom_input'] ?? null,
                ];
            }
        }

        $spk->keterangan = $request->keterangan;
        // Update field parameters_data dengan array yang lebih terstruktur
        $spk->parameters_data = $parametersData;

        // Simpan ke database
        $spk->save();

        // Mengembalikan response sukses
        return response()->json(['status' => 'success']);
    }


    
    

 
}
