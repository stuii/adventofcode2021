<?php

    $input = trim(file_get_contents('./input.txt'));
    $gamma = 0;
    $epsilon = 0;

    $common = [];

    foreach (explode("\r\n", $input) as $rate) {
        foreach(str_split($rate) as $bitPosition => $rateBit){
            if(!isset($common[$bitPosition])){ $common[$bitPosition] = [0 => 0, 1 => 0]; }
            $common[$bitPosition][$rateBit]++;
        }
    }

    foreach($common as $pos => $bits){
        $gamma .= $bits[0] > $bits[1] ? 0 : 1;
        $epsilon .= $bits[0] > $bits[1] ? 1 : 0;
    }

    $gamma = bindec($gamma);
    $epsilon = bindec($epsilon);
    echo 'gamma: '.$gamma."\r\n";
    echo 'epsilon: '.$epsilon."\r\n";
    echo 'solution: '.($gamma * $epsilon);
