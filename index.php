<?php
declare(strict_types=1);

namespace App;

require_once 'src/Utils/debug.php';
require_once 'src/controller.php';

const DEFAULT_ACTION = 'list';

$controller = new Controller($_GET, $_POST);
$controller->run();