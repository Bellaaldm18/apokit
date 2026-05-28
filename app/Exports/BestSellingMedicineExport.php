<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BestSellingMedicineExport implements FromCollection, WithHeadings
{
    protected $obat;

    public function __construct($obat)
    {
        $this->obat = $obat;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return collect($this->obat)->map(function($obat, $index) {
            return [
                '#' => $index + 1,
                'Nama Obat' => $obat['nama_obat'],
                'Nomor Batch' => $obat['no_batch'],
                'Total Penjualan' => $obat['total_penjualan'],
                'Stok Saat Ini' => $obat['stok']
            ];
        });
    }

    public function headings(): array
    {
        return [
            '#',
            'Nama Obat',
            'Nomor Batch',
            'Total Penjualan',
            'Stok Saat Ini'
        ];
    }
}