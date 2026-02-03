<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class actividades extends Model
{
    protected $table = 'actividades';
    protected $fillable = [
        'nombre', 
        'hora', 
        'area', 
        'vbNombre', 
        'vbFirma', 
        'foto', 
        'id_servicio'
    ];

    // Relación: Una actividad pertenece a un servicio
    public function servicio()
    {
        return $this->belongsTo(servicio::class, 'id_servicio');
    }
}