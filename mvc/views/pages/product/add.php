<section class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1>Add Product</h1>
        </div>
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">General Form</li>
        </ol>
        </div>
    </div>
    </div>
</section>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-9">
                <div class="card card-primary">
                    <form action="addProductProcess" method="POST" onsubmit="return validateForm()" enctype="multipart/form-data" name="formProduct">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="username" class="cols-sm-2 control-label">Category Name</label>
                                <div class="cols-sm-10">
                                    <select name="category_id" id="" class="form-control">
                                    <?php
                                        while($row = $data['listCategory']->fetch_assoc()){ 
                                    ?>
                                        <option value="<?php echo $row['id'] ?>"><?Php echo $row['category_name'] ?></option>
                                    <?php
                                        } 
                                    ?>
                                    </select>
                                </div>
                            </div>
                            <span id="error_category" style="color:red;"></span>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                            <label for="exampleInputEmail1">Product Name</label>
                            <input type="text" class="form-control" id="product_name" name="product_name" placeholder="Enter Product Name">
                            </div>
                            <span id="error_product" style="color:red;"></span>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                            <label for="exampleInputEmail1">price</label>
                            <input type="text" class="form-control" id="price" name="price" placeholder="Enter Price">
                            </div>
                            <span id="error_price" style="color:red;"></span>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                            <label for="exampleInputEmail1">Picture</label>
                            <input type="file" class="form-control" id="avatar" name="avatar" placeholder="Enter email">
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    function validateForm() {
        var flag = true;
        var product_name = document.forms["formProduct"]["product_name"].value;
        var price = document.forms["formProduct"]["price"].value;
        if(product_name == "") {
            document.getElementById("error_product").innerHTML = "product_name must not be left blank";
            flag =  false;
        }else if(product_name.length < 5) {
            document.getElementById("error_product").innerHTML = "product_name cannot be less than 5 character";
            flag =  false;
        }
        if(price == "") {
            document.getElementById("error_price").innerHTML = "price must not be left blank";
            flag =  false;
        }else if (price < 0) {
            document.getElementById("error_price").innerHTML = "price cannot be negative";
            flag =  false;
        }
        return flag;
    }
</script>