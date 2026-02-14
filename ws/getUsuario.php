<?php

header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/repositories/UserRepository.php';
require_once __DIR__ . '/utilities/JsonResponse.php';

/**
 * getUsuario.php
 * 
 * Obtiene un usuario por ID (si se proporciona el parámetro GET "id")
 * o todos los usuarios si no se proporciona ningún parámetro
 */

try {
    $repository = new UserRepository();

    // Verificar si se proporciona el parámetro 'id' por GET
    if (isset($_GET['id'])) {
        $id = (int) $_GET['id'];

        // Validar que el ID sea válido
        if ($id <= 0) {
            echo JsonResponse::send(false, 'ID inválido', null);
            exit;
        }

        // Buscar usuario por ID
        $user = $repository->getUserById($id);

        if ($user) {
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
            echo JsonResponse::send(true, 'Usuario obtenido correctamente', $data);
        } else {
            echo JsonResponse::send(false, "Usuario con id $id no encontrado", null);
        }
    } else {
        // Obtener todos los usuarios
        $users = $repository->getAllUsers();
        $data = [];

        foreach ($users as $user) {
            $data[] = [
                'id' => $user->getId(),
                'nombre' => $user->getNombre(),
                'apellidos' => $user->getApellidos(),
                'password' => $user->getPassword(),
                'telefono' => $user->getTelefono(),
                'email' => $user->getEmail(),
                'sexo' => $user->getSexo(),
                'fecha_nacimiento' => $user->getFechaNacimiento(),
            ];
        }

        echo JsonResponse::send(true, 'Usuarios obtenidos correctamente', $data);
    }
} catch (Exception $e) {
    echo JsonResponse::send(false, 'Error: ' . $e->getMessage(), null);
}

?>
