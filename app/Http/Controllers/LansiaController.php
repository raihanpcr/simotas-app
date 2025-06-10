<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Warga;
use Illuminate\Http\Request;

class LansiaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $datas = Warga::where('kategori', 'Lansia')->get();

        return view('pages.lansia.data', compact('datas'));
    }

    public function create()
    {
        $kategori = "Lansia";
        return view('pages.lansia.add', compact('kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nik' => 'required|max:16',
            'name' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required',
        ]);

        Warga::create([
            'nik' => $request->nik,
            'name' => $request->name,
            'place_of_birth' => $request->tempat_lahir,
            'date_of_birth' => $request->tanggal_lahir,
            'umur' => Carbon::parse($request->tanggal_lahir)->age,
            'alamat' => $request->alamat,
            'kategori' => "Lansia"
        ]);

        return redirect()->route('lansia.index')->with('success', 'Data berhasil ditambahkan!');
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
        $data = Warga::findOrFail($id);
        return view('pages.lansia.update', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $warga = Warga::findOrFail($id);

        $warga->update([
            'nik' => $request->nik,
            'name' => $request->name,
            'place_of_birth' => $request->tempat_lahir,
            'date_of_birth' => $request->tanggal_lahir,
            'alamat' => $request->alamat,
            'umur' =>  Carbon::parse($request->tanggal_lahir)->age,
        ]);

        return redirect()->route('lansia.index')->with('success', 'Data berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Warga::findOrFail($id);
        $data->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus.');
    }
}
