<?php
require_once('config.php');

if(isset($_GET['type'])){ 
    $selected_type = $_GET['type'];                 
    $list = matchType($list, $selected_type);
    
}



// organize by zip code 

?>
<!DOCTYPE html>
<html>
  <head>
   <?php include('partials/includes.php') ?>
</head>
    <body>
        <?php include('partials/nav.php');?>
        
        <div class="container-fluid text-center">
            <div class="jumbotron"></h1>
                <h1><?php echo $selected_type?> 
                <h3><strong><?php echo count($list). ' Properties of Type '. $selected_type ?> </strong></h3>
                
            </div>
        </div> 

<!---->
        
        <div class="container">           
            <h2>Totals</h2>           
            <div class="col-sm-4">
                <?php include('partials/by_type.php'); ?>

               <?php include('partials/money.php') ?>
            </div>            
            
            <div class="col-sm-6">   
                <h3>By Minimum Bid</h3> 
                <?php $sortedlist = getSortedTotals($list);?>   
                <?php include('partials/bar_graph.php') ?>                   
            </div>
        <div class="container">           
        </div>    

        <div class="panel panel-default ">
            <!-- Default panel contents -->
            <div class="panel-heading"><h3>Properties List</h3></div>
            <!-- Table -->
            <div class="table-responsive">
                <table class="table sortable">
                    <thead class="">
                    <tr>                  
                        <th>Minimum</th>
                        <th>Type</th>
                        <th>Address</th>
                        <th>Zip Code</th> 
                        <th>Action Number</th>                   
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($list as $item): ?> 
                    <?php include('partials/listing.php'); ?>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>
    </body>
</html>