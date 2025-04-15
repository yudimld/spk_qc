<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Specialty;

class SpecialtyController extends Controller
{
    public function index()
    {
        return view('masterdata.specialty');
    }

    public function getSpecialties()
    {
        $specialties = Specialty::all()->map(function ($specialty) {
            return [
                'id' => $specialty->id,
                'product_name' => $specialty->product_name,
                'appearance' => $specialty->appearance,
                'solution' => $specialty->solution,
                'ph_value' => "{$specialty->ph_value_min} - {$specialty->ph_value_max}",
                'sg' => "{$specialty->sg_min} - {$specialty->sg_max}",
                'sg_01' => "{$specialty->sg_01_min} - {$specialty->sg_01_max}",
                'specific_gravity' => "{$specialty->specific_gravity_min} - {$specialty->specific_gravity_max}",
                'specific_gravity_01' => "{$specialty->specific_gravity_01_min} - {$specialty->specific_gravity_01_max}",
                'viscosity' => "{$specialty->viscosity_min} - {$specialty->viscosity_max}",
                'viscosity_01' => "{$specialty->viscosity_01_min} - {$specialty->viscosity_01_max}",
                'dry_weight' => $specialty->dry_weight,
                'purity' => "{$specialty->purity_min} - {$specialty->purity_max}",
                'moisture_water' => "{$specialty->moisture_water_min} - {$specialty->moisture_water_max}",
                'residue_on_ignition' => "{$specialty->residue_on_ignition_min} - {$specialty->residue_on_ignition_max}",
                'solid_content' => "{$specialty->solid_content_min} - {$specialty->solid_content_max}",
                'shelf_life' => $specialty->shelf_life,
                'keterangan' => $specialty->keterangan
            ];
        });
      
        return response()->json(['data' => $specialties]);
    }
    

    // Menyimpan data dari form
    // public function store(Request $request)
    // {
        
    //     $validated = $request->validate([
    //         'product_name' => 'required|string',
    //         'appearance' => 'nullable|string',
    //         'solution' => 'nullable|numeric',
    //         'ph_value_min' => 'nullable|numeric',
    //         'ph_value_max' => 'nullable|numeric',
    //         'sg_min' => 'nullable|numeric',
    //         'sg_max'=> 'nullable|numeric',
    //         'sg_01_min' => 'nullable|numeric',
    //         'sg_01_max' => 'nullable|numeric',
    //         'specific_gravity_min' => 'nullable|numeric',
    //         'specific_gravity_max' => 'nullable|numeric',
    //         'specific_gravity_01_min' => 'nullable|numeric',
    //         'specific_gravity_01_max' => 'nullable|numeric',
    //         'viscosity_min' => 'nullable|numeric',
    //         'viscosity_max' => 'nullable|numeric',
    //         'viscosity_01_min' => 'nullable|numeric',
    //         'viscosity_01_max' => 'nullable|numeric',
    //         'dry_weight' => 'nullable|numeric',
    //         'purity_min' => 'nullable|numeric',
    //         'purity_max' => 'nullable|numeric',
    //         'moisture_water_min' => 'nullable|numeric',
    //         'moisture_water_max' => 'nullable|numeric',
    //         'residue_on_ignition_min' => 'nullable|numeric',
    //         'residue_on_ignition_max' => 'nullable|numeric',
    //         'solid_content_min' => 'nullable|numeric',
    //         'solid_content_max' => 'nullable|numeric',
    //         'shelf_life' => 'nullable|string',
    //         'keterangan' => 'nullable|string',
    //     ]);

    //     Specialty::create($validated);

