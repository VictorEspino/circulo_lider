<x-app-layout>
    <x-slot name="header">
        {{ __('Boletos obtenidos') }}
    </x-slot>
    <div class="w-full px-8 flex flex-col">
        <div class="text-xl font-bold py-5">
            Estos son los boletos obtenidos para el gran concurso de fin de año - ETAPA 1<br>
            <span class="text-xs">No se obtiene boletos por ventas no validadas en CIS
        </div>
        <div class="w-full px-10 flex flex-row bg-gray-500 text-gray-100">
            <div class="w-1/6 border px-4">
                Tipo
            </div>
            <div class="w-full flex flex-col w-1/6 border text-sm">
                <div>
                Plan
                </div>
                <div class="text-xs px-4">
                Cliente
                </div>
            </div>
            <div class="w-1/6 border px-4">
                Fecha
            </div>
            <div class="w-1/6 border px-4">
                Boleto 1
            </div>
            <div class="w-1/6 border px-4">
            Boleto 2<br><span class="text-xs">(Venta con Seguro)
            </div>
            <div class="w-1/6 border px-4">
            Boleto 3<br><span class="text-xs">(Venta con Seguro)
            </div>
            <div class="w-1/6 border px-4">
            Boleto 4<br><span class="text-xs">
            (Obtenlo alcanzando cuota mensual)
            </div>
            <div class="w-1/6 border px-4">
            Boleto 5<br><span class="text-xs">
            (Obtenlo alcanzando cuota mensual)
            </div>
            <div class="w-1/6 border px-4">
            Boleto 6<br><span class="text-xs">
            (Obtenlo alcanzando cuota mensual)
            </div>
        </div>
        @foreach($registros as $rec)
        <div class="w-full px-10 flex flex-row text-sm">
            <div class="w-1/6 border px-4">
                {{$rec->venta->tipo}}
            </div>
            <div class="w-full flex flex-col w-1/6 border">
                <div>
                <b>{{$rec->venta->det_plan->nombre}}</b>
                </div>
                <div class="text-xs px-4">
                {{$rec->venta->cliente}}
                </div>
            </div>
            <div class="w-1/6 border px-4">
                {{$rec->venta->fecha}}
            </div>
            <div class="w-1/6 border px-4">
                <b><span class="text-red-400">{{$rec->boleto1}}</b>
            </div>
            <div class="w-1/6 border px-4">
            <b><span class="text-red-400">{{$rec->boleto2}}</b>
            </div>
            <div class="w-1/6 border px-4">
            <b><span class="text-red-400">{{$rec->boleto3}}</b>
            </div>
            <div class="w-1/6 border px-4">
            <b><span class="text-red-400">{{$rec->boleto4}}</b>
            </div>
            <div class="w-1/6 border px-4">
            <b><span class="text-red-400">{{$rec->boleto5}}</b>
            </div>
            <div class="w-1/6 border px-4">
            <b><span class="text-red-400">{{$rec->boleto6}}</b>
            </div>
        </div>
        @endforeach
    </div> 
</x-app-layout>