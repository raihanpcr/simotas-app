<?php

namespace App\Http\Controllers;

use App\Models\Warga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BerandaController extends Controller
{
    public function index(Request $request)
    {
        $selectedYear = $request->input('tahun', now()->year); // default tahun sekarang

        $jmlYatimWating = 0;
        $jmlDisabilitasWating = 0;
        $jmlLansiaWating = 0;

        $dataYatim = [];
        $dataLansia = [];
        $dataDisabilitas = [];

        $bulanLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

        // Buat struktur default per bulan
        $dataYatimPerBulan = array_fill_keys($bulanLabels, 0);
        $dataLansiaPerBulan = array_fill_keys($bulanLabels, 0);
        $dataDisabilitasPerBulan = array_fill_keys($bulanLabels, 0);

        $kategoriList = ['Yatim', 'Lansia', 'Disabilitas'];

        if (Auth::user()->role == "super_admin" || Auth::user()->role == "kepala_dinas") {

            // Total data
            $jmlYatim = Warga::where('kategori', 'Yatim')->count();
            $jmlDisabilitas = Warga::where('kategori', 'Disabilitas')->count();
            $jmlLansia = Warga::where('kategori', 'Lansia')->count();

            // Waiting data (khusus super admin)
            $jmlYatimWating = Warga::where('kategori', 'Yatim')->where('status', 'waiting')->count();
            $jmlDisabilitasWating = Warga::where('kategori', 'Disabilitas')->where('status', 'waiting')->count();
            $jmlLansiaWating = Warga::where('kategori', 'Lansia')->where('status', 'waiting')->count();

            // List tahun
            $tahunList = Warga::selectRaw('YEAR(created_at) as tahun')
                ->groupBy('tahun')
                ->orderBy('tahun', 'asc')
                ->pluck('tahun');

            // Data tahunan (per kategori)
            foreach ($tahunList as $tahun) {
                $dataYatim[] = Warga::where('kategori', 'Yatim')->whereYear('created_at', $tahun)->count();
                $dataLansia[] = Warga::where('kategori', 'Lansia')->whereYear('created_at', $tahun)->count();
                $dataDisabilitas[] = Warga::where('kategori', 'Disabilitas')->whereYear('created_at', $tahun)->count();
            }

            // Data bulanan (per kategori di tahun terpilih)
            foreach ($kategoriList as $kategori) {
                $results = Warga::selectRaw('MONTH(created_at) as bulan, COUNT(*) as total')
                    ->where('kategori', $kategori)
                    ->whereYear('created_at', $selectedYear)
                    ->groupBy('bulan')
                    ->get();

                foreach ($results as $row) {
                    $namaBulan = $bulanLabels[$row->bulan - 1];
                    ${"data" . $kategori . "PerBulan"}[$namaBulan] = $row->total;
                }
            }

        } elseif (Auth::user()->role == "kepala_desa") {

            $kelurahan = Auth::user()->kelurahan_id;

            // Total data
            $jmlYatim = Warga::where('kategori', 'Yatim')->where('kel_id', $kelurahan)->count();
            $jmlDisabilitas = Warga::where('kategori', 'Disabilitas')->where('kel_id', $kelurahan)->count();
            $jmlLansia = Warga::where('kategori', 'Lansia')->where('kel_id', $kelurahan)->count();

            // List tahun
            $tahunList = Warga::selectRaw('YEAR(created_at) as tahun')
                ->where('kel_id', $kelurahan)
                ->groupBy('tahun')
                ->orderBy('tahun', 'asc')
                ->pluck('tahun');

            // Data tahunan
            foreach ($tahunList as $tahun) {
                $dataYatim[] = Warga::where('kategori', 'Yatim')->where('kel_id', $kelurahan)->whereYear('created_at', $tahun)->count();
                $dataLansia[] = Warga::where('kategori', 'Lansia')->where('kel_id', $kelurahan)->whereYear('created_at', $tahun)->count();
                $dataDisabilitas[] = Warga::where('kategori', 'Disabilitas')->where('kel_id', $kelurahan)->whereYear('created_at', $tahun)->count();
            }

            // Data bulanan
            foreach ($kategoriList as $kategori) {
                $results = Warga::selectRaw('MONTH(created_at) as bulan, COUNT(*) as total')
                    ->where('kategori', $kategori)
                    ->where('kel_id', $kelurahan)
                    ->whereYear('created_at', $selectedYear)
                    ->groupBy('bulan')
                    ->get();

                foreach ($results as $row) {
                    $namaBulan = $bulanLabels[$row->bulan - 1];
                    ${"data" . $kategori . "PerBulan"}[$namaBulan] = $row->total;
                }
            }
        }

        return view('pages.home', compact(
            'jmlYatim', 'jmlDisabilitas', 'jmlLansia',
            'dataYatim', 'dataLansia', 'dataDisabilitas',
            'tahunList', 'selectedYear',
            'jmlYatimWating', 'jmlDisabilitasWating', 'jmlLansiaWating',
            'dataYatimPerBulan', 'dataLansiaPerBulan', 'dataDisabilitasPerBulan'
        ));
    }
}
