<!-- app/views/login.php -->
<?php include 'header.php'; ?>

    <h2>Login</h2>
    <?php echo $error; ?>
    <form id="loginForm" method="POST" action="<?php echo BASE_URL; ?>user/login">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <br><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <br><br>

        <button type="submit">Login</button>
    </form>

<?php include 'footer.php'; ?>
