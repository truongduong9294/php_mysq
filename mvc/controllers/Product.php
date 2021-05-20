<?php
    class Product extends Controller{
        public function listProduct(){
            $url = $_SERVER['REQUEST_URI'];
            $parts = parse_url($url);
            if(array_key_exists('query', $parts)){
                parse_str($parts['query'], $query);
                $page_in = (int)$query['page'];
            }else {
                $page_in = 1;
            }
            $productModel = $this->model("ProductModel");
            $paginate = $productModel->getList($page_in);
            $this->view('master',['page' => 'product/list','paginate' => $paginate, 'page_in' => $page_in]);
        }

        public function addProduct(){
            $categoryModel = $this->model("CategoryModel");
            $listCategory = $categoryModel->categoryList();
            $this->view('master',['page' => 'product/add','listCategory' => $listCategory]);
        }

        public function addProductProcess(){
            $productModel = $this->model("ProductModel");
            $product = [];
            if(isset($_POST['submit'])){
                $product['category_id'] = $_POST['category_id'];
                $product['product_name'] = $_POST['product_name'];
                $product['price'] = $_POST['price'];
                $image = explode('.', $_FILES['avatar']['name']);
                $name_image = $image[0].'-'.time().'.'.$image[1];
                $product['picture'] = $name_image;
            }
            $target_dir = "uploads/";
            $target_file = $target_dir . basename($product['picture']);
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
            $product = $productModel->addProduct($product);
            if($product){
                $_SESSION['message'] = 'Add Product Success';
                header("Location: /Product/listProduct");
            }
        }

        public function editProduct($product_id){
            $categoryModel = $this->model("CategoryModel");
            $listCategory = $categoryModel->categoryList();
            $productModel = $this->model("ProductModel");
            $product = $productModel->findProduct($product_id);
            $this->view('master',['page' => 'product/edit','product' => $product, 'listCategory' => $listCategory]);
        }

        public function editProductProcess($product){
            $productModel = $this->model("ProductModel");
            $product_edit = $productModel->findProduct($product);
            $data_product = [];
            $check_img = false;
            if(isset($_POST['submit'])){
                $data_product['id'] = $product;
                $data_product['category_id'] = $_POST['category_id'];
                $data_product['product_name'] = $_POST['product_name'];
                $data_product['price'] = $_POST['price'];
                if($_FILES['avatar']['name']){
                    $image = explode('.', $_FILES['avatar']['name']);
                    $name_image = $image[0].'-'.time().'.'.$image[1];
                    $data_product['picture'] = $name_image;
                    $check_img = true;
                }else{
                    $data_product['picture'] = $product_edit['picture'];
                }
            }
            
            if($product_edit){
                $target_dir = "uploads/";
                $target_file = $target_dir . basename($data_product['picture']);
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
                if($productModel->editProduct($data_product)){
                    if($check_img) {
                        $picture = $product_edit['picture'];
                        unlink("uploads/".$picture);
                    }
                    $_SESSION['message'] = 'Edit Product Success';
                    header("Location: /Product/listProduct");
                }
            }
        }

        public function deleteProduct($product){
            $productModel = $this->model("ProductModel");
            $product_delete = $productModel->findProduct($product);
            if($product_delete){
                $picture = $product_delete['picture'];
                unlink("uploads/".$picture);
                if($productModel->deleteProduct($product)){
                    $_SESSION['message'] = 'Delete Product Success';
                    header("Location: /Product/listProduct");
                }
            }
        }
    }
?>