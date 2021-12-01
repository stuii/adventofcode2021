<?php

    $input = file_get_contents('./input.txt');
    $prevDepth = false;
    $increments = 0;

    foreach (explode("\r\n", $input) as $depth) {
        if ($prevDepth !== false) {
            if ($prevDepth < $depth) {
                $increments++;
            }
        }

        $prevDepth = $depth;
    }
    echo $increments;
