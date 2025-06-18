<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Request;
use app\repositories\SpaceRepository;
use app\models\Space;

class SpaceController extends Controller
{
    private SpaceRepository $spaceRepository;

    public function __construct()
    {
        parent::__construct();
        $this->spaceRepository = new SpaceRepository();
    }

    public function index()
    {
        $spaces = $this->spaceRepository->findAll();
        return $this->render('space/index', [
            'spaces' => $spaces
        ]);
    }

    public function show(int $id)
    {
        $space = $this->spaceRepository->findById($id);
        if (!$space) {
            return $this->render('error', [
                'exception' => new \Exception('Space not found', 404)
            ]);
        }

        return $this->render('space/show', [
            'space' => $space
        ]);
    }

    public function create(Request $request)
    {
        if (!$this->isAdmin()) {
            $this->response->redirect('/login');
        }

        if ($request->isPost()) {
            $space = new Space();
            $space->loadData($request->getBody());

            if ($this->spaceRepository->save($space)) {
                $this->session->setFlash('success', 'Space created successfully');
                $this->response->redirect('/spaces');
            }
        }

        return $this->render('space/create');
    }

    public function edit(Request $request, int $id)
    {
        if (!$this->isAdmin()) {
            $this->response->redirect('/login');
        }

        $space = $this->spaceRepository->findById($id);
        if (!$space) {
            return $this->render('error', [
                'exception' => new \Exception('Space not found', 404)
            ]);
        }

        if ($request->isPost()) {
            $space->loadData($request->getBody());

            if ($this->spaceRepository->save($space)) {
                $this->session->setFlash('success', 'Space updated successfully');
                $this->response->redirect('/spaces/' . $id);
            }
        }

        return $this->render('space/edit', [
            'space' => $space
        ]);
    }

    public function delete(int $id)
    {
        if (!$this->isAdmin()) {
            $this->response->redirect('/login');
        }

        if ($this->spaceRepository->delete($id)) {
            $this->session->setFlash('success', 'Space deleted successfully');
        } else {
            $this->session->setFlash('error', 'Error deleting space');
        }

        $this->response->redirect('/spaces');
    }
}