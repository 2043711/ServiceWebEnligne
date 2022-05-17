<?php

namespace App\Domain\Film\Service;

use App\Domain\Film\Repository\FilmListorRepository;
use App\Exception\ValidationException;

/**
 * Service.
 */
final class FilmListor
{
    /**
     * @var FilmListorRepository
     */
    private $repository;

    /**
     * The constructor.
     *
     * @param filmListorRepository $repository The repository
     */
    public function __construct(FilmListorRepository $repository)
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
    public function listAllFilms()
    {
        // Insert film
        $result = $this->repository->listAllFilms();

        return $result;
    }

    public function listFilm($id)
    {
        // Insert film
        $result = $this->repository->listFilm($id);

        return $result;
    }
}
