<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ReportExport implements FromCollection, WithHeadings, WithStyles
{
    protected $data;
    protected $jenis;

    public function __construct($data, $jenis = 'semua')
    {
        $this->data  = $data;
        $this->jenis = $jenis;
    }

    public function collection()
    {
        $rows = collect();

        foreach ($this->data as $loan) {
            $biaya       = ($loan->inventory->price ?? 0) * ($loan->duration_days ?? 0);
            $sudahKembali = $loan->returnItem && $loan->returnItem->status === 'sudah';

            if ($this->jenis === 'semua' || $this->jenis === 'peminjaman') {
                $rows->push([
                    'tanggal'   => $loan->created_at->format('j F Y'),
                    'jenis'     => 'Peminjaman',
                    'detail'    => $loan->inventory->name ?? '-',
                    'peminjam'  => $loan->borrower_name,
                    'biaya'     => $biaya,
                ]);
            }

            if ($sudahKembali && ($this->jenis === 'semua' || $this->jenis === 'pengembalian')) {
                $rows->push([
                    'tanggal'   => \Carbon\Carbon::parse($loan->returnItem->return_date)->format('j F Y'),
                    'jenis'     => 'Pengembalian',
                    'detail'    => $loan->inventory->name ?? '-',
                    'peminjam'  => $loan->borrower_name,
                    'biaya'     => '-',
                ]);
            }

            if ($sudahKembali && ($loan->returnItem->denda ?? 0) > 0 && $this->jenis === 'semua') {
                $rows->push([
                    'tanggal'   => \Carbon\Carbon::parse($loan->returnItem->return_date)->format('j F Y'),
                    'jenis'     => 'Denda',
                    'detail'    => 'Keterlambatan pengembalian',
                    'peminjam'  => $loan->borrower_name,
                    'biaya'     => $loan->returnItem->denda,
                ]);
            }
        }

        return $rows;
    }

    public function headings(): array
    {
        return ['Tanggal', 'Jenis', 'Detail', 'Peminjam', 'Biaya (Rp)'];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
