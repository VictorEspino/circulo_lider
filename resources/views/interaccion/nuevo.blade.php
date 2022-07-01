<x-app-layout>
    <x-slot name="header">
            {{ __('Interaccion - Nuevo') }}
    </x-slot>
    <form method="post" action="{{route('interaccion_nuevo')}}">
    <div class="flex flex-col w-full text-gray-700 rounded-lg px-5">
        
        <div class="w-full rounded-t-lg bg-gray-200 p-3 flex flex-col border-b border-gray-800"> <!--ENCABEZADO-->
        <div class="w-full text-sm">({{Auth::user()->user}}) - {{Auth::user()->name}}</div>            
            <div class="w-full text-sm">{{App\Models\User::with('area_user','subarea')->find(Auth::user()->id)->subarea->nombre}}</div>            
            <div class="flex justify-end"><button class="rounded p-1 border bg-green-500 hover:bg-green-700 text-gray-100 font-semibold">Guardar</button></div>
        </div> <!--FIN ENCABEZADO-->
        
            @csrf
        
        <div class="w-full rounded-b-lg bg-white p-3 flex flex-col"> <!--CONTENIDO-->
            <div class="w-full flex flex-row space-x-2">
                <div class="w-1/3">
                    <span class="text-xs">Tramite</span><br>
                    <select class="w-full rounded p-1 border border-gray-300" type="text" name="tramite">
                        <option value="" class=""></option>                        
                    <?php  
                        $tramites=App\Models\CatalogoInteracciones::all();
                        foreach ($tramites as $tramite) {
                    ?>
                        <option value="{{$tramite->tramite}}" class="" {{old('tramite')==$tramite->tramite?'selected':''}}>{{$tramite->tramite}}</option>
                    <?php
                        }
                    ?>
                    </select> 
                    @error('tramite')
                      <br><span class="text-xs italic text-red-700 text-xs">{{ $message }}</span>
                    @enderror                    
                </div>
                <div class="w-1/3">
                    <span class="text-xs">Telefono Cliente</span><br>
                    <input class="w-full rounded p-1 border border-gray-300" type="text" name="telefono_cliente" value="{{old('telefono_cliente')}}" id="tp">
                    @error('telefono_cliente')
                      <br><span class="text-xs italic text-red-700 text-xs">{{ $message }}</span>
                    @enderror                    
                </div>
                <div class="w-1/3">
                    <span class="text-xs">Fin de Interaccion</span><br>
                    <select class="w-full rounded p-1 border border-gray-300" type="text" name="fin_interaccion" id="fin" onChange="show_funnel()">
                        <option value="" class=""></option>
                        <option value="Funnel" class="" {{old('fin_interaccion')=="Funnel"?'selected':''}}>Funnel</option>
                        <option value="Venta" class="" {{old('fin_interaccion')=="Venta"?'selected':''}}>Venta</option>
                        <option value="Ninguna" class="" {{old('fin_interaccion')=="Ninguna"?'selected':''}}>Ninguna</option>
                    </select>    
                    @error('fin_interaccion')
                      <br><span class="text-xs italic text-red-700 text-xs">{{ $message }}</span>
                    @enderror                    
                </div>
                
            </div>
            <div class="w-full flex flex-row space-x-2">
                <div class="w-full">
                    <span class="text-xs">Observaciones</span><br>
                    <textarea class="w-full rounded p-1 border border-gray-300" name="observaciones">{{old('observaciones')}}</textarea>
                    @error('observaciones')
                      <br><span class="text-xs italic text-red-700 text-xs">{{ $message }}</span>
                    @enderror                    
                </div>
                

            </div>
        </div> <!--FIN CONTENIDO-->
        <!--
        <div class="w-full flex justify-center py-4">
            <button class="rounded p-1 border bg-green-500 hover:bg-green-700 text-gray-100 font-semibold">Guardar</button>
        </div>
        -->

    </div>
    <div class="p-4"></div>
    <div id="funnel_form" class="hidden flex flex-col w-full text-gray-700 shadow-lg rounded-lg px-5">
        <div class="w-full rounded-t-lg bg-gray-200 p-3 flex flex-col border-b border-gray-800"> <!--ENCABEZADO-->
            <div class="w-full text-lg font-semibold">Registo Funnel</div>
        </div> <!--FIN ENCABEZADO-->
        <div class="w-full rounded-b-lg bg-white p-3 flex flex-col"> <!--CONTENIDO-->
            <div class="w-full flex flex-row space-x-2">
                <div class="w-1/3">
                    <span class="text-xs">Origen del Prospecto</span><br>
                    <select class="w-full rounded p-1 border border-gray-300" type="text" name="origen">
                        <option value="Tienda" class="" {{old('origen')=="Tienda"?'selected':''}}>Tienda</option>
                    </select>    
                    @error('origen')
                      <br><span class="text-xs italic text-red-700 text-xs">{{ $message }}</span>
                    @enderror                    
                </div>
                <div class="w-2/3">
                    <span class="text-xs">Nombre Prospecto</span><br>
                    <input class="w-full rounded p-1 border border-gray-300" type="text" name="funnel_nombre" value="{{old('funnel_nombre')}}">
                    @error('funnel_nombre')
                      <br><span class="text-xs italic text-red-700 text-xs">{{ $message }}</span>
                    @enderror                    
                </div>
            </div>
            <div class="w-full flex flex-row space-x-2">
                <div class="w-1/2">
                    <span class="text-xs">Telefono Prospecto</span><br>
                    <input class="w-full rounded p-1 border border-gray-300" type="text" name="funnel_telefono" value="{{old('funnel_telefono')}}" id="tf">
                    @error('funnel_telefono')
                      <br><span class="text-xs italic text-red-700 text-xs">{{ $message }}</span>
                    @enderror                    
                </div>
                <div class="w-2/3">
                    <span class="text-xs">Email Prospecto</span><br>
                    <input class="w-full rounded p-1 border border-gray-300" type="text" name="funnel_correo" value="{{old('funnel_correo')}}">
                    @error('funnel_correo')
                      <br><span class="text-xs italic text-red-700 text-xs">{{ $message }}</span>
                    @enderror                    
                </div>
            </div>
            <div class="w-full flex flex-row space-x-2">
                <div class="w-1/3">
                    <span class="text-xs">Producto Interes</span><br>
                    <select class="w-full rounded p-1 border border-gray-300" type="text" name="tipo_f">
                        <option value="" class=""></option>                        
                        <option value="ACTIVACION" class="" {{old('tipo_f')=='ACTIVACION'?'selected':''}}>ACTIVACION</option>
                        <option value="RENOVACION" class="" {{old('tipo_f')=='RENOVACION'?'selected':''}}>RENOVACION</option>
                    </select> 
                    @error('tipo_f')
                      <br><span class="text-xs italic text-red-700 text-xs">{{ $message }}</span>
                    @enderror                    
                </div>
                <div class="w-1/3">
                    <span class="text-xs">Plan Interes</span><br>
                    <input class="w-full rounded p-1 border border-gray-300" type="text" name="funnel_plan" value="{{old('funnel_plan')}}">
                    @error('funnel_plan')
                      <br><span class="text-xs italic text-red-700 text-xs">{{ $message }}</span>
                    @enderror                    
                </div>
                <div class="w-1/3">
                    <span class="text-xs">Equipo Interes</span><br>
                    <input class="w-full rounded p-1 border border-gray-300" type="text" name="funnel_equipo" value="{{old('funnel_equipo')}}">
                    @error('funnel_equipo')
                      <br><span class="text-xs italic text-red-700 text-xs">{{ $message }}</span>
                    @enderror                    
                </div>
            </div>
            <div class="w-full flex flex-row space-x-2">
                <div class="w-1/2">
                    <span class="text-xs">Estatus</span><br>
                    <input class="w-full rounded p-1 border border-gray-300" type="text" name="funnel_estatus" value="Registro nuevo" readonly>
                    @error('funnel_estatus')
                      <br><span class="text-xs italic text-red-700 text-xs">{{ $message }}</span>
                    @enderror                    
                </div>
                <div class="w-1/2">
                    <span class="text-xs">Fecha Siguiente Contacto</span><br>
                    <input class="w-full rounded p-1 border border-gray-300" type="date" name="fecha_sig_contacto" value="{{old('fecha_sig_contacto')}}" placeholder='YYYY-MM-DD'>
                    @error('fecha_sig_contacto')
                      <br><span class="text-xs italic text-red-700 text-xs">{{ $message }}</span>
                    @enderror                    
                </div>
            </div>
            <div class="w-full flex flex-row space-x-2">
                <div class="w-full">
                    <span class="text-xs">Observaciones</span><br>
                    <textarea class="w-full rounded p-1 border border-gray-300" name="observaciones_f">{{old('observaciones_f')}}</textarea>
                    @error('observaciones_f')
                      <br><span class="text-xs italic text-red-700 text-xs">{{ $message }}</span>
                    @enderror                    
                </div>
                

            </div>
        </div> <!--FIN CONTENIDO-->
        <!--
        <div class="w-full flex justify-center py-4">
            <button class="rounded p-1 border bg-green-500 hover:bg-green-700 text-gray-100 font-semibold">Guardar</button>
        </div>
        -->
        
    </div>
    <div class="p-0"></div>
    <div id="order_form" class="hidden flex flex-col w-full bg-white text-gray-700 shadow-lg rounded-lg">
        <div class="w-full rounded-t-lg bg-gray-200 p-3 flex flex-col border-b border-gray-800"> <!--ENCABEZADO-->
            <div class="w-full text-lg font-semibold">Registo Orden</div>            
        </div> <!--FIN ENCABEZADO-->
