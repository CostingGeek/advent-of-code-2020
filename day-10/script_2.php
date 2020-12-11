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
$adapters = explode("\n", $list);
foreach( $adapters as $key => $line )
{
    $adapters[$key] = (int)preg_replace( "/\r|\n/", "", $line );
}
sort( $adapters );

$paths = [end($adapters)=>1];
$values = array_flip($adapters)+[0=>1];

function get($i,$offset,$paths){
  return $paths[$i+$offset] ?? 0;
}

for ($i = end($adapters) - 1; $i >= 0; $i--) {
  if(isset($values[$i])){
    $paths[$i] = array_reduce(
      array_map(function($jump) use($i,$paths){
        return get($i,$jump,$paths);
      }, [1,2,3])
    ,function($a,$b){
      return $a+$b;
    });
  }
}

// return output
echo "Part 2: ". $paths[0];
?>
