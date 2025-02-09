<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

use function PHPSTORM_META\map;

class ExpiredMedicineExport implements FromCollection, WithHeadings
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
                '#' => $index+1,
                'Nama Obat' => $obat['nama'],
                'Nomor Batch' => $obat['no_batch'],
                'Tanggal Kadaluarsa' => $obat['tgl_kadaluarsa'],
                'Stok' => $obat['stok']
            ];
        });
    }

    public function headings(): array
    {
        return [
            '#',
            'Nama Obat',
            'Nomor Batch',
            'Tanggal Kadaluarsa',
            'Stok'
        ];
    }
}
