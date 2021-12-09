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
        if($coord[0][0] == $coord[1][0] || $coord[0][1] == $coord[1][1]){ // is straight line
            drawLineOnPlot($coord, $plot);
        }
    }


//    drawPlot($plot);
//    echo 'maxOverlaps: '.calculateMaxOverlaps($plot);
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
            imagecolorallocate($im, 76, 175, 80),
           // imagecolorallocate($im, 139, 195, 74),
            //imagecolorallocate($im, 205, 220, 57),
           // imagecolorallocate($im, 255, 235, 59),
            imagecolorallocate($im, 255, 152, 0),
           // imagecolorallocate($im, 245, 124, 0),
            imagecolorallocate($im, 244, 67, 54),
            imagecolorallocate($im, 211, 47, 47),
            imagecolorallocate($im, 183, 28, 28),
        ];

        foreach($plot as $y => $yC){
            foreach($yC as $x => $count){
                imagefilledrectangle($im, $x+1, $y+1, $x+1, $y+1, $colors[$count]);
            }
        }
        imagepng($im, './plot.png');
        imagedestroy($im);
    }

    function drawLineOnPlot($coord, &$plot){
        if($coord[0][0] == $coord[1][0]){ // moves on X axis
            $start = $coord[0][1] < $coord[1][1] ? $coord[0][1] : $coord[1][1];
            $end = ($coord[0][1] + $coord[1][1]) - $start;
            for($x = $start; $x <= $end; $x++){
                $plot[$coord[0][0]][$x]++;
            }
        } elseif($coord[0][1] == $coord[1][1]){ // moves on Y axis
            $start = $coord[0][0] < $coord[1][0] ? $coord[0][0] : $coord[1][0];
            $end = ($coord[0][0] + $coord[1][0]) - $start;
            for($y = $start; $y <= $end; $y++){
                $plot[$y][$coord[0][1]]++;
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
