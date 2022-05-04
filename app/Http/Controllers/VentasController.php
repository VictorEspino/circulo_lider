<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plan;
use App\Models\Venta;
use Illuminate\Support\Facades\Auth;

class VentasController extends Controller
{
    public function show_nueva(Request $request)
    {
        $planes=Plan::where('estatus',1)->get();
        return(view('ventas.nueva',['planes'=>$planes]));
    }
    public function save_nueva(Request $request)
    {
        $request->validate([
            'tipo' => 'required',
            'fecha' => 'required',
            'cliente' => 'required',
            'mail_cliente'=>'required|email',
            'plan'=>'required',
            'plazo'=>'required|numeric',
            'renta' => 'required|numeric',
            'propiedad'=>'required',
            'contrato'=>'required',
            'addon_control'=>'required',
            'seguro_proteccion'=>'required',
            'dn'=>'required|digits:10',
        ],
        [
            'required' => 'Campo requerido.',
            'numeric'=>'Debe ser un numero',
            'email'=>'Indique una direccion de correo valida',
            'unique'=>'Valor duplicado en base de datos',
            'digits'=>'Debe contener 10 digitos'
        ]);
        Venta::create([
                    'tipo'=>$request->tipo,
                    'sucursal'=>Auth::user()->sucursal,
                    'ejecutivo'=>Auth::user()->id,
                    'fecha'=>$request->fecha,
                    'plan'=>$request->plan,
                    'renta'=>$request->renta,
                    'plazo'=>$request->plazo,
                    'propiedad'=>$request->propiedad,
                    'imei'=>$request->imei,
                    'iccid'=>$request->icc_id,
                    'dn'=>$request->dn,
                    'cliente'=>$request->cliente,
                    'co_id'=>$request->contrato,
                    'mail_cliente'=>$request->mail_cliente,
                    'addon_control'=>$request->addon_control=='SI'?1:0,
                    'seguro_proteccion'=>$request->seguro_proteccion=='SI'?1:0,
                    'observaciones'=>$request->observaciones
        ]);

        return(back()->withStatus('OK - Registro de venta '.$request->cliente.' creado con exito'));
    }
}
