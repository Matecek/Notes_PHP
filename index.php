<?php
declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

//spl_autoload_register(function (string $class) {
//    $path = str_replace(['\\', 'App/'], ['/', ''], $class);
//    $path = "src/$path.php";
//    require_once $path;
//});

require_once 'src/Utils/debug.php';
$config = require_once 'config/config.php';

use App\Controller\AbstractController;
use App\Controller\NoteController;
use App\Request;
use App\Exception\AppException;
use App\Exception\ConfigurationException;

$request = new Request($_GET, $_POST, $_SERVER);

try {
    AbstractController::initConfiguration($config);
    (new NoteController($request))->run();
}catch (ConfigurationException $e){
//    mail('xxx@xxx.com', 'Error', $e->getMessage());
    echo "<h1>Wystąpił błąd w aplikacji</h1>";
    echo 'Problem z konfiguracją. Proszę skontaktować się z administratorem: xxx@xxx.com';
}catch (AppException $e){
    echo "<h1>Wystąpił błąd w aplikacji</h1>";
    echo '<h3>' .$e->getMessage() .'</h3>';
}
catch (\Throwable $e) {
    echo "<h1>Wystąpił błąd w aplikacji</h1>";
    dump($e);
}
