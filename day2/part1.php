<?php

    $input = trim(file_get_contents('./input.txt'));
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
    echo 'depth: '.$depth."\r\n";
    echo 'horizontal: '.$horizontal."\r\n";
    echo 'solution: '.($depth * $horizontal);
