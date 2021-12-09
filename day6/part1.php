<?php

    $input = Solver::getInput();
    $lanternfishes = explode(',', $input);

    for($i = 0; $i < 80; $i++){
        foreach($lanternfishes as $key => $timeout){
            if($timeout == 0){
                $lanternfishes[] = 8;
                $lanternfishes[$key] = 6;
            } else {
                $lanternfishes[$key]--;
            }
        }
    }

    Solver::setResult(count($lanternfishes));
