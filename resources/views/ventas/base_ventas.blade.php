<x-app-layout>
    <x-slot name="header">
            {{ __('Ventas') }}
    </x-slot>

    <div class="flex flex-col w-full text-gray-700 px-2 md:px-8">
        <div class="w-full rounded-t-lg bg-slate-300 p-3 flex flex-col border-b border-gray-800"> <!--ENCABEZADO-->
        <div class="w-full text-lg font-semibold">Ventas</div>
            <div class="w-full text-sm">({{Auth::user()->user}}) - {{Auth::user()->name}}</div>            
            <div class="w-full text-sm">{{App\Models\User::with('area_user','subarea')->find(Auth::user()->id)->subarea->nombre}}</div>            
        </div> <!--FIN ENCABEZADO-->
        
        <div class="w-full rounded-b-lg bg-white p-3 flex flex-col"> <!--CONTENIDO-->
            <form class="w-full" action="{{route('base_ventas')}}" class="">
            <input type="hidden" name="filtro" value="ACTIVE"> 
            <div class="w-full flex flex-row space-x-2 bg-slate-400 py-3 px-3">
                    <div class="w-1/3">
                        <x-jet-label class="text-white text-sm">Buscar cliente / contrato / dn</x-jet-label>
                        <x-jet-input class="w-full" type="text" name="query" value="{{$query}}" placeholder=""></x-jet-input>
                    </div>
                    <div class="w-1/6">
                        <x-jet-label class="text-white text-sm">Tipo Venta</x-jet-label>
                        <select class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm py-1" name="tipo">
                            <option value="" class=""></option>
                            <option value="ACTIVACION" class="" {{$tipo=='ACTIVACION'?'selected':''}}>ACTIVACION</option>
                            <option value="RENOVACION" class="" {{$tipo=='RENOVACION'?'selected':''}}>RENOVACION</option>
                            <option value="PREPAGO" class="" {{$tipo=='PREPAGO'?'selected':''}}>PREPAGO</option>
                            <option value="ACCESORIO" class="" {{$tipo=='ACCESORIO'?'selected':''}}>ACCESORIO</option>
                        </select>  
                    </div>
                    <div class="w-1/6">
                        <x-jet-label class="text-white text-sm">Validado CIS</x-jet-label>
                        <select class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm py-1" name="validado_cis">
                            <option value="" class=""></option>
                            <option value="SI" class="" {{$validado_cis=='SI'?'selected':''}}>SI</option>
                            <option value="NO" class="" {{$validado_cis=='NO'?'selected':''}}>NO</option>
                        </select>  
                    </div>
                    <div class="w-1/6">
                        <x-jet-label class="text-white text-sm">Doc Completa</x-jet-label>
                        <select class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm py-1" name="doc_completa">
                            <option value="" class=""></option>
                            <option value="SI" class="" {{$doc_completa=='SI'?'selected':''}}>SI</option>
                            <option value="NO" class="" {{$doc_completa=='NO'?'selected':''}}>NO</option>
                        </select>  
                    </div>
                    <div class="w-1/6">
                        <x-jet-label class="text-white text-sm">Desde:</x-jet-label>
                        <x-jet-input class="w-full" type="date" name="f_inicio" value="{{$f_inicio}}"></x-jet-input>
                    </div>
                    <div class="w-1/6">
                        <x-jet-label class="text-white text-sm">Hasta:</x-jet-label>
                        <x-jet-input class="w-full" type="date" name="f_fin" value="{{$f_fin}}"></x-jet-input>
                    </div>
                    <div class="w-1/6 flex justify-center">
                        <x-jet-button>Buscar</x-jet-button>
                    </div>
                </form>
            </div>
            </form>
            <div class="flex justify-end text-xs pt-2">
                {{$registros->links()}}
            </div>
            <div class="w-full flex justify-center pt-5 flex-col"> <!--TABLA DE CONTENIDO-->
                <div class="w-full flex justify-center pb-3"><span class="font-semibold text-sm text-gray-700">Registros de Ventas</span></div>
                <div class="w-full flex justify-center">
                <table>
                    <tr class="">
                        <td class="border border-gray-300 font-semibold bg-slate-600 text-gray-200 p-1 text-sm"><center>Vendido por</td>
                        <td class="border border-gray-300 font-semibold bg-slate-600 text-gray-200 p-1 text-sm"><center>Sucursal</td>
                        <td class="border border-gray-300 font-semibold bg-slate-600 text-gray-200 p-1 text-sm"><center>Movimiento</td>
                        <td class="border border-gray-300 font-semibold bg-slate-600 text-gray-200 p-1 text-sm"><center>Cliente</td>
                        <td class="border border-gray-300 font-semibold bg-slate-600 text-gray-200 p-1 text-sm"><center>Plan</td>
                        <td class="border border-gray-300 font-semibold bg-slate-600 text-gray-200 p-1 text-sm"><center>Renta</td>
                        <td class="border border-gray-300 font-semibold bg-slate-600 text-gray-200 p-1 text-sm"><center>Plazo</td>
                        <td class="border border-gray-300 font-semibold bg-slate-600 text-gray-200 p-1 text-sm"><center>Fecha</td>
                        <td class="border border-gray-300 font-semibold bg-slate-600 text-gray-200 p-1 text-sm"><center>Propiedad</td>
                        <td class="border border-gray-300 font-semibold bg-slate-600 text-gray-200 p-1 text-sm"></td>
                    </tr>
                <?php
                    $color=false;
                    foreach($registros as $venta)
                    {
                ?>
                    <tr class="">
                        <td class="border border-gray-300 font-light {{$color?'bg-orange-100':''}} text-gray-700 p-1 text-xs">{{$venta->det_ejecutivo->name}}</td>
                        <td class="border border-gray-300 font-light {{$color?'bg-orange-100':''}} text-gray-700 p-1 text-xs">{{$venta->det_sucursal->nombre}}</td>
                        <td class="border border-gray-300 font-light {{$color?'bg-orange-100':''}} text-gray-700 p-1 text-xs">{{$venta->tipo}}</td>
                        <td class="border border-gray-300 font-light {{$color?'bg-orange-100':''}} text-gray-700 p-1 text-xs">{{$venta->cliente}}</td>
                        <td class="border border-gray-300 font-light {{$color?'bg-orange-100':''}} text-gray-700 p-1 text-xs">{{$venta->det_plan->nombre}}</td>
                        <td class="border border-gray-300 font-light {{$color?'bg-orange-100':''}} text-gray-700 p-1 text-xs"><center>${{number_format($venta->renta,2)}}</td>
                        <td class="border border-gray-300 font-light {{$color?'bg-orange-100':''}} text-gray-700 p-1 text-xs"><center>{{$venta->plazo}}</td>
                        <td class="border border-gray-300 font-light {{$color?'bg-orange-100':''}} text-gray-700 p-1 text-xs"><center>{{$venta->fecha}}</td>
                        <td class="border border-gray-300 font-light {{$color?'bg-orange-100':''}} text-gray-700 p-1 text-xs"><center>{{$venta->propiedad}}</td>
                        <td class="border border-gray-300 font-light {{$color?'bg-orange-100':''}} text-gray-700 p-1 text-xs">@livewire('venta.detalle-venta',['id_venta'=>$venta->id])</td>
                    </tr>
                <?php
                    $color=!$color;
                    }
                ?>
                </table>
                </div>
            </div><!--FIN DE TABLA -->

        </div> <!-- FIN DEL CONTENIDO -->
    </div> <!--DIV PRINCIPAL -->
</x-app-layout>
