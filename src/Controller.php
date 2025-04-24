<?php
declare(strict_types=1);

namespace App;

require_once 'src/View.php';

class Controller
{
    private const DEFAULT_ACTION = 'list';
    private array $request;

    public function __construct(array $request)
    {
        $this->request = $request;
    }

    public function action(): string
    {
        $data = $this->getRequestGet();
        return $data['_action'] ?? self::DEFAULT_ACTION;
    }

    public function run(): void
    {
        $view = new View();
        $viewpager = [];

        switch ($this->action()) {
            case 'create':
                $page = 'create';
                $created = false;

                $data = $this->getRequestPost();
                if (!empty($data)) {
                    $created = true;
                    $viewpager = [
                        'title' => $data['title'],
                        'description' => $data['description'],
                    ];
                }

                $viewpager['created'] = $created;
                break;
            case 'show':
                $viewpager = [
                    'title' => 'Moja notatka',
                    'description' => 'Opis',
                ];
                break;
            default:
                $page = 'list';
                $viewpager['resultList'] = "wyświetlamy notatki";
                break;
        }
        $view->render($page, $viewpager);
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