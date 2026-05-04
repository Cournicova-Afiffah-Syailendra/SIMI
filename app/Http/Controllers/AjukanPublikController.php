<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\LoanRequest;
use Illuminate\Http\Request;

class AjukanPublikController extends Controller
{
    /**
     * Tampilkan form ajukan peminjaman (publik, tanpa login)
     */
    public function index()
    {
        $inventories = Inventory::where('total_stock', '>', 0)
            ->orderBy('name')
            ->get();

        return view('publik.ajukan', compact('inventories'));
    }

    /**
     * Simpan pengajuan peminjaman
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'borrower_name'  => 'required|string|max:255',
            'organization'   => 'required|string|max:255',
            'inventory_id'   => 'required|exists:inventories,id',
            'duration_days'  => 'required|integer|min:1',
            'surat_link'     => 'nullable|url|max:500',
        ], [
            'borrower_name.required'  => 'Nama lengkap wajib diisi.',
            'organization.required'   => 'Asal instansi/organisasi wajib diisi.',
            'inventory_id.required'   => 'Pilih inventaris terlebih dahulu.',
            'inventory_id.exists'     => 'Inventaris tidak ditemukan.',
            'duration_days.required'  => 'Durasi pinjam wajib diisi.',
            'duration_days.min'       => 'Durasi minimal 1 hari.',
            'surat_link.url'          => 'Link surat harus berupa URL yang valid (https://...).',
        ]);

        // Simpan ke database
        LoanRequest::create([
            'borrower_name' => $validated['borrower_name'],
            'organization'  => $validated['organization'],
            'inventory_id'  => $validated['inventory_id'],
            'duration_days' => $validated['duration_days'],
            'surat_link'    => $validated['surat_link'] ?? null,
            'status'        => 'pending',
        ]);

        return back()->with('success',
            'Permintaan peminjaman berhasil diajukan! Admin akan menghubungi Anda segera.'
        );
    }
}
