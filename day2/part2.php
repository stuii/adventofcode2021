<?php

    $input = Solver::getInput();
    $depth = 0;
    $horizontal = 0;
    $aim = 0;

    foreach (explode("\r\n", $input) as $instruction) {
        list($command, $value) = explode(' ', $instruction);
        switch($command){
            case 'forward':
                $horizontal += $value;
                $depth += ($aim * $value);
                break;
            case 'down':
                $aim += $value;
                break;
            case 'up':
                $aim -= $value;
                break;
        }
    }
    Solver::setResult($depth * $horizontal);
