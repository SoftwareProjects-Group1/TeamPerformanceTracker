

<?php
    require("../view/_inc/head.php");
    require("../view/_inc/header.php");
?>

<div class="main">    
    <div class="inner_main">
        <div class="container">
            <div class="row">
                <div class="col-sm-9 col-md-7 col-lg-12 mx-auto">
                    <div class="card border-0 shadow rounded-3 my-5">
                        <div class="card-body p-4 p-5">
                            <main role="main" class="pb-3">
                                <h2 class = "title" style = "padding-top:25px">View Projects</h2><br>
                                <div class="row">
                                    <div class="col-10">
                                        <table class="table table-bordered table-striped">
                                            <thead>   
                                                <td>Action</td>                    
                                                <td>Project Manager</td>
                                                <td>Project Name</td>
                                                <td>Company</td>
                                                <td>Current Progress</td>                                     
                                            </thead>                    
                                            <tr>                               
                                                <td>Delete </td>	
                                                <td>John Doe</td>	
                                                <td>Do Things</td>
                                                <td>Doe Co</td>	
                                                <td>14%</td>			
                                            </tr>                    
                                        </table>    
                                    </div>
                                </div>
                                <a href="CreateProject.php">Create New Project</a>	                            
                            </main>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
    require("../view/_inc/footer.php");
?>