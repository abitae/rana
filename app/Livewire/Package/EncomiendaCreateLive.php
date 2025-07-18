<?php

namespace App\Livewire\Package;

use App\Services\Package\EncomiendaService;
use App\Models\Package\Customer;
use App\Models\Configuration\Sucursal;
use App\Models\Configuration\Transportista;
use App\Models\Configuration\Vehiculo;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Rule;
use Illuminate\Support\Facades\Auth;
use App\Services\Shared\SearchService;
use App\Traits\SearchDocument;

class EncomiendaCreateLive extends Component
{
    use SearchDocument;
    // Tab inicial
    public $selectedTab = 'remitente';

    // datos remitente
    public $type_code_remitente = 'DNI';
    public $code_remitente;
    public $name_remitente;
    public $address_remitente;
    public $ubigeo_remitente;
    public $texto_ubigeo_remitente;
    public $phone_remitente;
    public $email_remitente;

    public $remitente_id;

    // datos destinatario
    public $type_code_destinatario;
    public $code_destinatario;
    public $name_destinatario;
    public $address_destinatario;
    public $ubigeo_destinatario;
    public $texto_ubigeo_destinatario;
    public $phone_destinatario;
    public $email_destinatario;

    public $destinatario_id;

    // datos paquetes
    public $paquetes = [];


    public function render()
    {
        return view('livewire.package.encomienda-create-live');
    }

    public function searchRemitente()
    {
        $this->validate([
            'type_code_remitente' => 'required|string|max:255',
            'code_remitente' => 'required|string|max:255',
        ]);
        $customer = Customer::where('type_code', $this->type_code_remitente)
            ->where('code', $this->code_remitente)
            ->first();
        if (!$customer) {
            $response = $this->searchComplete($this->type_code_remitente, $this->code_remitente);
            if ($response['encontrado']) {
                if ($this->type_code_remitente == 'DNI') {
                    $this->name_remitente = $response['data']->nombre ?? '';
                    $this->address_remitente  = $response['data']->direccion ?? '';
                    $this->ubigeo_remitente = $response['data']->codigo_ubigeo ?? '';
                    $this->texto_ubigeo_remitente = $response['texto_ubigeo'] ?? '';
                    $this->phone_remitente = $response['data']->telefono ?? '';
                    $this->email_remitente = $response['data']->email ?? '';
                } else {
                    $this->name_remitente = $response['data']->nombre_comercial ?? '';
                    $this->address_remitente  = $response['data']->direccion ?? '';
                    $this->ubigeo_remitente = $response['data']->codigo_ubigeo ?? '';
                    $this->texto_ubigeo_remitente = $response['texto_ubigeo'] ?? '';
                    $this->phone_remitente = $response['data']->telefono ?? '';
                    $this->email_remitente = $response['data']->email ?? '';
                }
            } else {
                $this->addError('code_remitente', 'No se encontró el cliente');
            }
        } else {
            $this->remitente_id = $customer->id;
            $this->name_remitente = $customer->name;
            $this->address_remitente = $customer->address;
            $this->texto_ubigeo_remitente = $customer->texto_ubigeo;
            $this->phone_remitente = $customer->phone;
            $this->email_remitente = $customer->email;
        }
    }

