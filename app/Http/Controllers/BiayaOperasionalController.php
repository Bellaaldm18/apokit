<?php

namespace App\Http\Controllers;

use App\Models\BiayaOperasional;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class BiayaOperasionalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.biaya.index');
    }

    public function viewDatas()
    {
        $data = BiayaOperasional::orderBy('tanggal', 'desc')->get();
        return DataTables::of($data)
            ->addColumn('aksi', function ($data) {
                return view('admin.biaya.tombol')->with('data', $data);
            })
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.biaya.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $id = null)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'tanggal' => 'required|date',
                'nama_biaya' => 'required',
                'kategori' => 'required|in:operasional,non_operasional',
                'jumlah' => 'required|numeric|min:0',
            ],
            [
                'tanggal.required' => 'Kolom tanggal harus diisi',
                'nama_biaya.required' => 'Kolom nama biaya harus diisi',
                'kategori.required' => 'Kolom kategori harus diisi',
                'jumlah.required' => 'Kolom jumlah harus diisi',
                'jumlah.numeric' => 'Kolom jumlah harus berupa angka',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
        try {
            $data = [
                'tanggal' => $request->tanggal,
                'nama_biaya' => $request->nama_biaya,
                'kategori' => $request->kategori,
                'jumlah' => $request->jumlah,
                'keterangan' => $request->keterangan,
            ];

            BiayaOperasional::updateOrCreate(['id' => $id], $data);

            DB::commit();

            return redirect()->route('biaya.index')->with('success', 'Data biaya berhasil disimpan');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage());
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
        $data = BiayaOperasional::find($id);
        return view('admin.biaya.create', compact('data'));
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
        DB::beginTransaction();

        try {
            $biaya = BiayaOperasional::findOrFail($id);
            $biaya->delete();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }

        return response()->json(['message' => 'Data biaya berhasil dihapus'], 200);
    }
}
