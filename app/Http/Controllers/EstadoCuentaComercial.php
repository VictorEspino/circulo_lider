<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Calculo;

class EstadoCuentaComercial extends Controller
{
    public function estado_cuenta_comercial(Request $request)
    {
        if(Auth::user()->subarea->tipo=='SUBDISTRIBUIDOR')
         return('NO TIENES COMISIONES QUE MOSTRAR <br><br> <a href="javascript:history.back()">ATRAS</a>');
        else
        {
            if(Auth::user()->puesto==1)
            {
                return(redirect(route('estado_cuenta_vendedor',[$id=$request->id,$user_id=Auth::user()->id])));
            }
            if(Auth::user()->puesto==2)
            {
                return(redirect(route('estado_cuenta_gerente',[$id=$request->id,$user_id=Auth::user()->id])));
            }
            return('NO TIENES COMISIONES QUE MOSTRAR <br><br> <a href="javascript:history.back()">ATRAS</a>');
        } 
    }
    public function calculos_disponibles_comercial(Request $request)
    {
        $calculos=Calculo::with('periodo')
            ->where('visible_vendedor',1)
            ->orderBy('id','desc')
            ->get();
        return view ('seguimiento_calculo_comercial',['calculos'=>$calculos]);        
    }
}
