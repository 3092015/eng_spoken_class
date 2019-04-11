<?php 
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>LogIn</title>
    <link rel="stylesheet" href="../../public/css/style.css">
    <link rel="stylesheet" href="../../public/css/bootstrap.min.css">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="form_wrapper">
                <h1>Sign In</h1>
                <?php
                    if(isset($_SESSION["LoginErr"])){
                        echo "<p class='login_err'>".$_SESSION['LoginErr']."</p>";
                        unset($_SESSION["LoginErr"]);
                    }
                ?>
                <form action="../../controllers/backend/users.php" method="post">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" name="umail" id="umail" required autofocus>
                    </div>

                    <div class="form-group">
                        <label for="psw">Password</label>
                        <input type="password" class="form-control" name="upsw" id="upsw" required>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-6">
                            <input type="checkbox" onclick="passwordvsb()">
                            <label for="shwpsw">Show Password</label>
                        </div>
                        <div class="form-group col-6 text-right">
                            <a href="" class="fgtpsw">Forgot Password?</a>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="submit" value="Sign In" class="btn btn-success" name="signin">
                        <a href="register.php" class="btn btn-secondary">Sign Up</a>
                    </div>        
                </form>
            </div>
        </div>
    </div>

    <script src="../../public/js/formvalidate.js"></script>
</body>
</html>