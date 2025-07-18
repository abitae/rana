<div class="p-8 w-full">
    <!-- Header -->
    <div class="bg-white rounded-xl shadow-md border border-zinc-100 overflow-hidden mb-8 p-4">
        <div class="px-8 py-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div class="flex-1">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="p-2 bg-blue-100 rounded-lg">
                            <flux:icon name="building-office" class="w-6 h-6 text-blue-600" />
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold text-zinc-900">Gestión de Compañía</h1>
                            <p class="text-zinc-500 text-sm">Administra la información de tu empresa de forma simple y eficiente</p>
                        </div>
                    </div>
                </div>
                @if(!$company)
                    <div class="flex gap-3">
                        <flux:button wire:click="openCompanyModal()" icon="plus" variant="primary" class="flex items-center gap-2">
                            Registrar Compañía
                        </flux:button>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Mensajes -->
    @if (session()->has('message'))
        <div class="mb-6">
            <div class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 flex items-start gap-3">
                <div class="flex-shrink-0">
                    <flux:icon name="check-circle" class="w-5 h-5 text-green-600" />
                </div>
                <div class="flex-1">
                    <p class="text-sm font-medium text-green-800">{{ session('message') }}</p>
                </div>
                <div class="flex-shrink-0">
                    <button type="button" class="text-green-400 hover:text-green-600"
                        onclick="this.parentElement.parentElement.parentElement.remove()">
                        <flux:icon name="x-mark" class="w-4 h-4" />
                    </button>
                </div>
            </div>
        </div>
    @endif

    <!-- Card Única de Compañía -->
    <div class="bg-white rounded-xl shadow-md border border-zinc-100 overflow-hidden">
        @if($company)
            <div class="p-8">
                <div class="flex items-center gap-3 mb-6">
                    <div class="p-2 bg-blue-100 rounded-lg">
                        <flux:icon name="building-office" class="w-8 h-8 text-blue-600" />
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-zinc-900 mb-1">{{ $company->razonSocial }}</h2>
                        <div class="text-zinc-500 text-sm">RUC: {{ $company->ruc }}</div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div class="space-y-4">
                        <div>
                            <div class="text-xs text-zinc-500 mb-1">Dirección</div>
                            <div class="text-zinc-900">{{ $company->address }}</div>
                        </div>
                        <div>
                            <div class="text-xs text-zinc-500 mb-1">Correo Electrónico</div>
                            <div class="text-zinc-900">{{ $company->email ?? 'No especificado' }}</div>
                        </div>
                        <div>
                            <div class="text-xs text-zinc-500 mb-1">Teléfono</div>
                            <div class="text-zinc-900">{{ $company->telephone ?? 'No especificado' }}</div>
                        </div>
                        <div>
                            <div class="text-xs text-zinc-500 mb-1">Ubigeo</div>
                            <div class="text-zinc-900">{{ $company->ubigeo ?? 'No especificado' }}</div>
                        </div>
                    </div>
                    <div class="space-y-4">
                        <div>
                            <div class="text-xs text-zinc-500 mb-1">Cuenta Banco</div>
                            <div class="text-zinc-900">{{ $company->ctaBanco ?? 'No especificado' }}</div>
                        </div>
                        <div>
                            <div class="text-xs text-zinc-500 mb-1">PIN</div>
                            <div class="text-zinc-900">{{ $company->pin ?? 'No especificado' }}</div>
                        </div>
                        <div>
                            <div class="text-xs text-zinc-500 mb-1">Nro. MTC</div>
                            <div class="text-zinc-900">{{ $company->nroMtc ?? 'No especificado' }}</div>
                        </div>
                        <div>
                            <div class="text-xs text-zinc-500 mb-1">Usuario SOL</div>
                            <div class="text-zinc-900">{{ $company->sol_user ?? 'No especificado' }}</div>
                        </div>
                    </div>
                </div>

                <div class="flex gap-3">
                    <flux:button wire:click="openCompanyModal({{ $company->id }})" icon="pencil" variant="primary">
                        Editar Información
                    </flux:button>
                </div>
            </div>
        @else
            <div class="p-8 flex flex-col items-center justify-center text-center">
                <div class="w-16 h-16 bg-zinc-100 rounded-full flex items-center justify-center mb-4">
                    <flux:icon name="building-office" class="w-8 h-8 text-zinc-400" />
                </div>
                <h3 class="text-lg font-medium text-zinc-900 mb-2">No hay compañía registrada</h3>
                <p class="text-zinc-500 mb-4">Registra la información de tu empresa para comenzar</p>
                <flux:button wire:click="openCompanyModal()" icon="plus" variant="primary">
                    Registrar Compañía
                </flux:button>
            </div>
        @endif
    </div>

    <!-- Modal de Compañía -->
    <flux:modal wire:model="showCompanyModal" variant="flyout" max-width="3xl">
        <div class="px-6 pt-6 pb-2 border-b bg-gradient-to-r from-blue-50 to-indigo-50">
            <div class="flex items-center justify-center gap-3 mb-2">
                <div class="p-2 bg-blue-100 rounded-lg">
                    <flux:icon name="building-office" class="w-6 h-6 text-blue-600" />
                </div>
                <h2 class="text-xl font-bold text-zinc-900">
                    {{ $editingCompany ? 'Editar Compañía' : 'Nueva Compañía' }}
                </h2>
            </div>
        </div>
        <div class="p-8 max-h-[80vh] overflow-y-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <flux:input wire:model.defer="ruc" label="RUC" required size="sm" />
                <flux:input wire:model.defer="razonSocial" label="Razón Social" required size="sm" />
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <flux:input wire:model.defer="address" label="Dirección" required size="sm" />
                <flux:input wire:model.defer="email" label="Correo Electrónico" type="email" size="sm" />
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <flux:input wire:model.defer="telephone" label="Teléfono" size="sm" />
                <flux:input wire:model.defer="ubigeo" label="Ubigeo" size="sm" />
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <flux:input wire:model.defer="ctaBanco" label="Cuenta Banco" size="sm" />
                <flux:input wire:model.defer="pin" label="PIN" size="sm" />
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <flux:input wire:model.defer="nroMtc" label="Nro. MTC" size="sm" />
                <flux:input wire:model.defer="logo_path" label="Logo (ruta)" size="sm" />
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <flux:input wire:model.defer="sol_user" label="Usuario SOL" size="sm" />
                <flux:input wire:model.defer="sol_pass" label="Contraseña SOL" size="sm" />
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <flux:input wire:model.defer="cert_path" label="Certificado (ruta)" size="sm" />
                <flux:input wire:model.defer="client_id" label="Client ID" size="sm" />
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <flux:input wire:model.defer="client_secret" label="Client Secret" size="sm" />
                <div class="flex items-center gap-2 mt-2">
                    <flux:checkbox wire:model.defer="production" label="Producción" />
                </div>
            </div>
        </div>
        <div class="px-6 pb-6 pt-2 border-t bg-gray-50 flex justify-end gap-3">
            <flux:button wire:click="closeCompanyModal" variant="outline" size="sm">
                Cancelar
            </flux:button>
            <flux:button wire:click="saveCompany" variant="primary" size="sm" icon="check">
                {{ $editingCompany ? 'Actualizar' : 'Crear' }}
            </flux:button>
        </div>
    </flux:modal>
</div>
