<?php


// Constante du mode de l'application
// dev : variables utilisées en local
// prod : pour le déploiement de l'api en production
define("MODE", "dev");

switch (MODE) {
    case "dev":
        // Configuration BD en local
        $_ENV['host'] = 'localhost';
        $_ENV['username'] = 'root';
        $_ENV['database'] = 'serviceweb_examfinal';
        $_ENV['password'] = 'mysql';
        break;
        
    case "prod":
        // Configuration BD pour Heroku
        $_ENV['host'] = 'us-cdbr-east-05.cleardb.net';
        $_ENV['username'] = 'bf9a85969e8e77';
        $_ENV['database'] = 'heroku_772d1f6a72ac3f9';
        $_ENV['password'] = '1bb801fd';
        break;

};
