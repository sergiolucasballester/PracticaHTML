<?php

header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/repositories/UserRepository.php';
require_once __DIR__ . '/utilities/JsonResponse.php';

/**
 * deleteUsuario.php
 * 
 * Elimina un usuario de la BD por su ID (parámetro GET "id")
 * Retorna los datos del usuario eliminado
 */

try {
    // Validar que se proporcione el parámetro 'id' por GET
    if (!isset($_GET['id'])) {
        echo JsonResponse::send(false, 'Parámetro "id" requerido', null);
        exit;
    }

    $id = (int) $_GET['id'];

    // Validar que el ID sea válido
    if ($id <= 0) {
        echo JsonResponse::send(false, 'ID inválido', null);
        exit;
    }

    $repository = new UserRepository();

    // Obtener y eliminar el usuario
    $user = $repository->deleteUser($id);

    if ($user) {
        // Usuario eliminado correctamente
        $data = [
            'id' => $user->getId(),
            'nombre' => $user->getNombre(),
            'apellidos' => $user->getApellidos(),
            'password' => $user->getPassword(),
            'telefono' => $user->getTelefono(),
            'email' => $user->getEmail(),
            'sexo' => $user->getSexo(),
            'fecha_nacimiento' => $user->getFechaNacimiento(),
        ];
        echo JsonResponse::send(true, 'Usuario eliminado correctamente', $data);
    } else {
        echo JsonResponse::send(false, "Usuario con id $id no encontrado", null);
    }
} catch (Exception $e) {
    echo JsonResponse::send(false, 'Error: ' . $e->getMessage(), null);
}

?>
