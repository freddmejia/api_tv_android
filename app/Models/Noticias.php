<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use function PHPUnit\Framework\isEmpty;

class Noticias extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_categoria','source','autor','titulo','descripcion',
        'url','imagen','fecha_publicado_utc','fecha_publicado','contenido',
    ];
    public function categoria(){
        return $this->belongsTo('App\Models\Categorias','id_categoria','id');
    }

    public static function agregar_noticia($datos) {
        $id_categoria = intval($datos['id_categoria']);
        $empty = Noticias::where('titulo',$datos['titulo'])->where('id_categoria',$id_categoria)->get()->first();
        if(empty($empty)){
            $nueva_noticia = new Noticias();
            $nueva_noticia->id_categoria = $id_categoria;
            $nueva_noticia->source = $datos['source'];
            $nueva_noticia->autor = $datos['autor'];
            $nueva_noticia->titulo = $datos['titulo'];
            $nueva_noticia->descripcion = $datos['descripcion'];
            $nueva_noticia->url = $datos['url'];
            $nueva_noticia->imagen = $datos['imagen'];
            $nueva_noticia->fecha_publicado_utc = $datos['fecha_publicado_utc'];
            $nueva_noticia->fecha_publicado = $datos['fecha_publicado'];
            $nueva_noticia->contenido = $datos['contenido'];
            $nueva_noticia->save();
        }
    }
}
