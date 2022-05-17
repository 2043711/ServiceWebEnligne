<?php

namespace App\Action;

use App\Domain\Film\Service\FilmListor;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class FilmListAction
{
    private $filmListor;

    public function __construct(FilmListor $filmListor)
    {
        $this->filmListor = $filmListor;
    }

    public function __invoke(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ): ResponseInterface {
        $simple_string = "ChevalDansLaFerme\n";
        
        // Store the cipher method
        $ciphering = "AES-128-CTR";
        
        // Use OpenSSl Encryption method
        $iv_length = openssl_cipher_iv_length($ciphering);
        $options = 0;
        
        // Non-NULL Initialization Vector for encryption
        $encryption_iv = '1234567891011121';
        
        // Store the encryption key
        $encryption_key = "ApiDereck";
        
        // Use openssl_encrypt() function to encrypt the data
        $encryption = openssl_encrypt($simple_string, $ciphering, $encryption_key, $options, $encryption_iv);
        
        //Décriptage de la chaine de caractère $encryption
        $decryption = openssl_decrypt($encryption, $ciphering, $encryption_key, $options, $encryption_iv);
        
        error_log("Encrypted String: " . $encryption . "\n" . "Decypted String: " . $decryption . "\n", 3, "C:\Program Files\Ampps\www\ServiceWeb\debug.log");
        
        if(count($args) == 1){
            $id = intval($args["id"]);
            $result = $this->filmListor->listFilm($id);
        } else {
            $result = $this->filmListor->listAllFilms();
        }
        // Invoke the Domain with inputs and retain the result

        $response->getBody()->write((string)json_encode($result));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
}
