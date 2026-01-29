<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>phptframework admin</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        nav a { margin-right: 12px; }
        textarea { width: 100%; }
        input[type="text"], input[type="email"], input[type="password"] { width: 100%; max-width: 680px; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ddd; padding: 8px; }
        th { background: #f3f3f3; text-align: left; }
    </style>
</head>
<body>
    <nav>
        <a href="/">Home</a>
        <a href="/blog">Blog</a>
        <a href="/admin/posts">Posts</a>
        <a href="/admin/comments">Comments</a>
        <a href="/logout">Logout</a>
    </nav>
    <hr>
    <?php
        if (!empty($content)) {
            include $content;
        }
    ?>
</body>
</html>
