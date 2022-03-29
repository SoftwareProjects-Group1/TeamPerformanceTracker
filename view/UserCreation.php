<?php
    require("../view/_inc/head.php");
    require("../view/_inc/header.php");
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
            <h5 class="card-title text-center mb-5 fw-light fs-5">Create Account</h5>
            <form>
              <div class="form-floating mb-3">
                <input type="text" class="form-control" id="name" placeholder="name@example.com">
                <label for="floatingInput">Name</label>
              </div>

              <div class="form-floating mb-3">
                <input type="email" class="form-control" id="email" placeholder="Password"> 
                <label for="floatingInput">Email Address</label>
              </div>

              <div class="form-floating mb-3">
                <input type="password" class="form-control" id="password" placeholder="Password">  
                <label for="floatingPassword">Password </label>
              </div>

              <div class="form-floating mb-3">
                <input type="password" class="form-control" id="password" placeholder="Password">  
                <label for="floatingPassword">Confirm Password</label>      
              </div>

              <div class="d-grid text-center">
                <button class="  btn btn-primary btn-login text-uppercase fw-bold" type="submit">Sign
                  up</button>
              </div>

              <hr class="my-4">
              <div class="d-grid mb-2 text-center">
                <a href="index.php" class="btn btn-google btn-login text-uppercase fw-bold" type="submit">
                      Return to login</a>
                </button>
              </div>    
              
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
        </div>
    </div> 
<?php
    require("../view/_inc/footer.php");
?>