<?php
    require("../view/_inc/head.php");
    require("../view/_inc/header.php");

    $missingPassword = $missingPasswordConfirm = $passwordMismatch = "";

    if (isset($_POST['submit'])) {

      if ($_POST['password']=="" || $_POST['confirmPassword']=="") {
        echo '<script type="text/javascript">toastr.error("Missing fields")</script>';
      } 

      if ($_POST['password'] != $_POST['confirmPassword']) {
        echo '<script type="text/javascript">toastr.error("Password mismatch")</script>';
      }
      else {
        if  ($_POST['password']!=null && $_POST['confirmPassword']!=null){

          $m = new MongoDB\Driver\Manager('mongodb+srv://group1:fvAIyyCRp4PBaDPQ@clst01.to6hh.mongodb.net/projectDB?retryWrites=true&w=majority');

          $filter = [ 'Password_Hash' => $_GET['hash']]; 
          $query = new MongoDB\Driver\Query($filter);     
          $res = $m->executeQuery("projectDB.Users", $query);

          if (!count($res->toarray())){
            echo '<script type="text/javascript">toastr.error("Unable to update password")</script>';
          }
          else {
            $b = new \MongoDB\Driver\BulkWrite;
            $filter = ["Email_Address"=>$_GET['email']];
            
            $b->update($filter, ['$set'=>["Password"=>$_POST['password']]], []);
            $b->update($filter, ['$set'=>["Password_Hash"=>""]], []);
            $res = $m->executeBulkWrite('projectDB.Users', $b);

            header("Location: index.php?passwordUpdated=true");            
          }    

        }
      }
    }
     
?>

<script>
function toggleVisibility() {
  var x = document.getElementById("password");
  var y = document.getElementById("confirmPassword");
  if (x.type === "password" || y.type === "password") {
    x.type = "text";
    y.type = "text";
  } else {
    x.type = "password";
    y.type = "password";
  }
}
</script>

<div class="main">
    <div class="inner_main">

    <section class="vh-100">
    <body>
  <div class="container">
    <div class="row">
      <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
        <div class="card border-0 shadow rounded-3 my-5">
          <div class="card-body p-4 p-sm-5">
            <h5 class="card-title text-center mb-5 fw-light fs-5">Set A New Password</h5>
            <form method="post">
              
              <div class="form-floating mb-3">
                <input type="password" class="form-control" id="password" name="password" placeholder="New Password">
                <label for="floatingInput">New Password</label>
                <span class="text-danger"><?php echo $missingPassword; ?></span>
              </div>

              <div class="form-floating mb-3">
                <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Confirm Password">
                <label for="floatingInput">Confirm Password</label>
                <span class="text-danger"><?php echo $missingPasswordConfirm; ?></span>
                <span class="text-danger"><?php echo $passwordMismatch; ?></span>
              </div>

              <input type="checkbox" onclick="toggleVisibility()"> Show Passwords

              <hr class="my-4">

              <div class="d-grid text-center">
                <button class="btn btn-primary btn-success text-uppercase fw-bold" name="submit" type="submit">Update Password</button>
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