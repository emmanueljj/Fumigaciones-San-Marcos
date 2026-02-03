<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Empresas extends Model
{
    use HasFactory;

    protected $table = 'empresas';
    protected $primaryKey = 'id_empresa';
    protected $fillable = ['nombre', 'encargado', 'foto', 'ubicacion', 'calendario', 'esquemas', 'especificaciones', 'correo'];

    // Relación: Una empresa tiene muchos meses (1 a Muchos)
    public function meses()
    {
        return $this->hasMany(Meses::class, 'id_empresa');
    }

    // RELACIÓN ESPECIAL: Acceder a los servicios directamente
    // "Tengo muchos Servicios a través de la tabla Meses"
    public function servicios()
    {
        return $this->hasManyThrough(
            Servicio::class, 
            Meses::class, 
            'id_empresa', // FK en la tabla meses
            'id_mes',     // FK en la tabla servicios
            'id_empresa', // Local key en empresas
            'id_mes'      // Local key en meses
        );
    }
}