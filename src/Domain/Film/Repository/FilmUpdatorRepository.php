<?php

namespace App\Domain\Film\Repository;

use PDO;

/**
 * Repository.
 */
class FilmUpdatorRepository
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
     * Insert film row.
     *
     * @param array $film The film
     *
     * @return int The new ID
     */
    public function updateFilm(array $film, $id): bool
    {
        $sql = "SELECT * FROM films WHERE id = ?";

        $stmt = $this->connection->prepare($sql);
        $stmt->execute(array($id));
        $results = $stmt->fetchAll();

        $row = [
            'nom' => $film['nom'],
            'duree' => $film['duree'],
            'dateSortie' => $film['dateSortie'],
            'urlImage' => $film['urlImage'],
            'id' => $id,

        ];

        $sql = "UPDATE films SET 
                nom=:nom, 
                duree=:duree, 
                dateSortie=:dateSortie, 
                urlImage=:urlImage
                WHERE id =:id;";

        $this->connection->prepare($sql)->execute($row);

        return true;
    }
}

