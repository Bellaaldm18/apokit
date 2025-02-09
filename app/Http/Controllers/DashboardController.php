<?php

namespace App\Http\Controllers;

use App\Models\DetailTransaksi;
use App\Models\ManajemenObat;
use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard.index');
    }

    public function showDashboard()
    {
        // Assuming $daysOfWeek and $revenueData are already available in your controller

        // Top 5 Obat Terlaris
        $data = DetailTransaksi::join('manajemen_obats', 'detail_transaksis.obat_id', '=', 'manajemen_obats.id')
            ->select('manajemen_obats.nama as nama_obat', 'manajemen_obats.no_batch', DB::raw('SUM(detail_transaksis.kuantitas) as total_penjualan'))
            ->whereDate('detail_transaksis.created_at', '>=', now()->subDays(30))
            ->groupBy('manajemen_obats.nama', 'manajemen_obats.no_batch')
            ->orderBy('total_penjualan', 'desc')
            ->take(5)
            ->get();

        // Obat Mendekati Kadaluarsa
        $semester = Carbon::now()->addMonths(6);
        $kadaluarsa = ManajemenObat::where('tgl_kadaluarsa', '<=', $semester)
            ->orderBy('tgl_kadaluarsa')
            ->take(5)
            ->get();

        $daysOfWeek = [];
        $revenueData = [];

        for ($i = 6; $i >= 0; $i--) {
            $day = Carbon::now()->subDays($i)->format('Y-m-d');
            $daysOfWeek[] = $day;

            $dailyRevenue = $this->getDailyRevenue($day);
            $revenueData[] = $dailyRevenue;
        }

        $sumToday = $this->today();
        $sumWeekly = $this->weekly();
        $sumMonthly = $this->monthly();

        return view('admin.dashboard.index', compact('data', 'kadaluarsa', 'daysOfWeek', 'revenueData', 'sumToday', 'sumWeekly', 'sumMonthly'));
    }

    private function getDailyRevenue($date)
    {
        $dailyTransaction = Transaksi::whereDate('tgl_transaksi', $date)->get();
        $sum = $dailyTransaction->sum('total_pembayaran');

        return $sum ? $sum : 0;
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
}
