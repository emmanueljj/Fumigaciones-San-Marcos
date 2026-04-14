<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. TABLAS BASE
        Schema::create('empresas', function (Blueprint $table) {
            $table->id('id_empresa');
            $table->string('nombre');
            $table->string('encargado');
            $table->string('correo')->unique();
            $table->string('ubicacion')->nullable();
            $table->string('foto')->nullable();
            $table->string('calendario')->nullable();
            $table->json('esquemas')->nullable();
            $table->string('especificaciones')->nullable();
            $table->timestamps();
        });

        Schema::create('productos', function (Blueprint $table) {
            $table->id('id_pr');
            $table->string('nombre');
            $table->string('concentracion');
            $table->json('fichaTecnica')->nullable();
            $table->timestamps();
        });

        Schema::create('tecnicos', function (Blueprint $table) {
            $table->id('id_tec');
            $table->string('nombre');
            $table->string('clave');
            $table->timestamps();
        });

        // 2. NIVEL 1
        Schema::create('meses', function (Blueprint $table) {
            $table->id('id_mes');
            $table->date('fecha_I');
            $table->date('fecha_f');
            $table->unsignedBigInteger('id_empresa');
            $table->foreign('id_empresa')->references('id_empresa')->on('empresas')->onDelete('cascade');
            $table->timestamps();
        });

        // 3. NIVEL 2: SERVICIOS (LIMPIA)
        Schema::create('servicios', function (Blueprint $table) {
            $table->id('id_servicio');
            $table->date('fecha');
            $table->unsignedBigInteger('id_mes');
            $table->foreign('id_mes')->references('id_mes')->on('meses')->onDelete('cascade');
            $table->text('observacion')->nullable();
            $table->json('controlPerimetral')->nullable();
            $table->timestamps();
        });

        // 4. NIVEL 3: ACTIVIDADES
        Schema::create('actividades', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->time('hora');
            $table->string('area');
            $table->string('vbNombre');
            $table->string('vbFirma');
            $table->string('foto')->nullable();
            $table->unsignedBigInteger('id_servicio')->nullable();
            $table->foreign('id_servicio')->references('id_servicio')->on('servicios')->onDelete('set null');
            $table->timestamps();
        });

        // 5. TABLAS PIVOT (MUCHOS A MUCHOS)
        
        // Relación Servicios <-> Productos
        Schema::create('producto_servicio', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('servicio_id');
            $table->unsignedBigInteger('producto_id');
            $table->foreign('servicio_id')->references('id_servicio')->on('servicios')->onDelete('cascade');
            $table->foreign('producto_id')->references('id_pr')->on('productos')->onDelete('cascade');
            $table->timestamps();
        });

        // Relación Servicios <-> Técnicos (NUEVA)
        Schema::create('servicio_tecnico', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('servicio_id');
            $table->unsignedBigInteger('tecnico_id');
            $table->foreign('servicio_id')->references('id_servicio')->on('servicios')->onDelete('cascade');
            $table->foreign('tecnico_id')->references('id_tec')->on('tecnicos')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        // El orden inverso es vital
        Schema::dropIfExists('servicio_tecnico');
        Schema::dropIfExists('producto_servicio');
        Schema::dropIfExists('actividades');
        Schema::dropIfExists('servicios');
        Schema::dropIfExists('meses');
        Schema::dropIfExists('tecnicos');
        Schema::dropIfExists('productos');
        Schema::dropIfExists('empresas');
    }
};