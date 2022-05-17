<?php

namespace App\Http\Livewire\Venta;

use Livewire\Component;
use App\Models\Venta;

class DetalleVenta extends Component
{
    public $open=false;
    public $id_venta;

    public $tipo;
    public $cliente;
    public $ejecutivo;
    public $sucursal;
    public $mail_cliente;
    public $plan;
    public $renta;
    public $plazo;
    public $fecha;
    public $dn;
    public $propiedad;
    public $contrato;
    public $addon_control;
    public $observaciones;
    public $seguro_proteccion;

    public $validado;
    public $doc_completa;

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
        $this->open=true;
        $venta=Venta::with('det_ejecutivo','det_sucursal','det_plan')
                    ->find($this->id_venta);

        $this->cliente=$venta->cliente;
        $this->tipo=$venta->tipo;
        $this->plazo=$venta->plazo;
        $this->fecha=$venta->fecha;
        $this->mail_cliente=$venta->mail_cliente;
        $this->ejecutivo=$venta->det_ejecutivo->name;
        $this->plan=$venta->det_plan->nombre;
        $this->sucursal=$venta->det_sucursal->nombre;
        $this->renta=$venta->renta;
        $this->propiedad=$venta->propiedad;
        $this->contrato=$venta->co_id;
        $this->dn=$venta->dn;
        $this->observaciones=$venta->observaciones;
        $this->addon_control=$venta->addon_control;
        $this->seguro_proteccion=$venta->seguro_proteccion;
    }
    public function cancelar()
    {
        $this->open=false;
    }
}
