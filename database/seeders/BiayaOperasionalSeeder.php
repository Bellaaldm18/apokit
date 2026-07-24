<?php

namespace Database\Seeders;

use App\Models\BiayaOperasional;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BiayaOperasionalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            // Mei 2026
            ['tanggal' => '2026-05-05', 'nama_biaya' => 'Listrik', 'kategori' => 'operasional', 'jumlah' => 120000, 'keterangan' => 'Tagihan listrik apotek bulan Mei'],
            ['tanggal' => '2026-05-05', 'nama_biaya' => 'Air', 'kategori' => 'operasional', 'jumlah' => 40000, 'keterangan' => 'Tagihan air bulan Mei'],
            ['tanggal' => '2026-05-10', 'nama_biaya' => 'Internet', 'kategori' => 'operasional', 'jumlah' => 70000, 'keterangan' => 'Langganan internet bulan Mei'],
            ['tanggal' => '2026-05-31', 'nama_biaya' => 'Pajak UMKM', 'kategori' => 'non_operasional', 'jumlah' => 7300, 'keterangan' => 'Pajak final 0,5% dari omzet Mei'],
            ['tanggal' => '2026-05-31', 'nama_biaya' => 'Biaya Admin Bank', 'kategori' => 'non_operasional', 'jumlah' => 15000, 'keterangan' => 'Biaya administrasi rekening bulan Mei'],

            // Juni 2026
            ['tanggal' => '2026-06-05', 'nama_biaya' => 'Listrik', 'kategori' => 'operasional', 'jumlah' => 30000, 'keterangan' => 'Tagihan listrik apotek bulan Juni'],
            ['tanggal' => '2026-06-10', 'nama_biaya' => 'Internet', 'kategori' => 'operasional', 'jumlah' => 20000, 'keterangan' => 'Langganan internet bulan Juni'],
            ['tanggal' => '2026-06-30', 'nama_biaya' => 'Pajak UMKM', 'kategori' => 'non_operasional', 'jumlah' => 1400, 'keterangan' => 'Pajak final 0,5% dari omzet Juni'],
            ['tanggal' => '2026-06-30', 'nama_biaya' => 'Biaya Admin Bank', 'kategori' => 'non_operasional', 'jumlah' => 15000, 'keterangan' => 'Biaya administrasi rekening bulan Juni'],
        ];

        foreach ($data as $row) {
            BiayaOperasional::firstOrCreate(
                ['tanggal' => $row['tanggal'], 'nama_biaya' => $row['nama_biaya']],
                $row
            );
        }
    }
}
