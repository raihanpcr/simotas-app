<?php

namespace App\Http\Controllers;

use App\Models\Warga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BerandaController extends Controller
{
    function index(){

        $jmlYatimWating = 0;
        $jmlDisabilitasWating = 0;
        $jmlLansiaWating = 0 ;

        $dataYatim = [];
        $dataLansia = [];
        $dataDisabilitas = [];

        if (Auth::user()->role == "super_admin") {
            
            $jmlYatim = Warga::where('kategori','Yatim')->count();
            $jmlDisabilitas = Warga::where('kategori','Disabilitas')->count();
            $jmlLansia = Warga::where('kategori','Lansia')->count();

            $jmlYatimWating = Warga::where('kategori','Yatim')->where('status','waiting')->count();
            $jmlDisabilitasWating = Warga::where('kategori','Disabilitas')->where('status','waiting')->count();
            $jmlLansiaWating = Warga::where('kategori','Lansia')->where('status','waiting')->count();

            $tahunList = Warga::selectRaw('YEAR(created_at) as tahun')
                    ->groupBy('tahun')
                    ->orderBy('tahun', 'asc')
                    ->pluck('tahun');

            

            foreach ($tahunList as $tahun) {
                $dataYatim[] = Warga::where('kategori', 'Yatim')->whereYear('created_at', $tahun)->count();
                $dataLansia[] = Warga::where('kategori', 'Lansia')->whereYear('created_at', $tahun)->count();
                $dataDisabilitas[] = Warga::where('kategori', 'Disabilitas')->whereYear('created_at', $tahun)->count();
            }

        }else if (Auth::user()->role == "kepala_dinas") {

            $kecamatan = Auth::user()->kecamatan_id;

            $jmlYatim = Warga::where('kategori','Yatim')->where('kec_id', $kecamatan)->count();
            $jmlDisabilitas = Warga::where('kategori','Disabilitas')->where('kec_id', $kecamatan)->count();
            $jmlLansia = Warga::where('kategori','Lansia')->where('kec_id', $kecamatan)->count();

            $tahunList = Warga::selectRaw('YEAR(created_at) as tahun')
                    ->groupBy('tahun')
                    ->orderBy('tahun', 'asc')
                    ->pluck('tahun');

            foreach ($tahunList as $tahun) {
                $dataYatim[] = Warga::where('kategori', 'Yatim')->where('kec_id', $kecamatan)->whereYear('created_at', $tahun)->count();
                $dataLansia[] = Warga::where('kategori', 'Lansia')->where('kec_id', $kecamatan)->whereYear('created_at', $tahun)->count();
                $dataDisabilitas[] = Warga::where('kategori', 'Disabilitas')->where('kec_id', $kecamatan)->whereYear('created_at', $tahun)->count();
            }
            

        }elseif (Auth::user()->role == "kepala_desa") {

            // kalau login kepala_desa
            $kelurahan = Auth::user()->kelurahan_id;

            $jmlYatim = Warga::where('kategori','Yatim')->where('kel_id', $kelurahan)->count();
            $jmlDisabilitas = Warga::where('kategori','Disabilitas')->where('kel_id', $kelurahan)->count();
            $jmlLansia = Warga::where('kategori','Lansia')->where('kel_id', $kelurahan)->count();

            $tahunList = Warga::selectRaw('YEAR(created_at) as tahun')
                    ->groupBy('tahun')
                    ->orderBy('tahun', 'asc')
                    ->pluck('tahun');

            foreach ($tahunList as $tahun) {
                $dataYatim[] = Warga::where('kategori', 'Yatim')->where('kel_id', $kelurahan)->whereYear('created_at', $tahun)->count();
                $dataLansia[] = Warga::where('kategori', 'Lansia')->where('kel_id', $kelurahan)->whereYear('created_at', $tahun)->count();
                $dataDisabilitas[] = Warga::where('kategori', 'Disabilitas')->where('kel_id', $kelurahan)->whereYear('created_at', $tahun)->count();
            }
        };        

        return view('pages.home', compact('jmlYatim', 'jmlDisabilitas', 'jmlLansia', 'dataYatim', 'dataLansia', 'dataDisabilitas', 'tahunList', 'jmlYatimWating', 'jmlDisabilitasWating', 'jmlLansiaWating'));
    }
}
