<?php

namespace App\Http\Controllers;

use App\Models\DetailTransaksi;
use App\Models\ManajemenObat;
use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class PembayaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $keranjang = session('keranjangBelanja', []);
        $no_pesanan = $this->generateOrder();
        return view('cashier.pembayaran.index', compact('keranjang', 'no_pesanan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $keranjang = session('keranjangBelanja', []);

    DB::beginTransaction();
    try {
        // Hitung total dari keranjang
        $totalPembayaran = 0;
        foreach ($keranjang as $item) {
            $totalPembayaran += $item['harga'] * $item['kuantitas'];
        }

        $bayar = (int) $request->bayar;
        $kembalian = (int) $request->kembalian;

        // Simpan transaksi utama
        $transaksi = new Transaksi();
        $transaksi->no_transaksi = $request->no_pesanan;
        $transaksi->tgl_transaksi = now()->format('Y-m-d');
        $transaksi->waktu_transaksi = now()->toTimeString();
        $transaksi->total_pembayaran = $totalPembayaran;
        $transaksi->bayar = $bayar;
        $transaksi->kembalian = $kembalian;
        $transaksi->save();

        // Simpan detail transaksi
        foreach ($keranjang as $item) {
            $subtotal = $item['harga'] * $item['kuantitas'];
            $porsi = $subtotal / $totalPembayaran;

            $detailTransaksi = new DetailTransaksi();
            $detailTransaksi->transaksi_id = $transaksi->id;
            $detailTransaksi->obat_id = $item['id'];
            $detailTransaksi->kuantitas = $item['kuantitas'];
            $detailTransaksi->total_harga = $subtotal;
            $detailTransaksi->bayar = floor($bayar * $porsi);
            $detailTransaksi->kembalian = floor($kembalian * $porsi);
            $detailTransaksi->save();

            // Kurangi stok obat
            $obat = ManajemenObat::find($item['id']);
            if ($obat) {
                $obat->stok -= $item['kuantitas'];
                $obat->save();
            }
        }

        DB::commit();
        session()->forget('keranjangBelanja');
        return redirect()->to('pesanan');

    } catch (\Exception $e) {
        DB::rollBack();
        dd($e->getMessage());
        return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan transaksi: ' . $e->getMessage());
    }
}


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function getKeranjang()
    {
        $keranjang = session('keranjangBelanja', []);
        return response()->json(['keranjang' => $keranjang]);
    }

    public function generateOrder()
    {
        $today = now()->format('Ymd');
        $lastOrder = Transaksi::where('tgl_transaksi', $today)->latest()->first();

        if($lastOrder) {
            $lastOrderNumber = $lastOrder->no_transaksi;
            $lastOrderSequence = (int) substr($lastOrderNumber, -3);
            $newSequence = str_pad($lastOrderSequence + 1, 3, '0', STR_PAD_LEFT);
            $order = $today . '-' . $newSequence;
        } else {
            $order = $today . '-001';
        }


        return $order;
    }
}
