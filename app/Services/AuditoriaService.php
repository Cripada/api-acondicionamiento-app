<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuditoriaService
{
    
    /**
     * Configura la información de auditoría en el contexto SQL.
     *
     * @param string $tabla Nombre de la tabla afectada.
     * @param string|null $ip Dirección IP del cliente (opcional).
     * @param string|null $usuario Nombre del usuario autenticado (opcional).
     * @return void
     */

     public static function setContextInfo(string $tabla, ?string $ip = null, ?string $usuario = null): void
    {
        try {
            $direccionIp = $ip ?? (request()->ip() ?? '127.0.0.1');
            $nombreUsuario = $usuario ?? (Auth::user()->name ?? 'UsuarioDesconocido');

            $contextData = json_encode([
                'tabla' => $tabla,
                'ip' => $direccionIp,
                'usuario' => $nombreUsuario,
            ], JSON_UNESCAPED_UNICODE);

            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \Exception('Error al codificar JSON: ' . json_last_error_msg());
            }

            if (strlen($contextData) > 128) {
                throw new \Exception('El JSON excede el límite de 128 bytes para CONTEXT_INFO');
            }

            // Convertir los parámetros en datos binarios
            $binaryContextData = bin2hex($contextData);

            \Log::info('Contexto configurado en CONTEXT_INFO: ' . $contextData);
            \Log::info('Binary context data: ' . $binaryContextData);
            DB::statement("SET CONTEXT_INFO 0x$binaryContextData");

        } catch (\Exception $e) {
            \Log::error('Error en setContextInfo: ' . $e->getMessage());
        }
    }    
}
