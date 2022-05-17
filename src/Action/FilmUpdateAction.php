<?php

namespace App\Action;

use App\Domain\Film\Service\FilmUpdator;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class FilmUpdateAction
{
    private $filmUpdator;

    public function __construct(FilmUpdator $filmUpdator)
    {
        $this->filmUpdator = $filmUpdator;
    }

    public function __invoke(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ): ResponseInterface {
        // Collect input from the HTTP request
        $data = (array)$request->getParsedBody();
        if(isset($args['id'])){
            $id = intval($args['id']);
            $success = $this->filmUpdator->updateFilm($data, $id);
            $result = ['success'=> $success];
            $response->getBody()->write((string)json_encode($result));

            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(200);

        }
        //Pas de ID
        $result = ['success' => false];
        $response->getBody()->write((string)json_encode($result));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(400);
    }
}
