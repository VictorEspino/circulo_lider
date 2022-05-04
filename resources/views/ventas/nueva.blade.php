<x-app-layout>
    <x-slot name="header">
            {{ __('Ventas - Nueva') }}
    </x-slot>

    <div class="flex flex-col w-full bg-gray-100 text-gray-700  px-2 md:px-8">
        <div class="w-full rounded-t-lg bg-gray-200 p-3 flex flex-col border-b border-gray-800"> <!--ENCABEZADO-->
            <div class="w-full text-lg font-semibold">Registo Nueva Venta</div>
            <div class="w-full text-sm">({{Auth::user()->user}}) - {{Auth::user()->name}}</div>            
            <div class="w-full text-sm">{{App\Models\User::with('punto_venta')->find(Auth::user()->id)->punto_venta->pdv}}</div>            
        </div> <!--FIN ENCABEZADO-->
        @if(session('status')!='')
            <div class="w-full flex justify-center p-3 {{substr(session('status'),0,2)=='OK'?'bg-green-300':'bg-red-400'}}">
                <span class="font-semibold text-sm text-gray-600">{{session('status')}}</span>
            </div>    
        @endif
        <form method="post" action="{{route('ventas_nueva')}}">
            @csrf
        <div class="w-full rounded-b-lg bg-white p-3 flex flex-col space-y-2"> <!--CONTENIDO-->
            <div class="w-full flex flex-row space-x-2">
                <div class="w-1/2">
                    <x-jet-label>Movimiento</x-jet-label>
                    <select class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm py-1" name="tipo">
                        <option value="" class=""></option>
                        <option value="ACTIVACION" class="" {{old('tipo')=='ACTIVACION'?'selected':''}}>ACTIVACION</option>
                        <option value="RENOVACION" class="" {{old('tipo')=='RENOVACION'?'selected':''}}>RENOVACION</option>
                    </select>    
                    @error('tipo')
                      <br><span class="text-xs italic text-red-700 text-xs">{{ $message }}</span>
                    @enderror                    
                    
                </div>
                <div class="w-1/2">
                    <x-jet-label>Fecha</x-jet-label>
                    <x-jet-input type="date" class="w-full" name="fecha" value="{{old('fecha')}}"></x-jet-input>
                    @error('fecha')
                      <br><span class="text-xs italic text-red-700 text-xs">{{ $message }}</span>
                    @enderror                                     
                </div>
            </div>
            <div class="w-full flex flex-col space-x-0 space-y-2 md:flex-row md:space-x-2 md:space-y-0">
                <div class="w-full md:w-1/2">
                    <x-jet-label>Cliente</x-jet-label>
                    <x-jet-input type="text" class="w-full" name="cliente" value="{{old('cliente')}}"></x-jet-input>
                    @error('cliente')
                      <br><span class="text-xs italic text-red-700 text-xs">{{ $message }}</span>
                    @enderror                    
                    
                </div>
                <div class="w-full md:w-1/2">
                    <x-jet-label>email</x-jet-label>
                    <x-jet-input type="text" class="w-full" name="mail_cliente" value="{{old('mail_cliente')}}"></x-jet-input>
                    @error('mail_cliente')
                      <br><span class="text-xs italic text-red-700 text-xs">{{ $message }}</span>
                    @enderror                    
                    
                </div>
            </div>
            <div class="w-full flex flex-col space-x-0 space-y-2 md:flex-row md:space-x-2 md:space-y-0">
                <div class="w-full md:w-1/4">
                    <x-jet-label>Plan</x-jet-label>
                    <select class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm py-1" name="plan">
                        <option value="" class=""></option>
                        @foreach($planes as $plan)
                        <option value="{{$plan->id}}" class="" {{old('plan')==$plan->id?'selected':''}}>{{$plan->nombre}}</option>
                        @endforeach
                    </select>    
                    @error('plan')
                      <br><span class="text-xs italic text-red-700 text-xs">{{ $message }}</span>
                    @enderror                    
                    
                </div>
                <div class="w-full md:w-1/4">
                    <x-jet-label>DN</x-jet-label>
                    <x-jet-input type="text" class="w-full" name="dn" value="{{old('dn')}}"></x-jet-input>
                    @error('dn')
                      <br><span class="text-xs italic text-red-700 text-xs">{{ $message }}</span>
                    @enderror                                     
                </div>
                <div class="w-full md:w-1/4">
                    <x-jet-label>Renta</x-jet-label>
                    <x-jet-input type="text" class="w-full" name="renta" value="{{old('renta')}}"></x-jet-input>
                    @error('renta')
                      <br><span class="text-xs italic text-red-700 text-xs">{{ $message }}</span>
                    @enderror                                     
                </div>
                <div class="w-full md:w-1/4">
                    <x-jet-label>Plazo</x-jet-label>
                    <x-jet-input type="text" class="w-full" name="plazo" value="{{old('plazo')}}"></x-jet-input>
                    @error('plazo')
                      <br><span class="text-xs italic text-red-700 text-xs">{{ $message }}</span>
                    @enderror                                     
                </div>
            </div>
            <div class="w-full flex flex-col space-x-0 space-y-2 md:flex-row md:space-x-2 md:space-y-0">
                <div class="w-full md:w-1/4">
                    <x-jet-label>Propiedad</x-jet-label>
                    <select class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm py-1" name="propiedad">
                        <option value="" class=""></option>
                        <option value="NUEVO" class="" {{old('propiedad')=='NUEVO'?'selected':''}}>NUEVO</option>
                        <option value="PROPIO" class="" {{old('propiedad')=='PROPIO'?'selected':''}}>PROPIO</option>
                    </select>    
                    @error('propiedad')
                      <br><span class="text-xs italic text-red-700 text-xs">{{ $message }}</span>
                    @enderror                    
                    
                </div>
                <div class="w-full md:w-1/4">
                    <x-jet-label>IMEI</x-jet-label>
                    <x-jet-input type="text" class="w-full" name="imei" value="{{old('imei')}}"></x-jet-input>
                    @error('imei')
                      <br><span class="text-xs italic text-red-700 text-xs">{{ $message }}</span>
                    @enderror                                     
                </div>
                <div class="w-full md:w-1/4">
                    <x-jet-label>ICCID</x-jet-label>
                    <x-jet-input type="text" class="w-full" name="iccid" value="{{old('iccid')}}"></x-jet-input>
                    @error('iccid')
                      <br><span class="text-xs italic text-red-700 text-xs">{{ $message }}</span>
                    @enderror                                     
                </div>
                <div class="w-full md:w-1/4">
                    <x-jet-label>Contrato</x-jet-label>
                    <x-jet-input type="text" class="w-full" name="contrato" value="{{old('contrato')}}"></x-jet-input>
                    @error('contrato')
                      <br><span class="text-xs italic text-red-700 text-xs">{{ $message }}</span>
                    @enderror                                     
                </div>
            </div>
            <div class="w-full flex flex-col space-x-0 space-y-2 md:flex-row md:space-x-2 md:space-y-0">
                <div class="w-full md:w-1/4">
                    <x-jet-label>Addon control</x-jet-label>
                    <select class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm py-1" name="addon_control">
                        <option value="" class=""></option>
                        <option value="SI" class="" {{old('addon_control')=='SI'?'selected':''}}>SI</option>
                        <option value="NO" class="" {{old('addon_control')=='NO'?'selected':''}}>NO</option>
                    </select>    
                    @error('addon_control')
                      <br><span class="text-xs italic text-red-700 text-xs">{{ $message }}</span>
                    @enderror                    
                    
                </div>
                <div class="w-full md:w-1/4">
                <x-jet-label>Seguro de Proteccion</x-jet-label>
                    <select class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm py-1" name="seguro_proteccion">
                        <option value="" class=""></option>
                        <option value="SI" class="" {{old('seguro_proteccion')=='SI'?'selected':''}}>SI</option>
                        <option value="NO" class="" {{old('seguro_proteccion')=='NO'?'selected':''}}>NO</option>
                    </select>    
                    @error('seguro_proteccion')
                      <br><span class="text-xs italic text-red-700 text-xs">{{ $message }}</span>
                    @enderror                                     
                </div>
            </div>
            <div class="w-full flex flex-col space-x-0 space-y-2 md:flex-row md:space-x-2 md:space-y-0">
                <div class="w-full">
                    <x-jet-label>Observaciones</x-jet-label>
                    <textarea class="w-full rounded p-1 border border-gray-300" name="observaciones">{{old('observaciones')}}</textarea>
                    @error('observaciones')
                      <br><span class="text-xs italic text-red-700 text-xs">{{ $message }}</span>
                    @enderror                    
                    
                </div>
            </div>
        </div> <!--FIN CONTENIDO-->
        <div class="w-full flex justify-center py-4 bg-white">
            <button class="rounded p-1 border bg-green-500 hover:bg-green-700 text-gray-100 font-semibold">Guardar</button>
        </div>
        </form>
    </div>
</x-app-layout>
