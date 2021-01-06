<?php
$list = '939
7,13,x,x,59,x,31,19';

// digest the list as array
$list_array = explode("\n", $list);
foreach( $list_array as $key => $line )
{
    $list_array[$key] = preg_replace( "/\r|\n/", "", $line );
}

// parse information
$time_0 = $list_array[0];
$bus_array = explode(",", $list_array[1]);
$bus_array = array_diff( $bus_array, ['x'] );

// find next time for each bus
$time_array = array();
foreach( $bus_array as $bus )
{
    $time_array[$bus] = ceil( $time_0 / $bus ) * $bus;
}

// calculate time for next bus
asort( $time_array );
foreach( $time_array as $key => $time )
{
    echo "The next bus is ID $key will arrive in ".($time - $time_0)." minutes\n";
    echo "The result key is ".($time - $time_0) * $key;
    break;
}
