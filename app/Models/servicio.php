<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class servicio extends Model
{

    protected $table = 'servicios';
    protected $primaryKey = 'id_servicio';
    public $incrementing = true;
    protected $fillable = ['fecha', 'vb_nombre', 'vb_firma','id_mes'];

//relacion un servicio pertenecea un mes
    public function mes()
    {
        return $this->belongsTo(Meses::class, 'id_mes');
    }
//relacion un servicio tiene varias actividades
    public function actividades()
    {
        return $this->hasMany(actividades::class, 'id');
    }
}
