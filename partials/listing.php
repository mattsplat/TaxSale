
<tr>    
    <td><?php echo toMoney($item->price); ?></td> 
    <td><?php echo $item->type; ?> </td>
    <td><a href="property.php?id=<?php echo $item->id ; ?>">
        <?php echo $item->address.' '.$item->city; ?>
    </a></td> 
    <td> <?php echo $item->zipcode ?> </td>
    <td><a href="property.php?id=<?php echo $item->id ; ?>"><?php echo $item->id ; ?> </a> </td>
</tr>    


