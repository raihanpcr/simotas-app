<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bansos extends Model
{
    use HasFactory;
    protected $table = 'bansos';
    protected $guarded = ['id'];

    public function kecamatan(){
        return $this->belongsTo(Kecamatan::class, 'kecamatan_id');
    }

    public function kelurahan(){
        return $this->belongsTo(Kelurahan::class, 'kelurahan_id');
    }
}
