<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    protected $table = 'servicios';
    protected $primaryKey = 'id_servicio';
    protected $fillable = ['fecha', 'id_mes', 'observacion', 'controlPerimetral'];

    // Relación Muchos a Muchos con Productos
    public function productos()
    {
        return $this->belongsToMany(
            productos::class,       // Modelo relacionado
            'producto_servicio',   // Tabla pivot
            'servicio_id',         // FK en pivot hacia servicios
            'producto_id'          // FK en pivot hacia productos
        );
    }

    // Relación Muchos a Muchos con Técnicos
    public function tecnicos()
    {
        return $this->belongsToMany(
            tecnicos::class,        // Modelo relacionado
            'servicio_tecnico',    // Tabla pivot
            'servicio_id',         // FK en pivot hacia servicios
            'tecnico_id'           // FK en pivot hacia tecnicos
        );
    }

    // Relación inversa: Un servicio pertenece a un mes
    public function mes()
    {
        return $this->belongsTo(Meses::class, 'id_mes');
    }
}
