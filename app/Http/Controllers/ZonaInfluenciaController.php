<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EncuestaZonaInfluencia;
use App\Models\CatalogoInteracciones;
use App\Models\Funnel;
use App\Models\Plan;
use App\Models\ParametrosTiempo;
use App\Models\Venta;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ZonaInfluenciaController extends Controller
{
    public function show_form_nuevo(Request $request)
    {
        $planes=Plan::all();
        return(view('zona_influencia.nuevo',['planes'=>$planes]));
    }

    public function zona_influencia_nuevo(Request $request)
    {
        //return($request->all());
        $request->validate([
            'nombre_contacto'=> 'required',
            'telefono_cliente'=> 'required',
            'compania'=> 'required',
            'tipo_plan'=> 'required',
            'gasto_mes'=> 'required',
            'equipo_zona'=> 'required',
            'beneficios'=> 'max:255',
            'fin_interaccion'=>'required',
        ],
        [
            'required' => 'Campo requerido.',
            'numeric'=>'Debe ser un numero',
            'email'=>'Indique una direccion de correo valida',
            'unique'=>'Valor duplicado en base de datos',
            'digits'=>'Debe contener 10 digitos',
            'min'=>'Valor invalido'
        ]);
        $adicional="";
        if($request->fin_interaccion=="Funnel")
        {
            $request->validate([
                'origen' => 'required',
                'funnel_nombre' => 'required',
                'funnel_telefono' => 'required',
                'funnel_correo' => 'required|email',
                'tipo_f' => 'required',
                'funnel_plan' => 'required',
                'funnel_equipo' => 'required',
                'funnel_estatus' => 'required',
                'observaciones_f' => 'max:255',
                'fecha_sig_contacto' => 'required|date_format:Y-m-d'
            ],
            [
                'required' => 'Campo requerido.',
                'numeric'=>'Debe ser un numero',
                'email'=>'Indique una direccion de correo valida',
                'unique'=>'Valor duplicado en base de datos',
                'digits'=>'Debe contener 10 digitos',
                'min'=>'Valor invalido'
            ]);
            $funnel=new Funnel;      

            $funnel->empleado=Auth::user()->user;
            $funnel->nombre=Auth::user()->name;
            $funnel->udn=Auth::user()->subarea->id;
            $funnel->pdv=Auth::user()->subarea->nombre;
            $funnel->region=Auth::user()->area_user->nombre;
            $funnel->origen=$request->origen;
            $funnel->cliente=$request->funnel_nombre;
            $funnel->telefono=$request->funnel_telefono;
            $funnel->correo=$request->funnel_correo;
            $funnel->producto=$request->tipo_f;
            $funnel->plan=$request->funnel_plan;
            $funnel->equipo=$request->funnel_equipo;
            $funnel->estatus=$request->funnel_estatus;
            $funnel->observaciones=$request->observaciones_f;
            $funnel->fecha_sig_contacto=$request->fecha_sig_contacto;
            $funnel->minutos=10;
            $funnel->save();
            $adicional=" incluido el registro de prospecto ";
            //return(view('mensaje',[ 'estatus'=>'OK',
            //                        'mensaje'=>'El registro del prospecto ('.$request->funnel_nombre.') se realizo de manera exitosa!'
            //                      ]));
        }
        if($request->fin_interaccion=="Venta")
        {
            
            $request->validate([
                'tipo' => 'required',
                'fecha' => 'required',
                'cliente' => 'required',
                'mail_cliente'=>'required|email',
                'rfc'=>'exclude_if:tipo,ACCESORIO|exclude_if:tipo,PREPAGO|required',
                'plan'=>'required',
                'plazo'=>'numeric|exclude_if:tipo,PREPAGO|exclude_if:tipo,ACCESORIO|required',
                'renta' => 'exclude_if:tipo,PREPAGO|exclude_if:tipo,ACCESORIO|required|numeric|min:50',
                'propiedad'=>'exclude_if:tipo,ACCESORIO|required',
                'equipo'=>'required',
                'contrato'=>'exclude_if:tipo,PREPAGO|exclude_if:tipo,ACCESORIO|required',
                'cuenta'=>'exclude_if:tipo,PREPAGO|exclude_if:tipo,ACCESORIO|required',
                'orden'=>'required',
                'addon_control'=>'exclude_if:tipo,PREPAGO|exclude_if:tipo,ACCESORIO|required',
                'seguro_proteccion'=>'exclude_if:tipo,PREPAGO|exclude_if:tipo,ACCESORIO|required',
                'dn'=>'exclude_if:tipo,ACCESORIO|required|digits:10',
                'iccid'=>'exclude_unless:tipo,PREPAGO|required',
                'imei'=>'exclude_unless:propiedad,NUEVO|required',
                'renta_seguro'=>'exclude_unless:seguro_proteccion,SI|required|numeric|min:1',
            ],
            [
                'required' => 'Campo requerido.',
                'numeric'=>'Debe ser un numero',
                'email'=>'Indique una direccion de correo valida',
                'unique'=>'Valor duplicado en base de datos',
                'digits'=>'Debe contener 10 digitos',
                'min'=>'Valor invalido'
            ]);
            $minutos=20; //default value
            $tiempos=ParametrosTiempo::where('fuente','VENTA')
                                ->get();
        
            foreach($tiempos as $tiempo)
            {
                $minutos=$tiempo->minutos;
            }
            Venta::create([
                'empleado'=>Auth::user()->user,
                'nombre'=>Auth::user()->name,
                'udn'=>Auth::user()->subarea->id,
                'pdv'=>Auth::user()->subarea->nombre,
                'region'=>Auth::user()->area_user->nombre,
                'tipo'=>$request->tipo,
                'area'=>Auth::user()->area,
                'sub_area'=>Auth::user()->sub_area,
                'ejecutivo'=>Auth::user()->id,
                'fecha'=>$request->fecha,
                'plan'=>$request->plan,
                'renta'=>is_null($request->renta)||$request->renta==''?0:$request->renta,
                'plazo'=>$request->plazo,
                'propiedad'=>$request->propiedad,
                'imei'=>$request->imei,
                'iccid'=>$request->icc_id,
                'dn'=>$request->dn,
                'cliente'=>$request->cliente,
                'co_id'=>$request->contrato,
                'mail_cliente'=>$request->mail_cliente,
                'equipo'=>$request->equipo,
                'rfc'=>$request->rfc,
                'forma_pago'=>$request->forma_pago,
                'orden'=>$request->orden,
                'cuenta'=>$request->cuenta,
                'addon_control'=>$request->addon_control=='SI'?1:0,
                'seguro_proteccion'=>$request->seguro_proteccion=='SI'?1:0,
                'renta_seguro'=>$request->seguro_proteccion=='SI'?$request->renta_seguro==''?0:$request->renta_seguro:0,
                'observaciones'=>$request->observaciones_v,
                'minutos'=>$minutos
    ]);
            $adicional=" incluido el registro la orden ";
        }
        $interaccion=new EncuestaZonaInfluencia;      
        $interaccion->empleado=Auth::user()->user;
        $interaccion->nombre=Auth::user()->name;
        $interaccion->udn=Auth::user()->subarea->id;
        $interaccion->pdv=Auth::user()->subarea->nombre;
        $interaccion->region=Auth::user()->area_user->nombre;
        $interaccion->nombre_contacto=$request->nombre_contacto;
        $interaccion->telefono=$request->telefono_cliente;
        $interaccion->compañia=$request->compania;
        $interaccion->tipo_plan=$request->tipo_plan;
        $interaccion->gasto_mes=$request->gasto_mes;
        $interaccion->equipo=$request->equipo_zona;
        $interaccion->beneficios=$request->beneficios;
        $interaccion->fin_interaccion=$request->fin_interaccion;

        $minutos=4; //default value
        $tiempos=ParametrosTiempo::where('fuente','ENCUESTA')
                                ->get();
        
        foreach($tiempos as $tiempo)
        {
            $minutos=$tiempo->minutos;
        }
        $interaccion->minutos=$minutos;

        $interaccion->save();
        return(view('mensaje',[ 'estatus'=>'OK',
                                'mensaje'=>'El registro de la encuesta,'.$adicional.' en tu zona de influencia ('.$request->nombre_contacto.') se realizo de manera exitosa!'
                              ]));
    }
}
