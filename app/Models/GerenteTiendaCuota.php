<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GerenteTiendaCuota extends Model
{
    use HasFactory;

    protected $fillable=['periodo_id','gerente_id','area','sub_area','cuota_ventas'];

    public function gerente()
    {
        return $this->belongsTo(User::class,'gerente_id');
    }
    public function tienda()
    {
        return $this->belongsTo(SubArea::class,'sub_area');
    }
}
