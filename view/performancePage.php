<?php
    require("../view/_inc/head.php");
    require("../view/_inc/header.php");

    

        

    function displayTeams() {
        $m = new MongoDB\Driver\Manager('mongodb+srv://group1:fvAIyyCRp4PBaDPQ@clst01.to6hh.mongodb.net/projectDB?retryWrites=true&w=majority');
        echo "<table class='table table-bordered table-striped'>";
        echo "<thead>   
           <td>Team name</td>    
           <td>Team ID</td>    
      
            <td> Action </td>                       
            </thead>  ";     
        $results=[];
        $q = new MongoDB\Driver\Query([],[]);
        $cursor = $m->executeQuery('projectDB.Teams',$q);
        foreach($cursor as $row) {
            echo "<tr>";
            echo "<td>" . $row->teamName. "</td>";
            echo "<td>" . $row->teamID. "</td>";

            echo '<td><a class="btn btn-info" href="teamPerformance.php?TeamName='. $row->teamName.'">View Performance</a></td>';


         echo "</tr>";
        
        
        }
        echo "<table>";     
}
?>
        

<div class="main">      
    
        <div class="container">
        

            <div class="row">
                <div class="col-sm-9 col-md-7 col-lg-12 mx-auto">

                    <div class="card border-0 shadow rounded-3 my-5">
                        <br>
                    <h1 class="text-center"> View Team Performance </h1>

                        <div class="card-body p-4 p-5">

                                                               
                                                     
                                                
                                                <?php
                                                    displayTeams();
                                                 
                                                 
                                                 
                                                 ?>
                                                      
                                        </table>    
                                    </div>

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
