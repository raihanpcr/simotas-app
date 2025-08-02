<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Warga;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class YatimController extends Controller
{
    public function index(Request $request)
    {   

        if (Auth::user()->role == "super_admin" || Auth::user()->role == "kepala_dinas") {
            $query = Warga::with('kecamatan')->where('kategori', 'Yatim');

         }elseif (Auth::user()->role == "kepala_desa") {

            // kalau login kepala_desa
            $kelurahan = Auth::user()->kelurahan_id;
            $query = Warga::with('kecamatan')
                    ->where('kategori', 'Yatim')
                    ->where('kel_id', $kelurahan);
        };

        if ($request->has('search') && $request->search != '') {
            $query->where('nik','like', '%' . $request->search . '%');
        }

        $datas = $query->orderBy('created_at', 'desc')->paginate(10)->appends($request->only('search'));

        return view('pages.yatim.data', compact('datas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategori = "Yatim";
        $kecamatan = Kecamatan::all();
        return view('pages.yatim.add', compact('kategori','kecamatan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $role = Auth::user()->role;
        
        if ($role == "super_admin") {
            $status = "accept";
        }else{
            $status = "waiting";
        }
        //validation input
        $request->validate([
            'nik' => 'required|max:16',
            'name' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required',
        ]);

        //create database
        Warga::create([
            'nik' => $request->nik,
            'name' => $request->name,
            'place_of_birth' => $request->tempat_lahir,
            'date_of_birth' => $request->tanggal_lahir,
            'kec_id' => $request->kecamatan_id,
            'kel_id' => $request->kelurahan_id,
            'umur' => Carbon::parse($request->tanggal_lahir)->age,
            'alamat' => $request->alamat,
            'kategori' => "Yatim",
            'status' => $status
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
        $kecamatan = Kecamatan::all();
        $kelurahan = Kelurahan::where('kecamatan_id', $data->kec_id)->get();
        return view('pages.yatim.update', compact('data','kecamatan','kelurahan'));
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
            'kec_id' => $request->kecamatan_id,
            'kel_id' => $request->kelurahan_id,
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
