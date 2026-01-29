<?php

use App\Models\Posts;
use App\Components\RequestHandler;

class Controller
{
    public function get($id = null, $method = 'get', $templatePath = null)
    {
        $postsModel = new Posts();
        $posts = $postsModel->select()->orderBy('updated_at', 'DESC')->execute();

        $content = dirname(__FILE__) . '/list.php';
        include $templatePath;
    }

    public function create($id = null, $method = 'get', $templatePath = null)
    {
        $post = [
            'id' => null,
            'title' => '',
            'slug' => '',
            'body_md' => '',
            'status' => 'draft',
        ];
        $content = dirname(__FILE__) . '/form.php';
        include $templatePath;
    }

    public function edit($id = null, $method = 'get', $templatePath = null)
    {
        $post = null;
        if (!empty($id)) {
            $postsModel = new Posts();
            $rows = $postsModel->select()->where('id', '=', (int) $id)->execute();
            $post = empty($rows) ? null : $rows[0];
        }

        if (!$post) {
            http_response_code(404);
            echo 'Post not found';
            return;
        }

        $content = dirname(__FILE__) . '/form.php';
        include $templatePath;
    }

    public function save($id = null, $method = 'post', $templatePath = null)
    {
        if ($method !== 'post') {
            http_response_code(405);
            echo '405 Method Not Allowed';
            return;
        }

        $title = trim((string) RequestHandler::get('title'));
        $slug = trim((string) RequestHandler::get('slug'));
        $body = (string) RequestHandler::get('body_md');
        $status = (string) RequestHandler::get('status');

        if ($slug === '') {
            $slug = $this->slugify($title);
        }

        if ($title === '' || $slug === '') {
            header('Location: /admin/posts');
            return;
        }

        $postsModel = new Posts();

        // New
        if (empty($id)) {
            $postsModel->title = $title;
            $postsModel->slug = $slug;
            $postsModel->body_md = $body;
            $postsModel->status = ($status === 'published' ? 'published' : 'draft');
            if ($postsModel->status === 'published') {
                $postsModel->published_at = date('Y-m-d H:i:s');
            }
            $postsModel->insert();
            header('Location: /admin/posts');
            return;
        }

        // Update
        $postsModel->title = $title;
        $postsModel->slug = $slug;
        $postsModel->body_md = $body;
        $postsModel->status = ($status === 'published' ? 'published' : 'draft');
        if ($postsModel->status === 'published') {
            // Set published_at if missing
            $postsModel->query(
                'UPDATE posts SET published_at = COALESCE(published_at, :now) WHERE id = :id',
                ['now' => date('Y-m-d H:i:s'), 'id' => (int) $id]
            );
        }

        $postsModel->update()->where('id', '=', (int) $id)->execute();
        header('Location: /admin/posts');
    }

    public function delete($id = null, $method = 'post', $templatePath = null)
    {
        if ($method !== 'post') {
            http_response_code(405);
            echo '405 Method Not Allowed';
            return;
        }

        if (!empty($id)) {
            $postsModel = new Posts();
            $postsModel->delete()->where('id', '=', (int) $id)->execute();
        }

        header('Location: /admin/posts');
    }

    private function slugify(string $text): string
    {
        $text = strtolower(trim($text));
        $text = preg_replace('/[^a-z0-9]+/i', '-', $text);
        $text = trim($text, '-');
        return $text;
    }
}
