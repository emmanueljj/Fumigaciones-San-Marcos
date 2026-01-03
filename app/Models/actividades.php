<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\servicio;
use App\Models\tecnicos;

class actividades extends Model
{
    use HasFactory;
    protected $table = 'actividades'; // Asegúrate de que el nombre coincida con tu tabla
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $fillable = [
        'nombre',
        'hora',
        'area',
        'observacion',
        'foto',
        'id_servicio',
        'pr1',
        'pr2',
        'pr3',
        'pr4',
        'tecnico1',
        'tecnico2',
        'tecnico3',
    ];

    // Relación inversa: un mes pertenece a una empresa
    public function servicio()
    {
        return $this->belongsTo(servicio::class, 'id_servicio');
    }
    // relaciones de tecnicos
    public function relTecnico1() {
        return $this->belongsTo(tecnicos::class, 'tecnico1', 'id_tec');
    }

    public function relTecnico2() {
        return $this->belongsTo(tecnicos::class, 'tecnico2', 'id_tec');
    }

    public function relTecnico3() {
        return $this->belongsTo(tecnicos::class, 'tecnico3', 'id_tec');
    }
    // relaciones de productos
        public function relPr1() {
        return $this->belongsTo(productos::class, 'pr1', 'id_pr');
    }

    public function relPr2() {
        return $this->belongsTo(productos::class, 'pr2', 'id_pr');
    }

    public function relPr3() {
        return $this->belongsTo(productos::class, 'pr3', 'id_pr');
    }
    
    public function relPr4() {
        return $this->belongsTo(productos::class, 'pr4', 'id_pr');
    }
}
