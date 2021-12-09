<?php

    $input = Solver::getInput();

    $locations = [];

    foreach (explode("\r\n", $input) as $lineId => $line) {
        $locations[$lineId] = [];
        foreach (str_split($line) as $locationId => $location) {
            $locations[$lineId][$locationId] = $location;
        }
    }

    $maxWidth = $locationId;
    $maxHeight = $lineId;


    $risk = 0;
    for ($x = 0; $x <= $maxWidth; $x++) {
        for ($y = 0; $y <= $maxHeight; $y++) {
            $currentHeight = $locations[$y][$x];
            $isLowest = true;

            foreach (
                [
                    [-1, 0],
                    [0, -1],
                    [1, 0],
                    [0, 1],
                ] as $modifier
            ) {
                if(isset($locations[$y+$modifier[0]][$x+$modifier[1]])){
                    if($locations[$y+$modifier[0]][$x+$modifier[1]] <= $currentHeight){
                        $isLowest = false;
                    }
                }
            }

            if($isLowest){
                //echo 'location at ['.$y.','.$x.'] is a low point with height '.$currentHeight."\r\n";
                $risk += (1 + $currentHeight);
            }

        }
    }


    Solver::setResult($risk);
