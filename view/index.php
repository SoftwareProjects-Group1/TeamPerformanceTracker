<?php
    require("../view/_inc/head.php");
    require("../view/_inc/header.php");
    session_start();

    // include_once("checkLogin.php");

    // $erroruname = $errorpwd = $invalidMesg = "";
    
    
    //  if (isset($_POST['submit'])) {

    //   if ($_POST['uname']=="") {
    //       $erroruname = "Username is required";
    //     } 
        
    //     if ($_POST['pwd']==null) {
    //       $errorpwd = "Password is required";
    //     }

    //     if  ($_POST['pwd']!=null && $_POST['pwd']!=null){
    //       $hi = verify();

    //       if ($hi == null){
    //         echo "null";
    //       }
    //       else{
            
    //         echo $hi;

    //       }
    //     }
    //   } 
?>

<script>
  $(document).ready(function() {$('#loginForm').submit((e)=>{e.preventDefault();})});
  function submitForm(e) {
    var uName = e.srcElement[0].value;
    var pWord = e.srcElement[1].value;
    var rem = e.srcElement[2].checked;
    $.post('../../controller/checkLogin.php', { "action": "checkPass", "uname": uName, "pwd": pWord, "rem": rem }, function(data, status) { checkLogin(data, status) })
    e.srcElement[0].value = "";
    e.srcElement[1].value = "";
  }
  function checkLogin(data,status){
    console.log(data);
    if(status!="success"){alert("Can't login at this time");return;}
    if(data=="false"){alert("Bad Login, Try Again")}
    if(data=="true"){alert("Correct Login, change line 38 in the php file to redirect and add session updates instead of this alert.")}
  }
</script>

<div class="main">
    <div class="inner_main">

    <section>
    <body>
  <div class="container">
    <div class="row">
      <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
        <div class="card border-0 shadow rounded-3 my-5">
          <div class="card-body p-4 p-sm-5">
            <h5 class="card-title text-center mb-5 fw-light fs-5">Sign In</h5>
            
            <form onsubmit="submitForm(event)" id="loginForm">
              
              <div class="form-floating mb-3">
                <input class="form-control" name="uname" placeholder="name@example.com" required value="<?php if(isset($_COOKIE['username'])){echo $_COOKIE['username'];} ?>">
                <label for="floatingInput">Username</label>
                <span class="text-danger"></span>

              </div>

              <div class="form-floating mb-3">
                <input type="password" class="form-control" id="password" name = "pwd" placeholder="Password" value="<?php if(isset($_COOKIE['password'])){echo $_COOKIE['password'];} ?>" required>
                <label for="floatingPassword">Password</label>
                <span class="text-danger"></span>
                <span class="text-danger"></span>


              </div>

              <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" checked="<?php if(isset($_COOKIE['checked'])){echo $_COOKIE['checked'];} ?>" id="rememberPasswordCheck">
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