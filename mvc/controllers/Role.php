<?php
    class Role extends Controller{
        function listRole(){
            $url = $_SERVER['REQUEST_URI'];
            $parts = parse_url($url);
            if(array_key_exists('query', $parts)){
                parse_str($parts['query'], $query);
                $page_in = (int)$query['page'];
            }else {
                $page_in = 1;
            }
            $roleModel = $this->model("RoleModel");
            $paginate = $roleModel->listRole($page_in);
            $check_user = $roleModel->checkUser();
            $this->view('master',['page' => 'role/list','paginate' => $paginate, 'page_in' => $page_in, 'check_user' => $check_user]);
        }

        function editRole($role_id){
            $roleModel = $this->model("RoleModel");
            $role = $roleModel->findRole($role_id);
            $this->view('master',['page' => 'role/edit','role' => $role]);
        }

        function editRoleProcess($role){
            $roleModel = $this->model("RoleModel");
            $role = $roleModel->findRole($role);
            if(isset($_POST['submit'])){
                $role_id = $role['id'];
                $role_name = $_POST['role_name'];
            }
            if($roleModel->editRole($role_id,$role_name)){
                $_SESSION['message'] = 'Edit Role Success';
                header("Location: /Role/listRole");
            }
        }

        function deleteRole($role){
            $roleModel = $this->model("RoleModel");
            $role_delete = $roleModel->findRole($role);
            if($role_delete){
                if($roleModel->deleteRole($role)){
                    $_SESSION['message'] = 'Delete Role Success';
                    header("Location: /Role/listRole");
                }
            }
        }

        function addRole(){
            $this->view('master',['page' => 'Role/add']);
        }

        function addRoleProcess(){
            $roleModel = $this->model("RoleModel");
            if(isset($_POST['submit'])){
                $role_name = $_POST['role_name'];
            }
            $role = $roleModel->addRole($role_name);
            if($role){
                $_SESSION['message'] = 'Add Role Success';
                header("Location: /Role/listRole");
            }
        }
    }
?>