<!--        <form method="post" action="{{route('orden_nuevo')}}">
            @csrf
                    -->
        <div class="w-full rounded-b-lg bg-white p-3 flex flex-col"> <!--CONTENIDO-->
            <div class="w-full flex flex-row space-x-2">
                <div class="w-1/3">
                    <span class="text-xs">Origen de Contacto</span><br>
                    <select class="w-full rounded p-1 border border-gray-300" type="text" name="origen">                       
                        <option value="Tienda" class="" {{old('origen')=="Tienda"?'selected':''}}>Tienda</option>
                    </select>    
                    @error('origen')
                      <br><span class="text-xs italic text-red-700 text-xs">{{ $message }}</span>
                    @enderror                    
                </div>
                <div class="w-2/3">
                    <span class="text-xs">Nombre Cliente</span><br>
                    <input class="w-full rounded p-1 border border-gray-300" type="text" name="orden_nombre" value="{{old('orden_nombre')}}">
                    @error('orden_nombre')
                      <br><span class="text-xs italic text-red-700 text-xs">{{ $message }}</span>
                    @enderror                    
                </div>
            </div>
            <div class="w-full flex flex-row space-x-2">
                <div class="w-1/2">
                    <span class="text-xs">Telefono Cliente</span><br>
                    <input class="w-full rounded p-1 border border-gray-300" type="text" name="orden_telefono" value="{{old('orden_telefono')}}" id="to">
                    @error('orden_telefono')
                      <br><span class="text-xs italic text-red-700 text-xs">{{ $message }}</span>
                    @enderror                    
                </div>
                <div class="w-2/3">
                    <span class="text-xs">Email</span><br>
                    <input class="w-full rounded p-1 border border-gray-300" type="text" name="orden_correo" value="{{old('orden_correo')}}">
                    @error('orden_correo')
                      <br><span class="text-xs italic text-red-700 text-xs">{{ $message }}</span>
                    @enderror                    
                </div>
            </div>
            <div class="w-full flex flex-row space-x-2">
                <div class="w-1/3">
                    <span class="text-xs">Fecha Nacimiento</span><br>
                    <input class="w-full rounded p-1 border border-gray-300" type="date" name="f_nacimiento" id="f_nacimiento" value="{{old('f_nacimiento')}}" placeholder="YYYY-MM-DD" onchange='calcula_edad()'>
                    @error('f_nacimiento')
                      <br><span class="text-xs italic text-red-700 text-xs">{{ $message }}</span>
                    @enderror                    
                </div>
                <div class="w-1/3">
                    <span class="text-xs">Edad</span><br>
                    <input class="w-full rounded p-1 border border-gray-300" type="text" name="edad" id="edad" value="{{old('edad')}}" readonly>                    
                    @error('edad')
                      <br><span class="text-xs italic text-red-700 text-xs">{{ $message }}</span>
                    @enderror                    
                </div>
                
                <div class="w-1/3">
                    <span class="text-xs">Genero</span><br>
                    <select class="w-full rounded p-1 border border-gray-300" type="text" name="genero">
                        <option value="" class=""></option>                        
                        <option value="Femenino" class="" {{old('genero')=="Femenino"?'selected':''}}>Femenino</option>
                        <option value="Masculino" class="" {{old('genero')=="Masculino"?'selected':''}}>Masculino</option>
                        <option value="Otro" class="" {{old('genero')=="Otro"?'selected':''}}>Otro</option>
                    </select>    
                    @error('genero')
                      <br><span class="text-xs italic text-red-700 text-xs">{{ $message }}</span>
                    @enderror                    
                </div>
            </div>
            <div class="w-full flex flex-row space-x-2">
                <div class="w-1/4">
                    <span class="text-xs">Producto</span><br>
                    <select class="w-full rounded p-1 border border-gray-300" type="text" name="tipo_o">
                        <option value="" class=""></option>                        
                        <option value="ACTIVACION" class="" {{old('tipo_o')=='ACTIVACION'?'selected':''}}>ACTIVACION</option>
                        <option value="RENOVACION" class="" {{old('tipo_o')=='RENOVACION'?'selected':''}}>RENOVACION</option>
                    </select> 
                    @error('tipo_o')
                      <br><span class="text-xs italic text-red-700 text-xs">{{ $message }}</span>
                    @enderror                    
                </div>
                <div class="w-1/4">
                    <span class="text-xs">Plan</span><br>
                    <input class="w-full rounded p-1 border border-gray-300" type="text" name="orden_plan" value="{{old('orden_plan')}}">
                    @error('orden_plan')
                      <br><span class="text-xs italic text-red-700 text-xs">{{ $message }}</span>
                    @enderror                    
                </div>
                <div class="w-1/4">
                    <span class="text-xs">Equipo</span><br>
                    <input class="w-full rounded p-1 border border-gray-300" type="text" name="orden_equipo" value="{{old('orden_equipo')}}">
                    @error('orden_equipo')
                      <br><span class="text-xs italic text-red-700 text-xs">{{ $message }}</span>
                    @enderror                    
                </div>
                <div class="w-1/4">
                    <span class="text-xs">Renta</span><br>
                    <input class="w-full rounded p-1 border border-gray-300" type="text" name="orden_renta" value="{{old('orden_renta')}}">
                    @error('orden_renta')
                      <br><span class="text-xs italic text-red-700 text-xs">{{ $message }}</span>
                    @enderror                    
                </div>
            </div>
            <div class="w-full flex flex-row space-x-2">
                <div class="w-1/3">
                    <span class="text-xs">Estatus Final AT&T</span><br>
                    <select class="w-full rounded p-1 border border-gray-300" type="text" name="estatus_final">
                        <option value="" class=""></option>                        

                    </select> 
                    @error('estatus_final')
                      <br><span class="text-xs italic text-red-700 text-xs">{{ $message }}</span>
                    @enderror                  
                </div>
                <div class="w-1/3">
                    <span class="text-xs">Numero Orden</span><br>
                    <input class="w-full rounded p-1 border border-gray-300" type="text" name="numero_orden" value="{{old('numero_orden')}}">
                    @error('numero_orden')
                      <br><span class="text-xs italic text-red-700 text-xs">{{ $message }}</span>
                    @enderror                    
                </div>
                <div class="w-1/3">
                    <span class="text-xs">Flujo</span><br>
                    <select class="w-full rounded p-1 border border-gray-300" type="text" name="flujo">
                        <option value="" class=""></option>                        
                        <option value="Efectivo" class="" {{old('flujo')=="Efectivo"?'selected':''}}>Efectivo</option>
                        <option value="TDC" class="" {{old('flujo')=="TDC"?'selected':''}}>TDC</option>
                    </select>    
                    @error('flujo')
                      <br><span class="text-xs italic text-red-700 text-xs">{{ $message }}</span>
                    @enderror                    
                </div>
            </div>
            <div class="w-full flex flex-row space-x-2">
                <div class="w-1/4">
                    <span class="text-xs">Porcentaje Requerido</span><br>
                    <input class="w-full rounded p-1 border border-gray-300" type="text" name="porcentaje_requerido" value="{{old('porcentaje_requerido')}}"> 
                    @error('porcentaje_requerido')
                      <br><span class="text-xs italic text-red-700 text-xs">{{ $message }}</span>
                    @enderror                    
                </div>
                <div class="w-1/4">
                    <span class="text-xs">Monto Total</span><br>
                    <input class="w-full rounded p-1 border border-gray-300" type="text" name="monto_total" value="{{old('monto_total')}}">
                    @error('monto_total')
                      <br><span class="text-xs italic text-red-700 text-xs">{{ $message }}</span>
                    @enderror                    
                </div>
                <div class="w-1/4">
                    <span class="text-xs">Generada en</span><br>
                    <select class="w-full rounded p-1 border border-gray-300" type="text" name="generada_en">
                        <option value="Tienda" class="" {{old('generada_en')=="Tienda"?'selected':''}}>Tienda</option>
                        <option value="Virtual MAQ" class="" {{old('generada_en')=="Virtual MAQ"?'selected':''}}>Virtual MAQ</option>
                    </select>    
                    @error('generada_en')
                      <br><span class="text-xs italic text-red-700 text-xs">{{ $message }}</span>
                    @enderror                    
                </div>
                <div class="w-1/4">
                    <span class="text-xs">Riesgo</span><br>
                    <select class="w-full rounded p-1 border border-gray-300" type="text" name="riesgo">
                        <option value=""></option>
                        <option value="HH" class="" {{old('riesgo')=="HH"?'selected':''}}>HH</option>
                        <option value="HM" class="" {{old('riesgo')=="HM"?'selected':''}}>HM</option>
                        <option value="HL" class="" {{old('riesgo')=="HL"?'selected':''}}>HL</option>
                        <option value="MH" class="" {{old('riesgo')=="MH"?'selected':''}}>MH</option>
                        <option value="MM" class="" {{old('riesgo')=="MM"?'selected':''}}>MM</option>
                        <option value="ML" class="" {{old('riesgo')=="ML"?'selected':''}}>ML</option>
                        <option value="LH" class="" {{old('riesgo')=="MH"?'selected':''}}>LH</option>
                        <option value="LM" class="" {{old('riesgo')=="MM"?'selected':''}}>LM</option>
                        <option value="LL" class="" {{old('riesgo')=="ML"?'selected':''}}>LL</option>
                        <option value="Sin riesgo" class="" {{old('riesgo')=="Sin riesgo"?'selected':''}}>Sin riesgo</option>
                    </select>    
                    @error('riesgo')
                      <br><span class="text-xs italic text-red-700 text-xs">{{ $message }}</span>
                    @enderror                    
                </div>
            </div>
            <div class="w-full flex flex-row space-x-2">
                <div class="w-full">
                    <span class="text-xs">Observaciones</span><br>
                    <textarea class="w-full rounded p-1 border border-gray-300" name="observaciones_o">{{old('observaciones_o')}}</textarea>
                    @error('observaciones_o')
                      <br><span class="text-xs italic text-red-700 text-xs">{{ $message }}</span>
                    @enderror                    
                </div>
                

            </div>
        </div> <!--FIN CONTENIDO-->
