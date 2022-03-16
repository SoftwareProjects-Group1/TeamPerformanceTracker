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
            <h5 class="card-title text-center mb-5 fw-light fs-5">Forgot Password</h5>
            <form>
              
              <div class="form-floating mb-3">
                <input type="email" class="form-control" id="email" placeholder="name@example.com">
                <label for="floatingInput">Email address</label>
              </div>

              <div class="d-grid text-center">
                <button class="  btn btn-primary btn-success text-uppercase fw-bold" type="submit">Request Password Reset</button>
              </div>


              <hr class="my-2">
              <div class="d-grid mb-2 text-center">
                <a href="index.php" class="btn btn-google btn-login text-uppercase fw-bold" type="submit">
                      Return to login</a>
                </button>
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