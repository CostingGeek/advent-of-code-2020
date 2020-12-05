<?php
$list = '1721
979
366
299
675
1456';

// digest the list as array
$list_array = explode("\n", $list);

// sort the list
sort( $list_array );

// search for matching value
for( $i = count($list_array) - 1; $i > 0; $i--)
{
    $target = 2020 - (int)$list_array[$i]; 
    if( in_array( $target, $list_array )  )
    { 
        break;
    }
}

// return values
echo (int)$list_array[$i] . ' * ' . $target . ' = ';
echo (int)$list_array[$i] * $target . "\n";
?>
