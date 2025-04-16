<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Spk;
use Mpdf\Mpdf;
use App\Models\Pac;
use App\Models\User;
use App\Models\Specialty;
use Carbon\Carbon;
use MongoDB\BSON\ObjectId;
use Illuminate\Support\Facades\Log;


class ListSpkController extends Controller
{
    // public function index()
    // {
    //     // Ambil semua data SPK tanpa filter status
    //     $spks = Spk::orderBy('created_at', 'desc')->get();  // Ambil semua data SPK untuk diproses
        
    
    //     // Ambil ID pengguna (created_by) yang ada di SPK untuk pencarian di User
    //     $userIds = $spks->pluck('created_by');  // Ambil semua created_by (nup) dari SPK
        
    //     // Ambil data User berdasarkan 'nup' dari PostgreSQL
    //     $users = User::whereIn('nup', $userIds)->get();  // Ambil semua user yang nup-nya ada di SPK
    
    //     // Gabungkan data SPK dengan data User berdasarkan 'created_by' (nup)
    //     $spks->each(function ($spk) use ($users) {
    //         // Menambahkan informasi department dari user ke dalam objek SPK
    //         $user = $users->firstWhere('nup', $spk->created_by);  // Cari user berdasarkan nup
    //         $spk->department = $user ? $user->department : null;  // Jika ada user, tambahkan department
    //     });
    
    //     // Kirim data SPK yang sudah digabungkan dengan data user ke view
    //     return view('list_spk.list', compact('spks'));
    // }

    public function index()
    {
        // Ambil semua data SPK tanpa filter status
        $spks = Spk::orderBy('created_at', 'desc')->get();  // Ambil semua data SPK untuk diproses

        // Ambil ID pengguna (created_by) yang ada di SPK untuk pencarian di User
        $userIds = $spks->pluck('created_by');  // Ambil semua created_by (nup) dari SPK

        // Ambil data User berdasarkan 'nup' dari PostgreSQL
        $users = User::whereIn('nup', $userIds)->get();  // Ambil semua user yang nup-nya ada di SPK

        // Cek user yang sedang login
        $loggedInUser = auth()->user();
        $excludedRoles = ['staff_qc', 'spv_qc', 'staff_edc', 'manager_edc', 'manager_qc', 'director', 'manager_produksi', 'manager_logistik', 'spv_produksi'];

        // Gabungkan data SPK dengan data User berdasarkan 'created_by' (nup)
        $spks->each(function ($spk) use ($users, $loggedInUser, $excludedRoles) {
            // Menambahkan informasi department dari user ke dalam objek SPK
            $user = $users->firstWhere('nup', $spk->created_by);  // Cari user berdasarkan nup
            $spk->department = $user ? $user->department : null;  // Jika ada user, tambahkan department

            // Hitung selisih waktu antara updated_at dan created_at
            $created = Carbon::parse($spk->created_at);
            $updated = Carbon::parse($spk->updated_at);
            $diff = $updated->diff($created);

            // Hitung selisih waktu antara penyerahan_sample dan test_date dengan pengecekan test_date
            if ($spk->test_date) {
                $created1 = Carbon::parse($spk->penyerahan_sample);
                $updated1 = Carbon::parse($spk->test_date);
                $diff1 = $updated1->diff($created1);

                // Format selisih waktu menjadi HH:MM:SS
                $spk->time_to_release = sprintf('%02d:%02d:%02d', $diff1->h, $diff1->i, $diff1->s);
            } else {
                // Jika test_date belum ada, set default 00:00:00
                $spk->time_to_release = '00:00:00';
            }

            // Format selisih waktu menjadi HH:MM:SS
            $spk->time_to_close = sprintf('%02d:%02d:%02d', $diff->h, $diff->i, $diff->s);
            // $spk->time_to_release = sprintf('%02d:%02d:%02d', $diff1->h, $diff1->i, $diff1->s);

            // Pengecualian untuk role tertentu
            if (!in_array($loggedInUser->role, $excludedRoles)) {
                // Hanya tampilkan SPK jika department sesuai dengan user yang login
                if ($spk->department !== $loggedInUser->department) {
                    $spk->hidden = true; // Menandai data ini agar tidak ditampilkan
                }
            }
        });

        // Filter data yang tidak memiliki status hidden
        $spks = $spks->where('hidden', '!=', true);

        // Kirim data SPK yang sudah digabungkan dengan data user ke view
        return view('list_spk.list', compact('spks'));
    }

    public function show($id)
    {
        $spk = Spk::findOrFail($id);  // Ambil data SPK berdasarkan ID
        return response()->json($spk);  // Kembalikan data dalam format JSON
    }

