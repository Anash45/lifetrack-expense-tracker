<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Life Track - Expense Tracker</title>
        <script src="<?php echo BASE_URL; ?>js/jquery.min.js"></script>
        <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/style.css">
    </head>

    <body>
        <header>
            <div class="container">
                <img src="<?php echo BASE_URL; ?>img/logo.png" alt="Logo" class="h-logo">
                <nav>
                    <?php if(isset($_SESSION['role']) && $_SESSION['role'] == 'admin'){
                        echo '<a class="btn btn-primary" href="'.BASE_URL.'user/users">Users</a>';
                    } ?>
                    <a class="btn btn-success" href="<?php echo BASE_URL; ?>dashboard">Transactions</a>
                    <a class="btn btn-danger" href="<?php echo BASE_URL; ?>user/logout">Logout</a>
                </nav>
            </div>
        </header>
        <main>