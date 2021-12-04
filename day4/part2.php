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

    foreach($instructions as $inr => $instruction){
        for($b = 0; $b < count($boards); $b++) {
            for ($r = 0; $r < 5; $r++) {
                if(isset($boards[$b][$r][$instruction])){
                    $boards[$b][$r][$instruction] = true;
                }
            }
        }
        $solvedBoards = checkForSolve($boards);
        if($solvedBoards !== false){
            if(count($boards) > 1){
                foreach($solvedBoards as $solvedBoardId) {
                    unset($boards[$solvedBoardId]);
                }
                sort($boards);
            } else {
                echo 'score: '.(sumOfUnsolved($boards[$solvedBoards[0]]) * $instruction)."\r\n";
                die();
            }
        }
    }




    function checkForSolve($boards): array|bool
    {
        $solvedBoards = [];
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
                $solvedBoards[] = $boardId;
            }
        }
        return count($solvedBoards) == 0 ? false : $solvedBoards;
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