    //     return redirect()->route('master_data_specialty')->with('success', 'Data berhasil ditambahkan');
    // }
    public function store(Request $request)
    {
        // Menghilangkan spasi dari nama produk
        $productName = str_replace(' ', '', $request->product_name);
    
        // Periksa apakah produk dengan nama tersebut sudah ada di MongoDB
        $existingProduct = Specialty::where('product_name', $productName)->first();
    
        if ($existingProduct) {
            return redirect()->back()->with('error', 'Product name already exists. Please provide a unique name.');
        }
    
        try {
            // Validasi input
            $validated = $request->validate([
                'product_name' => 'required|string',
                'appearance' => 'nullable|string',
                'solution' => 'nullable|numeric',
                'ph_value_min' => 'nullable|numeric',
                'ph_value_max' => 'nullable|numeric',
                'sg_min' => 'nullable|numeric',
                'sg_max'=> 'nullable|numeric',
                'sg_01_min' => 'nullable|numeric',
                'sg_01_max' => 'nullable|numeric',
                'specific_gravity_min' => 'nullable|numeric',
                'specific_gravity_max' => 'nullable|numeric',
                'specific_gravity_01_min' => 'nullable|numeric',
                'specific_gravity_01_max' => 'nullable|numeric',
                'viscosity_min' => 'nullable|numeric',
                'viscosity_max' => 'nullable|numeric',
                'viscosity_01_min' => 'nullable|numeric',
                'viscosity_01_max' => 'nullable|numeric',
                'dry_weight' => 'nullable|numeric',
                'purity_min' => 'nullable|numeric',
                'purity_max' => 'nullable|numeric',
                'moisture_water_min' => 'nullable|numeric',
                'moisture_water_max' => 'nullable|numeric',
                'residue_on_ignition_min' => 'nullable|numeric',
                'residue_on_ignition_max' => 'nullable|numeric',
                'solid_content_min' => 'nullable|numeric',
                'solid_content_max' => 'nullable|numeric',
                'shelf_life' => 'nullable|string',
                'keterangan' => 'nullable|string',
            ]);
    
            // Simpan data baru
            Specialty::create($validated);
    
            return redirect()->route('master_data_specialty')->with('success', 'Data berhasil ditambahkan');
        } catch (\MongoDB\Driver\Exception\BulkWriteException $e) {
            // Tangani error duplicate key di MongoDB
            return redirect()->back()->with('error', 'Product name already exists. Please provide a unique name.');
        }
    }
    

    // Di controller, buat fungsi untuk memeriksa duplikat nama produk
    public function checkProductName(Request $request)
    {
        // Menghilangkan spasi dari nama produk
        $productName = str_replace(' ', '', $request->product_name);
    
        // Mengecek apakah produk dengan nama yang sudah diproses (tanpa spasi) sudah ada di database
        $existingProduct = Specialty::where('product_name', $productName)->exists();
    
        // Mengembalikan respons JSON
        return response()->json(['exists' => $existingProduct]);
    }
    
    

    
    
    public function destroy($id)
    {
        // Cari specialty berdasarkan ID
        $specialty = Specialty::find($id);
        
        // Jika specialty tidak ditemukan
        if (!$specialty) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        // Hapus data
        $specialty->delete();

        // Mengembalikan response sukses
        return response()->json(['message' => 'Data berhasil dihapus'], 200);
    }

    // edit
    // Mendapatkan data specialty berdasarkan ID
    public function getSpecialty($id)
    {
        $specialty = Specialty::find($id);

        if ($specialty) {
            return response()->json(['data' => $specialty]);
        } else {
            return response()->json(['message' => 'Data not found'], 404);
        }
    }

    // Mengupdate data specialty berdasarkan ID
    public function updateSpecialty(Request $request, $id)
    {
        // Validasi data
        $validated = $request->validate([
            'product_name' => 'required|string',
            'appearance' => 'nullable|string',
            'solution' => 'nullable|string',
            'ph_value_min' => 'nullable|numeric',
            'ph_value_max' => 'nullable|numeric',
            'sg_min' => 'nullable|numeric',
            'sg_max'=> 'nullable|numeric',
            'sg_01_min' => 'nullable|numeric',
            'sg_01_max' => 'nullable|numeric',
            'specific_gravity_min' => 'nullable|numeric',
            'specific_gravity_max' => 'nullable|numeric',
            'specific_gravity_01_min' => 'nullable|numeric',
            'specific_gravity_01_max' => 'nullable|numeric',
            'viscosity_min' => 'nullable|numeric',
            'viscosity_max' => 'nullable|numeric',
            'viscosity_01_min' => 'nullable|numeric',
            'viscosity_01_max' => 'nullable|numeric',
            'dry_weight' => 'nullable|numeric',
            'purity_min' => 'nullable|numeric',
            'purity_max' => 'nullable|numeric',
            'moisture_water_min' => 'nullable|numeric',
            'moisture_water_max' => 'nullable|numeric',
            'residue_on_ignition_min' => 'nullable|numeric',
            'residue_on_ignition_max' => 'nullable|numeric',
            'solid_content_min' => 'nullable|numeric',
            'solid_content_max' => 'nullable|numeric',
            'shelf_life' => 'nullable|string',
            'keterangan' => 'nullable|string',
        ]);

        // Cari specialty berdasarkan ID
        $specialty = Specialty::find($id);

        if ($specialty) {
            // Update data specialty
            $specialty->update($validated);

            return response()->json(['message' => 'Data Specialty berhasil diperbarui!'], 200);
        } else {
            return response()->json(['message' => 'Data Specialty tidak ditemukan'], 404);
        }
    }
}
