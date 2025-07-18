<div class="light">
    <div class="bg-white rounded-lg shadow-lg border border-gray-200">
        <!-- Header -->
        <div class="px-6 py-4 border-b border-gray-200">
            <!-- Información de Sucursal -->
            <div class="col-span-1 md:col-span-2">
                <div class="p-2 my-2 border rounded-lg border-sky-200 bg-sky-50">
                    <div class="flex items-center gap-3">
                        <div class="flex-shrink-0 h-10 w-10">
                            <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                <flux:icon name="building-office" class="w-5 h-5 text-blue-600" />
                            </div>
                        </div>
                        <div class="flex-1">
                            <div class="font-medium text-blue-800">Sucursal de Origen</div>
                            <div class="flex items-center gap-2">
                                @php
                                    $userSucursal = auth()->user()->sucursal;
                                @endphp
                                <span class="text-sm text-blue-600">{{ $userSucursal->name }} -
                                    {{ $userSucursal->code }}</span>
                                <span class="inline-flex items-center gap-2">
                                    <span class="inline-block w-5 h-5 rounded-full border border-zinc-200"
                                        style="background: {{ $userSucursal->color ?? '#3B82F6' }}"></span>
                                    <span class="text-xs text-zinc-700">{{ $userSucursal->color ?? '-' }}</span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="p-6">
            <x-mary-tabs wire:model="selectedTab">
                <!-- Tab Remitente -->
                <x-mary-tab name="remitente" label="Remitente" icon="o-user">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-6 bg-white rounded-lg shadow-sm">
                        <!-- Columna 1: Documento, Razón Social, Dirección, Ubigeo -->
                        <div class="flex flex-col gap-4">
                            <div class="flex gap-2">
                                <flux:input.group>
                                    <flux:select class="min-w-[90px]" wire:model="type_code_remitente">
                                        <flux:select.option value="DNI" selected>DNI</flux:select.option>
                                        <flux:select.option value="RUC">RUC</flux:select.option>
                                        <flux:select.option value="CE">CE</flux:select.option>
                                        <flux:select.option value="PASAPORTE">PASAPORTE</flux:select.option>
                                    </flux:select>
                                    <flux:input class="w-full" wire:model="code_remitente" placeholder="Documento" />
                                    <flux:button wire:click="searchRemitente" icon="magnifying-glass" class="">Buscar</flux:button>
                                </flux:input.group>
                            </div>
                            <flux:input placeholder="Dirección" wire:model="address_remitente" />
                        </div>
                        <div class="flex flex-col gap-4 justify-between h-full">
                            <div class="flex flex-col gap-4 flex-1">
                                <flux:input placeholder="Razón Social o Nombre Remitente" wire:model="name_remitente" />
                                <flux:input placeholder="Ubigeo" wire:model="texto_ubigeo_remitente" />
                            </div>
                            <!-- Columna 2: Teléfono y Email al final -->
                            <div class="grid grid-cols-2 gap-2">
                                <flux:input placeholder="Teléfono" wire:model="phone_remitente" />
                                <flux:input placeholder="Email" wire:model="email_remitente" />
                            </div>
                        </div>
                    </div>
                </x-mary-tab>

                <!-- Tab Destinatario -->
                <x-mary-tab name="destinatario" label="Destinatario" icon="o-user-group">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-6 bg-white rounded-lg shadow-sm">
                        <!-- Columna 1: Documento, Razón Social, Dirección, Ubigeo -->
                        <div class="flex flex-col gap-4">
                            <div class="flex gap-2">
                                <flux:input.group>
                                    <flux:select class="min-w-[90px]" wire:model="type_code_destinatario">
                                        <flux:select.option value="DNI" selected>DNI</flux:select.option>
                                        <flux:select.option value="RUC">RUC</flux:select.option>
                                        <flux:select.option value="CE">CE</flux:select.option>
                                        <flux:select.option value="PASAPORTE">PASAPORTE</flux:select.option>
                                    </flux:select>
                                    <flux:input class="w-full" wire:model="code_destinatario" placeholder="Documento" />
                                    <flux:button icon="magnifying-glass" class="">Buscar</flux:button>
                                </flux:input.group>
                            </div>
                            <flux:input placeholder="Dirección" wire:model="address_destinatario" />
                        </div>
                        <div class="flex flex-col gap-4 justify-between h-full">
                            <div class="flex flex-col gap-4 flex-1">
                                <flux:input placeholder="Razón Social o Nombre Destinatario"
                                    wire:model="name_destinatario" />
                                <flux:input placeholder="Ubigeo" wire:model="texto_ubigeo_destinatario" />
                            </div>
                            <!-- Columna 2: Teléfono y Email al final -->
                            <div class="grid grid-cols-2 gap-2">
                                <flux:input placeholder="Teléfono" wire:model="phone_destinatario" />
                                <flux:input placeholder="Email" wire:model="email_destinatario" />
                            </div>
                        </div>
                    </div>
                </x-mary-tab>
                <!-- Tab Paquetes -->
                <x-mary-tab name="paquetes" label="Paquetes" icon="o-cube">

                </x-mary-tab>
                <!-- Tab Envío -->
                <x-mary-tab name="envio" label="Envío" icon="o-truck">

                </x-mary-tab>
            </x-mary-tabs>
            <!-- Tab Envío -->
            <div class="mt-6">


                <!-- Tab Destinatario -->
                @if ($selectedTab == 'destinatario')
                @endif

                <!-- Tab Paquetes -->
                @if ($selectedTab == 'paquetes')
                <div class="grid grid-cols-1 gap-3 p-4 bg-white rounded-lg shadow-sm md:grid-cols-4">
                    <div class="col-span-1 md:col-span-1">
                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <flux:input label="CANTIDAD" wire:model="nuevoPaquete.cantidad"
                                    class="text-xs font-medium" placeholder="0" />
                            </div>
                            <div>
                                <flux:select label="UNIDAD"
                                    :options="[
                                        ['codigo' => 'UNIDAD', 'descripcion' => 'UNIDAD'],
                                        ['codigo' => 'KILOGRAMO', 'descripcion' => 'KILOGRAMO'],
                                        ['codigo' => 'METRO', 'descripcion' => 'METRO'],
                                        ['codigo' => 'LITRO', 'descripcion' => 'LITRO']
                                    ]"
                                    wire:model="nuevoPaquete.und_medida" option-value="codigo"
                                    option-label="descripcion" placeholder="Seleccione" />
                            </div>
                        </div>
                    </div>
                    <div class="col-span-1 md:col-span-2">
                        <flux:input label="DESCRIPCIÓN" wire:model="nuevoPaquete.description"
                            placeholder="Descripción del paquete" icon="clipboard-document-list" />
                    </div>
                    <div class="col-span-1 md:col-span-1">
                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <flux:input label="PESO" wire:model="nuevoPaquete.peso" suffix="KG"
                                    locale="es-PE" placeholder="0.00" />
                            </div>
                            <div>
                                <div class="flex flex-col">
                                    <flux:input label="MONTO" wire:model="nuevoPaquete.amount" suffix="S/"
                                        wire:keydown.enter="addPaquete" wire:keydown.ctrl.enter="addPaquete"
                                        placeholder="0.00" />
                                    <div class="flex justify-end gap-2 mt-2">
                                        <flux:button icon="plus" wire:click='addPaquete'
                                            class="text-white rounded-lg bg-sky-500 hover:bg-sky-600"
                                            tooltip="Agregar paquete" />
                                        <flux:button icon="trash" wire:click='resetNuevoPaquete'
                                            class="text-white bg-red-500 hover:bg-red-600 rounded-lg"
                                            tooltip="Limpiar campos" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Lista de Paquetes -->
                @if (!empty($paquetes))
                    <div class="mt-4">
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                            <x-mary-table :headers="[
                                ['key' => 'description', 'label' => 'Descripción'],
                                ['key' => 'cantidad', 'label' => 'Cantidad'],
                                ['key' => 'peso', 'label' => 'Peso (kg)'],
                                ['key' => 'amount', 'label' => 'Precio Unit.'],
                                ['key' => 'sub_total', 'label' => 'Subtotal'],
                            ]" :rows="$paquetes" striped hover>
                                <x-slot:empty>
                                    <div
                                        class="flex flex-col items-center justify-center py-6 space-y-2 text-gray-500">
                                        <flux:icon name="cube" class="w-12 h-12" />
                                        <p>No hay paquetes registrados</p>
                                        <p class="text-sm">Agregue paquetes utilizando el formulario superior</p>
                                    </div>
                                </x-slot:empty>
                            </x-mary-table>
                        </div>
                    </div>
                @endif

                <!-- Totales -->
                @if (!empty($paquetes))
                    <div class="mt-4 p-4 bg-gray-50 rounded-lg">
                        <div class="flex justify-between font-medium">
                            <span>Total Paquetes: {{ $cantidad }}</span>
                            <span>Monto Total: S/ {{ number_format($monto, 2) }}</span>
                        </div>
                    </div>
                @endif
                @endif

                <!-- Tab Envío -->
                @if ($selectedTab == 'envio')

                @endif
            </div>

        </div>

        <!-- Actions -->
        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50 flex justify-between items-center">
            <flux:button label="Reiniciar" wire:click="resetForm" icon="arrow-path" class="shadow-xl" />
            <flux:button label="Crear Encomienda" wire:click="validateTabs" icon="check" class="shadow-xl btn-primary" />
        </div>
    </div>

    <!-- Flash Messages -->
    @if (session()->has('success'))
        <div class="fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-md shadow-lg z-50">
            {{ session('success') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="fixed top-4 right-4 bg-red-500 text-white px-6 py-3 rounded-md shadow-lg z-50">
            {{ session('error') }}
        </div>
    @endif
</div>
