<?php

require_once __DIR__ . '/../interfaces/IToJson.php';

/**
 * Clase User que representa un alumno de la base de datos
 */
class User implements IToJson
{
    private $id;
    private $nombre;
    private $apellidos;
    private $password;
    private $telefono;
    private $email;
    private $sexo;
    private $fechaNacimiento;

    /**
     * Constructor de User
     *
     * @param string $nombre
     * @param string $apellidos
     * @param string $password
     * @param string|null $telefono
     * @param string|null $email
     * @param string|null $sexo
     * @param string|null $fechaNacimiento
     * @param int|null $id
     */
    public function __construct(
        $nombre,
        $apellidos,
        $password,
        $telefono = null,
        $email = null,
        $sexo = null,
        $fechaNacimiento = null,
        $id = null
    ) {
        $this->nombre = $nombre;
        $this->apellidos = $apellidos;
        $this->password = $password;
        $this->telefono = $telefono;
        $this->email = $email;
        $this->sexo = $sexo;
        $this->fechaNacimiento = $fechaNacimiento;
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    public function getApellidos()
    {
        return $this->apellidos;
    }

    public function setApellidos($apellidos)
    {
        $this->apellidos = $apellidos;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getTelefono()
    {
        return $this->telefono;
    }

    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getSexo()
    {
        return $this->sexo;
    }

    public function setSexo($sexo)
    {
        $this->sexo = $sexo;
    }

    public function getFechaNacimiento()
    {
        return $this->fechaNacimiento;
    }

    public function setFechaNacimiento($fechaNacimiento)
    {
        $this->fechaNacimiento = $fechaNacimiento;
    }

    /**
     * Convierte el objeto User a formato JSON
     *
     * @return string
     */
    public function toJSON()
    {
        return json_encode([
            'id' => $this->id,
            'nombre' => $this->nombre,
            'apellidos' => $this->apellidos,
            'password' => $this->password,
            'telefono' => $this->telefono,
            'email' => $this->email,
            'sexo' => $this->sexo,
            'fecha_nacimiento' => $this->fechaNacimiento,
        ]);
    }
}

?>