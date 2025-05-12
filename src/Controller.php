<?php
declare(strict_types=1);

namespace App;

use App\Exception\ConfigurationException;
use App\Exception\StorageException;

require_once 'Database.php';
require_once 'View.php';
require_once 'Exception/ConfigurationException.php';

class Controller
{
    private const DEFAULT_ACTION = 'list';

    private static array $config= [];

    private Database $database;
    private array $request;
    private View $view;

    public static function initConfiguration(array $config): void
    {
        self::$config = $config;
    }

    /**
     * @throws ConfigurationException
     * @throws StorageException
     */
    public function __construct(array $request)
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
        $viewpager = [];
        try {
            switch ($this->action()) {
                case 'create':
                    $page = 'create';
                    $data = $this->getRequestPost();

                    if (!empty($data)) {
                        $errors = [];

                        if (empty(trim($data['title']))) {
                            $errors[] = 'Tytuł nie może być pusty.';
                        }

                        if (!empty($errors)) {
                            throw new StorageException(implode('<br>', $errors));
                        }

                        $this->database->createNote([
                            'title' => $data['title'],
                            'description' => $data['description']
                        ]);
                        header('Location: /?before=created');
                    }
                    break;

                case 'show':
                    $viewpager = [
                        'title' => 'Moja notatka',
                        'description' => 'Opis',
                    ];
                    $page = 'show';
                    break;

                default:
                    $page = 'list';
                    $data = $this->getRequestGet();
                    $viewpager['before'] = $data['before'] ?? null;
                    break;
            }
        } catch (StorageException $e) {
            $page = 'create';
            $data = $this->getRequestPost();
            $viewpager = [
                'error' => $e->getMessage(),
                'title' => $data['title'] ?? '',
                'description' => $data['description'] ?? '',
                'created' => false
            ];
        }

        $this->view->render($page, $viewpager);
    }


    private function action(): string
    {
        $data = $this->getRequestGet();
        return $data['_action'] ?? self::DEFAULT_ACTION;
    }

    private function getRequestPost(): array
    {
        return $this->request['post'] ?? [];
    }

    private function getRequestGet(): array
    {
        return $this->request['get'] ?? [];
    }
}