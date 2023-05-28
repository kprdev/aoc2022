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

// find the largest 3 totals
$reindex = [];
foreach ($elves as $e) {
    $reindex[$e->total] = $e;
}

ksort($reindex);

$s = count($reindex);
$total = 0;

for ($i = 1; $i <= 3; $i++)
{
    $a = array_pop($reindex);
    var_dump($a->total);
    $total += $a->total;
}

echo "Top 3 add up to : $total.\n";

?>
