<?php
    require("../view/_inc/head.php");
    require("../view/_inc/header.php");


    function insert(){

      $num = rand(1000,10000);
      
      $bulk = new MongoDB\Driver\BulkWrite;

      $document2 = ['projectID' => $num, 'projectName' => $_POST['name'], 'projectDescription' => $_POST['description'], 'projectBudget' => (int)$_POST['budget'], 'ProjectManager' => $_POST['managername'], 'assignedTeamID' => (int)null];

      $_id3 = $bulk->insert($document2);

      var_dump($_id3);

      $m = new MongoDB\Driver\Manager('mongodb+srv://group1:fvAIyyCRp4PBaDPQ@clst01.to6hh.mongodb.net/projectDB?retryWrites=true&w=majority');
      $result = $m->executeBulkWrite('projectDB.Projects', $bulk);

    }
    $allFields = "yes";
    $errName = $errBudget = $errDesc = $errManager = "";



    if (isset($_POST["submit"])){

      if ($_POST['name']==""){
          $errName = "This field is mandatory";
          $allFields = "no";
      }
      if ($_POST['budget']==null){
          $errBudget = "This field is mandatory";
          $allFields = "no";
      }
      if ($_POST['description']==""){
          $errDesc = "This field is mandatory";
          $allFields = "no";
      }
      if ($_POST['managername']==""){
        $errManager = "This field is mandatory";
        $allFields = "no";
    }
      
      
  
      if($allFields == "yes")
      {
        insert();
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
          <h5 class="card-title text-center mb-5 fw-light fs-5">Create A New Project</h5>

          <form method="post">
            <div class="form-floating mb-3">
              <input type="text" class="form-control" id="projectName" placeholder="Project Name" name="name">
              <label for="floatingInput">Project Name</label>
              <span class="text-danger"><?php echo $errName; ?></span>

            </div>

            <div class="form-floating mb-3">
              <input type="text" class="form-control" id="managername" placeholder="Manager name" name="managername" value ="">
              <label for="floatingInput">Manager name</label>
              <span class="text-danger"><?php echo $errName; ?></span>
              <span class="text-danger"><?php echo $errDesc; ?></span>


              
            </div>    
            
            <div class="form-floating mb-3">
              <input type="number" class="form-control" id="projectBudget" placeholder="Budget" name="budget">
              <label for="floatingPassword">Budget</label>
              <span class="text-danger"><?php echo $errBudget; ?></span>

            </div>

            <div class="form-floating mb-3">
              <input type="text" class="form-control" id="projectDescription" placeholder="Project Name" name="description">
              <label for="floatingInput">Project Description</label>
              <span class="text-danger"><?php echo $errDesc; ?></span>

            </div>
            
            <div class="d-grid text-center">
              <button class="  btn btn-primary btn-login text-uppercase fw-bold" type="submit" name="submit">Create Project</button>
            </div><br>

            <div class="d-grid text-center">
              <button class="  btn btn-secondary btn-login text-uppercase fw-bold" type="submit" >Return To Dashboard</button>
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