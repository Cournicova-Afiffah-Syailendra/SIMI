<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventory;
use App\Models\LoanRequest;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // ── Stats Cards ──────────────────────────────────────────────
        $totalBarang        = Inventory::count();
        $barangTersedia     = Inventory::where('status', 'available')->count();
        $barangDipinjam     = LoanRequest::where('status', 'approved')->count();
        $menungguPersetujuan = LoanRequest::where('status', 'pending')->count();

        // ── Aktivitas Terbaru (5 peminjaman terbaru) ─────────────────
        $recentLoans = LoanRequest::with(['user', 'inventory'])
            ->latest()
            ->take(5)
            ->get();

        // ── Chart: 6 bulan terakhir ───────────────────────────────────
        $chartLabels      = [];
        $chartPeminjaman  = [];
        $chartPengembalian = [];

        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);

            $chartLabels[] = $month->translatedFormat('M'); // Jan, Feb, dst.

            $chartPeminjaman[] = LoanRequest::whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count();

            $chartPengembalian[] = LoanRequest::whereYear('updated_at', $month->year)
                ->whereMonth('updated_at', $month->month)
                ->where('status', 'returned')
                ->count();
        }

        return view('dashboard', compact(
            'totalBarang',
            'barangTersedia',
            'barangDipinjam',
            'menungguPersetujuan',
            'recentLoans',
            'chartLabels',
            'chartPeminjaman',
            'chartPengembalian',
        ));
    }
}
