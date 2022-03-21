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
          <h5 class="card-title text-center mb-5 fw-light fs-5">Create A New Project</h5>

          <form method="post">
            <div class="form-floating mb-3">
              <input type="text" class="form-control" id="projectName" placeholder="Project Name">
              <label for="floatingInput">Project Name</label>
            </div>

            <div class="form-floating mb-3">                    
              <select class="select form-control" name="EmpStatus">
                <option value="0" disabled>Select Team</option>
                <option value="1">Manager 1</option>
                <option value="2">Manager 2</option>
                <option value="3">Manager 3</option>
                <option value="4">Manager 4</option>
              </select>
              <label class="form-label select-label">Select Project Manager</label>
            </div>    
            
            <div class="form-floating mb-3">
              <input type="number" class="form-control" id="projectBudget" placeholder="Budget">
              <label for="floatingPassword">Budget</label>
            </div><br>

            <div class="form-floating mb-3">
              <input type="text" class="form-control" id="projectDescription" placeholder="Project Name">
              <label for="floatingInput">Project Description</label>
            </div>
            
            <div class="d-grid text-center">
              <button class="  btn btn-primary btn-login text-uppercase fw-bold" type="submit">Create Project</button>
            </div><br>

            <div class="d-grid text-center">
              <button class="  btn btn-secondary btn-login text-uppercase fw-bold" type="submit">Return To Dashboard</button>
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