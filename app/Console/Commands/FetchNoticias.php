<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use App\Models\Noticias;
use \DateTime;
use \DateTimeZone;
class FetchNoticias extends Command
{
    
    protected $signature = 'fetch_noticias';
    
    protected $description = 'Command description';
    
    /*public function __construct()
    {
        parent::__construct();
    }*/

    public function handle()
    {
        $datos = [];
        $id_categoria = 0;
        $fecha_actual = date('Y-m-d');
        $categorias = ['musica','bitcoin','cripto','economia','medicina','enfermedades','deporte','tecnologia','hacker','wifi'];
        foreach($categorias as $index => $categoria) {
            if($index >= 0 && $index <= 3){
                $id_categoria = 1;
            }
            else if($index >= 4 && $index <= 5){
                $id_categoria = 2;
            }
            else if($index == 6){
                $id_categoria = 3;
            }
            else if($index >= 7 && $index <= 8){
                $id_categoria = 4;
            }

            $noticias = FetchNoticias::obtener_noticias($categoria,$fecha_actual,$fecha_actual);
            $noticias = json_decode($noticias);
            $articulos = $noticias->articles;
            foreach($articulos as $noticia){
                $datetime = str_replace('Z',' ',str_replace('T',' ',$noticia->publishedAt));
                $datos['id_categoria'] = $id_categoria;
                $datos['source'] = $noticia->source->name;
                $datos['autor'] = $noticia->author;
                $datos['titulo'] = $noticia->title;
                $datos['descripcion'] = $noticia->description;
                $datos['url'] = $noticia->url;
                $datos['imagen'] = $noticia->urlToImage;
                $datos['fecha_publicado_utc'] = $datetime;
                $datos['fecha_publicado'] = FetchNoticias::convertir_datetime_a_spain($datetime);
                $datos['contenido'] = $noticia->content;
                Noticias::agregar_noticia($datos);
                $this->info('noticia '.serialize($noticia->title));
                $this->info('======================================================================');
                sleep(1);
            }
        }
        return 0;
    }

    public function obtener_noticias($categoria,$fecha_desde,$fecha_hasta){
        $response = Http::get(Config('app.newsapi'), [
            'q' => $categoria,
            'sortBy' => 'popularity',
            'apiKey' => Config::get('app.apikey'),
            'language' => 'es',
            'searchIn' => 'title,content,description',
            //'from' => $fecha_desde,
            //'to' => $fecha_hasta,
        ]);
        return $response;
    }

    public function convertir_datetime_a_spain($datetime){
        $dt = new DateTime($datetime, new DateTimeZone('UTC'));
        $dt->setTimezone(new DateTimeZone('Europe/Madrid'));
        return $dt->format('Y-m-d H:i:s');
    }
}
