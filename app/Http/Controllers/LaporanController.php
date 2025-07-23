<?php

namespace App\Http\Controllers;

use App\Models\Warga;
use App\Models\Kecamatan;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
      public function index()
      {     
            $kecamatan = Kecamatan::all();
            return view('pages.report.data', compact('kecamatan'));
      }

      public function exportCsv(Request $request){
            $query = Warga::with('kecamatan');

            if ($request->filled('tahun')) {
                  $query->whereYear('created_at', $request->tahun);
            }

            if ($request->filled('kategori')) {
                  $query->where('kategori', $request->kategori);
            }

            if ($request->filled('kecamatan')) {
                  $query->where('kec_id', $request->kecamatan);
            }

            if ($request->filled('kelurahan_id')) {
                  $query->where('kel_id', $request->kelurahan_id);
            }

            $wargas = $query->get();

            $headers = [
                  'Content-Type' => 'text/csv',
                  'Content-Disposition' => 'attachment; filename="laporan_warga.csv"',
            ];

            $callback = function () use ($wargas) {
                  $file = fopen('php://output', 'w');

                  // Baris judul kolom
                  fputcsv($file, ['NIK', 'Nama', 'Tempat Lahir', 'Tanggal Lahir', 'Umur', 'Alamat']);

                  // Baris data
                  foreach ($wargas as $warga) {
                        fputcsv($file, [
                              $warga->nik,
                              $warga->name,
                              $warga->place_of_birth,
                              $warga->date_of_birth,
                              $warga->umur,
                              $warga->alamat,
                        ]);
                  }

                  fclose($file);
            };

            return response()->stream($callback, 200, $headers);
      }
}
