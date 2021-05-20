<?php
    class RoleModel extends DB{
        public function listRole($page_in){
            $paginate = [];
            $query = "SELECT * FROM role";
            $rows = mysqli_query($this->con,$query);
            $count = mysqli_num_rows($rows);
            $num_per_page = 2;
            $pages = ceil($count/$num_per_page);
            $start = ($page_in*$num_per_page) - $num_per_page;
            $sql = "SELECT * FROM role LIMIT $start,$num_per_page";
            $querytext = mysqli_query($this->con,$sql);
            $paginate['listRole'] = $querytext;
            $paginate['num_per_page'] = $pages;
            return $paginate;
        }

        public function roleList() {
            $query = "SELECT * FROM role";
            $rows = mysqli_query($this->con,$query);
            return $rows;
        }

        public function addRole($role){
            $query = "INSERT INTO role VALUES(null,'$role')";
            $result = false;
            if(mysqli_query($this->con,$query)){
                $result = true;
            }
            return json_decode($result);
        }

        public function findRole($role_id) {
            $query = "SELECT * from role WHERE id = '$role_id'";
            $result = mysqli_query($this->con,$query);
            while($row = $result->fetch_assoc()){
                $data_role = $row;
            }
            return $data_role;
        }

        public function editRole($role_id,$role_name){
            $query = "UPDATE role SET role_name ='$role_name' WHERE id = '$role_id'";
            $result = false;
            if(mysqli_query($this->con,$query)){
                $result = true;
            }
            return json_decode($result);
        }

        public function deleteRole($role) {
            $query = "DELETE FROM role WHERE id = '$role'";
            $result = false;
            if(mysqli_query($this->con,$query)){
                $result = true;
            }
            return json_decode($result);
        }

        public function checkUser(){
            $check_user = [];
            $query = "SELECT DISTINCT(role.id) FROM role INNER JOIN user ON role.id = user.role_id";
            $result = mysqli_query($this->con,$query);
            while($row = $result->fetch_array()){
                array_push($check_user,$row['id']);
            }
            return $check_user;
        }
    }
?>