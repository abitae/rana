<div class="p-8 w-full">
    <!-- Header -->
    <div class="bg-white rounded-xl shadow-md border border-zinc-100 overflow-hidden mb-8 p-4">
        <div class="px-8 py-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div class="flex-1">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="p-2 bg-blue-100 rounded-lg">
                            <flux:icon name="users" class="w-6 h-6 text-blue-600" />
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold text-zinc-900">Gestión de Clientes</h1>
                            <p class="text-zinc-500 text-sm">Administra los clientes de forma simple y eficiente</p>
                        </div>
                    </div>
                </div>
                <div class="flex gap-3">
                    <flux:button wire:click="openCustomerModal()" icon="plus" variant="primary" class="flex items-center gap-2">
                        Nuevo Cliente
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

    <!-- Lista de Clientes -->
    <div class="space-y-8">
        <div class="bg-white rounded-xl shadow-md border border-zinc-100 overflow-hidden">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 px-6 py-4 border-b bg-zinc-50">
                <div>
                    <h3 class="text-xl font-semibold text-zinc-900">
                        Clientes Registrados
                        <span class="ml-2 px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-700">
                            {{ $customers->total() }} total
                        </span>
                    </h3>
                    <p class="text-sm text-zinc-500">
                        Mostrando {{ $customers->count() }} de {{ $customers->total() }} clientes
                    </p>
                </div>
                <div class="flex gap-2">
                    <flux:input type="search" wire:model.live="search" placeholder="Buscar cliente..." class="w-64" />
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
                    <div class="text-lg font-bold text-zinc-900">{{ $customers->total() }}</div>
                </div>
                <div>
                    <div class="text-xs text-zinc-500">Activos</div>
                    <div class="text-lg font-bold text-green-600">{{ $customers->where('isActive', true)->count() }}</div>
                </div>
                <div>
                    <div class="text-xs text-zinc-500">Inactivos</div>
                    <div class="text-lg font-bold text-red-600">{{ $customers->where('isActive', false)->count() }}</div>
                </div>
                <div>
                    <div class="text-xs text-zinc-500">Tipos</div>
                    <div class="text-lg font-bold text-purple-600">{{ $customers->unique('type_code')->count() }}</div>
                </div>
            </div>

            <!-- Tabla de Clientes -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-zinc-200">
                    <thead class="bg-zinc-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wider">Cliente</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wider">Contacto</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wider">Dirección</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wider">Estado</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-zinc-500 uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-zinc-100">
                        @forelse ($customers as $customer)
                            <tr class="hover:bg-zinc-50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                                <flux:icon name="users" class="w-5 h-5 text-blue-600" />
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-zinc-900">{{ $customer->name }}</div>
                                            <div class="text-sm text-zinc-500">Código: {{ $customer->code }}</div>
                                            @if($customer->type_code)
                                                <div class="text-xs text-zinc-400">Tipo: {{ $customer->type_code }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @if($customer->phone || $customer->email)
                                        <div class="text-sm text-zinc-900">
                                            @if($customer->phone)
                                                <div class="flex items-center gap-1">
                                                    <flux:icon name="phone" class="w-3 h-3 text-zinc-400" />
                                                    {{ $customer->phone }}
                                                </div>
                                            @endif
                                            @if($customer->email)
                                                <div class="flex items-center gap-1">
                                                    <flux:icon name="envelope" class="w-3 h-3 text-zinc-400" />
                                                    {{ $customer->email }}
                                                </div>
                                            @endif
                                        </div>
                                    @else
                                        <span class="text-sm text-zinc-400">Sin contacto</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if($customer->address)
                                        <div class="text-sm text-zinc-900">{{ $customer->address }}</div>
                                        @if($customer->ubigeo)
                                            <div class="text-sm text-zinc-500">UBIGEO: {{ $customer->ubigeo }}</div>
                                        @endif
                                    @else
                                        <span class="text-sm text-zinc-400">Sin dirección</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($customer->isActive)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <flux:icon name="check-circle" class="w-3 h-3 mr-1" />
                                            Activo
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            <flux:icon name="x-circle" class="w-3 h-3 mr-1" />
                                            Inactivo
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center justify-end gap-2">
                                        <flux:button
                                            wire:click="openCustomerModal({{ $customer->id }})"
                                            icon="pencil"
                                            size="sm"
                                            variant="outline"
                                        >
                                            Editar
                                        </flux:button>
                                        <flux:button
                                            wire:click="confirmDelete({{ $customer->id }})"
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
                                        <div class="w-16 h-16 bg-zinc-100 rounded-full flex items-center justify-center mb-4">
                                            <flux:icon name="users" class="w-8 h-8 text-zinc-400" />
                                        </div>
                                        <h3 class="text-lg font-medium text-zinc-900 mb-2">No hay clientes</h3>
                                        <p class="text-zinc-500 mb-4">Comienza registrando tu primer cliente</p>
                                        <flux:button wire:click="openCustomerModal()" icon="plus" variant="primary">
                                            Nuevo Cliente
                                        </flux:button>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($customers->hasPages())
                <div class="px-6 py-4 border-t border-zinc-100 bg-zinc-50">
                    <div class="flex items-center justify-between">
                        <div class="text-sm text-zinc-500">
                            Mostrando {{ $customers->firstItem() ?? 0 }} a {{ $customers->lastItem() ?? 0 }} de {{ $customers->total() }} resultados
                        </div>
                        <div>
                            {{ $customers->links() }}
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Modal de Cliente -->
    <flux:modal wire:model="showCustomerModal" variant="flyout" max-width="3xl">
        <div class="px-6 pt-6 pb-2 border-b bg-gradient-to-r from-blue-50 to-indigo-50">
            <div class="flex items-center justify-center gap-3 mb-2">
                <div class="p-2 bg-blue-100 rounded-lg">
                    <flux:icon name="users" class="w-6 h-6 text-blue-600" />
                </div>
                <h2 class="text-xl font-bold text-zinc-900">
                    {{ $editingCustomer ? 'Editar Cliente' : 'Nuevo Cliente' }}
                </h2>
            </div>
        </div>
        <div class="p-8 max-h-[80vh] overflow-y-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <flux:input wire:model.defer="name" label="Nombre Completo" required size="sm" />
                <flux:input wire:model.defer="code" label="Código Único" required size="sm" />
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <flux:input wire:model.defer="type_code" label="Código de Tipo" size="sm" />
                <flux:input wire:model.defer="phone" label="Teléfono" type="tel" size="sm" />
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <flux:input wire:model.defer="email" label="Correo Electrónico" type="email" size="sm" />
                <flux:input wire:model.defer="ubigeo" label="Código UBIGEO" size="sm" />
            </div>
            <div class="mb-4">
                <flux:input wire:model.defer="address" label="Dirección Completa" size="sm" />
            </div>
            <div class="flex items-center gap-2 mt-4">
                <flux:checkbox wire:model.defer="isActive" label="Cliente activo" />
            </div>
        </div>
        <div class="px-6 pb-6 pt-2 border-t bg-gray-50 flex justify-end gap-3">
            <flux:button wire:click="closeCustomerModal" variant="outline" size="sm">
                Cancelar
            </flux:button>
            <flux:button wire:click="saveCustomer" variant="primary" size="sm" icon="check">
                {{ $editingCustomer ? 'Actualizar' : 'Crear' }}
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
                Esta acción no se puede deshacer. El cliente será eliminado permanentemente.
            </p>
        </div>
        <div class="px-6 pb-6 pt-2 border-t flex justify-end space-x-3">
            <flux:button wire:click="cancelDelete" variant="outline">
                Cancelar
            </flux:button>
            <flux:button wire:click="deleteCustomer" variant="danger">
                Eliminar Definitivamente
            </flux:button>
        </div>
    </flux:modal>
</div>
