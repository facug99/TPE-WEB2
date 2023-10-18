<?php

/*
    TABLA DE ROUTING
    Acción                          Destino
    home                ->          home.controller->showHome();
    albums              ->          album.controller->showAlbums();
    album/:id           ->          album.controller->showAlbum($id);
    add-album           ->          album.controller->addAlbum();
    delete-album/:id    ->          album.controller->deleteBand();
    edit-album/:id      ->          album.controller->editAlbum($id);
    bands               ->          band.controller->showBands();
    band/:id            ->          band.controller->showBand($id);
    add-band            ->          band.controller->addBand();
    edit-band/:id       ->          band.controller->editBand($id);
    delete-band/:id     ->          band.controler->deleteBand($id);
    login               ->          auth.controller->showLogin();
    auth                ->          auth.controller->auth();
    logout              ->          auth.controller->logout();
    default             ->          error.controller->showError($error);
*/

// Se importa el archivo de configuración de la aplicación y los controladores
require_once "config.php";
require_once "./app/controllers/home.controller.php";
require_once "./app/controllers/album.controller.php";
require_once "./app/controllers/band.controller.php";
require_once "./app/controllers/auth.controller.php";
require_once "./app/controllers/error.controller.php";

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
        $albumController = new AlbumController();
        $albumController->showAlbums();
        break;

    case "album":
        $albumController = new AlbumController();
        $albumController->showAlbumById($params[1]);
        break;
    case "add-album":
        $albumController = new AlbumController();
        $albumController->addAlbum();
        break;
    
    case "edit-album":
        $albumController = new AlbumController();
        $albumController->editAlbum($params[1]);
        break;
    
    case "delete-album":
        $albumController = new AlbumController();
        $albumController->deleteAlbum($params[1]);
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

    case "edit-band":
        $bandController = new BandController();
        $bandController->editBand($params[1]);
        break;

    case "delete-band":
        $bandController = new BandController();
        $bandController->deleteBand($params[1]);
        break;

    case 'login':
        $authController = new AuthController();
        $authController->showLogin(); 
        break;
     
    case 'auth':
        $authController = new AuthController();
        $authController->auth();
        break;
    
    case 'logout':
        $authController = new AuthController();
        $authController->logout();
        break;
        
    default:
        $errorController = new ErrorController();
        $errorController->showError("Error 404: Page not found");
        break;
}
