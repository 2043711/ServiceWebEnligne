<?php

namespace App\Domain\Film\Service;

use App\Domain\Film\Repository\FilmDeletorRepository;
use App\Exception\ValidationException;

/**
 * Service.
 */
final class FilmDeletor
{
    /**
     * @var FilmDeletorRepository
     */
    private $repository;

    /**
     * The constructor.
     *
     * @param FilmDeletorRepository $repository The repository
     */
    public function __construct(FilmDeletorRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Supprimer un utilisateur selon son ID
     *
     * @param $id de l'utilisateur
     */

    public function listcle($cle)
    {
        // Insert film
        $result = $this->repository->listcle($cle);

        return $result;
    }

    public function deleteFilm($id)
    {
        $this->repository->deleteFilm($id);

    }
}
