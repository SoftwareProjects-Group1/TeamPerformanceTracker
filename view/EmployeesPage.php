<?php require("../view/_inc/head.php");?>
<link rel="stylesheet" type = "text/css" href = "../assets/css/teamManagement.css">
<script src="../view/scripts/employeeManagement.js"></script>
<?php require("../view/_inc/header.php");?>

<div id="alertModal" class="modal h-auto" tabindex="-1" role="dialog">
  <div class="modal-dialog m-0 mw-100" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Are you sure?</h5>
        <button type="button" class="close" onclick="$('#alertModal').modal('hide')">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Are you sure you wish to delete this employee, this is unreversible and will remove the team completely from the database. All Projects and Employees assigned will be set to unassigned.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" onclick="confirmDeleteEmployee()">Delete Employee</button>
        <button type="button" class="btn btn-secondary" onclick="$('#alertModal').modal('hide')">Cancel</button>
      </div>
    </div>
  </div>
</div>

<div class="main p-0">
    <div class="container-fluid h-100 w-100 p-4 ps-0">
        <div class="row ms-0 no-gutter h-100">
            <div class="col-2 d-flex flex-column align-items-center sideButtons justify-content-center">
                <button>Create Team</button>
                <div></div>
                <button>Create Employee</button>                
            </div>
            <div class="col-10">
              <div class="h-100 w-100 mainBox p-4 text-center" id="employeeHolder">
                
              </div>
            </div>
          </div>
        </div>
    </div> 
  </div> 
<?php
    require("../view/_inc/footer.php");
?>