<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

use Carbon\Carbon;

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
            $today = Carbon::today();
            $exp   = Carbon::parse($obat['tgl_kadaluarsa']);
            $diff  = $today->diffInDays($exp, false);

            if ($diff < 0) {
                $sisaHari = 'Sudah Kadaluarsa';
            } elseif ($diff === 0) {
                $sisaHari = 'Hari Ini';
            } else {
                $sisaHari = $diff . ' Hari Lagi';
            }

            return [
                '#'                  => $index + 1,
                'Nama Obat'          => $obat['nama'],
                'Nomor Batch'        => $obat['no_batch'],
                'Tanggal Kadaluarsa' => $obat['tgl_kadaluarsa'],
                'Sisa Hari'          => $sisaHari,
                'Stok'               => $obat['stok'],
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
            'Sisa Hari',
            'Stok',
        ];
    }
}
