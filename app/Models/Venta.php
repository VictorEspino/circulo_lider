<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;

    protected $fillable=[
                    'tipo',
                    'area',
                    'sub_area',
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
                    'equipo',
                    'rfc',
                    'forma_pago',
                    'orden',
                    'cuenta',
                    'addon_control',
                    'seguro_proteccion',
                    'renta_seguro',
                    'observaciones'
                ];
    public function det_ejecutivo()
    {
        return $this->belongsTo(User::class,'ejecutivo');
    }
    public function det_plan()
    {
        return $this->belongsTo(Plan::class,'plan');
    }
    public function det_sucursal()
    {
        return $this->belongsTo(Subarea::class,'sub_area');
    }
}
