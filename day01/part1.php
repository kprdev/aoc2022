<?php

class elfClass
{
    public $food = [];
    public $total = 0;

    function addFood($value)
    {
        $this->food[] = $value;
        $this->total += $value;
    }

    function getTotal()
    {
        return $this->total;
    }
}


if (count($argv) > 1)
    $input = $argv[1];
else
    $input = 'input';


$file = file_get_contents($input);
$lines = explode("\n", $file);

$elves = [];
$ecount = 0;

// Tally the elves
foreach ($lines as $i => $line)
{
    if ($ecount == 0 ||
        strlen($line) == 0)
    {
        $elves[] = new elfClass;
        $ecount++;
    }

    if (strlen($line) == 0)
    {
        continue;
    }

    $elves[$ecount-1]->addFood((int)$line);
}

echo "There are $ecount elves.\n";

// find the largest total
$largest = new elfClass;
foreach ($elves as $e)
{
    if ($e->total > $largest->total)
    {
        unset($largest);
        $largest = clone($e);
    }
}

var_dump($largest);

?>
