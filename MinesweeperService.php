<?php
    class MinesweeperService {
        public $mines = 0;
        public $minesCoordinate = array();

        //Decide where mines position
        public function decideMinesCoordinate($mines, $minesCoordinate, $mode) {
            /*while($mines < $mode['mines']) {
                $minesLocationX = mt_rand(0, $mode['range'][0] - 1);
                $minesLocationY = mt_rand(0, $mode['range'][1] - 1);

                if(empty($minesLocation[$minesLocationX][$minesLocationY])) {
                    $minesLocation[$minesLocationX][$minesLocationY] = 1;
                    echo $minesLocation[$minesLocationX][$minesLocationY];
                }

                $mines++;
            };*/

            while($mines < $mode['mines']) {
                $minesCoordinateX = mt_rand(0, $mode['range'][0] - 1);
                $minesCoordinateY = mt_rand(0, $mode['range'][1] - 1);
                $minesTemporaryCoordinate = "$minesCoordinateX,$minesCoordinateY";

                if(!in_array($minesTemporaryCoordinate, $minesCoordinate)) {
                    $minesCoordinate[] = $minesTemporaryCoordinate;
                    $mines++;
                }
            }
            return $minesCoordinate;
        }

    }