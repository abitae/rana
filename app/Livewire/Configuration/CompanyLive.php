<?php

namespace App\Livewire\Configuration;

use App\Models\Configuration\Company;
use App\Services\Configuration\CompanyService;
use Livewire\Component;

class CompanyLive extends Component
{

    protected CompanyService $companyService;

    public $showCompanyModal = false;
    public $showDeleteModal = false;
    public $editingCompany = null;
    public $companyToDelete = null;

    // Campos del formulario
    public $ruc = '';
    public $razonSocial = '';
    public $address = '';
    public $email = '';
    public $telephone = '';
    public $ubigeo = '';
    public $ctaBanco = '';
    public $pin = '';
    public $nroMtc = '';
    public $logo_path = '';
    public $sol_user = '';
    public $sol_pass = '';
    public $cert_path = '';
    public $client_id = '';
    public $client_secret = '';
    public $production = false;

    protected $rules = [
        'ruc' => 'required|string|max:20',
        'razonSocial' => 'required|string|max:255',
        'address' => 'required|string|max:255',
        'email' => 'nullable|email|max:255',
        'telephone' => 'nullable|string|max:20',
        'ubigeo' => 'nullable|string|max:20',
        'ctaBanco' => 'nullable|string|max:50',
        'pin' => 'nullable|string|max:20',
        'nroMtc' => 'nullable|string|max:20',
        'logo_path' => 'nullable|string|max:255',
        'sol_user' => 'nullable|string|max:50',
        'sol_pass' => 'nullable|string|max:50',
        'cert_path' => 'nullable|string|max:255',
        'client_id' => 'nullable|string|max:100',
        'client_secret' => 'nullable|string|max:100',
        'production' => 'boolean',
    ];

    public function boot(CompanyService $companyService): void
    {
        $this->companyService = $companyService;
    }

    public function render()
    {
        $company = $this->companyService->getCompanies()->first();
        return view('livewire.configuration.company-live', [
            'company' => $company,
        ]);
    }

    public function openCompanyModal($companyId = null): void
    {
        if ($companyId) {
            $this->editingCompany = Company::find($companyId);
            foreach ($this->editingCompany->getAttributes() as $key => $value) {
                if (property_exists($this, $key)) {
                    $this->$key = $value;
                }
            }
        } else {
            $this->resetCompanyForm();
        }
        $this->showCompanyModal = true;
    }

    public function saveCompany(): void
    {
        $data = $this->validate($this->rules);
        try {
            if ($this->editingCompany) {
                $this->companyService->actualizarCompany($this->editingCompany->id, $data);
            } else {
                $this->companyService->crearCompany($data);
            }
            $this->closeCompanyModal();
            session()->flash('message', 'Compañía guardada exitosamente.');
        } catch (\Exception $e) {
            session()->flash('message', $e->getMessage());
        }
    }

    public function closeCompanyModal(): void
    {
        $this->showCompanyModal = false;
        $this->resetCompanyForm();
        $this->editingCompany = null;
    }

    public function resetCompanyForm(): void
    {
        $this->reset([
            'ruc', 'razonSocial', 'address', 'email', 'telephone', 'ubigeo', 'ctaBanco', 'pin', 'nroMtc',
            'logo_path', 'sol_user', 'sol_pass', 'cert_path', 'client_id', 'client_secret', 'production'
        ]);
        $this->production = false;
    }

    public function confirmDelete($companyId): void
    {
        $this->companyToDelete = $companyId;
        $this->showDeleteModal = true;
    }

    public function cancelDelete(): void
    {
        $this->showDeleteModal = false;
        $this->companyToDelete = null;
    }

    public function deleteCompany(): void
    {
        try {
            $this->companyService->eliminarCompany($this->companyToDelete);
            $this->showDeleteModal = false;
            $this->companyToDelete = null;
            session()->flash('message', 'Compañía eliminada exitosamente.');
        } catch (\Exception $e) {
            session()->flash('message', $e->getMessage());
        }
    }


}
