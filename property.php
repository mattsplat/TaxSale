<?php
require_once('config.php');


if(isset($_GET['id'])){ 
    $id = $_GET['id'];                 
    $list = matchID($list, $id);    
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
                <h1>Action Number: <?php echo $id?> 
                
                
            </div>
        </div> 

<!---->
        
        
           <div class = "container">                
                <div class="panel panel-default ">
                <!-- Default panel contents -->
                    <div class="panel-heading"><h3>Properties Details</h3></div>
                    <div class="row"> 
                        
                        <div class="col-sm-4">           
                            <ul class="list-group">  
                                <li class="list-group-item" style="padding:50px 0px 0px 50px; font-size:40px;"> <i class="fa <?php echo getIcon($list); ?> fa-5x"></i>  </li>                                                             
                            </ul>
                        </div>                          
                        <div class="col-sm-6">                
                    <!-- Default panel contents -->                         
                            <ul class="list-group"> 
                                <li class="list-group-item"><h2><?php echo toMoney($list->price); ?></h2></li>
                                <li class="list-group-item"> <h2>Type: <?php echo $list->type; ?></h2></li>
                                <li class="list-group-item "><a style="color: white;" href="http://maps.google.com/?q= <?php echo $list->address.' '. $list->city . ' '. $list->zipcode; ?> ">                       
                                    <h2><?php echo $list->address. ' '. $list->zipcode; ?></h2></a></li> 
                                 <li class="list-group-item "><a style="color: white;" 
                                    href="http://landsweb.wycokck.org/LandsWeb/search/parcelDisplaySplit.aspx?Parcel=<?php echo $list->parcelID; ?> " target="_blank">
                                    <h2>Parcel Id: <?php echo $list->parcelID ?> </h2></a></li>               
                                               
                            </ul>                    
                        </div>
                        <div class="col-sm-1" style="padding:25px 0px 0px 25px;">
                        <?php if(isset($_SESSION['myList'])): ?>
                            <i id="removeFromList" data="<?php echo $list->id?>" class="fa fa-heart fa-3x" aria-hidden="true"></i> 
                        <?php endif; ?>
                        <?php if(!isset($_SESSION['myList'])): ?>
                            <i id="addToList" data="<?php echo $list->id?>"  class="fa fa-heart-o fa-3x" aria-hidden="true"></i> 
                            Add to MyList
                        <?php endif?>
                        </div>
                    </div>
                    <div class="text-center">
                        <iframe
                            width="600"
                            height="450"
                            frameborder="0" style="border:0"
                            src="https://www.google.com/maps/embed/v1/place?key=AIzaSyBVO38I05DtIVETs8UaaZtqaLngQgURYRA
                                &q=<?php echo $list->address.' '. $list->city . ' '. $list->zipcode; ?>" allowfullscreen>
                        </iframe>
                    </div>
                </div>  
                
            </div>
    </body>
<script>
    $('#addToList').on('click', function(e){ 
        console.log("clicky");
        $.ajax({
        
        type: 'POST',
        url: 'setMyList.php',
        data: {sendCellValue: $(this).data()}
    }); });
</script>
</html>