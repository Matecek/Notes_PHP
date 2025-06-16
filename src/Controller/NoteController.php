<?php
declare(strict_types=1);

namespace App\Controller;

class NoteController extends AbstractController
{
    private const PAGE_SIZE = 5;

    public function createAction(): void
    {
        if ($this->request->hasPost()) {
            $noteData = [
                'title' => $this->request->postParam('title'),
                'description' => $this->request->postParam('description')
            ];
            $this->noteModel->create($noteData);
            $this->redirect('/', ['after' => 'created']);
        }

        $this->view->render('create');
    }

    public function showAction(): void
    {
        $this->view->render(
            'show',
            [
                'note' => $this->getNote(),
            ]
        );
    }

    public function listAction(): void
    {
        $phrase = $this->request->getParam('phrase');
        $pageNumber = (int) $this->request->getParam('page', 1);
        $pageSize = (int) $this->request->getParam('pagesize', self::PAGE_SIZE);

        $sortBy = $this->request->getParam('sortby', 'edited');
        $sortOrder = $this->request->getParam('sortorder', 'desc');

        if (!in_array($pageSize, [1, 5, 10])){
            $pageSize = self::PAGE_SIZE;
        }

        if ($phrase){
            $noteList = $this->noteModel->search($phrase, $pageNumber, $pageSize, $sortBy, $sortOrder);
            $notes = $this->noteModel->searchCount($phrase);
        }else{
            $noteList = $this->noteModel->list($pageNumber, $pageSize, $sortBy, $sortOrder);
            $notes = $this->noteModel->count();
        }

        $this->view->render(
            'list',
            [
                'page' => [
                    'number' => $pageNumber,
                    'size' => $pageSize,
                    'pages' => (int) ceil($notes/$pageSize)
                ],
                'phrase' => $phrase,
                'sort' => [
                    'by' => $sortBy,
                    'order' => $sortOrder
                ],
                'notes' => $noteList,
                'after' => $this->request->getParam('after') ?? null,
                'error' => $this->request->getParam('error') ?? null
            ]
        );
    }

    public function editAction(): void
    {

        if ($this->request->isPost()) {
            $noteId = (int) $this->request->postParam('id');
            $noteData = [
                'title' => $this->request->postParam('title'),
                'description' => $this->request->postParam('description')
            ];
            $this->noteModel->edit($noteId, $noteData);
            $this->redirect('/', ['after' => 'edited']);
        }

        $this->view->render(
            'edit',
            [
                'note' => $this->getNote(),
            ]
        );
    }

    public function deleteAction(): void
    {
        if($this->request->isPost()){
            $noteId = (int) $this->request->postParam('id');
            $this->noteModel->delete($noteId);
            $this->redirect('/', ['after' => 'deleted']);
        }

        $this->view->render(
            'delete',
            [
                'note' => $this->getNote(),
            ]
        );
    }

    private function getNote(): array
    {
        $noteId = (int) $this->request->getParam('id');
        if (!$noteId) {
            $this->redirect('/', ['error' => 'missingNoteParams']);
        }

        return $this->noteModel->get($noteId);
    }
}