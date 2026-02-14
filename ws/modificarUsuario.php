<?php

header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/repositories/UserRepository.php';
require_once __DIR__ . '/utilities/JsonResponse.php';
require_once __DIR__ . '/models/User.php';

/**
 * modificarUsuario.php
 * 
 * Modifica un usuario existente en la BD
 * - Parámetro GET: id (ID del usuario a modificar)
 * - Parámetros POST: nombre, apellidos, password, telefono, email, sexo, fecha_nacimiento
 * 
 * Solo se modifican los campos que se envían por POST y no están vacíos
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

    // Verificar que el usuario existe
    $existingUser = $repository->getUserById($id);
    if (!$existingUser) {
        echo JsonResponse::send(false, "Usuario con id $id no encontrado", null);
        exit;
    }

    // Obtener los parámetros POST (solo se usan si están presentes y no están vacíos)
    $nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';
    $apellidos = isset($_POST['apellidos']) ? trim($_POST['apellidos']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';
    $telefono = isset($_POST['telefono']) ? trim($_POST['telefono']) : null;
    $email = isset($_POST['email']) ? trim($_POST['email']) : null;
    $sexo = isset($_POST['sexo']) ? trim($_POST['sexo']) : null;
    $fechaNacimiento = isset($_POST['fecha_nacimiento']) ? trim($_POST['fecha_nacimiento']) : '';

    // Crear objeto User con datos parciales para actualizar solo lo necesario
    $userToUpdate = new User(
        $nombre,
        $apellidos,
        $password,
        $telefono,
        $email,
        $sexo,
        $fechaNacimiento
    );

    // Actualizar el usuario
    $updated = $repository->updateUser($id, $userToUpdate);

    if ($updated) {
        // Obtener el usuario actualizado para retornarlo
        $updatedUser = $repository->getUserById($id);

        $data = [
            'id' => $updatedUser->getId(),
            'nombre' => $updatedUser->getNombre(),
            'apellidos' => $updatedUser->getApellidos(),
            'password' => $updatedUser->getPassword(),
            'telefono' => $updatedUser->getTelefono(),
            'email' => $updatedUser->getEmail(),
            'sexo' => $updatedUser->getSexo(),
            'fecha_nacimiento' => $updatedUser->getFechaNacimiento(),
        ];
        echo JsonResponse::send(true, 'Usuario modificado correctamente', $data);
    } else {
        echo JsonResponse::send(false, 'Error al modificar el usuario', null);
    }
} catch (Exception $e) {
    echo JsonResponse::send(false, 'Error: ' . $e->getMessage(), null);
}

?>
