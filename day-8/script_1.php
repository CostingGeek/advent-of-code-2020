<?php
$list = 'nop +0
acc +1
jmp +4
acc +3
jmp -3
acc -99
acc +1
jmp -4
acc +6';

// digest the list as array
$list_array = explode("\n", $list);
foreach( $list_array as $key => $line )
{
    $list_array[$key] = preg_replace( "/\r|\n/", "", $line );
}

// global variables
$acc = 0; $i = 0; $inst = 0;
$out = array();
$seq = array();
$continue = true;

// handle each pattern
function handle_line( $line )
{
    global $list_array, $acc, $out, $seq, $i, $false, $continue;
    
    // identify return to previously processed operation
    if( !isset( $seq[$line] ) )
    {
        $seq[$line] = $i;
    } else {
        //BIG ERROR
        $seq[$line] .= ",".$i;
        $continue = false;
    }

    // handle each operation
    switch( substr( $list_array[$line], 0, 3 ) )
    {
        case 'nop': // no operation
            $out[$line] = $acc;
            return 1;
            break;
            
        case 'acc': // accumulate
            $acc += (int)substr( $list_array[$line], 3, strlen($list_array[$line]) );
            $out[$line] = $acc;
            return 1;
            break;
            
        case 'jmp': // jump
            $out[$line] = $acc;
            return (int)substr( $list_array[$line], 3, strlen($list_array[$line]) );
            break;
    }
}

// main routine
while( $continue )
{
    $i++;
    $inst += handle_line( $inst );
}

// return output
echo "\n ope\t\t| seq\t\t| acc\n";
echo "------------------------------------------\n";
for( $i = 0; $i < count( $list_array); $i++ )
{
    echo $list_array[$i]."\t";
    if( strlen($list_array[$i]) < 8 ) { echo "\t"; }
    echo "| ";
    if( isset($seq[$i]) )
    {
        echo $seq[$i]."\t";
        if( strlen($seq[$i]) < 6 ) { echo "\t"; }
    } else {
        echo "\t\t";
    }
    echo "| ";
    echo isset($out[$i]) ? $out[$i] : "";
    echo "\n";
}
?>
