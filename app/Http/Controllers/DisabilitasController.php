<?php

namespace App\Http\Controllers;

use App\Models\Kecamatan;
use App\Models\Kelurahan;
use Carbon\Carbon;
use App\Models\Warga;
use Illuminate\Http\Request;

class DisabilitasController extends Controller
{
    function index(Request $request){
        $query = Warga::with('kecamatan')->where('kategori', 'Disabilitas');

        if ($request->has('search') && $request->search != '') {
            $query->where('nik', 'like', '%' . $request->search . '%');
        }
        
        $datas = $query->orderBy('created_at', 'desc')->paginate(10)->appends($request->only('search'));
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
        $kecamatan = Kecamatan::all();
        return view('pages.disabilitas.add', compact('kategori', 'kecamatan'));
    }

    public function GetKelurahan(request $request){
        $kelurahan = Kelurahan::where('kecamatan_id', $request->kecamatan_id)->get();
        return response()->json($kelurahan);
    }

    public function edit($id){
        $data = Warga::findOrFail($id);
        return view('pages.disabilitas.update', compact('data'));
    }

    public function update(Request $request, $id){
        $warga = Warga::findOrFail($id);

        $request->validate([
            'nik' => 'required|unique:warga,nik' . $warga->id,
            'name' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required',
        ], [
            'nik.unique' => 'NIK sudah terdaftar.',
        ]);


        $warga->update([
            'nik' => $request->nik,
            'name' => $request->name,
            'place_of_birth' => $request->tempat_lahir,
            'date_of_birth' => $request->tanggal_lahir,
            'alamat' => $request->alamat,
            'kec_id' => $request->kecamatan_id,
            'kel_id' => $request->kelurahan_id,
            'umur' =>  Carbon::parse($request->tanggal_lahir)->age,
        ]);

        return redirect()->route('disabilitas')->with('success', 'Data berhasil diupdate');
    }

    public function store(Request $request){

        // dd($request);

        $request->validate([
            'nik' => 'required|unique:warga,nik',
            'name' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required',
        ], [
            'nik.unique' => 'NIK sudah terdaftar.',
        ]);

        Warga::create([
            'nik' => $request->nik,
            'name' => $request->name,
            'place_of_birth' => $request->tempat_lahir,
            'date_of_birth' => $request->tanggal_lahir,
            'kec_id' => $request->kecamatan_id,
            'kel_id' => $request->kelurahan_id,
            'umur' => Carbon::parse($request->tanggal_lahir)->age,
            'alamat' => $request->alamat,
            'kategori' => "Disabilitas"
        ]);

        return redirect('/disabilitas')->with('success', 'Data berhasil ditambahkan!');
    }

}
