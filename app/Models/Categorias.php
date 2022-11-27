<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categorias extends Model
{
    use HasFactory;
    protected $fillable = [
        'nombre',
    ];

    public function noticias(){
        return $this->hasMany('App\Models\Noticias','id_categoria','id');
    }

}
