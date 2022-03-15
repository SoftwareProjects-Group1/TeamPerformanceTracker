<?php
    require("../view/_inc/head.php");
    require("../view/_inc/header.php");
?>
<div class="main">
    <div class="inner_main">

    <section class="vh-100">
  <div class="container-fluid h-custom">
    <div class="row d-flex justify-content-center align-items-center h-100">
        
        <form>
          <div class="divider d-flex align-items-center my-4">
            <p class="text-center fw-bold mx-3 mb-0"></p>
          </div>

          <!-- Email input -->
          <div class="form-outline mb-4 ">
          <label class="form-label" for="form3Example3">Email address</label>

            <input type="email" id="form3Example3" class="form-control form-control-lg"
              placeholder="" />
          </div>

          <!-- Password input -->
          <div class="form-outline mb-3">
          <label class="form-label" for="form3Example4">Password</label>

            <input type="password" id="form3Example4" class="form-control form-control-lg"
              placeholder="" />
          </div>
          
          <div class="text-center text-lg-start">
            <p class=" fw-bold mt-0 pt-0mb-0"> <a href="forgotPassword.php"
                class="link-danger">Forgot Password?</a></p>
          </div>


          <div class="text-center text-lg-start mt-4 pt-2">
            <button type="button" class="btn btn-primary btn-lg"
              style="padding-left: 2.5rem; padding-right: 2.5rem;">Login</button>
            <p class="small fw-bold mt-2 pt-1 mb-0">Don't have an account? <a href="#!"
                class="link-danger">Register</a></p>
          </div>

        </form>
      </div>
    </div>
</div>
</section>
        
    </div>
</div> 
<?php
    require("../view/_inc/footer.php");
?>