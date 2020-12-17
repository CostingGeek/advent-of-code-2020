<?php
// Initial Seat Map
$list = 'L.LL.LL.LL
LLLLLLL.LL
L.L.L..L..
LLLL.LL.LL
L.LL.LL.LL
L.LLLLL.LL
..L.L.....
LLLLLLLLLL
L.LLLLLL.L
L.LLLLL.LL';

// digest the list as array
$list_array_tmp = array();
$list_array = explode("\n", $list);
foreach( $list_array as $key => $line )
{
    $list_array[$key] = str_split( preg_replace( "/\r|\n/", "", $line ) );
}

// check if seat is occupied
function check_seat( $scan_y, $scan_x, $add_y, $add_x )
{
    global $list_array;

    $scan_x += $add_x;
    $scan_y += $add_y;

    // scan visible seats
    while( isset($list_array[$scan_y][$scan_x]) )
    {
        if( $list_array[$scan_y][$scan_x] == '#' )
        { 
            return 1; 
        } elseif( $list_array[$scan_y][$scan_x] == 'L' ) {
            return 0; 
        }
        
        
        $scan_x += $add_x;
        $scan_y += $add_y;
    }
    
    return 0;
}

// count number of occupied adjacent seats
function count_adjacent( $line, $pos )
{
    $count = 0;
    
    $count += check_seat( $line, $pos, -1,  -1 ); // upper left
    $count += check_seat( $line, $pos, -1,   0 ); // upper center
    $count += check_seat( $line, $pos, -1,   1 ); // upper right
    $count += check_seat( $line, $pos,  0,  -1 ); // middle left
    //$count += check_seat( $line, $pos );          // middle center
    $count += check_seat( $line, $pos,  0,   1 ); // middle right
    $count += check_seat( $line, $pos,  1,  -1 ); // lower left
    $count += check_seat( $line, $pos,  1,   0 ); // lower center
    $count += check_seat( $line, $pos,  1,   1 ); // lower right
    
    return $count;
}

// fill out seats based on current status
// return number of changes
function fill_seats( )
{
    global $list_array, $list_array_tmp;
    $change = 0;
    
    // loop through each row
    foreach( $list_array as $i => $line_array )
    {
        // loop through each seat
        foreach( $line_array as $j => $pos )
        {
            // count number of adjacent occupied seats
            $adj = count_adjacent( $i, $j ); 
            
            // if a seat is empty (L) 
            // and there are no occupied seats adjacent to it, 
            // the seat becomes occupied.
            if( $list_array[$i][$j] == 'L' && $adj == 0 )
            {
                $list_array_tmp[$i][$j] = '#'; // occupy seat
                $change++;
            }
            
            // if a seat is occupied (#) 
            // and four or more seats adjacent to it are also occupied, 
            // the seat becomes empty.
            if( $list_array[$i][$j] == '#' && $adj > 4 )
            {
                $list_array_tmp[$i][$j] = 'L'; // leave seat
                $change++;
            }
        }
    }
    
   return $change; 
}

// print ouput
function print_output( )
{
    global $list_array;
    $out = '';
    
    foreach( $list_array as $line_array )
    {
        foreach( $line_array as $pos )
        {
            $out .= $pos;
        }
    
        $out .= "\n";
    }
    
    $out .= "\n";
    return $out;
}

// how many seats end up occupied?
function count_occupied( )
{
    global $list_array;
    $occ = 0;
    
    foreach( $list_array as $line_array )
    {
        foreach( $line_array as $pos )
        {
            if( $pos == '#' )
            {
                $occ++;
            }
        }
    }
    
    return $occ;
}

// main loop
$done = -1;
$i = 0;

echo "Round 0\n";
echo print_output( );

do {
    $i++;
    
    $list_array_tmp = $list_array;
    $done = fill_seats();
    $list_array = $list_array_tmp;
    
    echo "Round $i - $done changes\n";
    //echo print_output( );

} while( $done != 0 );

echo print_output( );
$occ = count_occupied();
echo "We count $occ occupied seats\n";
?>
