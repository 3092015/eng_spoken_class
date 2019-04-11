<?php
    session_start();
    if(isset($_SESSION["id"])){
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Update My Profile</title>
    <link rel="stylesheet" href="../../public/css/style.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../../public/css/bootstrap.min.css">
</head>
<body>
    <?php
        include_once("layout/nav.php");
    ?>
    <div class="container-fluid">
        <div class="row">
            <div class="form_wrapper">
                <h1>Update</h1>
                <form action="" method="post" name="loginform" onsubmit="return formvalidate()">
                    <div class="form-row">   
                        <div class="form-group col-6">
                            <label for="fname">First Name</label>
                            <input type="text" class="form-control" name="fname" id="fname" value="<?php echo $_SESSION["firstname"] ?>" autofocus>
                        </div>
                        <div class="form-group col-6">
                            <label for="lname">Last Name</label>
                            <input type="text" class="form-control" name="lname" id="lname" value="<?php echo $_SESSION["lastname"] ?>">
                        </div>
                    </div>
                
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" name="umail" id="umail" value="<?php echo $_SESSION["email"] ?>">
                    </div>

                    <div class="form-group">
                        <label for="psw">Password</label>
                        <input type="password" class="form-control" name="upsw" id="upsw" title="Must contain at least one number and at least 8 or more characters" required>
                        <p id="upswerr"></p>
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
                        <input type="submit" value="Continue" class="btn btn-success" name="update">
                        <a href="../backend/showprofile.php" class="btn btn-secondary">Back</a>
                    </div>        
                </form>
            </div>
        </div>
    </div>

    <!-- Custom Js -->
    <script src="../../public/js/formvalidate.js"></script>
    <!-- Bootstrap JQuery -->
    <script src="../../public/js/jquery-3.3.1.slim.min.js"></script>
        
    <!-- Bootstrap Js -->
    <script src="../../public/js/bootstrap.min.js"></script>
    <script src="../../public/js/popper.min.js"></script>
</body>
</html>

<?php
    }else{
        $_SESSION["LoginErr"] = "Please Sign In.";
        header("Location:login.php");
    }
?>