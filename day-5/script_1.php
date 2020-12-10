<?php
$list = 'BFFFBBFRRR
FFFBBBFRRR
BBFFBBFRLL';

// digest the list as array
$list_array = explode("\n", $list);

// function to convert a seat chars to seat id
function derive_seat_id( $ticket )
{
    // convert to binary string
    $ticket_tmp = preg_replace( "/B/", "1", $ticket );
    $ticket_tmp = preg_replace( "/F/", "0", $ticket_tmp );
    $ticket_tmp = preg_replace( "/R/", "1", $ticket_tmp );
    $ticket_tmp = preg_replace( "/L/", "0", $ticket_tmp );
    
    // convert binaries to decimals
    $row_code  = bindec( substr( $ticket_tmp, 0, 7 ) );
    $seat_code = bindec( substr( $ticket_tmp, 7, 3 ) );

    // calculate seat ID
    $seat_id = $row_code * 8 + $seat_code;
    
    // return results
    echo $ticket;
    echo ' => '. $ticket_tmp;
    echo ': row ' . $row_code;
    echo ', column ' . $seat_code;
    echo ', seat ID ' . $seat_id . "\n";
        
    return $seat_id;
}

// convert each line to a ticket and derive seat ID
$seat_array = array();
foreach( $list_array as $line )
{
    $seat_id = derive_seat_id( preg_replace( "/\r|\n/", "", $line ) );
    $seat_array[] = $seat_id;
}

// identify lowest / highest seat IDs
rsort( $seat_array );
echo 'The lowest seat ID is ' . min($seat_array) . "\n";
echo 'The highest seat ID is ' . max($seat_array) . "\n";

?>
