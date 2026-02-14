<?php

header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/repositories/UserRepository.php';
require_once __DIR__ . '/utilities/JsonResponse.php';
require_once __DIR__ . '/models/User.php';

/**
 * crearUsuario2.php
 * 
 * Crea un nuevo usuario en la BD a partir de los parámetros POST
 * recibidos del formulario HTML
 */

try {
    // Validar que se recibieron todos los parámetros requeridos por POST
    $requiredFields = ['nombre', 'apellidos', 'password', 'fecha_nacimiento'];
    $missingFields = [];

    foreach ($requiredFields as $field) {
        if (!isset($_POST[$field]) || empty($_POST[$field])) {
            $missingFields[] = $field;
        }
    }

    if (!empty($missingFields)) {
        echo JsonResponse::send(
            false,
            'Campos requeridos faltantes: ' . implode(', ', $missingFields),
            null
        );
        exit;
    }

    // Obtener los parámetros POST
    $nombre = trim($_POST['nombre']);
    $apellidos = trim($_POST['apellidos']);
    $password = trim($_POST['password']);
    $telefono = isset($_POST['telefono']) ? trim($_POST['telefono']) : null;
    $email = isset($_POST['email']) ? trim($_POST['email']) : null;
    $sexo = isset($_POST['sexo']) ? trim($_POST['sexo']) : null;
    $fechaNacimiento = trim($_POST['fecha_nacimiento']);

    // Validaciones básicas
    if (empty($nombre) || empty($apellidos) || empty($password)) {
        echo JsonResponse::send(false, 'Los campos nombre, apellidos y password no pueden estar vacíos', null);
        exit;
    }

    // Crear nuevo usuario
    $user = new User(
        $nombre,
        $apellidos,
        $password,
        $telefono,
        $email,
        $sexo,
        $fechaNacimiento
    );

    $repository = new UserRepository();
    $createdUser = $repository->createUser($user);

    if ($createdUser) {
        // Usuario creado exitosamente
        $data = [
            'id' => $createdUser->getId(),
            'nombre' => $createdUser->getNombre(),
            'apellidos' => $createdUser->getApellidos(),
            'password' => $createdUser->getPassword(),
            'telefono' => $createdUser->getTelefono(),
            'email' => $createdUser->getEmail(),
            'sexo' => $createdUser->getSexo(),
            'fecha_nacimiento' => $createdUser->getFechaNacimiento(),
        ];
        echo JsonResponse::send(true, 'Usuario creado correctamente', $data);
    } else {
        echo JsonResponse::send(false, 'Error al crear el usuario', null);
    }
} catch (Exception $e) {
    echo JsonResponse::send(false, 'Error: ' . $e->getMessage(), null);
}

?>
