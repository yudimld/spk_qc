<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pac;

class MasterDataPacController extends Controller
{
    // Untuk menampilkan halaman view
    public function index()
    {
        return view('masterdata.pac'); 
    }

    public function getPacData()
    {
        $pacData = Pac::all()->map(function ($pac) {
            return [
                'id' => $pac->id,
                'product_name' => $pac->product_name,
                'appearance' => $pac->appearance,
                'ai2o3' => "{$pac->ai2o3_min} - {$pac->ai2o3_max}",
                'basicity' => "{$pac->basicity_min} - {$pac->basicity_max}",
                'ph_1_solution' => "{$pac->ph_1_solution_min} - {$pac->ph_1_solution_max}",
                'specific_gravity' => "{$pac->specific_gravity_min} - {$pac->specific_gravity_max}",
                'turbidity' => "{$pac->turbidity_min} - {$pac->turbidity_max}",
                'fe' => "{$pac->fe_min} - {$pac->fe_max}",
                'moisture' => "{$pac->moisture_min} - {$pac->moisture_max}",
                'cl' => "{$pac->cl_min} - {$pac->cl_max}",
                'so4' => "{$pac->so4_min} - {$pac->so4_max}",
                'shelf_life' => $pac->shelf_life,
                'kadar' => "{$pac->kadar_min} - {$pac->kadar_max}",
                'ph_pure' => "{$pac->ph_pure_min} - {$pac->ph_pure_max}",
                'kelarutan_hcl' => $pac->kelarutan_hcl,
            ];
        });
    
        return response()->json(['data' => $pacData]);
    }

    // public function store(Request $request)
    // {
    //     // Menghilangkan spasi untuk pengecekan duplikasi
    //     $productName = str_replace(' ', '', $request->product_name);
    
    //     // Validasi input
    //     $validated = $request->validate([
    //         'product_name' => 'required|string|max:255',
    //         'appearance' => 'nullable|string|max:255',
    //         'ai2o3_min' => 'nullable|numeric|min:0|max:100',
    //         'ai2o3_max' => 'nullable|numeric|min:0|max:100',
    //         'basicity_min' => 'nullable|numeric|min:0|max:100',
    //         'basicity_max' => 'nullable|numeric|min:0|max:100',
    //         'ph_1_solution_min' => 'nullable|numeric|min:0|max:14',
    //         'ph_1_solution_max' => 'nullable|numeric|min:0|max:14',
    //         'specific_gravity_min' => 'nullable|numeric|min:0|max:100',
    //         'specific_gravity_max' => 'nullable|numeric|min:0|max:100',
    //         'turbidity_min' => 'nullable|numeric|min:0',
    //         'turbidity_max' => 'nullable|numeric|min:0',
    //         'fe_min' => 'nullable|numeric|min:0',
    //         'fe_max' => 'nullable|numeric|min:0',
    //         'moisture_min' => 'nullable|numeric|min:0|max:100',
    //         'moisture_max' => 'nullable|numeric|min:0|max:100',
    //         'cl_min' => 'nullable|numeric|min:0|max:100',
    //         'cl_max' => 'nullable|numeric|min:0|max:100',
    //         'so4_min' => 'nullable|numeric|min:0|max:100',
    //         'so4_max' => 'nullable|numeric|min:0|max:100',
    //         'shelf_life' => 'nullable|string|max:255',
    //         'kadar_min' => 'nullable|numeric|min:0|max:100',
    //         'kadar_max' => 'nullable|numeric|min:0|max:100',
    //         'ph_pure_min' => 'nullable|numeric|min:0|max:14',
    //         'ph_pure_max' => 'nullable|numeric|min:0|max:14',
    //         'kelarutan_hcl' => 'nullable|string|max:255'
    //     ]);
    
    //     // Cek apakah product_name sudah ada di database
    //     $existingProduct = Pac::where('product_name', $productName)->first();

    //     if ($existingProduct) {
    //         // Jika ada produk dengan nama yang sama, kembalikan error
    //         return redirect()->back()->with('error', 'Product name already exists. Please provide a unique name.');
    //     }
    
    //     // Simpan data baru jika tidak ada duplikat
    //     Pac::create($validated);
    
