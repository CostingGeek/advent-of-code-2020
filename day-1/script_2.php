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

for( $i = count($list_array) - 1; $i > 0; $i--)
{
    $j = 0;
    for( $j = 0; $j < count($list_array); $j++)
    {
        if( (int)$list_array[$i] + (int)$list_array[$j] > 2020 )
        {
            continue;
        }
        
        $k = 0;
        for( $k = 0; $k < count($list_array); $k++)
        {
            if( (int)$list_array[$i] + (int)$list_array[$j] + (int)$list_array[$k] > 2020 )
            {
                continue;
            }
            
            if( (int)$list_array[$i] + (int)$list_array[$j] + (int)$list_array[$k] == 2020 )
            {
                break 3;
            }
            
        }
    }
}

echo (int)$list_array[$i] . ' * ' . (int)$list_array[$j] . ' * ' . (int)$list_array[$k] . ' = ';
echo (int)$list_array[$i] * (int)$list_array[$j] * (int)$list_array[$k] . "\n";
?>
