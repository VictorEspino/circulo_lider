<x-app-layout>
    <x-slot name="header">
            {{ __('Plantilla - Nuevo') }}
    </x-slot>

    <div class="flex flex-col w-full bg-gray-100 text-gray-700  px-2 md:px-8">
        <div class="w-full rounded-t-lg bg-gray-200 p-3 flex flex-col border-b border-gray-800"> <!--ENCABEZADO-->
            <div class="w-full text-lg font-semibold">Registo Nuevo Usuario</div>
            <div class="w-full text-sm">({{Auth::user()->user}}) - {{Auth::user()->name}}</div>            
            <div class="w-full text-sm">{{App\Models\User::with('punto_venta')->find(Auth::user()->id)->punto_venta->pdv}}</div>            
        </div> <!--FIN ENCABEZADO-->
        @if(session('status')!='')
            <div class="w-full flex justify-center p-3 {{substr(session('status'),0,2)=='OK'?'bg-green-300':'bg-red-400'}}">
                <span class="font-semibold text-sm text-gray-600">{{session('status')}}</span>
            </div>    
        @endif
        <form method="post" action="{{route('plantilla_nuevo')}}">
            @csrf
        <div class="w-full rounded-b-lg bg-white p-3 flex flex-col"> <!--CONTENIDO-->
            <div class="w-full flex flex-col md:flex-row space-x-0 md:space-x-2">
                <div class="w-full md:w-1/4">
                    <span class="text-xs">Numero Empleado</span><br>
                    <input class="w-full rounded p-1 border border-gray-300" type="text" name="user" value="{{old('user')}}">
                    @error('user')
                      <br><span class="text-xs italic text-red-700 text-xs">{{ $message }}</span>
                    @enderror                    
                </div>
                <div class="w-full md:w-1/2">
                    <span class="text-xs">Nombre</span><br>
                    <input class="w-full rounded p-1 border border-gray-300" type="text" name="nombre" value="{{old('nombre')}}">
                    @error('nombre')
                      <br><span class="text-xs italic text-red-700 text-xs">{{ $message }}</span>
                    @enderror                    
                </div>
                <div class="w-full md:w-1/4">
                    <span class="text-xs">Fecha Ingreso</span><br>
                    <input class="w-full rounded p-1 border border-gray-300" type="date" name="f_ingreso" value="{{old('f_ingreso')}}" placeholder="YYYY-MM-DD">
                    @error('f_ingreso')
                      <br><span class="text-xs italic text-red-700 text-xs">{{ $message }}</span>
                    @enderror                    
                </div>
            </div>
            <div class="w-full flex flex-col md:flex-row space-x-0 md:space-x-2">
                <div class="w-full md:w-1/4">
                    <span class="text-xs">email</span><br>
                    <input class="w-full rounded p-1 border border-gray-300" type="text" name="email" value="{{old('email')}}">
                    @error('email')
                      <br><span class="text-xs italic text-red-700 text-xs">{{ $message }}</span>
                    @enderror                    
                </div>
                <div class="w-full md:w-1/4">
                    <span class="text-xs">Puesto</span><br>
                    <select class="w-full rounded p-1 border border-gray-300" type="text" name="puesto">
                        <option value="" class=""></option>
                        <?php  
                        foreach ($puestos as $puesto) {
                        ?>
                        <option value="{{$puesto->id}}" class="" {{old('puesto')==$puesto->id?'selected':''}}>{{$puesto->nombre}}</option>
                        <?php
                        }
                        ?>
                    </select>    
                    @error('puesto')
                      <br><span class="text-xs italic text-red-700 text-xs">{{ $message }}</span>
                    @enderror                    
                </div>
                <div class="w-full md:w-1/4">
                    <span class="text-xs">Sucursal</span><br>
                    <select class="w-full rounded p-1 border border-gray-300" type="text" name="sucursal">
                        <option value="" class=""></option>                        
                    <?php  
                        foreach ($sucursales as $sucursal) {
                    ?>
                        <option value="{{$sucursal->id}}" class="" {{old('sucursal')==$sucursal->id?'selected':''}}>{{$sucursal->pdv}}</option>
                    <?php
                        }
                    ?>
                    </select>
                    @error('sucursal')
                      <br><span class="text-xs italic text-red-700 text-xs">{{ $message }}</span>
                    @enderror                    
                </div>
                <div class="w-full md:w-1/4">
                    <span class="text-xs">Estatus</span><br>
                    <select class="w-full rounded p-1 border border-gray-300" type="text" name="estatus">
                        <option value="1" class="" {{old('estatus')=="1"?'selected':''}}>Activo</option>
                    </select>    
                    @error('estatus')
                      <br><span class="text-xs italic text-red-700 text-xs">{{ $message }}</span>
                    @enderror                    
                </div>

            </div>
            <div class="w-full p-2"><span class="text-sm font-bold">Claves:</span></div>
            <div class="w-full flex flex-row space-x-2 pt-2">
                <div class="w-1/6 flex justify-center">
                    <span class="text-xs">ATTUID</span>&nbsp;
                    <input class="rounded p-1 border border-gray-300" type="checkbox" name="attuid" {{old('attuid')=='on'?'checked':''}}>
                </div>
                <div class="w-1/6 flex justify-center">
                    <span class="text-xs">VPN</span>&nbsp;
                    <input class="rounded p-1 border border-gray-300" type="checkbox" name="vpn" {{old('vpn')=='on'?'checked':''}}>
                </div>
                <div class="w-1/6 flex justify-center">
                    <span class="text-xs">AVS</span>&nbsp;
                    <input class="rounded p-1 border border-gray-300" type="checkbox" name="avs" {{old('avs')=='on'?'checked':''}}>
                </div>
                <div class="w-1/6 flex justify-center">
                    <span class="text-xs">PB</span>&nbsp;
                    <input class="rounded p-1 border border-gray-300" type="checkbox" name="pb" {{old('pb')=='on'?'checked':''}}>
                </div>
                <div class="w-1/6 flex justify-center">
                    <span class="text-xs">NOE</span>&nbsp;
                    <input class="rounded p-1 border border-gray-300" type="checkbox" name="noe" {{old('noe')=='on'?'checked':''}}>
                </div>
                <div class="w-1/6 flex justify-center">
                    <span class="text-xs">ASD</span>&nbsp;
                    <input class="rounded p-1 border border-gray-300" type="checkbox" name="asd" {{old('asd')=='on'?'checked':''}}>
                </div>
            </div>
                    
        </div> <!--FIN CONTENIDO-->
        <div class="w-full flex justify-center py-4 bg-white">
            <button class="rounded p-1 border bg-green-500 hover:bg-green-700 text-gray-100 font-semibold">Guardar</button>
        </div>
        </form>
    </div>
</x-app-layout>
