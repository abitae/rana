<?php

namespace App\Livewire\Package;

use App\Models\Package\Customer;
use App\Services\Package\CustomerService;
use Livewire\Component;
use Livewire\WithPagination;

class CustomerLive extends Component
{
    use WithPagination;

    protected CustomerService $customerService;

    public $showCustomerModal = false;
    public $showDeleteModal = false;
    public $editingCustomer = null;
    public $customerToDelete = null;
    public $search = '';
    public $filterStatus = '';

    // Campos del formulario
    public $type_code = '';
    public $code = '';
    public $name = '';
    public $phone = '';
    public $email = '';
    public $address = '';
    public $ubigeo = '';
    public $isActive = true;

    protected $rules = [
        'type_code' => 'nullable|string|max:20',
        'code' => 'required|string|max:255|unique:customers,code',
        'name' => 'required|string|max:255',
        'phone' => 'nullable|string|max:20',
        'email' => 'nullable|email|max:255',
        'address' => 'nullable|string|max:255',
        'ubigeo' => 'nullable|string|max:20',
        'isActive' => 'boolean',
    ];

    protected $messages = [
        'name.required' => 'El nombre es obligatorio.',
        'code.required' => 'El código es obligatorio.',
        'code.unique' => 'El código ya existe.',
        'email.email' => 'El correo electrónico no es válido.',
    ];

    public function boot(CustomerService $customerService): void
    {
        $this->customerService = $customerService;
    }

    public function render()
    {
        $customers = $this->customerService->getCustomers($this->search, $this->filterStatus);
        return view('livewire.package.customer-live', [
            'customers' => $customers,
        ]);
    }

    public function openCustomerModal($customerId = null): void
    {
        if ($customerId) {
            $this->editingCustomer = Customer::find($customerId);
            foreach ($this->editingCustomer->getAttributes() as $key => $value) {
                if (property_exists($this, $key)) {
                    $this->$key = $value;
                }
            }
        } else {
            $this->resetCustomerForm();
        }
        $this->showCustomerModal = true;
    }

    public function saveCustomer(): void
    {
        // Si está editando, quitar la validación unique del code
        if ($this->editingCustomer) {
            $this->rules['code'] = 'required|string|max:255';
        }
        $data = $this->validate($this->rules, $this->messages);

        try {
            if ($this->editingCustomer) {
                $this->customerService->actualizarCustomer($this->editingCustomer->id, $data);
            } else {
                $this->customerService->crearCustomer($data);
            }
            $this->closeCustomerModal();
            session()->flash('message', 'Cliente guardado exitosamente.');
        } catch (\Exception $e) {
            session()->flash('message', $e->getMessage());
        }
    }

    public function closeCustomerModal(): void
    {
        $this->showCustomerModal = false;
        $this->resetCustomerForm();
        $this->editingCustomer = null;
        $this->resetValidation();
    }

    public function resetCustomerForm(): void
    {
        $this->reset([
            'type_code', 'code', 'name', 'phone', 'email', 'address', 'ubigeo', 'isActive'
        ]);
        $this->isActive = true;
    }

    public function confirmDelete($customerId): void
    {
        $this->customerToDelete = $customerId;
        $this->showDeleteModal = true;
    }

    public function cancelDelete(): void
    {
        $this->showDeleteModal = false;
        $this->customerToDelete = null;
    }

    public function deleteCustomer(): void
    {
        try {
            $this->customerService->eliminarCustomer($this->customerToDelete);
            $this->showDeleteModal = false;
            $this->customerToDelete = null;
            session()->flash('message', 'Cliente eliminado exitosamente.');
        } catch (\Exception $e) {
            session()->flash('message', $e->getMessage());
        }
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedFilterStatus(): void
    {
        $this->resetPage();
    }
}
