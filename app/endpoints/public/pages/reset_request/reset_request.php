<h1>Password reset</h1>

<?php if (!empty($error)): ?>
    <p style="color: #ffb4a2;"><strong><?php echo htmlspecialchars($error); ?></strong></p>
<?php endif; ?>

<p>Enter your account email and we'll send you a link to reset your password.</p>

<form method="post" action="/reset-request">
    <div>
        <label>Email<br>
            <input type="email" name="email" required>
        </label>
    </div>
    <div style="margin-top:8px;">
        <button type="submit" class="btn">Send reset link</button>
    </div>
</form>
