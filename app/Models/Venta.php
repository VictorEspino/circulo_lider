<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;

    protected $fillable=[
                    'tipo',
                    'sucursal',
                    'ejecutivo',
                    'fecha',
                    'plan',
                    'renta',
                    'plazo',
                    'propiedad',
                    'imei',
                    'iccid',
                    'dn',
                    'cliente',
                    'co_id',
                    'mail_cliente',
                    'addon_control',
                    'seguro_proteccion',
                    'observaciones'
                ];
}
