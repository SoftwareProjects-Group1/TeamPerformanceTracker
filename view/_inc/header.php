</head>
<body class="d-flex flex-column position-absolute h-100 w-100">
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="/view/index.php"><img style="height: 75px;" src="../assets/media/Actemium.png"></a>
  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navCollapse" aria-controls="navCollapse" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse justify-content-end ps-2 pe-2" id="navCollapse">
      <?php
      session_start();
      if(isset($_SESSION['loggedIN'],$_SESSION['userRole']) && $_SESSION['userRole']=="Admin"){
        require("../view/_inc/headerLoggedInAdmin.php");
      } elseif(isset($_SESSION['loggedIN'],$_SESSION['userRole']) && $_SESSION['userRole']=="Employee") {
        require("../view/_inc/headerLoggedInEmployee.php");
      }
      ?>
  </div>
</nav>
<script>
  function logout() {
    $.post("../controller/logout.php",{"action": "logout"});
    alert("Logged Out");
    window.location.replace("../view/index.php");
  }
</script>