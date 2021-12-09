<?php

    $input = Solver::getInput();
    $depth = 0;
    $horizontal = 0;

    foreach (explode("\r\n", $input) as $instruction) {
        list($command, $value) = explode(' ', $instruction);
        switch($command){
            case 'forward':
                $horizontal += $value;
                break;
            case 'down':
                $depth += $value;
                break;
            case 'up':
                $depth -= $value;
                break;
        }
    }
    Solver::setResult($depth * $horizontal);
