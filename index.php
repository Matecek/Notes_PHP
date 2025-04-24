<?php
declare(strict_types=1);

namespace App;

require_once 'src/Utils/debug.php';
require_once 'src/view.php';

const DEFAULT_ACTION = 'list';

$action = $_GET['_action'] ?? DEFAULT_ACTION;
$view = new View();

$viewparams = [];
if ($action === 'create') {

    $page = 'create';
    $created = false;

    if (!empty($_POST)) {
        $created = true;
        $viewparams = [
            'title' => $_POST['title'],
            'description' => $_POST['description'],
        ];
    }

    $viewparams['created'] = $created;
}else{
    $page = 'list';
    $viewparams['resultList'] = "wyświetlamy notatki";
}

$view->render($page, $viewparams);

