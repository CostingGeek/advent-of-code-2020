<?php
$list = 'ecl:gry pid:860033327 eyr:2020 hcl:#fffffd
byr:1937 iyr:2017 cid:147 hgt:183cm

iyr:2013 ecl:amb cid:350 eyr:2023 pid:028048884
hcl:#cfa07d byr:1929

hcl:#ae17e1 iyr:2013
eyr:2024
ecl:brn pid:760753108 byr:1931
hgt:179cm

hcl:#cfa07d eyr:2025 pid:166559648
iyr:2011 ecl:brn hgt:59in';

// break passports by empty lines
$list_new = preg_replace( "/\r\n\r\n/", "---", $list );
$list_new = preg_replace( "/\r\n/", " ", $list_new );

// digest the list as array
$list_array = explode("---", $list_new);

// parameters
$req_array = ['byr','iyr','eyr','hgt','hcl','ecl','pid']; //skipping pid
$req_pass = 7;

// treat package by package
$tot_pass = 0;
foreach( $list_array as $line )
{
    // break a clean line by white spaces
    $line = preg_replace( "/\r|\n/", "", $line );
    $line_array = explode(" ", $line);
    
    // check each key against the list of valid keys
    $req_nb = 0;
    foreach( $line_array as $line_tmp ) 
    {
        $line_values = explode(":", $line_tmp);
        
        if( in_array( $line_values[0], $req_array ) )
        {
            $req_nb++;
        }
    }
    
    // Test number of keys for fail / pass
    echo $line.' => ';
    if( $req_nb >= $req_pass )
    {
        $tot_pass++;
        echo 'PASS';
    } else {
        echo 'FAIL';
    }
    echo "\n";
}

// Return result
echo 'Total Valid: '.$tot_pass;
