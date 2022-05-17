<?php

namespace App\Domain\film\Repository;

use PDO;

/**
 * Repository.
 */
class FilmCreatorRepository
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
    public function insertFilm(array $film): int
    {
        $row = [
            'nom' => $film['nom'],
            'duree' => $film['duree'],
            'dateSortie' => $film['dateSortie'],
            'urlImage' => $film['urlImage']
        ];

        $sql = "INSERT INTO films SET
                nom = :nom,
                duree = :duree,
                dateSortie = :dateSortie,
                urlImage = :urlImage";

        $this->connection->prepare($sql)->execute($row);

        return (int)$this->connection->lastInsertId();
    }
}

