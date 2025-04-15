<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Spk;

class DashboardController extends Controller
{
    public function index()
    {
        // Hitung jumlah SPK berdasarkan status
        $reAssignedCount = Spk::where('status', 're-assigned')->count();
        $assignedCount = Spk::where('status', 'assigned')->count();
        $openCount = Spk::where('status', 'open')->count();
        $closedCount = Spk::where('status', 'closed')->count();
        $readyCount = Spk::where('status', 'ready')->count();
        $requestToClosedCount = Spk::where('status', 'request to close')->count();
    
        // Mengirimkan semua variabel ke view dalam bentuk array
        return view('dashboard.index', compact('reAssignedCount', 'assignedCount', 'openCount', 'closedCount', 'readyCount', 'requestToClosedCount'));
    }
}
