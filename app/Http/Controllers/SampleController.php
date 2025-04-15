<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Spk;
use Illuminate\Support\Facades\Auth;

class SampleController extends Controller
{
    // Menampilkan halaman Status Sample dengan data
    public function statusSample()
    {
        // Ambil semua data SPK dengan status 'open' dan urutkan berdasarkan created_at secara descending
        $spks = Spk::where('status', 'open')->orderBy('created_at', 'desc')->get();
    
        // Ambil semua data SPK dengan status 'ready' dan urutkan berdasarkan created_at secara descending
        $spkr = Spk::where('status', 'ready')->orderBy('created_at', 'desc')->get();
    
        // Kirim data SPK ke view
        return view('sample.status_sample', compact('spks', 'spkr'));
    }

    public function showDetail($id)
    {
        $spk = Spk::findOrFail($id);  // Ambil data SPK berdasarkan ID
        return response()->json($spk);  // Kembalikan data dalam format JSON
    }

    public function updateStatusReady(Request $request, $id)
    {
        $spk = Spk::findOrFail($id); // Ambil data SPK berdasarkan ID
        $spk->update([
            'status' => 'ready', // Update status menjadi ready
            'lokasi' => $request->lokasi, // Update lokasi penyimpanan
            'keterangan_lokasi' => $request->keterangan, // Update keterangan
            'by' => $request->by // Menyimpan data by (NUP)
        ]);

        return response()->json(['message' => 'Data berhasil diperbarui ke status ready']);
    }

    public function updateStatusAssigned(Request $request, $id)
    {
        // Cari data SPK berdasarkan ID
        $spk = Spk::findOrFail($id);
    
        // Pastikan status SPK adalah 'open', baru bisa diubah ke 'assigned'
        if ($spk->status == 'open') {
            // Update status menjadi 'assigned'
            $spk->status = 'assigned';
    
            // Menambahkan user yang meng-assign (menggunakan Auth untuk mendapatkan ID user yang login)
            $spk->assign_by = Auth::user()->nup;  // Menyimpan ID NUP user yang meng-assign
    
            // Mengupdate data lokasi dan keterangan sesuai form
            $spk->lokasi = $request->lokasi;
            $spk->keterangan_lokasi = $request->keterangan;
    
            // Simpan perubahan ke database
            $spk->save();  
    
            // Mengembalikan response sukses
            return response()->json(['message' => 'Task has been successfully assigned!']);
        }
    
        // Jika status bukan 'open', tampilkan pesan error
        return response()->json(['message' => 'Task is not open for assignment.'], 400);
    }

    // Fungsi untuk mengubah status menjadi assigned
    public function updateStatusReadyToAssigned($id)
    {
        // Cari data SPK berdasarkan ID
        $spk = Spk::findOrFail($id);

        // Pastikan status SPK adalah 'ready', baru bisa diubah ke 'assigned'
        if ($spk->status == 'ready') {
            // Update status menjadi 'assigned'
            $spk->status = 'assigned';

            // Menambahkan user yang meng-assign (menggunakan Auth untuk mendapatkan ID user yang login)
            $spk->assign_by = Auth::user()->nup;  // Menyimpan ID NUP user yang meng-assign

            $spk->save();  // Menyimpan perubahan status dan user yang meng-assign

            // Mengembalikan response sukses
            return response()->json(['message' => 'Task has been successfully assigned!']);
        }

        // Jika status bukan 'ready', tampilkan pesan error
        return response()->json(['message' => 'Task is not ready for assignment.'], 400);
    }

}
