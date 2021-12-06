<?php

    $input = trim(file_get_contents('./input.txt'));
    $lanternfishes = explode(',', $input);

    var_dump($lanternfishes);
    for($i = 0; $i < 80; $i++){
        foreach($lanternfishes as $key => $timeout){
            if($timeout == 0){
                $lanternfishes[] = 8;
                $lanternfishes[$key] = 6;
            } else {
                $lanternfishes[$key]--;
            }
        }
    }

    echo count($lanternfishes);
