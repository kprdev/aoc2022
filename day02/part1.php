<?php

function rps_score($line)
{
    // A for Rock, B for Paper, and C for Scissors
    // X for Rock, Y for Paper, and Z for Scissors
/*
    1 1  tie
    2 2  tie
    3 3  tie

    1 2  right
    2 3  right

    3 1  right

    2 1  left
    3 2  left

    1 3  left
*/

    $a = str_ireplace( 
        array('a', 'b', 'c', 'x', 'y', 'z'),
        array('1', '2', '3', '1', '2', '3'),
        $line);

    $them = (int)$a[0];
    $ours = (int)$a[2];

    if ($them == $ours)
        $outcome = 3;
    elseif ($them == $ours - 1)
        $outcome = 6;
    elseif ($them == 3 && $ours == 1)
        $outcome = 6;
    elseif ($them == $ours + 1)
        $outcome = 0;
    else
        $outcome = 0;

    $score = $outcome + $ours;
    return $score;
}

if (count($argv) > 1)
    $input = $argv[1];
else
    $input = 'input';

$file = file_get_contents($input);
$lines = explode("\n", $file);
unset($lines[count($lines)-1]);

$totalScore = 0;
foreach ($lines as $l)
{
    $totalScore += rps_score($l);
}

var_dump($totalScore);
?>
