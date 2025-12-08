<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tecnicos extends Model
{
   use HasFactory;
   
    protected $table = 'tecnicos';
    protected $primaryKey = 'id_tec';
    public $incrementing = true;
    protected $fillable = ['nombre','clave'];
    
}
