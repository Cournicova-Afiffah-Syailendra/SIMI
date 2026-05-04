<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\LoanRequest;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $peminjamAktif = LoanRequest::where('borrower_name', $user->name)
            ->where('status', 'approved')
            ->count();

        $totalPeminjaman = LoanRequest::where('borrower_name', $user->name)->count();

        $selesai = LoanRequest::where('borrower_name', $user->name)
            ->whereHas('returnItem', function($q) {
                $q->where('status', 'sudah');
            })->count();

        $menunggu = LoanRequest::where('borrower_name', $user->name)
            ->where('status', 'pending')
            ->count();

        $peminjamAktifList = LoanRequest::with('inventory')
            ->where('borrower_name', $user->name)
            ->whereIn('status', ['approved', 'pending'])
            ->latest()
            ->take(5)
            ->get();

        $inventarisPopuler = Inventory::where('total_stock', '>', 0)
            ->latest()
            ->take(4)
            ->get();

        return view('user.dashboard', compact(
            'peminjamAktif',
            'totalPeminjaman',
            'selesai',
            'menunggu',
            'peminjamAktifList',
            'inventarisPopuler'
        ));
    }
}
