<?php
    require("../view/_inc/head.php");
    require("../view/_inc/header.php");

    function displayPerformance() {
        $m = new MongoDB\Driver\Manager('mongodb+srv://group1:fvAIyyCRp4PBaDPQ@clst01.to6hh.mongodb.net/projectDB?retryWrites=true&w=majority');
        echo "<table class='table table-bordered table-striped'>";
        echo "<thead>   
           <td>TeamName</td>                    
            <td>ManagerHappiness</td>
             <td>TotalFunding</td>
               <td>TotalSpent</td>
               <td>PercentageSpent</td>
                 </thead>  ";     
        $results=[];

        $filter = [ 'ProjectName' => $_GET['ProjectName']]; 

        $q = new MongoDB\Driver\Query($filter);

        $cursor = $m->executeQuery('projectDB.ProjectPerformances',$q);
        foreach($cursor as $row) {
            echo "<tr>";
            echo "<td>" . $row->ProjectName. "</td>";
            echo "<td>" . $row->ManagerHappiness . "</td>";
            echo "<td>" . $row->TotalFunding . "</td>"; 
            echo "<td>" . $row->TotalSpent. "</td>"; 
            echo "<td>" . $row->PercentageSpent. "</td>"; 
        
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
                    <h1 class="text-center"> <?php echo $_GET['ProjectName']; ?> </h1>

                        <div class="card-body p-4 p-5">

                                                               
                                                     
                                                
                                                <?php
                                                 
                                                 displayPerformance();
                                                 
                                                 ?>
                                                      
                                        </table>    
                                        <a class="btn btn-info" href="ViewProject.php">Return</a>
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
