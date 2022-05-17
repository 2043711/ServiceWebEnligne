<?php

namespace App\Domain\Key\Repository;
use PDO;
use function PHPUnit\Framework\throwException;

class KeyGettorRepository
{
    /**
     * @var PDO The database connection
     */
    private $connection;
    /**
     * Constructor.
     *
     * @param PDO $connection The database connection
     */
    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Insert user row.
     *
     * @param array $user The user
     *
     * @return int The new ID
     */
    public function getKey(string $username, string $password)
    {
        $sql = "SELECT password, id FROM users WHERE username = ?";

        $stmt = $this->connection->prepare($sql);
        $stmt->execute(array($username));
        $result = $stmt->fetchAll();
        if(count($result) < 1){
            throw new \Exception("Username invalid");
        }
        if ( password_verify($password, $result[0]['password']) ){
            $cle = substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyz", 10)), 0, 10);
            $sqlCle = "INSERT INTO cle_api (no_cle, user_id) VALUE ( ?,?)";
            $stmtCle = $this->connection->prepare($sqlCle);
            $stmtCle->execute(array($cle,$result[0]['id']));

            return $cle;
        }
        return "";
    }
    /**
     * Verifie si une clé est valide
     */
    public function validateKey(string $key)
    {
        $sql = "SELECT 1 FROM cle_api WHERE no_cle = ?";

        $stmt = $this->connection->prepare($sql);
        $stmt->execute(array($key));
        $result = $stmt->fetchAll();
        if(count($result) < 1){
            return false;
        }
        return true;
    }


    /**
    Liste les clées
     */
    public function listKeys()
    {
        $sql = "SELECT cle_api.*, username FROM cle_api INNER JOIN users ON cle_api.user_id = users.id ORDER BY username";

        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result;
    }

    public function deleteKey($id){
        $sql = "DELETE FROM cle_api WHERE id = ?";

        $stmt = $this->connection->prepare($sql);
        $stmt->execute(array($id));
        $deletedRows = $stmt->rowCount();
        return $deletedRows == 1;
    }

    public function cleUserExists($userId){
        $sql = "SELECT 1 FROM cle_api WHERE user_id = ?";

        $stmt = $this->connection->prepare($sql);
        $stmt->execute(array($userId));
        return $stmt->rowCount() == 1;
    }

    public function createKey($userId, $key)
    {
        $sql = "INSERT INTO cle_api (no_cle, user_id) VALUES (?, ?)";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute(array($key, $userId));
        return $this->connection->lastInsertId();
    }

    public function updateKey($userId, $key){
        $sql = "UPDATE cle_api SET no_cle = ? WHERE user_id = ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute(array($key, $userId));
        return $stmt->rowCount() > 0;
    }
}