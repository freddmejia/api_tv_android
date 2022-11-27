<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNoticiasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('noticias', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_categoria');
            $table->text('source')->nullable();
            $table->string('autor')->nullable();
            $table->text('titulo');
            $table->text('descripcion')->nullable();
            $table->text('url')->nullable();
            $table->text('imagen')->nullable();
            $table->string('fecha_publicado_utc');
            $table->string('fecha_publicado');
            $table->text('contenido');
            $table->foreign('id_categoria')->references('id')->on('categorias');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('noticias');
    }
}
