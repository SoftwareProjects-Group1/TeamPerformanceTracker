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
        echo '<form method="post">';
        foreach($cursor as $row):
            ?>
            <tr>
            <td><?php echo $row->ProjectName?></td>
            <td><input type="number" name = "happiness" value="<?php echo $row->ManagerHappiness?>"></td>
            <td><input type="number" name = "funding" value="<?php echo $row->TotalFunding?>"></td>
            <td><input type="number" name = "spent" value="<?php echo $row->TotalSpent?>"></td>
            <td><?php echo $row->PercentageSpent?></td>
        
            </tr>

        <?php endforeach;?>
        <button class="  btn btn-info" type="edit" name="edit" onclick="return confirm('Are you sure you wish to edit?')">Submit Edit</button>

        </form>

        <?php
        
    }
    $allfields = 'yes';

    if (isset($_POST['edit'])){

        if (isset($_POST['happiness'])){
            if ($_POST['happiness'] > 0 && $_POST['happiness'] <= 10){
                $allfields = 'yes';

            }
            else {
                $allfields = 'no';
            }
        }
        if (isset($_POST['funding'])){
            $allfields = 'yes';
        }
        else {
            $allfields = 'no';

        }

        if (isset($_POST['spent'])){
            $allfields = 'yes';

        }
        else{
            $allfields = 'no';
        }

        if ($allfields == 'yes'){
            echo 'working';
        }




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
                        

                        </form>
           
                                                     
                                                <?php

                                                displayPerformance();

                                                


                                                 
                                                 
                                                 ?>
                                                 <br>
                                                 
                                                

                                                <br>


                                                
                                                      
                                        </table>    
                                        <a class="btn btn-info" href="projectPerformance.php?ProjectName=<?php echo $_GET['ProjectName']?>">Back</a>
                                            <br>

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