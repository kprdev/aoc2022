<?php

function str2range($str) {
    list ($a, $b) = explode("-", $str);
    $a = (int)$a;
    $b = (int)$b;
    return range($a, $b);
}

function assertSubset($big, $sml) {
    $flip = array_flip($big);
    foreach ($sml as $v) {
        if (!isset($flip[$v])) {
            return false;
        }
    }
    return true;
}

function checkSubsets($a1, $a2) {
    if (assertSubset($a1, $a2) ||
        assertSubset($a2, $a1)) 
    {
        return true;
    }
    return false;
}

if (count($argv) > 1) {
    $input = $argv[1];
} else {
    $input = "input";
}

$file = file_get_contents($input);
$lines = explode("\n", $file);
unset($lines[count($lines)-1]);

$count = 0;
foreach ($lines as $l) {
    list ($e1, $e2) = explode(",", $l);

    $a1 = str2range($e1);
    $a2 = str2range($e2);

    if (checkSubsets($a1, $a2)) {
        $count++;
    }
}

echo ("$count\n");

?>
