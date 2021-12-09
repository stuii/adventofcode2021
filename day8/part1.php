<?php

    $input = Solver::getInput();

    $total = 0;

    foreach(explode("\r\n", $input) as $line){
        foreach(explode(' ', explode(' | ', $line)[1]) as $segments){
            $total += (int)in_array(strlen($segments), [2,3,4,7]);
        }
    }

    Solver::setResult($total);
