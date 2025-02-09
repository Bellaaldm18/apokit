<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class RiwayatController extends Controller
{
    public function index()
    {
        return view('cashier.riwayat.index');
    }

    public function viewDatas()
    {
        $data = Transaksi::with('detailTransaksis')->get();
        return DataTables::of($data)
            ->addColumn('aksi', function($data) {
                return view('cashier.riwayat.tombol')->with('data', $data);
            })
            ->make(true);
    }

    public function transactionDetails($id = null)
    {
        $data = Transaksi::with('detailTransaksis.obat')->where('id',$id)->first();
        // return $data;
        return view('cashier.riwayat.detail', compact('data'));
    }
}
