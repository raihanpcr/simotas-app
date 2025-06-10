<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Warga;
use Illuminate\Http\Request;

class DisabilitasController extends Controller
{
    function index(){
        $datas = Warga::where('kategori', 'Disabilitas')->get();

        return view('pages.disabilitas.data', compact('datas'));
    }

    public function destroy($id)
    {
        $data = Warga::findOrFail($id);
        $data->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus.');
    }

    public function addForm(){
        $kategori = "Disabilitas";
        return view('pages.disabilitas.add', compact('kategori'));
    }

    public function edit($id){
        $data = Warga::findOrFail($id);
        return view('pages.disabilitas.update', compact('data'));
    }

    public function update(Request $request, $id){
        $warga = Warga::findOrFail($id);

        $warga->update([
            'nik' => $request->nik,
            'name' => $request->name,
            'place_of_birth' => $request->tempat_lahir,
            'date_of_birth' => $request->tanggal_lahir,
            'alamat' => $request->alamat,
            'umur' =>  Carbon::parse($request->tanggal_lahir)->age,
        ]);

        return redirect()->route('disabilitas')->with('success', 'Data berhasil diupdate');
    }

    public function store(Request $request){

        // dd($request);

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
            'kategori' => "Disabilitas"
        ]);

        return redirect('/disabilitas')->with('success', 'Data berhasil ditambahkan!');

    }

}
