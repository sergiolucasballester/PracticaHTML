<?php

/**
 * Clase de conexión a la base de datos usando PDO
 */
class DatabaseConnection
{
    private static $connection = null;
    private $host = 'localhost';
    private $database = 'colegio';
    private $user = 'root';
    private $password = '';

    /**
     * Obtiene la conexión PDO (patrón Singleton)
     *
     * @return PDO
     * @throws Exception
     */
    public static function getConnection()
    {
        if (self::$connection === null) {
            try {
                $dsn = 'mysql:host=localhost;dbname=colegio;charset=utf8mb4';
                self::$connection = new PDO(
                    $dsn,
                    'root',
                    '',
                    array(
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    )
                );
            } catch (PDOException $e) {
                throw new Exception('Error de conexión a la base de datos: ' . $e->getMessage());
            }
        }
        return self::$connection;
    }
}

?>
