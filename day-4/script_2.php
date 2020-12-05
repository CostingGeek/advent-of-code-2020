<?php
$list = 'eyr:1972 cid:100
hcl:#18171d ecl:amb hgt:170 pid:186cm iyr:2018 byr:1926

iyr:2019
hcl:#602927 eyr:1967 hgt:170cm
ecl:grn pid:012533040 byr:1946

hcl:dab227 iyr:2012
ecl:brn hgt:182cm pid:021572410 eyr:2020 byr:1992 cid:277

hgt:59cm ecl:zzz
eyr:2038 hcl:74454a iyr:2023
pid:3556412378 byr:2007

pid:087499704 hgt:74in ecl:grn iyr:2012 eyr:2030 byr:1980
hcl:#623a2f

eyr:2029 ecl:blu cid:129 byr:1989
iyr:2014 pid:896056539 hcl:#a97842 hgt:165cm

hcl:#888785
hgt:164cm byr:2001 iyr:2015 cid:88
pid:545766238 ecl:hzl
eyr:2022

iyr:2010 hgt:158cm hcl:#b6652a ecl:blu byr:1944 eyr:2021 pid:093154719';

// break passports by empty lines
$list_new = preg_replace( "/\r\n\r\n/", "---", $list );
$list_new = preg_replace( "/\r\n/", " ", $list_new );

// digest the list as array
$list_array = explode("---", $list_new);

// parameters
$req_array = ['byr','iyr','eyr','hgt','hcl','ecl','pid']; //skipping pid
$ecl_array = ['amb','blu','brn','gry','grn','hzl','oth']; //valid eye colors
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
        
        switch( $line_values[0] )
        {
            case 'byr':
                if( $line_values[1] >= 1920 
                 && $line_values[1] <= 2002 )
                {
                    $req_nb++;
                }
                break;
        
            case 'iyr':
                if( $line_values[1] >= 2010 
                 && $line_values[1] <= 2020 )
                {
                    $req_nb++;
                }
                break;
                
            case 'eyr':
                if( (int)$line_values[1] >= 2020 
                 && (int)$line_values[1] <= 2030 )
                {
                    $req_nb++;
                }
                break;
                
            case 'hgt':
                $code   = substr($line_values[1],strlen($line_values[1])-2,2);
                $height = (int)substr($line_values[1],0,strlen($line_values[1])-2);
                switch( $code )
                {
                    case 'cm':
                        if( $height >= 150 
                        && $height <= 193 )
                        {
                            $req_nb++;
                        }
                        break;
                    
                    case 'in':
                        if( $height >= 59 
                        && $height <= 76 )
                        {
                            $req_nb++;
                        }
                        break;
                }
                break;
                
            case 'hcl':
                if( substr($line_values[1],0,1) != '#' ) { break; }
                $value = substr($line_values[1],1,strlen($line_values[1])-1);
                
                if( preg_match("/[0-9a-f]{6}/", $value ) )
                {
                    $req_nb++;
                }
                break;
                
            case 'ecl':
                if( in_array($line_values[1],$ecl_array) )
                {
                    $req_nb++;
                }
                break;
                
            case 'pid':
                if( preg_match("/[0-9]{9}/", $line_values[1] ) )
                {
                    $req_nb++;
                }
                break;
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
    echo '('.$req_nb.')'."\n";
}

// Return result
echo 'Total Valid: '.$tot_pass;
