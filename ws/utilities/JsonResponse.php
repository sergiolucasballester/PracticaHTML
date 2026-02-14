<?php

/**
 * Clase para manejar respuestas JSON de forma consistente
 */
class JsonResponse
{
    /**
     * Retorna una respuesta JSON con formato estandarizado
     *
     * @param bool $success
     * @param string $message
     * @param mixed $data
     * @return string
     */
    public static function send($success, $message, $data = null)
    {
        return json_encode([
            'success' => $success,
            'message' => $message,
            'data' => $data,
        ], JSON_UNESCAPED_UNICODE);
    }
}

?>
