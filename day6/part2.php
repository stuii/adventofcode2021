<?php

    $input = Solver::getInput();
    $input = explode(',', $input);

    $lanternfishes = array_fill(0,9,0);
    foreach($input as $item){
        $lanternfishes[$item]++;
    }

    // work smarter, not harder

    for($i = 0; $i < 256; $i++) {
        $newLanternfishes = array_fill(0, 9, 0);
        foreach ($lanternfishes as $timeout => $count) {
            if ($timeout == 0) {
                $newLanternfishes[8] = $count;
                $newLanternfishes[6] = $count;
            } else {
                $newLanternfishes[$timeout - 1] += $count;
            }
        }
        $lanternfishes = $newLanternfishes;

    //echo 'day '.($i + 1).': '.array_sum(array_values($lanternfishes))."\r\n";
    }

    Solver::setResult(array_sum(array_values($lanternfishes)));

