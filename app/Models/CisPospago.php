<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CisPospago extends Model
{
    use HasFactory;

    protected $fillable=[
                    'no_contrato_impreso',
                    'id_orden_contratacion',
                    'fecha_contratacion',
                    'cuenta_cliente',
                    'nombre_cliente',
                    'tipo_venta',
                    'status_orden',
                    'fecha_status_orden',
                    'nombre_pdv_unico',
                    'cve_unica_ejecutivo',
                    'nombre_ejecutivo_unico',
                    'id_contrato',
                    'mdn_inicial',
                    'propiedad',
                    'mdn_actual',
                    'sim',
                    'imei',
                    'plan_tarifario_homo',
                    'plazo_forzoso',
                    'nva_renta',
                    'mdn_definitivo',
                    'carga_id',
                    'user_id'
    ];
}
