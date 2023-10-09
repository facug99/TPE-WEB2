<?php

/*
    TABLA DE ROUTING
    Acción                      Destino
    home            ->          controller->showHome();
    albums          ->          controller->showAlbums();
    albums/:id      ->          controller->showAlbum($id);
    bands           ->          controller->showBands();
    bands/:id       ->          controller->showBand($id);
*/

// Se importan los archivos de los controladores
// ...

// URL base para utilizar URLs semánticas
define('BASE_URL', '//' . $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . dirname($_SERVER['PHP_SELF']) . '/');

// Lectura de acción del usuario
$action = "home"; // acción por defecto

if (!empty($_GET["action"])) {
    $action = $_GET["action"]; 
}

// Se analiza la acción (string parsing) y se almacena en un array
$params = explode('/', $action);

// Se determina qué camino seguir
switch($params[0]) {
    case "home":
        echo "Home";
        //showHome();
        break;

    case "albums":
        echo "Albums";
        //showAlbums();
        break;

    case "album":
        echo 'Album' . $params[1];
        //showAlbum($params[1]);
        break;

    case "bands":
        echo "Bands";
        //showBands();
        break;
        
    case "band":
        echo 'Band' . $params[1];
        //showBand($params[1]);
        break;

    default:
        //showError();
}