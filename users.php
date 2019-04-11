<?php
    session_start();
    include_once("../../models/backend/config.php");
    class User{
        public $firstname = null;
        public $lastname = null;
        public $email = null;
        public $password = null;
        public $cof_password = null;

        public function __construct($data = array()){
            if(isset($data['fname'])){
                $this->firstname = $this->check_input(ucwords(stripslashes($data['fname'])));
                // printf($this->firstname."<br>");
            }
            if(isset($data['lname'])){
                $this->lastname = $this->check_input(ucwords(stripslashes($data['lname'])));
                // printf($this->lastname."<br>");
            }
            if(isset($data['umail'])){
                $this->email = $this->check_input($data['umail']);
                // printf($this->email."<br>");
            }
            if(isset($data['upsw'])){
                $this->password = trim($data['upsw']);
                // printf($this->password."<br>");
            }
            if(isset($data['cpsw'])){
                $this->cof_password = trim($data['cpsw']);
                // printf($this->cof_password."<br>");
            }
        }

        public function storeFormvalue($params){
            $this->__construct($params);
        }

        public function check_input($input){
            $input = trim($input);
            $input = strip_tags($input);
            return $input;
        }

        public function register(){
            $reg_success = true;
            if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)){
                $reg_success = false;
            }
            if(strlen($this->password)<8){
                $reg_success = false;
            }
            if($this->cof_password != $this->password){
                $reg_success = false;
            }
            if(!$reg_success){
                die("<h1>Hello!</h1>");
            }else{
                try{
                    $con = new PDO(DB_DSN, DB_USN, DB_PW);
                    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    // echo "Connected Successfully!";
                    $sql1 = "INSERT INTO users(firstname, lastname, email, password) VALUES(:fname, :lname, :umail, :upsw)";
                    $stmt = $con->prepare($sql1);
                    $stmt->bindValue(":fname", $this->firstname, PDO::PARAM_STR);
                    $stmt->bindValue(":lname", $this->lastname, PDO::PARAM_STR);
                    $stmt->bindValue(":umail", $this->email, PDO::PARAM_STR);
                    $stmt->bindValue(":upsw", hash('sha512', $this->password), PDO::PARAM_STR);
                    $stmt->execute();

                    $sql2 = "SELECT * FROM users WHERE email=:umail AND password=:upsw LIMIT 1";
                    $stmt2 = $con->prepare($sql2);
                    $stmt2->bindValue(":umail", $this->email, PDO::PARAM_STR);
                    $stmt2->bindValue(":upsw", hash('sha512', $this->password), PDO::PARAM_STR);
                    $stmt2->execute();
                    $stmt2->setFetchMode(PDO::FETCH_ASSOC);
                    $valid = $stmt2->fetchAll();
                    if($valid){
                        foreach($valid as $data){
                            $_SESSION["id"] = $data["id"];
                            $_SESSION["firstname"] = $data["firstname"];
                            $_SESSION["lastname"] = $data["lastname"];
                            $_SESSION["email"] = $data['email'];
                        }
                        $_SESSION["uname"] = $_SESSION["firstname"]." ".$_SESSION["lastname"];
                    }else{
                        die("False");
                    }
                    header("Location:../../view/frontend/index.php");
                }
                catch(PDOException $e){
                    echo $e->getMessage();
                }
                $con = null;
            }
        }

        public function userLogin(){
            $login_success = false;
            try{
                $con = new PDO(DB_DSN, DB_USN, DB_PW);
                $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                // echo "Successfully!";
                $sql = "SELECT * FROM users WHERE email=:umail AND password=:upsw LIMIT 1";
                $stmt = $con->prepare($sql);
                $stmt->bindValue(":umail", $this->email, PDO::PARAM_STR);
                $stmt->bindValue(":upsw", hash('sha512', $this->password), PDO::PARAM_STR);
                $stmt->execute();
                $stmt->setFetchMode(PDO::FETCH_ASSOC);
                $valid = $stmt->fetchAll();
                if(!$valid){
                    $login_success = false;
                }else{
                    $login_success = true;
                    foreach($valid as $data){
                        $_SESSION["id"] = $data["id"];
                        $_SESSION["firstname"] = $data["firstname"];
                        $_SESSION["lastname"] = $data["lastname"];
                        $_SESSION["email"] = $data['email'];
                    }
                    $_SESSION["uname"] = $_SESSION["firstname"]." ".$_SESSION["lastname"];
                    header("Location:../../view/frontend/index.php");
                }
                if(!$login_success){
                    $_SESSION["LoginErr"] = "Invalid email or password.";
                    header("Location:../../view/backend/login.php");
                }
            }
            catch(PDOException $e){
                echo $e->getMessage();
            }
            $con = null;
        }
    }
    if(isset($_POST['signup'])){
        $usr = new User;
        $usr->storeFormvalue($_POST);
        $usr->register($_POST);
    }
    if(isset($_POST["signin"])){
        $usr = new User;
        $usr->storeFormvalue($_POST);
        $usr->userLogin($_POST);
    }
    if(isset($_POST["signout"])){
        unset($_SESSION["id"]);
        unset($_SESSION["firstname"]);
        unset($_SESSION["lastname"]);
        unset($_SESSION["uname"]);
        unset($_SESSION["email"]);
        header("Location:../../view/backend/login.php");
    }
?>