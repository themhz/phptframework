<h1>Set a new password</h1>

<?php if (!empty($error)): ?>
    <p style="color: #ffb4a2;"><strong><?php echo htmlspecialchars($error); ?></strong></p>
<?php endif; ?>

<?php if (empty($error)): ?>
<form method="post" action="/reset">
    <input type="hidden" name="token" value="<?php echo htmlspecialchars((string)($_GET['token'] ?? '')); ?>">
    <div>
        <label>New password<br>
            <input type="password" name="password" required>
        </label>
    </div>
    <div>
        <label>Confirm password<br>
            <input type="password" name="password_confirm" required>
        </label>
    </div>
    <div style="margin-top:8px;">
        <button type="submit" class="btn">Set password</button>
    </div>
</form>
<?php endif; ?>
