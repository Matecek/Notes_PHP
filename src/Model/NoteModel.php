<?php
declare(strict_types=1);

namespace App\Model;

use App\Exception\NotFoundException;
use App\Exception\StorageException;
use PDO;
use Throwable;

class NoteModel extends AbstractModel implements ModelInterface
{
    public function list(
        int $pageNumber,
        int $pageSize,
        string $sortBy,
        string $sortOrder
    ): array {
        return $this->findBy(null, $pageNumber, $pageSize, $sortBy, $sortOrder);
    }

    public function search(
        string $phrase,
        int $pageNumber,
        int $pageSize,
        string $sortBy,
        string $sortOrder
    ): array {
        return $this->findBy($phrase, $pageNumber, $pageSize, $sortBy, $sortOrder);
    }

    public function count(): int
    {
        try {
            $query = /** @lang text */
                "SELECT count(*) AS cn FROM notes";
            $result = $this->conn->query($query);
            $result = $result->fetch(PDO::FETCH_ASSOC);
            if ($result === false) {
                throw new StorageException('Błąd przy próbie pobrania ilości notatek', 400);
            }
            return (int) $result['cn'];
        }catch (Throwable $e){
            throw new StorageException('Nie udało się pobrać informacji o liczbie notatek', 400, $e);
        }

    }

    public function searchCount(string $phrase): int
    {
        try {
            $phrase = $this->conn->quote('%' . $phrase . '%', PDO::PARAM_STR);

            $query = /** @lang text */
                "SELECT count(*) AS cn FROM notes WHERE  title LIKE ($phrase)";
            $result = $this->conn->query($query);
            $result = $result->fetch(PDO::FETCH_ASSOC);
            if ($result === false) {
                throw new StorageException('Błąd przy próbie pobrania ilości notatek', 400);
            }
            return (int) $result['cn'];
        }catch (Throwable $e){
            throw new StorageException('Nie udało się pobrać informacji o liczbie notatek', 400, $e);
        }
    }

    public function get(int $id): array
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

    public function create(array $data): void
    {
        try{
            $title = $this->conn->quote($data['title']);
            $description = $this->conn->quote($data['description']);
            $dateTime = $this->conn->quote(date('Y-m-d H:i:s'));

            $query = /** @lang text */
                "INSERT INTO notes (title, description, created, edited) VALUES ($title, $description, $dateTime, $dateTime)";

            $this->conn->exec($query);
        }catch (Throwable $e){
            throw new StorageException('Nie udało się utworzyć nowej notatki', 400);
        }
    }

    public function edit(int $id, array $data): void
    {
        try{
            $title = $this->conn->quote($data['title']);
            $description = $this->conn->quote($data['description']);
            $dateTime = $this->conn->quote(date('Y-m-d H:i:s'));

            $query = /** @lang text */
                "UPDATE notes SET title = $title, description = $description, edited = $dateTime WHERE id = $id";

            $this->conn->exec($query);
        }catch (Throwable $e){
            throw new StorageException("Nie udało się edytować notatki o id: $id", 400);
        }
    }

    public function delete(int $id): void
    {
        try {
            $query = /** @lang text */
                "DELETE FROM notes WHERE id = $id LIMIT 1";
            $this->conn->exec($query);
        }catch (Throwable $e){
            throw new StorageException("Nie udało się usunąć notatki o id: $id", 400);
        }
    }

    private function findBy(
        ?string $phrase,
        int $pageNumber,
        int $pageSize,
        string $sortBy,
        string $sortOrder): array {
        try {
            $limit = $pageSize;
            $offset = ($pageNumber - 1) * $pageSize;

            if (!in_array($sortBy, ['edited', 'title'])){
                $sortBy = 'edited';
            }
            if (!in_array($sortOrder, ['asc', 'desc'])){
                $sortOrder = 'desc';
            }

            $wherePart = '';
            if ($phrase){
                $phrase = $this->conn->quote('%' . $phrase . '%', PDO::PARAM_STR);
                $wherePart = "WHERE title LIKE ($phrase)";
            }

            $query = /** @lang text */
                "SELECT id, title, created, edited 
                FROM notes
                $wherePart
                ORDER BY $sortBy $sortOrder
                LIMIT $offset, $limit";

            $result = $this->conn->query($query);
            return  $result->fetchAll(PDO::FETCH_ASSOC);
        }catch (Throwable $e){
            throw new StorageException('Nie udało się pobrać notatek', 400, $e);
        }
    }
}