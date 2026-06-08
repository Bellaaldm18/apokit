<?php

namespace App\Http\Controllers;

use App\Models\ManajemenObat;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MonitoringController extends Controller
{
    public function index()
    {
        $totalObat = ManajemenObat::count();
        $obatStokRendah = ManajemenObat::where('stok', '<=', 10)->count();
        $semester = Carbon::now()->addMonths(6);
        $obatMendekatiKadaluarsa = ManajemenObat::where('tgl_kadaluarsa', '<=', $semester)->count();
        $obatKadaluarsa = ManajemenObat::where('tgl_kadaluarsa', '<', now())->count();

        return view('admin.monitoring.index', compact(
            'totalObat', 'obatStokRendah', 'obatMendekatiKadaluarsa', 'obatKadaluarsa'
        ));
    }

    public function stokRendah()
    {
        $obat = ManajemenObat::where('stok', '<=', 10)->orderBy('stok', 'asc')->get();
        return datatables()->of($obat)->toJson();
    }

    public function kadaluarsaMendekati()
    {
        $semester = Carbon::now()->addMonths(6);
        $obat = ManajemenObat::where('tgl_kadaluarsa', '<=', $semester)
            ->orderBy('tgl_kadaluarsa', 'asc')
            ->get();
        return datatables()->of($obat)->toJson();
    }
}
