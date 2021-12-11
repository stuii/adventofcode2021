<?php

    $input = Solver::getInput();

    $dumbos = [];

    foreach (explode("\r\n", $input) as $rowId => $row) {
        foreach (str_split($row) as $colId => $col) {
            $dumbos[$rowId][$colId] = (int)$col;
        }
    }

    $totalFlashes = 0;
    $step = 0;

    while(!isSynced($dumbos)){
        foreach ($dumbos as $rowId => $row) {
            foreach ($row as $colId => $col) {
                $dumbos[$rowId][$colId]++;
            }
        }

        foreach ($dumbos as $rowId => $row) {
            foreach ($row as $colId => $col) {
                if($dumbos[$rowId][$colId] > 9) {
                    flashDumbo($dumbos, $rowId, $colId);
                }
            }
        }


        foreach ($dumbos as $rowId => $row) {
            foreach ($row as $colId => $col) {
                if($dumbos[$rowId][$colId] > 9){
                    $dumbos[$rowId][$colId] = false;
                    $totalFlashes++;
                }
            }
        }

        foreach ($dumbos as $rowId => $row) {
            foreach ($row as $colId => $col) {
                if($col === false){
                    $dumbos[$rowId][$colId] = 0;
                    $totalFlashes++;
                }
            }
        }
        $step++;
    }


    Solver::setResult($step);

    function flashDumbo(array &$dumbos, $rowId, $colId)
    {
        $dumbos[$rowId][$colId] = false;
        foreach ([[-1, -1], [-1, 0], [-1, 1], [0, -1], [0, 1], [1, -1], [1, 0], [1, 1]] as $modifier) {
            if (isset($dumbos[$rowId + $modifier[0]][$colId + $modifier[1]])) {
                if ($dumbos[$rowId + $modifier[0]][$colId + $modifier[1]] !== false) {
                    $dumbos[$rowId + $modifier[0]][$colId + $modifier[1]]++;
                    if($dumbos[$rowId + $modifier[0]][$colId + $modifier[1]] > 9){
                        flashDumbo($dumbos,$rowId + $modifier[0],$colId + $modifier[1]);
                    }
                }
            }
        }
    }

    function isSynced(array $dumbos)
    {
        foreach ($dumbos as $rowId => $row) {
            foreach ($row as $colId => $col) {
                if($col != 0){ return false; }
            }
        }
        return true;
    }
