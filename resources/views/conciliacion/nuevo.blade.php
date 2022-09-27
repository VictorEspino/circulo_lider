<x-app-layout>
    <x-slot name="header">
            {{ __('Nueva Conciliacion') }}
    </x-slot>
    <div class="flex flex-col w-full text-gray-700 rounded-lg px-5">
        <form method="post" action="{{route('conciliacion_nuevo')}}">
        <div class="w-full rounded-t-lg bg-gray-200 p-3 flex flex-col border-b border-gray-800"> <!--ENCABEZADO-->
            <div class="w-full text-sm">({{Auth::user()->user}}) - {{Auth::user()->name}}</div>            
            <div class="w-full text-sm">{{App\Models\User::with('area_user','subarea')->find(Auth::user()->id)->subarea->nombre}}</div>            
            <div class="flex justify-end">
                <button type="submit" class="rounded p-1 border bg-green-500 hover:bg-green-700 text-gray-100 font-semibold">
                    Guardar
                </button>
            </div>
        </div> <!--FIN ENCABEZADO-->
            @csrf
        <div class="w-full rounded-b-lg bg-white pb-10 p-3 flex flex-col"> <!--CONTENIDO-->
            <div class="w-full px-2 flex flex-row space-x-1">
                <div class="w-full">
                    <span class="text-xs text-ttds">Descripcion</span><br>
                    <input class="w-full rounded p-1 border border-gray-300" type="text" name="descripcion_calculo" value="{{old('descripcion_calculo')}}" id="descripcion_calculo">
                    @error('descripcion')
                    <br><span class="text-xs italic text-red-700 text-xs">{{ $message }}</span>
                    @enderror   
                </div>
            </div> 
            <div class="w-full px-2 pt-2">
                <span class="text-sm font-semibold text-gray-700">Periodo de Conciliacion</span>
            </div>
            <div class="w-full px-2 flex flex-row space-x-1">
                <div class="w-1/2">
                    <span class="text-xs text-ttds">Mes</span><br>
                    <select class="w-full rounded p-1 border border-gray-300" name="mes"  id="mes">
                        <option value=''></option>
                        <option value='1' {{old('mes')=="1"?'selected':''}}>enero</option>
                        <option value='2' {{old('mes')=="1"?'selected':''}}>febrero</option>
                        <option value='3' {{old('mes')=="1"?'selected':''}}>marzo</option>
                        <option value='4' {{old('mes')=="1"?'selected':''}}>abril</option>
                        <option value='5' {{old('mes')=="1"?'selected':''}}>mayo</option>
                        <option value='6' {{old('mes')=="1"?'selected':''}}>junio</option>
                        <option value='7' {{old('mes')=="1"?'selected':''}}>julio</option>
                        <option value='8' {{old('mes')=="1"?'selected':''}}>agosto</option>
                        <option value='9' {{old('mes')=="1"?'selected':''}}>septiembre</option>
                        <option value='10' {{old('mes')=="1"?'selected':''}}>octubre</option>
                        <option value='11' {{old('mes')=="1"?'selected':''}}>noviembre</option>
                        <option value='12' {{old('mes')=="1"?'selected':''}}>diciembre</option>
                    </select>
                    @error('mes')
                    <br><span class="text-xs italic text-red-700 text-xs">{{ $message }}</span>
                    @enderror   
                </div>
                <div class="w-1/2">
                    <span class="text-xs text-ttds">Año</span><br>
                    <select class="w-full rounded p-1 border border-gray-300" name="año" id="año">
                        <option value=''></option>
                        @foreach ($años as $año)
                            <option value="{{$año->valor}}" {{old('año')==$año->valor?'selected':''}}>{{$año->valor}}</option>
                        @endforeach
                    </select>
                    @error('año')
                    <br><span class="text-xs italic text-red-700 text-xs">{{ $message }}</span>
                    @enderror   
                </div>
            </div> 
        </div> <!--FIN CONTENIDO-->
        <div class="w-full flex justify-center py-4 bg-white rounded-b">
            <button type="submit" class="rounded p-1 border bg-green-500 hover:bg-green-700 text-gray-100 font-semibold">
                Guardar
            </button>
        </div>
        </form>
        @if(session('status')!='')
            <div class="w-full flex justify-center p-3 bg-green-300 rounded-b-lg">
                <span class="font-semibold text-sm text-gray-600">{{session('status')}}</span>
            </div>    
        @endif
        @if(session()->has('error_validacion'))
            <div class="w-full flex justify-center p-3 bg-red-300 rounded-b-lg">
                <span class="font-semibold text-sm text-gray-600">{{session()->get('error_validacion')}}</span>
            </div>    
        @endif
    </div>
    </div>
</x-app-layout>