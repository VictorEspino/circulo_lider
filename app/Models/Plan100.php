<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan100 extends Model
{
    use HasFactory;
    protected $fillable=['user_id','circulo','padre'];

    public function registro_padre()
    {
        return $this->belongsTo(Plan100::class,'padre');
    }
}
