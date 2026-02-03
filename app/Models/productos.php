<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class productos extends Model
{
    protected $table = 'productos';
    protected $primaryKey = 'id_pr';
    protected $fillable = ['nombre', 'concentracion', 'fichaTecnica'];

    public function servicios()
    {
        return $this->belongsToMany(
            Servicio::class, 
            'producto_servicio', 
            'producto_id', 
            'servicio_id'
        );
    }
}
