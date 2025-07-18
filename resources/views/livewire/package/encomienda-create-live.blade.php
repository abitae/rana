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
                        <div class="flex-1 flex flex-col items-center justify-center text-center">
                            <div class="font-medium text-blue-800">Sucursal de Origen</div>
                            <div class="flex items-center gap-2 justify-center">
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
                <x-mary-tab name="remitente" label="Remitente" icon="o-user" :disabled="$selectedTab != 'remitente'">
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
                                    <flux:button wire:click="searchRemitente" icon="magnifying-glass" class="">
                                        Buscar</flux:button>
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
                <x-mary-tab name="destinatario" label="Destinatario" icon="o-user-group" :disabled="$selectedTab != 'destinatario'">
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
                                    <flux:button wire:click="searchDestinatario" icon="magnifying-glass" class="">
                                        Buscar</flux:button>
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
                <x-mary-tab name="paquetes" label="Paquetes" icon="o-cube" :disabled="$selectedTab != 'paquetes'">
                    <div class="p-2 bg-white rounded-lg shadow-sm">
                        <div class="mb-4">
                            <h4 class="text-md font-semibold mb-2">Agregar Paquete</h4>
                            <div class="flex flex-row gap-1 items-end">
                                <div class="w-24">
                                    <flux:input label="Cantidad" wire:model="paquete_cantidad" type="number"
                                        min="1" placeholder="0" class="text-xs px-1" />
                                </div>
                                <div class="w-32">
                                    <flux:select label="Unidad" wire:model="paquete_unidad" class="text-xs px-1">
                                        <flux:select.option value="UNIDAD">UNIDAD</flux:select.option>
                                        <flux:select.option value="KILOGRAMO">KILOGRAMO</flux:select.option>
                                        <flux:select.option value="METRO">METRO</flux:select.option>
                                        <flux:select.option value="LITRO">LITRO</flux:select.option>
                                    </flux:select>
                                </div>
                                <div class="flex-1">
                                    <flux:input label="Descripción" wire:model="paquete_descripcion"
                                        placeholder="Descripción del paquete" />
                                </div>
                                <div class="w-24">
                                    <flux:input label="Peso (kg)" wire:model="paquete_peso" type="number"
                                        min="0" step="0.01" placeholder="0.00" />
                                </div>
                                <div class="w-24">
                                    <flux:input label="Valor (S/)" wire:model="paquete_valor" type="number"
                                        min="0" step="0.01" suffix="S/" placeholder="0.00" />
                                </div>
                                <div>
                                    <flux:button color="primary" wire:click="addPaquete" icon="plus">
                                        Agregar
                                    </flux:button>
                                </div>
                            </div>
                        </div>
                        <div>
                            <h4 class="text-md font-semibold mb-2">Lista de Paquetes</h4>
                            @php
                                $total_cantidad = 0;
                                $total_valor = 0;
                            @endphp
                            @if (count($paquetes) > 0)
                                <div class="overflow-x-auto">
                                    <table class="min-w-full text-xs border">
                                        <thead>
                                            <tr class="bg-gray-100">
                                                <th class="px-2 py-1 border">Cantidad</th>
                                                <th class="px-2 py-1 border">Unidad</th>
                                                <th class="px-2 py-1 border">Descripción</th>
                                                <th class="px-2 py-1 border">Peso (kg)</th>
                                                <th class="px-2 py-1 border">Valor (S/)</th>
                                                <th class="px-2 py-1 border">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($paquetes as $index => $paq)
                                                @php
                                                    $cantidad = $paq['cantidad'] ?? ($paq['paquete_cantidad'] ?? 0);
                                                    $valor = $paq['valor'] ?? ($paq['paquete_valor'] ?? 0);
                                                    $total_cantidad += is_numeric($cantidad) ? $cantidad : 0;
                                                    $total_valor += is_numeric($valor) ? $valor : 0;
                                                @endphp
                                                <tr>
                                                    <td class="px-2 py-1 border text-center">
                                                        {{ $cantidad }}</td>
                                                    <td class="px-2 py-1 border text-center">
                                                        {{ $paq['unidad'] ?? ($paq['paquete_unidad'] ?? '') }}</td>
                                                    <td class="px-2 py-1 border">
                                                        {{ $paq['descripcion'] ?? ($paq['paquete_descripcion'] ?? '') }}
                                                    </td>
                                                    <td class="px-2 py-1 border text-right">
                                                        {{ $paq['peso'] ?? ($paq['paquete_peso'] ?? '') }}</td>
                                                    <td class="px-2 py-1 border text-right">
                                                        {{ number_format($valor, 2) }}</td>
                                                    <td class="px-2 py-1 border text-center">
                                                        <flux:button color="danger" size="xs"
                                                            wire:click="removePaquete({{ $index }})"
                                                            icon="trash">
                                                        </flux:button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr class="bg-gray-50 font-bold">
                                                <td class="px-2 py-1 border text-center">{{ $total_cantidad }}</td>
                                                <td class="px-2 py-1 border text-center" colspan="2">Totales</td>
                                                <td class="px-2 py-1 border"></td>
                                                <td class="px-2 py-1 border text-right">
                                                    {{ number_format($total_valor, 2) }}</td>
                                                <td class="px-2 py-1 border"></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            @else
                                <div class="text-gray-500 text-sm">No hay paquetes agregados.</div>
                            @endif
                        </div>
                    </div>
                </x-mary-tab>
                <!-- Tab Envío -->
                <x-mary-tab name="envio" label="Envío" icon="o-truck" :disabled="$selectedTab != 'envio'">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-6 bg-white rounded-xl shadow-lg">
                        <!-- Columna 1: Sucursal de destino y tipo de entrega -->
                        <div class="flex flex-col gap-4">
                            <flux:select label="Sucursal de destino" wire:model="sucursal_destino_id"
                                placeholder="Seleccione una sucursal" class="w-full">
                                @forelse ($sucursales as $sucursal)
                                    <flux:select.option value="{{ $sucursal->id }}">
                                        {{ $sucursal->name }}
                                    </flux:select.option>
                                @empty
                                    <flux:select.option value="">No hay sucursales disponibles
                                    </flux:select.option>
                                @endforelse
                            </flux:select>
                            <div class="flex items-center gap-4">
                                <flux:checkbox label="¿Entrega a domicilio?" wire:model.live="isHome" />
                                <flux:checkbox label="¿Encomienda de retorno?" wire:model.live="isReturn" />
                            </div>

                        </div>
                        <!-- Columna 2: Seguridad y observaciones -->
                        <div class="flex flex-col gap-4">
                            @if ($isHome)
                                <flux:field>
                                    <flux:label>Dirección de envío</flux:label>
                                    <flux:input wire:model="direccion_envio"
                                        placeholder="Ingrese la dirección de envío" class="mt-2" />
                                </flux:field>
                            @else
                                <div class="grid grid-cols-2 gap-2">
                                    <flux:field>
                                        <flux:label>PIN de seguridad (3 dígitos)</flux:label>
                                        <flux:input wire:model.live="pin_seguridad"
                                            placeholder="PIN de seguridad (3 dígitos)" maxlength="3" minlength="3"
                                            type="password" />
                                    </flux:field>
                                    <flux:field>
                                        <flux:label>Confirmar PIN de seguridad</flux:label>
                                        <flux:input wire:model.live="pin_seguridad_confirm"
                                            placeholder="Repita el PIN de seguridad" maxlength="3" minlength="3"
                                            type="password" />
                                    </flux:field>
                                </div>
                            @endif
                            <flux:textarea label="Observaciones" wire:model="observaciones"
                                placeholder="Ingrese observaciones adicionales" rows="2" class="w-full" />
                        </div>
                    </div>
                    <!-- Documentos de traslado al final y a todo el ancho -->
                    <div class="w-full mt-6 bg-white rounded-xl shadow-sm p-6">
                        <flux:checkbox label="¿Agregar documentos de traslado?" wire:model.live="isDocumentosTraslado"
                            class="mt-2" />
                        @if ($isDocumentosTraslado)
                            <div>
                                <div class="mb-3 font-semibold text-gray-700 flex items-center gap-2">
                                    <flux:icon name="document-text" class="w-6 h-6 text-blue-600" />
                                    <span class="text-lg">Documentos de traslado</span>
                                </div>
                                <div class="bg-blue-50 rounded-lg p-4 shadow-inner mb-4">
                                    <div class="flex flex-col md:flex-row gap-4 items-end">
                                        <div class="flex-1">
                                            <flux:field>
                                                <flux:label>Tipo de documento</flux:label>
                                                <flux:select wire:model="documento_tipo" placeholder="Seleccione tipo"
                                                    class="w-full">
                                                    <flux:select.option value="guia">Guía de Remisión
                                                    </flux:select.option>
                                                    <flux:select.option value="factura">Factura</flux:select.option>
                                                    <flux:select.option value="boleta">Boleta</flux:select.option>
                                                    <flux:select.option value="otro">Otro</flux:select.option>
                                                </flux:select>
                                            </flux:field>
                                        </div>
                                        <div class="flex-1">
                                            <flux:field>
                                                <flux:label>N° de documento</flux:label>
                                                <flux:input wire:model="documento_numero"
                                                    placeholder="Ingrese el número" class="w-full" />
                                            </flux:field>
                                        </div>
                                        <div class="flex-1">
                                            <flux:field>
                                                <flux:label>RUC del emisor</flux:label>
                                                <flux:input wire:model="documento_ruc_emisor"
                                                    placeholder="Ingrese RUC del emisor" maxlength="11"
                                                    class="w-full" />
                                            </flux:field>
                                        </div>
                                        <div class="flex items-end">
                                            <flux:button color="primary" icon="plus"
                                                wire:click="addDocumentoTraslado" tooltip="Agregar documento"
                                                class="transition-transform hover:scale-105">
                                                Agregar
                                            </flux:button>
                                        </div>
                                    </div>
                                </div>
                                <!-- Lista de documentos agregados -->
                                <div class="mt-2">
                                    @if (!empty($documentos_traslado))
                                        <div class="overflow-x-auto">
                                            <table class="max-w-full text-xs border rounded-lg overflow-hidden shadow">
                                                <thead>
                                                    <tr class="bg-blue-100 text-blue-900">
                                                        <th class="px-4 py-2 border text-left">#</th>
                                                        <th class="px-4 py-2 border text-left">Tipo</th>
                                                        <th class="px-4 py-2 border text-left">N° Documento</th>
                                                        <th class="px-4 py-2 border text-left">RUC Emisor</th>
                                                        <th class="px-4 py-2 border text-center"></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($documentos_traslado as $i => $doc)
                                                        <tr class="hover:bg-blue-50 transition">
                                                            <td class="px-4 py-2 border text-gray-600 text-center">
                                                                {{ $i + 1 }}
                                                            </td>
                                                            <td class="px-4 py-2 border font-medium text-gray-700">
                                                                {{ ucfirst($doc['tipo']) }}
                                                            </td>
                                                            <td class="px-4 py-2 border text-gray-700">
                                                                {{ $doc['numero'] }}
                                                            </td>
                                                            <td class="px-4 py-2 border text-gray-700">
                                                                {{ $doc['ruc_emisor'] }}
                                                            </td>
                                                            <td class="px-4 py-2 border text-center">
                                                                <flux:button color="danger" size="xs"
                                                                    wire:click="removeDocumentoTraslado({{ $i }})"
                                                                    icon="trash" tooltip="Eliminar" />
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                        <div class="text-gray-500 text-sm mt-2 flex items-center gap-2">
                                            <flux:icon name="exclamation-circle" class="w-4 h-4 text-gray-400" />
                                            No hay documentos de traslado agregados.
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                </x-mary-tab>
                <x-mary-tab name="facturacion" label="Facturación" icon="o-credit-card" :disabled="$selectedTab != 'facturacion'">

                    <div class="w-full mt-6 bg-white rounded-xl shadow-sm p-6">
                        <!-- Primera fila: Tipo de envío (ocupa todo el ancho) -->
                        <div class="mb-4">
                            <flux:select label="Tipo de envío" wire:model.live="estado_pago"
                                class="w-full text-base font-semibold">
                                <flux:select.option value="ENVIO PAGADO">ENVIO PAGADO</flux:select.option>
                                <flux:select.option value="CONTRA ENTREGA">CONTRA ENTREGA</flux:select.option>
                            </flux:select>
                        </div>
                        @if ($estado_pago == 'ENVIO PAGADO')
                            <!-- Segunda fila: Tipo de comprobante y Tipo de pago -->
                            <div class="flex flex-col md:flex-row gap-4 mb-4">
                                <div class="w-full md:w-1/2">
                                    <flux:select label="Tipo de comprobante" wire:model.live="tipo_comprobante"
                                        class="w-full">
                                        <flux:select.option value="TICKET">TICKET</flux:select.option>
                                        <flux:select.option value="FACTURA">FACTURA</flux:select.option>
                                        <flux:select.option value="BOLETA">BOLETA</flux:select.option>
                                    </flux:select>
                                </div>
                                <div class="w-full md:w-1/2">
                                    <flux:select label="Tipo de pago" wire:model.live="tipo_pago" class="w-full">
                                        <flux:select.option value="CONTADO">CONTADO</flux:select.option>
                                        <flux:select.option value="CREDITO">CREDITO</flux:select.option>
                                    </flux:select>
                                </div>
                            </div>
                            @if ($tipo_pago == 'CONTADO')
                                <!-- Tercera fila: Método de pago -->
                                <div class="mb-2">
                                    <flux:select label="Método de pago" wire:model.live="metodo_pago" class="w-full">
                                        <flux:select.option value="EFECTIVO">EFECTIVO</flux:select.option>
                                        <flux:select.option value="YAPE">YAPE</flux:select.option>
                                        <flux:select.option value="TARJETA">TARJETA</flux:select.option>
                                        <flux:select.option value="CHEQUE">CHEQUE</flux:select.option>
                                        <flux:select.option value="TRANSFERENCIA">TRANSFERENCIA</flux:select.option>
                                        <flux:select.option value="OTRO">OTRO</flux:select.option>
                                    </flux:select>
                                </div>
                            @endif

                            @if ($tipo_comprobante != 'TICKET')
                                <!-- Título de la sección de datos de facturación -->
                                <div class="mb-4 mt-6">
                                    <h4 class="text-lg font-semibold text-blue-700 flex items-center gap-2">
                                        <flux:icon name="document-text" class="w-5 h-5 text-blue-600" />
                                        Datos de facturación
                                    </h4>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- Columna 1: Documento y Dirección -->
                                    <div class="flex flex-col gap-4">
                                        <div class="flex gap-2">
                                            <flux:input.group>
                                                <flux:select class="min-w-[90px]" wire:model="type_code_facturacion">
                                                    <flux:select.option value="DNI" selected>DNI
                                                    </flux:select.option>
                                                    <flux:select.option value="RUC">RUC</flux:select.option>
                                                    <flux:select.option value="CE">CE</flux:select.option>
                                                    <flux:select.option value="PASAPORTE">PASAPORTE
                                                    </flux:select.option>
                                                </flux:select>
                                                <flux:input class="w-full" wire:model="code_facturacion"
                                                    placeholder="Documento" />
                                                <flux:button wire:click="searchFacturacion" icon="magnifying-glass"
                                                    class="">
                                                    Buscar
                                                </flux:button>
                                            </flux:input.group>
                                        </div>
                                        <flux:input placeholder="Dirección" wire:model="address_facturacion" />
                                        <flux:input placeholder="Ubigeo" wire:model="texto_ubigeo_facturacion" />
                                    </div>
                                    <!-- Columna 2: Razón Social, Teléfono y Email -->
                                    <div class="flex flex-col gap-4 h-full justify-between">
                                        <flux:input placeholder="Razón Social o Nombre Facturación"
                                            wire:model="name_facturacion" />
                                        <div class="grid grid-cols-2 gap-2">
                                            <flux:input placeholder="Teléfono" wire:model="phone_facturacion" />
                                            <flux:input placeholder="Email" wire:model="email_facturacion" />
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endif
                    </div>
                </x-mary-tab>
            </x-mary-tabs>
        </div>

        <!-- Actions -->
        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50 flex justify-between items-center">

            <flux:button wire:click="leftTabs" icon="arrow-left" class="shadow-xl"
                :disabled="$selectedTab == 'remitente'">
                Anterior
            </flux:button>

            <flux:button wire:click="validateTabs" icon:trailing="arrow-right" class="shadow-xl">
                Siguiente
            </flux:button>

        </div>
    </div>
    <div class="px-2 py-4 border-b border-gray-200">
        <div class="mb-4 grid grid-cols-1 md:grid-cols-2 gap-3">
            <!-- Remitente -->
            <div class="bg-gradient-to-br from-blue-50 to-white rounded-xl shadow-md border border-blue-200 p-3">
                <div class="flex items-center mb-2 justify-between">
                    <div class="flex items-center">
                        <flux:icon name="user" class="w-6 h-6 text-blue-500 mr-1" />
                        <h3 class="font-bold text-blue-700 text-base">Remitente</h3>
                    </div>
                    @if ($remitente_id)
                        <flux:icon name="check"
                            class="w-6 h-6 text-green-500 border border-green-500 rounded-full p-1" />
                    @else
                        <flux:icon name="x-mark"
                            class="w-6 h-6 text-red-500 border border-red-500 rounded-full p-1" />
                    @endif
                </div>
                <div class="divide-y divide-blue-100">
                    <div class="py-1 flex items-center">
                        <span class="w-28 font-semibold text-gray-600 text-xs">Tipo Documento:</span>
                        <span class="ml-1 text-gray-800 text-xs">{{ $type_code_remitente ?? '-' }}</span>
                    </div>
                    <div class="py-1 flex items-center">
                        <span class="w-28 font-semibold text-gray-600 text-xs">N° Documento:</span>
                        <span class="ml-1 text-gray-800 text-xs">{{ $code_remitente ?? '-' }}</span>
                    </div>
                    <div class="py-1 flex items-center">
                        <span class="w-28 font-semibold text-gray-600 text-xs">Nombre:</span>
                        <span class="ml-1 text-gray-800 text-xs">{{ $name_remitente ?? '-' }}</span>
                    </div>
                    <div class="py-1 flex items-center">
                        <span class="w-28 font-semibold text-gray-600 text-xs">Dirección:</span>
                        <span class="ml-1 text-gray-800 text-xs">{{ $address_remitente ?? '-' }}</span>
                    </div>
                    <div class="py-1 flex items-center">
                        <span class="w-28 font-semibold text-gray-600 text-xs">Ubigeo:</span>
                        <span
                            class="ml-1 text-gray-800 text-xs">{{ $texto_ubigeo_remitente ?? '-' }}-{{ $ubigeo_remitente ?? '-' }}</span>
                    </div>
                    <div class="py-1 flex items-center">
                        <span class="w-28 font-semibold text-gray-600 text-xs">Teléfono:</span>
                        <span class="ml-1 text-gray-800 text-xs">{{ $phone_remitente ?? '-' }}</span>
                    </div>
                    <div class="py-1 flex items-center">
                        <span class="w-28 font-semibold text-gray-600 text-xs">Email:</span>
                        <span class="ml-1 text-gray-800 text-xs">{{ $email_remitente ?? '-' }}</span>
                    </div>
                </div>
            </div>
            <!-- Destinatario -->
            <div class="bg-gradient-to-br from-emerald-50 to-white rounded-xl shadow-md border border-emerald-200 p-3">
                <div class="flex items-center mb-2 justify-between">
                    <div class="flex items-center">
                        <flux:icon name="user-group" class="w-6 h-6 text-emerald-500 mr-1" />
                        <h3 class="font-bold text-emerald-700 text-base">Destinatario</h3>
                    </div>
                    @if ($destinatario_id)
                        <flux:icon name="check"
                            class="w-6 h-6 text-green-500 border border-green-500 rounded-full p-1" />
                    @else
                        <flux:icon name="x-mark"
                            class="w-6 h-6 text-red-500 border border-red-500 rounded-full p-1" />
                    @endif
                </div>
                <div class="divide-y divide-emerald-100">
                    <div class="py-1 flex items-center">
                        <span class="w-28 font-semibold text-gray-600 text-xs">Tipo Documento:</span>
                        <span class="ml-1 text-gray-800 text-xs">{{ $type_code_destinatario ?? '-' }}</span>
                    </div>
                    <div class="py-1 flex items-center">
                        <span class="w-28 font-semibold text-gray-600 text-xs">N° Documento:</span>
                        <span class="ml-1 text-gray-800 text-xs">{{ $code_destinatario ?? '-' }}</span>
                    </div>
                    <div class="py-1 flex items-center">
                        <span class="w-28 font-semibold text-gray-600 text-xs">Nombre:</span>
                        <span class="ml-1 text-gray-800 text-xs">{{ $name_destinatario ?? '-' }}</span>
                    </div>
                    <div class="py-1 flex items-center">
                        <span class="w-28 font-semibold text-gray-600 text-xs">Dirección:</span>
                        <span class="ml-1 text-gray-800 text-xs">{{ $address_destinatario ?? '-' }}</span>
                    </div>
                    <div class="py-1 flex items-center">
                        <span class="w-28 font-semibold text-gray-600 text-xs">Ubigeo:</span>
                        <span
                            class="ml-1 text-gray-800 text-xs">{{ $texto_ubigeo_destinatario ?? '-' }}-{{ $ubigeo_destinatario ?? '-' }}</span>
                    </div>
                    <div class="py-1 flex items-center">
                        <span class="w-28 font-semibold text-gray-600 text-xs">Teléfono:</span>
                        <span class="ml-1 text-gray-800 text-xs">{{ $phone_destinatario ?? '-' }}</span>
                    </div>
                    <div class="py-1 flex items-center">
                        <span class="w-28 font-semibold text-gray-600 text-xs">Email:</span>
                        <span class="ml-1 text-gray-800 text-xs">{{ $email_destinatario ?? '-' }}</span>
                        {{ $this->selectedTab }}
                    </div>
                </div>
            </div>
        </div>
        <!-- Paquetes -->
        <div class="mt-6 bg-gradient-to-br from-yellow-50 to-white rounded-xl shadow-md border border-yellow-200 p-3">
            <div class="flex items-center mb-2 justify-between">
                <div class="flex items-center">
                    <flux:icon name="cube" class="w-6 h-6 text-yellow-500 mr-1" />
                    <h3 class="font-bold text-yellow-700 text-base">Paquetes</h3>
                </div>
                @if (is_array($paquetes) && count($paquetes) > 0)
                    <flux:icon name="check"
                        class="w-6 h-6 text-green-500 border border-green-500 rounded-full p-1" />
                @else
                    <flux:icon name="x-mark" class="w-6 h-6 text-red-500 border border-red-500 rounded-full p-1" />
                @endif
            </div>
            <div>
                @if (is_array($paquetes) && count($paquetes) > 0)
                    <table class="min-w-full text-xs text-left text-gray-700">
                        <thead>
                            <tr>
                                <th class="px-2 py-1">Descripción</th>
                                <th class="px-2 py-1">Peso</th>
                                <th class="px-2 py-1">Valor</th>
                                <th class="px-2 py-1">Cantidad</th>
                                <th class="px-2 py-1">Unidad</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($paquetes as $index => $paquete)
                                <tr class="border-b">
                                    <td class="px-2 py-1">{{ $paquete['descripcion'] ?? '-' }}</td>
                                    <td class="px-2 py-1">{{ $paquete['peso'] ?? '-' }}</td>
                                    <td class="px-2 py-1">{{ $paquete['valor'] ?? '-' }}</td>
                                    <td class="px-2 py-1">{{ $paquete['cantidad'] ?? '-' }}</td>
                                    <td class="px-2 py-1">{{ $paquete['unidad'] ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="text-gray-500 text-xs py-2">No se han agregado paquetes.</div>
                @endif
            </div>

        </div>
        <!-- Vista de Datos de Envío -->
        <div class="mt-6 bg-white rounded-lg shadow border border-blue-200 p-2">
            <div class="flex items-center mb-2">
                <flux:icon name="truck" class="w-5 h-5 text-blue-500 mr-1" />
                <h3 class="font-semibold text-blue-700 text-sm">Datos de Envío</h3>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-2 text-xs">
                <div class="flex flex-col">
                    <span class="text-gray-500">Sucursal Destino</span>
                    <span class="font-medium text-gray-800 truncate">
                        {{ optional($sucursales->where('id', $sucursal_destino_id)->first())->name ?? '-' }}
                    </span>
                </div>
                <div class="flex flex-col">
                    <span class="text-gray-500">¿Domicilio?</span>
                    <span class="font-medium text-gray-800">{{ $isHome ? 'Sí' : 'No' }}</span>
                </div>
                <div class="flex flex-col">
                    <span class="text-gray-500">¿Retorno?</span>
                    <span class="font-medium text-gray-800">{{ $isReturn ? 'Sí' : 'No' }}</span>
                </div>
                <div class="flex flex-col md:col-span-2">
                    <span class="text-gray-500">Dirección de Envío</span>
                    <span class="font-medium text-gray-800 truncate">{{ $direccion_envio ?? '-' }}</span>
                </div>
                <div class="flex flex-col">
                    @if (!$isHome)
                        <span class="text-gray-500">PIN</span>
                        <span class="font-medium text-gray-800">{{ $pin_seguridad ? '***' : '-' }}</span>
                    @endif
                </div>
                <div class="flex flex-col md:col-span-3">
                    <span class="text-gray-500">Observaciones</span>
                    <span class="font-medium text-gray-800 truncate">{{ $observaciones ?? '-' }}</span>
                </div>
            </div>
        </div>
        <!-- Vista de Datos de Facturación -->
        <div class="mt-6 bg-white rounded-lg shadow border border-blue-200 p-2">
            <div class="flex items-center mb-2">

                <h3 class="font-semibold text-blue-700 text-sm">Datos de Facturación</h3>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-2 text-xs">
                <div class="flex flex-col">
                    <span class="text-gray-500">Tipo de Comprobante</span>
                    <span class="font-medium text-gray-800">{{ $tipo_comprobante ?? '-' }}</span>
                </div>
                <div class="flex flex-col">
                    <span class="text-gray-500">Tipo de Pago</span>
                    <span class="font-medium text-gray-800">{{ $tipo_pago ?? '-' }}</span>
                </div>
                <div class="flex flex-col">
                    <span class="text-gray-500">Método de Pago</span>
                    <span class="font-medium text-gray-800">{{ $metodo_pago ?? '-' }}</span>
                </div>
                <div class="flex flex-col">
                    <span class="text-gray-500">Estado de Pago</span>
                    <span class="font-medium text-gray-800">{{ $estado_pago ?? '-' }}</span>
                </div>

            </div>

        </div>
        <div class="mt-6 bg-white rounded-lg shadow border border-blue-200 p-2">
            <div class="flex items-center mb-2">
                <h3 class="font-semibold text-blue-700 text-sm">Datos de Facturación</h3>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-2 text-xs">
                <div class="flex flex-col md:col-span-2">
                    <span class="text-gray-500">Documento</span>
                    <span class="font-medium text-gray-800">
                        {{ $type_code_facturacion ?? '-' }}: {{ $code_facturacion ?? '-' }}
                    </span>
                </div>
                <div class="flex flex-col md:col-span-3">
                    <span class="text-gray-500">Nombre/Razón Social</span>
                    <span class="font-medium text-gray-800 truncate">{{ $name_facturacion ?? '-' }}</span>
                </div>
                <div class="flex flex-col md:col-span-2">
                    <span class="text-gray-500">Dirección</span>
                    <span class="font-medium text-gray-800 truncate">{{ $address_facturacion ?? '-' }}</span>
                </div>
                <div class="flex flex-col">
                    <span class="text-gray-500">Ubigeo</span>
                    <span class="font-medium text-gray-800">{{ $ubigeo_facturacion ?? '-' }}</span>
                </div>
                <div class="flex flex-col md:col-span-2">
                    <span class="text-gray-500">Texto Ubigeo</span>
                    <span class="font-medium text-gray-800 truncate">{{ $texto_ubigeo_facturacion ?? '-' }}</span>
                </div>
                <div class="flex flex-col">
                    <span class="text-gray-500">Teléfono</span>
                    <span class="font-medium text-gray-800">{{ $phone_facturacion ?? '-' }}</span>
                </div>
                <div class="flex flex-col">
                    <span class="text-gray-500">Correo</span>
                    <span class="font-medium text-gray-800">{{ $email_facturacion ?? '-' }}</span>
                </div>
            </div>
        </div>
    </div>
    <flux:modal wire:model="modalConfirmacionEncomienda" class="w-full">
        <div class="px-2 py-4 border-b border-gray-200 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Remitente -->
                <div class="bg-gradient-to-br from-blue-50 to-white rounded-xl shadow border border-blue-200 p-4">
                    <div class="flex items-center mb-3 justify-between">
                        <div class="flex items-center gap-2">
                            <flux:icon name="user" class="w-6 h-6 text-blue-500" />
                            <h3 class="font-bold text-blue-700 text-base">Remitente</h3>
                        </div>
                        <flux:icon
                            name="{{ $remitente_id ? 'check' : 'x-mark' }}"
                            class="w-6 h-6 {{ $remitente_id ? 'text-green-500 border-green-500' : 'text-red-500 border-red-500' }} border rounded-full p-1"
                        />
                    </div>
                    <dl class="divide-y divide-blue-100 text-xs">
                        <div class="flex py-1 items-center">
                            <dt class="w-28 font-semibold text-gray-600">Tipo Documento:</dt>
                            <dd class="ml-1 text-gray-800">{{ $type_code_remitente ?? '-' }}</dd>
                        </div>
                        <div class="flex py-1 items-center">
                            <dt class="w-28 font-semibold text-gray-600">N° Documento:</dt>
                            <dd class="ml-1 text-gray-800">{{ $code_remitente ?? '-' }}</dd>
                        </div>
                        <div class="flex py-1 items-center">
                            <dt class="w-28 font-semibold text-gray-600">Nombre:</dt>
                            <dd class="ml-1 text-gray-800 truncate">{{ $name_remitente ?? '-' }}</dd>
                        </div>
                        <div class="flex py-1 items-center">
                            <dt class="w-28 font-semibold text-gray-600">Dirección:</dt>
                            <dd class="ml-1 text-gray-800 truncate">{{ $address_remitente ?? '-' }}</dd>
                        </div>
                        <div class="flex py-1 items-center">
                            <dt class="w-28 font-semibold text-gray-600">Ubigeo:</dt>
                            <dd class="ml-1 text-gray-800">{{ $texto_ubigeo_remitente ?? '-' }}-{{ $ubigeo_remitente ?? '-' }}</dd>
                        </div>
                        <div class="flex py-1 items-center">
                            <dt class="w-28 font-semibold text-gray-600">Teléfono:</dt>
                            <dd class="ml-1 text-gray-800">{{ $phone_remitente ?? '-' }}</dd>
                        </div>
                        <div class="flex py-1 items-center">
                            <dt class="w-28 font-semibold text-gray-600">Email:</dt>
                            <dd class="ml-1 text-gray-800 truncate">{{ $email_remitente ?? '-' }}</dd>
                        </div>
                    </dl>
                </div>
                <!-- Destinatario -->
                <div class="bg-gradient-to-br from-emerald-50 to-white rounded-xl shadow border border-emerald-200 p-4">
                    <div class="flex items-center mb-3 justify-between">
                        <div class="flex items-center gap-2">
                            <flux:icon name="user-group" class="w-6 h-6 text-emerald-500" />
                            <h3 class="font-bold text-emerald-700 text-base">Destinatario</h3>
                        </div>
                        <flux:icon
                            name="{{ $destinatario_id ? 'check' : 'x-mark' }}"
                            class="w-6 h-6 {{ $destinatario_id ? 'text-green-500 border-green-500' : 'text-red-500 border-red-500' }} border rounded-full p-1"
                        />
                    </div>
                    <dl class="divide-y divide-emerald-100 text-xs">
                        <div class="flex py-1 items-center">
                            <dt class="w-28 font-semibold text-gray-600">Tipo Documento:</dt>
                            <dd class="ml-1 text-gray-800">{{ $type_code_destinatario ?? '-' }}</dd>
                        </div>
                        <div class="flex py-1 items-center">
                            <dt class="w-28 font-semibold text-gray-600">N° Documento:</dt>
                            <dd class="ml-1 text-gray-800">{{ $code_destinatario ?? '-' }}</dd>
                        </div>
                        <div class="flex py-1 items-center">
                            <dt class="w-28 font-semibold text-gray-600">Nombre:</dt>
                            <dd class="ml-1 text-gray-800 truncate">{{ $name_destinatario ?? '-' }}</dd>
                        </div>
                        <div class="flex py-1 items-center">
                            <dt class="w-28 font-semibold text-gray-600">Dirección:</dt>
                            <dd class="ml-1 text-gray-800 truncate">{{ $address_destinatario ?? '-' }}</dd>
                        </div>
                        <div class="flex py-1 items-center">
                            <dt class="w-28 font-semibold text-gray-600">Ubigeo:</dt>
                            <dd class="ml-1 text-gray-800">{{ $texto_ubigeo_destinatario ?? '-' }}-{{ $ubigeo_destinatario ?? '-' }}</dd>
                        </div>
                        <div class="flex py-1 items-center">
                            <dt class="w-28 font-semibold text-gray-600">Teléfono:</dt>
                            <dd class="ml-1 text-gray-800">{{ $phone_destinatario ?? '-' }}</dd>
                        </div>
                        <div class="flex py-1 items-center">
                            <dt class="w-28 font-semibold text-gray-600">Email:</dt>
                            <dd class="ml-1 text-gray-800 truncate">{{ $email_destinatario ?? '-' }}</dd>
                        </div>
                    </dl>
                </div>
            </div>

            <!-- Paquetes -->
            <div class="bg-gradient-to-br from-yellow-50 to-white rounded-xl shadow border border-yellow-200 p-4">
                <div class="flex items-center mb-3 justify-between">
                    <div class="flex items-center gap-2">
                        <flux:icon name="cube" class="w-6 h-6 text-yellow-500" />
                        <h3 class="font-bold text-yellow-700 text-base">Paquetes</h3>
                    </div>
                    <flux:icon
                        name="{{ (is_array($paquetes) && count($paquetes) > 0) ? 'check' : 'x-mark' }}"
                        class="w-6 h-6 {{ (is_array($paquetes) && count($paquetes) > 0) ? 'text-green-500 border-green-500' : 'text-red-500 border-red-500' }} border rounded-full p-1"
                    />
                </div>
                @if (is_array($paquetes) && count($paquetes) > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-xs text-left text-gray-700">
                            <thead>
                                <tr>
                                    <th class="px-2 py-1">Cantidad</th>
                                    <th class="px-2 py-1">Descripción</th>
                                    <th class="px-2 py-1">Peso</th>
                                    <th class="px-2 py-1">Valor</th>
                                    <th class="px-2 py-1">Unidad</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($paquetes as $paquete)
                                    <tr class="border-b">
                                        <td class="px-2 py-1">{{ $paquete['cantidad'] ?? '-' }}</td>
                                        <td class="px-2 py-1">{{ $paquete['descripcion'] ?? '-' }}</td>
                                        <td class="px-2 py-1">{{ $paquete['peso'] ?? '-' }}</td>
                                        <td class="px-2 py-1">{{ $paquete['valor'] ?? '-' }}</td>
                                        <td class="px-2 py-1">{{ $paquete['unidad'] ?? '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-gray-500 text-xs py-2">No se han agregado paquetes.</div>
                @endif
            </div>

            <!-- Datos de Envío -->
            <div class="bg-white rounded-lg shadow border border-blue-200 p-4">
                <div class="flex items-center mb-3 gap-2">
                    <flux:icon name="truck" class="w-5 h-5 text-blue-500" />
                    <h3 class="font-semibold text-blue-700 text-sm">Datos de Envío</h3>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-2 text-xs">
                    <div class="flex flex-col">
                        <span class="text-gray-500">Sucursal Destino</span>
                        <span class="font-medium text-gray-800 truncate">
                            {{ optional($sucursales->where('id', $sucursal_destino_id)->first())->name ?? '-' }}
                        </span>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-gray-500">¿Domicilio?</span>
                        <span class="font-medium text-gray-800">{{ $isHome ? 'Sí' : 'No' }}</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-gray-500">¿Retorno?</span>
                        <span class="font-medium text-gray-800">{{ $isReturn ? 'Sí' : 'No' }}</span>
                    </div>
                    <div class="flex flex-col md:col-span-2">
                        <span class="text-gray-500">Dirección de Envío</span>
                        <span class="font-medium text-gray-800 truncate">{{ $direccion_envio ?? '-' }}</span>
                    </div>
                    @if (!$isHome)
                    <div class="flex flex-col">
                        <span class="text-gray-500">PIN</span>
                        <span class="font-medium text-gray-800">{{ $pin_seguridad ? '***' : '-' }}</span>
                    </div>
                    @endif
                    <div class="flex flex-col md:col-span-3">
                        <span class="text-gray-500">Observaciones</span>
                        <span class="font-medium text-gray-800 truncate">{{ $observaciones ?? '-' }}</span>
                    </div>
                </div>
            </div>

            <!-- Datos de Facturación -->
            <div class="bg-white rounded-lg shadow border border-blue-200 p-4">
                <div class="flex items-center mb-3 gap-2">
                    <flux:icon name="document-text" class="w-5 h-5 text-blue-500" />
                    <h3 class="font-semibold text-blue-700 text-sm">Datos de Facturación</h3>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-2 text-xs">
                    <div class="flex flex-col">
                        <span class="text-gray-500">Tipo de Comprobante</span>
                        <span class="font-medium text-gray-800">{{ $tipo_comprobante ?? '-' }}</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-gray-500">Tipo de Pago</span>
                        <span class="font-medium text-gray-800">{{ $tipo_pago ?? '-' }}</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-gray-500">Método de Pago</span>
                        <span class="font-medium text-gray-800">{{ $metodo_pago ?? '-' }}</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-gray-500">Estado de Pago</span>
                        <span class="font-medium text-gray-800">{{ $estado_pago ?? '-' }}</span>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-2 text-xs mt-3">
                    <div class="flex flex-col md:col-span-2">
                        <span class="text-gray-500">Documento</span>
                        <span class="font-medium text-gray-800">
                            {{ $type_code_facturacion ?? '-' }}: {{ $code_facturacion ?? '-' }}
                        </span>
                    </div>
                    <div class="flex flex-col md:col-span-2">
                        <span class="text-gray-500">Nombre/Razón Social</span>
                        <span class="font-medium text-gray-800 truncate">{{ $name_facturacion ?? '-' }}</span>
                    </div>
                    <div class="flex flex-col md:col-span-2">
                        <span class="text-gray-500">Dirección</span>
                        <span class="font-medium text-gray-800 truncate">{{ $address_facturacion ?? '-' }}</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-gray-500">Ubigeo</span>
                        <span class="font-medium text-gray-800">{{ $ubigeo_facturacion ?? '-' }}</span>
                    </div>
                    <div class="flex flex-col md:col-span-2">
                        <span class="text-gray-500">Texto Ubigeo</span>
                        <span class="font-medium text-gray-800 truncate">{{ $texto_ubigeo_facturacion ?? '-' }}</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-gray-500">Teléfono</span>
                        <span class="font-medium text-gray-800">{{ $phone_facturacion ?? '-' }}</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-gray-500">Correo</span>
                        <span class="font-medium text-gray-800">{{ $email_facturacion ?? '-' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </flux:modal>
</div>
