<h1><?php echo empty($post['id']) ? 'Create post' : 'Edit post'; ?></h1>

<form method="post" action="/admin/posts/save<?php echo empty($post['id']) ? '' : '/' . (int) $post['id']; ?>">
    <div>
        <label>Title<br>
            <input type="text" name="title" value="<?php echo htmlspecialchars($post['title']); ?>" required>
        </label>
    </div>

    <div>
        <label>Slug (optional)<br>
            <input type="text" name="slug" value="<?php echo htmlspecialchars($post['slug']); ?>">
        </label>
    </div>

    <div>
        <label>Status<br>
            <select name="status">
                <option value="draft" <?php echo ($post['status'] === 'draft') ? 'selected' : ''; ?>>draft</option>
                <option value="published" <?php echo ($post['status'] === 'published') ? 'selected' : ''; ?>>published</option>
            </select>
        </label>
    </div>

    <div>
        <label>Body (Markdown)<br>
            <textarea name="body_md" rows="18"><?php echo htmlspecialchars($post['body_md']); ?></textarea>
        </label>
    </div>

    <div style="margin-top: 10px;">
        <button type="submit">Save</button>
        <a href="/admin/posts">Cancel</a>
    </div>
</form>
