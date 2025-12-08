<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Meses extends Model
{
    use HasFactory;

    protected $table = 'meses'; // Asegúrate de que el nombre coincida con tu tabla
    protected $primaryKey = 'id_mes';
    public $incrementing = true;
    protected $fillable = ['fecha_I', 'fecha_f', 'id_empresa']; // Ajusta según tus columnas reales

    // Relación inversa: un mes pertenece a una empresa
    public function empresa()
    {
        return $this->belongsTo(Empresas::class, 'id_empresa');
    }

    // Relación: un mes tiene muchos servicios
    // public function servicios()
    // {
    //     return $this->hasMany(Servicio::class, 'id_mes');
    // }
}
