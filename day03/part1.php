<?php

function uniques($string)
{
    $l = str_split($string);
    $l = array_unique($l);
    sort($l);

    return $l;
}

if (count($argv) > 1)
    $input = $argv[1];
else
    $input = 'input';


$file = file_get_contents($input);
$lines = explode("\n", $file);
unset($lines[count($lines)-1]);

$priority = ['HI',
    'a','b','c','d','e','f','g','h','i','j','k','l','m',
    'n','o','p','q','r','s','t','u','v','w','x','y','z',
    'A','B','C','D','E','F','G','H','I','J','K','L','M',
    'N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];
$priority = array_flip($priority);

$total_priority = 0;

foreach ($lines as $l) {
    list ($a, $b) = str_split($l, strlen($l) / 2);

    $ua = uniques($a);
    $ub = uniques($b);

    $c = array_intersect($ua, $ub);
    sort($c);
    $total_priority += $priority[$c[0]];
}

var_dump($total_priority);

?>