<!--        <div class="w-full flex justify-center py-4">
            <button class="rounded p-1 border bg-green-500 hover:bg-green-700 text-gray-100 font-semibold">Guardar</button>
        </div>
        </form>
                    -->
    </div>
    <div id="venta_form" class="hidden flex flex-col w-full text-gray-700 shadow-lg rounded-lg px-5">
        <div class="w-full rounded-t-lg bg-gray-200 p-3 flex flex-col border-b border-gray-800"> <!--ENCABEZADO-->
            <div class="w-full text-lg font-semibold">Registo Venta</div>            
        </div> <!--FIN ENCABEZADO-->
<!--        <form method="post" action="{{route('orden_nuevo')}}">
            @csrf
                    -->
                    <div class="w-full rounded-b-lg bg-white p-3 flex flex-col space-y-2"> <!--CONTENIDO-->
            <div class="w-full flex flex-row space-x-2">
                <div class="w-1/2">
                    <x-jet-label>Movimiento</x-jet-label>
                    <select class="w-full border-gray-300 focus:border-orange-300 focus:ring focus:ring-orange-200 focus:ring-opacity-50 rounded-md shadow-sm py-1" name="tipo">
                        <option value="" class=""></option>
                        <option value="ACTIVACION" class="" {{old('tipo')=='ACTIVACION'?'selected':''}}>ACTIVACION</option>
                        <option value="RENOVACION" class="" {{old('tipo')=='RENOVACION'?'selected':''}}>RENOVACION</option>
                        <option value="ACCESORIO" class="" {{old('tipo')=='ACCESORIO'?'selected':''}}>ACCESORIO</option>
                        <option value="PREPAGO" class="" {{old('tipo')=='PREPAGO'?'selected':''}}>PREPAGO</option>
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
                <div class="w-full md:w-1/4">
                    <x-jet-label>RFC</x-jet-label>
                    <x-jet-input type="text" class="w-full" name="rfc" value="{{old('rfc')}}"></x-jet-input>
                    @error('rfc')
                      <br><span class="text-xs italic text-red-700 text-xs">{{ $message }}</span>
                    @enderror                    
                    
                </div>
                <div class="w-full md:w-1/4">
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
                    <select class="w-full border-gray-300 focus:border-orange-300 focus:ring focus:ring-orange-200 focus:ring-opacity-50 rounded-md shadow-sm py-1" name="plan">
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
                    <x-jet-label>Modelo</x-jet-label>
                    <x-jet-input type="text" class="w-full" name="equipo" value="{{old('equipo')}}"></x-jet-input>
                    @error('equipo')
                      <br><span class="text-xs italic text-red-700 text-xs">{{ $message }}</span>
                    @enderror                                     
                </div>
                <div class="w-full md:w-1/4">
                    <x-jet-label>Propiedad</x-jet-label>
                    <select class="w-full border-gray-300 focus:border-orange-300 focus:ring focus:ring-orange-200 focus:ring-opacity-50 rounded-md shadow-sm py-1" name="propiedad">
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
            </div>
            
            <div class="w-full flex flex-col space-x-0 space-y-2 md:flex-row md:space-x-2 md:space-y-0">
                <div class="w-full md:w-1/4">
                    <x-jet-label>Contrato</x-jet-label>
                    <x-jet-input type="text" class="w-full" name="contrato" value="{{old('contrato')}}"></x-jet-input>
                    @error('contrato')
                      <br><span class="text-xs italic text-red-700 text-xs">{{ $message }}</span>
                    @enderror                                     
                </div>
                <div class="w-full md:w-1/4">
                    <x-jet-label>Cuenta</x-jet-label>
                    <x-jet-input type="text" class="w-full" name="cuenta" value="{{old('cuenta')}}"></x-jet-input>
                    @error('cuenta')
                      <br><span class="text-xs italic text-red-700 text-xs">{{ $message }}</span>
                    @enderror                    
                    
                </div>
                <div class="w-full md:w-1/4">
                    <x-jet-label>Orden Contratacion</x-jet-label>
                    <x-jet-input type="text" class="w-full" name="orden" value="{{old('orden')}}"></x-jet-input>
                    @error('orden')
                      <br><span class="text-xs italic text-red-700 text-xs">{{ $message }}</span>
                    @enderror                                     
                </div>
                <div class="w-full md:w-1/4">
                    <x-jet-label>Forma de pago</x-jet-label>
                    <select class="w-full border-gray-300 focus:border-orange-300 focus:ring focus:ring-orange-200 focus:ring-opacity-50 rounded-md shadow-sm py-1" name="forma_pago">
                        <option value="SIN cargo recurrente" class="" {{old('forma_pago')=='SIN cargo recurrente'?'selected':''}}>SIN cargo recurrente</option>
                        <option value="CON cargo recurrente" class="" {{old('forma_pago')=='CON cargo recurrente'?'selected':''}}>CON cargo recurrente</option>
                    </select>    
                    @error('forma_pago')
                      <br><span class="text-xs italic text-red-700 text-xs">{{ $message }}</span>
                    @enderror                                                       
                </div>
            </div>
            <div class="w-full flex flex-col space-x-0 space-y-2 md:flex-row md:space-x-2 md:space-y-0">
                <div class="w-full md:w-1/4">
                    <x-jet-label>Addon control</x-jet-label>
                    <select class="w-full border-gray-300 focus:border-orange-300 focus:ring focus:ring-orange-200 focus:ring-opacity-50 rounded-md shadow-sm py-1" name="addon_control">
                        <option value="NO" class="" {{old('addon_control')=='NO'?'selected':''}}>NO</option>
                        <option value="SI" class="" {{old('addon_control')=='SI'?'selected':''}}>SI</option>
                    </select>    
                    @error('addon_control')
                      <br><span class="text-xs italic text-red-700 text-xs">{{ $message }}</span>
                    @enderror                    
                    
                </div>
                <div class="w-full md:w-1/4">
                <x-jet-label>Seguro de Proteccion</x-jet-label>
                    <select class="w-full border-gray-300 focus:border-orange-300 focus:ring focus:ring-orange-200 focus:ring-opacity-50 rounded-md shadow-sm py-1" name="seguro_proteccion">
                        <option value="NO" class="" {{old('seguro_proteccion')=='NO'?'selected':''}}>NO</option>
                        <option value="SI" class="" {{old('seguro_proteccion')=='SI'?'selected':''}}>SI</option>                        
                    </select>    
                    @error('seguro_proteccion')
                      <br><span class="text-xs italic text-red-700 text-xs">{{ $message }}</span>
                    @enderror                                     
                </div>
                <div class="w-full md:w-1/4">
                    <x-jet-label>Renta de seguro de proteccion</x-jet-label>
                    <x-jet-input type="text" class="w-full" name="renta_seguro" value="{{old('renta_seguro')}}"></x-jet-input>
                    @error('renta_seguro')
                      <br><span class="text-xs italic text-red-700 text-xs">{{ $message }}</span>
                    @enderror                                     
                </div>
            </div>
            <div class="w-full flex flex-col space-x-0 space-y-2 md:flex-row md:space-x-2 md:space-y-0">
                <div class="w-full">
                    <x-jet-label>Observaciones</x-jet-label>
                    <textarea class="w-full border-gray-300 focus:border-orange-300 focus:ring focus:ring-orange-200 focus:ring-opacity-50 rounded-md shadow-sm py-1" name="observaciones_v">{{old('observaciones_v')}}</textarea>
                    @error('observaciones_v')
                      <br><span class="text-xs italic text-red-700 text-xs">{{ $message }}</span>
                    @enderror                    
                    
                </div>
            </div>
        </div> <!--FIN CONTENIDO-->
        <div class="w-full flex justify-center py-4 bg-white">
            <button class="rounded p-1 border bg-green-500 hover:bg-green-700 text-gray-100 font-semibold">Guardar</button>
        </div>
    </div>
    </form>
    <script>
        function calcula_edad()
        {
            var enteredDate = document.getElementById('f_nacimiento').value;
            var years = new Date(new Date() - new Date(enteredDate)).getFullYear() - 1970;
            document.getElementById('edad').value=years;
        }
    </script>
    <script>
        function show_funnel()
        {
            //alert(document.getElementById("fin").value);
            var valor=document.getElementById("fin").value;
            
            if(valor=="Funnel")
            {
                document.getElementById("funnel_form").style.display="block";
                document.getElementById("tf").value=document.getElementById("tp").value
                document.getElementById("venta_form").style.display="none";
            }
            if(valor=="Venta")
            {
                document.getElementById("venta_form").style.display="block";
                document.getElementById("to").value=document.getElementById("tp").value
                document.getElementById("funnel_form").style.display="none";
            }
            if(valor!="Funnel" && valor!="Venta")
            {
                document.getElementById("funnel_form").style.display="none";
                document.getElementById("venta_form").style.display="none";
            }
            
            
        }
        if({{old('fin_interaccion')=='Funnel'?'true':'false'}})
        {
            document.getElementById("funnel_form").style.display="block";
            document.getElementById("tf").value=document.getElementById("tp").value
        }
        if({{old('fin_interaccion')=='Venta'?'true':'false'}})
        {
            document.getElementById("venta_form").style.display="block";
            document.getElementById("to").value=document.getElementById("tp").value
        }
    </script>

</x-app-layout>
