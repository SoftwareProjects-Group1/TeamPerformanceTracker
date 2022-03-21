<?php
    require("../view/_inc/head.php");
    require("../view/_inc/header.php");
        $m = new MongoDB\Driver\Manager('mongodb+srv://group1:fvAIyyCRp4PBaDPQ@clst01.to6hh.mongodb.net/projectDB?retryWrites=true&w=majority');
        $filter = [ 'projectName' => $_GET['ProjectName']]; 

        $query = new MongoDB\Driver\Query($filter);     
        $res = $m->executeQuery("projectDB.Projects", $query);
         foreach($res as $row) {
            
                $proID = $row->projectID;
                $name = $row->projectName ;
                $desc = $row->projectDescription ;
                $budget = $row->projectBudget;
                $manager = $row->ProjectManager;
            }    


    function update(){
      
      $update = new MongoDB\Driver\BulkWrite;
      $update->update(
        ['projectName' => $_GET['ProjectName']],
        ['$set' => ['projectName' => $_POST['name']]],
        ['$set' => ['projectDescription' => $_POST['description']]],
        ['$set' => ['projectBudget' => $_POST['budget']]],
        ['$set' => ['ProjectManager' => $_POST['managername']]]
      )  ;

      $m = new MongoDB\Driver\Manager('mongodb+srv://group1:fvAIyyCRp4PBaDPQ@clst01.to6hh.mongodb.net/projectDB?retryWrites=true&w=majority');

      $m->executeBulkWrite('projectDB.Projects', $update);

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
        update();
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
          <h5 class="card-title text-center mb-5 fw-light fs-5">Update</h5>

          <form method="post">
            <div class="form-floating mb-3">
              <input type="text" class="form-control" id="projectName" placeholder="Project Name" name="name" value = "<?php echo $name?>">
              <label for="floatingInput">Project Name</label>
              <span class="text-danger"><?php echo $errName; ?></span>

            </div>

            <div class="form-floating mb-3">
              <input type="text" class="form-control" id="managername" placeholder="Manager name" name="managername" value ="<?php echo $manager?>">
              <label for="floatingInput">Manager name</label>
              <span class="text-danger"><?php echo $errName; ?></span>


              
           </div>    
            
            <div class="form-floating mb-3">
              <input type="number" class="form-control" id="projectBudget" placeholder="Budget" name="budget" value = "<?php echo $budget?>">
              <label for="floatingPassword">Budget</label>
              <span class="text-danger"><?php echo $errBudget; ?></span>

            </div>

            <div class="form-floating mb-3">
              <input type="text" class="form-control" id="projectDescription" placeholder="Project Name" name="description" value = "<?php echo $desc?>">
              <label for="floatingInput">Project Description</label>
              <span class="text-danger"><?php echo $errDesc; ?></span>

            </div>
            
            <div class="d-grid text-center">
              <button class="  btn btn-primary btn-login text-uppercase fw-bold" type="submit" name="submit">Update</button>
            </div><br>

            <div class="d-grid text-center">
              <a href="index.php" class="btn btn-secondary btn-login text-uppercase fw-bold" type="submit" >Return to home</a>
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