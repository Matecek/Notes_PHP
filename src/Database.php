<?php
declare(strict_types=1);

namespace App;

use PDO;
use Exception;

class Database
{
    public function __construct(array $config)
    {
        dump($config);
        $dsn = "mysql:dbname={$config['database']};host={$config['host']}";

        try{
            $connection = new PDO('sss');
            dump($connection);
        }catch (Exception $e){
            dump($e);
        }

//        $connection = new PDO($dsn, $config['user'], $config['password']);
//        dump($connection);
    }
}