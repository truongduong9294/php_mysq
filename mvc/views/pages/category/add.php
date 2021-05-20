<section class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1>Add Category</h1>
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
                    <form action="addCategoryProcess" onsubmit="return validateForm()" method="POST" name="formCategory">
                        <div class="card-body">
                            <div class="form-group">
                            <label for="exampleInputEmail1">Category Name</label>
                            <input type="text" class="form-control" id="category_name" name="category_name" placeholder="Enter email">
                            </div>
                            <span id="error_category" style="color:red;"></span>
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
        var category_name = document.forms["formCategory"]["category_name"].value;
        if (category_name == "") {
            document.getElementById("error_category").innerHTML = "category_name must not be left blank";
            flag =  false;
        }else if (category_name.length < 5) {
            document.getElementById("error_category").innerHTML = "category_name cannot be less than 5 character";
            flag =  false;
        }
        return flag;
    }
</script>