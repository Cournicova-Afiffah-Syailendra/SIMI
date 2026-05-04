<?php

namespace App\Http\Controllers;

use App\Models\ReturnItem;
use App\Models\LoanRequest;
use Illuminate\Http\Request;

class ReturnController extends Controller
{
    public function index()
    {
        $returns = LoanRequest::with(['inventory', 'returnItem'])
            ->where('status', 'approved')
            ->latest()
            ->get();

        return view('admin.returns.index', compact('returns'));
    }

    public function confirm(LoanRequest $loanRequest)
    {
        ReturnItem::updateOrCreate(
            ['loan_request_id' => $loanRequest->id],
            [
                'return_date' => now()->toDateString(),
                'status'      => 'sudah',
                'denda'       => 0,
            ]
        );

        return redirect()
            ->route('returns.index')
            ->with('success', 'Pengembalian berhasil dikonfirmasi.');
    }
}
