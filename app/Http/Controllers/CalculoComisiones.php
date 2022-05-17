<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Periodo;
use App\Models\Calculo;
use App\Models\Venta;
use App\Models\MedicionVendedor;
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
        return($this->mediciones($calculo));
        return($calculo);
    }
    public function acreditar_ventas($calculo)
    {
        return;
    }
    private function mediciones($calculo)
    {
        return($this->medicion_vendedor($calculo));
        $this->medicion_gerente($calculo);
    }
    private function medicion_vendedor($calculo)
    {
        MedicionVendedor::where('calculo_id',$calculo->id)->delete();
        $sql_mediciones="SELECT ejecutivo,count(*) as ventas,sum(renta) as rentas 
                        FROM `ventas` WHERE fecha>='".$calculo->periodo->f_inicio."' and fecha<='".$calculo->periodo->f_fin."' 
                        and tipo='ACTIVACION' 
                        and plan in (select id from plans where nombre like '%ARMALO%') 
                        group by ejecutivo";
        $mediciones=DB::select(DB::raw($sql_mediciones));
        $mediciones=collect($mediciones);
        foreach($mediciones as $medicion)
        {
            $bv=0;
            $br=0;
            if($medicion->ventas==0)
            {
                $bv=1;
            }
            if($medicion->ventas>0 && $medicion->ventas<=4)
            {
                $bv=2;
            }
            if($medicion->ventas>4 && $medicion->ventas<=7)
            {
                $bv=3;
            }
            if($medicion->ventas>7 && $medicion->ventas<=10)
            {
                $bv=4;
            }
            if($medicion->ventas>10 && $medicion->ventas<=13)
            {
                $bv=5;
            }
            if($medicion->ventas>13)
            {
                $bv=6;
            }

            if($medicion->rentas>=1675 && $medicion->rentas<=2340.999999)
            {
                $br=1;
            }
            if($medicion->rentas>2340.999999 && $medicion->rentas<=2930.999999)
            {
                $br=2;
            }
            if($medicion->rentas>2930.999999 && $medicion->rentas<=3340.999999)
            {
                $br=3;
            }
            if($medicion->rentas>3340.999999 && $medicion->rentas<=4180.999999)
            {
                $br=4;
            }
            if($medicion->rentas>4180.999999)
            {
                $br=5;
            }
            MedicionVendedor::create([
                            'calculo_id'=>$calculo->id,
                            'ventas'=>$medicion->ventas,
                            'rentas'=>$medicion->rentas,
                            'bracket_ventas'=>$bv,
                            'bracket_rentas'=>$br
            ]);
        }
        return($mediciones);
    }
    private function medicion_gerente($calculo)
    {

    }
    private function pago_comisiones($calculo)
    {
        $this->comisiones_vendedor($calculo);
        $this->comisiones_gerente($calculo);
    }
    private function comisiones_vendedor($calculo)
    {

    }
    private function comisiones_gerente($calculo)
    {

    }
}
