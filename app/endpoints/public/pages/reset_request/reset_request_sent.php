<h1>Reset requested</h1>

<p>If your account exists we'll send a reset link to your email. For development, you can use the link below:</p>

<?php if (!empty($resetLink)): ?>
    <p><a class="btn" href="<?php echo htmlspecialchars($resetLink); ?>"><?php echo htmlspecialchars($resetLink); ?></a></p>
<?php else: ?>
    <p>Check your email for the reset link.</p>
<?php endif; ?>
