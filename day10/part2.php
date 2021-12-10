<?php

    $input = Solver::getInput();

    $total = 0;

    $openingChars = ['(', '[', '{', '<'];
    $closingChars = ['(' => ')', '[' => ']', '{' => '}', '<' => '>'];

    $penalties = [')' => 3, ']' => 57, '}' => 1197, '>' => 25137];

    $problems = explode("\r\n", $input);
    $expectedClosures = [];

    foreach ($problems as $problemId => $problem) {
        $expectedClosures[$problemId] = [];
        foreach (str_split($problem) as $char) {
            if(in_array($char, $openingChars)){
                array_unshift($expectedClosures[$problemId], $closingChars[$char]);
            } else {
                $expectedChar = array_shift($expectedClosures[$problemId]);
                if($expectedChar != $char){
                    unset($expectedClosures[$problemId]);
                    break;
                }
            }
        }
    }

    $charScores = [')' => 1, ']' => 2, '}' => 3, '>' => 4];

    $scores = [];
    foreach ($expectedClosures as $problemId => $closure) {
        $score = 0;

        foreach($closure as $char){
            $score *= 5;
            $score += $charScores[$char];
        }
        $scores[] = $score;
    }

    sort($scores);

    Solver::setResult($scores[floor(count($scores)/2)]);
