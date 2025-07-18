<div class="p-8 w-full">
    <!-- Header -->
    <div class="bg-white rounded-xl shadow-md border border-zinc-100 overflow-hidden mb-8 p-4">
        <div class="px-8 py-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div class="flex-1">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="p-2 bg-blue-100 rounded-lg">
                            <x-flux::icon name="banknotes" class="w-6 h-6 text-blue-600" />
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold text-zinc-900">Gestión de Caja</h1>
                            <p class="text-zinc-500 text-sm">Administra tus movimientos de caja de forma simple y segura
                            </p>
                        </div>
                    </div>

                </div>
                <div class="flex gap-3">
                    <flux:button wire:click="showHistorialModal = true" icon="clock" variant="outline"
                        class="flex items-center gap-2">
                        Historial
                    </flux:button>
                    @if ($cajaActiva)
                        <flux:button wire:click="openCajaModal({{ $cajaActiva->id }})" icon="lock-closed"
                            variant="danger" class="flex items-center gap-2">
                            Cerrar Caja
                        </flux:button>
                    @else
                        <flux:button wire:click="openCajaModal()" icon="banknotes" variant="primary"
                            class="flex items-center gap-2">
                            Abrir Caja
                        </flux:button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Mensajes -->
    @if (session()->has('message'))
        <div class="mb-6">
            <div class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 flex items-start gap-3">
                <div class="flex-shrink-0">
                    <x-flux::icon name="check-circle" class="w-5 h-5 text-green-600" />
                </div>
                <div class="flex-1">
                    <p class="text-sm font-medium text-green-800">{{ session('message') }}</p>
                </div>
                <div class="flex-shrink-0">
                    <button type="button" class="text-green-400 hover:text-green-600"
                        onclick="this.parentElement.parentElement.parentElement.remove()">
                        <x-flux::icon name="x-mark" class="w-4 h-4" />
                    </button>
                </div>
            </div>
        </div>
    @endif

    <!-- Lista de Cajas -->
    <div class="space-y-8">
        @if ($cajaActiva)
            <div class="bg-white rounded-xl shadow-md border border-zinc-100 overflow-hidden">
                <div
                    class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 px-6 py-4 border-b bg-zinc-50">
                    <div>
                        <h3 class="text-xl font-semibold text-zinc-900">
                            Caja #{{ $cajaActiva->id }}
                            <span class="ml-2 px-2 py-1 text-xs rounded-full bg-green-100 text-green-700">
                                Activa
                            </span>
                        </h3>
                        <p class="text-sm text-zinc-500">
                            Usuario: <span class="font-medium">{{ $cajaActiva->user->name }}</span>
                            <span class="mx-2">|</span>
                            Apertura: {{ $cajaActiva->created_at->format('d/m/Y H:i') }}
                        </p>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 px-6 py-4 bg-blue-50 text-center">
                    <div>
                        <div class="text-xs text-zinc-500">Apertura</div>
                        <div class="text-lg font-bold text-zinc-900">
                            ${{ number_format($cajaActiva->monto_apertura, 2) }}</div>
                    </div>
                    <div>
                        <div class="text-xs text-zinc-500">Entradas</div>
                        <div class="text-lg font-bold text-green-600">
                            ${{ number_format($this->getTotalEntries($cajaActiva), 2) }}</div>
                    </div>
                    <div>
                        <div class="text-xs text-zinc-500">Salidas</div>
                        <div class="text-lg font-bold text-red-600">
                            ${{ number_format($this->getTotalExits($cajaActiva), 2) }}</div>
                    </div>
                    <div>
                        <div class="text-xs text-zinc-500">Balance</div>
                        <div
                            class="text-lg font-bold {{ $this->getBalance($cajaActiva) >= 0 ? 'text-green-600' : 'text-red-600' }}">
                            ${{ number_format($this->getBalance($cajaActiva), 2) }}
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 p-6">
                    <!-- Entradas -->
                    <div>
                        <div class="flex justify-between items-center mb-4">
                            <h4 class="text-lg font-semibold text-zinc-900">Entradas</h4>
                            <flux:button wire:click="openEntryModal()" icon="plus" variant="primary" size="sm"
                                class="flex items-center gap-1">
                                Nueva Entrada
                            </flux:button>
                        </div>
                        @if ($cajaActiva->entries->count() > 0)
                            <div class="divide-y divide-green-100 rounded-lg border border-green-100 bg-green-50">
                                @foreach ($cajaActiva->entries as $entry)
                                    <div class="flex justify-between items-center px-4 py-3">
                                        <div>
                                            <div class="font-medium text-zinc-900">{{ $entry->description }}</div>
                                            <div class="text-xs text-zinc-500">{{ $entry->tipoEntry?->name ?? '-' }} -
                                                {{ ucfirst($entry->metodo_pago) }}</div>
                                            <div class="text-xs text-zinc-400">
                                                {{ $entry->created_at->format('d/m/Y H:i') }}</div>
                                        </div>
                                        <div class="text-right">
                                            <div class="text-lg font-bold text-green-600">
                                                ${{ number_format($entry->monto_entry, 2) }}</div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8 text-zinc-400">
                                <x-flux::icon name="inbox" class="w-12 h-12 mx-auto mb-2 text-zinc-200" />
                                <p>No hay entradas registradas</p>
                            </div>
                        @endif
                    </div>
                    <!-- Salidas -->
                    <div>
                        <div class="flex justify-between items-center mb-4">
                            <h4 class="text-lg font-semibold text-zinc-900">Salidas</h4>
                            <flux:button wire:click="openExitModal()" icon="plus" variant="danger" size="sm"
                                class="flex items-center gap-1">
                                Nueva Salida
                            </flux:button>
                        </div>
                        @if ($cajaActiva->exits->count() > 0)
                            <div class="divide-y divide-red-100 rounded-lg border border-red-100 bg-red-50">
                                @foreach ($cajaActiva->exits as $exit)
                                    <div class="flex justify-between items-center px-4 py-3">
                                        <div>
                                            <div class="font-medium text-zinc-900">{{ $exit->description }}</div>
                                            <div class="text-xs text-zinc-500">{{ $exit->tipoExit?->name ?? '-' }} -
                                                {{ ucfirst($exit->metodo_pago) }}</div>
                                            <div class="text-xs text-zinc-400">
                                                {{ $exit->created_at->format('d/m/Y H:i') }}</div>
                                        </div>
                                        <div class="text-right">
                                            <div class="text-lg font-bold text-red-600">
                                                ${{ number_format($exit->monto_exit, 2) }}</div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8 text-zinc-400">
                                <x-flux::icon name="inbox" class="w-12 h-12 mx-auto mb-2 text-zinc-200" />
                                <p>No hay salidas registradas</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @else
            <div class="bg-white rounded-xl shadow-md border border-zinc-100 overflow-hidden">
                <div class="px-8 py-12 text-center">
                    <div class="mx-auto w-24 h-24 bg-zinc-100 rounded-full flex items-center justify-center mb-6">
                        <x-flux::icon name="banknotes" class="w-12 h-12 text-zinc-400" />
                    </div>
                    <h3 class="text-xl font-semibold text-zinc-900 mb-2">No tienes una caja activa</h3>
                    <p class="text-zinc-500 mb-6 max-w-md mx-auto">
                        Para comenzar a registrar movimientos de caja, primero debes abrir una caja.
                        Esto te permitirá controlar entradas, salidas y mantener un balance actualizado.
                    </p>
                </div>
            </div>
        @endif
    </div>

    <!-- Modal de Caja -->
    <flux:modal wire:model="showCajaModal">
        <div class="px-6 pt-6 pb-2 border-b">
            <h2 class="text-xl font-bold text-center text-zinc-900">
                {{ $editingCaja ? 'Cerrar Caja' : 'Abrir Caja' }}
            </h2>
        </div>
        <div class="p-8 space-y-6">
            @if (!$editingCaja)
                <flux:input wire:model="monto_apertura" label="Monto de Apertura" type="number" step="0.01"
                    min="0" placeholder="0.00" required />
            @else
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Balance Calculado
                            <span class="ml-1"
                                title="Este es el balance calculado automáticamente basado en apertura, entradas y salidas.">
                                <svg class="inline w-4 h-4 text-zinc-400" fill="none" stroke="currentColor"
                                    stroke-width="2" viewBox="0 0 24 24">
                                    <circle cx="12" cy="12" r="10" />
                                    <line x1="12" y1="16" x2="12" y2="12" />
                                    <line x1="12" y1="8" x2="12.01" y2="8" />
                                </svg>
                            </span>
                        </label>
                        <div class="bg-zinc-100 rounded px-4 py-2 text-lg font-bold text-zinc-800">
                            ${{ number_format($editingCaja ? $editingCaja->monto_apertura + $editingCaja->entries->sum('monto_entry') - $editingCaja->exits->sum('monto_exit') : 0, 2) }}
                        </div>
                        <p class="text-xs text-zinc-500 mt-1">Este es el balance calculado automáticamente. Se usará
                            como monto de cierre.</p>
                    </div>
                    <!-- El input de monto_cierre ha sido eliminado -->
                </div>
            @endif
        </div>
        <div class="px-6 pb-6 pt-2 border-t flex justify-end space-x-3">
            <flux:button wire:click="closeCajaModal" variant="outline">
                Cancelar
            </flux:button>
            <flux:button wire:click="saveCaja" variant="primary">
                {{ $editingCaja ? 'Cerrar Caja' : 'Abrir Caja' }}
            </flux:button>
        </div>
    </flux:modal>

    <!-- Modal de Entrada -->
    <flux:modal wire:model="showEntryModal">
        <div class="px-6 pt-6 pb-2 border-b">
            <h2 class="text-xl font-bold text-center text-zinc-900">
                {{ $editingEntry ? 'Editar Entrada' : 'Nueva Entrada' }}
            </h2>
        </div>
        <div class="p-8 space-y-6">
            <flux:input wire:model="monto_entry" label="Monto" type="number" step="0.01" min="0"
                placeholder="0.00" required />
            <flux:textarea wire:model="description_entry" label="Descripción" rows="3"
                placeholder="Descripción de la entrada" />
            <div class="grid grid-cols-2 gap-4">
                <flux:select wire:model="tipo_entry" label="Tipo de Entrada" required>
                    @foreach ($entry_types as $id => $name)
                        <option value="{{ $id }}">{{ ucfirst($name) }}</option>
                    @endforeach
                </flux:select>
                <flux:input wire:model="metodo_pago_entry" label="Método de Pago" as="select" required>
                    <option value="efectivo">Efectivo</option>
                    <option value="tarjeta">Tarjeta</option>
                    <option value="transferencia">Transferencia</option>
                </flux:input>
            </div>
        </div>
        <div class="px-6 pb-6 pt-2 border-t flex justify-end space-x-3">
            <flux:button wire:click="closeEntryModal" variant="outline">
                Cancelar
            </flux:button>
            <flux:button wire:click="saveEntry" variant="primary">
                {{ $editingEntry ? 'Actualizar' : 'Crear' }}
            </flux:button>
        </div>
    </flux:modal>

    <!-- Modal de Salida -->
    <flux:modal wire:model="showExitModal">
        <div class="px-6 pt-6 pb-2 border-b">
            <h2 class="text-xl font-bold text-center text-zinc-900">
                {{ $editingExit ? 'Editar Salida' : 'Nueva Salida' }}
            </h2>
        </div>
        <div class="p-8 space-y-6">
            <flux:input wire:model="monto_exit" label="Monto" type="number" step="0.01" min="0"
                placeholder="0.00" required />
            <flux:textarea wire:model="description_exit" label="Descripción" rows="3"
                placeholder="Descripción de la salida" />
            <div class="grid grid-cols-2 gap-4">
                <flux:select wire:model="tipo_exit" label="Tipo de Salida" required>
                    @foreach ($exit_types as $id => $name)
                        <option value="{{ $id }}">{{ ucfirst($name) }}</option>
                    @endforeach
                </flux:select>
                <flux:input wire:model="metodo_pago_exit" label="Método de Pago" as="select" required>
                    <option value="efectivo">Efectivo</option>
                    <option value="tarjeta">Tarjeta</option>
                    <option value="transferencia">Transferencia</option>
                </flux:input>
            </div>
        </div>
        <div class="px-6 pb-6 pt-2 border-t flex justify-end space-x-3">
            <flux:button wire:click="closeExitModal" variant="outline">
                Cancelar
            </flux:button>
            <flux:button wire:click="saveExit" variant="danger">
                {{ $editingExit ? 'Actualizar' : 'Crear' }}
            </flux:button>
        </div>
    </flux:modal>

    <!-- Modal de Historial de Cajas -->
    <flux:modal variant="flyout" wire:model="showHistorialModal">
        <div class="px-6 pt-6 pb-2 border-b">
            <h2 class="text-xl font-bold text-center text-zinc-900">
                Historial de Cajas
            </h2>
        </div>
        <div class="p-8 overflow-x-auto">
            <table class="min-w-full text-sm text-zinc-700">
                <thead>
                    <tr class="bg-zinc-100">
                        <th class="px-4 py-2 text-left">#</th>
                        <th class="px-4 py-2 text-left">Apertura</th>
                        <th class="px-4 py-2 text-left">Cierre</th>
                        <th class="px-4 py-2 text-left">Monto Apertura</th>
                        <th class="px-4 py-2 text-left">Monto Cierre</th>
                        <th class="px-4 py-2 text-left">Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($historialCajas as $caja)
                        <tr class="border-b">
                            <td class="px-4 py-2">{{ $caja->id }}</td>
                            <td class="px-4 py-2">{{ $caja->created_at->format('d/m/Y H:i') }}</td>
                            <td class="px-4 py-2">
                                {{ $caja->monto_cierre ? $caja->updated_at->format('d/m/Y H:i') : '-' }}</td>
                            <td class="px-4 py-2">${{ number_format($caja->monto_apertura, 2) }}</td>
                            <td class="px-4 py-2">${{ number_format($caja->monto_cierre, 2) }}</td>
                            <td class="px-4 py-2">
                                <span
                                    class="px-2 py-1 rounded-full text-xs {{ $caja->isActive ? 'bg-green-100 text-green-700' : 'bg-zinc-200 text-zinc-600' }}">
                                    {{ $caja->isActive ? 'Activa' : 'Cerrada' }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @if ($historialCajas->isEmpty())
                <div class="text-center text-zinc-400 py-8">
                    <x-flux::icon name="inbox" class="w-12 h-12 mx-auto mb-2 text-zinc-200" />
                    <p>No hay historial de cajas.</p>
                </div>
            @endif
        </div>
        <div class="px-6 pb-6 pt-2 border-t flex justify-end space-x-3">
            <flux:button wire:click="showHistorialModal = false" variant="outline">
                Cerrar
            </flux:button>
        </div>
    </flux:modal>
</div>
