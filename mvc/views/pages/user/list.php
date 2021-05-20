<section class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1>List User</h1>
        </div>
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <a class="btn btn-primary" href="register">Add</a>
        </ol>
        </div>
    </div>
    </div><!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
    <div class="row">
        <div class="col-12">
        <div class="card">
            <div class="card-header">
            <h3 class="card-title">DataTable with minimal features & hover style</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="example2" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Fullname</th>
                            <th>Email</th>
                            <th>Avatar</th>
                            <th colspan="2">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        while($row = $data['paginate']['listUser']->fetch_assoc()){
                    ?>
                        <tr>
                            <td><?php echo $row['id'] ?></td>
                            <td><?php echo $row['user_name'] ?></td>
                            <td><?php echo $row['full_name'] ?></td>
                            <td><?php echo $row['email'] ?></td>
                            <td><img src="<?php echo '../uploads/'.$row['avatar'] ?>" alt="" style="width: 50%;"></td>
                            <td><a href="editUser/<?php echo $row['id'];?>">Edit</a></td>
                            <td>
                                <a onclick="return confirm('Are you want to delete?')" href="deleteUser/<?php echo $row['id'] ?>">Delete</a>
                            </td>
                        </tr>
                    <?php
                        }
                     ?>
                    </tbody>
                </table>
                <nav aria-label="Page navigation example" style="margin-top: 30px;">
                    <ul class="pagination">
                        <?php
                            if($data['page_in'] > 1) {
                                $previous = $data['page_in'] - 1;
                            }else {
                                $previous = 1;
                            }
                            if($data['page_in'] >= $data['paginate']['num_per_page']){
                                $next = 1;
                            }else {
                                $next = $data['page_in'] + 1;
                            }
                         ?>
                        <li class="page-item"><a class="page-link" href="listUser?page=<?php echo $previous ?>">Previous</a></li>
                        <?php
                             for($i = 1; $i<= $data['paginate']['num_per_page']; $i++) {
                        ?>
                            <li class="page-item"><a class="page-link" href="listUser?page=<?php echo $i ?>"><?php echo $i ?></a></li>
                        <?php } ?>
                        <li class="page-item"><a class="page-link" href="listUser?page=<?php echo $next ?>">Next</a></li>
                    </ul>
                </nav>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</section>