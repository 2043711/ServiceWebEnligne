<?php

namespace App\Domain\Key\Service;

use App\Domain\Key\Repository\KeyGettorRepository;
use App\Exception\ValidationException;
use http\Exception\InvalidArgumentException;

/**
 * Service.
 */
final class KeyGettor
{
    /**
     * @var KeyGettorRepository
     */
    private $repository;

    /**
     * The constructor.
     *
     * @param KeyGettorRepository $repository The repository
     */
    public function __construct(KeyGettorRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Get a Key
     *
     * @param string the base64 username and password
     *
     * @return string the user's key
     */
    public function getKey(string $basicAuth) : string
    {
        $decoded = base64_decode($basicAuth);
        $info = explode(":", $decoded);
        if(count($info) == 2){
            $cle = $this->repository->getKey($info[0], $info[1]);
            return $cle;
        }
        throw InvalidArgumentException("token invalid");
    }

    public function listKeys() : array
    {
        return $this->repository->listKeys();
    }

    public function deleteKey($id) : array
    {
        $array = array();
        if (is_numeric($id)) {
            $array['success'] = $this->repository->deleteKey($id);
        } else {
            $array['success'] = false;
            $array['message'] = "Le id doit être un nombre";
        }

        return $array;
    }

    public function updateKey($userId, $key){
        if($this->repository->cleUserExists($userId)){
            //Update
            if($this->repository->updateKey($userId, $key)){
                return array("success" => true, "message" => "Clé mise à jour");
            } else {
                return array("success" => false, "message" => "Erreur de mise à jour de la clée");
            }
        } else {
            //Create
            $id = $this->repository->createKey($userId, $key);
            return array("success" => true, "message" => "Clé créée", "id"=>$id);
        }
    }
}
