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

    $directions = [
        [-1, 0],
        [0, -1],
        [1, 0],
        [0, 1],
    ];

    $lowPoints = [];

    $risk = 0;
    for ($x = 0; $x <= $maxWidth; $x++) {
        for ($y = 0; $y <= $maxHeight; $y++) {
            $currentHeight = $locations[$y][$x];
            $isLowest = true;

            foreach ($directions as $modifier) {
                if(isset($locations[$y+$modifier[0]][$x+$modifier[1]])){
                    if($locations[$y+$modifier[0]][$x+$modifier[1]] <= $currentHeight){
                        $isLowest = false;
                    }
                }
            }

            if($isLowest){
                //echo 'location at ['.$y.','.$x.'] is a low point with height '.$currentHeight."\r\n";
                $lowPoints[] = [$y,$x];
            }

        }
    }

    $basins = [];

    foreach($lowPoints as $startingPoint){
        $basin = [$startingPoint];
        $lastPoints = $basin;

        while(count($lastPoints) > 0){
            $newPoints = [];

            foreach($lastPoints as $point){
                foreach ($directions as $modifier) {
                    if(isset($locations[$point[0]+$modifier[0]][$point[1]+$modifier[1]])){
                        if($locations[$point[0]+$modifier[0]][$point[1]+$modifier[1]] < 9){
                            if(!in_array([($point[0]+$modifier[0]),($point[1]+$modifier[1])], [...$basin, ...$newPoints])) {
                                $newPoints[] = [($point[0] + $modifier[0]), ($point[1] + $modifier[1])];
                            }
                        }
                    }
                }
            }

            $basin = [...$basin, ...$newPoints];
            $lastPoints = $newPoints;
        }
        $basins[] = $basin;
    }

    usort($basins, function($a,$b){
        return (count($a) <=> count($b))*-1;
    });

    $total = false;
    foreach(array_slice($basins, 0,3) as $item){
        if($total === false){
            $total = count($item);
        } else {
            $total *= count($item);
        }
    }

    Solver::setResult($total);
