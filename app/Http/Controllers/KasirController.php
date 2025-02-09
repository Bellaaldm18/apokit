<?php

namespace App\Http\Controllers;

use App\Models\ManajemenObat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;

class KasirController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = ManajemenObat::get();
        return view('cashier.kasir', compact('data'));
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
        //
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

    public function search(Request $request)
    {
        $data = ManajemenObat::get();
        return DataTables::of($data)
            ->addColumn('aksi', function($data) {
                return view('cashier.tombol')->with('data', $data);
            })
            ->make(true);
    }

    public function simpanKeranjang(Request $request)
    {
        $keranjang = $request->input('keranjang');

        Session::put('keranjangBelanja', $keranjang);

        return response()->json(['message' => 'Keranjang berhasil disimpan dalam session']);
    }
}
