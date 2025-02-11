<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlantasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plantas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('FechaRecoleccion');
            $table->string('FechaFotografia');
            $table->string('NombreRecolectorDatos');
            $table->string('NombreRecolectorMuestra');
            $table->string('NombreAutorFoto');
            $table->string('urlImg');
            $table->string('MotivoRechazo')->nullable();
            $table->unsignedBigInteger('imagenes')->nullable();
            $table->boolean('Verificado')->nullable();
            $table->string('NomVerificador')->nullable();

            $table->unsignedBigInteger('nombre_ejem_id')->nullable();

            $table->foreign('nombre_ejem_id')
                ->references('id')
                ->on('nombre_ejemplars')
                ->onDelete('cascade');

            $table->unsignedBigInteger('Morfologia_id')->nullable();

            $table->foreign('Morfologia_id')
                ->references('id')
                ->on('morfologias')
                ->onDelete('cascade');

            $table->unsignedBigInteger('situacion_entornos_id')->nullable();

            $table->foreign('situacion_entornos_id')
                ->references('id')
                ->on('situacion_entornos')
                ->onDelete('cascade');
            $table->unsignedBigInteger('user_id')->nullable();
            
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

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
        Schema::dropIfExists('plantas');
    }
}
