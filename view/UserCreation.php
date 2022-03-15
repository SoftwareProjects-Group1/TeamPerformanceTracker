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
            <h5 class="card-title text-center mb-5 fw-light fs-5">Sign In</h5>
            <form>
              <div class="form-floating mb-3">
              <label for="floatingInput">Name</label>
                <input type="email" class="form-control" id="name" placeholder="name@example.com">
                
              </div>
              <div class="form-floating mb-3">
              <label for="floatingPassword">Email Address</label>
                <input type="password" class="form-control" id="email" placeholder="Password">
                
              </div>
              <div class="form-floating mb-3">
              <label for="floatingPassword">Password </label>
                <input type="password" class="form-control" id="password" placeholder="Password">
                
              </div>

              <div class="form-floating mb-3">
              <label for="floatingPassword">Confirm Password</label>
                <input type="password" class="form-control" id="password" placeholder="Password">
                
              </div>

              
              <div class="d-grid text-center">
                <button class="  btn btn-primary btn-login text-uppercase fw-bold" type="submit">Sign
                  up</button>
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