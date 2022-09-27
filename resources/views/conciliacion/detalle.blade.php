<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-ttds leading-tight">
            {{ __('Detalle de Control') }}
        </h2>
    </x-slot>
    <div class="w-full px-8 flex flex-col">
    <div class="flex flex-col w-full bg-white text-gray-700 shadow-lg rounded-lg">
        <div class="w-full rounded-t-lg bg-gray-200 p-3 flex flex-col border-b border-gray-800"> <!--ENCABEZADO-->
            <div>
                <div class="w-full text-xl font-bold text-gray-700">Conciliacion AT&T</div>
                <div class="w-full text-lg font-semibold text-gray-700">{{$descripcion}}</div>            
                <div class="w-full text-xs font-semibold text-gray-700">De {{$fecha_inicio}} a {{$fecha_fin}}</div>                        
            </div>
        </div> <!--FIN ENCABEZADO-->
        @if(session('status')!='')
            <div class="w-full flex justify-between flex-row p-3 bg-green-300" id="estatus1">
                <div class="flex justify-center items-center">
                    <span class="font-semibold text-sm text-gray-600">{{session('status')}}</span>
                </div>
                <div>
                    <a href="javascript:eliminar_estatus()"><span class="font-semibold text-base text-gray-600">X</span></a>
                </div>        
            </div>    
        @endif
        @if(session()->has('failures') || session()->has('error_validacion'))
        <div class="bg-red-200 p-4 flex justify-center font-bold">
            El archivo no fue cargado verifique detalles al final de la pagina
        </div>
        @endif
        <div class="flex flex-col md:space-x-5 md:space-y-0 items-start md:flex-row">
            <div class="w-full p-3 md:w-1/2 md:p-5 flex flex-col">
                <div class="w-full bg-gray-200 p-2 rounded-t-lg">Callidus</div>
                <div class="w-full border-r border-l p-2 flex flex-row">
                    <div class="w-1/2">
                        <div class="w-full flex justify-center text-4xl font-semibold text-orange-600">{{number_format($n_callidus,0)}}</div>
                        <div class="w-full flex justify-center text-sm">Registros Venta</div>
                    </div>
                    <div class="w-1/2">
                        <div class="w-full flex justify-center text-4xl font-semibold text-orange-600">{{number_format($n_callidus_residual,0)}}</div>
                        <div class="w-full flex justify-center text-sm">Registros Residual</div>
                    </div>
                </div>
                <div class="w-full border-r border-l ">
                    <form method="post" action="{{route('callidus_import')}}" enctype="multipart/form-data" id="carga_ventas_callidus">
                        @csrf
                    <div class="w-full rounded-b-lg p-3 flex flex-col"> <!--CONTENIDO-->
                        <div class="w-full flex flex-row space-x-2">
                            <div class="w-4/5">
                                
                                <span class="text-xs text-ttds">Archivo Ventas</span><br>
                                <input type="hidden" name="id_conciliacion" value="{{$id_conciliacion}}" id="id_conciliacion">
                                <input class="w-full rounded p-1 border border-gray-300 bg-white" type="file" name="file_v" value="{{old('file_v')}}" id="file_v">
                                @error('file_v')
                                <br><span class="text-xs italic text-red-700 text-xs">{{ $message }}</span>
                                @enderror                    
                            </div>
                            <div class="w-1/5 flex items-end">
                                <button onClick="carga_ventas_callidus()" type="button" class="rounded px-3 py-2 border text-gray-100 font-semibold bg-[#186D92] hover:bg-ttds-hover">Cargar</button>
                            </div>                
                        </div>
                    </div> <!--FIN CONTENIDO-->
                    
                    </form>
                </div>
                <div class="w-full border-b border-r border-l rounded-b shadow-lg">
                    <form method="post" action="{{route('callidus_residual_import')}}" enctype="multipart/form-data" id="carga_residual_callidus">
                        @csrf
                    <div class="w-full rounded-b-lg p-3 flex flex-col"> <!--CONTENIDO-->
                        <div class="w-full flex flex-row space-x-2">
                            <div class="w-4/5">
                                <span class="text-xs text-ttds">Archivo Residual</span><br>
                                <input type="hidden" name="id_conciliacion" value="{{$id_conciliacion}}" id="id_conciliacion">
                                <input class="w-full rounded p-1 border border-gray-300 bg-white" type="file" name="file_r" value="{{old('file_r')}}" id="file_r">
                                @error('file_r')
                                <br><span class="text-xs italic text-red-700 text-xs">{{ $message }}</span>
                                @enderror                    
                            </div>
                            <div class="w-1/5 flex items-end">
                                <button onClick="carga_residual_callidus()" type="button" class="rounded px-3 py-2 border bg-[#186D92] hover:bg-ttds-hover text-gray-100 font-semibold">Cargar</button>
                            </div>                
                        </div>
                    </div> <!--FIN CONTENIDO-->
                    
                    </form>
                </div>                    
            </div>
            <div class="w-full p-3 md:w-1/2 md:p-5 flex flex-col ">
                <div class="w-full bg-gray-200 p-2 rounded-t-lg">Resultados Conciliacion</div>
                <div class="w-full border-r border-l p-2 flex flex-row">
                    <div class="w-1/2">
                        <div class="w-full flex justify-center text-4xl font-semibold text-orange-600"><a href="{{route('reclamos_export',['id'=>$id_conciliacion])}}">{{number_format($n_reclamos,0)}}</a></div>
                        <div class="w-full flex justify-center text-sm">Aclaraciones</div>
                    </div>
                    <div class="w-1/2">
                        <div class="w-full flex justify-center text-4xl font-semibold text-orange-600">{{number_format($alertas,0)}}</div>
                        <div class="w-full flex justify-center text-sm">Alertas Cobranza</div>
                    </div>
                </div>
                <div class="w-full border-r border-l p-2 flex flex-row border-b border-r border-l rounded-b shadow-lg">
                    <div class="w-1/2">
                        <div class="w-full flex justify-center text-4xl font-semibold text-orange-600"><a href="{{route('reclamos_residual_export',['id'=>$id_conciliacion])}}">{{number_format($n_reclamos_residual,0)}}</a></div>
                        <div class="w-full flex justify-center text-sm">Aclaraciones Residual</div>
                    </div>
                    <div class="w-1/2">
                
                    </div>
                </div>
                
            </div>

        </div>
        
        @if(session('status'))
        <div class="bg-green-200 p-4 flex justify-center font-bold rounded-b-lg" id="estatus2">
            {{session('status')}}
        </div>
        @endif
        @if(session()->has('failures'))
        <div class="bg-red-200 p-4 flex justify-center font-bold">
            El archivo no fue cargado!
        </div>
        <div class="bg-red-200 p-4 flex justify-center rounded-b-lg">
            <table class="text-sm">
                <tr>
                    <td class="bg-red-700 text-gray-100 px-3">Row</td>
                    <td class="bg-red-700 text-gray-100 px-3">Columna</td>
                    <td class="bg-red-700 text-gray-100 px-3">Error</td>
                    <td class="bg-red-700 text-gray-100 px-3">Valor</td>
                </tr>
            
                @foreach(session()->get('failures') as $validation)
                <tr>
                    <td class="px-3"><center>{{$validation->row()}}</td>
                    <td class="px-3"><center>{{$validation->attribute()}}</td>
                    <td class="px-3">
                        <ul>
                        @foreach($validation->errors() as $e)
                            <li>{{$e}}</li>
                        @endforeach
                        </ul>
                    </td>
                    
                    <td class="px-3"><center>
                    <?php
                     try{
                    ?>    
                        {{$validation->values()[$validation->attribute()]}}
                    <?php
                        }
                        catch(\Exception $e)
                        {
                            ;
                        }
                    ?>
                    </td>
                </tr>
                @endforeach

            </table>
        </div>
        @endif
        @if(session()->has('error_validacion'))
        <div class="bg-red-200 p-4 flex justify-center font-bold">
            El archivo no fue cargado!
        </div>
        <div class="bg-red-200 p-4 flex justify-center rounded-b-lg">
            <table class="text-sm">
                <tr>
                    <td class="bg-red-700 text-gray-100 px-3">Row</td>
                    <td class="bg-red-700 text-gray-100 px-3">Columna</td>
                    <td class="bg-red-700 text-gray-100 px-3">Error</td>
                    <td class="bg-red-700 text-gray-100 px-3">Valor</td>
                </tr>
            @foreach(session()->get('error_validacion') as $error)
                <tr>
                    <td class="px-3"><center>{{$error["row"]}}</td>
                    <td class="px-3"><center>{{$error["campo"]}}</td>
                    <td class="px-3"><center>{{$error["mensaje"]}}</td>
                    <td class="px-3"><center>{{$error["valor"]}}</td>
                </tr>
            @endforeach
            </table>
        </div>
        @endif
    </div>
    </div>
