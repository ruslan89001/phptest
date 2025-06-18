<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Request;
use app\core\Response;
use app\mappers\ReviewMapper;
use app\models\Review;

class ReviewController extends Controller
{
    public function create(Request $request, Response $response, int $spaceId)
    {
        if (!$this->session->get('user_id')) {
            $this->session->setFlash('error', 'Пожалуйста, войдите в систему');
            $response->redirect('/login');
        }

        $review = new Review();
        $review->user_id = $this->session->get('user_id');
        $review->space_id = $spaceId;

        if ($request->isPost()) {
            $review->loadData($request->getBody());

            $mapper = new ReviewMapper();
            if ($mapper->save($review)) {
                $this->session->setFlash('success', 'Отзыв добавлен');
                $response->redirect("/spaces/$spaceId");
            } else {
                $this->session->setFlash('error', 'Ошибка при добавлении отзыва');
            }
        }

        return $this->render('review/create', [
            'model' => $review,
            'spaceId' => $spaceId
        ]);
    }

    public function delete(Request $request, Response $response, int $id)
    {
        $mapper = new ReviewMapper();
        $review = $mapper->findById($id);

        if (!$review) {
            $this->session->setFlash('error', 'Отзыв не найден');
            $response->redirect('/dashboard');
        }

        if ($review['user_id'] !== $this->session->get('user_id') && !$this->isAdmin()) {
            $this->session->setFlash('error', 'У вас нет прав для удаления этого отзыва');
            $response->redirect('/dashboard');
        }

        if ($mapper->delete($id)) {
            $this->session->setFlash('success', 'Отзыв удален');
        } else {
            $this->session->setFlash('error', 'Ошибка при удалении отзыва');
        }

        $response->redirect('/dashboard');
    }
}