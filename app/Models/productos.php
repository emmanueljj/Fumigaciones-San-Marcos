<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class productos extends Model
{
    protected $table = 'productos';
    protected $primaryKey = 'id_pr';
    public $incrementing = true;
    protected $fillable = ['nombre','concentracion','metodo','plaga'];
    
}
