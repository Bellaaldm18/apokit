<?php

namespace App\Http\Controllers;

use App\Exports\BestSellingMedicineExport;
use App\Exports\ExpiredMedicineExport;
use App\Models\DetailTransaksi;
use App\Models\ManajemenObat;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class LaporanObatController extends Controller
{
    public function index()
    {
        return view('admin.pelaporan_obat.index');
    }

    public function cariKadaluarsa()
    {
        $semester = Carbon::now()->addMonths(6);
        $kadaluarsa = ManajemenObat::where('tgl_kadaluarsa', '<=', $semester)->get();

        return datatables()->of($kadaluarsa)->toJson();
    }

    public function obatTerlaris()
    {
        $obatTerlaris = DetailTransaksi::join('manajemen_obats', 'detail_transaksis.obat_id', '=', 'manajemen_obats.id')
                        ->select('manajemen_obats.nama as nama_obat', 'manajemen_obats.no_batch', DB::raw('SUM(detail_transaksis.kuantitas) as total_penjualan'), 'manajemen_obats.stok')
                        ->whereDate('detail_transaksis.created_at', '>=', now()->subDays(30))
                        ->groupBy('manajemen_obats.nama', 'manajemen_obats.no_batch', 'manajemen_obats.stok')
                        ->orderBy('total_penjualan', 'desc')
                        ->get();

        return datatables()->of($obatTerlaris)->toJson();
    }

    public function exportExpired(Request $request)
    {
        $semester = Carbon::now()->addMonths(6);
        $kadaluarsa = ManajemenObat::where('tgl_kadaluarsa', '<=', $semester)->get();
        $export = new ExpiredMedicineExport($kadaluarsa);
        // return $kadaluarsa;
        $fileName = 'laporan_obat_kadaluarsa.xlsx';
        return Excel::download($export, $fileName);
    }

    public function exportBestSelling(Request $request)
    {
        $obatTerlaris = DetailTransaksi::join('manajemen_obats', 'detail_transaksis.obat_id', '=', 'manajemen_obats.id')
                        ->select('manajemen_obats.nama as nama_obat', 'manajemen_obats.no_batch', DB::raw('SUM(detail_transaksis.kuantitas) as total_penjualan'), 'manajemen_obats.stok')
                        ->whereDate('detail_transaksis.created_at', '>=', now()->subDays(30))
                        ->groupBy('manajemen_obats.nama', 'manajemen_obats.no_batch', 'manajemen_obats.stok')
                        ->orderBy('total_penjualan', 'desc')
                        ->get();
        // return $obatTerlaris;
        $export = new BestSellingMedicineExport($obatTerlaris);
        $fileName = 'laporan_obat_terlaris.xlsx';
        return Excel::download($export, $fileName);
    }
}
