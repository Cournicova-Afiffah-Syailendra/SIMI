<?php

namespace App\Http\Controllers;

use App\Models\LoanRequest;
use App\Exports\ReportExport;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->start_date
            ? Carbon::parse($request->start_date)->startOfDay()
            : Carbon::now()->startOfMonth();

        $endDate = $request->end_date
            ? Carbon::parse($request->end_date)->endOfDay()
            : Carbon::now()->endOfMonth();

        $jenis = $request->jenis ?? 'semua';

        $loanRequests = LoanRequest::with(['inventory', 'returnItem'])
            ->where('status', 'approved')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->latest()
            ->get();

        $totalPendapatan = $loanRequests->sum(function($loan) {
            return ($loan->inventory->price ?? 0) * ($loan->duration_days ?? 0);
        });

        $totalTransaksi = $loanRequests->count();

        // Export PDF
        if ($request->export === 'pdf') {
            $pdf = Pdf::loadView('admin.reports.pdf', compact(
                'loanRequests', 'totalPendapatan', 'totalTransaksi',
                'startDate', 'endDate', 'jenis'
            ))->setPaper('a4', 'landscape');

            return $pdf->download('laporan-' . now()->format('Y-m-d') . '.pdf');
        }

        // Export Excel
        if ($request->export === 'excel') {
            return Excel::download(
                new ReportExport($loanRequests, $jenis),
                'laporan-' . now()->format('Y-m-d') . '.xlsx'
            );
        }

        return view('admin.reports.index', compact(
            'loanRequests', 'totalPendapatan', 'totalTransaksi',
            'startDate', 'endDate', 'jenis'
        ));
    }
}
