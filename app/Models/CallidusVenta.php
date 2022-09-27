<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CallidusVenta extends Model
{
    protected $fillable = ['tipo',
                            'periodo',
                            'contrato',
                            'cliente',
                            'plan',
                            'dn',
                            'propiedad',
                            'modelo',
                            'fecha',
                            'fecha_baja',
                            'plazo',
                            'descuento_multirenta',
                            'afectacion_comision',
                            'comision',
                            'renta',
                            'tipo_baja',
                            'conciliacion_id',
                            'razon_0',
                            'logro',
                            'cuota',
                            'alcance',
                            'estatus',
                            'monto_reclamo'
                    ];
    use HasFactory;
}
