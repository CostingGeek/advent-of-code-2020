<?php
$list = 'F10
N3
F7
R90
F11';

// digest the list as array
$list_array = explode("\n", $list);
foreach( $list_array as $key => $line )
{
    $list_array[$key] = preg_replace( "/\r|\n/", "", $line );
}

// initial parameters
$pos_x = 0;
$pos_y = 0;
$wpt_x = 10;
$wpt_y = 1;

// turn the ship either way by 90 deg increments
function turn($side)
{
    global $pos_x, $pos_y, $wpt_x, $wpt_y;

    for( $i = 0; $i< abs($side); $i++)
    {
        $diff_x = $wpt_x - $pos_x;
        $diff_y = $wpt_y - $pos_y;

        if( $side > 0 )
        {
            $wpt_x = $pos_x + $diff_y;
            $wpt_y = $pos_y - $diff_x;
        } else {
            $wpt_x = $pos_x - $diff_y;
            $wpt_y = $pos_y + $diff_x;
        }
    }

}

// move towards the waypoint
function forward($cnt)
{
    global $pos_x, $pos_y, $wpt_x, $wpt_y;
    
    echo "Forward $cnt times\n";
    
    $diff_x = $wpt_x - $pos_x;
    $diff_y = $wpt_y - $pos_y;
    
    $pos_x += $cnt * $diff_x;
    $pos_y += $cnt * $diff_y;
    
    $wpt_x = $pos_x + $diff_x;
    $wpt_y = $pos_y + $diff_y;
}

// move in any direction
function move( $dir, $cnt)
{
    global $pos_x, $pos_y, $wpt_x, $wpt_y;
    
    switch( $dir )
    {
        case 'N': $wpt_y += $cnt; break;
        case 'S': $wpt_y -= $cnt; break;
        case 'E': $wpt_x += $cnt; break;
        case 'W': $wpt_x -= $cnt; break;
            
        case 'L': turn(-1 * $cnt / 90); break;
        case 'R': turn(+1 * $cnt / 90); break;
        
        case 'F': forward($cnt); break;
    }
}

// Initial position
echo "S[$pos_x,$pos_y] - ";
echo "W[$wpt_x,$wpt_y]\n";

// handle each move instruction
foreach( $list_array as $line )
{
    $dir = substr($line, 0, 1);
    $cnt = substr($line, 1, strlen($line)-1);

    move( $dir, $cnt);
    echo "Move $dir : $cnt => ";
    echo "S[$pos_x,$pos_y] - ";
    echo "W[$wpt_x,$wpt_y]\n";
}

// Output the ship's ending position
echo "The ship's Manhattan distance is ";
echo abs($pos_x) . " + " . abs($pos_y) . " = ";
echo abs($pos_x) + abs($pos_y);
?>
