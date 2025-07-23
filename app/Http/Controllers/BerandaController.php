<?php

namespace App\Http\Controllers;

use App\Models\Warga;
use Illuminate\Http\Request;

class BerandaController extends Controller
{
    function index(){

        $jmlYatim = Warga::where('kategori','Yatim')->count();
        $jmlDisabilitas = Warga::where('kategori','Disabilitas')->count();
        $jmlLansia = Warga::where('kategori','Lansia')->count();

        $tahunList = Warga::selectRaw('YEAR(created_at) as tahun')
                ->groupBy('tahun')
                ->orderBy('tahun', 'asc')
                ->pluck('tahun');

        $dataYatim = [];
        $dataLansia = [];
        $dataDisabilitas = [];

        foreach ($tahunList as $tahun) {
            $dataYatim[] = Warga::where('kategori', 'Yatim')->whereYear('created_at', $tahun)->count();
            $dataLansia[] = Warga::where('kategori', 'Lansia')->whereYear('created_at', $tahun)->count();
            $dataDisabilitas[] = Warga::where('kategori', 'Disabilitas')->whereYear('created_at', $tahun)->count();
        }

        return view('pages.home', compact('jmlYatim', 'jmlDisabilitas', 'jmlLansia', 'dataYatim', 'dataLansia', 'dataDisabilitas', 'tahunList'));
    }
}
