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
                        <x-jet-input class="w-full text-sm" type="text" wire:model.defer="ejecutivo"/>
                        @error('tipo') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                    </div>
                    <div class="w-1/2">
                        <x-jet-label value="Sucursal" />
                        <x-jet-input class="w-full text-sm" type="text" wire:model.defer="sucursal"/>
                        @error('cliente') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="w-full mb-2 flex flex-row space-x-4">
                    <div class="w-1/2">
                    <x-jet-label value="Cliente" />
                        <x-jet-input class="w-full text-sm" type="text" wire:model.defer="cliente"/>
                        @error('tipo') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                    </div>
                    <div class="w-1/2">
                        <x-jet-label value="email" />
                        <x-jet-input class="w-full text-sm" type="text" wire:model.defer="mail_cliente"/>
                        @error('cliente') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="w-full mb-2 flex flex-row space-x-4">
                    <div class="w-1/2">
                    <x-jet-label value="Movimiento" />
                        <x-jet-input class="w-full text-sm" type="text" wire:model.defer="tipo"/>
                        @error('tipo') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                    </div>
                    <div class="w-1/2">
                        <x-jet-label value="Plan" />
                        <x-jet-input class="w-full text-sm" type="text" wire:model.defer="plan"/>
                        @error('cliente') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="w-full mb-2 flex flex-row space-x-4">
                    <div class="w-1/3">
                    <x-jet-label value="Renta" />
                        <x-jet-input class="w-full text-sm" type="text" wire:model.defer="renta"/>
                        @error('tipo') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                    </div>
                    <div class="w-1/3">
                        <x-jet-label value="Plazo" />
                        <x-jet-input class="w-full text-sm" type="text" wire:model.defer="plazo"/>
                        @error('cliente') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                    </div>
                    <div class="w-1/3">
                        <x-jet-label value="Fecha" />
                        <x-jet-input class="w-full text-sm" type="text" wire:model.defer="fecha"/>
                        @error('cliente') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="w-full mb-2 flex flex-row space-x-4">
                    <div class="w-1/2">
                    <x-jet-label value="Contrato" />
                        <x-jet-input class="w-full text-sm" type="text" wire:model.defer="contrato"/>
                        @error('tipo') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                    </div>
                    <div class="w-1/2">
                        <x-jet-label value="DN" />
                        <x-jet-input class="w-full text-sm" type="text" wire:model.defer="dn"/>
                        @error('cliente') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="w-full mb-2">
                    <x-jet-label value="Observaciones" />
                    <textarea rows=4 class="w-full text-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" type="text" name="descripcion"  wire:model.defer="observaciones"></textarea>
                    @error('descripcion') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                </div>
                <div class="w-full py-3">
                    <x-jet-label class="text-base text-red-500" value="Validacion" />
                </div>
                <div class="w-full mb-2 flex flex-row space-x-4">
                    <div class="w-1/3">
                    <x-jet-label value="Validado" />
                    <select class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm py-1" name="tipo">
                        <option value="" class=""></option>
                        <option value="ACTIVACION" class="" {{old('tipo')=='ACTIVACION'?'selected':''}}>SI</option>
                        <option value="RENOVACION" class="" {{old('tipo')=='RENOVACION'?'selected':''}}>NO</option>
                    </select>    
                    </div>
                    <div class="w-1/3">
                        <x-jet-label value="Documentacion Completa" />
                        <select class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm py-1" name="tipo">
                        <option value="" class=""></option>
                        <option value="ACTIVACION" class="" {{old('tipo')=='ACTIVACION'?'selected':''}}>SI</option>
                        <option value="RENOVACION" class="" {{old('tipo')=='RENOVACION'?'selected':''}}>NO</option>
                        </select> 
                    </div>
                    <div class="w-1/3">
                        <x-jet-label value="Contar como comisionable" />
                        <select class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm py-1" name="tipo">
                        <option value="" class=""></option>
                        <option value="ACTIVACION" class="" {{old('tipo')=='ACTIVACION'?'selected':''}}>SI</option>
                        <option value="RENOVACION" class="" {{old('tipo')=='RENOVACION'?'selected':''}}>NO</option>
                        </select> 
                    </div>
                </div>
                
            </div>
        </x-slot>
        <x-slot name="footer">
            <x-jet-secondary-button wire:click="cancelar">CANCELAR</x-jet-secondary-button>
            <x-jet-danger-button wire:click="guardar">GUARDAR</x-jet-secondary-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>