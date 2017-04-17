<h3>By Type</h3>       
<ul class="list-group">
    <?php $totals = totalByType($list); ?>        
    <?php foreach($totals as $type => $total):?>
    <li class="list-group-item">
        <p><strong><?php echo $type ?><span class="badge">- <?php echo $total ;?></span> </strong></p>
    </li>
    <?php endforeach; ?>
</ul>