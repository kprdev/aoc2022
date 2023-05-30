<?php

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

    $slice = array_slice($stacks[$from], -$qty);
    foreach ($slice as $c) {
        $stacks[$to][] = $c;
    }

    foreach (range(1, $qty) as $i) {
        array_pop($stacks[$from]);
    }

}


foreach (range(1,count($stacks)-1) as $i) {
    $s = $stacks[$i];
    echo $s[count($s)-1];
}
echo "\n";

?>
