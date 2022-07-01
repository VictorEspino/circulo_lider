<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Funnel;
use App\Models\TimeUpdate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FunnelController extends Controller
{
    public function show_calendario(Request $request)
    {
        $campo_universo='udn';
        $key_universo='';
    
        if(Auth::user()->puesto_desc->puesto=='EJECUTIVO' || Auth::user()->puesto_desc->puesto=='OTRO')
        {
            $campo_universo='udn';
            $key_universo=Auth::user()->subarea->id;
        }
        if(Auth::user()->puesto_desc->puesto=='GERENTE')
        {
            $campo_universo='udn';
            $key_universo=Auth::user()->subarea->id;
        }
        if(Auth::user()->puesto_desc->puesto=='REGIONAL')
        {
            $campo_universo='region';
            $key_universo=Auth::user()->pdv;
        }

        $registros=Funnel::where($campo_universo,$key_universo)
                            ->select('id',DB::raw('cliente as title, fecha_sig_contacto as start,CASE WHEN fecha_sig_contacto<date(now()) THEN "#FF0000" ELSE "#0073e6" END as backgroundColor'))
                            ->where('estatus','!=','Venta')
                            ->where('estatus','!=','Finalizar Seguimiento')
                            ->orderBy('created_at','desc')
                            ->get();                      
                            //return($registros);         
        $SQL_inicio="select lpad(now(),10,0) as hoy from dual";
        $inicio=DB::select(DB::raw(
            $SQL_inicio
        ));

        return(view('funnel.calendario',['registros'=>$registros,'inicio'=>$inicio[0]->hoy]));
    }
    public function seguimiento_funnel(Request $request)
    {
        $campo_universo='udn';
        $key_universo='';
    
        if(Auth::user()->puesto_desc->puesto=='EJECUTIVO' || Auth::user()->puesto_desc->puesto=='OTRO')
        {
            $campo_universo='udn';
            $key_universo=Auth::user()->subarea->id;
        }
        if(Auth::user()->puesto_desc->puesto=='GERENTE')
        {
            $campo_universo='udn';
            $key_universo=Auth::user()->subarea->id;
        }
        if(Auth::user()->puesto_desc->puesto=='REGIONAL')
        {
            $campo_universo='region';
            $key_universo=Auth::user()->pdv;
        }


        if(isset($_GET['query']))
        {
            $registros=Funnel::where($campo_universo,$key_universo)
                                ->where('cliente','like','%'.$_GET["query"].'%')
                                ->where('estatus','!=','Venta')
                                ->where('estatus','!=','Finalizar Seguimiento')
                                ->orderBy('created_at','desc')
                                ->paginate(10);
            $registros->appends($request->all());
            return(view('funnel.seguimiento',['registros'=>$registros,'query'=>$_GET['query']]));
        }
        else
        {
            $registros=Funnel::where($campo_universo,$key_universo)
                                ->where('estatus','!=','Venta')
                                ->where('estatus','!=','Finalizar Seguimiento')
                                ->orderBy('created_at','desc')   
                                //->dd();                             
                                ->paginate(10);
            return(view('funnel.seguimiento',['registros'=>$registros,'query'=>'']));
        }
    }

    public function funnel_detalles(Request $request)
    {
        return(Funnel::find($request->id));
    }
    public function funnel_update(Request $request)
    {
        $cambio=false;

        $funnel=Funnel::find($request->id);

        $e1_a=$funnel->estatus1;
        $e2_a=$funnel->estatus2;
        $e3_a=$funnel->estatus3;
        $fs_a=$funnel->fecha_sig_contacto;
        $e_a=$funnel->estatus;
        $o_a=$funnel->observaciones;

        if($e1_a!=$request->estatus1 || $e2_a!=$request->estatus2 || 
            $e3_a!=$request->estatus3 || $fs_a!=$request->fecha_sig_contacto ||
            $e_a!=$request->estatus || $o_a!=$request->observaciones)
            {
                $cambio=true;
            }



        $funnel->estatus1=$request->estatus1;
        $funnel->estatus2=$request->estatus2;
        $funnel->estatus3=$request->estatus3;
        $funnel->fecha_sig_contacto=$request->fecha_sig_contacto;
        $funnel->estatus=$request->estatus;
        $funnel->observaciones=$request->observaciones;
        $funnel->cliente=$request->cliente;
        $funnel->telefono=$request->telefono;
        $funnel->correo=$request->correo;
        $funnel->producto=$request->producto;
        $funnel->plan=$request->plan;
        $funnel->equipo=$request->equipo;
        $funnel->save();

        if($cambio)
        {
        $tiempos=new TimeUpdate();
        $tiempos->empleado=Auth::user()->user;
        $tiempos->nombre=Auth::user()->name;
        $tiempos->udn=Auth::user()->subarea->id;
        $tiempos->pdv=Auth::user()->subarea->nombre;
        $tiempos->region=Auth::user()->area_user->nombre;
        $tiempos->minutos_funnel=10;
        $tiempos->funnel_id=$request->id;
        $tiempos->save();
        }


        return;
    }

    public function funnel_form(Request $request)
    {
        $origen="";
        if($request->origen=='CD') $origen='CONTACTO DIGITAL';
        if($request->origen=='RF') $origen='REFERIDO';
        return(view('funnel.nuevo',['origen_funnel'=>$origen]));
    }

    public function funnel_save(Request $request)
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
        ]
        );
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

        return(view('mensaje',[ 'estatus'=>'OK',
                                'mensaje'=>'Registro de contacto ('.$request->funnel_nombre.') realizado de manera exitosa!'
                              ]));
    }
}