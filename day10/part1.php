<?php

    $input = Solver::getInput();

    $total = 0;

    $openingChars = ['(', '[', '{', '<'];
    $closingChars = ['(' => ')', '[' => ']', '{' => '}', '<' => '>'];

    $penalties = [')' => 3, ']' => 57, '}' => 1197, '>' => 25137];

    $totalPenalties = 0;

    foreach (explode("\r\n", $input) as $problem) {
        $expectedClosures = [];
        foreach (str_split($problem) as $char) {
            if(in_array($char, $openingChars)){
                array_unshift($expectedClosures, $closingChars[$char]);
            } else {
                $expectedChar = array_shift($expectedClosures);
                if($expectedChar != $char){
                    $totalPenalties += $penalties[$char];
                    break;
                }
            }
        }
    }


    Solver::setResult($totalPenalties);
