<?php
$list = '1-3 a: abcde
1-3 b: cdefg
2-9 c: ccccccccc';

// digest the list as array
$list_array = explode("\n", $list);

$nb_valid = 0;
foreach( $list_array as $line )
{
    // break a clean line by white spaces
    $line = preg_replace( "/\r|\n/", "", $line );
    $line_array = explode(" ", $line);

    // identify password
    $password = $line_array[2];
    
    // identify character
    $char = preg_replace( "/:/", "", $line_array[1] );

    // extract letter positions
    $letter_pos     = explode("-", $line_array[0]);
    $letter_pos_1   = (int)$letter_pos[0];
    $letter_pos_2   = (int)$letter_pos[1];
    
    // check positions
    $pass_pos_1 = substr($password,$letter_pos_1 - 1,1);
    $pass_pos_2 = substr($password,$letter_pos_2 - 1,1);
    
    // test that only one condition is true
    $test = ( $pass_pos_1 == $char ? 1 : 0 ) 
          + ( $pass_pos_2 == $char ? 1 : 0 );
    $return = $test == 1 ? 1 : 0;

    echo $line . ' => ';
    echo $password . ' => ';
    echo $char . ' = ' . $pass_pos_1 . ' or ' . $pass_pos_2 . ' => ';
    echo ( $return ? 'PASS' : 'FAIL' );
    echo "\n";
    $nb_valid += $return;
}

echo 'Valid Passwords: ' . $nb_valid;
?>
