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
    <title>My Profile</title>
    <!-- Custon CSS -->
    <link rel="stylesheet" href="../../public/css/style.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../../public/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../public/css/font-awesome.min.css">
</head>
<body>
    <?php
        include_once("layout/nav.php");
    ?>

    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="prof_wrapper">
                    
                    <h5 class="prof_header">My Profile</h5>
                    <div class="prof_body">
                        <table class="table table-striped">
                            <tbody>
                                <tr>
                                    <td>First Name</td>
                                    <td>:</td>
                                    <td>
                                        <?php
                                            echo $_SESSION["firstname"];
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Last Name</td>
                                    <td>:</td>
                                    <td>
                                        <?php
                                            echo $_SESSION["lastname"];
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Email</td>
                                    <td>:</td>
                                    <td>
                                        <?php
                                            echo $_SESSION["email"];
                                        ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <a href="update.php" class="btn btn-success">Update</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap JQuery -->
    <script src="../../public/js/jquery-3.3.1.slim.min.js"></script>
        
    <!-- Bootstrap Js -->
    <script src="../../public/js/bootstrap.min.js"></script>
    <script src="../../public/js/popper.min.js"></script>
</body>
</html>

<?php
    }
    else{
        $_SESSION["LoginErr"] = "Please Sign In.";
        header("Location:login.php");
    }
?>