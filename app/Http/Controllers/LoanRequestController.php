<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\LoanRequest;
use Illuminate\Http\Request;

class LoanRequestController extends Controller
{
    public function index()
    {
        $loanRequests = LoanRequest::with('inventory')->latest()->get();
        $inventories = Inventory::orderBy('name')->get();

        return view('admin.loan-requests.index', compact('loanRequests', 'inventories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'borrower_name' => 'required|string|max:255',
            'organization' => 'nullable|string|max:255',
            'inventory_id' => 'required|exists:inventories,id',
            'duration_days' => 'required|integer|min:1',
            'surat_link' => 'nullable|url|max:255',
        ], [
            'surat_link.url' => 'Link surat harus berupa URL yang valid.',
        ]);

        LoanRequest::create($validated);

        return redirect()
            ->route('loan-requests.index')
            ->with('success', 'Permintaan peminjaman berhasil ditambahkan.');
    }

    public function approve(LoanRequest $loanRequest)
    {
        $loanRequest->update([
            'status' => 'approved',
        ]);

        return redirect()
            ->route('loan-requests.index')
            ->with('success', 'Permintaan peminjaman berhasil disetujui.');
    }

    public function reject(LoanRequest $loanRequest)
    {
        $loanRequest->update([
            'status' => 'rejected',
        ]);

        return redirect()
            ->route('loan-requests.index')
            ->with('success', 'Permintaan peminjaman berhasil ditolak.');
    }
}