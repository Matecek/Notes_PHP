<?php
declare(strict_types=1);

namespace App;

use App\Exception\ConfigurationException;
use App\Exception\NotFoundException;
use App\Exception\StorageException;
use PDO;
use PDOException;
use Throwable;

class Database
{
    private PDO $conn;

    public function __construct(array $config)
    {
        try {
            $this->validateConfig($config);
            $this->createConnection($config);
        }catch (PDOException $e){
            throw new StorageException('Connection error');
        }
    }

    public function getNote(int $id): array
    {
        try{
            $query = /** @lang text */
                "SELECT * FROM notes WHERE id = $id";
            $result = $this->conn->query($query);
            $note = $result->fetch(PDO::FETCH_ASSOC);
        }catch (Throwable $e){
            throw new StorageException('Brak notatki', 400, $e);
        }

        if (!$note) {
            throw new NotFoundException("Notatka o id: $id nie istnieje.");
        }

        return $note;
    }

    public function getNotes(
        int $pageNumber,
        int $pageSize,
        string $sortBy,
        string $sortOrder
    ): array {
        try {
            $limit = $pageSize;
            $offset = ($pageNumber - 1) * $pageSize;
            if (!in_array($sortBy, ['title', 'created'])){
                $sortBy = 'created';
            }
            if (!in_array($sortOrder, ['asc', 'desc'])){
                $sortOrder = 'desc';
            }

            $query = /** @lang text */
                "SELECT id, title, created 
                FROM notes
                ORDER BY $sortBy $sortOrder
                LIMIT $offset, $limit";

            $result = $this->conn->query($query);
            return  $result->fetchAll(PDO::FETCH_ASSOC);
        }catch (Throwable $e){
            throw new StorageException('Nie udało się pobrać notatek', 400, $e);
        }

    }

    public function getCount(): int
    {
        try {
            $query = /** @lang text */
                "SELECT count(*) AS cn FROM notes";
            $result = $this->conn->query($query);
            $result = $result->fetch(PDO::FETCH_ASSOC);
            if ($result === false) {
                throw new StorageException('Błąd przy próbie pobrania ilości', 400);
            }
            return (int) $result['cn'];
        }catch (Throwable $e){
            throw new StorageException('Nie udało się pobrać informacji o liczbie notatek', 400, $e);
        }

    }

    public function editNote(int $id, array $data): void
    {
        try{
            $title = $this->conn->quote($data['title']);
            $description = $this->conn->quote($data['description']);

            $query = /** @lang text */
                "UPDATE notes SET title = $title, description = $description WHERE id = $id";

            $this->conn->exec($query);
        }catch (Throwable $e){
            throw new StorageException("Nie udało się edytować notatki o id: $id", 400);
        }
    }

    public function deleteNote(int $id): void
    {
        try {
            $query = /** @lang text */
                "DELETE FROM notes WHERE id = $id LIMIT 1";
            $this->conn->exec($query);
        }catch (Throwable $e){
            throw new StorageException("Nie udało się usunąć notatki o id: $id", 400);
        }
    }

    public function createNote(array $data): void
    {
        try{
            $title = $this->conn->quote($data['title']);
            $description = $this->conn->quote($data['description']);
            $created = $this->conn->quote(date('Y-m-d H:i:s'));

            $query = /** @lang text */
                "INSERT INTO notes (title, description, created) VALUES ($title, $description, $created)";

            $this->conn->exec($query);
        }catch (Throwable $e){
            throw new StorageException('Nie udało się utworzyć nowej notatki', 400);
        }
    }

    private function createConnection(array $config): void
    {
        $dsn = "mysql:dbname={$config['database']};host={$config['host']}";

        $this->conn = new PDO($dsn, $config['user'], $config['password'], [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    }

    private function validateConfig(array $config): void
    {
        if (empty($config['database']) || empty($config['host']) || empty($config['user']) || empty($config['password']))
        {
            throw new ConfigurationException('Storage config error');
        }
    }
}