<div>
    <x-slot name="header">
            {{ __('Plan 100') }}
    </x-slot>
    <div class="pt-5 pb-10 flex flex-col w-full text-gray-700  px-2 md:px-8">
        <div class="w-full rounded-t-lg bg-slate-300 p-3 flex flex-col border-b border-gray-800"> <!--ENCABEZADO-->
                <div class="w-full text-lg font-semibold flex flex-row">
                    <div class="w-3/4">Plan 100</div>
                    <div class="w-2/12 text-sm">Circulo 1 ({{$completos_c1}}/10)</div>
                    <div class="w-1/12 text-sm">{{number_format(100*$completos_c1/10,2)}}%</div>
                </div>
                <div class="w-full text-sm flex flex-row">
                    <div class="w-3/4">({{Auth::user()->user}}) - {{Auth::user()->name}}</div>            
                    <div class="w-2/12 font-semibold">
                        @if($completos_c1==10)
                        Circulo 2 ({{$completos_c2}}/30)
                        @endif
                    </div>
                    <div class="w-1/12 font-semibold">
                        @if($completos_c1==10)
                        {{number_format(100*$completos_c2/30,2)}}%
                        @endif
                    </div>
                </div>
                <div class="w-full text-sm flex flex-row py-1">
                    <div class="w-3/4">{{App\Models\User::with('area_user','subarea')->find(Auth::user()->id)->subarea->nombre}}</div>            
                    <div class="w-2/12 font-semibold">
                        @if($completos_c1==10 && $completos_c2==30)
                        Circulo 3 ({{$completos_c3}}/60)
                        @endif
                    </div>
                    <div class="w-1/12 font-semibold">
                        @if($completos_c1==10 && $completos_c2==30)
                        {{number_format(100*$completos_c3/60,2)}}%
                        @endif
                    </div>
                </div>            
                <div>
                    <x-jet-button wire:click="guardar">Guardar</x-jet-button>
                </div>
        </div> <!--FIN ENCABEZADO-->
        <div class="w-full py-3 px-4 bg-orange-300 text-base flex flex-col">
            <div class="font-bold">Primer circulo de influencia</div>
            <div class="text-xs">Acercate con familiares y amigos cercanos para tener un primer contacto sobre sus servicios</div>
        </div>
        <div class="w-full" wire:model="show1">
        @php
            $x=1;
        @endphp
        @foreach($circulo1 as $index=>$referido1)

            <div class="w-full flex flex-row space-x-2 justify-between">
                <div class="w-3 flex items-center">
                    <span class="text-lg font-bold">{{$x}}</span>
                </div>
                <div class="flex1">
                    <x-jet-label>Contacto</x-jet-label>
                    <x-jet-input class="text-xs w-full" wire:model.defer="circulo1.{{$index}}.nombre_contacto" />
                </div>
                <div>
                    <x-jet-label>Telefono</x-jet-label>
                    <x-jet-input class="text-xs w-full" wire:model.defer="circulo1.{{$index}}.telefono" />
                </div>
                <div>
                    <x-jet-label>Compañia</x-jet-label>
                    <x-jet-input class="text-xs w-full" wire:model.defer="circulo1.{{$index}}.compañia" />
                </div>
                <div>
                    <x-jet-label>Tipo plan</x-jet-label>
                    <x-jet-input class="text-xs w-full" wire:model.defer="circulo1.{{$index}}.tipo_plan" />
                </div>
                <div>
                    <x-jet-label>Gasto mes</x-jet-label>
                    <x-jet-input class="text-xs w-full" wire:model.defer="circulo1.{{$index}}.gasto_mes" />
                </div>
                <div>
                    <x-jet-label>Beneficios</x-jet-label>
                    <x-jet-input class="text-xs w-full" wire:model.defer="circulo1.{{$index}}.beneficios" />
                </div>
                <div>
                    <x-jet-label>Equipo</x-jet-label>
                    <x-jet-input class="text-xs w-full" wire:model.defer="circulo1.{{$index}}.equipo" />
                </div>
            </div>
            @php
                $x=$x+1;
            @endphp 
       @endforeach
        </div>
        @if($show2)
        <div class="w-full py-3 px-4 bg-orange-300 text-base flex flex-col">
            <div class="font-bold">Segundo circulo de influencia</div>
            <div class="text-xs">Realiza una segunda llamada al contacto indicado para obtener 3 referidos por cada uno.</div>
        </div>
        <div class="w-full" wire:model="show1">
        @php
            $padre="";
        @endphp
        @foreach($circulo2 as $index=>$referido2)
            @if($padre!=$circulo2[$index]['contacto_padre'])
            <div class="w-full text-sm bg-slate-200 py-1 px-3">
                <b>{{$circulo2[$index]['contacto_padre']}}</b> (Telefono : {{$circulo2[$index]['telefono_padre']}})
            </div>
            @endif

            <div class="w-full flex flex-row space-x-2 justify-between">
                <div class="w-3 flex items-center">
                    <span class="text-lg font-bold">{{$x}}</span>
                </div>
                <div class="flex1">
                    <x-jet-label>Contacto</x-jet-label>
                    <x-jet-input class="text-xs w-full" wire:model.defer="circulo2.{{$index}}.nombre_contacto" />
                </div>
                <div>
                    <x-jet-label>Telefono</x-jet-label>
                    <x-jet-input class="text-xs w-full" wire:model.defer="circulo2.{{$index}}.telefono" />
                </div>
                <div>
                    <x-jet-label>Compañia</x-jet-label>
                    <x-jet-input class="text-xs w-full" wire:model.defer="circulo2.{{$index}}.compañia" />
                </div>
                <div>
                    <x-jet-label>Tipo plan</x-jet-label>
                    <x-jet-input class="text-xs w-full" wire:model.defer="circulo2.{{$index}}.tipo_plan" />
                </div>
                <div>
                    <x-jet-label>Gasto mes</x-jet-label>
                    <x-jet-input class="text-xs w-full" wire:model.defer="circulo2.{{$index}}.gasto_mes" />
                </div>
                <div>
                    <x-jet-label>Beneficios</x-jet-label>
                    <x-jet-input class="text-xs w-full" wire:model.defer="circulo2.{{$index}}.beneficios" />
                </div>
                <div>
                    <x-jet-label>Equipo</x-jet-label>
                    <x-jet-input class="text-xs w-full" wire:model.defer="circulo2.{{$index}}.equipo" />
                </div>
            </div>
            @php
                $padre=$circulo2[$index]['contacto_padre'];
                $x=$x+1;
            @endphp 
       @endforeach
        </div>
        @endif

        @if($show3)
        <div class="w-full py-3 px-4 bg-orange-300 text-base flex flex-col">
            <div class="font-bold">Tercer circulo de influencia</div>
            <div class="text-xs">Realiza una segunda llamada al contacto indicado para obtener 2 referidos por cada uno.</div>
        </div>
        <div class="w-full" wire:model="show1">
        @php
            $padre="";
        @endphp
        @foreach($circulo3 as $index=>$referido3)
            @if($padre!=$circulo3[$index]['contacto_padre'])
            <div class="w-full text-sm bg-slate-200 py-1 px-3">
                <b>{{$circulo3[$index]['contacto_padre']}}</b> (Telefono : {{$circulo3[$index]['telefono_padre']}})
            </div>
            @endif

            <div class="w-full flex flex-row space-x-2 justify-between">
                <div class="w-3 flex items-center">
                    <span class="text-lg font-bold">{{$x}}</span>
                </div>
                <div class="flex1">
                    <x-jet-label>Contacto</x-jet-label>
                    <x-jet-input class="text-xs w-full" wire:model.defer="circulo3.{{$index}}.nombre_contacto" />
                </div>
                <div>
                    <x-jet-label>Telefono</x-jet-label>
                    <x-jet-input class="text-xs w-full" wire:model.defer="circulo3.{{$index}}.telefono" />
                </div>
                <div>
                    <x-jet-label>Compañia</x-jet-label>
                    <x-jet-input class="text-xs w-full" wire:model.defer="circulo3.{{$index}}.compañia" />
                </div>
                <div>
                    <x-jet-label>Tipo plan</x-jet-label>
                    <x-jet-input class="text-xs w-full" wire:model.defer="circulo3.{{$index}}.tipo_plan" />
                </div>
                <div>
                    <x-jet-label>Gasto mes</x-jet-label>
                    <x-jet-input class="text-xs w-full" wire:model.defer="circulo3.{{$index}}.gasto_mes" />
                </div>
                <div>
                    <x-jet-label>Beneficios</x-jet-label>
                    <x-jet-input class="text-xs w-full" wire:model.defer="circulo3.{{$index}}.beneficios" />
                </div>
                <div>
                    <x-jet-label>Equipo</x-jet-label>
                    <x-jet-input class="text-xs w-full" wire:model.defer="circulo3.{{$index}}.equipo" />
                </div>
            </div>
            @php
                $padre=$circulo3[$index]['contacto_padre'];
                $x=$x+1;
            @endphp 
       @endforeach
        </div>
        @endif
    </div>
</div>