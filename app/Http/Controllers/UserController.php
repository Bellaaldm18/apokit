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
                // 'password' => 'required',
                'role' => 'required'
            ],
            [
                'nama' => 'Kolom nama harus diisi',
                'username' => 'Kolom username harus diisi',
                // 'password' => 'Kolom password harus diisi',
                'role' => 'Kolom role harus diisi'
            ]
        );

        if($validator->fails()) {
            DB::rollBack();
            return [
                'errors' => $validator->errors()
            ];
        }

        try {
            $data = [
                'nama' => $request->nama,
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'role' => $request->role,
                'no_tlpn' => $request->no_tlpn,
                'email' => $request->email,
                'is_active' => 1
            ];

            if(filled($request->password)) {
                $data['password'] = Hash::make($request->password);
            }

            User::updateOrCreate(['id' => $id], $data);
            DB::commit();

            return view('admin.user.index');
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
