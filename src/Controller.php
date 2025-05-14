<?php
declare(strict_types=1);

namespace App;

require_once 'Database.php';
require_once 'View.php';
require_once 'Exception/ConfigurationException.php';

use App\Exception\ConfigurationException;
use App\Exception\NotFoundException;
use App\Exception\StorageException;
use App\Request;

class Controller
{
    private const DEFAULT_ACTION = 'list';

    private static array $config= [];

    private Database $database;
    private Request $request;
    private View $view;

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

    public function createAction()
    {
        if ($this->request->hasPost()) {
            $noteData = [
                'title' => $this->request->postParam('title'),
                'description' => $this->request->postParam('description')
            ];
            $this->database->createNote($noteData);
            header('Location: /?before=created');
            exit;
        }

        $this->view->render('create');
    }

    public function showAction()
    {
        $noteId = (int) $this->request->getParam('id');

        if (!$noteId) {
            header('Location: /?error=missingNoteId');
            exit;
        }

        try{
            $note = $this->database->getNote($noteId);
        }catch (NotFoundException $e){
            header('Location: /?error=noteNotFound');
            exit;
        }

        $this->view->render(
            'show',
            ['note' => $note]
        );
    }

    public function listAction()
    {
        $this->view->render(
            'list',
            [
                'notes' => $this->database->getNotes(),
                'before' => $this->request->getParam('before') ?? null,
                'error' => $this->request->getParam('error') ?? null
            ]
        );
    }

    public function run(): void
    {
        $action = $this->action() . 'Action';
        $this->$action();
    }

    private function action(): string
    {
        return $this->request->getParam('action', self::DEFAULT_ACTION);
    }
}