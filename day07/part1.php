<?php

class kpdir 
{
    public $name = "";
    public $type = "";
    public $size = 0;

    public $parent = null;
    public $children = array();

    public $path = "";
    public $totalSize = 0;

    public function __construct($name, $type, $size = null, $parent = null)
    {
        $this->name = $name;
        $this->type = $type;
        $this->size = $size;
        if ($parent) {
            $this->parent = $parent;
            $this->path = $parent->path . '/' . $name;
        } else {
            $this->path = "ROOT";
        }
    }

    // Print current Tree
    public function ls($depth = 0)
    {
        $indent = str_repeat(' ', $depth * 2) . '- ' . $this->name;
        if ($this->type == 'dir')
        {
            echo $indent . ' (' . $this->type . ') total-size: ' . $this->totalSize . PHP_EOL;
            foreach ($this->children as $c) 
            {
                $c->ls($depth + 1);
            }
        } else {
            echo $indent . ' (' . $this->type . ', size=' . $this->size . ')' . PHP_EOL;
        }
    }

    public function addChild($name, $type, $size = 0)
    {
        // name, type , size, parent
        switch ($type) 
        {
            case "dir":
                $this->children[$name] = new kpdir($name, $type, $size, $this);
                break;
            case "file":
                $this->children[$name] = new kpdir($name, $type, $size);
                $this->increaseTotalSize($size);
                break;
        }
    }

    private function increaseTotalSize($size) {
        // add size to current total
        $this->totalSize += $size;
        // add size to parent total
        if ($this->parent) 
        {
            $this->parent->increaseTotalSize($size);
        }
    }

    // Final solution part 1
    public function totalLessThan(&$buffer, $qsize) 
    {
        foreach ($this->children as $c) {
            if ($c->type == "dir")
            {
                $c->totalLessThan($buffer, $qsize);
                if (0 < $c->totalSize && $c->totalSize < $qsize)
                {
                    $buffer[] = array( $c->name, $c->totalSize );
                }
            }
        }
    }
}


// get input
if ($argc > 1) {
    $input = $argv[1];
} else {
    $input = "input";
}

$file = file_get_contents($input);
$lines = explode(PHP_EOL, $file, -1);

// init
$rootdir = new kpdir("/", "dir");
$curdir = $rootdir;

// process input
foreach ($lines as $l) {
    // commands
    if ($l[0] == '$')
    {
        $parts = explode(" ", $l);
        $cmd = $parts[1];
        
        switch ($cmd)
        {
            // $ cd NAME
            case "cd":
                $arg = $parts[2];
                if ($arg == "/")
                {
                    $curdir = $rootdir;
                } 
                elseif ($arg == "..")
                {
                    $curdir = $curdir->parent;
                }
                elseif (array_key_exists($arg, $curdir->children))
                {
                    $curdir = $curdir->children[$arg];
                }
                else
                {
                    $curdir->addChild($arg, "dir");
                    $curdir = $curdir->children[$arg];
                }
                echo "CURRENT DIR IS ".$curdir->path."\n";
                break;
            // $ ls
            case "ls":
                // dir NAME
                // 12345 NAME.TXT
                list ($size, $name) = $parts;
                break;
        }
    }
    else
    {
        // response to ls command
        list($size, $name) = explode(" ", $l);
        if ($size == "dir")
        {
            $curdir->addChild($name, "dir");
        }
        else 
        {
            $curdir->addChild($name, "file", (int)$size);
        }
    }

}

// check input processing
//$rootdir->ls();

// Find all of the directories with a total size of at most 100000. 
$hundredkays = [];
$rootdir->totallessThan($hundredkays, 100000);


// What is the sum of the total sizes of those directories?
$sum = 0;
foreach ($hundredkays as $h) {
    $sum += $h[1];
}
echo "\nSum is $sum.\n";

?>
