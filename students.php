<?php
    session_start();
    include_once("../../models/backend/config.php");

    $id = null;
    $name = null;
    $dob = null;
    $email = null;
    $phone = null;
    $addr = null;
    $level = null;
    $image = null;
    $created_by = null;
    $active = null;
    $updated_at = null;

    class Student{
        public function __construct($data = array()){
            if(isset($data["id"])){
                $this->id = $data["id"];
            }
            if(isset($data["stuname"])){
                $this->name = $this->check_input(ucwords($data["stuname"]));
                // printf($this->name."<br/>");
            }
            if(isset($data["studob"])){
                $this->dob = $this->check_input($data["studob"]);
                // printf($this->dob."<br/>");
            }
            if(isset($data["stumail"])){
                $this->email = $this->check_input($data["stumail"]);
                // printf($this->email."<br/>");
            }else{
                $this->email = null;
                // printf($this->email."<br/>");
            }
            if(isset($data["stuph"])){
                $this->phone = $this->check_input($data["stuph"]);
                // printf($this->phone."<br/>");
            }
            if(isset($data["stuaddr"])){
                $this->addr = $this->check_input($data["stuaddr"]);
                // printf($this->addr."<br/>");
            }
            if(isset($data["level"])){
                $this->level = $this->check_input($data["level"]);
            }else{
                $this->level = "Beginner";
            }
            if(isset($_FILES["stuimg"]["name"])){
                $this->image = $_FILES["stuimg"]["name"];
            }
            $this->created_by = $_SESSION["id"];
            $this->active = 1;
            $this->updated_at = date("Y-m-d H:i:s");
        }

        public function reg_value($params){
            $this->__construct($params);
        }

        public function check_input($input){
            $input = trim($input);
            $input = strip_tags($input);
            return $input;
        }

        public function create(){
            // printf($this->level."<br/>". $this->created_by."<br/>".$this->updated_at."<br/>");
            // printf($this->image);
            $create_suc = true;
            if($this->email != null){
                if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)){
                    $create_suc = false;
                }
            }
            if(strlen($this->phone)!=11){
                $create_suc = false;
            }
            if(!file_exists("../../storage")){
                $create_suc = false;
            }
            if(!file_exists("../../storage/images")){
                $create_suc = false;
            }
            $uploadDir = "../../storage/images/";
            $file_path = $uploadDir.basename($this->image);
            $file_type = strtolower(pathinfo($file_path, PATHINFO_EXTENSION));
            // die($file_path);
            $check = getimagesize($_FILES["stuimg"]["tmp_name"]);
            if(!$check){
                $create_suc = false;
                $_SESSION["UploadErr"] = "File is not an image.";
                header("Location:../../view/backend/students/create.php");
            }

            if($file_type!="jpeg" && $file_type!="jpg" && $file_type!="png"){
                $create_suc = false;
                $_SESSION["UploadErr"] = "Sorry, only jpg, jpeg, png files are allowed.";
                header("Location:../../view/backend/students/create.php");
            }

            if(move_uploaded_file($_FILES["stuimg"]["tmp_name"], $file_path)){
                $create_suc = true;
                printf("True");
            }else{
                $create_suc = false;
                $_SESSION["UploadErr"] = "Error uploading file.";
                header("Location:../../view/backend/students/create.php");
            }

            if(!$create_suc){
                die("False");
            }else{
                try{
                    $con = new PDO(DB_DSN, DB_USN, DB_PW);
                    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $sql = "INSERT INTO students(name, birthdate, email, phone, address, level, photo, created_by, active, updated_at) VALUES(:stuname, :studob, :stumail, :stuph, :stuaddr, :stulevel, :stuimg, :created_by, :active, :updated_at)";
                    $stmt = $con->prepare($sql);
                    $stmt->bindValue(":stuname", $this->name, PDO::PARAM_STR);
                    $stmt->bindValue(":studob", $this->dob, PDO::PARAM_STR);
                    $stmt->bindValue(":stumail", $this->email, PDO::PARAM_STR);
                    $stmt->bindValue(":stuph", $this->phone, PDO::PARAM_STR);
                    $stmt->bindValue(":stuaddr", $this->addr, PDO::PARAM_STR);
                    $stmt->bindValue(":stulevel", $this->level, PDO::PARAM_STR);
                    $stmt->bindValue(":stuimg", $this->image, PDO::PARAM_STR);
                    $stmt->bindValue(":created_by", $this->created_by, PDO::PARAM_STR);
                    $stmt->bindValue(":active", $this->active, PDO::PARAM_INT);
                    $stmt->bindValue(":updated_at", $this->updated_at, PDO::PARAM_STR);
                    $stmt->execute();
                    header("Location:../../view/backend/students/index.php");
                }
                catch(PDOException $e){
                    echo $e->getMessage();
                }
                $con = null;
            }
        }

        public function update(){
            // printf($this->level);
            $update_suc = true;
            if($this->email != null){
                if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)){
                    $update_suc = false;
                }
            }
            if(strlen($this->phone)!=11){
                $update_suc = false;
            }
            if(!$update_suc){
                die("False");
            }else{
                try{
                    $con = new PDO(DB_DSN, DB_USN, DB_PW);
                    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $sql = "UPDATE students SET name=:stuname, birthdate=:studob, email = :stumail, phone=:stuph, address=:stuaddr, level=:stulevel, updated_at=:updated_at WHERE id= $this->id";
                    $stmt = $con->prepare($sql);
                    $stmt->bindValue(":stuname", $this->name, PDO::PARAM_STR);
                    $stmt->bindValue(":studob", $this->dob, PDO::PARAM_STR);
                    $stmt->bindValue(":stumail", $this->email, PDO::PARAM_STR);
                    $stmt->bindValue(":stuph", $this->phone, PDO::PARAM_STR);
                    $stmt->bindValue(":stuaddr", $this->addr, PDO::PARAM_STR);
                    $stmt->bindValue(":stulevel", $this->level, PDO::PARAM_STR);
                    $stmt->bindValue(":updated_at", $this->updated_at, PDO::PARAM_STR);
                    $stmt->execute();
                    header("Location:../../view/backend/students/index.php");
                }
                catch(PDOException $e){
                    echo $e->getMessage();
                }
                $con = null;
            }
            
        }
        public function delete(){
            if($_SESSION["id"]){
                try{
                    $con = new PDO(DB_DSN, DB_USN, DB_PW);
                    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $sql = "UPDATE students SET active=:active, deleted_at=:deleted_at WHERE id=$this->id";
                    $stmt = $con->prepare($sql);
                    $stmt->bindValue(":active", null, PDO::PARAM_INT);
                    $stmt->bindValue(":deleted_at", $this->updated_at, PDO::PARAM_INT);
                    $stmt->execute();
                    header("Location:../../view/backend/students/index.php");
                }
                catch(PDOException $e){
                    echo $e->getMessage();
                }
                $con = null;
            }else{
                $_SESSION["LoginErr"] = "Please Sign In.";
                header("Location:../../view/backend/login.php");
            }
        }
    }
    if(isset($_POST["create_stu"])){
        $stu = new Student;
        $stu->reg_value($_POST);
        $stu->create($_POST);
    }

    if(isset($_POST["edit"])){
        $stu = new Student;
        $stu -> reg_value($_POST);
        $stu->update($_POST);
    }

    if(isset($_POST["delete"])){
        $stu = new Student;
        $stu->reg_value($_POST);
        $stu->delete($_POST);
    }
?>