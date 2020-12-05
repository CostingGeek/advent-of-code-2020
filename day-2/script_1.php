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

    // remove unnecessary letters
    $pattern = '/[^'.preg_replace( "/:/", "", $line_array[1] ).']/';
    $password_clean = preg_replace( $pattern, "", $line_array[2] );

    // count number of valid letters
    $letter_count = strlen( $password_clean );

    // extract range
    $letter_range = explode("-", $line_array[0]);
    $letter_min   = (int)$letter_range[0];
    $letter_max   = (int)$letter_range[1];
    
    // check if number of letters is within range
    if( $letter_count >= $letter_min 
     && $letter_count <= $letter_max )
    {
        $return = 1;
    } else { 
        $return = 0;
    }

    echo $line . ' => ';
    echo $password_clean . ' => ';
    echo $letter_min . '<=' . $letter_count . '<=' . $letter_max . ' => ';
    echo ( $return ? 'PASS' : 'FAIL' );
    echo "\n";
    $nb_valid += $return;
}

echo 'Valid Passwords: ' . $nb_valid;
?>
