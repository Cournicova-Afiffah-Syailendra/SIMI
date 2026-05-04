<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\LoanRequest;
use Illuminate\Support\Facades\Auth;

class RiwayatController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $riwayat = LoanRequest::with(['inventory', 'returnItem'])
            ->where('borrower_name', $user->name)
            ->latest()
            ->get();

        return view('user.riwayat', compact('riwayat'));
    }
}
