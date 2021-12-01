<?php

    $input = file_get_contents('./input.txt');

    $prevDepths = [];
    $increments = 0;

    foreach (explode("\r\n", $input) as $key => $depth) {
        $prevDepths[$key] = $depth;

        for ($offset = 1; $offset <= 2; $offset++) {
            if (isset($prevDepths[$key - $offset])) {
                $prevDepths[$key - $offset] += (int)$depth;
            }
        }
        if ($key >= 3) {
            if($prevDepths[$key - 3] < $prevDepths[$key - 2]){ $increments++; }
        }
    }

    echo $increments;
