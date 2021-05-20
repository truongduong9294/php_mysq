<?php
    class ProductModel extends DB{
        public function getList($page_in){
            $paginate = [];
            $query = "SELECT *,category.category_name AS category_name,product.id as product_id FROM product INNER JOIN category ON product.category_id = category.id";
            $rows = mysqli_query($this->con,$query);
            $count = mysqli_num_rows($rows);
            $num_per_page = 2;
            $pages = ceil($count/$num_per_page);
            $start = ($page_in*$num_per_page) - $num_per_page;
            $sql = "SELECT *,category.category_name AS category_name,product.id as product_id FROM product INNER JOIN category ON product.category_id = category.id LIMIT $start,$num_per_page";
            $querytext = mysqli_query($this->con,$sql);
            $paginate['listProduct'] = $querytext;
            $paginate['num_per_page'] = $num_per_page;
            return $paginate;
        }

        public function addProduct($product){
            $category_id = $product['category_id'];
            $product_name = $product['product_name'];
            $price = $product['price'];
            $picture = $product['picture'];
            $query = "INSERT INTO product VALUES(null,'$category_id','$product_name','$picture','$price')";
            $result = false;
            if(mysqli_query($this->con,$query)){
                $result = true;
            }
            return json_decode($result);
        }

        public function findProduct($product_id){
            $query = "SELECT *,product.id AS product_id,category.category_name AS category_name from product  INNER JOIN category ON product.category_id = category.id WHERE product.id = '$product_id'";
            $result = mysqli_query($this->con,$query);
            while($row = $result->fetch_assoc()){
                $data_category = $row;
            }
            return $data_category;
        }

        public function editProduct($data_product){
            $product_id = $data_product['id'];
            $category_id = $data_product['category_id'];
            $product_name = $data_product['product_name'];
            $price = $data_product['price'];
            $picture = $data_product['picture'];
            $query = "UPDATE product SET category_id ='$category_id', product_name = '$product_name', picture = '$picture', price = '$price' WHERE id = '$product_id'";
            $result = false;
            if(mysqli_query($this->con,$query)){
                $result = true;
            }
            return json_decode($result);
        }

        public function deleteProduct($product) {
            $query = "DELETE FROM product WHERE id = '$product'";
            $result = false;
            if(mysqli_query($this->con,$query)){
                $result = true;
            }
            return json_decode($result);
        }
    }
?>