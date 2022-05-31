<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CisPospago;
use App\Models\CisRenovacion;
use App\Models\Venta;
use App\Imports\CisPospagoImport;
use App\Imports\CisRenovacionImport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ImportController extends Controller
{
    public function carga_cis_pospago(Request $request) 
    {
        $request->validate([
            'file'=> 'required',
            ]);
        $file=$request->file('file');

        $bytes = random_bytes(5);
        $carga_id=bin2hex($bytes);

        //return("&&".Str::slug('ID_ORDEN_CONTRATACION')."&&");

        $import=new CisPospagoImport;
        $import->setCargaId($carga_id);

        try{
        $import->import($file);
        }
        catch(\Maatwebsite\Excel\Validators\ValidationException $e) {
            return back()->withFailures($e->failures());
        }  

        $errores=$this->validar_carga_pospago($carga_id);
        if(!empty($errores))
        {
            $this->borrar_carga_erp($carga_id);
            return(back()->with('error_validacion',$errores));
        }

        $this->aplica_carga_pospago($carga_id);

        return back()->withStatus('Archivo cargado con exito!');
    }
    private function validar_carga_pospago($carga_id)
    {
        $cargados=CisPospago::select(DB::raw('distinct no_contrato_impreso'))
                                ->where('carga_id',$carga_id)
                                ->get();
        CisPospago::where('carga_id','!=',$carga_id)
                                ->whereIn('no_contrato_impreso',$cargados->pluck('no_contrato_impreso'))
                                ->delete();
    }

    private function aplica_carga_pospago($carga_id)
    {
        $cargados=CisPospago::select(DB::raw('max(fecha_contratacion) as ultimo,min(fecha_contratacion) as primero'))
                                ->where('carga_id',$carga_id)
                                ->get()->first();

        $ventas_periodo=Venta::where('tipo','ACTIVACION')
                                //->where('cis_id',0)
                                ->where('fecha','>=',$cargados->primero)
                                ->where('fecha','<=',$cargados->ultimo)
                                ->get();

        foreach($ventas_periodo as $venta_sin_validacion)
        {
            $contrato_final=0;
            $contrato_id_row=0;
            $contrato_resultado_c1=0;
            $contrato_resultado_c2=0;
            $contrato_resultado_c3=0;
            $contrato_row_c1=0;
            $contrato_row_c2=0;
            $contrato_row_c3=0;
            //CRITERIO 1 CO_ID
            $cargados=CisPospago::select('id','id_contrato')
                                ->where('carga_id',$carga_id)
                                ->where('id_contrato',$venta_sin_validacion->co_id)
                                ->get();
            $encontrados_c1=0;
            foreach($cargados as $encontrado)
            {
                $encontrados_c1=$encontrados_c1+1;
                $contrato_resultado_c1=$encontrado->id_contrato;
                $contrato_row_c1=$encontrado->id;
            }

            //CRITERIO (DN 0 DN DEFINITIVO) y CUENTA
            $cargados=CisPospago::select('id','id_contrato')
                                ->where('carga_id',$carga_id)
                                ->where(function ($query) use ($venta_sin_validacion)
                                    {
                                        $query->where('mdn_inicial',$venta_sin_validacion->dn);
                                        $query->orWhere('mdn_actual',$venta_sin_validacion->dn);
                                    })
                                ->where('cuenta_cliente',$venta_sin_validacion->cuenta)
                                ->get();
            $encontrados_c2=0;
            foreach($cargados as $encontrado)
            {
                $encontrados_c2=$encontrados_c2+1;
                $contrato_resultado_c2=$encontrado->id_contrato;
                $contrato_row_c2=$encontrado->id;
            }

            //CRITERIO SOLO CUENTA
            $cargados=CisPospago::select('id','id_contrato')
                                ->where('carga_id',$carga_id)
                                ->where('cuenta_cliente',$venta_sin_validacion->cuenta)
                                ->get();
            $encontrados_c3=0;
            foreach($cargados as $encontrado)
            {
                $encontrados_c3=$encontrados_c3+1;
                $contrato_resultado_c3=$encontrado->id_contrato;
                $contrato_row_c3=$encontrado->id;
            }

            //dd($encontrados_c1."-".$contrato_resultado_c1."-----".$encontrados_c2."-".$contrato_resultado_c2);

            if($encontrados_c1==1 && $encontrados_c2==1)
            {
                if($contrato_resultado_c2==$contrato_resultado_c1)
                {
                    $contrato_final=$contrato_resultado_c1;
                    $contrato_id_row=$contrato_row_c1;
                }
                if($contrato_resultado_c2!=$contrato_resultado_c1)
                    $contrato_final=-1;
            }

            if($encontrados_c1==0 && $encontrados_c2==1)
            {
                    $contrato_final=$contrato_resultado_c2;
                    $contrato_id_row=$contrato_row_c2;
            }

            if($encontrados_c1==1 && $encontrados_c2==0)
            {
                    $contrato_final=$contrato_resultado_c1;
                    $contrato_id_row=$contrato_row_c1;
            }

            if($encontrados_c1==0 && $encontrados_c2==0)
            {
                    $contrato_final=0;
            }

            if($encontrados_c1>1 || $encontrados_c2>1)
            {
                    $contrato_final=-1;
            }

            if($contrato_final==0)
            {
                if($encontrados_c3==1)
                {
                    $contrato_final=$contrato_resultado_c3;
                    $contrato_id_row=$contrato_row_c3;
                }
                if($encontrados_c3>1)
                {
                    $contrato_final=-1;   
                }
            }
            
        Venta::where('id',$venta_sin_validacion->id)->update([
                                            'cis_id'=>$contrato_final,
                                            'cis_row_id'=>$contrato_id_row
                                        ]);
        if($contrato_final>0)
        {
            Venta::where('id',$venta_sin_validacion->id)->update([
                'co_id'=>$contrato_final,
            ]);
        }

        }
    }

    public function carga_cis_renovacion(Request $request) 
    {
        $request->validate([
            'file'=> 'required',
            ]);
        $file=$request->file('file');

        $bytes = random_bytes(5);
        $carga_id=bin2hex($bytes);

        //return("&&".Str::slug('ID_ORDEN_CONTRATACION')."&&");

        $import=new CisRenovacionImport;
        $import->setCargaId($carga_id);

        try{
        $import->import($file);
        }
        catch(\Maatwebsite\Excel\Validators\ValidationException $e) {
            return back()->withFailures($e->failures());
        }  

        $errores=$this->validar_carga_renovacion($carga_id);
        if(!empty($errores))
        {
            $this->borrar_carga_erp($carga_id);
            return(back()->with('error_validacion',$errores));
        }

        $this->aplica_carga_renovacion($carga_id);

        return back()->withStatus('Archivo cargado con exito!');
    }
    private function validar_carga_renovacion($carga_id)
    {
        $cargados=CisRenovacion::select(DB::raw('distinct no_contrato_impreso'))
                                ->where('carga_id',$carga_id)
                                ->get();
        CisRenovacion::where('carga_id','!=',$carga_id)
                                ->whereIn('no_contrato_impreso',$cargados->pluck('no_contrato_impreso'))
                                ->delete();
    }

    private function aplica_carga_renovacion($carga_id)
    {
        $cargados=CisRenovacion::select(DB::raw('max(fecha_activacion_contrato) as ultimo,min(fecha_activacion_contrato) as primero'))
                                ->where('carga_id',$carga_id)
                                ->get()->first();
        $ventas_periodo=Venta::where('tipo','RENOVACION')
                                //->where('cis_id',0)
                                ->where('fecha','>=',$cargados->primero)
                                ->where('fecha','<=',$cargados->ultimo)
                                ->get();

        foreach($ventas_periodo as $venta_sin_validacion)
        {
            $contrato_final=0;
            $contrato_id_row=0;
            $contrato_resultado_c1=0;
            $contrato_resultado_c2=0;
            $contrato_resultado_c3=0;
            $contrato_row_c1=0;
            $contrato_row_c2=0;
            $contrato_row_c3=0;
            //CRITERIO 1 CO_ID
            $cargados=CisRenovacion::select('id','co_id')
                                ->where('carga_id',$carga_id)
                                ->where('co_id',$venta_sin_validacion->co_id)
                                ->get();
            $encontrados_c1=0;
            foreach($cargados as $encontrado)
            {
                $encontrados_c1=$encontrados_c1+1;
                $contrato_resultado_c1=$encontrado->co_id;
                $contrato_row_c1=$encontrado->id;
            }

            //CRITERIO (DN 0 DN DEFINITIVO) y CUENTA
            $cargados=CisRenovacion::select('id','co_id')
                                ->where('carga_id',$carga_id)
                                ->where(function ($query) use ($venta_sin_validacion)
                                    {
                                        $query->where('dn_actual',$venta_sin_validacion->dn);
                                    })
                                ->where('cuenta_cliente',$venta_sin_validacion->cuenta)
                                ->get();
            $encontrados_c2=0;
            foreach($cargados as $encontrado)
            {
                $encontrados_c2=$encontrados_c2+1;
                $contrato_resultado_c2=$encontrado->co_id;
                $contrato_row_c2=$encontrado->id;
            }

            //CRITERIO SOLO CUENTA
            $cargados=CisRenovacion::select('id','co_id')
                                ->where('carga_id',$carga_id)
                                ->where('cuenta_cliente',$venta_sin_validacion->cuenta)
                                ->get();
            $encontrados_c3=0;
            foreach($cargados as $encontrado)
            {
                $encontrados_c3=$encontrados_c3+1;
                $contrato_resultado_c3=$encontrado->co_id;
                $contrato_row_c2=$encontrado->id;
            }


            //dd($encontrados_c1."-".$contrato_resultado_c1."-----".$encontrados_c2."-".$contrato_resultado_c2);

            if($encontrados_c1==1 && $encontrados_c2==1)
            {
                if($contrato_resultado_c2==$contrato_resultado_c1)
                {
                    $contrato_final=$contrato_resultado_c1;
                    $contrato_id_row=$contrato_row_c1;
                }
                if($contrato_resultado_c2!=$contrato_resultado_c1)
                    $contrato_final=-1;
            }

            if($encontrados_c1==0 && $encontrados_c2==1)
            {
                    $contrato_final=$contrato_resultado_c2;
                    $contrato_id_row=$contrato_row_c2;
            }

            if($encontrados_c1==1 && $encontrados_c2==0)
            {
                    $contrato_final=$contrato_resultado_c1;
                    $contrato_id_row=$contrato_row_c1;
            }

            if($encontrados_c1==0 && $encontrados_c2==0)
            {
                    $contrato_final=0;
            }

            if($encontrados_c1>1 || $encontrados_c2>1)
            {
                    $contrato_final=-1;
            }

            if($contrato_final==0)
            {
                if($encontrados_c3==1)
                {
                    $contrato_final=$contrato_resultado_c3;
                    $contrato_id_row=$contrato_row_c3;
                }
                if($encontrados_c3>1)
                {
                    $contrato_final=-1;   
                }
            }

            
            Venta::where('id',$venta_sin_validacion->id)->update([
                'cis_id'=>$contrato_final,
                'cis_row_id'=>$contrato_id_row
            ]);

            if($contrato_final>0)
            {
                Venta::where('id',$venta_sin_validacion->id)->update([
                    'co_id'=>$contrato_final,
                ]);
            }

        }
    }
}
