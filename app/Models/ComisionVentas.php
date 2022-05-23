<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComisionVentas extends Model
{
    use HasFactory;
    protected $fillable=['venta_id','calculo_id','escenario','cuenta','paga'];
}
