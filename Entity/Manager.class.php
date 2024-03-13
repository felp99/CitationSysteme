<?php 
require_once 'config/db-config.php';
abstract class Manager {
    protected $pdo;

    public function __construct() {
        $this->pdo = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS); // Database connection;
    }

    abstract protected function create(Object $object);
    abstract protected function read(int $id): Object;
    abstract protected function readFromAttributes(Object $object): Object;
    abstract protected function update(Object $object);
    abstract protected function delete(int $id);
    abstract protected function readAll(): array;
    abstract protected function generateObjectFromArray(array $data): Object;
    abstract protected function exists(Object $object): int;
    protected function connectDB() 
    {
        try {
            $this -> pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->pdo; // Retourne l'objet PDO si la connexion est réussie
        } catch(PDOException $e) {
            die("Erreur de connexion : " . $e->getMessage()); // Gestion des erreurs de connexion
        }
    }
}