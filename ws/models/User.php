<?php

require_once __DIR__ . '/../interfaces/IToJson.php';

/**
 * Clase User que representa un alumno de la base de datos
 */
class User implements IToJson
{
    private ?int $id;
    private string $nombre;
    private string $apellidos;
    private string $password;
    private ?string $telefono;
    private ?string $email;
    private ?string $sexo;
    private ?string $fechaNacimiento;

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
        string $nombre,
        string $apellidos,
        string $password,
        ?string $telefono = null,
        ?string $email = null,
        ?string $sexo = null,
        ?string $fechaNacimiento = null,
        ?int $id = null
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

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): void
    {
        $this->nombre = $nombre;
    }

    public function getApellidos(): string
    {
        return $this->apellidos;
    }

    public function setApellidos(string $apellidos): void
    {
        $this->apellidos = $apellidos;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getTelefono(): ?string
    {
        return $this->telefono;
    }

    public function setTelefono(?string $telefono): void
    {
        $this->telefono = $telefono;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    public function getSexo(): ?string
    {
        return $this->sexo;
    }

    public function setSexo(?string $sexo): void
    {
        $this->sexo = $sexo;
    }

    public function getFechaNacimiento(): ?string
    {
        return $this->fechaNacimiento;
    }

    public function setFechaNacimiento(?string $fechaNacimiento): void
    {
        $this->fechaNacimiento = $fechaNacimiento;
    }

    /**
     * Convierte el objeto User a formato JSON
     *
     * @return string
     */
    public function toJSON(): string
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