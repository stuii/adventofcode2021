<?php

    $input = trim(file_get_contents('./input.txt'));
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
    echo 'aim: '.$aim."\r\n";
    echo 'depth: '.$depth."\r\n";
    echo 'horizontal: '.$horizontal."\r\n";
    echo 'solution: '.($depth * $horizontal);
