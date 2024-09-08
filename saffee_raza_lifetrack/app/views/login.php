<?php include 'header.php'; ?>
<style>
    header{
        display: none;
    }
    main{
        min-height: calc(100vh - 34px);
    }
</style>
<div class="container">
    <div class="form-box login-form">
        <h2 class="title">Login</h2>
        <?php echo $error; ?>
        <form id="loginForm" method="POST" action="<?php echo BASE_URL; ?>user/login">
            <div class="form-group">
                <label for="email">Email:</label>
                <input class="inp" type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input class="inp" type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <p class="form-note">Doesn't have an account? <a href="<?php echo BASE_URL; ?>/user/register">Signup here!</a></p>
            </div>
            <div class="form-group">
                <button class="btn btn-primary" type="submit">Login</button>
            </div>
        </form>
    </div>
</div>
<?php include 'footer.php'; ?>