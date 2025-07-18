<?php

namespace App\Services\Package;

use App\Models\Package\Encomienda;
use App\Models\Package\Customer;
use App\Models\Package\Paquete;
use App\Models\Configuration\Sucursal;
use App\Models\Configuration\Transportista;
use App\Models\Configuration\Vehiculo;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class EncomiendaService
{
    public function getAll($search = '', $filters = [])
    {
        $query = Encomienda::with([
            'user',
            'transportista',
            'vehiculo',
            'remitente',
            'sucursal_remitente',
            'destinatario',
            'sucursal_destinatario',
            'facturacion',
            'paquetes'
        ]);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('code', 'like', "%{$search}%")
                  ->orWhereHas('remitente', function ($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%")
                        ->orWhere('code', 'like', "%{$search}%");
                  })
                  ->orWhereHas('destinatario', function ($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%")
                        ->orWhere('code', 'like', "%{$search}%");
                  });
            });
        }

        // Aplicar filtros
        if (isset($filters['estado_encomienda'])) {
            $query->where('estado_encomienda', $filters['estado_encomienda']);
        }

        if (isset($filters['estado_pago'])) {
            $query->where('estado_pago', $filters['estado_pago']);
        }

        if (isset($filters['sucursal_id'])) {
            $query->where('sucursal_id', $filters['sucursal_id']);
        }

        if (isset($filters['transportista_id'])) {
            $query->where('transportista_id', $filters['transportista_id']);
        }

        return $query->orderBy('created_at', 'desc')->paginate(10);
    }

    public function getById($id)
    {
        return Encomienda::with([
            'user',
            'transportista',
            'vehiculo',
            'remitente',
            'sucursal_remitente',
            'destinatario',
            'sucursal_destinatario',
            'facturacion',
            'paquetes'
        ])->findOrFail($id);
    }

    public function create($data)
    {
        DB::beginTransaction();
        try {
            // Generar código único
            $data['code'] = $this->generateUniqueCode();

            // Usuario actual
            $data['user_id'] = Auth::id();

            // Fecha de creación
            $data['fecha_creacion'] = now();

            // Estado inicial
            $data['estado_encomienda'] = 'REGISTRADO';

            // PIN de seguridad
            $data['pin'] = rand(100, 999);

            // Crear encomienda
            $encomienda = Encomienda::create($data);

            // Crear paquetes si se proporcionan
            if (isset($data['paquetes']) && is_array($data['paquetes'])) {
                foreach ($data['paquetes'] as $paqueteData) {
                    $paqueteData['encomienda_id'] = $encomienda->id;
                    Paquete::create($paqueteData);
                }
            }

            DB::commit();
            return $encomienda;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function update($id, $data)
    {
        DB::beginTransaction();
        try {
            $encomienda = Encomienda::findOrFail($id);
            $encomienda->update($data);

            // Actualizar paquetes si se proporcionan
            if (isset($data['paquetes']) && is_array($data['paquetes'])) {
                // Eliminar paquetes existentes
                $encomienda->paquetes()->delete();

                // Crear nuevos paquetes
                foreach ($data['paquetes'] as $paqueteData) {
                    $paqueteData['encomienda_id'] = $encomienda->id;
                    Paquete::create($paqueteData);
                }
            }

            DB::commit();
            return $encomienda;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function delete($id)
    {
        $encomienda = Encomienda::findOrFail($id);

        // Verificar si se puede eliminar
        if ($encomienda->estado_encomienda !== 'REGISTRADO') {
            throw new \Exception('No se puede eliminar una encomienda que ya ha sido procesada.');
        }

        return $encomienda->delete();
    }

    public function updateEstado($id, $estado)
    {
        $encomienda = Encomienda::findOrFail($id);

        $encomienda->estado_encomienda = $estado;

        // Actualizar fecha según el estado
        switch ($estado) {
            case 'ENVIADO':
                $encomienda->fecha_envio = now();
                break;
            case 'RECIBIDO':
                $encomienda->fecha_recepcion = now();
                break;
            case 'ENTREGADO':
                $encomienda->fecha_entrega = now();
                break;
            case 'RETORNADO':
                $encomienda->fecha_retorno = now();
                break;
        }

        return $encomienda->save();
    }

    public function getCustomers($search = '')
    {
        $query = Customer::where('isActive', true);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%");
            });
        }

        return $query->orderBy('name')->get();
    }

    public function getSucursales()
    {
        return Sucursal::where('isActive', true)->orderBy('name')->get();
    }

    public function getTransportistas()
    {
        return Transportista::where('isActive', true)->orderBy('name')->get();
    }

    public function getVehiculos()
    {
        return Vehiculo::where('isActive', true)->orderBy('name')->get();
    }

    public function getVehiculosByTransportista($transportistaId)
    {
        return Vehiculo::where('isActive', true)
                       ->where('transportista_id', $transportistaId)
                       ->orderBy('name')
                       ->get();
    }

    private function generateUniqueCode()
    {
        do {
            $code = 'ENC-' . str_pad(rand(1, 99999), 5, '0', STR_PAD_LEFT);
        } while (Encomienda::where('code', $code)->exists());

        return $code;
    }

    public function calculateTotal($paquetes)
    {
        $total = 0;
        foreach ($paquetes as $paquete) {
            $total += $paquete['amount'] ?? 0;
        }
        return $total;
    }
}
