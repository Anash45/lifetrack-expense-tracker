<!-- app/views/register.php -->
<?php include 'header.php'; ?>

    <h2>Register</h2>
    <form id="registerForm" method="POST" action="<?php echo BASE_URL; ?>user/register">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>
        <br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <br><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <br><br>

        <button type="submit">Register</button>
    </form>

<?php include 'footer.php'; ?>
