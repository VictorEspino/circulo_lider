<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plan;
use App\Models\Venta;
use App\Models\SubArea;
use Illuminate\Support\Facades\Auth;

class VentasController extends Controller
{
    public function show_nueva(Request $request)
    {
        $planes=Plan::where('estatus',1)->orderBy('nombre','asc')->get();
        return(view('ventas.nueva',['planes'=>$planes,'origen'=>$request->origen,'nombre'=>$request->nombre,'email'=>$request->email]));
    }
    public function save_nueva(Request $request)
    {
        //return($request->all());
        $request->validate([
            'origen' => 'required',
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
        Venta::create([
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
                    'observaciones'=>$request->observaciones
        ]);
        return(back()->withStatus('OK - Registro de venta '.$request->cliente.' creado con exito'));
    }
    public function base_ventas(Request $request)
    {
        //return($request->all());
        $filtro_text='';
        $tipo='';
        $validado_cis='';
        $doc_completa='';
        $f_inicio='';
        $f_fin='';
        $filtro=false;
        $excel="NO";
        $sucursal=0;
        if(isset($_GET['filtro']))
        {
            $filtro=true;
            $filtro_text=$_GET["query"];
            $tipo=$_GET["tipo"];
            $validado_cis=$_GET["validado_cis"];
            $doc_completa=$_GET["doc_completa"];
            $f_inicio=$_GET["f_inicio"];
            $f_fin=$_GET["f_fin"];
            $excel=$_GET["excel"];
            $sucursal=$_GET["sucursal"];
        }
        if($excel=="NO")
        {
        $registros=Venta::with('det_ejecutivo','det_sucursal','det_plan')
                        ->orderBy('fecha','desc')
                        ->when ($sucursal>0,function ($query) use ($sucursal)
                        {
                            $query->where('sub_area',$sucursal);
                        })

                        ->when (Auth::user()->puesto==1,function ($query)
                        {
                            $query->where('ejecutivo',Auth::user()->id);
                        })
                        ->when (Auth::user()->puesto==2,function ($query)
                        {
                            $query->where('sub_area',Auth::user()->sub_area);
                        })
                        ->when($filtro && $filtro_text!='',function ($query) use ($filtro_text)
                            {
                                $query->where(function ($anidado) use ($filtro_text){
                                    $anidado->where('cliente','like','%'.$filtro_text.'%');
                                    $anidado->orWhere('dn','like','%'.$filtro_text.'%');
                                    $anidado->orWhere('co_id','like','%'.$filtro_text.'%');
                                });               
                            })
                        ->when($filtro && $tipo!='',function ($query) use ($tipo)
                            {
                                $query->where('tipo',$tipo);
                            })
                        ->when($filtro && $validado_cis!='',function ($query) use ($validado_cis)
                            {
                                $query->where('cis_id',$validado_cis=='SI'?'>':'<=',0);
                                $query->whereRaw("tipo in ('ACTIVACION','RENOVACION')");
                            })
                        ->when($filtro && $doc_completa!='',function ($query) use ($doc_completa)
                            {
                                $query->where('doc_completa',$doc_completa=='SI'?1:0);
                                $query->whereRaw("tipo in ('ACTIVACION','RENOVACION')");
                            })
                        ->when($filtro && $f_inicio!='',function ($query) use ($f_inicio)
                            {
                                $query->where('fecha','>=',$f_inicio);
                            })
                        ->when($filtro && $f_fin!='',function ($query) use ($f_fin)
                            {
                                $query->where('fecha','<=',$f_fin);
                            })
                        ->paginate(10);
        }    
        else
        {
        $registros=Venta::with('det_ejecutivo','det_sucursal','det_plan')
                        ->orderBy('fecha','desc')
                        ->when ($sucursal>0,function ($query) use ($sucursal)
                        {
                            $query->where('sub_area',$sucursal);
                        })
                        ->when (Auth::user()->puesto==1,function ($query)
                        {
                            $query->where('ejecutivo',Auth::user()->id);
                        })
                        ->when (Auth::user()->puesto==2,function ($query)
                        {
                            $query->where('sub_area',Auth::user()->sub_area);
                        })
                        ->when($filtro && $filtro_text!='',function ($query) use ($filtro_text)
                            {
                                $query->where(function ($anidado) use ($filtro_text){
                                    $anidado->where('cliente','like','%'.$filtro_text.'%');
                                    $anidado->orWhere('dn','like','%'.$filtro_text.'%');
                                    $anidado->orWhere('co_id','like','%'.$filtro_text.'%');
                                });               
                            })
                        ->when($filtro && $tipo!='',function ($query) use ($tipo)
                            {
                                $query->where('tipo',$tipo);
                            })
                        ->when($filtro && $validado_cis!='',function ($query) use ($validado_cis)
                            {
                                $query->where('cis_id',$validado_cis=='SI'?'>':'<=',0);
                                $query->whereRaw("tipo in ('ACTIVACION','RENOVACION')");
                            })
                        ->when($filtro && $doc_completa!='',function ($query) use ($doc_completa)
                            {
                                $query->where('doc_completa',$doc_completa=='SI'?1:0);
                                $query->whereRaw("tipo in ('ACTIVACION','RENOVACION')");
                            })
                        ->when($filtro && $f_inicio!='',function ($query) use ($f_inicio)
                            {
                                $query->where('fecha','>=',$f_inicio);
                            })
                        ->when($filtro && $f_fin!='',function ($query) use ($f_fin)
                            {
                                $query->where('fecha','<=',$f_fin);
                            })
                        ->get();
        }           
        
        if($filtro && $excel=="NO")
        {
            $registros->appends([
                    'filtro'=>'ACTIVE',
                    'query' => $filtro_text,
                    'tipo'=>$tipo,
                    'validado_cis'=>$validado_cis,
                    'doc_completa'=>$doc_completa,
                    'f_fin'=>$f_fin,
                    'f_inicio'=>$f_inicio,
                    'excel'=>$excel,
                    'sucursal'=>$sucursal,
                    ]);   
        }            
        $sucursales=SubArea::orderBy('nombre')->whereIn('area_id',['2','3','6'])->get();
        return(view($excel=="NO"?'ventas.base_ventas':'ventas.export',['registros'=>$registros,'query'=>$filtro_text,'validado_cis'=>$validado_cis,'doc_completa'=>$doc_completa,'tipo'=>$tipo,'f_inicio'=>$f_inicio,'f_fin'=>$f_fin,'excel'=>$excel,'sucursal'=>$sucursal,'sucursales'=>$sucursales]));
    }
}
