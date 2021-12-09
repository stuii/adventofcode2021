<?php

    $input = Solver::getInput();

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

    foreach($positions as $position => &$fuel){
        foreach($crabs as $crab){
            $fuel += abs($crab - $position);
        }
    }
    unset($fuel);
    asort($positions);

    Solver::setResult(array_shift($positions));
