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

        //User select position
        public function userSelectPosition($selectCoordinateX, $selectCoordinateY, $mode) {
            while(($selectCoordinateX > $mode['range'][0] - 1) || $selectCoordinateX < 0) {
                echo "Invalid Coordinate, X value must between 1~".$mode['range'][0]."\n";
                $selectCoordinateX = readline("Enter Coordinate X:")-1;
            }

            while(($selectCoordinateY > $mode['range'][1] - 1) || $selectCoordinateY < 0) {
                echo "Invalid Coordinate, Y value must between 1~".$mode['range'][1]."\n";
                $selectCoordinateY = readline("Enter Coordinate Y:")-1;
            }

            $selectCoordinate = "$selectCoordinateX,$selectCoordinateY";

            return $selectCoordinate;
        }

        //
        public function checkNumberOfMines ($selectPosition, $minesPosition) {
            /*if(in_array($selectPosition, $minesPosition)) {
                echo "You Died"."\n";
                return;
            }*/
            while(!in_array($selectPosition, $minesPosition)) {

                $numberOfMines = 0;
                foreach ($minesPosition as $coordinates) {
                    $coordinatesX = explode(",", $coordinates)[0];
                    $coordinatesY = explode(",", $coordinates)[1];
                    $squareOfDistance = pow($selectCoordinateX - $coordinatesX, 2) + pow($selectCoordinateY - $coordinatesY, 2);
                    if ($squareOfDistance == 2 || $squareOfDistance == 1) {
                        $numberOfMines++;
                    }
                }
            }

            echo "You Died!!";
        }
    }