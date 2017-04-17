<?php
require_once('config.php');
$list_total = count($list);
?>

<!DOCTYPE html>
<html>
    <head>
    <?php include('partials/includes.php') ?>
        
    </head>
    <body>
        <?php include('partials/nav.php');?>

        <div class="container-fluid text-center">
            <div class="jumbotron">
                <h2><strong> Stats </strong></h2>                
            </div>
        </div>
        
        <div class="container">
            <div>
                <h2>Totals</h2>
            </div>
            <div class="col-sm-6">   
                <h3>By Zip Code</h3> 
                <?php $sortedlist = totalPerZipcode($list);  ?>
                <?php include('partials/bar_graph2.php'); ?>       
                <!--<?php foreach($ziptotals as $zipcode => $ziptotal  ): ?>
                    <div class="progress">
                    <?php $percent = round(($ziptotal / $list_total)*100) ?>
                        <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" 
                                style="width: <?php echo $percent ?>%">
                            <?php echo $percent. '% '?>
                        </div>
                        <div class="pull-right"><p><strong><?php echo $ziptotal . ' total for '. $zipcode ?> </strong></p></div>
                    </div>
                <?php endforeach; ?>            -->
           
                
                </div>
                <div class="col-sm-6">
                    <h3>By Minimum Bid</h3>
                    <?php $sortedlist = getSortedTotals($list); ?>  
                    <?php include('partials/bar_graph.php') ?>   
                </div>
                  
            </div>
        </div>


        <div class="container">
            <div class="col-sm-4">
                <?php include('partials/money.php') ?>               
            </div>
            <div class="col-sm-4">
                <?php include('partials/by_type.php') ?>
            </div>
        </div>

    </body>
</html>