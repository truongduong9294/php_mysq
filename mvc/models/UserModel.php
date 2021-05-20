<?php
    class UserModel extends DB{
        public function listUser($page_in){
            $paginate = [];
            $query = "SELECT * FROM user";
            $rows = mysqli_query($this->con,$query);
            $count = mysqli_num_rows($rows);
            $num_per_page = 2;
            $pages = ceil($count/$num_per_page);
            $start = ($page_in*$num_per_page) - $num_per_page;
            $sql = "SELECT * FROM user LIMIT $start,$num_per_page";
            $querytext = mysqli_query($this->con,$sql);
            $paginate['listUser'] = $querytext;
            $paginate['num_per_page'] = $pages;
            return $paginate;
        }

        public function checkUsername($user_name){
            $query = "SELECT id FROM user WHERE user_name = '$user_name'";
            $rows = mysqli_query($this->con,$query);
            $result = false;
            if(mysqli_num_rows($rows) > 0){
                $result = true;
            }
            return json_decode($result);
        }

        public function addUser($user){
            $user_name = $user['user_name'];
            $password = $user['password'];
            $full_name = $user['full_name'];
            $avatar = $user['avatar'];
            $role_id = $user['role_id'];
            $email = $user['email'];
            $query = "INSERT INTO user VALUES(null,'$user_name','$password','$full_name','$avatar','$role_id','$email')";
            $result = false;
            if(mysqli_query($this->con,$query)){
                $result = true;
            }
            return json_decode($result);
        }

        public function findUser($user) {
            $query = "SELECT * from user WHERE id = '$user'";
            $result = mysqli_query($this->con,$query);
            while($row = $result->fetch_assoc()){
                $data_user = $row;
            }
            return $data_user;
        }

        public function deleteUser($user) {
            $query = "DELETE FROM user WHERE id = '$user'";
            $result = false;
            if(mysqli_query($this->con,$query)){
                $result = true;
            }
            return json_decode($result);
        }

        public function editUser($data_user){
            $user_id = $data_user['id'];
            $user_name = $data_user['user_name'];
            $password = $data_user['password'];
            $full_name = $data_user['full_name'];
            $avatar = $data_user['avatar'];
            $role_id = $data_user['role_id'];
            $email = $data_user['email'];
            $query = "UPDATE user SET user_name ='$user_name', password = '$password', full_name = '$full_name', avatar = '$avatar', role_id = '$role_id', email = '$email' WHERE id = '$user_id'";
            $result = false;
            if(mysqli_query($this->con,$query)){
                $result = true;
            }
            return json_decode($result);
        }

        public function loginUser($user){
            $user_name = $user['user_name'];
            $password = $user['password'];
            $query = "SELECT * FROM user WHERE user_name = '$user_name' AND password = '$password'";
            $rows = mysqli_query($this->con,$query);
            $row = [];
            if(mysqli_num_rows($rows) > 0){
                $row = mysqli_fetch_array($rows);
            }
            return $row;
        }

        public function insertToken($token,$emailTo){
            $result = false;
            $query = "INSERT INTO password_resets VALUES(null,'$emailTo','$token')";
            if(mysqli_query($this->con,$query)){
                $result = true;
            }
            return json_decode($result);
        }

        public function checkToken($token){
            $query = "SELECT email FROM password_resets WHERE token = '$token'";
            $result = mysqli_query($this->con,$query);
            if(mysqli_num_rows($result) > 0) {
                while($row = $result->fetch_assoc()){
                    $email = $row;
                }
                return $email;
            }else{
                return false;
            }
        }

        public function passwordReset($email,$password){
            $query = "UPDATE user SET password ='$password' WHERE email ='$email' ";
            $result = false;
            if(mysqli_query($this->con,$query)){
                $result = true;
            }
            return json_decode($result);
        }

        public function deleteToken($token){
            $query = "DELETE FROM password_resets WHERE token = '$token'";
            $result = false;
            if(mysqli_query($this->con,$query)){
                $result = true;
            }
            return json_decode($result);
        }
    }
?>