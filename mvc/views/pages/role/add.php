<section class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1>Add Role</h1>
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
                    <form action="addRoleProcess" method="POST" onsubmit="return validateForm()" name="formRole">
                        <div class="card-body">
                            <div class="form-group">
                            <label for="exampleInputEmail1">Role Name</label>
                            <input type="text" class="form-control" id="role_name" name="role_name" placeholder="Enter Role ">
                            </div>
                            <span id="error_role" style="color:red;"></span>
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
        var role_name = document.forms["formRole"]["role_name"].value;
        if (role_name == "") {
            document.getElementById("error_role").innerHTML = "role_name must not be left blank";
            flag =  false;
        }else if (role_name.length < 5) {
            document.getElementById("error_role").innerHTML = "role_name cannot be less than 5 character";
            flag =  false;
        }
        return flag;
    }
</script>