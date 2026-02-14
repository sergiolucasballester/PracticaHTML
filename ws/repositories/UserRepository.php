<?php

require_once __DIR__ . '/../config/DatabaseConnection.php';
require_once __DIR__ . '/../models/User.php';

/**
 * Clase UserRepository para gestionar operaciones con usuarios en la BD
 */
class UserRepository
{
    private $connection;

    public function __construct()
    {
        $this->connection = DatabaseConnection::getConnection();
    }

    /**
     * Obtiene un usuario por su ID
     *
     * @param int $id
     * @return User|null
     */
    public function getUserById($id)
    {
        $sql = 'SELECT * FROM alumno WHERE id = :id';
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([':id' => $id]);
        $data = $stmt->fetch();

        if ($data) {
            return $this->createUserFromData($data);
        }
        return null;
    }

    /**
     * Obtiene todos los usuarios
     *
     * @return array
     */
    public function getAllUsers()
    {
        $sql = 'SELECT * FROM alumno';
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $users = [];

        while ($data = $stmt->fetch()) {
            $users[] = $this->createUserFromData($data);
        }

        return $users;
    }

    /**
     * Crea un nuevo usuario en la BD
     *
     * @param User $user
     * @return User|null
     */
    public function createUser($user)
    {
        $sql = 'INSERT INTO alumno (nombre, apellidos, password, telefono, email, sexo, fecha_nacimiento) 
                VALUES (:nombre, :apellidos, :password, :telefono, :email, :sexo, :fecha_nacimiento)';
        $stmt = $this->connection->prepare($sql);

        $result = $stmt->execute([
            ':nombre' => $user->getNombre(),
            ':apellidos' => $user->getApellidos(),
            ':password' => $user->getPassword(),
            ':telefono' => $user->getTelefono(),
            ':email' => $user->getEmail(),
            ':sexo' => $user->getSexo(),
            ':fecha_nacimiento' => $user->getFechaNacimiento(),
        ]);

        if ($result) {
            $user->setId((int) $this->connection->lastInsertId());
            return $user;
        }
        return null;
    }

    /**
     * Actualiza un usuario en la BD
     *
     * @param int $id
     * @param User $user
     * @return bool
     */
    public function updateUser($id, $user)
    {
        // Obtener usuario actual para preservar campos no modificados
        $current = $this->getUserById($id);
        if (!$current) {
            return false;
        }

        // Usar valores nuevos si se proporcionan, si no, mantener los actuales
        $nombre = !empty($user->getNombre()) ? $user->getNombre() : $current->getNombre();
        $apellidos = !empty($user->getApellidos()) ? $user->getApellidos() : $current->getApellidos();
        $password = !empty($user->getPassword()) ? $user->getPassword() : $current->getPassword();
        $telefono = $user->getTelefono() !== null ? $user->getTelefono() : $current->getTelefono();
        $email = $user->getEmail() !== null ? $user->getEmail() : $current->getEmail();
        $sexo = $user->getSexo() !== null ? $user->getSexo() : $current->getSexo();
        $fechaNacimiento = !empty($user->getFechaNacimiento()) 
            ? $user->getFechaNacimiento() 
            : $current->getFechaNacimiento();

        $sql = 'UPDATE alumno SET nombre = :nombre, apellidos = :apellidos, password = :password, 
                telefono = :telefono, email = :email, sexo = :sexo, fecha_nacimiento = :fecha_nacimiento 
                WHERE id = :id';
        $stmt = $this->connection->prepare($sql);

        return $stmt->execute([
            ':nombre' => $nombre,
            ':apellidos' => $apellidos,
            ':password' => $password,
            ':telefono' => $telefono,
            ':email' => $email,
            ':sexo' => $sexo,
            ':fecha_nacimiento' => $fechaNacimiento,
            ':id' => $id,
        ]);
    }

    /**
     * Elimina un usuario de la BD
     *
     * @param int $id
     * @return User|null
     */
    public function deleteUser($id)
    {
        // Obtener el usuario antes de eliminarlo
        $user = $this->getUserById($id);
        if (!$user) {
            return null;
        }

        $sql = 'DELETE FROM alumno WHERE id = :id';
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([':id' => $id]);

        return $user;
    }

    /**
     * Crea un objeto User a partir de datos de la BD
     *
     * @param array $data
     * @return User
     */
    private function createUserFromData($data)
    {
        return new User(
            $data['nombre'],
            $data['apellidos'],
            $data['password'],
            $data['telefono'] ?? null,
            $data['email'] ?? null,
            $data['sexo'] ?? null,
            $data['fecha_nacimiento'] ?? null,
            (int) $data['id']
        );
    }
}

?>
