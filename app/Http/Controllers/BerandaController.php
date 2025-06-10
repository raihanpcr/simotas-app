<?php

namespace App\Http\Controllers;

use App\Models\Warga;
use Illuminate\Http\Request;

class BerandaController extends Controller
{
    function index(){

        $yatim = Warga::where('kategori','Disabilitas')->get();

        return view('pages.home');
    }
}
