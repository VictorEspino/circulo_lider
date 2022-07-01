<x-app-layout>
    <x-slot name="header">
            {{ $origen_funnel }}
    </x-slot>
    <form method="post" action="{{route('funnel_save')}}">
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
                    <span class="text-xs">Origen del Prospecto</span><br>
                    <select class="w-full rounded p-1 border border-gray-300" type="text" name="origen">
                        <option value="{{$origen_funnel}}" class="" >{{$origen_funnel}}</option>
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