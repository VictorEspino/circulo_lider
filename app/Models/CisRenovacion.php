<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CisRenovacion extends Model
{
    use HasFactory;
    protected $fillable=[
                    'no_contrato_impreso',
                    'id_orden_renovacion',
                    'cuenta_cliente',
                    'status_renovacion',
                    'fecha_status',
                    'id_ejecutivo',
                    'nombre_ejecutivo',
                    'co_id',
                    'fecha_activacion_contrato',
                    'new_sim',
                    'modelo_nuevo',
                    'plan_actual',
                    'renta_actual',
                    'plazo_actual',
                    'dn_actual',
                    'propiedad',
                    'carga_id',
                    'user_id'
    ];
}
