<?php

    $input = Solver::getInput();
    $input = explode("\r\n", $input);
    $oxygen = $input;
    $co2 = $input;


    function getCommon(array $array, int $offset, bool $most = true)
    {
        $common = [0 => 0, 1 => 0];
        foreach ($array as $entry) {
            $common[substr($entry, $offset, 1)]++;
        }

        if ($most) {
            return $common[0] > $common[1] ? 0 : 1;
        } else {
            return $common[0] <= $common[1] ? 0 : 1;
        }
    }


    for ($offset = 0; $offset < strlen($input[0]); $offset++) {
        if (count($oxygen) > 1) {
            $mostCommon = getCommon($oxygen, $offset, true);
            foreach ($oxygen as $key => $rate) {
                if (substr($rate, $offset, 1) != $mostCommon) {
                    unset($oxygen[$key]);
                }
            }
        }

        if (count($co2) > 1) {
            $leastCommon = getCommon($co2, $offset, false);
            foreach ($co2 as $key => $rate) {
                if (substr($rate, $offset, 1) != $leastCommon) {
                    unset($co2[$key]);
                }
            }
        }
    }

    $oxygen = array_shift($oxygen);
    $co2 = array_shift($co2);

    $co2 = bindec($co2);
    $oxygen = bindec($oxygen);
    Solver::setResult($co2 * $oxygen);
