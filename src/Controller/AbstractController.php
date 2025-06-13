<?php
declare(strict_types=1);

namespace App\Controller;

use App\Exception\NotFoundException;
use App\Exception\StorageException;
use App\Request;
use App\View;
use App\Database;
use App\Exception\ConfigurationException;
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

    public function __construct(Request $request)
    {
        if (empty(self::$config['db'])) {
            throw new ConfigurationException('Config error');
        }
        $this->database = new Database(self::$config['db']);

        $this->request = $request;
        $this->view = new View();
    }

    final public function run(): void
    {
        try{
            $action = $this->action() . 'Action';

            if (!method_exists($this, $action)) {
                $action = self::DEFAULT_ACTION . 'Action';
            }

            $this->$action();
        } catch (StorageException $e){
            $this->view->render('error', ['message' => $e->getMessage()]);
        } catch (NotFoundException $e){
            $this->redirect('/', ['error' => 'noteNotFound']);
        }
    }

    final protected function redirect(string $to, array $params): void
    {
        $location = $to . '?' . http_build_query($params);
        header("Location: $location");
        exit;
    }

    final protected function action(): string
    {
        return $this->request->getParam('action', self::DEFAULT_ACTION);
    }
}