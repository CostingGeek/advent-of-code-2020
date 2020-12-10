<?
$list = '35
20
15
25
47
40
62
55
65
95
102
117
150
182
127
219
299
277
309
576';

// digest the list as array
$list_array = explode("\n", $list);
foreach( $list_array as $key => $line )
{
    $list_array[$key] = (int)preg_replace( "/\r|\n/", "", $line );
}

// variables
$pb_len = 5;

// function to check a key against <$len> previous fields
function check_sum( $list, $index, $len )
{
    // keep <$len> previous values
    $list_tmp = array_slice( $list, $index - $len, $len );
    rsort($list_tmp);
    $key = $list[$index];

    $found = false;
    foreach( $list_tmp as $value )
    {
        $target = $key - $value;
        if( array_search( $target, $list_tmp ) )
        {
            $found = true;
            break;
        }
    }
    
    return $found;
}

// scan the <list> for continuous combinations 
// that match the <target> starting from <index>
function scan_sequence( $list, $index, $target )
{
    $tmp = 0; $found = 0;
    for( $j = $index; $j < count( $list ); $j++ )
    {
        $tmp += $list[$j];

        if( $tmp == $target )
        {
            echo "Sum($index,$j) = $tmp \n";
            $found = $j;
            break;
        } elseif ( $tmp > $target ) {
            break;
        }
    }
    
    return $found;
}

// test each value after preamble
for( $i = $pb_len; $i < count( $list_array ); $i++)
{
    if( !check_sum( $list_array, $i, $pb_len ) )
    { 
        break;
    }
}

// return the invalid key
$invalid = $list_array[$i];
echo 'Invalid Key  = '.$invalid." \n";

// find sequence of invalid key
for( $i = 0; $i < count($list_array); $i++ )
{
    $scan = scan_sequence( $list_array, $i, $invalid);
    if(  $scan > 0 )
    {
        break;
    }
}

// filter out the valid sequence
$list_tmp = array_slice( $list_array, $i, $scan - $i + 1 );

// return output
$out = '';
foreach( $list_tmp as $line )
{
    if( $out == '' )
    {
        $out = $line;
    } else {
        $out .= "\n".$line;
    }
}
echo $out."\n";

// find min / max
sort( $list_tmp );
echo 'Min: '.min($list_tmp)."\n";
echo 'Max: '.max($list_tmp)."\n";
echo 'Res: '.( min($list_tmp) + max($list_tmp) )."\n";
?>
