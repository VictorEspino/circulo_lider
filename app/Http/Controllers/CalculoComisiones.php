<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Periodo;
use App\Models\Calculo;
use App\Models\Venta;
use App\Models\User;
use App\Models\Plan;
use App\Models\SubArea;
use App\Models\ComisionVentas;
use App\Models\PagosVendedor;
use App\Models\ComisionAddon;
use App\Models\MedicionVendedor;
use App\Models\MedicionGerente;
use App\Models\GerenteTiendaCuota;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CalculoComisiones extends Controller
{
    public function nuevo(Request $request)
    {
        $ultimo_periodo=Calculo::select(DB::raw("max(periodo_id) as ultimo"))
                                ->get()
                                ->first();
        $periodo_siguiente=$ultimo_periodo->ultimo+1;
        $periodo_calculo=Periodo::find($periodo_siguiente);
        return(view('nuevo_calculo',['periodo'=>$periodo_siguiente,'desc_periodo'=>$periodo_calculo->descripcion,'f_inicio'=>$periodo_calculo->f_inicio,'f_fin'=>$periodo_calculo->f_fin]));
    }
    public function save_nuevo(Request $request)
    {
        $request->validate([
            'descripcion' => 'required',
        ],
        [
            'required' => 'Campo requerido.',
        ]);
        try{
            Calculo::create(['periodo_id'=>$request->periodo,
                             'descripcion'=>$request->descripcion,
                             'user_id'=>Auth::user()->id
                            ]);
        }
        catch(\Exception $e)
        {   
            return(back()->withStatus('FAIL - No se puede registrar calculo, contacte al administrador'));
        }
        return(back()->withStatus('OK - Periodo de comisiones registrado con exito!'));
    }
    public function calculo_comisiones(Request $request)
    {
        $calculo_id=$request->id;
        $calculo=Calculo::with('periodo')->find($calculo_id);
        $this->acreditar_ventas($calculo);
        $this->mediciones($calculo);
        $this->comisiones($calculo);
        $this->pagos($calculo);
        return(back()->withStatus('OK - Calculo de comisiones ejecutado con exito!'));
    }
    public function acreditar_ventas($calculo)
    {
        ComisionVentas::where('calculo_id',$calculo->id)->delete();
        /*
        $ventas_periodo=Venta::where('fecha','>=',$calculo->periodo->f_inicio)
                       ->where('fecha','<=',$calculo->periodo->f_fin)
                       ->get();
        */
        $sql_ventas_periodo="
                SELECT ventas.*,cis_pospagos.status_orden,cis_pospagos.fecha_status_orden
                FROM ventas
                LEFT JOIN cis_pospagos
                ON ventas.cis_row_id = cis_pospagos.id
                WHERE
                cis_pospagos.status_orden='CERRADO' and cis_pospagos.fecha_status_orden>='".$calculo->periodo->f_inicio."' and cis_pospagos.fecha_status_orden<='".$calculo->periodo->f_fin."'
                and ventas.tipo='ACTIVACION'
                UNION
                SELECT ventas.*,cis_renovacions.status_renovacion as status_orden,cis_renovacions.fecha_activacion_contrato as fecha_status_orden
                FROM ventas
                LEFT JOIN cis_renovacions
                ON ventas.cis_row_id = cis_renovacions.id
                WHERE
                cis_renovacions.status_renovacion='ACTIVO' and cis_renovacions.fecha_activacion_contrato>='".$calculo->periodo->f_inicio."' and cis_renovacions.fecha_activacion_contrato<='".$calculo->periodo->f_fin."'
                and ventas.tipo='RENOVACION'
                UNION
                select ventas.*,'OK' as status_orden,ventas.fecha as fecha_status_orden from ventas WHERE
                fecha>='".$calculo->periodo->f_inicio."' and fecha<='".$calculo->periodo->f_fin."' and tipo in ('PREPAGO','ACCESORIO')
                        ";
        $ventas_periodo=DB::select(DB::raw($sql_ventas_periodo));
        $ventas_periodo=collect($ventas_periodo);
        foreach($ventas_periodo as $venta)
        {
            $cuenta=1; //se deben validar condiciones para saber si cuenta
            $paga=1; //se deben validar condiciones para saber si paga
            ComisionVentas::create([
                        'calculo_id'=>$calculo->id,
                        'venta_id'=>$venta->id,
                        'escenario'=>1,
                        'cuenta'=>$cuenta,
                        'paga'=>$paga
            ]);
        }
    }
    private function mediciones($calculo)
    {
        $this->medicion_vendedor($calculo);
        $this->medicion_gerente($calculo);
    }
    private function medicion_vendedor($calculo)
    {
        MedicionVendedor::where('calculo_id',$calculo->id)->delete();

        $sql_mediciones="select ejecutivo,sum(ventas) as ventas,sum(rentas)/1.16/1.03 as rentas FROM
                        (
                        SELECT b.ejecutivo,count(*) as ventas,sum(b.renta) as rentas  FROM comision_ventas a,ventas b where a.calculo_id='".$calculo->id."' and a.venta_id=b.id AND
                                                b.tipo='ACTIVACION' and
                                                b.plan in (select id from plans where nombre like '%ARMALO%') AND
                                                a.cuenta=1
                                                group by b.ejecutivo
                        UNION 
                        SELECT distinct ejecutivo,0 as ventas, 0 as rentas from ventas where fecha>='".$calculo->periodo->f_inicio."' and fecha<='".$calculo->periodo->f_fin."'
                        ) as a group by a.ejecutivo";
        $mediciones=DB::select(DB::raw($sql_mediciones));
        $mediciones=collect($mediciones);
        foreach($mediciones as $medicion)
        {
            $bv=0;
            $br=0;
            if($medicion->ventas==0){$bv=1;}
            if($medicion->ventas>0 && $medicion->ventas<=4){$bv=2;}
            if($medicion->ventas>4 && $medicion->ventas<=7){$bv=3;}
            if($medicion->ventas>7 && $medicion->ventas<=10){$bv=4;}
            if($medicion->ventas>10 && $medicion->ventas<=13){$bv=5;}
            if($medicion->ventas>13){$bv=6;}

            if($medicion->rentas>=1675 && $medicion->rentas<=2340.999999){$br=1;}
            if($medicion->rentas>2340.999999 && $medicion->rentas<=2930.999999){$br=2;}
            if($medicion->rentas>2930.999999 && $medicion->rentas<=3340.999999){$br=3;}
            if($medicion->rentas>3340.999999 && $medicion->rentas<=4180.999999){$br=4;}
            if($medicion->rentas>4180.999999){$br=5;}

            MedicionVendedor::create([
                            'calculo_id'=>$calculo->id,
                            'ejecutivo'=>$medicion->ejecutivo,
                            'ventas'=>$medicion->ventas,
                            'rentas'=>$medicion->rentas,
                            'bracket_ventas'=>$bv,
                            'bracket_rentas'=>$br
            ]);
        }
    }
    private function medicion_gerente($calculo)
    {
        MedicionGerente::where('calculo_id',$calculo->id)->delete();

        $sql_mediciones="
            select area,sub_area,sum(ventas) as ventas FROM
            (
                SELECT b.area,b.sub_area,count(*) as ventas FROM comision_ventas a,ventas b where a.calculo_id='".$calculo->id."' and a.venta_id=b.id AND b.tipo='ACTIVACION' and b.plan in 
                    (select id from plans where (nombre like '%ARMALO%' or nombre like '%SIMPLE%') AND nombre not like '%EMPR%'  ) 
                AND a.cuenta=1
                group by b.area,b.sub_area
            UNION 
                SELECT distinct area,sub_area,0 as ventas from ventas where fecha>='".$calculo->periodo->f_inicio."' and fecha<='".$calculo->periodo->f_fin."'
            ) as a group by area,sub_area 
        ";
        $mediciones=DB::select(DB::raw($sql_mediciones));
        $mediciones=collect($mediciones);
        foreach($mediciones as $medicion)
        {
            $cuota_asignacion=GerenteTiendaCuota::where('periodo_id',$calculo->periodo_id)
                                    ->where('area',$medicion->area)
                                    ->where('sub_area',$medicion->sub_area)
                                    ->get()
                                    ->first();
            $factor=$cuota_asignacion->cuota_ventas>0?$medicion->ventas/$cuota_asignacion->cuota_ventas:0;
            if($factor<0.5) $factor=0;
            if($factor>1.2) $factor=1.2;

            MedicionGerente::create([
                'calculo_id'=>$calculo->id,
                'area'=>$medicion->area,
                'sub_area'=>$medicion->sub_area,
                'gerente_id'=>$cuota_asignacion->gerente_id,
                'cuota_ventas'=>$cuota_asignacion->cuota_ventas,
                'ventas'=>$medicion->ventas,
                'factor'=>$factor
            ]);
            
        }
    }
    private function comisiones($calculo)
    {
        $this->comisiones_vendedor($calculo);
        $this->comisiones_gerente($calculo);
    }
    private function comisiones_vendedor($calculo)
    {
        ComisionAddon::where('calculo_id',$calculo->id)->delete();
        $sql_creditos="select a.*,b.nombre as plan_nombre from (SELECT b.*,a.cuenta as cuenta_proceso,a.paga as paga_proceso FROM comision_ventas a,ventas b where a.calculo_id='".$calculo->id."' and a.venta_id=b.id) as a,plans b where a.plan=b.id order by a.ejecutivo";
        $creditos=DB::select(DB::raw($sql_creditos));
        $creditos=collect($creditos);
        $vendedor_anterior=0;

        
        $factor_pago=0;
        $ventas_armalo=0;
        $x=0;
        foreach($creditos as $credito)
        {
            $comision=0;
            if($vendedor_anterior!=$credito->ejecutivo)
            {
                $factor_pago=0;
                $ventas_armalo=0;
                $mediciones=MedicionVendedor::where('calculo_id',$calculo->id)
                                            ->where('ejecutivo',$credito->ejecutivo)
                                            ->get()
                                            ->first();
                if($mediciones->bracket_ventas==1){$factor_pago=0;}
                if($mediciones->bracket_ventas==2){$factor_pago=0.7;}
                if($mediciones->bracket_ventas==3){$factor_pago=0.95;}
                if($mediciones->bracket_ventas==4){$factor_pago=1.2;}
                if($mediciones->bracket_ventas==5){$factor_pago=1.4;}
                if($mediciones->bracket_ventas==6){$factor_pago=1.5;}

                $ventas_armalo=$mediciones->ventas;
            }
            if($credito->paga_proceso)
            {
                if($credito->tipo=='ACTIVACION')
                {
                    if(strpos(strtoupper($credito->plan_nombre),'ARMALO')!==false)
                    {
                        $comision=($credito->renta/1.16/1.03)*$factor_pago;
                    }
                    if(strpos(strtoupper($credito->plan_nombre),'SIMPLE')!==false && $ventas_armalo>=3)
                    {
                        if($credito->plazo<=12) {$comision=($credito->renta/1.16/1.03)*0.5;}
                        if($credito->plazo>12 && $credito->plazo<=18) {$comision=($credito->renta/1.16/1.03)*0.6;}
                        if($credito->plazo>18) {$comision=($credito->renta/1.16/1.03)*0.7;}
                    }
                    if(strpos(strtoupper($credito->plan_nombre),'NEG')!==false || strpos(strtoupper($credito->plan_nombre),'EMPR')!==false )
                    {
                        $factor_pago_emp=0;
                        if($factor_pago==0){$factor_pago_emp=0.6;}
                        else{$factor_pago_emp=$factor_pago;}
                        $comision=($credito->renta/1.16/1.03)*$factor_pago_emp;
                    }
                }
                if($credito->tipo=='RENOVACION')
                {
                    $comision=($credito->renta/1.16/1.03)*0.6; //ARMALO Y EMPRESARIAL

                    if(strpos(strtoupper($credito->plan_nombre),'SIMPLE')!==false)
                    {
                        if($credito->plazo<=12) {$comision=($credito->renta/1.16/1.03)*0.4;}
                        if($credito->plazo>12 && $credito->plazo<=18) {$comision=($credito->renta/1.16/1.03)*0.5;}
                        if($credito->plazo>18) {$comision=($credito->renta/1.16/1.03)*0.6;}
                    }

                    if($ventas_armalo<3 && strpos(strtoupper($credito->plan_nombre),'NEG')===false && strpos(strtoupper($credito->plan_nombre),'EMPR')===false)
                    {
                        $comision=0;
                    }
                }
                if($credito->tipo=='ACCESORIO' && $ventas_armalo>=3)
                {
                    $comision=10;
                    if($credito->renta>200)
                     {$comision=20;}
                }
                if($credito->tipo=='PREPAGO' && $ventas_armalo>=3)
                {
                    $comision=15;
                }

                if(($credito->tipo=='RENOVACION' || $credito->tipo=='ACTIVACION') && ($credito->addon_control==1 || $credito->seguro_proteccion==1))
                {
                    if($credito->addon_control==1)
                    {
                        ComisionAddon::create([
                            'calculo_id'=>$calculo->id,
                            'venta_id'=>$credito->id,
                            'tipo'=>'ADDON CONTROL',
                            'comision_vendedor'=>$ventas_armalo>=3?25.86:0,
                        ]);                
                    }
                    if($credito->seguro_proteccion==1)
                    {
                        ComisionAddon::create([
                            'calculo_id'=>$calculo->id,
                            'venta_id'=>$credito->id,
                            'tipo'=>'SEGURO PROTECCION',
                            'comision_vendedor'=>$ventas_armalo>=3?0.6*($credito->renta_seguro/1.16/1.03):0,
                        ]);                
                    }
                }
                ComisionVentas::where('calculo_id',$calculo->id)
                            ->where('venta_id',$credito->id)
                            ->update(['comision_vendedor'=>$comision]);

            }
            $vendedor_anterior=$credito->ejecutivo;
            
        }
    }
    private function comisiones_gerente($calculo)
    {
        $sql_creditos="select a.*,b.nombre as plan_nombre from (SELECT b.*,a.cuenta as cuenta_proceso,a.paga as paga_proceso FROM comision_ventas a,ventas b where a.calculo_id='".$calculo->id."' and a.venta_id=b.id) as a,plans b where a.plan=b.id order by a.area,a.sub_area";
        $creditos=DB::select(DB::raw($sql_creditos));
        $creditos=collect($creditos);

        $sub_area_anterior=0;

        foreach($creditos as $credito)
        {
            $comision=0;
            if($sub_area_anterior!=$credito->sub_area)
            {
                $factor_pago=0;
                $mediciones=MedicionGerente::where('calculo_id',$calculo->id)
                                            ->where('area',$credito->area)
                                            ->where('sub_area',$credito->sub_area)
                                            ->get()
                                            ->first();
                $factor_pago=$mediciones->factor;

                $sql_addons="SELECT b.*,a.tipo as tipo_addon,a.id as id_comision FROM comision_addons a,ventas b where a.calculo_id='".$calculo->id."' and a.venta_id=b.id  and b.area='".$credito->area."' and b.sub_area='".$credito->sub_area."'";
                $addons_comision=DB::select(DB::raw($sql_addons));
                $addons_comision=collect($addons_comision);
                foreach($addons_comision as $addon_vendido_sucursal)
                {
                    $comision_addon_vendido=0;
                    if($factor_pago>=0.5)
                    {
                        if($addon_vendido_sucursal->tipo_addon=='ADDON CONTROL')
                        {
                            $comision_addon_vendido=12.93;
                        }
                        else
                        {
                            $comision_addon_vendido=0.3*$addon_vendido_sucursal->renta_seguro/1.16/1.03;
                        }
                        ComisionAddon::where('id',$addon_vendido_sucursal->id_comision)
                                    ->update(['comision_gerente'=>$comision_addon_vendido]);
                    }
                }


            }
            if($credito->paga_proceso)
            {
                if($credito->tipo=='ACTIVACION')
                {
                    if(strpos(strtoupper($credito->plan_nombre),'ARMALO')!==false)
                    {
                        $comision=($credito->renta/1.16/1.03)*0.5*$factor_pago;
                    }
                    if(strpos(strtoupper($credito->plan_nombre),'SIMPLE')!==false)
                    {
                        $comision=($credito->renta/1.16/1.03)*0.3;
                    }
                    if(strpos(strtoupper($credito->plan_nombre),'NEG')!==false || strpos(strtoupper($credito->plan_nombre),'EMPR')!==false )
                    {
                        $comision=($credito->renta/1.16/1.03)*0.5*$factor_pago;
                    }
                }
                if($credito->tipo=='RENOVACION')
                {
                    $comision=($credito->renta/1.16/1.03)*0.2; //ARMALO Y EMPRESARIAL

                    if(strpos(strtoupper($credito->plan_nombre),'ARMALO')!==false && $credito->propiedad=='PROPIO')
                    {
                        $comision=0;
                    }

                    if($factor_pago<0.5)
                    {
                        $comision=0;
                    }
                }
                if($credito->tipo=='ACCESORIO')
                {
                    $comision=0;
                }
                if($credito->tipo=='PREPAGO' && $factor_pago>=0.5)
                {
                    $comision=5;
                }
                ComisionVentas::where('calculo_id',$calculo->id)
                            ->where('venta_id',$credito->id)
                            ->update(['comision_gerente'=>$comision]);

            }
            $sub_area_anterior=$credito->sub_area;            
        }
    }

    public function pagos($calculo)
    {
        $this->pagos_vendedor($calculo);
        $this->pagos_gerente($calculo);
    }

    public function pagos_vendedor($calculo)
    {
        PagosVendedor::where('calculo_id',$calculo->id)->delete();
        $sql_ventas="
        select ejecutivo,sum(comision) as comision from
        (
        SELECT ventas.ejecutivo,sum(comision_ventas.comision_vendedor) as comision 
                                FROM comision_ventas,ventas 
                                where comision_ventas.venta_id=ventas.id and comision_ventas.calculo_id=".$calculo->id." 
                                group by ventas.ejecutivo
        UNION
        SELECT ventas.ejecutivo,sum(comision_addons.comision_vendedor) as comision 
                                FROM comision_addons,ventas 
                                where comision_addons.venta_id=ventas.id and comision_addons.calculo_id=".$calculo->id." 
                                group by ventas.ejecutivo
         ) as a group by a.ejecutivo
                    ";
        $ventas_ejecutivo=DB::select(DB::raw($sql_ventas));
        $ventas_ejecutivo=collect($ventas_ejecutivo);

        foreach($ventas_ejecutivo as $pago_ejec)
        {
            $medicion=MedicionVendedor::where('calculo_id',$calculo->id)
                                        ->where('ejecutivo',$pago_ejec->ejecutivo)
                                        ->get()
                                        ->first();
            $bono_rentas=0;
            if($medicion->bracket_rentas==1)
            {
                $bono_rentas=300;
            }
            if($medicion->bracket_rentas==2)
            {
                $bono_rentas=600;
            }
            if($medicion->bracket_rentas==3)
            {
                $bono_rentas=900;
            }
            if($medicion->bracket_rentas==4)
            {
                $bono_rentas=1200;
            }
            if($medicion->bracket_rentas==5)
            {
                $bono_rentas=1500;
            }
            $vendedor_detalles=User::with('subarea')->find($pago_ejec->ejecutivo);
            PagosVendedor::create([
                            'calculo_id'=>$calculo->id,
                            'user_id'=>$pago_ejec->ejecutivo,
                            'nombre'=>$vendedor_detalles->name,
                            'sucursal'=>$vendedor_detalles->subarea->nombre,
                            'comisiones'=>$pago_ejec->comision,
                            'bono_rentas'=>$bono_rentas,
                            'total_pago'=>$pago_ejec->comision+$bono_rentas
            ]);
        }
    }

    public function pagos_gerente($calculo)
    {
        $sql_ventas="
        select area,sub_area,sum(comision) as comision from
        (
        SELECT ventas.area,ventas.sub_area,sum(comision_ventas.comision_gerente) as comision 
                                FROM comision_ventas,ventas 
                                where comision_ventas.venta_id=ventas.id and comision_ventas.calculo_id=".$calculo->id." 
                                group by ventas.area,ventas.sub_area
        UNION
        SELECT ventas.area,ventas.sub_area,sum(comision_addons.comision_gerente) as comision 
                                FROM comision_addons,ventas 
                                where comision_addons.venta_id=ventas.id and comision_addons.calculo_id=".$calculo->id." 
                                group by ventas.area,ventas.sub_area
         ) as a group by a.area,a.sub_area
         ";
        $ventas_gerente=DB::select(DB::raw($sql_ventas));
        $ventas_gerente=collect($ventas_gerente);
        foreach($ventas_gerente as $comisiones_gerente)
        {
            $cuota_asignacion=GerenteTiendaCuota::where('periodo_id',$calculo->periodo_id)
                                    ->where('area',$comisiones_gerente->area)
                                    ->where('sub_area',$comisiones_gerente->sub_area)
                                    ->get()
                                    ->first();
            $usuario=User::find($cuota_asignacion->gerente_id);
            $subarea=SubArea::find($comisiones_gerente->sub_area);
            PagosVendedor::create([
                'calculo_id'=>$calculo->id,
                'user_id'=>$cuota_asignacion->gerente_id,
                'nombre'=>$usuario->name,
                'sucursal'=>$subarea->nombre,
                'comisiones'=>$comisiones_gerente->comision,
                'bono_rentas'=>0,
                'total_pago'=>$comisiones_gerente->comision,
                'rol'=>'GERENTE' 
                ]);
        }
        
    }

    public function seguimiento_calculo(Request $request)
    {
        $calculos=Calculo::with('periodo')
                            ->where('visible',1)
                            ->orderBy('id','desc')
                            ->get();
        return view ('seguimiento_calculo',['calculos'=>$calculos]);
    }

    public function detalle_calculo(Request $request)
    {
        $calculo=Calculo::with('periodo')->find($request->id);

        $ventas=Venta::select(DB::raw('count(*) as n'))
                        ->where('fecha','>=',$calculo->periodo->f_inicio)
                        ->where('fecha','<=',$calculo->periodo->f_fin)
                        ->get()->first()->n;
        $validadas=0;
        
        $calculo=Calculo::with('periodo')->find($request->id);

        $pagos=PagosVendedor::select(DB::raw('count(*) as n'))
                            ->where('calculo_id',$calculo->id)
                            ->get()->first()->n;
        $pagos_ejec=PagosVendedor::select(DB::raw('count(*) as n'))
                            ->where('rol','EJECUTIVO')
                            ->where('calculo_id',$calculo->id)
                            ->get()->first()->n;

        return (view('detalle_calculo',['ventas'=>$ventas,
                                        'validadas'=>$validadas,
                                        'calculo'=>$calculo,
                                        'pagos'=>$pagos,
                                        'pagos_ejec'=>$pagos_ejec,
                                        'pagos_gte'=>$pagos-$pagos_ejec,
                                    ]));
    }

    public function export_pagos_vendedor(Request $request)
    {
        $pagos=PagosVendedor::with('ejecutivo','ejecutivo.subarea')->where('calculo_id',$request->id)->get();
        return(view('export_pagos_vendedor',['pagos'=>$pagos]));
    }

    public function export_comisiones_vendedor(Request $request)
    {
        $sql_comisiones="
                         SELECT ventas.*,comision_ventas.comision_vendedor,comision_ventas.comision_gerente 
                         FROM comision_ventas,ventas  
                         WHERE comision_ventas.venta_id=ventas.id
                         AND comision_ventas.calculo_id='".$request->id."'
                         ";

        $sql_addons="
                        SELECT ventas.*,comision_addons.tipo as tipo_addon,comision_addons.comision_vendedor,comision_addons.comision_gerente 
                        FROM comision_addons,ventas  
                        WHERE comision_addons.venta_id=ventas.id
                        AND comision_addons.calculo_id='".$request->id."'
                        ";

        $comisiones=DB::select(DB::raw($sql_comisiones));
        $comisiones=collect($comisiones);
        $comisiones_addon=DB::select(DB::raw($sql_addons));
        $comisiones_addon=collect($comisiones_addon);
        $usuarios=User::all();
        $planes=Plan::all();

        $usuario_tienda=$usuarios->pluck('sub_area','id');

        $usuarios=$usuarios->pluck('name','id');
        $planes=$planes->pluck('nombre','id');
        
        $tiendas=SubArea::all();
        $tiendas=$tiendas->pluck('nombre','id');
        return(view('export_comisiones_vendedor',['comisiones'=>$comisiones,'comisiones_addon'=>$comisiones_addon,'usuarios'=>$usuarios,'planes'=>$planes,'tiendas'=>$tiendas,'usuario_tienda'=>$usuario_tienda]));
    }
}
