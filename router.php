<?php

/*
    TABLA DE ROUTING
    Acción                      Destino
    home            ->          home.controller->showHome();
    albums          ->          album.controller->showAlbums();
    album/:id       ->          album.controller->showAlbum($id);
    bands           ->          band.controller->showBands();
    band/:id        ->          band.controller->showBand($id);
*/

// Se importan los archivos de los controladores
require_once "./app/controllers/home.controller.php";
require_once "./app/controllers/album.controller.php";
require_once "./app/controllers/band.controller.php";

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
switch ($params[0]) {
    case "home":
        $homeController = new HomeController();
        $homeController->showHome();
        break;

    case "albums":
        //showAlbums();
        break;

    case "album":
        //showAlbum($params[1]);
        break;

    case "bands":
        $bandController = new BandController();
        $bandController->showBands();
        break;

    case "band":
        $bandController = new BandController();
        $bandController->showBandById($params[1]);
        break;

    case "add-band":
        $bandController = new BandController();
        $bandController->addBand();
        break;

    case "modify-band":
        $bandController = new BandController();
        $bandController->modifyBand($params[1]);
        break;

    case "delete-band":
        $bandController = new BandController();
        $bandController->deleteBand($params[1]);
        break;

    default:
        //showError("Error 404: Page not found");
}