<div class="fixed hidden inset-0 bg-gray-900 bg-opacity-50 overflow-y-auto h-full w-full" id="modal_procesa">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-36 w-36 rounded-full bg-green-100">
                <svg version="1.1" id="L7" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                viewBox="0 0 100 100" enable-background="new 0 0 100 100" xml:space="preserve">
                <path fill="#fff" d="M31.6,3.5C5.9,13.6-6.6,42.7,3.5,68.4c10.1,25.7,39.2,38.3,64.9,28.1l-3.1-7.9c-21.3,8.4-45.4-2-53.8-23.3
                c-8.4-21.3,2-45.4,23.3-53.8L31.6,3.5z">
                    <animateTransform 
                        attributeName="transform" 
                        attributeType="XML" 
                        type="rotate"
                        dur="2s" 
                        from="0 50 50"
                        to="360 50 50" 
                        repeatCount="indefinite" />
                </path>
                <path fill="#fff" d="M42.3,39.6c5.7-4.3,13.9-3.1,18.1,2.7c4.3,5.7,3.1,13.9-2.7,18.1l4.1,5.5c8.8-6.5,10.6-19,4.1-27.7
                c-6.5-8.8-19-10.6-27.7-4.1L42.3,39.6z">
                    <animateTransform 
                        attributeName="transform" 
                        attributeType="XML" 
                        type="rotate"
                        dur="1s" 
                        from="0 50 50"
                        to="-360 50 50" 
                        repeatCount="indefinite" />
                </path>
                <path fill="#fff" d="M82,35.7C74.1,18,53.4,10.1,35.7,18S10.1,46.6,18,64.3l7.6-3.4c-6-13.5,0-29.3,13.5-35.3s29.3,0,35.3,13.5
                L82,35.7z">
                    <animateTransform 
                        attributeName="transform" 
                        attributeType="XML" 
                        type="rotate"
                        dur="2s" 
                        from="0 50 50"
                        to="360 50 50" 
                        repeatCount="indefinite" />
                </path>
                </svg>
            </div>
            <h3 class="text-lg leading-6 font-medium text-gray-900 p-3" id="mensaje">Procesando</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500">
                    Esta operacion puede tardar algunos segundos.
                </p>
            </div>
        </div>
    </div>
</div>
<!--FIN MODALES-->





    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        function ejecuta_calculo(tipo)
        {
            document.getElementById('modal_procesa').style.display="block";
            if(tipo==1){
                document.getElementById('mensaje').innerHTML = "Ejecutando Adelanto";
                document.getElementById('forma_adelanto').submit();
                }
            if(tipo==2){
                document.getElementById('mensaje').innerHTML = "Ejecutando Cierre";
                document.getElementById('forma_cierre').submit();
                }
                
        }
        function carga_ventas_callidus()
        {
            document.getElementById('modal_procesa').style.display="block";
            document.getElementById('mensaje').innerHTML = "Cargando Ventas Callidus";
            document.getElementById('carga_ventas_callidus').submit();
        }
        function carga_residual_callidus()
        {
            document.getElementById('modal_procesa').style.display="block";
            document.getElementById('mensaje').innerHTML = "Cargando Residual";
            document.getElementById('carga_residual_callidus').submit();
        }
        @if(session('status')!='')

            //setTimeout(eliminar_estatus(), 6000);
            function eliminar_estatus() {
                document.getElementById("estatus1").style.display="none";
                document.getElementById("estatus2").style.display="none";
                }   
        @endif
        </script>
</x-app-layout>
