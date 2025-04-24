<?php
declare(strict_types=1);

namespace App;

require_once 'src/View.php';

class Controller
{
    private const DEFAULT_ACTION = 'list';
    private array $request;
    private View $view;

    public function __construct(array $request)
    {
        $this->request = $request;
        $this->view = new View();
    }

    public function run(): void
    {
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