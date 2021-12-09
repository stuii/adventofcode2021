<?php

    $input = Solver::getInput();
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
    Solver::setResult($increments);
