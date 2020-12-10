<?
$list = '28
33
18
42
31
14
46
20
48
47
24
23
49
45
19
38
39
11
1
32
25
35
8
17
7
9
4
2
34
10
3';

// digest the list as array
$list_array = explode("\n", $list);
foreach( $list_array as $key => $line )
{
    $list_array[$key] = (int)preg_replace( "/\r|\n/", "", $line );
}
sort( $list_array );

// parameters
$seed = 0;
$gap  = 3;
$seq_list = array();
$gap_list = array();
$gap_list[1] = 0;
$gap_list[2] = 0;
$gap_list[3] = 0;

// append outlet and device value
//array_unshift( $list_array, 0 );
$list_array[] = max($list_array) + 3;

function build_sequence( $root, $seed, $count = 0  )
{
    global $list_array, $gap, $seq_list;

    if( $count == count( $list_array ) )
    {
        $seq_list[] = $root;
        return true;
    }
    
    for( $i = $count; $i < count( $list_array ); $i++ )
    {
        if( $list_array[$i] > $seed + $gap )
        {
            return false;
        } 
        
        build_sequence( $root.', '.$list_array[$i], $list_array[$i], $i + 1 );

    }

    return true;
}

// call the recursive function
build_sequence( '0', $seed );

// return output
echo "There are ".count( $seq_list )." combinations:\n";
foreach( $seq_list as $seq )
{
    echo $seq."\n";
}
?>
