<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Warga;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DisabilitasController extends Controller
{
    function index(Request $request){

        
        if (Auth::user()->role == "super_admin") {
            $query = Warga::with('kecamatan')->where('kategori', 'Disabilitas');

        }else if (Auth::user()->role == "kepala_dinas") {

            // kalau login kepala dinas
            $kecamatan = Auth::user()->kecamatan_id;
            $query = Warga::with('kecamatan')
                    ->where('kategori', 'Disabilitas')
                    ->where('kec_id', $kecamatan);

        }elseif (Auth::user()->role == "kepala_desa") {

            // kalau login kepala_desa
            $kelurahan = Auth::user()->kelurahan_id;
            $query = Warga::with('kecamatan')
                    ->where('kategori', 'Disabilitas')
                    ->where('kel_id', $kelurahan);
        };

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
        // $kelurahan = Kelurahan::where('kecamatan_id', $request->kecamatan_id)->get();
        // return response()->json($kelurahan);


        $user = Auth::user();
        $kecamatanID = $request->kecamatan_id;

        $kelurahan = Kelurahan::query();

        if ($user->role === 'super_admin') {
            $kelurahan->where('kecamatan_id', $kecamatanID);
        } elseif ($user->role === 'kepala_dinas') {
            if ($user->kecamatan_id == $kecamatanID) {
                $kelurahan->where('kecamatan_id', $kecamatanID);
            } else {
                return response()->json([]);
            }
        } elseif ($user->role === 'kepala_desa') {
            $kelurahan->where('id', $user->kelurahan_id)
                    ->where('kecamatan_id', $kecamatanID);
        } else {
            return response()->json([]);
        }

        return response()->json($kelurahan->get());
    }

    public function edit($id){
        $data = Warga::findOrFail($id);
        $kecamatan = Kecamatan::all();
        $kelurahan = Kelurahan::where('kecamatan_id', $data->kec_id)->get();
        return view('pages.disabilitas.update', compact('data','kecamatan','kelurahan'));
    }

    public function update(Request $request, $id){
        $warga = Warga::findOrFail($id);

        $request->validate([
            'nik' => 'required|unique:warga,nik,' . $id,
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
