<?php
declare(strict_types=1);

namespace App;

require_once 'src/Utils/debug.php';
require_once 'src/controller.php';
require_once 'src/Exception/AppException.php';
require_once 'src/Request.php';

use App\Exception\AppException;
use App\Exception\ConfigurationException;
use App\Request;
use Throwable;

$config = require_once 'config/config.php';

$request = new Request($_GET, $_POST);

try {
    Controller::initConfiguration($config);
    (new Controller($request))->run();
}catch (ConfigurationException $e){
//    mail('xxx@xxx.com', 'Error', $e->getMessage());
    echo "<h1>Wystąpił błąd w aplikacji</h1>";
    echo 'Problem z konfiguracją. Proszę skontaktować się z administratorem: xxx@xxx.com';
}catch (AppException $e){
    echo "<h1>Wystąpił błąd w aplikacji</h1>";
    echo '<h3>' .$e->getMessage() .'</h3>';
}
catch (Throwable $e) {
    echo "<h1>Wystąpił błąd w aplikacji</h1>";
    dump($e);
}
