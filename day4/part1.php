<?php

    $input = trim(file_get_contents('./input.txt'));
    $instructions = [];
    $boards = [];

    $skipped = 1;
    foreach (explode("\r\n", $input) as $key => $row) {
        if(trim($row) == ''){ $skipped++; continue; }
        if($key === 0){
            $instructions = explode(',', $row);
        }
        if($key > 1){
            $boardId = floor(($key-$skipped)/5);
            $rowId = $key - (($boardId * 5) + $skipped);

            if(!isset($boards[$boardId])) { $boards[$boardId] = []; }
            $columns = [];
            for($i = 0;$i < 5; $i++){
                $columns[trim(substr($row, ($i*3), 2))] = false;
            }
            $boards[$boardId][$rowId] = $columns;
        }
    }

    foreach($instructions as $instruction){
        for($b = 0; $b < count($boards); $b++) {
            for ($r = 0; $r < 5; $r++) {
                if(isset($boards[$b][$r][$instruction])){
                    $boards[$b][$r][$instruction] = true;
                }
            }
        }
        $solve = checkForSolve($boards);
        if($solve !== false){
            echo 'instruction: '.$instruction."\r\n";
            echo 'score: '.($solve * $instruction)."\r\n";
            die();
        }
    }




    function checkForSolve($boards): int|bool
    {
        foreach($boards as $boardId => $board){
            $isSolved = false;
            $cols = array_fill(0,5,0);

            foreach($board as $rowId => $row){
                $rows = 0;
                $colId = 0;
                foreach($row as $number => $column){
                    if($column) {
                        $cols[$colId]++;
                        $rows++;
                    }
                    $colId++;
                }
                if($rows == 5){ $isSolved = true; }
            }
            foreach($cols as $col){
                if($col == 5){ $isSolved = true; }
            }

            if($isSolved){
                return sumOfUnsolved($board);
            }
        }
        return false;
    }

    function sumOfUnsolved($board){
        $total = 0;
        foreach($board as $row){
            foreach($row as $number => $col){
                if(!$col){ $total += $number; }
            }
        }
        return $total;
    }
