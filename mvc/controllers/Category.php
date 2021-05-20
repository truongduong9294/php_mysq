<?php
    class Category extends Controller{
        public function listCategory(){
            $url = $_SERVER['REQUEST_URI'];
            $parts = parse_url($url);
            if(array_key_exists('query', $parts)){
                parse_str($parts['query'], $query);
                $page_in = (int)$query['page'];
            }else {
                $page_in = 1;
            }
            $categoryModel = $this->model("CategoryModel");
            $paginate = $categoryModel->getList($page_in);
            $check_product = $categoryModel->checkProduct();
            $this->view('master',['page' => 'category/list','paginate' => $paginate, 'page_in' => $page_in, 'check_product' => $check_product]);
        }

        public function addCategory(){
            $this->view('master',['page' => 'category/add']);
        }

        public function addCategoryProcess(){
            $categoryModel = $this->model("CategoryModel");
            if(isset($_POST['submit'])){
                $category_name = $_POST['category_name'];
            }
            $category = $categoryModel->addCategory($category_name);
            if($category){
                $_SESSION['message'] = 'Add Category Success';
                header("Location: /Category/listCategory");
            }
        }

        public function editCategory($category_id){
            $categoryModel = $this->model("CategoryModel");
            $category = $categoryModel->findCategory($category_id);
            $this->view('master',['page' => 'category/edit','category' => $category]);
        }

        public function editCategoryProcess($category){
            $categoryModel = $this->model("CategoryModel");
            $category = $categoryModel->findCategory($category);
            if(isset($_POST['submit'])){
                $category_id = $category['id'];
                $category_name = $_POST['category_name'];
            }
            if($categoryModel->editCategory($category_id,$category_name)){
                $_SESSION['message'] = 'Edit Category Success';
                header("Location: /Category/listCategory");
            }
        }

        public function deleteCategory($category){
            $categoryModel = $this->model("CategoryModel");
            $category_delete = $categoryModel->findCategory($category);
            if($category_delete){
                if($categoryModel->deleteCategory($category)){
                    $_SESSION['message'] = 'Delete Category Success';
                    header("Location: /Category/listCategory");
                }
            }
        }
    }
?>