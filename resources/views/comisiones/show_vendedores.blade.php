<x-app-layout>
    <x-slot name="header">
            {{ __('Estados de cuenta - Vendedores') }}
    </x-slot>

    <div class="flex flex-col w-full text-gray-700 px-2 md:px-8">
        <div class="w-full rounded-t-lg bg-slate-300 p-3 flex flex-col border-b border-gray-800"> <!--ENCABEZADO-->
        <div class="w-full text-lg font-semibold">Vendedores</div>
            <div class="w-full text-sm">({{Auth::user()->user}}) - {{Auth::user()->name}}</div>            
            <div class="w-full text-sm">{{App\Models\User::with('area_user','subarea')->find(Auth::user()->id)->subarea->nombre}}</div>            
        </div> <!--FIN ENCABEZADO-->
        
        <div class="w-full rounded-b-lg bg-white p-3 flex flex-col"> <!--CONTENIDO-->
            <form class="w-full" action="{{route('comision_vendedores',['id'=>$id])}}" class="">
            <input type="hidden" name="filtro" value="ACTIVE"> 
            <div class="w-full flex flex-row space-x-2 bg-slate-400 py-3 px-3">
                    <div class="w-5/6">
                        <x-jet-label class="text-white text-sm">Buscar sucursal/vendedor</x-jet-label>
                        <x-jet-input class="w-full" type="text" name="query" value="{{$query}}" placeholder=""></x-jet-input>
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
                <div class="w-full flex justify-center pb-3"><span class="font-semibold text-sm text-gray-700">Registros de Pago</span></div>
                <div class="w-full flex justify-center">
                <table>
                    <tr class="">
                        <td class="border border-gray-300 font-semibold bg-slate-600 text-gray-200 p-1 text-sm"></td>
                        <td class="border border-gray-300 font-semibold bg-slate-600 text-gray-200 p-1 text-sm"><center>Vendedor</td>
                        <td class="border border-gray-300 font-semibold bg-slate-600 text-gray-200 p-1 text-sm"><center>Sucursal</td>
                        <td class="border border-gray-300 font-semibold bg-slate-600 text-gray-200 p-1 text-sm"><center>Comisiones</td>
                        <td class="border border-gray-300 font-semibold bg-slate-600 text-gray-200 p-1 text-sm"><center>Bono rentas</td>
                        <td class="border border-gray-300 font-semibold bg-slate-600 text-gray-200 p-1 text-sm"><center>Total a pagar</td>
                    </tr>
                <?php
                    $color=false;
                    foreach($registros as $pago)
                    {
                ?>
                    <tr class="">
                        <td class="border border-gray-300 font-light {{$color?'bg-orange-100':''}} text-xs px-2 text-orange-500"><a href="{{route('estado_cuenta_vendedor',['id'=>$id,'user_id'=>$pago->user_id])}}"><i class="fas fa-balance-scale"></i></a></td>
                        <td class="border border-gray-300 font-light {{$color?'bg-orange-100':''}} text-gray-700 p-1 text-xs">{{$pago->nombre}}</td>
                        <td class="border border-gray-300 font-light {{$color?'bg-orange-100':''}} text-gray-700 p-1 text-xs">{{$pago->sucursal}}</td>
                        <td class="border border-gray-300 font-light {{$color?'bg-orange-100':''}} text-gray-700 p-1 text-xs"><center>${{number_format($pago->comisiones,0)}}</td>
                        <td class="border border-gray-300 font-light {{$color?'bg-orange-100':''}} text-gray-700 p-1 text-xs"><center>${{number_format($pago->bono_rentas,0)}}</td>
                        <td class="border border-gray-300 font-light {{$color?'bg-orange-100':''}} text-gray-700 p-1 text-xs"><center>${{number_format($pago->total_pago,0)}}</td>
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