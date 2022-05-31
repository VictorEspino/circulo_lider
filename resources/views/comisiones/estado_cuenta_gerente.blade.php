<x-app-layout>
    <x-slot name="header">
        {{ __('Estado de cuenta gerente') }}
    </x-slot>
    <div class="p-6 flex flex-col w-full text-gray-700  px-2 md:px-8">
        <div class="w-full rounded-t-lg bg-slate-300 p-3 flex flex-col border-b border-gray-800"> <!--ENCABEZADO-->
            <div class="w-full text-lg font-semibold">Comisiones</div>
            <div class="w-full text-sm">{{$pago->nombre}} - {{$pago->sucursal}}</div>            
            <div class="w-full text-sm">Del {{$calculo->periodo->f_inicio}} al {{$calculo->periodo->f_fin}}</div>            
        </div> <!--FIN ENCABEZADO-->
        <div class="w-full flex flex-col">
            <div class="w-full text-xl font-bold text-gray-600 pt-3">Resultados</div>
            <div class="w-full flex flex-row pt-3 space-x-5">
                <div class="w-1/3 flex flex-col bg-gradient-to-br from-black to-slate-500 text-white rounded-lg py-3 px-3">
                    <div class="flex flex-col md:flex-row lg:flex-row">
                        <div class="w-5/6 font-bold">Alcance</div>
                        <div class="text-sm font-bold">Cuota: {{$medicion->cuota_ventas}}</div> 
                    </div> 
                    <div class="text-3xl font-bold flex justify-end text-orange-500">{{number_format(100*$medicion->factor,2)}}%</div>
                    <div class="flex flex-row">
                        <div class="font-bold text-xs">Ventas: {{$medicion->ventas}}</div> 
                    </div>
                </div>
                <div class="w-1/3 flex flex-col bg-gradient-to-br from-black to-slate-500 text-white rounded-lg py-3 px-3">
                    <div class="flex flex-col md:flex-row lg:flex-row">
                        <div class="w-5/6 font-bold">Comisiones</div>
                        <div class="text-sm font-bold"></div> 
                    </div> 
                    <div class="text-3xl font-bold flex justify-end text-orange-500">${{number_format($pago->comisiones,2)}}</div>
                    <div class="flex flex-row">
                        <div class="font-bold text-xs"></div> 
                    </div>
                </div>
                <div class="w-1/3 flex flex-col bg-gradient-to-br from-black to-slate-500 text-white rounded-lg py-3 px-3">
                    <div class="flex flex-col md:flex-row lg:flex-row">
                        <div class="w-5/6 font-bold">Total pago</div>
                        <div class="text-sm font-bold"></div> 
                    </div> 
                    <div class="text-3xl font-bold flex justify-end text-orange-500">${{number_format($pago->total_pago,2)}}</div>
                    <div class="flex flex-row">
                        <div class="font-bold text-xs"></div> 
                    </div>
                </div>
            </div>
            <div class="w-full text-xl font-bold text-gray-600 pt-3">Alcances</div>
            <div class="w-full flex flex-row pt-3 space-x-5">
                <div class="w-full flex flex-col bg-gradient-to-br from-orange-400 to-black text-white rounded-lg py-3 px-3">
                    <div class="flex flex-col md:flex-row lg:flex-row">
                        <div class="w-5/6 font-bold">Ventas</div>
                        <div class="text-sm font-bold"></div> 
                    </div> 
                    <div class="text-3xl font-bold flex justify-end">{{number_format($medicion->ventas,0)}}</div>
                    <div class="flex flex-col">
                        <div class="font-bold text-xs">
                            Suman las VENTAS DE PLANES ARMALO, SIMPLE y SIMPLE PLUS
                        </div> 
                        <div class="font-bold text-xs">
                            Necesitas lograr al menos el 50% de tu cuota con estas ventas.
                        </div>
                        <div class="font-bold text-xs">
                            El alcance maximo para el pago de tus comisiones es el 120%
                        </div> 
                    </div>
                </div>
                
            </div>
            <div class="w-full text-xl font-bold text-gray-600 pt-3">Detalles</div>
            @php
            $tipo_actual="";
            $ciclo=0;
            $subtotal=0;

            foreach($comisiones as $detalle_comision)
            {
                if($ciclo==0 && $tipo_actual!=$detalle_comision->tipo)
                {
                    
            @endphp
                <div class="w-full flex flex-row pt-4">
                    <div class="w-1/4"></div>
                    <div class="w-1/2">
                    <div class="w-full flex flex-col">
                        <div class="w-full flex flex-row rounded bg-slate-600 px-3 py-1">
                            <div class="w-3/4 text-gray-200">{{$detalle_comision->tipo}}</div>
                            <div class="w-1/4 text-gray-200 text-xs flex items-center">Comision</div>
                        </div>
            @php
                    $subtotal=0;
                }
                if($ciclo>0 && $tipo_actual!=$detalle_comision->tipo)
                {
                    
            @endphp
                    </div>
                    </div>
                        <div class="w-1/4"></div>
                    </div>
                    <div class="w-full flex flex-row">
                        <div class="w-1/4"></div>
                        <div class="w-1/2 flex flex-row rounded bg-slate-200 font-bold">
                            <div class="w-3/4 flex justify-end px-10">
                                Subtotal
                            </div>
                            <div class="w-1/4">
                                ${{number_format($subtotal,2)}}
                            </div>
                        </div>
                        <div class="w-1/4"></div>
                    </div>      
                    <div class="w-full flex flex-row pt-4">
                    <div class="w-1/4"></div>
                    <div class="w-1/2">
                    <div class="w-full flex flex-col">
                        <div class="w-full flex flex-row rounded bg-slate-600 px-3 py-1">
                            <div class="w-3/4 text-gray-200">{{$detalle_comision->tipo}}</div>
                            <div class="w-1/4 text-gray-200 text-xs flex items-center">Comision</div>
                        </div>
            @php
                    $subtotal=0;
                }
            @endphp
                <div class="w-full text-gray-600 rounded border border-orange-200 flex flex-row text-sm">
                    <div class="w-3/4 flex flex-col px-3">
                        <div class="w-full font-bold">
                            {{$planes[$detalle_comision->plan]}}
                        </div>
                        <div class="w-full text-sm">
                            Plazo: {{$detalle_comision->plazo}} | Renta: {{$detalle_comision->renta}}
                        </div>
                        <div class="w-full text-sm">
                            Cliente: {{$detalle_comision->cliente}}
                        </div>
                        <div class="w-full text-sm">
                            Cuenta: {{$detalle_comision->cuenta}} | Orden: {{$detalle_comision->orden}} | Co_id: {{$detalle_comision->co_id}}
                        </div>
                        <div class="w-full text-sm">
                            Equipo: {{$detalle_comision->equipo}} | Propiedad: {{$detalle_comision->propiedad}}
                        </div>
                    </div>
                    <div class="w-1/4 flex items-center font-bold text-base">
                        ${{number_format($detalle_comision->comision_gerente,2)}}
                    </div>
                </div>
                    
            @php
                $subtotal=$subtotal+$detalle_comision->comision_gerente;
                $tipo_actual=$detalle_comision->tipo;
                $ciclo=$ciclo+1;
            }
            @endphp
            </div>
                    </div>
                        <div class="w-1/4"></div>
                    </div>
                    <div class="w-full flex flex-row">
                        <div class="w-1/4"></div>
                        <div class="w-1/2 flex flex-row rounded bg-slate-200 font-bold">
                            <div class="w-3/4 flex justify-end px-10">
                                Subtotal
                            </div>
                            <div class="w-1/4">
                                ${{number_format($subtotal,2)}}
                            </div>
                        </div>
                        <div class="w-1/4"></div>
                    </div> 
                <div class="w-full flex flex-row pt-4">
                    <div class="w-1/4"></div>
                    <div class="w-1/2">
                    <div class="w-full flex flex-col">
                        <div class="w-full flex flex-row rounded bg-slate-600 px-3 py-1">
                            <div class="w-3/4 text-gray-200">ADDONS</div>
                            <div class="w-1/4 text-gray-200 text-xs flex items-center">Comision</div>
                        </div>  
                    </div>
                    <div class="w-1/4"></div>
                </div>
            </div>
            @php
                $subtotal=0;
            @endphp
            @foreach($comisiones_addon as $addon)
            @php
                $subtotal=$subtotal+$addon->comision_gerente;
            @endphp
            <div class="w-full flex flex-row">
                    <div class="w-1/4"></div>
                    <div class="w-1/2">
                <div class="w-full text-gray-600 rounded border border-orange-200 flex flex-row text-sm">
                    <div class="w-3/4 flex flex-col px-3">
                        <div class="w-full font-bold">
                            {{$addon->tipo_addon}}
                        </div>
                        <div class="w-full text-sm">
                            {{$planes[$addon->plan]}}
                        </div>
                        <div class="w-full text-sm">
                            Renta: {{$addon->tipo_addon=='ADDON CONTROL'?50:$addon->renta_seguro}}
                        </div>

                        <div class="w-full text-sm">
                            Cuenta: {{$addon->cuenta}} | Orden: {{$addon->orden}} | Co_id: {{$detalle_comision->co_id}}
                        </div>
                    </div>
                    <div class="w-1/4 flex items-center font-bold text-base">
                        ${{number_format($addon->comision_gerente,2)}}
                    </div>
                </div>
                <div class="w-1/4"></div>
            </div>            
        </div>
        @endforeach
        <div class="w-full flex flex-row">
            <div class="w-1/4"></div>
            <div class="w-1/2 flex flex-row rounded bg-slate-200 font-bold">
                <div class="w-3/4 flex justify-end px-10">
                    Subtotal
                </div>
                <div class="w-1/4">
                    ${{number_format($subtotal,2)}}
                </div>
            </div>
            <div class="w-1/4"></div>
        </div> 
    </div>
</x-app-layout>
