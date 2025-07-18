<div class="p-8 w-full">
    <!-- Header -->
    <div class="bg-white rounded-xl shadow-md border border-zinc-100 overflow-hidden mb-8 p-4">
        <div class="px-8 py-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div class="flex-1">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="p-2 bg-blue-100 rounded-lg">
                            <flux:icon name="layout-grid" class="w-6 h-6 text-blue-600" />
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold text-zinc-900">Gestión de Vehículos</h1>
                            <p class="text-zinc-500 text-sm">Administra los vehículos de forma simple y eficiente</p>
                        </div>
                    </div>
                </div>
                <div class="flex gap-3">
                    <flux:button wire:click="openVehiculoModal()" icon="plus" variant="primary" class="flex items-center gap-2">
                        Nuevo Vehículo
                    </flux:button>
                </div>
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

    <!-- Lista de Vehículos -->
    <div class="space-y-8">
        <div class="bg-white rounded-xl shadow-md border border-zinc-100 overflow-hidden">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 px-6 py-4 border-b bg-zinc-50">
                <div>
                    <h3 class="text-xl font-semibold text-zinc-900">
                        Vehículos Registrados
                        <span class="ml-2 px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-700">
                            {{ $vehiculos->total() }} total
                        </span>
                    </h3>
                    <p class="text-sm text-zinc-500">
                        Mostrando {{ $vehiculos->count() }} de {{ $vehiculos->total() }} vehículos
                    </p>
                </div>
                                    <div class="flex gap-2">
                        <flux:input type="search" wire:model.live="search" placeholder="Buscar vehículo..." class="w-64" />
                        <flux:select wire:model.live="filterStatus" class="w-48">
                            <option value="">Todos</option>
                            <option value="1">Solo activos</option>
                            <option value="0">Solo inactivos</option>
                        </flux:select>
                    </div>
            </div>

            <!-- Estadísticas -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 px-6 py-4 bg-blue-50 text-center">
                <div>
                    <div class="text-xs text-zinc-500">Total</div>
                    <div class="text-lg font-bold text-zinc-900">{{ $vehiculos->total() }}</div>
                </div>
                <div>
                    <div class="text-xs text-zinc-500">Activos</div>
                    <div class="text-lg font-bold text-green-600">{{ $vehiculos->where('isActive', true)->count() }}</div>
                </div>
                <div>
                    <div class="text-xs text-zinc-500">Inactivos</div>
                    <div class="text-lg font-bold text-red-600">{{ $vehiculos->where('isActive', false)->count() }}</div>
                </div>
                <div>
                    <div class="text-xs text-zinc-500">Marcas</div>
                    <div class="text-lg font-bold text-purple-600">{{ $vehiculos->unique('marca')->count() }}</div>
                </div>
            </div>

            <!-- Tabla de Vehículos -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-zinc-200">
                    <thead class="bg-zinc-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wider">Vehículo</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wider">Identificación</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wider">Características</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wider">Estado</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-zinc-500 uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-zinc-100">
                        @forelse ($vehiculos as $vehiculo)
                            <tr class="hover:bg-zinc-50 transition-colors">
                                <td class="px-6 py-4">
                                    <div>
                                        <div class="text-sm font-medium text-zinc-900">{{ $vehiculo->name }}</div>
                                        <div class="text-sm text-zinc-500">Tipo: {{ $vehiculo->tipo }}</div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="space-y-2">
                                        <div class="flex items-center gap-2">
                                            <flux:icon name="identification" class="w-4 h-4 text-indigo-500" />
                                            <span class="text-sm font-medium text-zinc-900">Placa:</span>
                                            <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-indigo-100 text-indigo-800">
                                                {{ $vehiculo->placa ?? 'Sin placa' }}
                                            </span>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <flux:icon name="building-office" class="w-4 h-4 text-green-500" />
                                            <span class="text-sm font-medium text-zinc-900">Marca:</span>
                                            <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-green-100 text-green-800">
                                                {{ $vehiculo->marca }}
                                            </span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="space-y-2">
                                        <div class="flex items-center gap-2">
                                            <flux:icon name="document-text" class="w-4 h-4 text-purple-500" />
                                            <span class="text-sm font-medium text-zinc-900">Modelo:</span>
                                            <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-purple-100 text-purple-800">
                                                {{ $vehiculo->modelo }}
                                            </span>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <flux:icon name="paint-brush" class="w-4 h-4 text-orange-500" />
                                            <span class="text-sm font-medium text-zinc-900">Color:</span>
                                            <span class="inline-flex items-center gap-2">
                                                <span class="inline-block w-4 h-4 rounded-full border border-zinc-200" style="background: {{ $vehiculo->color ?? '#3B82F6' }}"></span>
                                                <span class="text-xs text-zinc-700">{{ $vehiculo->color ?? '-' }}</span>
                                            </span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($vehiculo->isActive)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <flux:icon name="check-circle" class="w-3 h-3 mr-1" />
                                            Activo
                                        </span>
                                    @else
                                        <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            <flux:icon name="x-circle" class="w-3 h-3 mr-1" />
                                            Inactivo
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center justify-end gap-2">
                                        <flux:button
                                            wire:click="openVehiculoModal({{ $vehiculo->id }})"
                                            icon="pencil"
                                            size="sm"
                                            variant="outline"
                                        >
                                            Editar
                                        </flux:button>
                                        <flux:button
                                            wire:click="confirmDelete({{ $vehiculo->id }})"
                                            icon="trash"
                                            size="sm"
                                            variant="danger"
                                        >
                                            Eliminar
                                        </flux:button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-zinc-400">
                                    <div class="flex flex-col items-center">
                                        <h3 class="text-lg font-medium text-zinc-900 mb-2">No hay vehículos</h3>
                                        <flux:button wire:click="openVehiculoModal()" icon="plus" variant="primary">
                                            Nuevo Vehículo
                                        </flux:button>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($vehiculos->hasPages())
                <div class="px-6 py-4 border-t border-zinc-100 bg-zinc-50">
                    <div class="flex items-center justify-between">
                        <div class="text-sm text-zinc-500">
                            Mostrando {{ $vehiculos->firstItem() ?? 0 }} a {{ $vehiculos->lastItem() ?? 0 }} de {{ $vehiculos->total() }} resultados
                        </div>
                        <div>
                            {{ $vehiculos->links() }}
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Modal de Vehículo -->
    <flux:modal wire:model="showVehiculoModal" variant="flyout" max-width="3xl">
        <div class="px-6 pt-6 pb-2 border-b bg-gradient-to-r from-blue-50 to-indigo-50">
            <div class="flex items-center justify-center gap-3 mb-2">
                <div class="p-2 bg-blue-100 rounded-lg">
                    <flux:icon name="layout-grid" class="w-6 h-6 text-blue-600" />
                </div>
                <h2 class="text-xl font-bold text-zinc-900">
                    {{ $editingVehiculo ? 'Editar Vehículo' : 'Nuevo Vehículo' }}
                </h2>
            </div>
        </div>
        <div class="p-8 max-h-[80vh] overflow-y-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <flux:input wire:model.defer="name" label="Nombre del Vehículo" required size="sm" />
                <flux:input wire:model.defer="placa" label="Placa" required size="sm" />
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <flux:input wire:model.defer="marca" label="Marca" required size="sm" />
                <flux:input wire:model.defer="modelo" label="Modelo" required size="sm" />
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <flux:select wire:model.defer="tipo" label="Tipo de Vehículo" required size="sm">
                    <option value="">Seleccionar tipo</option>
                    <option value="INTERNO">Interno</option>
                    <option value="EXTERNO">Externo</option>
                </flux:select>
                <flux:input wire:model.defer="color" label="Color" type="color" size="sm" />
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div class="flex items-center gap-2 mt-2">
                    <flux:checkbox wire:model.defer="isActive" label="Activo" />
                </div>
            </div>
        </div>
        <div class="px-6 pb-6 pt-2 border-t bg-gray-50 flex justify-end gap-3">
            <flux:button wire:click="closeVehiculoModal" variant="outline" size="sm">
                Cancelar
            </flux:button>
            <flux:button wire:click="saveVehiculo" variant="primary" size="sm" icon="check">
                {{ $editingVehiculo ? 'Actualizar' : 'Crear' }}
            </flux:button>
        </div>
    </flux:modal>

    <!-- Modal de Confirmación de Eliminación -->
    <flux:modal wire:model="showDeleteModal">
        <div class="px-6 pt-6 pb-2 border-b">
            <h2 class="text-xl font-bold text-center text-zinc-900">
                Confirmar Eliminación
            </h2>
        </div>
        <div class="p-8 text-center">
            <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <flux:icon name="exclamation-triangle" class="w-8 h-8 text-red-600" />
            </div>
            <h3 class="text-lg font-medium text-zinc-900 mb-2">¿Estás seguro?</h3>
            <p class="text-zinc-500 mb-6">
                Esta acción no se puede deshacer. El vehículo será eliminado permanentemente.
            </p>
        </div>
        <div class="px-6 pb-6 pt-2 border-t flex justify-end space-x-3">
            <flux:button wire:click="cancelDelete" variant="outline">
                Cancelar
            </flux:button>
            <flux:button wire:click="deleteVehiculo" variant="danger">
                Eliminar Definitivamente
            </flux:button>
        </div>
    </flux:modal>
</div>
