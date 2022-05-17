<x-app-layout>
    <x-slot name="header">
            {{ __('Nuevo Calculo') }}
    </x-slot>

    <div class="p-10 flex flex-col w-full text-gray-700  px-2 md:px-8">
        <div class="w-full rounded-t-lg bg-slate-300 p-3 flex flex-col border-b border-gray-800"> <!--ENCABEZADO-->
            <div class="w-full text-lg font-semibold">Nuevo Calculo Comisiones</div>
            <div class="w-full text-sm">({{Auth::user()->user}}) - {{Auth::user()->name}}</div>            
            <div class="w-full text-sm">{{App\Models\User::with('area_user','subarea')->find(Auth::user()->id)->subarea->nombre}}</div>            
        </div> <!--FIN ENCABEZADO-->
        @if(session('status')!='')
            <div class="w-full flex justify-center p-3 {{substr(session('status'),0,2)=='OK'?'bg-green-300':'bg-red-400'}}">
                <span class="font-semibold text-sm text-gray-600">{{session('status')}}</span>
            </div>    
        @endif
        <form method="post" action="{{route('nuevo_calculo')}}">
            @csrf
            <input type="hidden" name="periodo" value="{{$periodo}}">
        <div class="w-full p-3 flex flex-col"> <!--CONTENIDO-->
            <div class="w-full flex flex-col space-y-2 md:space-y-0 md:flex-row md:space-x-2">
                <div class="w-full md:w-1/2">
                    <x-jet-label>Descripcion</x-jet-label>
                    <x-jet-input type="text" class="w-full" name="descripcion"></x-jet-input>
                    @error('descripcion')
                      <br><span class="text-xs italic text-red-700 text-xs">{{ $message }}</span>
                    @enderror                    
                </div>
                <div class="w-full md:w-1/2">
                    <x-jet-label>Periodo a calcular</x-jet-label>
                    <x-jet-input class="w-full" type="text" value="{{$desc_periodo}}" readonly></x-jet-input>             
                </div>              
            </div>
        </div> <!--FIN CONTENIDO-->
        <div class="w-full flex justify-center py-4 shadow-lg">
            <x-jet-button>GUARDAR</x-jet-button>
        </div>
        </form>
    </div>
</x-app-layout>