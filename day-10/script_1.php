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
$gap_list = array();
$gap_list[1] = 0;
$gap_list[2] = 0;
$gap_list[3] = 0;

// append device value
$list_array[] = max($list_array) + 3;

// walk the list of adapters
foreach( $list_array as $line )
{
    $diff = $line - $seed;
    $seed = $line;
    $gap_list[$diff]++;
}

// return results
echo "There are:\n";
echo $gap_list[1]." differences of 1 jolt\n";
echo $gap_list[2]." differences of 2 jolts\n";
echo $gap_list[3]." differences of 3 jolts\n";

echo "The number of 1-jolt differences multiplied by the number of 3-jolt differences = ". ($gap_list[1] * $gap_list[3]);
?>
