<?php 
include('../class/User.php');
$user = new User();
$user->adminLoginStatus();
include('include/header.php');
?>
<!-- Set the title -->
<title>pdo-admin</title>

<!-- Include CSS files -->
<link rel="stylesheet" href="css/dataTables.bootstrap.min.css" />
<link rel="stylesheet" href="css/style.css">

<!-- Include JavaScript files -->
<script src="js/jquery.dataTables.min.js"></script>
<script src="js/dataTables.bootstrap.min.js"></script>
<script src="js/users.js"></script>

<!-- Container -->
<div class="container contact">	
    <?php include 'menus.php'; ?>
    
    <!-- User list section -->
    <div class="col-lg-10 col-md-10 col-sm-9 col-xs-12">   
        <a href="#"><strong><span class="fa fa-dashboard"></span> User List</strong></a>
        <hr>		
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-10">
                    <h3 class="panel-title"></h3>
                </div>
                <div class="col-md-2" align="right">
                    <button type="button" name="add" id="addUser" class="btn btn-success btn-xs">Add</button>
                </div>
            </div>
        </div>
        
        <!-- User list table -->
        <table id="userList" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Gender</th>
                    <th>Email</th>
                    <th>Mobile</th>
                    <th>Role</th>					
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
        </table>
    </div>
    
    <!-- User modal -->
    <div id="userModal" class="modal fade">
        <div class="modal-dialog">
            <form method="post" id="userForm">
                <!-- Modal content -->
                <div class="modal-content">
                    <!-- Modal header -->
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title"><i class="fa fa-plus"></i> Edit User</h4>
                    </div>
                    
                    <!-- Modal body -->
                    <div class="modal-body">
                        <!-- Form fields -->
                        <div class="form-group">
                            <label for="firstname" class="control-label">First Name*</label>
                            <input type="text" class="form-control" id="firstname" name="firstname" placeholder="First Name" required>							
                        </div>
                        <!-- Other form fields -->
                        
                        <!-- Modal footer -->
                        <div class="modal-footer">
                            <input type="hidden" name="userid" id="userid" />
                            <input type="hidden" name="action" id="action" value="updateUser" />
                            <input type="submit" name="save" id="save" class="btn btn-info" value="Save" />
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include('include/footer.php');?>