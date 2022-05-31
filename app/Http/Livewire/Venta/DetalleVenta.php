<?php

namespace App\Http\Livewire\Venta;

use Livewire\Component;
use App\Models\Venta;
use App\Models\Plan;
use App\Models\CisPospago;
use App\Models\CisRenovacion;
use Illuminate\Support\Facades\DB;

class DetalleVenta extends Component
{
    public $open=false;
    public $id_venta;

    public $procesando=0;
    public $procesando2=0;

    public $planes=[];
    public $cliente;
    public $tipo;
    public $plazo;
    public $fecha;
    public $mail_cliente;
    public $ejecutivo;
    public $plan;
    public $sucursal;
    public $renta;
    public $propiedad;
    public $iccid;
    public $contrato;
    public $cuenta;
    public $orden;
    public $dn;
    public $imei;
    public $equipo;
    public $observaciones;
    public $addon_control;
    public $seguro_proteccion;
    public $renta_seguro;
    public $rfc;

    public $cis_id;
    public $cis_details=[];
    public $cis_opciones=[];

    public $plan_id;

    public $venta_doc_completa;
    public $pagar;

    public function render()
    {
        return view('livewire.venta.detalle-venta');
    }
    public function mount($id_venta)
    {
        $this->id_venta=$id_venta;
    }
    public function abrir()
    {
        $this->procesando=0;
        $this->open=true;
        $venta=Venta::with('det_ejecutivo','det_sucursal','det_plan')
                    ->find($this->id_venta);
        
        $this->planes=Plan::all();
        $this->cliente=$venta->cliente;
        $this->tipo=$venta->tipo;
        $this->plazo=$venta->plazo;
        $this->fecha=$venta->fecha;
        $this->mail_cliente=$venta->mail_cliente;
        $this->ejecutivo=$venta->det_ejecutivo->name;
        $this->plan=$venta->det_plan->nombre;
        $this->plan_id=$venta->plan;
        $this->sucursal=$venta->det_sucursal->nombre;
        $this->renta=$venta->renta;
        $this->propiedad=$venta->propiedad;
        $this->iccid=$venta->iccid;
        $this->contrato=$venta->co_id;
        $this->cuenta=$venta->cuenta;
        $this->orden=$venta->orden;
        $this->dn=$venta->dn;
        $this->imei=$venta->imei;
        $this->equipo=$venta->equipo;
        $this->observaciones=$venta->observaciones;
        $this->addon_control=$venta->addon_control;
        $this->seguro_proteccion=$venta->seguro_proteccion;
        $this->renta_seguro=$venta->renta_seguro;
        $this->rfc=$venta->rfc;
        $this->cis_id=$venta->cis_id;
        $this->cis_row_id=$venta->cis_row_id;

        $DN=$this->dn;
        $CUENTA=$this->cuenta;

        $this->cis_opciones=[];

        $this->venta_doc_completa=$venta->doc_completa;
        $this->pagar=$venta->pagar;

        if($this->cis_id>0)
        {
            if($this->tipo=="ACTIVACION")
            {
                $detalle_cis=CisPospago::where('id',$this->cis_row_id)
                                    ->get()
                                    ->first();
                $this->cis_details[]=[
                                    'impreso'=>$detalle_cis->no_contrato_impreso,
                                    'orden'=>$detalle_cis->id_orden_contratacion,                                    
                                    'cuenta'=>$detalle_cis->cuenta_cliente,
                                    'cliente'=>$detalle_cis->nombre_cliente,
                                    'dn'=>"ini : ".$detalle_cis->mdn_inicial." | def :".$detalle_cis->mdn_actual,                                    
                                    'co_id'=>$detalle_cis->id_contrato,
                                    'servicio'=>$detalle_cis->plan_tarifario_homo." | ".$detalle_cis->nva_renta." | ".$detalle_cis->plazo_forzoso,
                                    'ejecutivo'=>$detalle_cis->cve_unica_ejecutivo." | ".$detalle_cis->nombre_ejecutivo_unico." | ".$detalle_cis->nombre_pdv_unico,
                                    'estatus'=>$detalle_cis->fecha_contratacion." | ".$detalle_cis->status_orden." | ".$detalle_cis->fecha_status_orden,
                                ];
            }
            if($this->tipo=="RENOVACION")
            {
                $detalle_cis=CisRenovacion::where('id',$this->cis_row_id)
                                    ->get()
                                    ->first();
                $this->cis_details[]=[
                                    'impreso'=>$detalle_cis->no_contrato_impreso,
                                    'orden'=>$detalle_cis->id_orden_renovacion,
                                    'cuenta'=>$detalle_cis->cuenta_cliente,
                                    'cliente'=>"No identificado",
                                    'dn'=>$detalle_cis->dn_actual,
                                    'co_id'=>$detalle_cis->co_id,
                                    'servicio'=>$detalle_cis->plan_actual." | ".$detalle_cis->renta_actual." | ".$detalle_cis->plazo_actual,
                                    'ejecutivo'=>$detalle_cis->id_ejecutivo." | ".$detalle_cis->nombre_ejecutivo,
                                    'estatus'=>$detalle_cis->fecha_activacion_contrato." | ".$detalle_cis->status_renovacion." | ".$detalle_cis->fecha_status,
                                ];
            }
        }
        if($this->cis_id=="-1") //NO SE PUDO INDETIFICAR CON CRITERIO AUTOMATICO
        {
            if($this->tipo=="ACTIVACION")
            {
                $cargados=CisPospago::where('id_contrato',$this->contrato)
                                ->orWhere(function ($query) use ($DN,$CUENTA) {
                                    $query->where(function ($query2) use ($DN,$CUENTA)
                                    {
                                        $query2->where('mdn_inicial',$DN);
                                        $query2->orWhere('mdn_actual',$DN);
                                        });
                                    $query->where('cuenta_cliente',$CUENTA);
                                })
                                ->orWhere('cuenta_cliente',$CUENTA)
                                ->get();
                foreach($cargados as $opcion)
                {
                    $usado="NO";
                    $contrato_usado=Venta::select(DB::raw('count(*) as n'))->where('cis_row_id',$opcion->id)->get()->first();
                    if($contrato_usado->n!="0")
                    {
                        $usado="SI";
                    }
                    $this->cis_opciones[]=[
                        'id'=>$opcion->id,
                        'impreso'=>$opcion->no_contrato_impreso,
                        'orden'=>$opcion->id_orden_contratacion,                                    
                        'cuenta'=>$opcion->cuenta_cliente,
                        'cliente'=>$opcion->nombre_cliente,
                        'dn'=>"ini : ".$opcion->mdn_inicial." | def :".$opcion->mdn_actual,                                    
                        'co_id'=>$opcion->id_contrato,
                        'servicio'=>$opcion->plan_tarifario_homo." | ".$opcion->nva_renta." | ".$opcion->plazo_forzoso,
                        'ejecutivo'=>$opcion->cve_unica_ejecutivo." | ".$opcion->nombre_ejecutivo_unico." | ".$opcion->nombre_pdv_unico,
                        'estatus'=>$opcion->fecha_contratacion." | ".$opcion->status_orden." | ".$opcion->fecha_status_orden,
                        'usado'=>$usado
                    ];
                }
            }
            if($this->tipo=="RENOVACION")
            {
                $cargados=CisRenovacion::where('co_id',$this->contrato)
                                ->orWhere(function ($query) use ($DN,$CUENTA) {
                                    $query->where('dn_actual',$DN);
                                    $query->where('cuenta_cliente',$CUENTA);
                                })
                                ->orWhere('cuenta_cliente',$CUENTA)
                                ->get();
                //dd($cargados);
                foreach($cargados as $opcion)
                {
                    $usado="NO";
                    $contrato_usado=Venta::select(DB::raw('count(*) as n'))->where('cis_row_id',$opcion->id)->get()->first();
                    if($contrato_usado->n!="0")
                    {
                        $usado="SI";
                    }
                    $this->cis_opciones[]=[
                        'id'=>$opcion->id,
                        'impreso'=>$opcion->no_contrato_impreso,
                        'orden'=>$opcion->id_orden_renovacion,
                        'cuenta'=>$opcion->cuenta_cliente,
                        'cliente'=>"No identificado",
                        'dn'=>$opcion->dn_actual,
                        'co_id'=>$opcion->co_id,
                        'servicio'=>$opcion->plan_actual." | ".$opcion->renta_actual." | ".$opcion->plazo_actual,
                        'ejecutivo'=>$$opcion->id_ejecutivo." | ".$opcion->nombre_ejecutivo,
                        'estatus'=>$opcion->fecha_activacion_contrato." | ".$opcion->status_renovacion." | ".$opcion->fecha_status,
                        'usado'=>$usado
                    ];
                }
            }
            //dd($this->cis_opciones);
        }

    }
    public function cancelar()
    {
        $this->open=false;
    }
    public function guardar()
    {
        $this->validate([
            'tipo' => 'required',
            'fecha' => 'required',
            'cliente' => 'required',
            'mail_cliente'=>'required|email',
            'rfc'=>'exclude_if:tipo,ACCESORIO|exclude_if:tipo,PREPAGO|required',
            'plan_id'=>'required',
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
            'renta_seguro'=>'numeric|exclude_if:tipo,PREPAGO|exclude_if:tipo,ACCESORIO|exclude_if:seguro_proteccion,0|required|min:1',
        ],
        [
            'required' => 'Campo requerido.',
            'numeric'=>'Debe ser un numero',
            'email'=>'Indique una direccion de correo valida',
            'unique'=>'Valor duplicado en base de datos',
            'digits'=>'Debe contener 10 digitos',
            'min'=>'Valor invalido'
        ]);

        $this->procesando=1;

        Venta::where('id',$this->id_venta)->update([
            'cliente'=>$this->cliente,
            'mail_cliente'=>$this->mail_cliente,
            'rfc'=>$this->rfc,
            'fecha'=>$this->fecha,
            'tipo'=>$this->tipo,
            'plan'=>$this->plan_id,
            'renta'=>$this->renta,
            'plazo'=>$this->plazo,
            'dn'=>$this->dn,
            'equipo'=>$this->equipo,
            'propiedad'=>$this->propiedad,
            'imei'=>$this->imei,
            'iccid'=>$this->iccid,
            'co_id'=>$this->contrato,
            'cuenta'=>$this->cuenta,
            'orden'=>$this->orden,
            'addon_control'=>$this->addon_control,
            'seguro_proteccion'=>$this->seguro_proteccion,
            'renta_seguro'=>$this->seguro_proteccion==0?0:$this->renta_seguro,
            'observaciones'=>$this->observaciones,
            'doc_completa'=>$this->venta_doc_completa,
            'pagar'=>$this->pagar,
                ]);
        $this->open=false;
        return redirect(request()->header('Referer'));
    }
    public function mapear($cis_id,$cis_row_id)
    {
        $procesando2=1;
        Venta::where('id',$this->id_venta)->update([
                            'co_id'=>$cis_id,
                            'cis_id'=>$cis_id,
                            'cis_row_id'=>$cis_row_id
                            ]);
        //dd($cis_id."-".$cis_row_id);
        $this->abrir();
        $procesando2=0;
    }
    public function updatedVentaDocCompleta()
    {
        if($this->venta_doc_completa=="1" && $this->cis_id>0)
         $this->pagar=1;
    }
}
