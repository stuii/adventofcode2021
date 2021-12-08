<?php

    $input = trim(file_get_contents('./input.txt'));

    $crabs = explode(',', $input);

    $minPos = false;
    $maxPos = false;

    foreach($crabs as $crab){
        $minPos = $minPos === false ? $crab : ($minPos < $crab ? $minPos : $crab);
        $maxPos = $maxPos === false ? $crab : ($maxPos > $crab ? $maxPos : $crab);
    }

    $positions = [];
    for($i = $minPos; $i <= $maxPos; $i++){
        $positions[$i] = 0;
    }

    $fuelForLevels = [];

    foreach($positions as $position => &$fuel){
        foreach($crabs as $crabId => $crab){
            $levelsToTravel = abs($crab - $position);
            if(isset($fuelForLevels[$levelsToTravel])){
                $fuel += $fuelForLevels[$levelsToTravel];
            } else {
                $fuelForLevels[$levelsToTravel] = 0;
                for ($f = 0; $f <= $levelsToTravel; $f++) {
                    $fuelForLevels[$levelsToTravel] += $f;
                }
                $fuel += $fuelForLevels[$levelsToTravel];
            }
        }
    }
    unset($fuel);
    asort($positions);

    echo 'solution: '.array_shift($positions);
