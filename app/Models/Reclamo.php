<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reclamo extends Model
{
    use HasFactory;

    public function venta()
    {
        return $this->belongsTo(Venta::class);
    }
    public function callidus()
    {
        return $this->belongsTo(CallidusVenta::class,'callidus_id');
    }
    public function callidus_residual()
    {
        return $this->belongsTo(CallidusResidual::class,'callidus_id');
    }
}
