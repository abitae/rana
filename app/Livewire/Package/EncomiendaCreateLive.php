<?php

namespace App\Livewire\Package;

use App\Models\Package\Customer;
use App\Models\Configuration\Sucursal;
use Livewire\Component;
use App\Traits\SearchDocument;
use Illuminate\Support\Facades\Auth;

class EncomiendaCreateLive extends Component
{
    use SearchDocument;
    // Tab inicial
    public $selectedTab = 'remitente';
    public $modalConfirmacionEncomienda = false;
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
    public $type_code_destinatario = 'DNI';
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

    public $paquete_descripcion;
    public $paquete_peso = 1;
    public $paquete_valor = 0;
    public $paquete_cantidad = 1;
    public $paquete_unidad = 'UNIDAD';

    // datos envio
    public $sucursal_destino_id;
    public $isHome = false;
    public $isReturn = false;
    public $direccion_envio;
    public $pin_seguridad;
    public $pin_seguridad_confirm;
    public $observaciones;
    public $isDocumentosTraslado = false;
    public $documentos_traslado = [];

    // Documentos de traslado
    public $documento_tipo;
    public $documento_numero;
    public $documento_ruc_emisor;

    // sucursales
    public $sucursales;

    // facturacion
    public $tipo_comprobante = 'TICKET';
    public $tipo_pago = 'CONTADO';
    public $metodo_pago = 'EFECTIVO';
    public $estado_pago = 'ENVIO PAGADO';

    // datos de facturacion
    public $type_code_facturacion = 'DNI';
    public $code_facturacion;
    public $facturacion_id;
    public $name_facturacion;
    public $address_facturacion;
    public $ubigeo_facturacion;
    public $texto_ubigeo_facturacion;
    public $phone_facturacion;
    public $email_facturacion;

    public function boot()
    {
        // Mostrar las sucursales que no sean la del usuario logueado
        $this->sucursales = Sucursal::where('id', '!=', Auth::user()->sucursal->id)->get();
        $this->sucursal_destino_id = $this->sucursales->first()->id;
    }
    public function render()
    {
        return view('livewire.package.encomienda-create-live');
    }