    //     // Kembali dengan pesan sukses ke route yang benar (master_data_pac)
    //     return redirect()->route('master_data_pac')->with('success', 'Data PAC berhasil ditambahkan!');
    // }
    public function store(Request $request)
    {
        // Menghilangkan spasi untuk pengecekan duplikasi
        $productName = str_replace(' ', '', $request->product_name);
    
        // Validasi input
        $validated = $request->validate([
            'product_name' => 'required|string|max:255',
            'appearance' => 'nullable|string|max:255',
            'ai2o3_min' => 'nullable|numeric|min:0|max:100',
            'ai2o3_max' => 'nullable|numeric|min:0|max:100',
            'basicity_min' => 'nullable|numeric|min:0|max:100',
            'basicity_max' => 'nullable|numeric|min:0|max:100',
            'ph_1_solution_min' => 'nullable|numeric|min:0|max:14',
            'ph_1_solution_max' => 'nullable|numeric|min:0|max:14',
            'specific_gravity_min' => 'nullable|numeric|min:0|max:100',
            'specific_gravity_max' => 'nullable|numeric|min:0|max:100',
            'turbidity_min' => 'nullable|numeric|min:0',
            'turbidity_max' => 'nullable|numeric|min:0',
            'fe_min' => 'nullable|numeric|min:0',
            'fe_max' => 'nullable|numeric|min:0',
            'moisture_min' => 'nullable|numeric|min:0|max:100',
            'moisture_max' => 'nullable|numeric|min:0|max:100',
            'cl_min' => 'nullable|numeric|min:0|max:100',
            'cl_max' => 'nullable|numeric|min:0|max:100',
            'so4_min' => 'nullable|numeric|min:0|max:100',
            'so4_max' => 'nullable|numeric|min:0|max:100',
            'shelf_life' => 'nullable|string|max:255',
            'kadar_min' => 'nullable|numeric|min:0|max:100',
            'kadar_max' => 'nullable|numeric|min:0|max:100',
            'ph_pure_min' => 'nullable|numeric|min:0|max:14',
            'ph_pure_max' => 'nullable|numeric|min:0|max:14',
            'kelarutan_hcl' => 'nullable|string|max:255'
        ]);
    
        try {
            // Cek apakah product_name sudah ada di database
            $existingProduct = Pac::where('product_name', $productName)->first();
    
            if ($existingProduct) {
                // Jika ada produk dengan nama yang sama, kembalikan error
                return response()->json(['error' => 'Product name already exists. Please provide a unique name.'], 400);
            }
    
            // Simpan data baru jika tidak ada duplikat
            Pac::create($validated);
    
            // Kembali dengan pesan sukses
            return response()->json(['success' => 'Data PAC berhasil ditambahkan!'], 200);
        } catch (\MongoDB\Driver\Exception\BulkWriteException $e) {
            // Tangani MongoDB duplicate key error
            return response()->json(['error' => 'Product name already exists. Please provide a unique name.'], 400);
        } catch (\Exception $e) {
            // Tangani error lainnya
            return response()->json(['error' => 'An unexpected error occurred. Please try again.'], 500);
        }
    }
    

    public function checkProductName(Request $request)
    {
        try {
            // Menghilangkan spasi dari nama produk
            $productName = str_replace(' ', '', $request->product_name);

            // Cek apakah produk sudah ada di database
            $existingProduct = Pac::where('product_name', $productName)->first();

            // Mengembalikan response JSON
            return response()->json(['exists' => $existingProduct ? true : false]);

        } catch (\Exception $e) {
            // Tangani error jika terjadi
            return response()->json(['error' => 'There was an error checking the product name. Please try again.'], 500);
        }
    }

    

    // GET Data PAC untuk ditampilkan di modal edit
    public function edit($id)
    {
        $pac = Pac::findOrFail($id);
        return response()->json($pac);
    }

    // UPDATE Data PAC
    public function update(Request $request, $id)
    {
        $request->validate([
            'product_name' => 'required|string|max:255',
            'appearance' => 'nullable|string',
            'ai2o3_min' => 'nullable|numeric',
            'ai2o3_max' => 'nullable|numeric',
            'basicity_min' => 'nullable|numeric',
            'basicity_max' => 'nullable|numeric',
            'ph_1_solution_min' => 'nullable|numeric',
            'ph_1_solution_max' => 'nullable|numeric',
            'specific_gravity_min' => 'nullable|numeric',
            'specific_gravity_max' => 'nullable|numeric',
            'turbidity_min' => 'nullable|numeric',
            'turbidity_max' => 'nullable|numeric',
            'fe_min' => 'nullable|numeric',
            'fe_max' => 'nullable|numeric',
            'moisture_min' => 'nullable|numeric',
            'moisture_max' => 'nullable|numeric',
            'cl_min' => 'nullable|numeric',
            'cl_max' => 'nullable|numeric',
            'so4_min' => 'nullable|numeric',
            'so4_max' => 'nullable|numeric',
            'shelf_life' => 'nullable|string',
            'kadar_min' => 'nullable|numeric',
            'kadar_max' => 'nullable|numeric',
            'ph_pure_min' => 'nullable|numeric',
            'ph_pure_max' => 'nullable|numeric',
            'kelarutan_hcl' => 'nullable|string',
        ]);
    
        // Temukan data berdasarkan ID
        $pac = Pac::findOrFail($id);
    
        // Update semua field
        $pac->update([
            'product_name' => $request->product_name,
            'appearance' => $request->appearance,
            'ai2o3_min' => $request->ai2o3_min,
            'ai2o3_max' => $request->ai2o3_max,
            'basicity_min' => $request->basicity_min,
            'basicity_max' => $request->basicity_max,
            'ph_1_solution_min' => $request->ph_1_solution_min,
            'ph_1_solution_max' => $request->ph_1_solution_max,
            'specific_gravity_min' => $request->specific_gravity_min,
            'specific_gravity_max' => $request->specific_gravity_max,
            'turbidity_min' => $request->turbidity_min,
            'turbidity_max' => $request->turbidity_max,
            'fe_min' => $request->fe_min,
            'fe_max' => $request->fe_max,
            'moisture_min' => $request->moisture_min,
            'moisture_max' => $request->moisture_max,
            'cl_min' => $request->cl_min,
            'cl_max' => $request->cl_max,
            'so4_min' => $request->so4_min,
            'so4_max' => $request->so4_max,
            'shelf_life' => $request->shelf_life,
            'kadar_min' => $request->kadar_min,
            'kadar_max' => $request->kadar_max,
            'ph_pure_min' => $request->ph_pure_min,
            'ph_pure_max' => $request->ph_pure_max,
            'kelarutan_hcl' => $request->kelarutan_hcl,
        ]);
    
        // Beri respon sukses
        return response()->json(['message' => 'Data PAC berhasil diperbarui!']);
    }

    public function destroy($id)
    {
        $pac = Pac::findOrFail($id);
        $pac->delete();

        return response()->json(['message' => 'Data PAC berhasil dihapus!']);
    }


}
