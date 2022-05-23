<div>
<x-slot name="header">
        {{ __('Cuotas Tienda') }}
</x-slot>
<div class="pt-5 flex flex-col w-full text-gray-700  px-2 md:px-8">
    <div class="w-full rounded-t-lg bg-slate-300 p-3 flex flex-col border-b border-gray-800"> <!--ENCABEZADO-->
            <div class="w-full text-lg font-semibold">Cuotas Tienda</div>
            <div class="w-full text-sm">({{Auth::user()->user}}) - {{Auth::user()->name}}</div>            
            <div class="w-full text-sm">{{App\Models\User::with('area_user','subarea')->find(Auth::user()->id)->subarea->nombre}}</div>            
    </div> <!--FIN ENCABEZADO-->
    <div class="w-full flex flex-col md:flex-row bg-white space-y-3 md:space-y-0">
        <div class="w-full md:w-1/3 px-5 flex flex-col">
            <div class="w-full flex flex-row">
                <div class="w-3/4">
                    <div class="w-full font-bold pt-3">Periodos con cuota asignada</div>
                </div>
                <div class="p-4 flex-1">
                    <x-jet-button wire:click="confirma_nuevo">Nuevo</x-jet-button>
                </div>
            </div>
            @foreach($periodos as $periodo)
                <div class="py-1 px-3 text-sm border-b {{$periodo_id==$periodo->id?'font-bold text-orange-600':''}}">{{$periodo->descripcion}}&nbsp;&nbsp;<span class="text-red-400" style="cursor:pointer" wire:click="detalle({{$periodo->id}},'{{$periodo->descripcion}}')"><i class="fas fa-edit"></i></span></div>
            @endforeach
        </div>
        <div class="w-full md:w-2/3 px-5 flex flex-col">
            <div class="w-full flex flex-row">
                <div class="w-3/4">
                    <div class="w-full font-bold pt-3">Cuotas para el periodo : {{$desc_seleccionado}}</div>
                    <div class="w-ful pt-1 pb-3 text-xs">Puede actualizar tanto la asignacion del gerente, asi como la cuota asignada a cada tienda.</div>
                </div>
                <div class="p-4 flex-1">
                    @if($periodo_id>0)
                    <x-jet-button wire:click="guardar">Guardar</x-jet-button>
                    @endif
                </div>
            </div>
            @php
                $color=false;
            @endphp
            @foreach($detalles as $index=>$detalle)
            @php
                $color=!$color;
            @endphp
            <div class="w-full py-1 text-base flex flex-row border-b items-center {{$color?'bg-orange-100':'bg-white'}}" >
                <div class="w-1/4 flex items-center px-3 text-xs">{{$detalle['tienda']}}</div>
                <div class="w-1/2 px-3">
                    <select wire:model.defer="detalles.{{$index}}.gerente_id" class="w-full text-xs border-gray-300 focus:border-orange-300 focus:ring focus:ring-orange-200 focus:ring-opacity-50 rounded-md shadow-sm py-1">
                        @foreach($gerentes as $gerente)
                        <option value="{{$gerente->id}}" class="" {{$gerente->id==$detalles[$index]['gerente_id']?'selected':''}}>{{$gerente->name}}</option>
                        @endforeach
                    </select>  
                </div>
                <div class="w-1/4 px-3">
                    <x-jet-input class="w-full py-1 text-sm" wire:model.defer="detalles.{{$index}}.cuota_ventas" type="text" value="{{$detalle['cuota_ventas']}}"></x-jet-input>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
<x-jet-dialog-modal wire:model="open_confirm_nuevo" maxWidth="md">
        <x-slot name="title">
            Nuevo periodo
        </x-slot>
        <x-slot name="content">
            <div class="w-full flex flex-row">
                <div class="w-24 text-7xl text-orange-500 flex justify-center py-8"><i class="far fa-question-circle"></i></div>
                <div class="flex-1 text-sm text-gray-600 px-5 flex flex-col items-center">  
                    <div class="pt-4">
                    Se integraran los registros de cuota del siguiente periodo: <b>{{$siguiente_periodo_desc}}</b><br><br>
                    </div>
                    <div>
                    ¿Desea continuar?
                    </div>
                </div>
            </div> 
            
        </x-slot>
        <x-slot name="footer">
            <x-jet-secondary-button wire:click.prevent="$set('open_confirm_nuevo',false)">Cancelar</x-jet-secondary-button>&nbsp;&nbsp;
            <button {{$procesando==1?'disabled':''}} class='inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition' wire:click.prevent="nuevo_periodo">Confirmar</button>
        </x-slot>
    </x-jet-dialog-modal>
</div>