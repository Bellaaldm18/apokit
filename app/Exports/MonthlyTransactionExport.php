<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MonthlyTransactionExport implements FromCollection, WithHeadings
{
    protected $transaksi;

    public function __construct($transaksi)
    {
        $this->transaksi = $transaksi;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return collect($this->transaksi)->map(function($transaksi, $index) {
            return [
                '#' => $index+1,
                'Nomor Transaksi' => $transaksi['no_transaksi'],
                'Tanggal Transaksi' => $transaksi['tgl_transaksi'],
                'Total Transaksi' => $transaksi['total_pembayaran']
            ];
        });
    }

    public function headings(): array
    {
        return [
            '#',
            'Nomor Transaksi',
            'Tanggal Transaksi',
            'Total Transaksi'
        ];
    }
}
