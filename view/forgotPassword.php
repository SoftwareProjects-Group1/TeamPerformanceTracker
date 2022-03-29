<?php
    require("../view/_inc/head.php");
    require("../view/_inc/header.php");
    
    if (isset($_POST['submit'])) {

      $m = new MongoDB\Driver\Manager('mongodb+srv://group1:fvAIyyCRp4PBaDPQ@clst01.to6hh.mongodb.net/projectDB?retryWrites=true&w=majority');

      $filter = [ 'Email_Address' => $_POST['email']]; 
      $query = new MongoDB\Driver\Query($filter);     
      $res = $m->executeQuery("projectDB.Users", $query);

      if (!count($res->toarray())){
        echo '<script type="text/javascript">toastr.error("Email not in database")</script>';
      }      
      else {
        require("phpmailer/PHPMailer.php");
        require("phpmailer/SMTP.php");
        require("phpmailer/Exception.php");
    
        $mail = new PHPMailer\PHPMailer\PHPMailer();
        $mail->IsSMTP(); 
    
        $mail->SMTPDebug = 1; 
        $mail->SMTPAuth = true; 
        $mail->SMTPSecure = 'ssl'; 
        $mail->Host = "smtp.gmail.com";
        $mail->Port = 465; 
        $mail->IsHTML(true);
        $mail->Username = "actemiumproject@gmail.com";
        $mail->Password = "nzw*FMZ@zcm9rby6vwa";
        $mail->SetFrom("actemiumproject@gmail.com");
        $mail->Subject = "Actemium - Password Reset";
        $mail->Body = "Test";
        $mail->AddAddress($_POST['email']);
        $mail->Send();

        header("Location: forgotPasswordSummary.php");
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
            <h5 class="card-title text-center mb-5 fw-light fs-5">Forgot Password</h5>
            <form method="post">
              
              <div class="form-floating mb-3">
                <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com">
                <label for="floatingInput">Email address</label>
              </div>

              <div class="d-grid text-center">
                <button class="btn btn-primary btn-success text-uppercase fw-bold" name="submit" type="submit">Request Password Reset</button>
              </div>

              <hr class="my-4">
              <div class="d-grid mb-2 text-center">
                <a href="index.php" class="btn btn-google btn-login text-uppercase fw-bold">
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