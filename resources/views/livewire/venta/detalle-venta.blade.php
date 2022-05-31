<div>
    <i wire:click="abrir" class="fas fa-edit text-orange-500 text-sm" style="cursor:pointer"></i>
    <x-jet-dialog-modal wire:model="open" maxWidth="2xl">
        <x-slot name="title">
            Detalle Ventas
        </x-slot>
        <x-slot name="content">
            <div class="flex flex-col w-full">
                <div class="w-full mb-2 flex flex-row space-x-4">
                    <div class="w-1/2">
                    <x-jet-label value="Ejecutivo" />
                        <x-jet-input class="w-full text-sm" type="text" wire:model.defer="ejecutivo" readonly/>
                    </div>
                    <div class="w-1/2">
                        <x-jet-label value="Sucursal" />
                        <x-jet-input class="w-full text-sm" type="text" wire:model.defer="sucursal" readonly/>
                    </div>
                </div>
                <div class="w-full mb-2 flex flex-row space-x-4">
                    <div class="w-1/2">
                    <x-jet-label value="Cliente" />
                        <x-jet-input class="w-full text-sm" type="text" wire:model.defer="cliente"/>
                        @error('cliente') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                    </div>
                    <div class="w-1/2">
                        <x-jet-label value="email" />
                        <x-jet-input class="w-full text-sm" type="text" wire:model.defer="mail_cliente"/>
                        @error('mail_cliente') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="w-full mb-2 flex flex-row space-x-4">
                    <div class="w-1/2">
                    <x-jet-label value="RFC" />
                        <x-jet-input class="w-full text-sm" type="text" wire:model.defer="rfc"/>
                        @error('rfc') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                    </div>
                    <div class="w-1/2">
                        <x-jet-label value="Fecha" />
                        <x-jet-input class="w-full text-sm" type="date" wire:model.defer="fecha"/>
                        @error('fecha') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="w-full mb-2 flex flex-row space-x-4">
                    <div class="w-1/2">
                    <x-jet-label value="Movimiento" />
                        <select class="w-full border-gray-300 focus:border-orange-300 focus:ring focus:ring-orange-200 focus:ring-opacity-50 rounded-md shadow-sm py-1" wire:model="tipo">
                            <option value="" class=""></option>
                            <option value="ACTIVACION" class="" >ACTIVACION</option>
                            <option value="RENOVACION" class="" >RENOVACION</option>
                            <option value="ACCESORIO" class="" >ACCESORIO</option>
                            <option value="PREPAGO" class="" >PREPAGO</option>
                        </select>    
                        @error('tipo') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                    </div>
                    <div class="w-1/2">
                        <x-jet-label value="Plan" />
                        <select class="w-full border-gray-300 focus:border-orange-300 focus:ring focus:ring-orange-200 focus:ring-opacity-50 rounded-md shadow-sm py-1" wire:model="plan_id">
                            <option value="" class=""></option>
                            @foreach($planes as $plan_opcion)
                            <option value="{{$plan_opcion->id}}" class="">{{$plan_opcion->nombre}}</option>
                            @endforeach
                        </select>    
                        @error('plan_id') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="w-full mb-2 flex flex-row space-x-4">
                    <div class="w-1/3">
                    <x-jet-label value="Renta" />
                        <x-jet-input class="w-full text-sm" type="text" wire:model.defer="renta"/>
                        @error('renta') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                    </div>
                    <div class="w-1/3">
                        <x-jet-label value="Plazo" />
                        <x-jet-input class="w-full text-sm" type="text" wire:model.defer="plazo"/>
                        @error('plazo') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                    </div>
                    <div class="w-1/3">
                        <x-jet-label value="DN" />
                        <x-jet-input class="w-full text-sm" type="text" wire:model.defer="dn"/>
                        @error('dn') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="w-full mb-2 flex flex-row space-x-4">
                    <div class="w-1/3">
                    <x-jet-label value="Modelo" />
                        <x-jet-input class="w-full text-sm" type="text" wire:model.defer="equipo"/>
                        @error('equipo') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                    </div>
                    <div class="w-1/3">
                        <x-jet-label value="Propiedad" />
                        <select class="w-full border-gray-300 focus:border-orange-300 focus:ring focus:ring-orange-200 focus:ring-opacity-50 rounded-md shadow-sm py-1" wire:model="propiedad">
                            <option value="" class=""></option>
                            <option value="NUEVO" class="" >NUEVO</option>
                            <option value="PROPIO" class="" >PROPIO</option>
                        </select>    
                        @error('propiedad') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                    </div>
                    <div class="w-1/3">
                        <x-jet-label value="IMEI" />
                        <x-jet-input class="w-full text-sm" type="text" wire:model.defer="imei"/>
                        @error('imei') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="w-full mb-2 flex flex-row space-x-4">
                    <div class="w-1/4">
                    <x-jet-label value="ICCID" />
                        <x-jet-input class="w-full text-sm" type="text" wire:model.defer="iccid"/>
                        @error('iccid') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                    </div>
                    <div class="w-1/4">
                        <x-jet-label value="Contrato" />
                        <x-jet-input class="w-full text-sm" type="text" wire:model.defer="contrato"/>
                        @error('contrato') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                    </div>
                    <div class="w-1/4">
                        <x-jet-label value="Cuenta" />
                        <x-jet-input class="w-full text-sm" type="text" wire:model.defer="cuenta"/>
                        @error('cuenta') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                    </div>
                    <div class="w-1/4">
                        <x-jet-label value="Orden" />
                        <x-jet-input class="w-full text-sm" type="text" wire:model.defer="orden"/>
                        @error('orden') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="w-full mb-2 flex flex-row space-x-4">
                    <div class="w-1/3">
                    <x-jet-label value="Addon Control" />
                        <select class="w-full border-gray-300 focus:border-orange-300 focus:ring focus:ring-orange-200 focus:ring-opacity-50 rounded-md shadow-sm py-1" wire:model="addon_control">
                            <option value="1" class="" >SI</option>
                            <option value="0" class="" >NO</option>
                        </select>   
                        @error('addon_control') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                    </div>
                    <div class="w-1/3">
                        <x-jet-label value="Seguro Proteccion" />
                        <select class="w-full border-gray-300 focus:border-orange-300 focus:ring focus:ring-orange-200 focus:ring-opacity-50 rounded-md shadow-sm py-1" wire:model="seguro_proteccion">
                            <option value="1" class="" >SI</option>
                            <option value="0" class="" >NO</option>
                        </select>   
                        @error('seguro_proteccion') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                    </div>
                    <div class="w-1/3">
                        <x-jet-label value="Renta Seguro" />
                        <x-jet-input class="w-full text-sm" type="text" wire:model.defer="renta_seguro"/>
                        @error('renta_seguro') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="w-full mb-2">
                    <x-jet-label value="Observaciones" />
                    <textarea rows=4 class="w-full text-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" type="text" name="descripcion"  wire:model.defer="observaciones"></textarea>
                    @error('descripcion') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                </div>
                @if($tipo=="ACTIVACION" || $tipo=="RENOVACION")
                <div class="w-full py-3">
                    <x-jet-label class="text-base text-red-500" value="Validacion" />
                </div>
                <div class="w-full mb-2 flex flex-row space-x-4">
                    <div class="w-2/3 flex flex-col space-y-1">

                        <div class="w-full">
                            <span class="font-bold text-gray-700">CIS - </span><span class="font-bold {{$cis_id=="-1"?'text-yellow-600':($cis_id=="0"?'text-red-400':'text-green-400')}}">CO_ID {{$cis_id=="-1"?'POR DEFINIR':($cis_id=="0"?'NO ENCONTRADO':$cis_id)}}</span>
                        </div>
                        @if($cis_id>0)
                        <div class="w-full rounded border border-orange-300 px-2 py-1 flex flex-col">
                            <div class="w-full">Contrato Impreso: {{$cis_details[0]['impreso']}}</div>
                            <div class="w-full">Orden: {{$cis_details[0]['orden']}}</div>
                            <div class="w-full">Cuenta: {{$cis_details[0]['cuenta']}}</div>
                            <div class="w-full">Cliente: {{$cis_details[0]['cliente']}}</div>
                            <div class="w-full">MDN: {{$cis_details[0]['dn']}}</div>
                            <div class="w-full font-bold">CO_ID: {{$cis_details[0]['co_id']}}</div>
                            <div class="w-full">Servicio: {{$cis_details[0]['servicio']}}</div>
                            <div class="w-full">Ejecutivo: {{$cis_details[0]['ejecutivo']}}</div>
                            <div class="w-full">Estatus: {{$cis_details[0]['estatus']}}</div>
                            
                        </div>       
                        @endif
                        @if($cis_id=="-1")
                        @foreach($cis_opciones as $opcion)
                        <div class="w-full rounded border border-orange-300 px-2 py-1 flex flex-col">
                            <div class="w-full">Contrato Impreso: {{$opcion['impreso']}}</div>
                            <div class="w-full">Orden: {{$opcion['orden']}}</div>
                            <div class="w-full">Cuenta: {{$opcion['cuenta']}}</div>
                            <div class="w-full">Cliente: {{$opcion['cliente']}}</div>
                            <div class="w-full">MDN: {{$opcion['dn']}}</div>
                            <div class="w-full font-bold">CO_ID: {{$opcion['co_id']}}</div>
                            <div class="w-full">Servicio: {{$opcion['servicio']}}</div>
                            <div class="w-full">Ejecutivo: {{$opcion['ejecutivo']}}</div>
                            <div class="w-full">Estatus: {{$opcion['estatus']}}</div>
                            @if($opcion['usado']=="NO")
                                <div class="w-full py-2 flex justify-end">
                                    @if(Auth::user()->puesto==4)
                                    <button {{$procesando2==1?'disabled':''}} wire:click="mapear({{$opcion['co_id']}},{{$opcion['id']}})" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">MAPEAR</button>
                                    @else
                                    <div class="w-full py-2 flex justify-end text-gray-700">Este registro se puede mapear</div>
                                    @endif
                                </div>
                            @endif
                            @if($opcion['usado']=="SI")
                                <div class="w-full py-2 flex justify-end text-green-600">Este registro ya fue mapeado</div>
                            @endif
                            
                        </div>     
                        @endforeach  
                        @endif           
                    </div>
                    <div class="w-1/3">
                        <div class="w-full">
                            <x-jet-label value="Documentacion Completa" />
                            @if(Auth::user()->puesto==4)
                            <select wire:model="venta_doc_completa" class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm py-1">
                            <option value="0" class="">NO</option>
                            <option value="1" class="">SI</option>
                            </select> 
                            @else
                            <div class="w-full py-2 flex justify-center font-bold text-gray-700">{{$venta_doc_completa==1?'SI':'NO'}}</div>
                            @endif
                        </div>
                        <div class="w-full">
                            <x-jet-label value="Contar como comisionable" />
                            @if(Auth::user()->puesto==4)
                            <select wire:model="pagar" class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm py-1">
                            <option value="0" class="">NO</option>
                            <option value="1" class="">SI</option>
                            </select> 
                            @else
                            <div class="w-full py-2 flex justify-center font-bold text-gray-700">{{$pagar==1?'SI':'NO'}}</div>
                            @endif
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </x-slot>
        <x-slot name="footer">
            <x-jet-secondary-button wire:click="cancelar">CANCELAR</x-jet-secondary-button>
            <button {{$procesando==1?'disabled':''}} wire:click="guardar" class="inline-flex items-center justify-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 focus:outline-none focus:border-red-700 focus:ring focus:ring-red-200 active:bg-red-600 disabled:opacity-25 transition">GUARDAR<button>
        </x-slot>
    </x-jet-dialog-modal>
</div>