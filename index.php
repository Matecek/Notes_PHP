<?php
declare(strict_types=1);

namespace App;

require_once 'src/Utils/debug.php';
require_once 'src/view.php';

const DEFAULT_ACTION = 'list';

$action = $_GET['action'] ?? DEFAULT_ACTION;

$view = new View();
if ($action === 'create') {
    $resultCreate = "udało się";
}else{
    $resultList = "wyświetlamy notatki";
}
$view->render($action);

