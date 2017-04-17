<?php
require_once('config.php');

if(isset($_GET['sort'])){ 
            $sort = $_GET['sort'];                 
    if(isset($sort_options[$sort] ) ){
        $sort= ($sort_options[$sort]);
        $list = sortList($list, $sort);
    }
    
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
                <h1>Tax Sale List 
                <h2><strong><?php echo count($list) ?> Properties </strong></h2>
                <article>
                You must pre-register in order to participate in the Tax Sale. The Sale is scheduled for April 27, 2017, 10:00 am at Memorial Hall, 600 North 7th Street, Kansas City, KS  66101.
                You must pre-register in order to participate in the Tax Sale. Registration takes place in the Delinquent Real Estate Office between the hours of 8:00 am and 5:00 pm. 
                Prior to Registration you must obtain a tax clearance from the Delinqueint Real Estate Office.The Tax Clearance must be in the name of the individual,
                group or company bidding on the property.		
                </article>
            </div>
        </div>       

        <div class="panel panel-default ">
            <!-- Default panel contents -->
            <div class="panel-heading">Properties List</div>
            <!-- Table -->
            <div class="table-responsive">
                <table class="table table-striped hover">
                    <thead class=" ">
                    <tr>                                    
                    <th><a href="?sort=minimum">Minimum</a></th>
                    <th><a href="?sort=type">Type</a></th>
                    <th>Address</th>
                    <th><a href="?sort=zipcode">Zip Code</a></th>
                    <th><a href=".">Action Number</a></th>
                    
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