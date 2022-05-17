<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-ttds leading-tight">
            {{ __('Calculos Registrados') }}
        </h2>
    </x-slot>
    <div class="flex flex-col w-full text-gray-700 px-2 md:px-8">
        <div class="w-full rounded-t-lg bg-slate-300 p-3 flex flex-col border-b border-gray-800"> <!--ENCABEZADO-->
            <div class="w-full text-lg font-semibold">Importar archivo CIS</div>            
            <div class="w-full flex flex-col">
            <div class="w-full text-sm">({{Auth::user()->user}}) - {{Auth::user()->name}}</div>            
                <div class="w-full text-sm">{{App\Models\User::with('punto_venta')->find(Auth::user()->id)->punto_venta->pdv}}</div>            
            </div>
            
        </div> <!--FIN ENCABEZADO-->
        <div class="flex flex-wrap">
            
            <div class="w-full md:w-1/3 flex flex-row p-4">
                <div class="w-full flex p-3 flex-row rounded-lg shadow-xl bg-orange-100 rounded-lg shadow-xl">
                    <div class="w-5/6 p-2 flex items-center">
                        <div class="w-full flex flex-col justify-center">
                            <div class="w-full text-xl text-yellow-500 font-bold flex justify-start"><i class="fas fa-th-large"></i></div>
                            <div class="w-full text-3xl text-gray-600 font-semibold flex justify-start">Marzo 2022</div>
                            <div class="w-full text-xs text-gray-700 flex justify-start">De 2022-03-01 a 2022-03-31</div>
                            <div class="w-full text-lg text-gray-700 font-semibold flex justify-start">Ventas Marzo 2022</div>                
                        </div>
                    </div>
                    <div class="w-1/6 text-3xl font-thin text-gray-500 flex flex-col text-center">
                        <div class="w-full py-2 text-gray-500">
                            <a href="{{route('detalle_calculo',['id'=>1])}}" title="Marzo 2022">
                             <i class="fas fa-handshake"></i>
                            </a>
                        </div>

                    </div>    
                </div>
            </div>
            <div class="w-full md:w-1/3 flex flex-row p-4">
                <div class="w-full flex p-3 flex-row rounded-lg shadow-xl bg-orange-100 rounded-lg shadow-xl">
                    <div class="w-5/6 p-2 flex items-center">
                        <div class="w-full flex flex-col justify-center">
                            <div class="w-full text-xl text-yellow-500 font-bold flex justify-start"><i class="fas fa-th-large"></i></div>
                            <div class="w-full text-3xl text-gray-600 font-semibold flex justify-start">Febrero 2022</div>
                            <div class="w-full text-xs text-gray-700 flex justify-start">De 2022-02-01 a 2022-03-28</div>
                            <div class="w-full text-lg text-gray-700 font-semibold flex justify-start">Ventas Febrero 2022</div>                
                        </div>
                    </div>
                    <div class="w-1/6 text-3xl font-thin text-gray-500 flex flex-col text-center">
                        <div class="w-full py-2 text-gray-500">
                            <a href="{{route('detalle_calculo',['id'=>2])}}" title="Marzo 2022">
                             <i class="fas fa-handshake"></i>
                            </a>
                        </div>

                    </div>    
                </div>
            </div>
            
        </div>
        @if(session('status')!='')
            <div class="w-full flex justify-center p-3 bg-green-300 rounded-b-lg">
                <span class="font-semibold text-sm text-gray-600">{{session('status')}}</span>
            </div>    
        @endif
    </div>
    
</x-app-layout>