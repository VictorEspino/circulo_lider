<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicionGerente extends Model
{
    use HasFactory;

    protected $fillable=[
        'calculo_id',
        'area',
        'sub_area',
        'gerente_id',
        'cuota_ventas',
        'ventas',
        'cuota',
        'factor',
        'plantilla_autorizada',
        'ejecutivos_activos',
        'ejecutivos_productivos'
    ];
}
