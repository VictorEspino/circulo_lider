<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PagosVendedor;
use App\Models\MedicionVendedor;
use App\Models\MedicionGerente;
use App\Models\Calculo;
use App\Models\Plan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EstadosCuenta extends Controller
{
    public function vendedores(Request $request)
    {
        $filtro_text='';
        $filtro=false;
        if(isset($_GET['filtro']))
        {
            $filtro=true;
            $filtro_text=$_GET["query"];
        }
        $registros=PagosVendedor::where('calculo_id',$request->id)
                        ->where('rol','EJECUTIVO')
                        ->orderBy('nombre','asc')
                        ->when($filtro && $filtro_text!='',function ($query) use ($filtro_text)
                            {
                                $query->where(function ($anidado) use ($filtro_text) {
                                    $anidado->where('nombre','like','%'.$filtro_text.'%');
                                    $anidado->orWhere('sucursal','like','%'.$filtro_text.'%');
                                });
                            })
                        ->paginate(10);
        if($filtro)
        {
            $registros->appends([
                    'filtro'=>'ACTIVE',
                    'query' => $filtro_text,
                    ]);   
        }            

        return(view('comisiones.show_vendedores',['id'=>$request->id,'registros'=>$registros,'query'=>$filtro_text]));
    }

    public function estado_cuenta_vendedor(Request $request)
    {
        $medicion=MedicionVendedor::where('ejecutivo',$request->user_id)
                                    ->where('calculo_id',$request->id)
                                    ->get()->first();
        $pago=PagosVendedor::where('user_id',$request->user_id)
                                    ->where('calculo_id',$request->id)
                                    ->where('rol','EJECUTIVO')
                                    ->get()->first();

        $calculo=Calculo::with('periodo')->find($request->id);

        $sql_comisiones="
                        SELECT ventas.*,comision_ventas.comision_vendedor 
                        FROM comision_ventas,ventas  
                        WHERE comision_ventas.venta_id=ventas.id
                        AND comision_ventas.calculo_id='".$request->id."'
                        AND ventas.ejecutivo='".$request->user_id."'
                        ORDER BY ventas.tipo
                        ";


        $sql_addons="
                        SELECT ventas.*,comision_addons.tipo as tipo_addon,comision_addons.comision_vendedor 
                        FROM comision_addons,ventas  
                        WHERE comision_addons.venta_id=ventas.id
                        AND comision_addons.calculo_id='".$request->id."'
                        AND ventas.ejecutivo='".$request->user_id."'
                        ";

        $comisiones=DB::select(DB::raw($sql_comisiones));
        $comisiones=collect($comisiones);
        $comisiones_addon=DB::select(DB::raw($sql_addons));
        $comisiones_addon=collect($comisiones_addon);
        $planes=Plan::all();
        $planes=$planes->pluck('nombre','id');
        return(view('comisiones.estado_cuenta_vendedor',['version'=>2,'calculo'=>$calculo,'pago'=>$pago,'medicion'=>$medicion,'comisiones'=>$comisiones,'planes'=>$planes,'comisiones_addon'=>$comisiones_addon]));
    }

    public function gerentes(Request $request)
    {
        $filtro_text='';
        $filtro=false;
        if(isset($_GET['filtro']))
        {
            $filtro=true;
            $filtro_text=$_GET["query"];
        }
        $registros=PagosVendedor::where('calculo_id',$request->id)
                        ->where('rol','GERENTE')
                        ->orderBy('nombre','asc')
                        ->when($filtro && $filtro_text!='',function ($query) use ($filtro_text)
                            {
                                $query->where(function ($anidado) use ($filtro_text) {
                                    $anidado->where('nombre','like','%'.$filtro_text.'%');
                                    $anidado->orWhere('sucursal','like','%'.$filtro_text.'%');
                                });
                            })
                        ->paginate(10);
        if($filtro)
        {
            $registros->appends([
                    'filtro'=>'ACTIVE',
                    'query' => $filtro_text,
                    ]);   
        }            

        return(view('comisiones.show_gerentes',['id'=>$request->id,'registros'=>$registros,'query'=>$filtro_text]));
    }

    public function estado_cuenta_gerente(Request $request)
    {
        $version=2;
        $medicion=MedicionGerente::where('gerente_id',$request->user_id)
                                    ->where('calculo_id',$request->id)
                                    ->get()->first();
        $pago=PagosVendedor::where('user_id',$request->user_id)
                                    ->where('calculo_id',$request->id)
                                    ->where('rol','GERENTE')
                                    ->get()->first();

        $calculo=Calculo::with('periodo')->find($request->id);

        $sql_comisiones="
                        SELECT ventas.*,comision_ventas.comision_gerente 
                        FROM comision_ventas,ventas  
                        WHERE comision_ventas.venta_id=ventas.id
                        AND comision_ventas.calculo_id='".$request->id."'
                        AND ventas.sub_area='".$medicion->sub_area."'
                        ORDER BY ventas.tipo
                        ";


        $sql_addons="
                        SELECT ventas.*,comision_addons.tipo as tipo_addon,comision_addons.comision_gerente 
                        FROM comision_addons,ventas  
                        WHERE comision_addons.venta_id=ventas.id
                        AND comision_addons.calculo_id='".$request->id."'
                        AND ventas.sub_area='".$medicion->sub_area."'
                        ";

        $comisiones=DB::select(DB::raw($sql_comisiones));
        $comisiones=collect($comisiones);
        $comisiones_addon=DB::select(DB::raw($sql_addons));
        $comisiones_addon=collect($comisiones_addon);
        $planes=Plan::all();
        $planes=$planes->pluck('nombre','id');
        return(view('comisiones.estado_cuenta_gerente',['calculo'=>$calculo,'pago'=>$pago,'medicion'=>$medicion,'comisiones'=>$comisiones,'planes'=>$planes,'comisiones_addon'=>$comisiones_addon,'version'=>$version]));
    }

}
