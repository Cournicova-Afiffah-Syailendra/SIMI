<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\LoanRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AjukanController extends Controller
{
    public function index()
    {
        $inventories = Inventory::where('total_stock', '>', 0)->orderBy('name')->get();
        $user = Auth::user();
        $myLoans = LoanRequest::with('inventory')
            ->where('borrower_name', $user->name)
            ->latest()
            ->get();

        return view('user.ajukan', compact('inventories', 'myLoans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'inventory_id'  => 'required|exists:inventories,id',
            'duration_days' => 'required|integer|min:1',
            'surat_link'    => 'nullable|url|max:255',
        ]);

        $user = Auth::user();

        LoanRequest::create([
            'borrower_name'  => $user->name,
            'organization'   => $user->organization ?? '-',
            'inventory_id'   => $request->inventory_id,
            'duration_days'  => $request->duration_days,
            'surat_link'     => $request->surat_link,
            'status'         => 'pending',
        ]);

        return redirect()->route('user.ajukan')->with('success', 'Permintaan peminjaman berhasil diajukan.');
    }
}
