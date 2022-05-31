<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PagosVendedor extends Model
{
    use HasFactory;

    protected $fillable=['calculo_id','user_id','comisiones','bono_rentas','total_pago','nombre','sucursal'];

    public function ejecutivo()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
