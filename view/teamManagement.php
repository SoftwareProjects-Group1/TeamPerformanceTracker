<?php require("../view/_inc/head.php");?>
<link rel="stylesheet" type = "text/css" href = "../assets/css/teamManagement.css">
<script src="../view/scripts/teamManagement.js"></script>
<?php require("../view/_inc/header.php");?>
<div class="main p-0">
    <div class="container-fluid h-100 w-100 p-4 ps-0">
        <div class="row ms-0 no-gutter h-100">
            <div class="col-2 d-flex flex-column align-items-center sideButtons justify-content-center">
                <button>Create Team</button>
                <div></div>
                <button>Create User</button>
                <div></div>
                <button>Discard Changes</button>
                <div></div>
                <button>Save Changes</button>
            </div>
            <div class="col-10">
                <div class="h-100 w-100 mainBox p-4 text-center" id="teamHolder">
                </div>
            </div>
        </div>
    </div>
</div> 
<?php
    require("../view/_inc/footer.php");
?>