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
            $percentage = $row->PercentageSpent;
        
         echo "</tr>";

        
        
        }
        echo "<table>";
        return $percentage;

        
}

    

        

    
       
        ?>
        
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>

<div class="main">      
    
        <div class="container">

            <div class="row">
                <div class="col-sm-9 col-md-7 col-lg-12 mx-auto">

                    <div class="card border-0 shadow rounded-3 my-5">
                        <br>
                    <h1 class="text-center"> <?php echo $_GET['ProjectName']; ?> </h1>

                        <div class="card-body p-4 p-5">

                                                               
                                                     
                                                
                                                <?php
                                                 
                                                 $percentage = displayPerformance();

                                                 
                                                 
                                                 ?>
                                                 <br>
                                                 <h3 class="text-center"> Funding Spent  </h3>

                                                 
                                                 <div class="progress" style="height: 20px;">
                                                 <div class="progress-bar" role="progressbar" style="width: <?php echo $percentage;?>%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"><?php echo $percentage. "%"; ?></div>
                                                </div>

                                                <br>


                                                <div id="container" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>


                                               <script> Highcharts.chart("container", {
                                                    colors: ["#01BAF2", "#f6fa4b", "#FAA74B", "#baf201", "#f201ba"],
                                                    chart: {
                                                        type: "pie"
                                                    },
                                                    title: {
                                                        text: "Funding Spent"
                                                    },
                                                    tooltip: {
                                                        valueSuffix: '%'
                                                    },
                                                    plotOptions: {
                                                        pie: {
                                                        allowPointSelect: true,
                                                        cursor: "pointer",
                                                        dataLabels: {
                                                            enabled: true,
                                                            format: '{point.name}: {point.percentage:.1f}%'
                                                        },
                                                        showInLegend: true
                                                        }
                                                    },
                                                    series: [
                                                        {
                                                        name: "Percentage",
                                                        colorByPoint: true,
                                                        data: [
                                                            {
                                                            name: "Spent Funding",
                                                            y: <?php echo $percentage;?>
                                                            },
                                                            {
                                                            name: "Funding Remaining",
                                                            sliced: true,
                                                            selected: true,
                                                            y: <?php echo 100 - $percentage;?>
                                                            },                                                    
                                                        ]
                                                        }
                                                    ]
                                                    }); </script>

                                                <br>
                                                      
                                        </table>    
                                        <a class="btn btn-info" href="performancePage.php">Return</a>
                                        <a class="btn btn-info" href="editProjectPerformance.php?ProjectName=<?php echo $_GET['ProjectName'] ?>">Edit Performance</a>

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