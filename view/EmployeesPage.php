<?php require("../view/_inc/head.php");?>
<link rel="stylesheet" type = "text/css" href = "../assets/css/teamManagement.css">
<script src="../view/scripts/employeeManagement.js"></script>
<?php require("../view/_inc/header.php");?>

<div id="alertModal" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modalWidth" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitle"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="modalContent"></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" id="modalButton"></button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>

<div class="main p-0">
    <div class="container-fluid h-100 w-100 p-4 ps-0">
        <div class="row ms-0 no-gutter h-100">
            <div class="col-2 d-flex flex-column align-items-center sideButtons justify-content-center">
                <button onclick="createTeamPopup();">Create Team</button>
                <div></div>
                <button onclick="createEmployeePopup();">Create Employee</button>
            </div>
            <div class="col-10">
                <div class="h-100 w-100 mainBox p-4 text-center" id="employeeHolder">
                </div>
            </div>
        </div>
    </div>
</div> 
<?php
    require("../view/_inc/footer.php");
?>



