<?php
    require("../view/_inc/head.php");
    require("../view/_inc/header.php");



    function displayPerformance() {
        $m = new MongoDB\Driver\Manager('mongodb+srv://group1:fvAIyyCRp4PBaDPQ@clst01.to6hh.mongodb.net/projectDB?retryWrites=true&w=majority');
        echo "<table class='table table-bordered table-striped'>";
        echo "<thead>   
           <td>Team Name</td>                    
            <td>Manager Happiness</td>
             <td>Total Funding</td>
               <td>Total Spent</td>
               <td>Percentage Spent</td>
                 </thead>  ";     
        $results=[];

        $filter = [ 'TeamName' => $_GET['TeamName']]; 

        $q = new MongoDB\Driver\Query($filter);

        $cursor = $m->executeQuery('projectDB.TeamPerformances',$q);
        foreach($cursor as $row) {
            echo "<tr>";
            echo "<td>" . $row->TeamName. "</td>";
            echo "<td>" . $row->ManagerHappiness . "</td>";
            echo "<td>" . $row->TotalFunding . "</td>"; 
            echo "<td>" . $row->TotalSpent. "</td>"; 
            echo "<td>" . $row->PercentageSpent. "</td>"; 
            $per = $row->PercentageSpent;
        
         echo "</tr>";
        
        
        }
        echo "<table>";
        return $per;
        
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
                    <h1 class="text-center"> <?php echo $_GET['TeamName']; ?> </h1>

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
                                                    subtitle: {
                                                        text:
                                                        'Source:<a href="https://youtu.be/dQw4w9WgXcQ" target="_default">Rick</a>'
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
                                        <a class="btn btn-info" href="editTeamPerformance.php?TeamName=<?php echo $_GET['TeamName']?>">Edit Project Performance</a>

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
