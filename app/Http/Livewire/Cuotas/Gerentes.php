<?php

namespace App\Http\Livewire\Cuotas;

use App\Models\GerenteTiendaCuota;
use App\Models\Periodo;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Livewire\Component;

class Gerentes extends Component
{
    public $periodos=[];
    public $detalles=[];
    public $gerentes;
    public $periodo_id;
    public $desc_seleccionado;

    public $open_confirm_nuevo=false;
    public $siguiente_periodo_desc;
    public $siguiente_periodo_id;
    public $ultimo_periodo_id;
    public $procesando=0;

    public function render()
    {
        return view('livewire.cuotas.gerentes');
    }
    public function mount()
    {
        $this->gerentes=User::where('puesto',2)
                                ->whereIn('area',[2,3,6])
                                ->orderBy('name')
                                ->get();
        $this->actualiza_periodos();
    }
    private function actualiza_periodos()
    {
        $periodos_actuales=GerenteTiendaCuota::select(DB::raw('distinct periodo_id'))
                                                ->get();
        $periodos_actuales=$periodos_actuales->pluck('periodo_id');
        $this->periodos=Periodo::whereIn('id',$periodos_actuales)->orderBy('id','desc')->get()->take(12);

        $this->ultimo_periodo_id=$this->periodos->first()->id;
        $this->siguiente_periodo_desc=Periodo::find(1+$this->ultimo_periodo_id)->descripcion;
        $this->siguiente_periodo_id=1+$this->ultimo_periodo_id;
    }
    public function detalle($periodo_id,$descripcion)
    {
        $this->periodo_id=$periodo_id;
        $this->desc_seleccionado=$descripcion;
        $this->detalles=[];
        $cuotas_gerentes=GerenteTiendaCuota::with('tienda')->where('periodo_id',$periodo_id)->get();
        foreach($cuotas_gerentes as $cuota)
        {
            $this->detalles[]=[
                                'periodo_id'=>$periodo_id,
                                'gerente_id'=>$cuota->gerente_id,
                                'subarea'=>$cuota->sub_area,
                                'cuota_ventas'=>$cuota->cuota_ventas,
                                'tienda'=>$cuota->tienda->nombre,
                              ];
        }
    }
    public function guardar()
    {
        foreach($this->detalles as $detalle_cuota)
        {
            GerenteTiendaCuota::where('periodo_id',$this->periodo_id)
                                ->where('sub_area',$detalle_cuota['subarea'])
                                ->update([
                                        'gerente_id'=>$detalle_cuota['gerente_id'],
                                        'cuota_ventas'=>$detalle_cuota['cuota_ventas'],
                                ]);
        }
        $this->emit('alert_ok','Cuotas del periodo '.$this->desc_seleccionado.' actualizadas con exito!');
    }
    public function confirma_nuevo()
    {
        $this->procesando=0;
        $this->open_confirm_nuevo=true;
    }
    public function nuevo_periodo()
    {
        $this->procesando=1;
        $ultimas_cuotas=GerenteTiendaCuota::where('periodo_id',$this->ultimo_periodo_id)
                                            ->get();
        foreach($ultimas_cuotas as $ultima)
        {
            GerenteTiendaCuota::create([
                'periodo_id'=>$this->siguiente_periodo_id,
                'gerente_id'=>$ultima->gerente_id,
                'area'=>$ultima->area,
                'sub_area'=>$ultima->sub_area,
                'cuota_ventas'=>$ultima->cuota_ventas
            ]);
            
        }
        $this->open_confirm_nuevo=false;
        $this->actualiza_periodos();
        $this->emit('alert_ok','Cuotas del nuevo periodo generadas con exito!');
    }
}
