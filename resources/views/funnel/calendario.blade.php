<x-app-layout>
    <x-slot name="header">
            {{ __('Funnel - Seguimiento') }}
    </x-slot>

    <div class="flex flex-col w-full text-gray-700 shadow-lg rounded-lg px-5">
        <div class="w-full rounded-t-lg bg-gray-200 p-3 flex flex-col border-b border-gray-800"> <!--ENCABEZADO-->
            <div class="w-full text-lg font-semibold">Seguimiento Funnel</div>
            <div class="w-full text-sm">({{Auth::user()->user}}) - {{Auth::user()->name}}</div>            
            <div class="w-full text-sm">{{App\Models\User::with('area_user','subarea')->find(Auth::user()->id)->subarea->nombre}}</div>            
        </div> <!--FIN ENCABEZADO-->
        
        <div class="w-full rounded-b-lg bg-white p-3 flex flex-col"> <!--CONTENIDO-->
            <div class="w-full pl-56">
                <div id='calendar'></div>
            </div>
            
        </div> <!-- FIN DEL CONTENIDO -->
    </div> <!--DIV PRINCIPAL-->

    
<!--MODAL DE DETALLES-->
        <div id="detalles" class="hidden overflow-x-hidden overflow-y-auto fixed inset-0 z-50 outline-none focus:outline-none justify-center items-center flex">
            <div class="relative w-3/5 my-6 mx-auto max-w-3xl">
                <!--content-->
                <div class="p-3 border-0 rounded-lg shadow-lg relative flex flex-col w-full bg-white outline-none focus:outline-none">
                    <!--header-->
                    <div class="flex items-start justify-between p-3 border-b border-solid border-grey-300 rounded-t">
                        <h3 class="text-xl font-semibold">
                            Detalles Prospecto
                        </h3>
                        <button class="p-1 ml-auto bg-transparent border-0 text-black opacity-5 float-right text-3xl leading-none font-semibold outline-none focus:outline-none" onClick="close_detalles()">
                            <span class="bg-transparent text-black opacity-5 h-6 w-6 text-2xl block outline-none focus:outline-none">
                                ×
                            </span>
                        </button>
                    </div>
                    <!--body-->
                    <div class="flex flex-col p-3">
                        <div class="py-2 w-full flex flex-row text-xs text-gray-700 space-x-2">
                            <div class="w-full">
                                Originado por: <input class="w-full rounded p-1 border border-white" type="text" id="nombre" readonly>
                            </div>
                        </div>
                        <div class="py-2 w-full flex flex-row text-xs text-gray-700 space-x-2">
                            <div class="w-full">
                                Prospecto <input class="w-full rounded p-1 border border-white" type="text" id="cliente">
                                <input class="hidden" type="text" id="id">
                            </div>
                        </div>
                        <div class="py-2 w-full flex flex-row text-xs text-gray-700 space-x-2">
                            <div class="w-1/3">
                                Origen <input class="w-full rounded p-1 border border-white" type="text" id="origen" readonly>
                            </div>
                            <div class="w-1/3">
                                Telefono <input class="w-full rounded p-1 border border-white" type="text" id="telefono">
                            </div>
                            <div class="w-1/3">
                                Correo <input class="w-full rounded p-1 border border-white" type="text" id="correo">
                            </div>
                        </div>
                        <div class="py-2 w-full flex flex-row text-xs text-gray-700 space-x-2">
                            <div class="w-1/3">
                                Producto <input class="w-full rounded p-1 border border-white" type="text" id="producto">
                            </div>
                            <div class="w-1/3">
                                Plan <input class="w-full rounded p-1 border border-white" type="text" id="plan">
                            </div>
                            <div class="w-1/3">
                                Equipo <input class="w-full rounded p-1 border border-white" type="text" id="equipo">
                            </div>
                        </div>
                        <div class="py-2 w-full flex flex-row text-xs text-gray-700 space-x-2">
                            <div class="w-1/3">
                                Seguimiento 1 <input class="w-full rounded p-1 border border-gray-300" type="date" id="estatus1" placeholder="YYYY-MM-DD">
                            </div>
                            <div class="w-1/3">
                                Seguimiento 2 <input class="w-full rounded p-1 border border-gray-300" type="date" id="estatus2" placeholder="YYYY-MM-DD">
                            </div>
                            <div class="w-1/3">
                                Seguimiento 3 <input class="w-full rounded p-1 border border-gray-300" type="date" id="estatus3" placeholder="YYYY-MM-DD">
                            </div>
                        </div>
                        <div class="py-2 w-full flex flex-row text-xs text-gray-700 space-x-2">
                            <div class="w-1/2">
                                Estatus 
                                <select class="w-full rounded p-1 border border-gray-300" type="text" id="estatus">
                                    <option value=""></option>
                                    <option value="Registro nuevo">Registro nuevo</option>
                                    <option value="Seguimiento">Seguimiento</option>
                                    <option value="Venta">Venta</option>
                                    <option value="Finalizar Seguimiento">Finalizar Seguimiento</option>
                                </select>
                            </div>
                            <div class="w-1/2">
                                <span class="text-xs">Fecha Siguiente Contacto</span><br>
                                <input class="w-full rounded p-1 border border-gray-300" type="date" name="fecha_sig_contacto" id="fecha_sig_contacto" value="{{old('fecha_sig_contacto')}}" placeholder='YYYY-MM-DD'>
                                @error('fecha_sig_contacto')
                                  <br><span class="text-xs italic text-red-700 text-xs">{{ $message }}</span>
                                @enderror                    
                            </div>
                        </div>
                        <div class="py-2 w-full flex flex-row text-xs text-gray-700 space-x-2">
                            <div class="w-full">
                                Observaciones
                                <textarea class="w-full rounded p-1 border border-gray-300" id="observaciones"></textarea>
                            </div>
                        </div>
                    </div>
                        <!--footer-->
                    <div class="flex items-center justify-end p-2 border-t border-solid border-gray-300 rounded-b">
                        <button class="rounded p-1 border bg-green-500 hover:bg-green-700 text-gray-100 font-semibold" onClick="guardar_detalles()">Guardar</button>&nbsp;&nbsp;
                        <button class="rounded p-1 border bg-red-500 hover:bg-red-700 text-gray-100 font-semibold" onClick="close_detalles()">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
        <div id="detalles2" class="hidden opacity-25 fixed inset-0 z-40 bg-black"></div>
        <script>
            function detalles(id)
            {
                document.getElementById("detalles").style.display="block";
                document.getElementById("detalles2").style.display="block";                
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        //document.getElementById("txtHint").innerHTML = this.responseText;
                        if(this.responseText!='')
                        {
                            respuesta=JSON.parse(this.response);
                            //console.log(respuesta);
                            document.getElementById("id").value=respuesta.id;
                            document.getElementById("origen").value=respuesta.origen;
                            document.getElementById("nombre").value=respuesta.nombre;
                            document.getElementById("cliente").value=respuesta.cliente;
                            document.getElementById("telefono").value=respuesta.telefono;
                            document.getElementById("correo").value=respuesta.correo;
                            document.getElementById("producto").value=respuesta.producto;
                            document.getElementById("plan").value=respuesta.plan;
                            document.getElementById("equipo").value=respuesta.equipo;
                            document.getElementById("estatus").value=respuesta.estatus;
                            document.getElementById("estatus1").value=respuesta.estatus1;
                            document.getElementById("estatus2").value=respuesta.estatus2;
                            document.getElementById("estatus3").value=respuesta.estatus3;
                            document.getElementById("fecha_sig_contacto").value=respuesta.fecha_sig_contacto;
                            document.getElementById("observaciones").value=respuesta.observaciones;

                        }
                        else
                        {
                            document.getElementById("id").value='';
                            document.getElementById("nombre").value='';
                            document.getElementById("origen").value='';
                            document.getElementById("cliente").value='';
                            document.getElementById("telefono").value='';
                            document.getElementById("correo").value='';
                            document.getElementById("producto").value='';
                            document.getElementById("plan").value='';
                            document.getElementById("equipo").value='';
                            document.getElementById("estatus").value='';
                            document.getElementById("estatus1").value='';
                            document.getElementById("estatus2").value='';
                            document.getElementById("estatus3").value='';
                            document.getElementById("observaciones").value='';
                            alert("Error al consultar la base de datos, intente nuevamente!");
                        }
        
                    }
                };  
                xmlhttp.open("GET", "/funnel_detalles/" + id, true);
                xmlhttp.send();
            }
            function close_detalles()
            {
                document.getElementById("detalles").style.display="none";
                document.getElementById("detalles2").style.display="none";
            }
            function guardar_detalles()
            {
                document.getElementById("detalles").style.display="none";
                document.getElementById("detalles2").style.display="none";
                id=document.getElementById("id").value;
                origen=document.getElementById("origen").value;
                cliente=document.getElementById("cliente").value;
                telefono=document.getElementById("telefono").value;
                correo=document.getElementById("correo").value;
                producto=document.getElementById("producto").value;
                plan=document.getElementById("plan").value;
                equipo=document.getElementById("equipo").value;
                            
                estatus1=document.getElementById("estatus1").value;
                estatus2=document.getElementById("estatus2").value;
                estatus3=document.getElementById("estatus3").value;
                estatus=document.getElementById("estatus").value;
                fecha_sig_contacto=document.getElementById("fecha_sig_contacto").value;

                observaciones=document.getElementById("observaciones").value;
                
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.open("POST", "/funnel_update", true);
                xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xmlhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                         console.log("Actualizacion Exitosa");
                         if(estatus=="Venta")
                         {
                             alert("Sera redirigido a la pantalla para completar la venta");
                             document.location.href="/ventas_nueva/"+origen+"/"+cliente+"/"+correo;
                         }
                         else
                         {
                            document.location.reload();
                         }
                        }
                }; 
                xmlhttp.onerror = function () {
                  alert("** Un error ha ocurrido en la actualizacion");
                };
                parametros="_token="+"{{csrf_token()}}"
                parametros+="&id="+id;
                parametros+="&estatus1="+estatus1;
                parametros+="&estatus2="+estatus2;
                parametros+="&estatus3="+estatus3;
                parametros+="&fecha_sig_contacto="+fecha_sig_contacto;
                parametros+="&estatus="+estatus;
                parametros+="&observaciones="+observaciones;
                parametros+="&cliente="+cliente;
                parametros+="&telefono="+telefono;
                parametros+="&correo="+correo;
                parametros+="&producto="+producto;
                parametros+="&plan="+plan;
                parametros+="&equipo="+equipo;
                console.log(parametros);
                xmlhttp.send(parametros);
            }
        </script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
              var calendarEl = document.getElementById('calendar');
          
              var calendar = new FullCalendar.Calendar(calendarEl, {
                headerToolbar: {
                  left: 'prev,next today',
                  center: 'title',
                  right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                initialDate: '{{$inicio}}',
                navLinks: true, // can click day/week names to navigate views
                selectable: false,
                selectMirror: false,
                
                eventClick: function(arg) {
                  detalles(arg.event.id);
                },
                editable: true,
                dayMaxEvents: true, // allow "more" link when too many events
                events: {!!$registros!!},
                locale: 'es',
                slotDuration: '24:00'
              });
          
              calendar.render();
            });
          
          </script>
</x-app-layout>
