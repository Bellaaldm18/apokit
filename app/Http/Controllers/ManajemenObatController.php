<?php

namespace App\Http\Controllers;

use App\Models\ManajemenObat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class ManajemenObatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = ManajemenObat::get();
        return view('admin.obat.index', compact('data'));
        // return $data;
    }

    public function viewDatas() {
        $data = ManajemenObat::get();
        return DataTables::of($data)
            ->addColumn('aksi', function($data) {
                return view('admin.obat.tombol')->with('data', $data);
            })
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.obat.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $id = null)
    {
        DB::beginTransaction();
        // Validasi
        $validator = Validator::make(
            $request->all(),
            [
                'nama' => 'required',
                'no_batch' => 'required',
                'tgl_kadaluarsa' => 'required',
                'stok' => 'required',
                'tgl_penerimaan' => 'required',
                'harga_beli' => 'required',
                'harga_jual' => 'required'
            ],
            [
                'nama' => 'Kolom nama harus diisi',
                'no_batch' => 'Kolom nomor batch harus diisi',
                'tgl_kadaluarsa' => 'Kolom tanggal kadaluarsa harus diisi',
                'stok' => 'Kolom kuantitas harus diisi',
                'tgl_penerimaan' => 'Kolom tanggal penerimaan harus diisi',
                'harga_beli' => 'Kolom harga beli harus diisi',
                'harga_jual' => 'Kolom harga jual harus diisi'
            ]
        );

        if($validator->fails()) {
            DB::rollBack();
            return [
                'errors' => $validator->errors()
            ];
        }

        try {
            // Simpan Data
            $data = [
                'nama' => $request->nama,
                'no_batch' => $request->no_batch,
                'tgl_kadaluarsa' => $request->tgl_kadaluarsa,
                'stok' => $request->stok,
                'tgl_penerimaan' => $request->tgl_penerimaan,
                'harga_beli' => $request->harga_beli,
                'harga_jual' => $request->harga_jual,
                'catatan' => $request->catatan
            ];

            $manajemen_obat = ManajemenObat::updateOrCreate(['id'=>$id], $data);

            DB::commit();

            return view('admin.obat.index');
        } catch(\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
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
        $data = ManajemenObat::find($id);
        return view('admin.obat.create', compact('data'));
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

        try{
            $manajemen_obat = ManajemenObat::findOrFail($id);
            $manajemen_obat->delete();

            DB::commit();
        } catch(\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }

        return response()->json(['message' => 'Obat berhasil dihapus'], 200);
    }

    public function search(Request $request)
    {
        $searchTerm = $request->input('searchTerm');

        $result = ManajemenObat::where('nama', 'like', '%'. $searchTerm . '%')
            ->orWhere('no_batch', 'like', '%'. $searchTerm . '%')
            ->get();

        return response()->json($result);
    }
}
