<?php

namespace App\Domain\Film\Service;

use App\Domain\Film\Repository\FilmCreatorRepository;
use App\Exception\ValidationException;

/**
 * Service.
 */
final class FilmCreator
{
    /**
     * @var FilmCreatorRepository
     */
    private $repository;

    /**
     * The constructor.
     *
     * @param FilmCreatorRepository $repository The repository
     */
    public function __construct(FilmCreatorRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Create a new user.
     *
     * @param array $data The form data
     *
     * @return int The new user ID
     */
    public function createFilm(array $data): int
    {

        // Insert user
        $filmId = $this->repository->insertFilm($data);

        // Logging here: User created successfully
        //$this->logger->info(sprintf('User created successfully: %s', $userId));

        return $filmId;
    }
}
