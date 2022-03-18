<?php
    require("../view/_inc/head.php");
    require("../view/_inc/header.php");
    include_once("checkLogin.php");
    
    
    if (isset($_POST['submit'])) {

      if ($_POST['uname']=="") {
          $erroruname = "Username is required";
        } 
        
        if ($_POST['pwd']==null) {
          $errorpwd = "Password is required";
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
            <h5 class="card-title text-center mb-5 fw-light fs-5">Sign In</h5>
            
            <form method="post">
              
              <div class="form-floating mb-3">
                <input type="email" class="form-control" name="uname" placeholder="name@example.com">
                <label for="floatingInput">Username</label>
                <span class="text-danger"><?php echo $erroruname; ?></span>

              </div>

              <div class="form-floating mb-3">
                <input type="password" class="form-control" id="password" name = "pwd" placeholder="Password">
                <label for="floatingPassword">Password</label>
                <span class="text-danger"><?php echo $errorpwd; ?></span>
                <span class="text-danger"><?php echo $invalidMesg; ?></span>


              </div>

              <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" value="rememberPassword" id="rememberPasswordCheck">
                <label class="form-check-label" for="rememberPasswordCheck">
                  Remember password
                </label>
              </div>

              <div class="d-grid text-center">
                <button type="submit" value="Login" name ="submit" class="btn btn-primary btn-login text-uppercase fw-bold">Sign
                  in</button>
              </div>
              </form>

              <hr class="my-4">
              <div class="d-grid mb-2 text-center">
                <a href="forgotPassword.php" class="btn btn-google btn-login text-uppercase fw-bold" type="submit">
                      Forgot password?</a>

                </button>
              </div>

              <div class="d-grid mb-2 text-center">
              <a href="UserCreation.php" class="btn btn-google btn-login text-uppercase fw-bold" type="submit">
                      Create Account</a>
              </div>

            
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