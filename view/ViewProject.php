

<?php
    require("../view/_inc/head.php");
    require("../view/_inc/header.php");

    

        

    function displayProjects() {
        $m = new MongoDB\Driver\Manager('mongodb+srv://group1:fvAIyyCRp4PBaDPQ@clst01.to6hh.mongodb.net/projectDB?retryWrites=true&w=majority');
        echo "<table class='table table-bordered table-striped'>";
        echo "<thead>   
           <td>Project ID</td>                    
            <td>Project Name</td>
             <td>Project Description</td>
               <td>Project Budget</td>
               <td>Project Manager</td>
                    <td> Update </td>     
                    <td> View Performance </td>      
                 </thead>  ";     
        $results=[];
        $q = new MongoDB\Driver\Query([],[]);
        $cursor = $m->executeQuery('projectDB.Projects',$q);
        foreach($cursor as $row) {
            echo "<tr>";
            echo "<td>" . $row->projectID. "</td>";
            echo "<td>" . $row->projectName . "</td>";
            echo "<td>" . $row->projectDescription . "</td>"; 
            echo "<td>" . $row->projectBudget. "</td>"; 
            echo "<td>" . $row->ProjectManager. "</td>"; 
            //echo "<td>" . $row->assignedTeamID . "</td>";
            echo '<td><a class="btn btn-info" href="updateProject.php?ProjectName='. $row->projectName.'">Update</a></td>';
            echo '<td><a class="btn btn-info" href="projectPerformance.php?ProjectName='. $row->projectName.'">ViewPerformance</a></td>';




         echo "</tr>";
        
        
        }
        echo "<table>";

        
}

       
        ?>
        

<div class="main">    
    
    <div class="inner_main">
    <?php if (isset($_GET['Deleted'])){
                       echo '<script type="text/javascript">toastr.success("Successfully Deleted")</script>';

    }
    if (isset($_GET['Created'])){
        echo '<script type="text/javascript">toastr.success("Successfully Created")</script>';

}
if (isset($_GET['Updated'])){
    echo '<script type="text/javascript">toastr.success("Successfully Updated")</script>';

}
    
    ?>
    
    
        <div class="container">
        

            <div class="row">
                <div class="col-sm-9 col-md-7 col-lg-12 mx-auto">

                    <div class="card border-0 shadow rounded-3 my-5">
                    <br>
                    <h1 class="text-center"> Projects </h1>

                        <div class="card-body p-4 p-5">

                                                               
                                                     
                                                
                                                <?php
                                                    DisplayProjects();
                                                 
                                                 
                                                 
                                                 ?>
                                                      
                                        </table>    
                                    </div>
                                    <a href="CreateProject.php"  type="button" class="btn btn-primary">Create New Project</a>	     

                                </div>
                         
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