    // buscar destinatario
    public function searchDestinatario()
    {
        $this->validate([
            'type_code_destinatario' => 'required|string|max:255',
            'code_destinatario' => 'required|string|max:255',
        ]);
        $customer = Customer::where('type_code', $this->type_code_destinatario)
            ->where('code', $this->code_destinatario)
            ->first();
        if (!$customer) {

            $response = $this->searchComplete($this->type_code_destinatario, $this->code_destinatario);
            if ($response['encontrado']) {
                if ($this->type_code_destinatario == 'DNI') {
                    $this->name_destinatario = $response['data']->nombre ?? '';
                    $this->address_destinatario  = $response['data']->direccion ?? '';
                    $this->ubigeo_destinatario = $response['data']->codigo_ubigeo ?? '';
                    $this->texto_ubigeo_destinatario = $response['texto_ubigeo'] ?? '';
                    $this->phone_destinatario = $response['data']->telefono ?? '';
                    $this->email_destinatario = $response['data']->email ?? '';
                } else {
                    $this->name_destinatario = $response['data']->nombre_comercial ?? '';
                    $this->address_destinatario  = $response['data']->direccion ?? '';
                    $this->ubigeo_destinatario = $response['data']->codigo_ubigeo ?? '';
                    $this->texto_ubigeo_destinatario = $response['texto_ubigeo'] ?? '';
                    $this->phone_destinatario = $response['data']->telefono ?? '';
                    $this->email_destinatario = $response['data']->email ?? '';
                }
            } else {
                $this->addError('code_remitente', 'No se encontró el cliente');
            }
        } else {
            $this->name_destinatario = $customer->name;
            $this->address_destinatario = $customer->address;
            $this->texto_ubigeo_destinatario = $customer->texto_ubigeo;
            $this->phone_destinatario = $customer->phone;
            $this->email_destinatario = $customer->email;
        }
    }

    // validar campos de los tabs
    public function validateTabs()
    {
        if ($this->selectedTab == 'remitente') {

            if ($this->type_code_remitente == 'RUC' && strpos($this->code_remitente, '20') === 0) {
                $tipe_validate = 'required';
            } else {
                $tipe_validate = 'nullable';
            }
            $this->validate([
                'type_code_remitente' => 'required|string|max:255',
                'code_remitente' => 'required|string|max:255',
                'name_remitente' => 'required|string|max:255',
                'address_remitente' => $tipe_validate .'|string',
                'ubigeo_remitente' => $tipe_validate .'|string|max:255',
                'texto_ubigeo_remitente' => $tipe_validate .'|string|max:255',
                'phone_remitente' => 'nullable|string|max:255',
                'email_remitente' => 'nullable|string|email',
            ]);

            if (!$this->remitente_id) {
                $this->remitente_id = Customer::create([
                    'type_code' => $this->type_code_remitente,
                    'code' => $this->code_remitente,
                    'name' => $this->name_remitente,
                    'address' => $this->address_remitente ?? '',
                    'ubigeo' => $this->ubigeo_remitente ?? '',
                    'texto_ubigeo' => $this->texto_ubigeo_remitente ?? '',
                    'phone' => $this->phone_remitente ?? '',
                    'email' => $this->email_remitente ?? '',
                ]);
            }
        }
        if ($this->selectedTab == 'destinatario') {
            if ($this->type_code_destinatario == 'RUC' && strpos($this->code_destinatario, '20') === 0) {
                $tipe_validate = 'required';
            } else {
                $tipe_validate = 'nullable';
            }
            $this->validate([
                'type_code_destinatario' => 'required|string|max:255',
                'code_destinatario' => 'required|string|max:255',
                'name_destinatario' => 'required|string|max:255',
                'address_destinatario' => $tipe_validate .'|string',
                'ubigeo_destinatario' => $tipe_validate .'|string|max:255',
                'texto_ubigeo_destinatario' => $tipe_validate .'|string|max:255',
                'phone_destinatario' => 'nullable|string|max:255',
                'email_destinatario' => 'nullable|string|email',
            ]);
            if (!$this->destinatario_id) {
                $this->destinatario_id = Customer::create([
                    'type_code' => $this->type_code_destinatario,
                    'code' => $this->code_destinatario,
                    'name' => $this->name_destinatario,
                    'address' => $this->address_destinatario ?? '',
                    'ubigeo' => $this->ubigeo_destinatario ?? '',
                    'texto_ubigeo' => $this->texto_ubigeo_destinatario ?? '',
                    'phone' => $this->phone_destinatario ?? '',
                    'email' => $this->email_destinatario ?? '',
                ]);
            }
        }
    }
}
