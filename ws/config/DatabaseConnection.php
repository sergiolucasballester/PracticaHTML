<?php

/**
 * Clase de conexión a la base de datos usando PDO
 */
class DatabaseConnection
{
    private static ?PDO $connection = null;
    private const HOST = 'localhost';
    private const DATABASE = 'colegio';
    private const USER = 'root';
    private const PASSWORD = '';

    /**
     * Obtiene la conexión PDO (patrón Singleton)
     *
     * @return PDO
     * @throws Exception
     */
    public static function getConnection(): PDO
    {
        if (self::$connection === null) {
            try {
                $dsn = 'mysql:host=' . self::HOST . ';dbname=' . self::DATABASE . ';charset=utf8mb4';
                self::$connection = new PDO(
                    $dsn,
                    self::USER,
                    self::PASSWORD,
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    ]
                );
            } catch (PDOException $e) {
                throw new Exception('Error de conexión a la base de datos: ' . $e->getMessage());
            }
        }
        return self::$connection;
    }
}

?>
