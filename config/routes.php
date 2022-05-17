<?php

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use App\Middleware\BasicAuthMiddleware;
use App\Middleware\AuthMiddleware;
use Slim\App;

return function (App $app) {
    $app->get('/', \App\Action\HomeAction::class)->setName('home');

    $app->post('/film', \App\Action\FilmCreationAction::class);
    
    // Documentation de l'api
    $app->get('/docs', \App\Action\Docs\SwaggerUiAction::class);

    $app->get('/film', \App\Action\FilmListAction::class);
    $app->get('/film/{id}', \App\Action\FilmListAction::class);
    $app->delete('/film/{id}/{cle}', \App\Action\FilmDeleteAction::class);
    $app->put('/film/{id}', \App\Action\FilmUpdateAction::class);

    $app->get('/hello', \App\Action\HelloAction::class)->setName("hello")->add(AuthMiddleware::class);

    //CORS
    $app->options('/{routes:.*}', \App\Action\PreflightAction::class);
};

