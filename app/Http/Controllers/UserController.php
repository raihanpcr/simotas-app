<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Kecamatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    
    public function index()
    {
        $datas = User::with('kecamatan')->orderBy('created_at', 'desc')->paginate(5);
        return view('pages.user.data', compact('datas'));
    }

    public function create()
    {
        $kecamatan = Kecamatan::all();
        return view('pages.user.add', compact('kecamatan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'username' => 'required',
            'password' => 'required',
            'kecamatan_id' => 'required',
            'kelurahan_id' => 'required',
            'role' => 'required',
        ]);

        // dd($request->all());

        $pass = Hash::make($request->password);
        // dd($request->all());
        User::create([
            'name' => $request->nama,
            'username' => $request->username,
            'password' => $pass,
            'password_string' => $request->password,
            'role' => $request->role,
            'kecamatan_id' => $request->kecamatan_id,
            'kelurahan_id' => $request->kelurahan_id
        ]);

        return redirect()->route('user.index')->with('success', 'Data berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = User::findOrFail($id);
        $kecamatan = Kecamatan::all();
        return view('pages.user.update', compact('data', 'kecamatan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'nama' => 'required',
            'username' => 'required',
            'password' => 'required',
            'kecamatan_id' => 'required',
            'kelurahan_id' => 'required',
            'role' => 'required',
        ]);

        $user->update([
            'name' => $request->nama,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'password_string' => $request->password,
            'kecamatan_id' => $request->kecamatan_id,
            'kelurahan_id' => $request->kelurahan_id,
            'role' => $request->role,
        ]);

        return redirect()->route('user.index')->with('success', 'Data berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = User::findOrFail($id);
        $data->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus.');
    }
}
