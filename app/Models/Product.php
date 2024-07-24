<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $guarded = [];

    //relasi ke tabel user
    public function user(){
        return $this->belongsTo(User::class);
    }

    //relasi ke tabel kategori
    public function category(){
        return $this->belongsTo(Category::class);
    }
}
