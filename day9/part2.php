<?php

    $input = trim(file_get_contents('./input.txt'));

    $segmentValues = [
        [1,1,1,0,1,1,1],
        [0,0,1,0,0,1,0],
        [1,0,1,1,1,0,1],
        [1,0,1,1,0,1,1],
        [0,1,1,1,0,1,0],
        [1,1,0,1,0,1,1],
        [1,1,0,1,1,1,1],
        [1,0,1,0,0,1,0],
        [1,1,1,1,1,1,1],
        [1,1,1,1,0,1,1],
    ];


    $total = 0;

    foreach(explode("\r\n", $input) as $line){

        $encodingMap = [false,false,false,false,false,false,false];

        list($input, $encoded) = explode(' | ', $line);
        $input = explode(' ',$input);
        $encoded = explode(' ',$encoded);

        $segmentOccurrences = [0,0,0,0,0,0,0];
        foreach($input as $item){
            foreach(str_split($item) as $seg){
                $segmentOccurrences[ord($seg)-97]++;
            }
        }
        // 4 occurrences = seg e[4]
        // 6 occurrences = seg b[1]
        // 9 occurrences = seg f[5]
        // 8 occurrences = seg a[0] / c[2]
        // 7 occurrences = seg d[3] / g[6]

        $encodingMap[array_search(4, $segmentOccurrences)] = 4;
        $encodingMap[array_search(6, $segmentOccurrences)] = 1;
        $encodingMap[array_search(9, $segmentOccurrences)] = 5;


        // find number 4
        $numberFour = array_filter($input, function($a){if(strlen($a) == 4){ return true;}});
        foreach(str_split(array_values($numberFour)[0]) as $seg){
            if($encodingMap[ord($seg)-97] === false){
                $encodingMap[ord($seg)-97] = $segmentOccurrences[ord($seg)-97] == 8 ? 2 : 3;
            }
        }


        // find number 7
        $numberSeven = array_filter($input, function($a){if(strlen($a) == 3){ return true;}});
        foreach(str_split(array_values($numberSeven)[0]) as $seg){
            if($encodingMap[ord($seg)-97] === false){
                $encodingMap[ord($seg)-97] = 0;
            }
        }

        $missingValue = array_keys(array_fill(0,7,true));
        $missingKey = false;
        foreach($encodingMap as $key => $item){
            if($item !== false){
                unset($missingValue[$item]);
            } else {
                $missingKey = $key;
            }
        }
        $encodingMap[$missingKey] = array_keys($missingValue)[0];

        // 🤩 wow full encoding map



        // now onto decoding

        $decodedNumber = '';
        foreach($encoded as $encodedNumber){
            $segments = [0,0,0,0,0,0,0];
            foreach(str_split($encodedNumber) as $seg){
                $segments[$encodingMap[ord($seg)-97]] = 1;
            }
            $decodedNumber .= array_search($segments, $segmentValues);
        }
        $total += (int)$decodedNumber;
    }

    echo 'solution: '.$total;
