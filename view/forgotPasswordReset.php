<?php
    require("../view/_inc/head.php");
    require("../view/_inc/header.php");

    $missingPassword = $missingPasswordConfirm = "";
    
    if (isset($_POST['submit'])) {

      if ($_POST['password']=="") {
          $missingPassword = "Password is required";
      } 

      if ($_POST['confirmPassword']=="") {
        $missingPasswordConfirm = "Please confirm your password";
    } 

      if  ($_POST['password']!=null && $_POST['confirmPassword']!=null){
        echo "Password Reset Function Here";
      }
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
              </div>

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