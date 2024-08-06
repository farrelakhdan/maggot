<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;
    protected $table = 'produk';
    protected $fillable = ['UID_Produk', 'Nama', 'Deskripsi', 'Gambar', 'Harga', 'created_at', 'updated_at'];
    protected $hidden = [
        'ID_Produk',
    ];
}