    // buscar remitente
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
            $this->ubigeo_remitente = $customer->ubigeo;
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
            $this->destinatario_id = $customer->id;
            $this->name_destinatario = $customer->name;
            $this->address_destinatario = $customer->address;
            $this->ubigeo_destinatario = $customer->ubigeo;
            $this->texto_ubigeo_destinatario = $customer->texto_ubigeo;
            $this->phone_destinatario = $customer->phone;
            $this->email_destinatario = $customer->email;
        }
    }
    // buscar facturacion
    public function searchFacturacion()
    {
        $this->validate([
            'type_code_facturacion' => 'required|string|max:255',
            'code_facturacion' => 'required|string|max:255',
        ]);
        $customer = Customer::where('type_code', $this->type_code_facturacion)
            ->where('code', $this->code_facturacion)
            ->first();
        if (!$customer) {

            $response = $this->searchComplete($this->type_code_facturacion, $this->code_facturacion);
            if ($response['encontrado']) {
                if ($this->type_code_facturacion == 'DNI') {
                    $this->name_facturacion = $response['data']->nombre ?? '';
                    $this->address_facturacion  = $response['data']->direccion ?? '';
                    $this->ubigeo_facturacion = $response['data']->codigo_ubigeo ?? '';
                    $this->texto_ubigeo_facturacion = $response['texto_ubigeo'] ?? '';
                    $this->phone_facturacion = $response['data']->telefono ?? '';
                    $this->email_facturacion = $response['data']->email ?? '';
                } else {
                    $this->name_facturacion = $response['data']->nombre_comercial ?? '';
                    $this->address_facturacion  = $response['data']->direccion ?? '';
                    $this->ubigeo_facturacion = $response['data']->codigo_ubigeo ?? '';
                    $this->texto_ubigeo_facturacion = $response['texto_ubigeo'] ?? '';
                    $this->phone_facturacion = $response['data']->telefono ?? '';
                    $this->email_facturacion = $response['data']->email ?? '';
                }
            } else {
                $this->addError('code_remitente', 'No se encontró el cliente');
            }
        } else {
            $this->facturacion_id = $customer->id;
            $this->name_facturacion = $customer->name;
            $this->address_facturacion = $customer->address;
            $this->ubigeo_facturacion = $customer->ubigeo;
            $this->texto_ubigeo_facturacion = $customer->texto_ubigeo;
            $this->phone_facturacion = $customer->phone;
            $this->email_facturacion = $customer->email;
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
                'address_remitente' => $tipe_validate . '|string',
                'ubigeo_remitente' => $tipe_validate . '|string|max:255',
                'texto_ubigeo_remitente' => $tipe_validate . '|string|max:255',
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
            $this->selectedTab = 'destinatario';
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
                'address_destinatario' => $tipe_validate . '|string',
                'ubigeo_destinatario' => $tipe_validate . '|string|max:255',
                'texto_ubigeo_destinatario' => $tipe_validate . '|string|max:255',
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
            $this->selectedTab = 'paquetes';
        }
        if ($this->selectedTab == 'paquetes') {
            $this->validate([
                'paquetes' => 'required|array',
            ]);
            //la direccion de envio es la del destinatario
            $this->direccion_envio = $this->address_destinatario;
            $this->selectedTab = 'envio';
        }
        if ($this->selectedTab == 'envio') {

            // Mejorar la validación: si isHome es true, el pin no será requerido
            if ($this->isHome) {
                $validate_home = 'required';
                $validate_pin = 'nullable|string|max:3';
                $validate_pin_confirm = 'nullable|string|max:3';
            } else {
                $validate_home = 'nullable';
                $validate_pin = 'required|string|max:3|same:pin_seguridad_confirm';
                $validate_pin_confirm = 'required|string|max:3';
            }

            $this->validate([
                'sucursal_destino_id' => 'required|integer',
                'pin_seguridad' => $validate_pin,
                'pin_seguridad_confirm' => $validate_pin_confirm,
                'observaciones' => 'nullable|string|max:255',
                'direccion_envio' => $validate_home . '|string|max:255',
            ]);
            $this->selectedTab = 'facturacion';
        }
        if ($this->selectedTab == 'facturacion') {

            if ($this->estado_pago == 'CONTRA ENTREGA') {
                $this->tipo_comprobante = 'TICKET';
                $this->tipo_pago = 'CREDITO';
                $this->metodo_pago = 'OTRO';
                $this->facturacion_id = $this->destinatario_id;
            } else {
                if ($this->tipo_pago == 'CREDITO') {
                    $this->metodo_pago = 'OTRO';
                }
            }

            $this->validate([
                'facturacion_id' => 'required|integer',
                'tipo_comprobante' => 'required|string|max:255', // TICKET, FACTURA, BOLETA
                'tipo_pago' => 'required|string|max:255', // CONTADO, CREDITO
                'metodo_pago' => 'required|string|max:255', // EFECTIVO, YAPE, TARJETA, CHEQUE, TRANSFERENCIA, OTRO
                'estado_pago' => 'required|string|max:255', // ENVIO PAGADO, CONTRA ENTREGA
            ]);

            $this->modalConfirmacionEncomienda = true;
        }
    }

    public function updatedIsReturn($value)
    {
        if ($value) {
            $this->isHome = true;
        }
    }
    // Agregar un paquete al array en memoria
    public function addPaquete()
    {
        $this->validate([
            'paquete_descripcion' => 'required|string|max:255',
            'paquete_peso' => 'required|numeric|min:0',
            'paquete_valor' => 'required|numeric|min:0',
            'paquete_cantidad' => 'required|integer|min:1',
            'paquete_unidad' => 'required|string|max:255',
        ]);

        $this->paquetes[] = [
            'descripcion' => $this->paquete_descripcion,
            'peso' => $this->paquete_peso,
            'valor' => $this->paquete_valor,
            'cantidad' => $this->paquete_cantidad,
            'unidad' => $this->paquete_unidad,
        ];

        // Limpiar los campos del formulario de paquete
        $this->paquete_descripcion = null;
        $this->paquete_peso = 1;
        $this->paquete_valor = 0;
        $this->paquete_cantidad = 1;
        $this->paquete_unidad = 'UNIDAD';
    }

    // Eliminar un paquete del array en memoria
    public function removePaquete($index)
    {
        if (isset($this->paquetes[$index])) {
            unset($this->paquetes[$index]);
            $this->paquetes = array_values($this->paquetes); // Reindexar el array
        }
    }

    // Agregar un documento de traslado al array en memoria
    public function addDocumentoTraslado()
    {
        $this->validate([
            'documento_tipo' => 'required|string|max:50',
            'documento_numero' => 'required|string|max:50',
            'documento_ruc_emisor' => 'required|string|max:11',
        ]);

        $this->documentos_traslado[] = [
            'tipo' => $this->documento_tipo,
            'numero' => $this->documento_numero,
            'ruc_emisor' => $this->documento_ruc_emisor,
        ];

        // Limpiar los campos del formulario de documento
        $this->documento_tipo = null;
        $this->documento_numero = null;
        $this->documento_ruc_emisor = null;
    }

    // Eliminar un documento de traslado del array en memoria
    public function removeDocumentoTraslado($index)
    {
        if (isset($this->documentos_traslado[$index])) {
            unset($this->documentos_traslado[$index]);
            $this->documentos_traslado = array_values($this->documentos_traslado); // Reindexar el array
        }
    }
    public function leftTabs()
    {
        switch ($this->selectedTab) {
            case 'remitente':
                break;
            case 'destinatario':
                $this->selectedTab = 'remitente';
                break;
            case 'paquetes':
                $this->selectedTab = 'destinatario';
                break;
            case 'envio':
                $this->selectedTab = 'paquetes';
                break;
            case 'facturacion':
                $this->selectedTab = 'envio';
                break;
        }
    }
}
