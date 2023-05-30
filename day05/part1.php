<?php

function printstacks($s) {
    foreach ($s as $i => $t) {
        echo $i.": ".implode('-', $t), "\n";
    }
}

if (count($argv) > 1) {
    $input = $argv[1];
} else {
    $input = "input";
}

$file = file_get_contents($input);
$lines = explode("\n", $file);
unset($lines[count($lines)-1]);

$stacks = [ 
    [],
    ['R','G','H','Q','S','B','T','N'],
    ['H','S','F','D','P','Z','J'],
    ['Z','H','V'],
    ['M','Z','J','F','G','H'],
    ['T','Z','C','D','L','M','S','R'],
    ['M','T','W','V','H','Z','J'],
    ['T','F','P','L','Z'],
    ['Q','V','W','S'],
    ['W','H','L','M','T','D','N','C']
];

if ($input == "sample") {
    $stacks = [ [], ['z','n'], ['m','c','d'], ['p'] ];
}

foreach ($lines as $l) {
    if (strlen($l) == 0 || $l[0] != 'm') {
        continue;
    }

    list ( , $qty, , $from, , $to) = explode(" ", $l);

    foreach (range(1, $qty) as $i) {
        if ($stacks[$from]) {
            $v = array_pop($stacks[$from]);
            array_push($stacks[$to], $v);
/*
            printstacks($stacks);
            echo "$i / $qty from $from to $to";
            readline();
*/
        }
    }
}
//echo "========\n";

// solution
unset($stacks[0]);
foreach ($stacks as $s){
    echo $s[count($s)-1];
}
echo "\n";

?>
