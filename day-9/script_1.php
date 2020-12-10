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
    
    if( $found )
    {
        echo $key.' = '.$value.' + '.$target."\n";
    }
    
    return $found;
}

// variables
$pb_len = 5;

// test each value after preamble
for( $i = $pb_len; $i < count( $list_array ); $i++)
{
    if( !check_sum( $list_array, $i, $pb_len ) )
    { 
        break;
    }
}

echo 'Invalid Key: '.$list_array[$i];
?>
