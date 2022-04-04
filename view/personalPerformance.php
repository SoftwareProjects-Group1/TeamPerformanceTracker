<?php
    require("../view/_inc/head.php");
    require("../view/_inc/header.php");

    $Title = ($_SESSION['userFname'].". ".$_SESSION['userSname']);
    
    
        

    function displayTeams() {
        $m = new MongoDB\Driver\Manager('mongodb+srv://group1:fvAIyyCRp4PBaDPQ@clst01.to6hh.mongodb.net/projectDB?retryWrites=true&w=majority');     
        $results=[];
        $q = new MongoDB\Driver\Query([],[]);
        $cursor = $m->executeQuery('projectDB.Employees',$q);
             
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
                    <h1 class="text-center"> Personal Performance </h1>

                        <div class="card-body p-4 p-5">

                                                               
                                                     
                                                
                            <?php
                                displayTeams();
                                
                            ?>

                            <div id="container" style="min-width: 410px; height: 500px; max-width: 1000px; margin: 0 auto"></div>

                            <script>
                            var Title = <?=json_encode($Title)?>;

                            Highcharts.chart('container', {
                            chart: {
                                type: 'column'
                            },
                            title: {
                                text: Title
                            },
                            xAxis: {
                                categories: [
                                    'Project 1',
                                    'Project 2',
                                    'Prokect 3',
                                    'Project 4',
                                    'Project 5',
                                    'Project 6',
                                ],
                                crosshair: true
                            },
                            yAxis: {
                                min: 0,
                                max:10,
                                title: {
                                    text: "Score"
                                }
                            },
                            tooltip: {
                                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                                    '<td style="padding:0"><b>{point.y:.1f} mm</b></td></tr>',
                                footerFormat: '</table>',
                                shared: true,
                                useHTML: true
                            },
                            plotOptions: {
                                column: {
                                    pointPadding: 0.2,
                                    borderWidth: 0
                                }
                            },
                            series: [{
                                name: 'Personal Rating',
                                data: [4, 7, 10, 5, 6, 4, 8, 7]

                                }, {
                                name: 'Manager Rating',
                                data: [6, 8, 4, 8, 5, 4, 6, 10]
                            }]
                        });
                        </script>
                         
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

<!--
     <?php
    echo($_SESSION['userFname'].". ".$_SESSION['userSname']);
    ?> 
-->