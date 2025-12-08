<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class servicio extends Model
{
    public function mes()
{
    return $this->belongsTo(Mes::class, 'id_mes');
}
}
