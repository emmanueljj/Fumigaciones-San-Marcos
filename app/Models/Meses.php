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

    public function relEmpresa()
    {
        return $this->belongsTo(Empresas::class, 'id_empresa');
    }

    public function servicios()
    {
        return $this->hasMany(Servicio::class, 'id_mes');
    }
    
    public function actividades() {
        return $this->hasMany(actividades::class, 'id_servicio');
    }

    public function empresa()
    {
        // El segundo parámetro es la llave foránea en tu tabla 'meses'
        return $this->belongsTo(Empresas::class, 'id_empresa');
    }

}
