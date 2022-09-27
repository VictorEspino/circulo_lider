<?php

namespace App\Imports;

use App\Models\CallidusVenta;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithBatchInserts;

class ImportCallidusVentas implements ToModel,WithHeadingRow,WithValidation,WithBatchInserts
{
    use Importable;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        
        $fecha_raw=$row['fecha'];
        $fecha=\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($fecha_raw);
        $fecha_baja_raw=$row['fecha_baja'];
        if($fecha_baja_raw!="")
        {
            $fecha_baja=\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($fecha_baja_raw);
        }
        else
        {
            $fecha_baja=null;
        }
        $id=session('id_conciliacion');

        $respuesta=$this->valida_comision_pagada($row['razon_0'],trim($row['tipo']),trim($row['plan']),trim($row['propiedad']),$row['plazo'],$row['renta'],$row['alcance'],$row['comision']);
        //dd($respuesta['monto']);
        return new CallidusVenta([
            'conciliacion_id'=>$id,
            'tipo'=> trim($row['tipo']),
            'cliente'=>trim($row['cliente']),
            'periodo'=> trim($row['periodo']),
            //'cuenta'=> trim($row['cuenta']),
            'contrato'=> trim($row['contrato']),
            'plan'=> trim($row['plan']),
            'dn'=> trim($row['dn']),
            'propiedad'=> trim($row['propiedad']),
            'modelo'=> trim($row['modelo']),
            'fecha'=> $fecha,
            'fecha_baja'=> $fecha_baja,
            'plazo'=> $row['plazo'],
            'descuento_multirenta'=> $row['descuento_multirenta']*100,
            'afectacion_comision'=> $row['afectacion_comision']*100,
            'comision'=> $row['comision'],
            'renta'=> $row['renta'],
            'tipo_baja'=> $row['tipo_baja'],
            'razon_0'=> $row['razon_0'],
            'logro'=> $row['logro'],
            'cuota'=> $row['cuota'],
            'alcance'=> $row['alcance'],
            'estatus'=>$respuesta['estatus'],
            'monto_reclamo'=>$respuesta['monto']
        ]);
    }
    public function rules(): array
    {
        return [
            '*.tipo' => ['required'],
            '*.periodo' => ['required'],
            //'*.cuenta' => ['required'],
            '*.contrato' => ['required'],
            //'*.plan' => ['required'],
            //'*.dn' => ['required','exclude_if:*.tipo,DESACTIVACION_DESACTIVACIONES','exclude_if:*.tipo,ADDON','exclude_if:*.tipo,ADDON_DESACTIVACION','digits:10'],
            //'*.propiedad' => ['required'],
            '*.fecha' => ['required'],
            '*.plazo' => ['required','numeric'],
            //'*.descuento_multirenta' => ['required','numeric'],
            '*.comision' => ['required'],
            '*.renta' => ['required','numeric'],
            '*.tipo_baja'=>['exclude_unless:*.tipo,DESACTIVACION_DESACTIVACIONES','required'],
        ];
    }
    public function batchSize(): int
    {
        return 1000;
    }
    public function valida_comision_pagada($razon_0,$tipo,$plan,$propiedad,$plazo,$renta,$alcance,$comision)
    {
        $respuesta=[
                    'estatus'=>1,
                    'monto'=>0
                    ];
        if($tipo=="ADDON_DESACTIVACION" || $tipo=="DESACTIVACION_DESACTIVACIONES" || $razon_0=="DESACTIVADO MISMO MES") 
        return($respuesta);
        

        $comision_correcta=0;
        if($tipo=="ACCESORIOS")
            {
                $comision_correcta=($renta/1.16/1.03)*0.2;
            }
        if($tipo=="ADDON")
            {
                $comision_correcta=($renta/1.16/1.03)*3;
            }
        if($tipo=="ACTIVACION_ACTIVACIONES")
            {
                if(strpos($plan,"SIMPLE")!==false)
                {
                    if($plazo==6){$comision_correcta=76;}
                    if($plazo==12){$comision_correcta=($renta/1.16/1.03)*1.5;}
                    if($plazo==18){$comision_correcta=($renta/1.16/1.03)*2.5;}
                    if($plazo==24){$comision_correcta=($renta/1.16/1.03)*3.0;}
                }
                if(strpos($plan,"ARMALO")!==false)
                {
                    $base=0;
                    if(strpos($plan,"3")!==false)
                    {
                        $base=1055;
                    }
                    if(strpos($plan,"5")!==false)
                    {
                        $base=1930;
                    }
                    if(strpos($plan,"11")!==false)
                    {
                        $base=2565;
                    }
                    if(strpos($plan,"17")!==false)
                    {
                        $base=3519;
                    }
                    if(strpos($plan,"26")!==false)
                    {
                        $base=4780;
                    }
                    if(strpos($plan,"40")!==false)
                    {
                        $base=6704;
                    }

                    //CHECA ACELERADOR 1
                    $acelerador=0;
                    if($alcance>=1)
                    {
                        $acelerador=$base*1.03;
                    }
                    if($alcance>=1.05)
                    {
                        $acelerador=$base*1.08;
                    }
                    if($alcance>=1.01 && $renta>=499)
                    {
                        $acelerador=50;
                    }

                    //CHECA PE
                    $performace_element=0;
                    if($propiedad=="NUEVO")
                    {
                        $performace_element=100;

                        if($alcance>=0.9)
                        {
                            $performace_element=300*$alcance;
                        }
                        if($alcance>=1)
                        {
                            $performace_element=300;
                        }
                    }
                $comision_correcta=$base+$acelerador+$performace_element;
                }
            }
            if($tipo=="RENOVACIONES")
            {
                if(strpos($plan,"SIMPLE")!==false)
                {
                    if($plazo==6){$comision_correcta=75;}
                    if($plazo==12){$comision_correcta=($renta/1.16/1.03)*1.5;}
                    if($plazo==18){$comision_correcta=($renta/1.16/1.03)*2.5;}
                    if($plazo==24){$comision_correcta=($renta/1.16/1.03)*3;}
                }
                if(strpos($plan,"ARMALO")!==false)
                {
                    $base=0;
                    if(strpos($plan,"3")!==false)
                    {
                        $base=1055;
                    }
                    if(strpos($plan,"5")!==false)
                    {
                        $base=1930;
                    }
                    if(strpos($plan,"9")!==false)
                    {
                        $base=2524;
                    }
                    if(strpos($plan,"11")!==false)
                    {
                        $base=2565;
                    }
                    if(strpos($plan,"14")!==false)
                    {
                        $base=3066;
                    }
                    if(strpos($plan,"17")!==false)
                    {
                        $base=3519;
                    }
                    if(strpos($plan,"20")!==false)
                    {
                        $base=4019;
                    }
                    if(strpos($plan,"26")!==false)
                    {
                        $base=4780;
                    }
                    if(strpos($plan,"40")!==false)
                    {
                        $base=6704;
                    }                    
                $comision_correcta=$base;
                }
            }
        $delta=$comision-$comision_correcta;
        if($delta<-1.5 || $delta>1.5)
        {
            $respuesta=[
                'estatus'=>0,
                'monto'=>$delta,
                ];
        }

        return($respuesta);

    }
}
