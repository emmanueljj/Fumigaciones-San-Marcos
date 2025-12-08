<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Empresas extends Model
{
    use HasFactory;

    protected $table = 'empresas';
    protected $primaryKey = 'id_empresa';
    public $incrementing = true;
    protected $fillable = ['nombre', 'encargado', 'foto'];

    // Relación: una empresa tiene muchos meses
    public function meses()
    {
        return $this->hasMany(Meses::class, 'id_empresa');
    }

    // Relación: una empresa tiene muchos servicios a través de meses
    public function servicios()
    {
        return $this->hasManyThrough(
            Servicio::class,
            'id_empresa', // Foreign key en Mes
            'id_mes',     // Foreign key en Servicio
            'id_empresa', // Local key en Empresa
            'id_mes'      // Local key en Mes
        );
    }
}
