<?php

if ($argc > 1) {
    $input = $argv[1];
} else {
    $input = "input";
}

if ($input == "input") {
    $line = file_get_contents($input);
} else {
    $line = $input;
}


$place = findMarker($line, 14);
echo "first marker after character ".$place."\n";

function findMarker($text, $length) {
    $count = strlen($text);
    for ($i = 0; $i <= $count - $length; $i++) {
        $unique = count(array_unique(str_split(substr($text, $i, $length))));

        if ($unique == $length) {
            return $i + $length;
        }
    }
}

?>
