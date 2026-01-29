<h1>Posts</h1>

<p><a href="/admin/posts/create">Create new post</a></p>

<?php if (empty($posts)): ?>
    <p>No posts.</p>
<?php else: ?>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Slug</th>
                <th>Status</th>
                <th>Updated</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($posts as $p): ?>
                <tr>
                    <td><?php echo (int) $p['id']; ?></td>
                    <td><?php echo htmlspecialchars($p['title']); ?></td>
                    <td><?php echo htmlspecialchars($p['slug']); ?></td>
                    <td><?php echo htmlspecialchars($p['status']); ?></td>
                    <td><?php echo htmlspecialchars($p['updated_at']); ?></td>
                    <td>
                        <a href="/admin/posts/edit/<?php echo (int) $p['id']; ?>">Edit</a>
                        |
                        <form method="post" action="/admin/posts/delete/<?php echo (int) $p['id']; ?>" style="display:inline;" onsubmit="return confirm('Delete this post?');">
                            <button type="submit">Delete</button>
                        </form>
                        |
                        <a href="/post/show/<?php echo htmlspecialchars($p['slug']); ?>" target="_blank">View</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>
