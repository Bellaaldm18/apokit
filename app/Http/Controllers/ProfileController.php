<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function edit()
    {
        $data = auth()->user();
        return view('profile.profile', compact('data'));
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        $validator = Validator::make(
            $request->all(),
            [
                'nama' => 'required',
                'username' => 'required',
                'password' => 'nullable|min:6',
            ],
            [
                'nama' => 'Kolom nama harus diisi',
                'username' => 'Kolom username harus diisi',
                'password.min' => 'Password minimal harus 6 karakter',
            ]
        );

        if ($validator->fails()) {
            DB::rollBack();
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $data = [
                'nama' => $request->nama,
                'no_tlpn' => $request->no_tlpn,
                'email' => $request->email
            ];

            if ($request->filled('password')) {
                $data['password'] = Hash::make($request->password);
            }

            $user = User::findOrFail($id);
            $user->update($data);

            DB::commit();

            return redirect()->route('profile.edit');
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