    public function update(Request $request, $id)
    {
        $spk = Spk::findOrFail($id);  // Ambil data SPK berdasarkan ID

        // Perbarui data SPK dengan input form, validasi bisa ditambahkan di sini
        $spk->update($request->all());

        return response()->json(['message' => 'Data berhasil diperbarui']);
    }

    // Method untuk menghapus data
    public function destroy($id)
    {
        try {
            $spk = SPK::findOrFail($id);
            $spk->delete();
    
            return response()->json(['message' => 'Data berhasil dihapus!'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan saat menghapus data.'], 500);
        }
    }

    // result test generated pdf
    public function generatePdf($id)
    {
        // Ambil data SPK berdasarkan ID
        $spk = Spk::find($id);
    
        if (!$spk) {
            return response()->json(['message' => 'SPK not found'], 404);
        }
    
        $spk->qc_status = trim($spk->qc_status);
    
        // Ambil parameter data
        $parametersData = is_string($spk->parameters_data) 
            ? json_decode($spk->parameters_data, true) 
            : $spk->parameters_data;
    
        // Cari shelf_life berdasarkan nama_material ke tabel Pac atau Specialty
        $pac = \App\Models\Pac::where('product_name', $spk->nama_material)->first();
        $specialty = \App\Models\Specialty::where('product_name', $spk->nama_material)->first();
    
        // Ambil shelf_life dalam bentuk integer (bulan)
        $shelfLife = $pac?->shelf_life ?? $specialty?->shelf_life ?? null;
        $shelfLife = $shelfLife ? (int) $shelfLife : null;
    
        // Hitung expiry date jika memungkinkan
        $expiryDate = null;
        if ($shelfLife && $spk->manufacture_date) {
            $expiryDate = \Carbon\Carbon::parse($spk->manufacture_date)->addMonths($shelfLife)->format('Y-m-d');
        }

        // Hitung expiry date berdasarkan tanggal_kedatangan
        $arrivalExpiryDate = null;
        if ($shelfLife && $spk->tanggal_kedatangan) {
            $arrivalExpiryDate = \Carbon\Carbon::parse($spk->tanggal_kedatangan)
                ->addMonths($shelfLife)
                ->format('Y-m-d');
        }
    
        // Kirim ke view PDF
        $pdfContent = view('pdf.spk', compact('spk', 'parametersData', 'expiryDate', 'arrivalExpiryDate'))->render();
    
        $mpdf = new \Mpdf\Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'orientation' => 'L'
        ]);
    
        $mpdf->WriteHTML($pdfContent);
        return $mpdf->Output($spk->no_ticket . '.pdf', 'I');
    }
    
    
    // Close SPK
    public function closeSpk($id)
    {
        try {
            Log::info("Received Close SPK request with ID: {$id}");
    
            // Cari SPK berdasarkan ID
            $spk = Spk::find($id);
        
            // Jika SPK tidak ditemukan
            if (!$spk) {
                return response()->json(['status' => 'error', 'message' => 'SPK tidak ditemukan!'], 404);
            }
        
            // Update status SPK menjadi 'closed'
            $spk->status = 'closed';
            $spk->save();
        
            // Kembalikan response sukses
            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            Log::error("Error closing SPK with ID: {$id} - {$e->getMessage()}");
            return response()->json(['status' => 'error', 'message' => 'Terjadi kesalahan di server.'], 500);
        }
    }

    // Reassign SPK
    public function reassignSpk(Request $request)
    {
        try {
            // Validasi data yang dikirimkan
            $request->validate([
                'spk_id' => 'required|regex:/^[0-9a-fA-F]{24}$/', // Validasi spk_id agar sesuai dengan format ObjectId MongoDB
                'reason' => 'required|string|max:255', // Pastikan alasan diisi
                'reassign_by' => 'required|string', // Pastikan reassign_by diisi
            ]);

            // Cari SPK berdasarkan ID menggunakan ObjectId
            $spk = Spk::find(new ObjectId($request->spk_id)); // Menggunakan ObjectId untuk MongoDB
            if (!$spk) {
                return response()->json(['message' => 'SPK not found!'], 404);
            }

            // Update status SPK menjadi 're-assigned' dan simpan siapa yang mengupdate (reassign_by)
            $spk->status = 're-assigned';
            $spk->reassign_by = $request->reassign_by; // Menggunakan reassign_by dari request
            $spk->reason = $request->reason; // Simpan alasan reassign
            $spk->save();

            // Mengembalikan response sukses
            return response()->json(['status' => 'success', 'message' => 'SPK has been successfully re-assigned.']);
        } catch (\Exception $e) {
            // Menangani kesalahan dan mencatatnya
            \Log::error('Error reassigning SPK:', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'An error occurred while processing your request.'], 500);
        }
    }



    


}
