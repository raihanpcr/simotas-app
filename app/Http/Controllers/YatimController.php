<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Warga;
use Illuminate\Http\Request;

class YatimController extends Controller
{
    public function index()
    {
        $datas = Warga::where('kategori', 'Yatim')->get();

        return view('pages.yatim.data', compact('datas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategori = "Yatim";
        return view('pages.yatim.add', compact('kategori'));
    }

    /**
     * Store a newly created resource in storage.
     */
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
            'kategori' => "Yatim"
        ]);

        return redirect()->route('yatim.index')->with('success', 'Data berhasil ditambahkan!');
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
        return view('pages.yatim.update', compact('data'));
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

        return redirect()->route('yatim.index')->with('success', 'Data berhasil diupdate');
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
