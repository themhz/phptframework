<h1>Register</h1>

<?php if (!empty($error)): ?>
    <p style="color: #ffb4a2;"><strong><?php echo htmlspecialchars($error); ?></strong></p>
<?php endif; ?>

<form method="post" action="/register">
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
    <div>
        <label>Confirm password<br>
            <input type="password" name="password_confirm" required>
        </label>
    </div>
    <div style="margin-top: 8px;">
        <button type="submit" class="btn">Register</button>
    </div>
</form>
