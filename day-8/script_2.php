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
function handle_line( $list_array, $line )
{
    global $acc, $out, $seq, $i, $continue;
    
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

// return output
function return_output( $list_array )
{
    global $seq, $out;
    
    echo "\n ope\t\t| seq\t\t| acc\n";
    echo "------------------------------------------\n";
    for( $i = 0; $i < count( $list_array); $i++ )
    {
        echo $i.':'.$list_array[$i]."\t";
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
}

// brute force: process all variations
$j = 0;
$continue_main = true;
while( $continue_main )
{
    $j++;
    
    // initialize all variables
    $continue = true;
    $i = 0; $inst = 0; $acc = 0;
    $out = array(); $seq = array();

    // modify a single instruction
    $list_tmp = $list_array;
    $code = $list_tmp[$j];
    switch( substr($code, 0, 3 ) )
    {
        case 'nop':
           $list_tmp[$j] = 'jmp' .substr($code, 3, strlen($code) );
           break;
           
        case 'jmp':
           $list_tmp[$j] = 'nop' .substr($code, 3, strlen($code) );
           break;
           
        case 'acc':
            continue 2;
    }

    // main routine
    while( $continue )
    {
        $i++;
        $inst += handle_line( $list_tmp, $inst );
        
        // check if routine reached last line: success!
        if( $inst == count($list_array) ) 
        { 
            echo $j . ": " . $code . " => " . $list_tmp[$j] . " => " . $acc . "\n";
            $continue      = false;
            $continue_main = false;
        }
    }

}

return_output( $list_tmp );
?>
