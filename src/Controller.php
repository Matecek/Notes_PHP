<?php
declare(strict_types=1);

namespace App;

require_once 'src/View.php';

class Controller
{
    private const DEFAULT_ACTION = 'list';
    private array $getData;
    private array $postData;
    public function __construct(array $getData, array $postData)
    {
        $this->getData = $getData;
        $this->postData = $postData;
    }
    public function run(): void
    {

        $action = $this->getData['_action'] ?? self::DEFAULT_ACTION;

        $view = new View();
        $viewpager = [];

        switch ($action) {
            case 'create':
                $page = 'create';
                $created = false;

                if (!empty($this->postData)) {
                    $created = true;
                    $viewpager = [
                        'title' => $this->postData['title'],
                        'description' => $this->postData['description'],
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
}