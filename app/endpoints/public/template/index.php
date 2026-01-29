<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>phptframework</title>
  <link rel="stylesheet" href="/assets/css/neon-dark.css">
  <style>
    /* small local tweaks for public template */
    .hero + .card{margin-top:14px}
  </style>
</head>
<body>
  <header class="site-header">
    <div class="brand">
      <div class="title">phptframework</div>
      <div class="tag">Minimal PHP framework + starter blog</div>
    </div>
    <nav class="nav" style="margin-left:auto">
      <a href="/">Home</a>
      <a href="/blog">Blog</a>
      <a href="/admin/posts">Admin</a>
    </nav>
  </header>

  <main class="container">
    <?php if (!empty($content)) { include $content; } else { ?>
      <section class="hero">
        <h1>Welcome to phptframework</h1>
        <p class="lead">A compact PHP framework with routing, Markdown support and a starter blog. Use the admin area to create posts and moderate comments.</p>
        <p><a class="btn" href="/blog">View blog</a></p>
      </section>
    <?php } ?>

  </main>
</body>
</html>
