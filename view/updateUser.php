<?php
    require("../view/_inc/head.php");
    require("../view/_inc/header.php");
    
        $m = new MongoDB\Driver\Manager('mongodb+srv://group1:fvAIyyCRp4PBaDPQ@clst01.to6hh.mongodb.net/projectDB?retryWrites=true&w=majority');
        $filter = [ 'Username' => $_GET['Username']]; 

        $query = new MongoDB\Driver\Query($filter);     
        $res = $m->executeQuery("projectDB.Users", $query);
         foreach($res as $row) {
            
                $usermame = $row->Username;
                $password = $row->Password ;
                $fname = $row->First_Name ;
                $lname = $row->Last_Name;
                $email = $row->Email_Address;
                $role = $row->Role;

            }  
    
    $allFields = "yes";
    $errUname = $errPass = $errFname = $errLname = $errEmail = $errRole = "";



    if (isset($_POST["submit"])){

        if ($_POST['username']==""){
            $errUname = "This field is mandatory";
            $allFields = "no";
        }
        if ($_POST['password']==null){
            $errPass = "This field is mandatory";
            $allFields = "no";
        }
        if ($_POST['fname']==""){
            $errFname = "This field is mandatory";
            $allFields = "no";
        }
        if ($_POST['lname']==""){
          $errLname = "This field is mandatory";
          $allFields = "no";
      }
      if ($_POST['email']==""){
          $errEmail = "This field is mandatory";
          $allFields = "no";
      }
      if ($_POST['role'] == "Role"){
          $errRole = "Please select a role";
          $allFields = "no";
      } 
      
      
  
      if($allFields == "yes")
      {


        $m = new MongoDB\Driver\Manager('mongodb+srv://group1:fvAIyyCRp4PBaDPQ@clst01.to6hh.mongodb.net/projectDB?retryWrites=true&w=majority');

        $filter = [ 'Username' => $_POST['username']]; 

        $query = new MongoDB\Driver\Query($filter);     
        $res = $m->executeQuery("projectDB.Users", $query);

        if (!count($res->toarray())){
            $b = new \MongoDB\Driver\BulkWrite;
            $filter = ["Username"=>$_GET['Username']];
            
            $b->update($filter, ['$set'=>["Username"=>$_POST['username']]], []);
            $b->update($filter, ['$set'=>["Password"=>$_POST['password']]], []);
            $b->update($filter, ['$set'=>["First_Name"=>$_POST['fname']]], []);
            $b->update($filter, ['$set'=>["Last_Name"=>$_POST['lname']]], []);
            $b->update($filter, ['$set'=>["Email_Address"=>$_POST['email']]], []);
            $b->update($filter, ['$set'=>["Role"=>$_POST['role']]], []);
    
    
            $res = $m->executeBulkWrite('projectDB.Users', $b);
            header("Location:manageUsers.php?Updated=True");
      }
          else {
            echo '<script type="text/javascript">toastr.error("Username already exists")</script>';

              
              }
      }

        

}
    
if (isset($_POST["delete"])){
  $b = new \MongoDB\Driver\BulkWrite;
  $filter = ["Username"=>$_GET['Username']];
  $b->delete($filter, []);

  $res = $m->executeBulkWrite('projectDB.Users', $b);
  header("Location:manageUsers.php?Deleted=true");


} 
?>

         


<div class="main">    
    <div class="inner_main">
    <section class="vh-100">
<body>
  
<div class="container">
  <div class="row">
    <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
      <div class="card border-0 shadow rounded-3 my-5">
        <div class="card-body p-4 p-sm-5">
          <h5 class="card-title text-center mb-5 fw-light fs-5">Update User</h5>

          <form method="post">
            <div class="form-floating mb-3">
              <input type="text" class="form-control" id="username" placeholder="Username" name="username" value = "<?php echo $usermame?>">
              <label for="floatingInput">Username</label>
              <span class="text-danger"><?php echo $errUname; ?></span>

            </div>

            <div class="form-floating mb-3">
              <input type="text" class="form-control" id="password" placeholder="password" name="password" value = "<?php echo $password?>">
              <label for="floatingInput">Password</label>
              <span class="text-danger"><?php echo $errPass; ?></span>


              
            </div>    
            
            <div class="form-floating mb-3">
              <input type="text" class="form-control" id="fname" placeholder="fname" name="fname" value = "<?php echo $fname?>">
              <label for="floatingPassword">First Name</label>
              <span class="text-danger"><?php echo $errFname; ?></span>

            </div>

            <div class="form-floating mb-3">
              <input type="text" class="form-control" id="lname" placeholder="lname" name="lname" value = "<?php echo $lname?>">
              <label for="floatingPassword">Last Name</label>
              <span class="text-danger"><?php echo $errLname; ?></span>

            </div>

            <div class="form-floating mb-3">
              <input type="email" class="form-control" id="email" placeholder="email" name="email" value = "<?php echo $email?>">
              <label for="floatingInput">Email Address</label>
              <span class="text-danger"><?php echo $errEmail; ?></span>

            </div>

            <select class="form-select" aria-label="Default select example"  name="role">
            <option selected><?php echo $role?></option>
            <?php if ($role == "Admin"){
                echo '
                <option value="Engineer">Engineer</option>
                <option value="Manager">Project Manager</option>';
            }
            else if ($role == "Engineer"){
                echo '<option value="Admin">Admin</option>
                <option value="Manager">Project Manager</option>';
            }
            else {
                echo '<option value="Admin">Admin</option>
                <option value="Engineer">Engineer</option>';
            }
            ?>
            
            </select>
            <span class="text-danger"><?php echo $errRole; ?></span>

            <hr class="my-4">
            
            <div class="d-grid text-center">
              <button class="  btn btn-primary btn-login text-uppercase fw-bold" type="submit" name="submit"> Update User</button>
            </div><br>
            <div class="d-grid text-center">
              <button class="  btn btn-primary btn-login text-uppercase fw-bold" type="delete" name="delete" onclick="return confirm('Are you sure you wish to delete?')">Delete User</button>
            </div><br>
            <div class="d-grid text-center">
              <a href = "manageUsers.php" class="  btn btn-secondary btn-login text-uppercase fw-bold" type="submit" >Return To Users</a>
            </div>
          </form>

        </div>
      </div>
    </div>
  </div>
</div>
</body>
</div>
</div>
</section>

<?php
    require("../view/_inc/footer.php");
?>