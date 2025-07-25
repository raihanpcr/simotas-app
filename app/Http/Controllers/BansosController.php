<?php

namespace App\Http\Controllers;

use App\Models\Bansos;
use App\Models\Kecamatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BansosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   
        if (Auth::user()->role == "super_admin" || Auth::user()->role == "kepala_dinas") {
            $datas = Bansos::with('kecamatan')->orderBy('created_at', 'desc')->paginate(5);

        }
        // else if (Auth::user()->role == "kepala_dinas") {

        //     // kalau login kepala dinas
        //     $kecamatan = Auth::user()->kecamatan_id;
        //     $datas = Bansos::with('kecamatan')->where('kecamatan_id', $kecamatan)->orderBy('created_at', 'desc')->paginate(5);

        // }
        elseif (Auth::user()->role == "kepala_desa") {

            // kalau login kepala_desa
            $kelurahan = Auth::user()->kelurahan_id;
            $datas = Bansos::with('kecamatan')->where('kelurahan_id', $kelurahan)->orderBy('created_at', 'desc')->paginate(5);
        };
        
        return view('pages.bansos.data', compact('datas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kecamatan = Kecamatan::all();
        return view('pages.bansos.add', compact('kecamatan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kecamatan_id' => 'required',
            'kelurahan_id' => 'required',
            'alamat' => 'required',
            'link_google_map' => 'required',
        ]);

        Bansos::create([
            'kecamatan_id' => $request->kecamatan_id,
            'kelurahan_id' => $request->kelurahan_id,
            'alamat' => $request->alamat,
            'link_map' => $request->link_google_map
        ]);

        return redirect()->route('bansos.index')->with('success', 'Data berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $data = Bansos::findOrFail($id);
        return view('pages.bansos.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id){
        $data = Bansos::findOrFail($id);
        $kecamatan = Kecamatan::all();
        return view('pages.bansos.update', compact('data', 'kecamatan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $data = Bansos::findOrFail($id);

        $request->validate([
            'kecamatan_id' => 'required',
            'kelurahan_id' => 'required',
            'alamat' => 'required',
            'link_google_map' => 'required',
        ]);

        $data->update([
            'kecamatan_id' => $request->kecamatan_id,
            'kelurahan_id' => $request->kelurahan_id,
            'alamat' => $request->alamat,
            'link_map' => $request->link_google_map
        ]);

        return redirect()->route('bansos.index')->with('success', 'Data berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = Bansos::findOrFail($id);
        $data->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus.');
    }
}
