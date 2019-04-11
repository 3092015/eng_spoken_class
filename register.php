<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Create Your Admin Account</title>
    <link rel="stylesheet" href="../../public/css/style.css">
    <link rel="stylesheet" href="../../public/css/bootstrap.min.css">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="form_wrapper">
                <h1>Sign Up</h1>
                <form action="../../controllers/backend/users.php" method="post" name="loginform" onsubmit="return formvalidate()">
                    <div class="form-row">   
                        <div class="form-group col-6">
                            <label for="fname">First Name</label>
                            <input type="text" class="form-control" name="fname" id="fname" required autofocus>
                        </div>
                        <div class="form-group col-6">
                            <label for="lname">Last Name</label>
                            <input type="text" class="form-control" name="lname" id="lname" required autofocus>
                        </div>
                    </div>
                
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" name="umail" id="umail" required>
                    </div>

                    <div class="form-group">
                        <label for="psw">Password</label>
                        <input type="password" class="form-control" name="upsw" id="upsw" title="Must contain at least one number and at least 8 or more characters" required>
                        <p id="upswerr"></p>
                    </div>

                    <div class="form-group">
                        <label for="cpsw">Confirm Password</label>
                        <input type="password" class="form-control" name="cpsw" id="cpsw" required>
                        <p id="cpswerr"></p>
                    </div>

                    <div class="form-group">
                        <input type="checkbox" onclick="passwordvsb()">
                        <label for="shwpsw">Show Password</label>
                    </div>

                    <div class="form-group">
                        <input type="submit" value="Sign Up" class="btn btn-success" name="signup">
                        <a href="login.php" class="btn btn-secondary">Sign In</a>
                    </div>        
                </form>
            </div>
        </div>
    </div>

    <script src="../../public/js/formvalidate.js"></script>
</body>
</html>