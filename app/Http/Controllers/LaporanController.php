<?php

namespace App\Http\Controllers;

use App\Exports\MonthlyTransactionExport;
use App\Models\BiayaOperasional;
use App\Models\DetailTransaksi;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use ConsoleTVs\Charts\Facades\Charts;

class LaporanController extends Controller
{
    public function index()
    {
        $sumToday = $this->today();
        $sumWeekly = $this->weekly();
        $sumMonthly = $this->monthly();
        return view('admin.pelaporan_keuangan.index', compact('sumToday', 'sumWeekly', 'sumMonthly'));
    }

    public function today()
    {
        $today = now()->format('Y-m-d');
        $todayTransaction = Transaksi::whereDate('tgl_transaksi', $today)->get();
        $sum = $todayTransaction->sum('total_pembayaran');

        return $sum ? $sum : 0;
    }

    public function weekly()
    {
        $startOfWeek = now()->startOfWeek();
        $endOfWeek = now()->endOfWeek();

        $weeklyTransaction = Transaksi::whereBetween('tgl_transaksi', [$startOfWeek, $endOfWeek])->get();
        $sum = $weeklyTransaction->sum('total_pembayaran');

        return $sum ? $sum : 0;
    }

    public function monthly()
    {
        $startOfMonth = now()->startOfMonth();
        $endOfMonth = now()->endOfMonth();

        $monthlyTransaction = Transaksi::whereBetween('tgl_transaksi', [$startOfMonth, $endOfMonth])->get();
        $sum = $monthlyTransaction->sum('total_pembayaran');

        return $sum ? $sum : 0;
    }

    public function monthlyTransaction(Request $request)
    {
        $bulan = $request->input('bulan');

        $transaksi = Transaksi::whereMonth('tgl_transaksi', $bulan)->get();

        return datatables()->of($transaksi)->toJson();
    }

    public function exportMonthly(Request $request)
    {
        $bulan = $request->input('bulan');
        $namaBulan = $this->getNamaBulan($bulan);
        $transaksi = Transaksi::whereMonth('tgl_transaksi', $bulan)->get();
        $export = new MonthlyTransactionExport($transaksi);
        // return $transaksi;
        $fileName = 'laporan_bulanan_' . strtolower($namaBulan) . '.xlsx';
        return Excel::download($export, $fileName);
    }

    private function getNamaBulan($bulan)
    {
        $daftarBulan = [
            '01' => 'Januari',
            '02' => 'Februari',
            '03' => 'Maret',
            '04' => 'April',
            '05' => 'Mei',
            '06' => 'Juni',
            '07' => 'Juli',
            '08' => 'Agustus',
            '09' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember',
        ];

        return $daftarBulan[$bulan];
    }

    public function totalPendapatanBulan(Request $request)
    {
        $bulan = $request->bulan;

        $total = Transaksi::whereMonth('tgl_transaksi', $bulan)
            ->sum('total_pembayaran');

        $totalCash = Transaksi::whereMonth('tgl_transaksi', $bulan)
            ->where('metode_pembayaran', 'cash')
            ->sum('total_pembayaran');

        $totalQris = Transaksi::whereMonth('tgl_transaksi', $bulan)
            ->where('metode_pembayaran', 'qris')
            ->sum('total_pembayaran');

        $totalTransfer = Transaksi::whereMonth('tgl_transaksi', $bulan)
            ->where('metode_pembayaran', 'transfer')
            ->sum('total_pembayaran');

        return response()->json([
            'total' => $total,
            'cash' => $totalCash,
            'qris' => $totalQris,
            'transfer' => $totalTransfer
        ]);
    }

    public function ringkasanLaba(Request $request)
    {
        $bulan = $request->bulan;

        $pendapatan = Transaksi::whereMonth('tgl_transaksi', $bulan)->sum('total_pembayaran');

        $hpp = DetailTransaksi::whereHas('transaksi', function ($query) use ($bulan) {
            $query->whereMonth('tgl_transaksi', $bulan);
        })->with('obat')->get()->sum(function ($detail) {
            return ($detail->obat->harga_beli ?? 0) * $detail->kuantitas;
        });

        $biayaOperasional = BiayaOperasional::whereMonth('tanggal', $bulan)
            ->where('kategori', 'operasional')
            ->sum('jumlah');

        $biayaNonOperasional = BiayaOperasional::whereMonth('tanggal', $bulan)
            ->where('kategori', 'non_operasional')
            ->sum('jumlah');

        $labaKotor = $pendapatan - $hpp;
        $labaOperasional = $labaKotor - $biayaOperasional;
        $labaBersih = $labaOperasional - $biayaNonOperasional;

        $marginKotor = $pendapatan > 0 ? ($labaKotor / $pendapatan) * 100 : 0;
        $marginOperasional = $pendapatan > 0 ? ($labaOperasional / $pendapatan) * 100 : 0;
        $marginBersih = $pendapatan > 0 ? ($labaBersih / $pendapatan) * 100 : 0;

        return response()->json([
            'pendapatan' => $pendapatan,
            'hpp' => $hpp,
            'laba_kotor' => $labaKotor,
            'margin_kotor' => round($marginKotor, 1),
            'biaya_operasional' => $biayaOperasional,
            'laba_operasional' => $labaOperasional,
            'margin_operasional' => round($marginOperasional, 1),
            'biaya_non_operasional' => $biayaNonOperasional,
            'laba_bersih' => $labaBersih,
            'margin_bersih' => round($marginBersih, 1),
        ]);
    }
}
