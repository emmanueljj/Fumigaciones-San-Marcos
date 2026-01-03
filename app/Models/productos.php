<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class productos extends Model
{
    use HasFactory;
    protected $table = 'productos';
    protected $primaryKey = 'id_pr';
    public $incrementing = true;
    protected $fillable = ['nombre','concentracion','metodo','plaga'];
    
}
