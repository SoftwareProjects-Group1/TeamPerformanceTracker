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
    <div class="col-sm-7 col-md-7 col-lg-7 mx-auto">
    <div class="card border-0 shadow rounded-3 my-5">
        <div class="card-body p-4 p-sm-5">
        <div class="card text-white bg-success mb-7" style="max-width: 50rem;">
        <div class="card-header">Password Reset</div>
        <div class="card-body">
            <h5 class="card-title">Email Sent!</h5>
            <p class="card-text">You have successfully sent a password reset to the email address provided. Please check your junk and spam folders if you are unable to find the email.</p>
        </div>
        </div>

        <hr class="my-4">
            <div class="d-grid mb-2 text-center">
            <a href="index.php" class="btn btn-google btn-login text-uppercase fw-bold" type="submit">
                    Return to login</a>
            </button>
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