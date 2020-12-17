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
$dir_x = 0;
$dir_y = 0;
$ang_list = ['N','E','S','W'];
$ang = 1;

// turn the ship either way by 90 deg increments
function turn($side)
{
    global $ang_list, $ang;

    $ang += $side;
        
    if( $ang > 3 ) { $ang -= 4; }
    if( $ang < 0 ) { $ang += 4; }

}

// move in any direction
function move( $dir, $cnt)
{
    global $dir_x, $dir_y, $ang_list, $ang;
    
    switch( $dir )
    {
        case 'N': $dir_y += $cnt; break;
        case 'S': $dir_y -= $cnt; break;
        case 'E': $dir_x += $cnt; break;
        case 'W': $dir_x -= $cnt; break;
            
        case 'L': turn(-1 * $cnt / 90); break;
        case 'R': turn(+1 * $cnt / 90); break;
        
        case 'F': move($ang_list[$ang], $cnt); break;
    }
}

// Initial position
echo "[$dir_x,$dir_y]";
echo " / $ang_list[$ang] \n";

// handle each move instruction
foreach( $list_array as $line )
{
    $dir = substr($line, 0, 1);
    $cnt = substr($line, 1, strlen($line)-1);

    move( $dir, $cnt);
    echo "Move $dir : $cnt\n";
    echo "[$dir_x,$dir_y]";
    echo " / $ang_list[$ang] \n";
}

// Output the ship's ending position
echo "The ship's Manhattan distance is ";
echo abs($dir_x) . " + " . abs($dir_y) . " = ";
echo abs($dir_x) + abs($dir_y);
?>
