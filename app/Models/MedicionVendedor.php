<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicionVendedor extends Model
{
    use HasFactory;
    protected $fillable=['calculo_id','ventas','rentas','bracket_ventas','bracket_rentas'];
}
