<h3>Money</h3>                
<ul class="list-group">
    <li class="list-group-item">
        Total of all Minimum Bids: <span class="pull-right"><?php echo toMoney(allMinimumTotal($list)); ?></span>
    </li>
    <li class="list-group-item">
        Average Minimum Bid: <span class="pull-right"><?php echo toMoney(getAverage($list)) ; ?></span>
    </li>
    <li class="list-group-item">
        Lowest Minimum Bid: <span class="pull-right"><?php echo toMoney(getLowest($list) ) ; ?></span>
    </li>
    <li class="list-group-item">
        Highest Minimum Bid: <span class="pull-right"><?php echo toMoney(getHighest($list)) ; ?></span>
    </li
</ul>