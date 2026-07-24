<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = User::get();
        return view('admin.user.index', compact('data'));
    }

    public function viewDatas() {
        $data = User::get();
        return DataTables::of($data)
            ->addColumn('aksi', function($data) {
                return view('admin.user.tombol')->with('data', $data);
            })
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.user.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $id = null)
    {
        DB::beginTransaction();
        $validator = Validator::make(
            $request->all(),
            [
                'nama' => 'required',
                'username' => 'required',
                'password' => $id ? 'nullable|min:5' : 'required|min:5',
                'role' => 'required'
            ],
            [
                'nama' => 'Kolom nama harus diisi',
                'username' => 'Kolom username harus diisi',
                'password.required' => 'Kolom password harus diisi',
                'password.min' => 'Password minimal 5 karakter',
                'role' => 'Kolom role harus diisi'
            ]
        );

        if($validator->fails()) {
            DB::rollBack();
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $data = [
                'nama' => $request->nama,
                'username' => $request->username,
                'role' => $request->role,
                'no_tlpn' => $request->no_tlpn,
                'email' => $request->email,
            ];

            if(filled($request->password)) {
                $data['password'] = Hash::make($request->password);
            }

            if(!$id) {
                $data['is_active'] = 1;
            }

            User::updateOrCreate(['id' => $id], $data);
            DB::commit();

            return redirect()->route('user.index')->with('success', 'Data user berhasil disimpan');
        } catch(\Exception $e) {
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
        $data = User::find($id);
        return view('admin.user.create', compact('data'));
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
            $manajemen_user = User::findOrFail($id);
            $manajemen_user->delete();

            DB::commit();
        } catch(\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }

        return response()->json(['message' => 'User berhasil dihapus'], 200);
    }

    public function is_active(Request $request, $id)
    {
        $update = User::where(['id' => $id])
            ->update([
                'is_active' => $request->status
            ]);

        if($update) {
            return [
                'success' => true
            ];
        }
    }
}
