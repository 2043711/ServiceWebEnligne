<?php
// Source : https://www.slimframework.com/docs/v4/concepts/middleware.html
namespace App\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;
use App\Domain\Key\Repository\KeyGettorRepository;

class AuthMiddleware
{
    /**
     * Example middleware invokable class
     *
     * @param  Request  $request PSR-7 request
     * @param  RequestHandler $handler PSR-15 request handler
     *
     * @return Response
     */

    private $repository;

    public function __construct(KeyGettorRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        $auth = $request->getHeader('Authorization');
        $route = $request->getAttribute('route');
        $exploded = explode(' ', $request->getHeaderLine('Authorization'));
        if($exploded[0] == 'Apikey'){

            if(!$this->repository->validateKey($exploded[1])){
                $response = new Response();
                $response->getBody()->write('Clé invalide!');
                return $response->withStatus(401);
            }

            $response = $handler->handle($request);
            $existingContent = (string) $response->getBody();

            $response = new Response();
            $response->getBody()->write(($existingContent));

            return $response
                ->withHeader('Content-Type', 'application/json');

        } else {
            $response = new Response();
            $response->getBody()->write('Veuillez utiliser une clé d\'api pour accéder à cette route');
            return $response->withStatus(401);
        }
    }
}
