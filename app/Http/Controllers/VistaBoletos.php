<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\BoletosVendedor;

class VistaBoletos extends Controller
{
    public function vista_boletos()
    {
        if(Auth::user()->puesto==1)
        {
        $registros=BoletosVendedor::with('venta','venta.det_plan')->where('ejecutivo',Auth::user()->id)->get();
        //foreach($registros as $rec)
        return(view('boletos_ejecutivo',['registros'=>$registros]));
        }
        else
        return('No tienes boletos que mostrar en esta seccion<br><br><a href="javascript:history.back()">Atras</a>');
    }
}
