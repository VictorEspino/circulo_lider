<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PeriodoMes;
use App\Models\Conciliacion;
use App\Models\CallidusVenta;
use App\Models\CallidusResidual;
use App\Models\Reclamo;
use App\Models\Venta;
use App\Models\AlertaCobranza;
use App\Imports\ImportCallidusVentas;
use App\Imports\ImportCallidusResidual;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ConciliacionController extends Controller
{
    public function vista_nuevo(Request $request)
    {
        $años=PeriodoMes::select(DB::raw('distinct(año) as valor'))
                    ->whereRaw('DATEDIFF( now(),fecha_fin)<60')
                    ->get()
                    ->take(2);
        return(view('conciliacion.nuevo',['años'=>$años,
                                          'nombre'=>Auth::user()->name,
                                        ]));
    }
    public function conciliacion_nuevo(Request $request)
    {
        $request->validate([
            'descripcion_calculo'=> 'required|max:255',
            'año'=>'required',
            'mes'=>'required',
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
        $periodo=PeriodoMes::where('año',$request->año)->where('mes',$request->mes)->get()->first();
        $calculo_valida=Conciliacion::where('periodo_id',$periodo->id)->get();
        if(!$calculo_valida->isEmpty())
        {
            return(back()->with('error_validacion','El periodo de conciliacion ya se encuentra registrado'));
        }
        $registro=new Conciliacion;
        $registro->descripcion=$request->descripcion_calculo;
        $registro->periodo_id=$periodo->id;
        $registro->user_id=Auth::user()->id;
        $registro->save();
        return(back()->withStatus('Registro de conciliacion'.$request->descripcion.' creado con exito'));       
    }
    public function seguimiento_conciliacion(Request $request)
    {
        $conciliaciones=Conciliacion::with('periodo')->where('visible',1)->orderBy('periodo_id','desc')->get()->take(10);
        $meses=array('Ene',
                  'Feb',
                  'Mar',
                  'Abr',
                  'May',
                  'Jun',
                  'Jul',
                  'Ago',
                  'Sep',
                  'Oct',
                  'Nov',
                  'Dic',
                );
        return(view('conciliacion.seguimiento',['conciliaciones'=>$conciliaciones,'meses'=>$meses]));
    }
    public function detalle_conciliacion(Request $request)
    {
        $conciliacion=Conciliacion::with('periodo')->find($request->id);
        $n_callidus=CallidusVenta::select(DB::raw('count(*) as n'))
                        ->where('conciliacion_id',$request->id)
                        ->get()
                        ->first();

        $n_callidus_residual=CallidusResidual::select(DB::raw('count(*) as n'))
                        ->where('conciliacion_id',$request->id)
                        ->get()
                        ->first();

        $n_reclamos=Reclamo::select(DB::raw('count(*) as n'))
                        ->where('conciliacion_id',$request->id)
                        ->where('tipo','!=','RESIDUAL')
                        ->get()
                        ->first();

        $n_reclamos_residual=Reclamo::select(DB::raw('count(*) as n'))
                        ->where('conciliacion_id',$request->id)
                        ->where('tipo','RESIDUAL')
                        ->get()
                        ->first();
        

        $alertas=0;

        $alertas_cobranza=AlertaCobranza::select(DB::raw('count(*) as n'))->where('conciliacion_id',$conciliacion->id)->get()->first();
        $alertas=!is_null($alertas_cobranza->n)?$alertas_cobranza->n:0;

        return(view('conciliacion.detalle',['id_conciliacion'=>$conciliacion->id,
                                       'n_callidus'=>$n_callidus->n,
                                       'n_callidus_residual'=>$n_callidus_residual->n,
                                       'fecha_inicio'=>$conciliacion->periodo->fecha_inicio,
                                       'fecha_fin'=>$conciliacion->periodo->fecha_fin,
                                       'descripcion'=>$conciliacion->descripcion,
                                       'n_reclamos'=>$n_reclamos->n,
                                       'alertas'=>$alertas,
                                       'n_reclamos_residual'=>$n_reclamos_residual->n,
                                    ]));
    }
    public function callidus_import(Request $request) 
    {
        $request->validate([
            'file_v'=> 'required',
            ]);
        $file=$request->file('file_v');
        CallidusVenta::where('conciliacion_id',$request->id_conciliacion)->delete();
        Reclamo::where('conciliacion_id',$request->id_conciliacion)
                    ->where('tipo','COMISION INCORRECTA')
                    ->delete();
        Reclamo::where('conciliacion_id',$request->id_conciliacion)
                    ->where('tipo','COMISION FALTANTE')
                    ->delete();
        
        $import=new ImportCallidusVentas;
        session(['id_conciliacion' => $request->id_conciliacion]);
        try{
        $import->import($file);
        }
        catch(\Maatwebsite\Excel\Validators\ValidationException $e) {
            return back()->withFailures($e->failures());
        }
        $this->revisa_lineas_faltantes($request->id_conciliacion);
        $this->aplica_reclamos($request->id_conciliacion);
        return back()->withStatus('Archivo Callidus Ventas cargado con exito!');
    }
    public function revisa_lineas_faltantes($id_conciliacion)
    {
        $conciliacion=Conciliacion::with('periodo')->find($id_conciliacion);

        $lineas_validadas=Venta::whereBetween('fecha', [$conciliacion->periodo->fecha_inicio, $conciliacion->periodo->fecha_fin ])
                                ->where('cis_row_id','>',0)
                                ->get();
        foreach($lineas_validadas as $venta)
        {
            $ocurrencias=0;
            $registro_callidus=CallidusVenta::where('conciliacion_id',$id_conciliacion)
                                ->where('contrato',$venta->cis_id."_DL")
                                ->get();
            foreach($registro_callidus as $registro)
            {
                $ocurrencias+=1;
            }

            if($ocurrencias==0)
            {
                $reclamo=new Reclamo;
                $reclamo->venta_id=$venta->id;
                $reclamo->callidus_id=0;
                $reclamo->conciliacion_id=$id_conciliacion;
                $reclamo->monto=$venta->renta;
                $reclamo->razon="COMISION FALTANTE";
                $reclamo->tipo="COMISION FALTANTE";
                $reclamo->save();   
            }
        }
    }
    public function aplica_reclamos($id_conciliacion)
    {
        $reclamos=CallidusVenta::where('conciliacion_id',$id_conciliacion)
                                ->where('estatus',0)
                                ->get();
        foreach($reclamos as $reclamo_actual)
        {
            $reclamo=new Reclamo;
            $reclamo->venta_id=0;
            $reclamo->callidus_id=$reclamo_actual->id;
            $reclamo->conciliacion_id=$id_conciliacion;
            $reclamo->monto=$reclamo_actual->monto_reclamo;
            $reclamo->razon="COMISION INCORRECTA";
            $reclamo->tipo="COMISION INCORRECTA";
            $reclamo->save();   
        }
    }
    public function callidus_residual_import(Request $request) 
    {
        ini_set('memory_limit', '512M');
        $request->validate([
            'file_r'=> 'required',
            ]);
        $file=$request->file('file_r');
        CallidusResidual::where('conciliacion_id',$request->id_conciliacion)->delete();
        Reclamo::where('conciliacion_id',$request->id_conciliacion)
        ->where('tipo','RESIDUAL')
        ->delete();

        $import=new ImportCallidusResidual;
        session(['id_conciliacion' => $request->id_conciliacion]);
        try{
        $import->import($file);
        }
        catch(\Maatwebsite\Excel\Validators\ValidationException $e) {
            return back()->withFailures($e->failures());
        }    
        $this->valida_residual_estatus($request->id_conciliacion);
        return back()->withStatus('Archivo Callidus Residual cargado con exito!');
    }

    public function valida_residual_estatus($id_conciliacion)
    {
        $lineas_residual=CallidusResidual::where('conciliacion_id',$id_conciliacion)
                                        ->get();
        foreach($lineas_residual as $linea)
        {
            if($linea->estatus=="ACTIVO" && $linea->comision==0)
            {
                $reclamo=new Reclamo;
                $reclamo->venta_id=0;
                $reclamo->callidus_id=$linea->id;
                $reclamo->conciliacion_id=$id_conciliacion;
                $reclamo->monto=$linea->renta*0.05;
                $reclamo->razon="COMISION INCORRECTA";
                $reclamo->tipo="RESIDUAL";
                $reclamo->save();   
            }
        }
    }

    public function reclamos_export(Request $request)
    {
        $query=Reclamo::with('venta','callidus')
                        ->where('conciliacion_id',$request->id)
                        ->where('tipo','!=','RESIDUAL')
                        ->get();
        return(view('reclamos.export',['query'=>$query]));
    }

    public function reclamos_residual_export(Request $request)
    {
        $query=Reclamo::with('venta','callidus_residual')
                        ->where('conciliacion_id',$request->id)
                        ->where('tipo','RESIDUAL')
                        ->get();
        return(view('reclamos.export_residual',['query'=>$query]));
    }
}
