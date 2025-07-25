<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warga extends Model
{
    use HasFactory;
    protected $table = 'warga';
    protected $guarded = ['id'];

    public function kecamatan(){
        return $this->belongsTo(Kecamatan::class, 'kec_id');
    }

    public function kelurahan(){
        return $this->belongsTo(Kelurahan::class, 'kel_id');
    }
}
