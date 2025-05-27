<?php
namespace App\Database;

class Mariadb{
    private string $host = "localhost"; // endereço do servidor
    private string $dbname = "my_tarefas"; // nome do banco
    private string $username = "root"; // usuário do banco
    private string $password = "123456"; // senha do usuário do banco
    private ?\PDO $connection = null; // conexão com o banco

    public function __construct()
    {
        try {
            $this->connection = new \PDO(
                "mysql:host={$this->host};dbname={$this->dbname};
                charset=utf8",
                $this->username,
                $this->password,
                [
                    \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                    \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                    \PDO::ATTR_EMULATE_PREPARES => false,
                ]
                );
        } catch (\PDOException $e) {
            die("Erro de conexão: " . $e->getMessage());
        }
    }

    public function getConnection() : ?\PDO {
        return $this->connection;
    }

    public function getTaefaById(int $id): ?array{
        $sql = "SELECT * FROM tarefas WHERE id = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    public function update(): bool {
        $sql = "UPDATE tarefas SET titulo = :titulo, descricao = :descricao,
        status = :status, user_id = :user_id WHERE id = :id";
        $stmt = $this->connection->prepare($sql);
        return $stmt->execute([
            ':id' => $this->id,
            ':titulo' => $this->titulo,
            ':descricao' => $this->descricao,
            ':status' => $this->status,
            ':user_id' => $this->user_id
        ]);
    }

    public function delete(int $id): bool
    {
        $sql = "DELETE FROM tarefas WHERE id = :id";
        $stmt = $this->connection->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }

    public function getAllByUser(int $user_id) : array
    {
        $sql = "SELECT * FROM tarefas where user_id = :user_id";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([':user_id' => $user_id]);
        return $stmt->fetchAll();
    }
}

