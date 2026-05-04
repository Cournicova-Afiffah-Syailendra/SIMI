<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\LoanRequest;
use App\Services\GoogleDriveService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserLoanController extends Controller
{
    public function index()
    {
        $inventories = Inventory::where('total_stock', '>', 0)
            ->orderBy('name')
            ->get();

        $myLoans = LoanRequest::with('inventory')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('user.ajukan', compact('inventories', 'myLoans'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'inventory_id'   => 'required|exists:inventories,id',
            'duration_days'  => 'required|integer|min:1',
            'surat_link'     => 'nullable|url|max:500',
            'bukti_transfer' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'surat_file'     => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ], [
            'inventory_id.required'  => 'Pilih inventaris terlebih dahulu.',
            'duration_days.required' => 'Durasi pinjam wajib diisi.',
            'duration_days.min'      => 'Durasi minimal 1 hari.',
            'surat_link.url'         => 'Link surat harus berupa URL yang valid.',
            'bukti_transfer.mimes'   => 'Bukti transfer harus berupa file JPG, PNG, atau PDF.',
            'bukti_transfer.max'     => 'Ukuran file maksimal 5MB.',
            'surat_file.mimes'       => 'Surat peminjaman harus berupa file JPG, PNG, atau PDF.',
            'surat_file.max'         => 'Ukuran file maksimal 5MB.',
        ]);

        $buktiUrl = null;
        $suratUrl = null;

        // Upload ke Google Drive jika ada file
        try {
            $gdrive = new GoogleDriveService();

            if ($request->hasFile('bukti_transfer')) {
                $buktiUrl = $gdrive->upload(
                    $request->file('bukti_transfer'),
                    'SIMI/Bukti Transfer'
                );
            }

            if ($request->hasFile('surat_file')) {
                $suratUrl = $gdrive->upload(
                    $request->file('surat_file'),
                    'SIMI/Surat Peminjaman'
                );
            }
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Gagal mengupload file ke Google Drive: ' . $e->getMessage());
        }

        // Ambil nama user yang login
        $user = Auth::user();

        LoanRequest::create([
            'user_id'            => $user->id,
            'borrower_name'      => $user->name,
            'organization'       => $user->organization ?? null,
            'inventory_id'       => $validated['inventory_id'],
            'duration_days'      => $validated['duration_days'],
            'surat_link'         => $validated['surat_link'] ?? null,
            'bukti_transfer_url' => $buktiUrl,
            'surat_file_url'     => $suratUrl,
            'status'             => 'pending',
        ]);

        return back()->with('success', 'Permintaan peminjaman berhasil diajukan.');
    }

    /**
     * Upload surat menyusul (setelah peminjaman disetujui)
     */
    public function uploadSurat(Request $request, LoanRequest $loan)
    {
        // Pastikan hanya pemilik yang bisa upload
        abort_if($loan->user_id !== Auth::id(), 403);

        $request->validate([
            'surat_file' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ], [
            'surat_file.required' => 'File surat wajib dipilih.',
            'surat_file.mimes'    => 'File harus berupa JPG, PNG, atau PDF.',
        ]);

        try {
            $gdrive   = new GoogleDriveService();
            $suratUrl = $gdrive->upload(
                $request->file('surat_file'),
                'SIMI/Surat Peminjaman'
            );

            $loan->update(['surat_file_url' => $suratUrl]);

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal upload surat: ' . $e->getMessage());
        }

        return back()->with('success', 'Surat peminjaman berhasil diupload.');
    }
}
