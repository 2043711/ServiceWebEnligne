<?php

namespace App\Action;

use App\Domain\Film\Service\FilmDeletor;
use App\Domain\Film\Service\FilmListor;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class FilmDeleteAction
{
    private $filmDeletor;

    public function __construct(FilmDeletor $filmDeletor)
    {
        $this->filmDeletor = $filmDeletor;
    }

    public function __invoke(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ): ResponseInterface {

        if(isset($args['id']) && isset($args['cle'])){
            $id = intval($args['id']);
            if ($this->filmDeletor->listcle($args['cle'])){
                $this->filmDeletor->deleteFilm($id);
                $result = ['success'=> true];
                $response->getBody()->write((string)json_encode($result));

                return $response
                    ->withHeader('Content-Type', 'application/json')
                    ->withStatus(200);
            }
        } else {
            //Pas de ID ou pas de cle ou mauvaise cle
            $result = ['success' => false];
            $response->getBody()->write((string)json_encode($result));

            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(400);
        }
    }
}
