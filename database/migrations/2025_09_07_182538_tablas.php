<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
         // Tabla: empresas
        Schema::create('empresas', function (Blueprint $table) {
            $table->id('id_empresa');
            $table->string('nombre');
            $table->string('encargado');
            $table->string('foto')->nullable(); // ← nueva columna
            $table->timestamps();
        });

        // Tabla: meses
        Schema::create('meses', function (Blueprint $table) {
            $table->id('id_mes');
            $table->date('fecha_I');
            $table->date('fecha_f');
            $table->unsignedBigInteger('id_empresa');
            $table->foreign('id_empresa')->references('id_empresa')->on('empresas')->onDelete('cascade');
            $table->timestamps();
        });

        // Tabla: servicios
        Schema::create('servicios', function (Blueprint $table) {
            $table->id('id_servicio');
            $table->date('fecha');
            $table->string('vb_nombre');
            $table->string('vb_firma');
            $table->unsignedBigInteger('id_mes');
            $table->foreign('id_mes')->references('id_mes')->on('meses')->onDelete('cascade');
            $table->timestamps();
        });

        // Tabla: productos
        Schema::create('productos', function (Blueprint $table) {
            $table->id('id_pr')->autoIncrement();
            $table->string('nombre');
            $table->string('concentracion');
            $table->string('metodo');
            $table->string('plaga');
            $table->timestamps();
        });

        // Tabla: tecnicos
        Schema::create('tecnicos', function (Blueprint $table) {
            $table->id('id_tec');
            $table->string('nombre');
            $table->string('clave');
            $table->timestamps();
        });

        // Tabla: actividades
        Schema::create('actividades', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->time('hora');
            $table->string('area');
            $table->text('observacion')->nullable();
            $table->string('foto')->nullable();

            // Claves foráneas a productos
            $table->unsignedBigInteger('pr1')->nullable();
            $table->unsignedBigInteger('pr2')->nullable();
            $table->unsignedBigInteger('pr3')->nullable();
            $table->unsignedBigInteger('pr4')->nullable();
            $table->foreign('pr1')->references('id_pr')->on('productos')->onDelete('set null');
            $table->foreign('pr2')->references('id_pr')->on('productos')->onDelete('set null');
            $table->foreign('pr3')->references('id_pr')->on('productos')->onDelete('set null');
            $table->foreign('pr4')->references('id_pr')->on('productos')->onDelete('set null');

            // Claves foráneas a técnicos
            $table->unsignedBigInteger('tecnico1')->nullable();
            $table->unsignedBigInteger('tecnico2')->nullable();
            $table->unsignedBigInteger('tecnico3')->nullable();
            $table->foreign('tecnico1')->references('id_tec')->on('tecnicos')->onDelete('set null');
            $table->foreign('tecnico2')->references('id_tec')->on('tecnicos')->onDelete('set null');
            $table->foreign('tecnico3')->references('id_tec')->on('tecnicos')->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('actividades');
        Schema::dropIfExists('tecnicos');
        Schema::dropIfExists('productos');
        Schema::dropIfExists('servicios');
        Schema::dropIfExists('meses');
        Schema::dropIfExists('empresas');
    }
};
