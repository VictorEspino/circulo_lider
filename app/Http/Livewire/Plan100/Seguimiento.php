<?php

namespace App\Http\Livewire\Plan100;

use Livewire\Component;
use App\Models\Plan100;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Seguimiento extends Component
{
    public $plan100=[];
    public $circulo1=[];
    public $circulo2=[];
    public $circulo3=[];

    public $show1=true;
    public $show2=false;
    public $show3=false;

    public $completos_c1=0;
    public $completos_c2=0;
    public $completos_c3=0;

    protected $listeners = ['datos_guardados' => 'mount'];

    public function render()
    {
        return view('livewire.plan100.seguimiento');
    }
    public function mount()
    {
        $registros=Plan100::select(DB::raw('count(*) as n'))
                    ->where('user_id',Auth::user()->id)
                    ->get()
                    ->first();
        if($registros->n==0)
        {
            for($x=1;$x<=10;$x++)
            {
                $registro=Plan100::create([
                    'user_id'=>Auth::user()->id,
                    'circulo'=>1,
                    'padre'=>0
                ]);
                for($y=1;$y<=3;$y++)
                {
                    $registro2=Plan100::create([
                        'user_id'=>Auth::user()->id,
                        'circulo'=>2,
                        'padre'=>$registro->id,
                    ]);
                    for($z=1;$z<=2;$z++)
                    {
                        $registro3=Plan100::create([
                            'user_id'=>Auth::user()->id,
                            'circulo'=>3,
                            'padre'=>$registro2->id,
                        ]);
                    }
                }
            }
        }

        $circulo1=Plan100::where('user_id',Auth::user()->id)
                            ->where('circulo',1)
                            ->orderBy('id','asc')
                            ->get();
        $this->circulo1=[];
        $this->completos_c1=0;
        foreach($circulo1 as $registro)
        {
            $this->circulo1[]=[
                'id'=>$registro->id,
                'nombre_contacto'=>$registro->nombre_contacto,
                'telefono'=>$registro->telefono,
                'compañia'=>$registro->compañia,
                'tipo_plan'=>$registro->tipo_plan,
                'gasto_mes'=>$registro->gasto_mes,
                'beneficios'=>$registro->beneficios,
                'equipo'=>$registro->equipo
            ];
            if((!is_null($registro->nombre_contacto) && $registro->nombre_contacto!='') &&
               (!is_null($registro->telefono) && $registro->telefono!='') &&
               (!is_null($registro->compañia) && $registro->compañia!='') &&
               (!is_null($registro->tipo_plan) && $registro->tipo_plan!='') &&
               (!is_null($registro->gasto_mes) && $registro->gasto_mes!='') &&
               (!is_null($registro->beneficios) && $registro->beneficios!='') &&
               (!is_null($registro->equipo) && $registro->equipo!='') 
             )
             {
                $this->completos_c1=$this->completos_c1+1;
             }
             
        }
        
        if($this->completos_c1==10) {$this->show2=true;}
        $this->completos_c2=0;
        $circulo2=Plan100::with('registro_padre')
                        ->where('user_id',Auth::user()->id)
                        ->where('circulo',2)
                        ->orderBy('id','asc')
                        ->get();
        $this->circulo2=[];
        $this->completos_c2=0;
        foreach($circulo2 as $registro)
        {
            $this->circulo2[]=[
                'id'=>$registro->id,
                'contacto_padre'=>$registro->registro_padre->nombre_contacto,
                'telefono_padre'=>$registro->registro_padre->telefono,
                'nombre_contacto'=>$registro->nombre_contacto,
                'telefono'=>$registro->telefono,
                'compañia'=>$registro->compañia,
                'tipo_plan'=>$registro->tipo_plan,
                'gasto_mes'=>$registro->gasto_mes,
                'beneficios'=>$registro->beneficios,
                'equipo'=>$registro->equipo
            ];
            if((!is_null($registro->nombre_contacto) && $registro->nombre_contacto!='') &&
            (!is_null($registro->telefono) && $registro->telefono!='') &&
            (!is_null($registro->compañia) && $registro->compañia!='') &&
            (!is_null($registro->tipo_plan) && $registro->tipo_plan!='') &&
            (!is_null($registro->gasto_mes) && $registro->gasto_mes!='') &&
            (!is_null($registro->beneficios) && $registro->beneficios!='') &&
            (!is_null($registro->equipo) && $registro->equipo!='') 
            )
            {
                $this->completos_c2=$this->completos_c2+1;
            }
        }

        if($this->completos_c2==30) {$this->show3=true;}
        $this->completos_c3=0;

        $circulo3=Plan100::with('registro_padre')
                        ->where('user_id',Auth::user()->id)
                        ->where('circulo',3)
                        ->orderBy('id','asc')
                        ->get();
        $this->circulo3=[];
        $this->completos_c3=0;
        foreach($circulo3 as $registro)
        {
            $this->circulo3[]=[
                'id'=>$registro->id,
                'contacto_padre'=>$registro->registro_padre->nombre_contacto,
                'telefono_padre'=>$registro->registro_padre->telefono,
                'nombre_contacto'=>$registro->nombre_contacto,
                'telefono'=>$registro->telefono,
                'compañia'=>$registro->compañia,
                'tipo_plan'=>$registro->tipo_plan,
                'gasto_mes'=>$registro->gasto_mes,
                'beneficios'=>$registro->beneficios,
                'equipo'=>$registro->equipo
            ];
            if((!is_null($registro->nombre_contacto) && $registro->nombre_contacto!='') &&
            (!is_null($registro->telefono) && $registro->telefono!='') &&
            (!is_null($registro->compañia) && $registro->compañia!='') &&
            (!is_null($registro->tipo_plan) && $registro->tipo_plan!='') &&
            (!is_null($registro->gasto_mes) && $registro->gasto_mes!='') &&
            (!is_null($registro->beneficios) && $registro->beneficios!='') &&
            (!is_null($registro->equipo) && $registro->equipo!='') 
            )
            {
                $this->completos_c3=$this->completos_c3+1;
            }
        }

    

    }
    public function guardar()
    {
        $this->completos_c1=0;
        foreach($this->circulo1 as $registro)
        {
            Plan100::where('id',$registro['id'])
                    ->update([
                        'nombre_contacto'=>$registro['nombre_contacto'],
                        'telefono'=>$registro['telefono'],
                        'compañia'=>$registro['compañia'],
                        'tipo_plan'=>$registro['tipo_plan'],
                        'gasto_mes'=>$registro['gasto_mes'],
                        'beneficios'=>$registro['beneficios'],
                        'equipo'=>$registro['equipo']
                    ]);
            if((!is_null($registro['nombre_contacto']) && $registro['nombre_contacto']!='') &&
                (!is_null($registro['telefono']) && $registro['telefono']!='') &&
                (!is_null($registro['compañia']) && $registro['compañia']!='') &&
                (!is_null($registro['tipo_plan']) && $registro['tipo_plan']!='') &&
                (!is_null($registro['gasto_mes']) && $registro['gasto_mes']!='') &&
                (!is_null($registro['beneficios']) && $registro['beneficios']!='') &&
                (!is_null($registro['equipo']) && $registro['equipo']!='') 
                )
                  {
                     $this->completos_c1=$this->completos_c1+1;
                  }
        }
        if($this->completos_c1==10)
        {
            $this->show2=true;
        }
        else
        {
            $this->show2=false;
            $this->show3=false;
        }
        $this->completos_c2=0;
        foreach($this->circulo2 as $registro)
        {
            Plan100::where('id',$registro['id'])
                    ->update([
                        'nombre_contacto'=>$registro['nombre_contacto'],
                        'telefono'=>$registro['telefono'],
                        'compañia'=>$registro['compañia'],
                        'tipo_plan'=>$registro['tipo_plan'],
                        'gasto_mes'=>$registro['gasto_mes'],
                        'beneficios'=>$registro['beneficios'],
                        'equipo'=>$registro['equipo']
                    ]);
            if((!is_null($registro['nombre_contacto']) && $registro['nombre_contacto']!='') &&
                (!is_null($registro['telefono']) && $registro['telefono']!='') &&
                (!is_null($registro['compañia']) && $registro['compañia']!='') &&
                (!is_null($registro['tipo_plan']) && $registro['tipo_plan']!='') &&
                (!is_null($registro['gasto_mes']) && $registro['gasto_mes']!='') &&
                (!is_null($registro['beneficios']) && $registro['beneficios']!='') &&
                (!is_null($registro['equipo']) && $registro['equipo']!='') 
                )
                  {
                     $this->completos_c2=$this->completos_c2+1;
                  }
        }
        if($this->completos_c2==30 && $this->show2==true)
        {
            $this->show3=true;
        }
        else
        {
            $this->show3=false;
        }

        foreach($this->circulo3 as $registro)
        {
            Plan100::where('id',$registro['id'])
                    ->update([
                        'nombre_contacto'=>$registro['nombre_contacto'],
                        'telefono'=>$registro['telefono'],
                        'compañia'=>$registro['compañia'],
                        'tipo_plan'=>$registro['tipo_plan'],
                        'gasto_mes'=>$registro['gasto_mes'],
                        'beneficios'=>$registro['beneficios'],
                        'equipo'=>$registro['equipo']
                    ]);
            if((!is_null($registro['nombre_contacto']) && $registro['nombre_contacto']!='') &&
                (!is_null($registro['telefono']) && $registro['telefono']!='') &&
                (!is_null($registro['compañia']) && $registro['compañia']!='') &&
                (!is_null($registro['tipo_plan']) && $registro['tipo_plan']!='') &&
                (!is_null($registro['gasto_mes']) && $registro['gasto_mes']!='') &&
                (!is_null($registro['beneficios']) && $registro['beneficios']!='') &&
                (!is_null($registro['equipo']) && $registro['equipo']!='') 
                )
                  {
                     $this->completos_c3=$this->completos_c3+1;
                  }
        }
        $this->emit('datos_guardados');
        $this->emit('alert_ok','El avance de tu PLAN 100 fue guardado con exito!');
    }

}
