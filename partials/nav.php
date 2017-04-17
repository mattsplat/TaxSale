<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">Tax Sale Info</a>
    </div>
    <ul class="nav navbar-nav">
      <li class="active"><a href=".">Home</a></li>
      <li><a href="stats.php">All Stats</a></li>
      <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Zip Code
        <span class="caret"></span></a>
        <ul class="dropdown-menu">
            <?php foreach($zipcodes as $zipcode): ?>
                <li><a href="zipcode.php?zip=<?php echo $zipcode; ?>"> <?php echo $zipcode; ?></a></li>
            <?php endforeach;  ?>         
        </ul>        
      </li>
      <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Improvement Type
        <span class="caret"></span></a>
        <ul class="dropdown-menu">
            <?php foreach($types as $type): ?>
                <li><a href="type.php?type=<?php echo urlencode($type); ?>"> <?php echo $type; ?></a></li>
            <?php endforeach;  ?>         
        </ul>        
      </li>
      <?php if(isset($_SESSION['myList'])): ?>  
      <li class="pull-right"><a href="/myList.php">My List  <i class="fa fa-heart" aria-hidden="true"></i> </a></li>  
      <?php endif ?>       
    </ul>
  </div>
</nav>