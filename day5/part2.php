<?php

    $input = Solver::getInput();

    $lineCoords = [];

    foreach (explode("\r\n", $input) as $row) {
        $coords = explode(' -> ', $row);
        $lineCoords[] = [
            explode(',', $coords[0]),
            explode(',', $coords[1]),
        ];
    }

    $plot = createEmptyPlot($lineCoords);

    foreach($lineCoords as $coord){
        drawLineOnPlot($coord, $plot);
    }


    //drawPlot($plot);
    //echo 'maxOverlaps: '.calculateMaxOverlaps($plot);
    Solver::setResult(calculateOverlaps($plot));


    function calculateMaxOverlaps($plot){
        $overlaps = 0;
        foreach($plot as $y){
            foreach($y as $x){
                $overlaps = $x > $overlaps ? $x : $overlaps;
            }
        }
        return $overlaps;
    }
    function calculateOverlaps($plot){
        $overlaps = 0;
        foreach($plot as $y){
            foreach($y as $x){
                $overlaps += $x >= 2 ? 1 : 0;
            }
        }
        return $overlaps;
    }

    function drawPlot(array $plot)
    {
        // so unnecessary, yet so cool

        $im = imagecreatetruecolor(count($plot) + 1 , count($plot[0]) +1 );
        $colors = [
            imagecolorallocate($im, 33,33,33),
            imagecolorallocate($im, 42, 61, 42),
            imagecolorallocate($im, 50, 90, 52),
            imagecolorallocate($im, 144, 93, 16),
            imagecolorallocate($im, 160, 53, 46),
            imagecolorallocate($im, 244, 67, 54),
        ];

        foreach($plot as $y => $yC){
            foreach($yC as $x => $count){
                imagefilledrectangle($im, $x+1, $y+1, $x+1, $y+1, $colors[$count]);
            }
        }
        imagepng($im, './plot3.png');
        imagedestroy($im);
    }

    function drawLineOnPlot($coord, &$plot){
        $y1 = $coord[0][0];
        $x1 = $coord[0][1];
        $y2 = $coord[1][0];
        $x2 = $coord[1][1];

        if($y1 == $y2){ // moves on X axis
            $start = $x1 < $x2 ? $x1 : $x2;
            $end = ($x1 + $x2) - $start;
            for($x = $start; $x <= $end; $x++){
                $plot[$y1][$x]++;
            }
        } elseif($x1 == $x2){ // moves on Y axis
            $start = $y1 < $y2 ? $y1 : $y2;
            $end = ($y1 + $y2) - $start;
            for($y = $start; $y <= $end; $y++){
                $plot[$y][$x1]++;
            }
        } else { // diagonal
            $yDirection = ($y1 < $y2) ? 1 : -1;
            $xDirection = ($x1 < $x2) ? 1 : -1;

            for($i = 0; $i <= abs($x1 - $x2); $i++){
                $plot[
                    $y1 + ($i * $yDirection)
                ][
                    $x1 + ($i * $xDirection)
                ]++;
            }
        }
    }


    function createEmptyPlot($coords){
        $maxX = 0;
        $maxY = 0;
        foreach($coords as $coord){
            $maxX = $coord[0][0] > $maxX ? $coord[0][0] : $maxX;
            $maxX = $coord[1][0] > $maxX ? $coord[1][0] : $maxX;
            $maxY = $coord[0][1] > $maxY ? $coord[0][1] : $maxY;
            $maxY = $coord[1][1] > $maxY ? $coord[1][1] : $maxY;
        }
        $plot = array_fill(0,$maxY+1, array_fill(0,$maxX+1,0));
        return $plot;
    }
