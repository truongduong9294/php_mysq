<?php
    class CategoryModel extends DB{
        public function getList($page_in){
            $paginate = [];
            $query = "SELECT * FROM category";
            $rows = mysqli_query($this->con,$query);
            $count = mysqli_num_rows($rows);
            $num_per_page = 2;
            $pages = ceil($count/$num_per_page);
            $start = ($page_in*$num_per_page) - $num_per_page;
            $sql = "SELECT * FROM category LIMIT $start,$num_per_page";
            $querytext = mysqli_query($this->con,$sql);
            $paginate['listCategory'] = $querytext;
            $paginate['num_per_page'] = $pages;
            return $paginate;
        }

        public function categoryList(){
            $query = "SELECT * FROM category";
            $rows = mysqli_query($this->con,$query);
            return $rows;
        }

        public function addCategory($category){
            $query = "INSERT INTO category VALUES(null,'$category')";
            $result = false;
            if(mysqli_query($this->con,$query)){
                $result = true;
            }
            return json_decode($result);
        }

        public function findCategory($category_id) {
            $query = "SELECT * from category WHERE id = '$category_id'";
            $result = mysqli_query($this->con,$query);
            while($row = $result->fetch_assoc()){
                $data_category = $row;
            }
            return $data_category;
        }

        public function editCategory($category_id,$category_name){
            $query = "UPDATE category SET category_name ='$category_name' WHERE id = '$category_id'";
            $result = false;
            if(mysqli_query($this->con,$query)){
                $result = true;
            }
            return json_decode($result);
        }

        public function deleteCategory($category) {
            $query = "DELETE FROM category WHERE id = '$category'";
            $result = false;
            if(mysqli_query($this->con,$query)){
                $result = true;
            }
            return json_decode($result);
        }

        public function checkProduct(){
            $check_product = [];
            $query = "SELECT DISTINCT(category.id) FROM category INNER JOIN product ON category.id = product.category_id";
            $result = mysqli_query($this->con,$query);
            while($row = $result->fetch_array()){
                array_push($check_product,$row['id']);
            }
            return $check_product;
        }
    }
?>