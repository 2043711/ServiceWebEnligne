<?php

namespace App\Domain\Film\Service;

use App\Domain\Film\Repository\FilmUpdatorRepository;
use App\Exception\ValidationException;

/**
 * Service.
 */
final class FilmUpdator
{
    /**
     * @var FilmUpdatorRepository
     */
    private $repository;

    /**
     * The constructor.
     *
     * @param FilmUpdatorRepository $repository The repository
     */
    public function __construct(FilmUpdatorRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Create a new film.
     *
     * @param array $data The form data
     *
     * @return int The new film ID
     */
    public function updateFilm(array $data, $id): bool
    {

        // Insert film
        $reussite = $this->repository->updateFilm($data, $id);

        // Logging here: Film created successfully
        //$this->logger->info(sprintf('Film created successfully: %s', $filmId));

        return $reussite;
    }
}
