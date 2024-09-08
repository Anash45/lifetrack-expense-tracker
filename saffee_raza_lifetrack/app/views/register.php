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
        <h2 class="title">Register</h2>
        <form id="registerForm" method="POST" action="<?php echo BASE_URL; ?>user/register">
            <div class="form-group">
                <label for="name">Name:</label>
                <input class="inp" type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input class="inp" type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input class="inp" type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <p class="form-note">Already have an account? <a href="<?php echo BASE_URL; ?>/user/login">Login here!</a></p>
            </div>
            <div class="form-group">
                <button class="btn btn-primary" type="submit">Register</button>
            </div>
        </form>
    </div>
</div>
<?php include 'footer.php'; ?>