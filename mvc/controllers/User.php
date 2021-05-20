<?php
    require './PHPMailer/PHPMailer.php';
    require './PHPMailer/SMTP.php';
    require './PHPMailer/Exception.php';

    class User extends Controller{
        public function register(){
            $roleModel = $this->model("RoleModel");
            $listRole = $roleModel->roleList();
            $this->view('pages/register',['listRole' => $listRole]);
        }

        public function listUser(){
            $url = $_SERVER['REQUEST_URI'];
            $parts = parse_url($url);
            if(array_key_exists('query', $parts)){
                parse_str($parts['query'], $query);
                $page_in = (int)$query['page'];
            }else {
                $page_in = 1;
            }
            $userModel = $this->model("UserModel");
            $paginate = $userModel->listUser($page_in);
            $this->view('master',['page' => 'user/list','paginate' => $paginate, 'page_in' => $page_in]);
        }

        public function registerProcess(){
            $userModel = $this->model("UserModel");
            $user = [];
            if(isset($_POST['register'])){
                $user['user_name'] = $_POST['user_name'];
                $user['email'] = $_POST['email'];
                $user['full_name'] = $_POST['full_name'];
                $user['password'] = $_POST['password'];
                $user['role_id'] = $_POST['role_id'];
                $image = explode('.', $_FILES['avatar']['name']);
                $name_image = $image[0].'-'.time().'.'.$image[1];
                $user['avatar'] = $name_image;
            }
            $check_user = $userModel->checkUsername($user['user_name']);
            if($check_user) {
                echo "Username already exists";
            }else {
                $target_dir = "uploads/";
                $target_file = $target_dir . basename($user['avatar']);
                $uploadOk = 1;
                $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                if(isset($_POST["submit"])) {
                    $check = getimagesize($_FILES["avatar"]["tmp_name"]);
                    if($check !== false) {
                        echo "File is an image - " . $check["mime"] . ".";
                        $uploadOk = 1;
                    }else {
                        echo "File is not an image.";
                        $uploadOk = 0;
                    }
                }
                if (file_exists($target_file)) {
                    echo "Sorry, file already exists.";
                    $uploadOk = 0;
                }
                  
                  // Check file size
                if ($_FILES["avatar"]["size"] > 500000) {
                    echo "Sorry, your file is too large.";
                    $uploadOk = 0;
                }
                  
                // Allow certain file formats
                if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                    && $imageFileType != "gif" ) {
                    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                    $uploadOk = 0;
                }
                  
                  // Check if $uploadOk is set to 0 by an error
                if ($uploadOk == 0) {
                    echo "Sorry, your file was not uploaded.";
                    // if everything is ok, try to upload file
                    } else {
                    if (move_uploaded_file($_FILES["avatar"]["tmp_name"], $target_file)) {
                        echo "The file ". htmlspecialchars( basename( $_FILES["avatar"]["name"])). " has been uploaded.";
                    } else {
                    echo "Sorry, there was an error uploading your file.";
                    }
                }
                $user = $userModel->addUser($user);
                if($user){
                    $_SESSION['message'] = 'Register Success';
                    header("Location: /User/listUser");
                }
            }
        }
        
        public function deleteUser($user) {
            $userModel = $this->model("UserModel");
            $user_delete = $userModel->findUser($user);
            if($user_delete){
                $avatar = $user_delete['avatar'];
                unlink("uploads/".$avatar);
                if($userModel->deleteUser($user)){
                    $_SESSION['message'] = 'Delete User Success';
                    header("Location: /User/listUser");
                }
            }
        }

        public function editUser($user){
            $roleModel = $this->model("RoleModel");
            $listRole = $roleModel->roleList();
            $userModel = $this->model("UserModel");
            $user = $userModel->findUser($user);
            $this->view('pages/user/edit',['listRole' => $listRole,'user' => $user]);
        }

        public function editUserProcess($user){
            $userModel = $this->model("UserModel");
            $user_edit = $userModel->findUser($user);
            $data_user = [];
            if(isset($_POST['register'])){
                $data_user['id'] = $user;
                $data_user['user_name'] = $_POST['user_name'];
                $data_user['email'] = $_POST['email'];
                $data_user['full_name'] = $_POST['full_name'];
                $data_user['password'] = $_POST['password'];
                if($_POST['password']) {
                    $data_user['password'] = $_POST['password'];
                }else{
                    $data_user['password'] = $user_edit['password'];
                }
                $data_user['role_id'] = $_POST['role_id'];
                if($_FILES['avatar']['name']){
                    $image = explode('.', $_FILES['avatar']['name']);
                    $name_image = $image[0].'-'.time().'.'.$image[1];
                    $data_user['avatar'] = $name_image;
                }else{
                    $data_user['avatar'] = $user_edit['avatar'];
                }
            }
            if($user_edit){
                $target_dir = "uploads/";
                $target_file = $target_dir . basename($data_user['avatar']);
                $uploadOk = 1;
                $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                if(isset($_POST["submit"])) {
                    $check = getimagesize($_FILES["avatar"]["tmp_name"]);
                    if($check !== false) {
                        echo "File is an image - " . $check["mime"] . ".";
                        $uploadOk = 1;
                    }else {
                        echo "File is not an image.";
                        $uploadOk = 0;
                    }
                }
                if (file_exists($target_file)) {
                    echo "Sorry, file already exists.";
                    $uploadOk = 0;
                }
                  
                  // Check file size
                if ($_FILES["avatar"]["size"] > 500000) {
                    echo "Sorry, your file is too large.";
                    $uploadOk = 0;
                }
                  
                // Allow certain file formats
                if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                    && $imageFileType != "gif" ) {
                    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                    $uploadOk = 0;
                }
                  
                  // Check if $uploadOk is set to 0 by an error
                if ($uploadOk == 0) {
                    echo "Sorry, your file was not uploaded.";
                    // if everything is ok, try to upload file
                    } else {
                    if (move_uploaded_file($_FILES["avatar"]["tmp_name"], $target_file)) {
                        echo "The file ". htmlspecialchars( basename( $_FILES["avatar"]["name"])). " has been uploaded.";
                    } else {
                    echo "Sorry, there was an error uploading your file.";
                    }
                }
                if($userModel->editUser($data_user)){
                    $avatar = $user_edit['avatar'];
                    unlink("uploads/".$avatar);
                    $_SESSION['message'] = 'Edit User Success';
                    header("Location: /User/listUser");
                }
            }
        }

        public function login(){
            $this->view('pages/login');
        }

        public function loginProcess(){
            $userModel = $this->model("UserModel");
            $user = [];
            if(isset($_POST['login'])){
                $user['user_name'] = $_POST['user_name'];
                $user['password'] = $_POST['password'];
            }
            $user_logined = $userModel->loginUser($user);
            if($user_logined){
                $_SESSION['user_name'] = $user_logined['user_name'];
                switch($user_logined['role_id']) {
                    case "1":
                        header("Location: /User/listUser");
                        break;
                    default:
                        echo "hiển thị trang user";
                }
            }else {
                header("Location: /User/login");
            }
        }

        public function logout(){
            session_start();
            unset($_SESSION["user_name"]);
            unset($_SESSION["role_id"]);
            header("Location: /User/login");
        }

        public function resetPassword(){
            $this->view('pages/check_email');
        }

        public function resetPasswordProcess(){
            if(isset($_POST['email'])){
                $emailTo = $_POST['email'];
                $token = uniqid();
                $userModel = $this->model("UserModel");
                $insertToken = $userModel->insertToken($token,$emailTo);
                $mail = new PHPMailer\PHPMailer\PHPMailer(true);
                try {                
                    $mail->SMTPDebug = 2;                                 // Enable verbose debug output
                    $mail->isSMTP();                                      // Set mailer to use SMTP
                    $mail->Host = 'ssl://smtp.gmail.com';  // Specify main and backup SMTP servers
                    $mail->SMTPAuth = true;                               // Enable SMTP authentication
                    $mail->Username = '';                 // SMTP username
                    $mail->Password = '';                           // SMTP password
                    $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
                    $mail->Port = 465;                                    // TCP port to connect to
                
                    //Recipients
                    $mail->setFrom('', 'Mailer');
                    $mail->addAddress($emailTo, 'Joe User');     // Add a recipient
                    //Content
                    $url = "http://".$_SERVER['HTTP_HOST']."/User/resetForm/$token";
                    $mail->isHTML(true);                                  // Set email format to HTML
                    $mail->Subject = 'Your password reset link';
                    $mail->Body    = "<h1>Your requested a password reset</h1> Click <a href='$url'>This link </a>";
                    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
                    $mail->send();
                    echo 'Message has been sent';
                }catch (Exception $e) {
                    echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
                }
            }
        }
        public function resetForm($token){
            $userModel = $this->model("UserModel");
            $email = $userModel->checkToken($token);
            if($email) {
                $delete_token = $userModel->deleteToken($token);
                $this->view('pages/resetform',['email' => $email['email']]);
            }else{
                echo "token has been delete";
            }
        }

        public function changePassword($email){
            $userModel = $this->model("UserModel");
            $password = $_POST['password'];
            $password_reset = $userModel->passwordReset($email,$password);
            if($password_reset){
                header("Location: /User/listUser");
            }else {
                header("Location: /User/login");
            }
        }
    }
?>