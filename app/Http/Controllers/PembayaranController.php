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
        // dd($keranjang);

        DB::beginTransaction();
        try {
            $transaksi = new Transaksi();
            $transaksi->no_transaksi = $request->no_pesanan;
            $transaksi->tgl_transaksi = now()->format('Y-m-d');
            $transaksi->waktu_transaksi = now()->toTimeString(); // Tambahkan waktu transaksi sesuai dengan saat ini
            $transaksi->total_pembayaran = $request->bayar; // Isi dengan total pembayaran jika Anda memiliki perhitungan total
            $transaksi->save();

            // Simpan juga detail transaksi jika ada
            foreach ($keranjang as $item) {
                $detailTransaksi = new DetailTransaksi();
                $detailTransaksi->transaksi_id = $transaksi->id;
                $detailTransaksi->obat_id = $item['id'];
                $detailTransaksi->kuantitas = $item['kuantitas'];
                $detailTransaksi->total_harga = $item['harga'] * $item['kuantitas'];
                $detailTransaksi->save();

                $obat = ManajemenObat::find($item['id']);
                if($obat) {
                    $obat->stok -= $item['kuantitas'];
                    $obat->save();
                }
            }

            DB::commit();
            session()->forget('keranjangBelanja');
            return redirect()->to('pesanan');
        } catch(\Exception $e) {
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
