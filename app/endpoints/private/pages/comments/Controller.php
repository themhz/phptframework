<?php

use App\Models\Comments;
use App\Components\RequestHandler;

class Controller
{
    public function get($id = null, $method = 'get', $templatePath = null)
    {
        $status = (string) (RequestHandler::get('status') ?? 'pending');
        if (!in_array($status, ['pending', 'approved', 'spam'], true)) {
            $status = 'pending';
        }

        $commentsModel = new Comments();
        $comments = $commentsModel->query(
            'SELECT c.*, p.title AS post_title, p.slug AS post_slug '
            . 'FROM comments c JOIN posts p ON c.post_id = p.id '
            . 'WHERE c.status = :status '
            . 'ORDER BY c.created_at DESC',
            ['status' => $status]
        );

        $content = dirname(__FILE__) . '/list.php';
        include $templatePath;
    }

    public function approve($id = null, $method = 'post', $templatePath = null)
    {
        $this->setStatus($id, $method, 'approved');
    }

    public function spam($id = null, $method = 'post', $templatePath = null)
    {
        $this->setStatus($id, $method, 'spam');
    }

    public function delete($id = null, $method = 'post', $templatePath = null)
    {
        if ($method !== 'post') {
            http_response_code(405);
            echo '405 Method Not Allowed';
            return;
        }

        if (!empty($id)) {
            $commentsModel = new Comments();
            $commentsModel->delete()->where('id', '=', (int) $id)->execute();
        }

        header('Location: /admin/comments');
    }

    private function setStatus($id, string $method, string $status): void
    {
        if ($method !== 'post') {
            http_response_code(405);
            echo '405 Method Not Allowed';
            return;
        }

        if (!empty($id)) {
            $commentsModel = new Comments();
            $commentsModel->status = $status;
            $commentsModel->update()->where('id', '=', (int) $id)->execute();
        }

        header('Location: /admin/comments');
    }
}
