<?php
$list = '..##.......
#...#...#..
.#....#..#.
..#.#...#.#
.#...##..#.
..#.##.....
.#.#.#....#
.#........#
#.##...#...
#...##....#
.#..#...#.#';

// digest the list as array
$list_array = explode("\n", $list);

// starting parameters
$nb_lines   = count($list_array) - 1;
$line_len   = strlen($list_array[0]);

// scan for trees as a function for reuse
function scan_for_trees( $move_right, $move_down, $debug = false ) 
{
    global $list_array, $nb_lines, $line_len;

    // move along the y-axis
    $pos_x = 0;
    $nb_trees   = 0;
    for( $pos_y = 0; $pos_y < $nb_lines; $pos_y += $move_down  )
    {
        // check if pattern needs to be repeated
        $repeat = floor( $pos_x / $line_len ) + 1;
    
        // repeat the pattern if needed
        $line = '';
        for( $i = 0; $i <= $repeat; $i++ )
        {
            $line .= preg_replace( "/\r|\n/", "", $list_array[$pos_y] );
        }

        // check for trees
        if( substr($line,$pos_x,1) == '#' )
        {
            $char = 'X';
            $nb_trees++;
        } else {
            $char = 'O';
        }
    
        // display result in debug mode
        if( $debug ) 
        {
            $text = '';
            $text .= substr($line,0,$pos_x);
            $text .= $char;
            $text .= substr($line,$pos_x+1)."\n";
            echo $text;
        }
    
        // move along the x-axis
        $pos_x += $move_right;
    }

    // return result
    return $nb_trees;
}

$total_trees = 1;

// Scan for Right 1, down 1.
$nb_trees = scan_for_trees( 1, 1 ); // should be 2
echo 'Scan [1,1] = '  . $nb_trees."\n";
$total_trees *= $nb_trees;

// Scan for Right 3, down 1.
$nb_trees = scan_for_trees( 3, 1 ); // should be 7
echo 'Scan [3,1] = '  . $nb_trees."\n";
$total_trees *= $nb_trees;

// Scan for Right 5, down 1.
$nb_trees = scan_for_trees( 5, 1 ); // should be 3
echo 'Scan [5,1] = '  . $nb_trees."\n";
$total_trees *= $nb_trees;

// Scan for Right 7, down 1.
$nb_trees = scan_for_trees( 7, 1 ); // should be 4
echo 'Scan [7,1] = '  . $nb_trees."\n";
$total_trees *= $nb_trees;

// Scan for Right 1, down 2.
$nb_trees = scan_for_trees( 1, 2 ); // should be 2
echo 'Scan [1,2] = '  . $nb_trees."\n";
$total_trees *= $nb_trees;

echo 'Total Trees: ' . $total_trees;
?>
