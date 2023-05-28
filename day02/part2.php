<?php


function rpsScore2($line)
{
    // A for Rock, B for Paper, and C for Scissors
    // X for LOSE, Y for DRAW, and Z for WIN
/*
    1 1 LOSE 3
    2 1 LOSE 1
    3 1 LOSE 2
    1 2 DRAW 1
    2 2 DRAW 2
    3 2 DRAW 3
    1 3 WIN  2
    2 3 WIN  3
    3 3 WIN  1
*/

    $a = str_ireplace( 
        array('a', 'b', 'c', 'x', 'y', 'z'),
        array('1', '2', '3', '1', '2', '3'),
        $line);

    $them = (int)$a[0];
    $rslt = (int)$a[2];

    $lose = array(0, 3, 1, 2);
    $win = array(0, 2, 3, 1);

    if ($rslt == 1) 
    {
        $ours = $lose[$them];
        $outcome = 0;
    }
    elseif ($rslt == 2)
    {
        $ours = $them;
        $outcome = 3;
    }
    elseif ($rslt == 3) 
    {
        $ours = $win[$them];
        $outcome = 6;
    }

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
    $totalScore += rpsScore2($l);
}

var_dump($totalScore);
?>
