<?php

    $input = trim(file_get_contents('./input.txt'));

    $total = 0;

    foreach(explode("\r\n", $input) as $line){
        foreach(explode(' ', explode(' | ', $line)[1]) as $segments){
            $total += (int)in_array(strlen($segments), [2,3,4,7]);
        }
    }

    echo 'solution: '.$total;
