<h1>Login</h1>

<?php if (!empty($error)): ?>
    <p style="color: #b00020;"><strong><?php echo htmlspecialchars($error); ?></strong></p>
<?php endif; ?>

<form method="post" action="/login">
    <?php if (!empty($next)): ?>
        <input type="hidden" name="next" value="<?php echo htmlspecialchars($next); ?>">
    <?php endif; ?>
    <div>
        <label>Email<br>
            <input type="email" name="email" required>
        </label>
    </div>
    <div>
        <label>Password<br>
            <input type="password" name="password" required>
        </label>
    </div>
    <div style="margin-top: 8px;">
        <button type="submit">Login</button>
    </div>
</form>
