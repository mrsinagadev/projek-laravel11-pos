<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // field yang tidak boleh di-isi
    protected $guarded = [];

    // relasi antara kategori dengan user (inverse)
    public function user(){
        return $this->belongsTo(User::class);
    }
}
