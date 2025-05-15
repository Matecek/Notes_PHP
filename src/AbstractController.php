<?php
declare(strict_types=1);

namespace App;

require_once 'Database.php';
require_once 'View.php';
require_once 'Exception/ConfigurationException.php';

use App\Exception\ConfigurationException;
use App\Exception\StorageException;

abstract class AbstractController
{
    protected const DEFAULT_ACTION = 'list';

    private static array $config= [];

    protected Database $database;
    protected Request $request;
    protected View $view;

    public static function initConfiguration(array $config): void
    {
        self::$config = $config;
    }

    /**
     * @throws ConfigurationException
     * @throws StorageException
     */
    public function __construct(Request $request)
    {
        if (empty(self::$config['db'])) {
            throw new ConfigurationException('Config error');
        }
        $this->database = new Database(self::$config['db']);

        $this->request = $request;
        $this->view = new View();
    }

    public function run(): void
    {
        $action = $this->action() . 'Action';

        if (!method_exists($this, $action)) {
            $action = self::DEFAULT_ACTION . 'Action';
        }
        $this->$action();
    }

    protected function action(): string
    {
        return $this->request->getParam('action', self::DEFAULT_ACTION);
    }
}