<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>phptframework admin</title>
    <link rel="stylesheet" href="/assets/css/neon-dark.css">
    <style>header.site-header{border-bottom:1px solid rgba(255,255,255,0.02)}</style>
</head>
<body>
  <header class="site-header">
    <div class="brand">
      <div class="title">phptframework</div>
      <div class="tag">Admin</div>
    </div>
    <nav class="nav" style="margin-left:auto">
      <a href="/">Home</a>
      <a href="/blog">Blog</a>
      <a href="/admin/posts">Posts</a>
      <a href="/admin/comments">Comments</a>
      <a href="/logout">Logout</a>
    </nav>
  </header>

  <main class="container">
    <?php
        if (!empty($content)) {
            include $content;
        } else {
            echo '<div class="card"><h1>Admin Dashboard</h1><p class="lead">Use the navigation to manage posts and comments.</p></div>';
        }
    ?>
  </main>
</body>
</html>
