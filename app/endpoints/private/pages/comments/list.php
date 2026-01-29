<h1>Comments</h1>

<p>
    <a href="/admin/comments?status=pending">Pending</a> |
    <a href="/admin/comments?status=approved">Approved</a> |
    <a href="/admin/comments?status=spam">Spam</a>
</p>

<?php if (empty($comments)): ?>
    <p>No comments.</p>
<?php else: ?>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Post</th>
                <th>Author</th>
                <th>Created</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($comments as $c): ?>
                <tr>
                    <td><?php echo (int) $c['id']; ?></td>
                    <td>
                        <a href="/post/show/<?php echo htmlspecialchars($c['post_slug']); ?>" target="_blank">
                            <?php echo htmlspecialchars($c['post_title']); ?>
                        </a>
                    </td>
                    <td><?php echo htmlspecialchars($c['author_name']); ?></td>
                    <td><?php echo htmlspecialchars($c['created_at']); ?></td>
                    <td><?php echo htmlspecialchars($c['status']); ?></td>
                    <td>
                        <?php if ($c['status'] !== 'approved'): ?>
                            <form method="post" action="/admin/comments/approve/<?php echo (int) $c['id']; ?>" style="display:inline;">
                                <button type="submit">Approve</button>
                            </form>
                        <?php endif; ?>
                        <?php if ($c['status'] !== 'spam'): ?>
                            <form method="post" action="/admin/comments/spam/<?php echo (int) $c['id']; ?>" style="display:inline;">
                                <button type="submit">Spam</button>
                            </form>
                        <?php endif; ?>
                        <form method="post" action="/admin/comments/delete/<?php echo (int) $c['id']; ?>" style="display:inline;" onsubmit="return confirm('Delete this comment?');">
                            <button type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
                <tr>
                    <td colspan="6" style="background:#fafafa;">
                        <pre style="white-space: pre-wrap; margin: 0;"><?php echo htmlspecialchars($c['body_md']); ?></pre>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>
